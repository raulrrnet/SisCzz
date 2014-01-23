<?php
/**
 * The Recordset class
 */
class MX_TreeMenu_recordset {

	/**
	 * The Recordset resource
	 * @var object ResourceID
	 * @access private
	 */
	var $resource = null;

	/**
	 * The returned fields
	 * @var array
	 * @access public
	 */
	var $fields = array();

	/**
	 * Are we at the end of the record?
	 * @var boolean
	 * @access public
	 */
	var $EOF = true;

	/**
	 * The constructor
	 * @param object ResourceID &$resource - the recordset resource id
	 * @access public
	 */
	function MX_TreeMenu_recordset(&$resource) {
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
		$this->fields = mysql_fetch_assoc($this->resource);
		$this->EOF = ($this->fields)?false:true;
		return !$this->EOF;
	}
}
?>
