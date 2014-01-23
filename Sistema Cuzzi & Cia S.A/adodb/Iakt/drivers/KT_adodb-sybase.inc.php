<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.
class KT_ADODB_sybase extends ADODB_sybase {

	function ErrorMsg(){
		if (!function_exists('sybase_connect')){
				return 'Your PHP doesn\'t contain the Sybase connection module!';
		}
		return parent::ErrorMsg();	
	}
}

class kt_adorecordset_sybase extends ADORecordset_sybase{
	
}
?>
