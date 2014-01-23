<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.
class KT_ADODB_oracle extends ADODB_oracle {

	function ErrorMsg(){
		if (!function_exists('ora_plogon')){
					return 'Your PHP doesn\'t contain the Oracle connection module!';
		}
		return parent::ErrorMsg(); 
	}	
	
		
}
?>
