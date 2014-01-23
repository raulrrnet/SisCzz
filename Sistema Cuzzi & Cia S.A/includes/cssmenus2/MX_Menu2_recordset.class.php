<?php
/**
 * The Recordset class
 */
class MX_Menu2_recordset {

	/**
	 * The Recordset resource
	 * @var object MySQL ResourceID
	 * @access private
	 */
	var $resource;

	/**
	 * The returned fields
	 * @var array
	 * @access public
	 */
	var $fields;

	/**
	 * Are we at the end of the record?
	 * @var boolean
	 * @access public
	 */
	var $EOF;

	/**
	 * The constructor
	 * @param object ResourceID &$resource - the recordset resource id
	 * @access public
	 */
	function MX_Menu2_recordset(&$resource) {
		if (!is_resource($resource)){
				die('The MX Menu 2 Recordset require a MySQL resource');
		}
		$this->resource = &$resource;
		if (mysql_num_rows($this->resource) > 0) {
				mysql_data_seek($this->resource, 0);
		}
		$this->fields = mysql_fetch_assoc($this->resource);
		$this->EOF = ($this->fields)?false:true;
	}

	/**
	 * Gets the record count
	 * @return integer
	 * @access public
	 */
	function RecordCount() {
		return mysql_num_rows($this->resource);
	}

	/**
	 * Returns the value of a field
	 * @return mixt
	 * @access public
	 */
	function Fields($colName) {
		if (isset($this->fields[$colName])) {
			return $this->fields[$colName];
		} else {
			return '';
		}
	}

	/**
	 * Moves to the next row
	 * @return boolean
	 *         true if there is a next row
	 *         false otherwise
	 * @access public
	 */
	function MoveNext() {
		if (is_resource($this->resource)){
				$this->fields = mysql_fetch_assoc($this->resource);
		}else{
				$this->fields = false;
		}
		$this->EOF = ($this->fields)?false:true;
		return !$this->EOF;
	}
	/**
	 * Moves to the first row
	 * @return boolean
	 *         true if there is a next row
	 *         false otherwise
	 * @access public
	 */
	function MoveFirst(){
		if (is_resource($this->resource) && mysql_num_rows($this->resource) > 0){
				mysql_data_seek($this->resource, 0);
				return $this->MoveNext();
		}else{
				return $this->EOF = false;
		}
	}
}
?>
