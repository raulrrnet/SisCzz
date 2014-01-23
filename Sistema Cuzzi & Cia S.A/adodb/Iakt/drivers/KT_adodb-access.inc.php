<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.
class KT_ADODB_access extends ADODB_access {
	
	var $hasInsertID = true;
	
	function _insertid($table = '', $column = ''){
			$sql = 'SELECT @@IDENTITY AS LastInsertID';
			$rs = $this->Execute($sql) OR die($this->ErrorMsg());
			return $rs->Fields('LastInsertID');
	}
}
?>
