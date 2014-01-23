<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.
class KT_ADODB_firebird extends ADODB_firebird {

	function ErrorMsg(){
		if (!function_exists('ibase_pconnect')){
				return 'Your PHP doesn\'t contain the Interbase-Firebird connection module!';
		}
		return parent::ErrorMsg();
	}
}

/*
	by InterAKT
	extends base class to implement FieldHasChange method
*/
class KT_ADORecordset_firebird extends ADORecordset_firebird {
	var $exfields = false; //copy of the fields

	function MoveFirst() 
	{
		//reset fields
		$this->exfields = false;
		parent::MoveFirst();
	}

	function MoveNext() 
	{
		//save the old fields before moving further
		if (!$this->EOF) {
			$this->exfields = $this->fields;//INTERAKT
		}
		return parent::MoveNext();
	}

	/*
		return the old value of a field
		@param
		$colname - the name of the field
		
		@return
		field value
	*/
	function ExFields($colname){
		if ($this->exfields && isset($this->exfields[$colname])) {
			return $this->exfields[$colname];
		} else {
			return null;
		}
	}
	
	/*
		check if the specific field has changed his value on MoveNext
		@param
			$field - the name of the field that we want to watch for
		@return
			boolean true if the field has changed from the previos value , false otherwise
	*/
	function FieldHasChanged($field){
		if ($this->exfields) {
			return ($this->Fields($field) != $this->ExFields($field));
		} else {
			return true;
		}
	}
} 
?>
