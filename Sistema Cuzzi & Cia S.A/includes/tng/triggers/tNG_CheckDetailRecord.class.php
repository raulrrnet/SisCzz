<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/
/**
 * This the CheckDetailRecord trigger; extends the tNG_CheckTableField class;
 * Checks if exists a master record; it is used inside of a trigger registered to a transaction.
 * @access public
 */
	class tNG_CheckDetailRecord extends tNG_CheckTableField {
		
	  /**
	  * Constructor. Sets the reference to the transaction in which the trigger is used.
	  * @param object tNG &$tNG reference to transaction object
	  * @access public
	  */
		function tNG_CheckDetailRecord(&$tNG) {
			parent::tNG_CheckTableField($tNG);
		}
		
		/**
	  * execute method of the class; check if detail record exists and return null or error;
	  * @param none
		* @return mix null or error object if records exists;
	  * @access public
	  */
		function Execute() {
			$this->setFieldType($this->tNG->getColumnType($this->tNG->getPrimaryKey()));
			$this->setFieldValue($this->tNG->getPrimaryKeyValue());
			$this->errorIfExists(true);
			$err = parent::Execute();
			if ($err != NULL) {
				// change the default error message
				$useSavedData = false;
				if (in_array($this->tNG->transactionType, array('_delete', '_multipleDelete'))) {
					$useSavedData = true;
				}				
				$this->errorMsg = KT_DynamicData($this->errorMsg, $this->tNG, '', $useSavedData);
				
				// set only user message
				$err = new tNG_error('TRIGGER_MESSAGE__CHECK_DETAIL_RECORD', array(), array());
				$err->addDetails('%s', array($this->errorMsg), array(''));				
			}
			return $err;
		}
	}

?>