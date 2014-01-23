<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.
class KT_ADODB_sqlite extends ADODB_sqlite {

	function ErrorMsg(){
		if (!function_exists('sqlite_open')){
					return 'Your PHP doesn\'t contain the SQLite connection module!';
		}
		return parent::ErrorMsg(); 
	}	

	# solving http://phplens.com/lens/lensforum/msgs.php?id=12496
	function _connect($argHostname='', $argUsername='', $argPassword='', $argDatabasename=''){
				if ($argHostname === '' && $argDatabasename !== ''){
					return parent::_connect($argDatabasename, $argUsername, $argPassword, $argDatabasename);
			}
			else return parent::_connect($argHostname, $argUsername, $argPassword, $argDatabasename);
	}

	# solving http://phplens.com/lens/lensforum/msgs.php?id=12496
	function _pconnect($argHostname='', $argUsername='', $argPassword='', $argDatabasename=''){
				if ($argHostname === '' && $argDatabasename !== ''){
					return parent::_pconnect($argDatabasename, $argUsername, $argPassword, $argDatabasename);
			}
			else return parent::_pconnect($argHostname, $argUsername, $argPassword, $argDatabasename);
	}
		
}

class KT_ADORecordset_sqlite extends ADORecordset_sqlite {

} 
?>
