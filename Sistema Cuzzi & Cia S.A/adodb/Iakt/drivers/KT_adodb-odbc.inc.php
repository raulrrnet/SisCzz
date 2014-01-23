<?php
// Copyright 2001-2003 Interakt Online. All rights reserved.

class KT_ADODB_odbc extends ADODB_odbc{
			
			var $arrayClass='KT_ADORecordSet_array';

			function ErrorMsg(){
					if (!function_exists('odbc_connect')){
							return 'Your PHP doesn\'t contain the ODBC connection module!';
					}
					$error_returned = parent::ErrorMsg();
					// correct #bug http://phplens.com/lens/lensforum/msgs.php?id=12436
					if ($error_returned == ''){
							$error_returned = @odbc_errormsg();
					}
					return $error_returned;
			}
}
/*
	by InterAKT
	extends base class to implement FieldHasChange method
*/
class KT_ADORecordSet_odbc extends ADORecordSet_odbc {
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

class KT_ADORecordSet_array extends ADORecordSet_array{
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
		if (!empty($this->exfields)){
				$curr_fields = $this->fields;
				$this->fields = $this->exfields;
				$value = $this->Fields($colname);
				$this->fields = $curr_fields;
				return $value;
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
			//var_dump($this->exfields);
		if (!empty($this->exfields)){
			return ($this->Fields($field) != $this->ExFields($field));
		} else {
			return true;
		}
	}
}

?>
