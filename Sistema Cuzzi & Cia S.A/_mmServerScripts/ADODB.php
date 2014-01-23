<?php

define ('STR_START_ERROR', '<ERRORS><ERROR><DESCRIPTION>');
define ('STR_END_ERROR',   '</DESCRIPTION></ERROR></ERRORS>');

define ('SF', '<FIELD>');
define ('EF', '</FIELD>');

define ('SV', '<VALUE>');
define ('EV', '</VALUE>');

define ('SN', '<NAME>');
define ('EN', '</NAME>');
	
function KT_ErrorHandler($errno, $errstr, $errfile, $errline) {
	global $f;
	$errortype = array ( 
		1   =>  'Error', 
		2   =>  'Warning', 
		4   =>  'Parsing Error', 
		8   =>  'Notice', 
		16  =>  'Core Error', 
		32  =>  'Core Warning', 
		64  =>  'Compile Error', 
		128 =>  'Compile Warning', 
		256 =>  'User Error', 
		512 =>  'User Warning', 
		1024=>  'User Notice',
		2047=>  'All', 
		2048=>  'Runtime Notice'
	); 
	$str = sprintf("[%s]\n%s:\t%s\nFile:\t\t'%s'\nLine:\t\t%s\n\n", date('d-m-Y H:i:s'),@$errortype[@$errno], @$errstr,@$errfile,@$errline);
	
	if (error_reporting() != 0) {
			//we will hide the deprecation problems E_STRICT
			if ($errno != 2048){
				@fwrite($f, $str);
			}
			if (@$errno == 2){
				$error = STR_START_ERROR.'An Warning Type error appeared. The error is logged into the log file.'.STR_END_ERROR;
				echo $error;
			}
	}
}
if (!isset($debug_to_file)){
		$debug_to_file = false; 
}
if ($debug_to_file){
		$old_error_handler = set_error_handler('KT_ErrorHandler');
}

if (file_exists('../adodb/adodb.inc.php')){
		require_once('../adodb/adodb.inc.php');
}else{
	if (empty($error)){ $error = ''; }
	$error .= STR_START_ERROR.'Please upload the adodb folder to the testing server.'.STR_END_ERROR;
	if ($debug_to_file){
			@fwrite($f, "\n".$error."\n");
			@fclose($f);
	}
	echo $error;
	die();
}

class ADODBConnection {
	var $isOpen;
	var $hostname;
	var $database;
	var $username;
	var $password;
	var $timeout;
	var $connectionId;
	var $connection;
	var $dbtype;

	function ADODBConnection ($ConnectionString, $Timeout, $Host, $DB, $UID, $Pwd) {
		$this->isOpen = false;
		$this->timeout = $Timeout;
		
		if ($DB) {
			$DBType = preg_replace('/:.*$/', '', $DB);
			$DB = preg_replace('/^.*?:/', '', $DB);
		} else {
			$DBType = '';
		}
		
		if ($Host) { 
			$this->hostname = $Host;
		}
		elseif (ereg('host=([^;]+);', $ConnectionString, $ret)) {
			$this->hostname = $ret[1];
		}
		
		if ($DB) {
			$this->database = $DB;
		} elseif (ereg('db=([^;]+);',$ConnectionString, $ret)){
			//if (preg_match('/db=(([^;]+);?([^tuph][^yiw][^pds])*([^;]*))/', $ConnectionString, $ret)) {
			$this->database = preg_replace('/^.*?:/', '$1', $ret[1]);
		}
		
		if ($UID) {
			$this->username = $UID;
		}
		elseif (ereg('uid=([^;]+);',  $ConnectionString, $ret)) {
			$this->username = $ret[1];
		}
		
		if ($Pwd) {
			$this->password = $Pwd;
		} elseif (ereg('pwd=([^;]+);',  $ConnectionString, $ret)) {
			$this->password = $ret[1];
		}

		if ($DBType) { 
			$this->dbtype = $DBType;
		} elseif (preg_match('/db=(([^;]+);?([^tuph][^yiw][^pds])*([^;]*))/', $ConnectionString, $ret)) {
			$this->dbtype = preg_replace('/:.*$/', '', $ret[1]);
		}

	}

	function Open() {
		ADOLoadCode($this->dbtype);
		ob_start();
		$this->connection= &KTNEWConnection($this->dbtype);//&ADONewConnection($this->dbtype);
		$connectionError = ob_get_contents();
		ob_end_clean();
		//added to support the adodb failures -- cristic
		if (FALSE === $this->connection){
				$error = STR_START_ERROR.'ADOdb driver failed to initialise. </DESCRIPTION></ERROR>';
				$error .= '<ERROR><DESCRIPTION>' . @$connectionError . STR_END_ERROR;
				$this->isOpen = false;
				return $error;			
		}

		if (!$this->database && FALSE !== stristr($this->dbtype, 'postgres')) {
				$this->database = "template1";
		}

		switch ((string)$this->dbtype){
				case 'ado':
				case 'access':
				case 'odbc':
				case 'odbc_mssql':
								$this->connectionId = $this->connection->Connect($this->database, $this->username,$this->password);
								break;
				case 'ibase':
				case 'firebird':
  					   	$this->connectionId = $this->connection->Connect($this->hostname.":".$this->database,$this->username,$this->password);
								break;
				default:
  					   	$this->connectionId = $this->connection->Connect($this->hostname,$this->username,$this->password,$this->database);
								break;						
		}

		if ($this->connectionId) {
			// fix for an ODBC - PHP configuration problem
			$this->GetTables();

			return $this->isOpen = true;
	  } else {
			$connectionError = ob_get_contents();	

			// this error information gets added in test open
			if (is_object($this->connection) && method_exists($this->connection, 'ErrorMsg')){ 
					$error_message = $this->connection->ErrorMsg() ;
			}
			
			if (!isset($error_message) || $error_message == "") {
					$error_message = "Unable to Establish Connection to Host '" . $this->hostname . "', database '".$this->database."' for user '" . $this->username."'" ;
			}
			
			$error  = STR_START_ERROR. $error_message . '</DESCRIPTION></ERROR>';
			$error .= '<ERROR><DESCRIPTION>' . @$connectionError . STR_END_ERROR;
			$this->isOpen = false;

			return $error;
		}	
	}

	function TestOpen() {
			return ($this->isOpen) ? '<TEST status=true></TEST>' : $this->HandleException();
	}

	function Close() {
		if ($this->isOpen) {
			if ($this->connection->Close()) {
				$this->isOpen = false;
				$this->connectionId = false;
			}
		}
	}

	function GetTables() {
		$xmlOutput = "";
		$result = $this->connection->MetaTables('TABLES');
		
		if ($result && is_array($result))
		{
			sort($result);
			reset($result);

			$xmlOutput = '<RESULTSET><FIELDS>';

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= SF.SN.'TABLE_CATALOG'.EN.EF;		// column 0 (zero-based)
			$xmlOutput .= SF.SN.'TABLE_SCHEMA'.EN.EF;		// column 1
			$xmlOutput .= SF.SN.'TABLE_NAME'.EN.EF;		// column 2

			$xmlOutput .= '</FIELDS><ROWS>';

			$tableCount = 0;
			if (is_array($result)){
					$tableCount = sizeof($result);
			}
			
			// patch for odbc when a configuration PHP create problems.
			$str_result = implode('|', $result);
			if (false !== stristr($str_result, 'ssql')){
					if (function_exists('ini_get') && function_exists('ini_set') && @ini_get('odbc.defaultlrl') == 0){
						$patch = true;
						foreach($result as $cheie=>$valoare){
								if (false === stristr($valoare, 'ssql')){
										$patch = false;
								}
						}
						if ($patch === true){
								ini_set('odbc.defaultlrl', 65535);
								$result = $this->connection->MetaTables('TABLES');	
								$tableCount = sizeof($result);
						}
					}
			}

			for ($i=0; $i < $tableCount; $i++)
			{
				$xmlOutput .= '<ROW><VALUE/><VALUE/>'.SV;
				$xmlOutput .= $result[$i];
				$xmlOutput .= EV.'</ROW>';
			}

			$xmlOutput .= '</ROWS></RESULTSET>';
		}else{
			$xmlOutput = '<RESULTSET><FIELDS>';
			$xmlOutput .= '</FIELDS><ROWS>';
			$xmlOutput .= '</ROWS></RESULTSET>';		
		}

		return $xmlOutput;
	}

	function GetViews()
	{
		$xmlOutput = '';
		$result = $this->connection->MetaTables('VIEWS');


		if ($result && is_array($result))
		{
			sort($result);
			reset($result);

			$xmlOutput = '<RESULTSET><FIELDS>';

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= SF.SN.'TABLE_CATALOG'.EN.EF;		// column 0 (zero-based)
			$xmlOutput .= SF.SN.'TABLE_SCHEMA'.EN.EF;		// column 1
			$xmlOutput .= SF.SN.'TABLE_NAME'.EN.EF;		// column 2

			$xmlOutput .= '</FIELDS><ROWS>';
			$tableCount = 0;
			if (is_array($result)){
					$tableCount = sizeof($result);
			}

			for ($i=0; $i < $tableCount; $i++)
			{
				$xmlOutput .= '<ROW><VALUE/><VALUE/>'.SV;
				$xmlOutput .= $result[$i];
				$xmlOutput .= EV.'</ROW>';
			}

			$xmlOutput .= '</ROWS></RESULTSET>';
		}else{
			//somthing wrong happen and the result is crashed
			$xmlOutput = '<RESULTSET><FIELDS>';
			$xmlOutput .= '</FIELDS><ROWS>';
			$xmlOutput .= '</ROWS></RESULTSET>';	
		}

		return $xmlOutput;
	}

	function GetProcedures()
	{
		
		if (method_exists($this->connection, 'getProcedureList') && false){
			$result = $this->connection->getProcedureList('public');
		}else{
			return '<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>';	
		}

		$xmlOutput = '';

		if ($result)
		{
			$xmlOutput = '<RESULTSET><FIELDS>';

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= SF.SN.'PROCEDURE_CATALOG'.EN.EF;		// column 0 (zero-based)
			$xmlOutput .= SF.SN.'PROCEDURE_SCHEMA'.EN.EF;		// column 1
			$xmlOutput .= SF.SN.'PROCEDURE_NAME'.EN.EF;		// column 2
			$xmlOutput .= SF.SN.'PROCEDURE_TYPE'.EN.EF;		// column 3
			$xmlOutput .= SF.SN.'PROCEDURE_DEFINITION'.EN.EF;		// column 4
			$xmlOutput .= SF.SN.'DESCRIPTION'.EN.EF;		// column 5
			$xmlOutput .= SF.SN.'DATE_CREATED'.EN.EF;		// column 6
			$xmlOutput .= SF.SN.'DATE_MODIFIED'.EN.EF;		// column 7

			$xmlOutput .= '</FIELDS><ROWS>';
			$tableCount = sizeof($result);
			if (is_array($result)){
					foreach($result as $key=>$value)
					{
								$xmlOutput .= '<ROW>';
								$xmlOutput .= SV.@$value['procedure_catalog'].EV;
								$xmlOutput .= SV.@$value['procedure_schema'].EV;
								$xmlOutput .= SV.@$value['procedure_name'].EV;
								$xmlOutput .= SV.@$value['procedure_type'].EV;
								$xmlOutput .= SV.@$value['procedure_definition'].EV;
								$xmlOutput .= SV.@$value['procedure_description'].EV;
								$xmlOutput .= SV.@$value['procedure_date_created'].EV;
								$xmlOutput .= SV.@$value['procedure_date_modified'].EV;
								$xmlOutput .= '</ROW>';
	  			}
			}
			$xmlOutput .= '</ROWS></RESULTSET>';
		}else{
			return '<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>';	
                }

		return $xmlOutput;
	}

	function GetColumnsOfTable($TableName)
	{
		if (function_exists('utf8_decode')){
				$TableName = utf8_decode($TableName);
		}
		$xmlOutput = '';
		$result = $this->connection->MetaColumns($TableName);

		if (!$result) {
			if (is_object($this->connection) && method_exists($this->connection, 'ErrorMsg')){ 
				$errStr = $this->connection->ErrorMsg();
			}
			if (@$errStr == '') {
				$errStr = 'Unable to retrive column information of table ' . $TableName;
			}
			$error  = STR_START_ERROR . $errStr . STR_END_ERROR;
			return $error;
		} else {
			$xmlOutput = '<RESULTSET><FIELDS>';

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= SF.SN.'TABLE_CATALOG'.EN.EF;		// column 0 (zero-based)
			$xmlOutput .= SF.SN.'TABLE_SCHEMA'.EN.EF;		// column 1
			$xmlOutput .= SF.SN.'TABLE_NAME'.EN.EF;			// column 2
			$xmlOutput .= SF.SN.'COLUMN_NAME'.EN.EF;
			$xmlOutput .= SF.SN.'DATA_TYPE'.EN.EF;
			$xmlOutput .= SF.SN.'IS_NULLABLE'.EN.EF;
			$xmlOutput .= SF.SN.'COLUMN_SIZE'.EN.EF;

			$xmlOutput .= '</FIELDS><ROWS>';

			// The fields returned from DESCRIBE are: Field, Type, Null, Key, Default, Extra
			if (is_array($result)){
				//sort($result);
				reset($result);
				foreach($result as $field=>$row){
					$xmlOutput .= '<ROW><VALUE/><VALUE/><VALUE/>';

					if (preg_match('/^(.+)\((\d+)\)/', $row->type, $ret))
					{
						$row->type = $ret[1];
						$row->max_length = $ret[2];
					}
					
					if($row->max_length == -1){
						$row->max_length = '';
					}
					$xmlOutput .= SV;
					if (function_exists('utf8_encode')){
							$xmlOutput .= utf8_encode($row->name);
					}else{
							$xmlOutput .= $row->name;
					}
					$xmlOutput .= EV;
					$xmlOutput .= SV . $row->type                    .EV;
					$xmlOutput .= SV . (!empty($row->not_null) || $row->not_null === true?'NO':'YES') .EV;
					$xmlOutput .= SV . $row->max_length         		 .EV.'</ROW>';
				}
			}
			$xmlOutput .= '</ROWS></RESULTSET>';
		}

		return $xmlOutput;
	}

	function GetParametersOfProcedure($ProcedureName, $SchemaName, $CatalogName)
	{				$result = "";

					if (method_exists($this->connection, 'getProcedureParameters') && false){
							$result = $this->connection->getProcedureParameters($ProcedureName, 'public');
					}else{
								return '<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>';	
					}
					$xmlOutput = '<RESULTSET><FIELDS>';
					$xmlOutput .= SF.SN.'PROCEDURE_CATALOG'     .EN.EF;
					$xmlOutput .= SF.SN.'PROCEDURE_SCHEMA'			.EN.EF;
					$xmlOutput .= SF.SN.'PROCEDURE_NAME'				.EN.EF;
					$xmlOutput .= SF.SN.'PARAMETER_NAME'				.EN.EF;
					$xmlOutput .= SF.SN.'ORDINAL_POSITION'			.EN.EF;
					$xmlOutput .= SF.SN.'PARAMETER_TYPE'				.EN.EF;
					$xmlOutput .= SF.SN.'PARAMETER_HASDEFAULT'	.EN.EF;
					$xmlOutput .= SF.SN.'PARAMETER_DEFAULT'			.EN.EF;
					$xmlOutput .= SF.SN.'IS_NULLABLE'						.EN.EF;
					$xmlOutput .= SF.SN.'DATA_TYPE'							.EN.EF;
					$xmlOutput .= SF.SN.'CHARACTER_MAXIMUM_LENGTH'.EN.EF;
					$xmlOutput .= SF.SN.'CHARACTER_OCTET_LENGTH'.EN.EF;
					$xmlOutput .= SF.SN.'NUMERIC_PRECISION'			.EN.EF;
					$xmlOutput .= SF.SN.'NUMERIC_SCALE'					.EN.EF;
					$xmlOutput .= SF.SN.'DESCRIPTION'						.EN.EF;
					$xmlOutput .= SF.SN.'TYPE_NAME'							.EN.EF;
					$xmlOutput .= SF.SN.'LOCAL_TYPE_NAME'				.EN.EF;
					$xmlOutput .= SF.SN.'SS_DATA_TYPE'					.EN.EF;
					$xmlOutput .= '</FIELDS><ROWS>';

					if (is_array($result)){
							foreach($result as $key=>$value){
											$xmlOutput .= '<ROW>';
											$xmlOutput .= SV.@$value['procedure_catalog'].EV;
											$xmlOutput .= SV.@$value['procedure_schema'].EV;
											$xmlOutput .= SV.@$value['procedure_name'].EV;
											$xmlOutput .= SV.@$value['parameter_name'].EV;
											$xmlOutput .= SV.@$value['ordinal_position'].EV;
											$xmlOutput .= SV.@$value['parameter_type'].EV;
											$xmlOutput .= SV.@$value['parameter_hasdefault'].EV;
											$xmlOutput .= SV.@$value['parameter_default'].EV;
											$xmlOutput .= SV.@$value['is_nullable'].EV;
											$xmlOutput .= SV.@$value['data_type'].EV;
											$xmlOutput .= SV.@$value['character_maximum_length'].EV;
											$xmlOutput .= SV.@$value['character_octet_legth'].EV;
											$xmlOutput .= SV.@$value['numeric_precision'].EV;
											$xmlOutput .= SV.@$value['numeric_scale'].EV;
											$xmlOutput .= SV.@$value['description'].EV;
											$xmlOutput .= SV.@$value['type_name'].EV;
											$xmlOutput .= SV.@$value['local_type_name'].EV;
											$xmlOutput .= SV.@$value['ss_data_type'].EV;
											$xmlOutput .= '</ROW>';
							}					
					}
					$xmlOutput .= '</ROWS></RESULTSET>';
					return $xmlOutput;
		// not supported
	}

	function ExecuteSQL($aStatement, $MaxRows)
	{
		if ( get_magic_quotes_gpc() )
		{
			$aStatement = stripslashes( $aStatement ) ;
		}
				
		$xmlOutput = "";
		$result = $this->connection->SelectLimit($aStatement,$MaxRows);
		if (!$result) {
			$result = $this->connection->Execute($aStatement);
		}
		if (!$result) {
			if (is_object($this->connection) && method_exists($this->connection, 'ErrorMsg')){ 
			$errorMsg = $this->connection->ErrorMsg();
			}
			if (@$errorMsg == '') {
				$errorMsg = 'Error executing query: ' . $aStatement;
			}
			$error  = STR_START_ERROR . $errorMsg . STR_END_ERROR;
			return $error;
		} else {
			$xmlOutput = '<RESULTSET><FIELDS>';

			$fieldCount = $result->FieldCount();
			for ($i=0; $i < $fieldCount; $i++)
			{
				$meta = $result->FetchField($i);
				if ($meta)
				{
					$xmlOutput .= '<FIELD';
					$xmlOutput .= ' type="'			    . @$meta->type;
					$xmlOutput .= '" max_length="'	. @$meta->max_length;
					$xmlOutput .= '" table="'			  . @$meta->table;
					$xmlOutput .= '" not_null="'		. @$meta->not_null;
					$xmlOutput .= '" numeric="'		  . @$meta->numeric;
					$xmlOutput .= '" unsigned="'		. @$meta->unsigned;
					$xmlOutput .= '" zerofill="'		. @$meta->zerofill;
					$xmlOutput .= '" primary_key="'	. @$meta->primary_key;
					$xmlOutput .= '" multiple_key="'. @$meta->multiple_key;
					$xmlOutput .= '" unique_key="'	. @$meta->unique_key;
					$xmlOutput .= '"><NAME>'			  . $meta->name;
					$xmlOutput .= '</NAME>'.EF;
				}
			}

			$xmlOutput .= '</FIELDS><ROWS>';

			if ($fieldCount > 0){
					$result->MoveFirst();
			}
			while(!$result->EOF)
			{
				$xmlOutput .= '<ROW>';

				for ($i=0; $i<$fieldCount; $i++)
				{
					$xmlOutput .= '<VALUE>';
					$xmlOutput .= htmlspecialchars($result->fields[$i]);
					$xmlOutput .= '</VALUE>';
				}

 				$xmlOutput .= '</ROW>';
 				$result->MoveNext();
			}

			$result->Close();

			$xmlOutput .= '</ROWS></RESULTSET>';
		}
				
		return $xmlOutput;
	}

	function GetProviderTypes()
	{
		// not supported?
		return '<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>';
	}

	function ExecuteSP($aProcStatement, $TimeOut, $Parameters)
	{
		// not supported
		return '<RESULTSET><FIELDS></FIELDS><ROWS></ROWS></RESULTSET>';
	}

	function ReturnsResultSet($ProcedureName)
	{
		// not supported
		return '<RETURNSRESULTSET status=false></RETURNSRESULTSET>';
	}

	function SupportsProcedure()
	{	
		return '<SUPPORTSPROCEDURE status='.((method_exists($this->connection, 'getProcedureList') && false)?'true':'false').'></SUPPORTSPROCEDURE>';
	}

	function HandleException()
	{
		if (is_object($this->connection) && method_exists($this->connection, 'ErrorMsg')){ 
		$errorMsg = $this->connection->ErrorMsg();
		}
		if ($errorMsg == '') {
			$errorMsg = 'Unable to establish connection to the server!';
		}
		return STR_START_ERROR. $errorMsg . STR_END_ERROR;
	}

	function GetDatabaseList()
	{
		$xmlOutput = '<RESULTSET><FIELDS><FIELD><NAME>NAME</NAME></FIELD></FIELDS><ROWS>';
		$dbList = $this->connection->MetaDatabases();
		
		if (isset($dbList) && is_array($dbList)){
			foreach ($dbList as $key=>$value){
					$xmlOutput .= '<ROW><VALUE>' . $value . '</VALUE></ROW>';
			}
		}

		$xmlOutput .= '</ROWS></RESULTSET>';

		return $xmlOutput;
	}

	function GetPrimaryKeysOfTable($TableName)
	{
		$xmlOutput = '';
		$result = $this->connection->MetaColumns($TableName);
		if (!$result || !is_array($result)) {
			if (is_object($this->connection) && method_exists($this->connection, 'ErrorMsg')){ 
					$errorMsg = $this->connection->ErrorMsg();
			}
			if (@$errorMsg == '') {
				$errorMsg = 'Unable to get primary key of table ' . $TableName;
			}
			return STR_START_ERROR. $errorMsg . STR_END_ERROR;
		} else {
			$xmlOutput = '<RESULTSET><FIELDS>';

			// Columns are referenced by index, so Schema and
			// Catalog must be specified even though they are not supported
			$xmlOutput .= SF.SN.'TABLE_CATALOG' .EN.EF;		// column 0 (zero-based)
			$xmlOutput .= SF.SN.'TABLE_SCHEMA'	.EN.EF;		// column 1
			$xmlOutput .= SF.SN.'TABLE_NAME'		.EN.EF;			// column 2
			$xmlOutput .= SF.SN.'COLUMN_NAME'		.EN.EF;
			$xmlOutput .= SF.SN.'DATA_TYPE'			.EN.EF;
			$xmlOutput .= SF.SN.'IS_NULLABLE'		.EN.EF;
			$xmlOutput .= SF.SN.'COLUMN_SIZE'		.EN.EF;
			$xmlOutput .= '</FIELDS><ROWS>';

			// The fields returned from DESCRIBE are: Field, Type, Null, Key, Default, Extra
			foreach ($result as $field=>$row)
			{
			  if (isset($row->primary_key) && $row->primary_key){
  				$xmlOutput .= '<ROW><VALUE/><VALUE/><VALUE/>';
  
				if (preg_match('/^(.+)\((\d+)\)/', $row->type, $ret))
				{
					 $row->type = $ret[1];
					 $row->max_length = $ret[2];
				}

				if($row->max_length == -1){
					$row->max_length = '';
				}

				$xmlOutput .= SV . $field 												. EV;
				$xmlOutput .= SV . $row->type                    	. EV;
				$xmlOutput .= SV . (($row->not_null)?'NO':'YES') 	. EV;
				$xmlOutput .= SV . $row->max_length         		  . EV.'</ROW>';
  			  }
			}

			$xmlOutput .= '</ROWS></RESULTSET>';
		}
		return $xmlOutput;
	}

}	// class ADODBConnection
?>
