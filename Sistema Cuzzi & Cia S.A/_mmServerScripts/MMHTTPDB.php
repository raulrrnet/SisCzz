<?php
$debug_to_file = false;
// security check
// $allowed_ips = array("192.168.0.75", "192.168.0.1");
$allowed_ips = array();
if (count($allowed_ips)>0 && isset($_SERVER["REMOTE_ADDR"])){
		   if (!in_array($_SERVER["REMOTE_ADDR"], $allowed_ips)) {
				 	 $error_string = "<ERRORS><ERROR><DESCRIPTION>You are not allowed to use this connection gateway. You should change the Connection parameters to add your IP or the Proxy server IP to the list.</DESCRIPTION></ERROR></ERRORS>";
				   die($error_string);
			 }
}

//remove the escaping from the given attributes 
if (get_magic_quotes_gpc() > 0){
	foreach($_POST as $k=>$v){
			$_POST[$k]=stripslashes($_POST[$k]);
	}
}

if(false && extension_loaded("mbstring"))
{
	$acceptCharsetHeader = "Accept-Charset: " . mb_internal_encoding();
	header( $acceptCharsetHeader );
	$head = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=" . mb_http_output() . "></head>";
	echo( $head );
}else{
	$head = "<html><head></head>";
	echo( $head );
}

if ($debug_to_file){
		@ini_set('display_errors', 0);
		@ini_set('error_log', 'php_errors.log');
		@ini_set('log_errors', 1);
		@error_reporting(E_ALL);
		$f = @fopen("log.txt", "a");
		@fwrite($f, "\n--------------------------------\n");
		foreach($_POST as $key=>$value) {
				@fwrite($f, "\$_POST[\"".$key."\"] = \"".$value."\";\n");
		}
		if (isset($_POST['opCode']) && $_POST['opCode'] == "IsOpen" ){
			@fwrite($f, "\nPHP-Version: ".phpversion()."\n");
			@fwrite($f, "PHP-OS: ".PHP_OS."\n");
			@fwrite($f, "PHP-SAPI-NAME: ".php_sapi_name()."\n");
			@fwrite($f, "PHP-Extensions: ".var_export(get_loaded_extensions(),true)."\n");
			@fwrite($f, "PHP-lib-expat: ".(function_exists("utf8_decode")?"Found":"NOT FOUND")."\n");
		}
}


if (isset($_POST['Type']) && $_POST['Type'] == "ADODB") {
	require("ADODB.php");
	$oConn = new ADODBConnection($_POST['ConnectionString'], @$_POST['Timeout'], @$_POST['Host'], @$_POST['Database'], @$_POST['UserName'], @$_POST['Password']);
}else{
	$error ="<ERRORS><ERROR><DESCRIPTION>";
	$error.="The files from the _mmServerScripts folder are for the server model PHP-ADODB. You try to connect to a database using a a different server model ".@$_POST['Type'].".\n\nPlease remove this folder outside the Dreamweaver environment on both local and testing machines and try again.";
	$error.="</DESCRIPTION></ERROR></ERRORS>";
	if ($debug_to_file){
		@fwrite($f,"Error: ".$error);
	}
	echo $error;
	return;
}

if ($debug_to_file){
		@fwrite($f, "Connection Object: ".((isset($oConn) && $oConn)?"ADODB Connection":"Failed")."\n");
}

// Process opCode
if (isset($oConn) && $oConn) {
	ob_start();
	$answer = $oConn->Open();
	$errors[] = ob_get_contents();
	ob_end_clean();
	if ($oConn->isOpen && isset($_POST['opCode']) && $_POST['opCode'] == "IsOpen" && $answer == true) {
			$answer = $oConn->TestOpen();
	} elseif ($oConn->connectionId && $oConn->isOpen) {
				ob_start();
				switch ($_POST['opCode']===0 ? "":$_POST['opCode']){
							case "GetTables": $answer = $oConn->GetTables();
											break;
							case "GetColsOfTable": $answer = $oConn->GetColumnsOfTable($_POST['TableName']);
											break;
							case "ExecuteSQL": $answer = $oConn->ExecuteSQL($_POST['SQL'], $_POST['MaxRows']);
											break;
							case "GetODBCDSNs": $answer = $oConn->GetDatabaseList();
											break;
							case "SupportsProcedure": $answer = $oConn->SupportsProcedure();
											break;
							case "GetProviderTypes": $answer = $oConn->GetProviderTypes();
											break;
							case "GetViews": $answer = $oConn->GetViews();
											break;
							case "GetProcedures": $answer = $oConn->GetProcedures();
											break;
							case "GetParametersOfProcedure": $answer = $oConn->GetParametersOfProcedure($_POST['ProcName'], @$_POST['Schema'], @$_POST['Catalog']);
											break;
							case "ReturnsResultset": $answer = $oConn->ReturnsResultSet($_POST['RRProcName']);
											break;
							case "ExecuteSP": $answer = $oConn->ExecuteSP($_POST['ExecProcName'], 0, $_POST['ExecProcParameters']);
											break;
							case "GetKeysOfTable": $answer = $oConn->GetPrimaryKeysOfTable($_POST['TableName']);
											break;
							default: $answer = "<ERRORS>\n<ERROR><DESCRIPTION>The '".$_POST['opCode']."' command is not supported by the PHP-ADOdb.</DESCRIPTION></ERROR>\n</ERRORS>";
											break;
				}
				$errors[] = ob_get_contents();
				ob_end_clean();
	}
	if ($debug_to_file && $errors){
				@fwrite($f, "\nPHP Errors:\n".var_export($errors,true)."\n");
	}
	echo @$answer;

	if ($debug_to_file){
	 //		The following lines are for debug purpose only
					@fwrite($f, "\nAnswer From The Database:\n\n\t".@$answer."\n\n\n");
					@fclose($f);
	}
	$oConn->Close();
}else{
	if ($debug_to_file){
	 //		The following lines are for debug purpose only
					@fwrite($f, "\n oConn was not initialized properly for unknown reason;\n\n\n");
					@fclose($f);
	}
	echo "<ERRORS>\n<ERROR><DESCRIPTION>The Connection was not initialized properly for unknown reason</DESCRIPTION></ERROR>\n</ERRORS>";
}

echo( "</html>" );
?>
