<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.

//Added by Interakt
//New Connection class
//this will implement FieldHasChange for 

global $ADODB_NEWCONNECTION;
$ADODB_NEWCONNECTION = 'KTNEWConnection';

function &KTNEWConnection($db='') {
	GLOBAL $ADODB_LASTDB;
	if (!defined('ADODB_ASSOC_CASE')){
			define('ADODB_ASSOC_CASE',2);
	}
	$errorfn = (defined('ADODB_ERROR_HANDLER')) ? ADODB_ERROR_HANDLER : false;
	$rez = true;
	if ($db) {
		if ($ADODB_LASTDB != $db){
				ADOLoadCode($db);
		}
	} else { 
		if (!empty($ADODB_LASTDB)) {
			ADOLoadCode($ADODB_LASTDB);
		} else {
			 $rez = false;
		}
	}
	
	if (!$rez) {
		 if ($errorfn) {
			// raise an error
			$errorfn('ADONewConnection', 'ADONewConnection', -998,
					 "Could not load the database driver for $db",
					 $dbtype);
		} else{
			 ADOConnection::outp( "<p>ADONewConnection: Unable to load database driver for '$db'</p>",false);
		}
		return false;
	}
	
	
	$cls = 'ADODB_'.$ADODB_LASTDB;

	if (file_exists(ADODB_DIR.'/Iakt/drivers/KT_adodb-'.$ADODB_LASTDB.'.inc.php') && is_readable(ADODB_DIR.'/Iakt/drivers/KT_adodb-'.$ADODB_LASTDB.'.inc.php')){
			require_once(ADODB_DIR.'/Iakt/drivers/KT_adodb-'.$ADODB_LASTDB.'.inc.php');
			if (class_exists('KT_'.$cls))	{
					$cls = 'KT_' . $cls;
			}
	}
	
	$obj = & new $cls();
	
	if (class_exists('KT_ADORecordSet_'.$ADODB_LASTDB)){
			$obj->rsPrefix = 'KT_ADORecordSet_';
	}
	
	if ($errorfn){
              $obj->raiseErrorFn = $errorfn;
	}
	
	return $obj;
}

	/*
	NAME:
		unescapeQuotes
	DESCRIPTION:
		if the magic_quotes_runtime are on unescape the text
		ADDED BY IAKT!
	PARAMETERS:
		$text - string - escaped string
	RETURN:
		string - unescaped string
	*/
	function unescapeQuotes($text) {
		if (get_magic_quotes_runtime()) {
			return stripslashes($text);
		} else {
			return $text;
		}
	}
?>
