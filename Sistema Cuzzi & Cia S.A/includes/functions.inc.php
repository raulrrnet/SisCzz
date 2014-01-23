<?php
  // PHP ADODB document - made with PHAkt
  // functions needed by PHAkt generated pages
  
  require_once(dirname(__FILE__) . '/common/KT_common.php');
  
  function KT_replaceParam($qstring, $paramName, $paramValue) {
    if (preg_match("/&" . $paramName . "=/", $qstring)) {
      return preg_replace("/&" . $paramName . "=[^&]+/", "&" . $paramName . "=" . urlencode($paramValue), $qstring);
    } else {
      return $qstring . "&" . $paramName . "=" . urlencode($paramValue);
    }
  }

  function KT_removeParam($qstring, $paramName) {
    if($qstring == "&"){
      $qstring = "";
    }
    $tmp = preg_replace("/&" . $paramName . "=[^&]*/", "", $qstring);
	if ($tmp == $qstring) {
    	$tmp = preg_replace("/\?" . $paramName . "=[^&]*/", "?", $tmp);
    	$tmp = str_replace("?&", "?", $tmp);
    	$tmp = preg_replace("#\?$#", "", $tmp);
	}
	return $tmp;
  }


/***
* KT_keep_arrayParams
* Description: Transform an array into an URL string delimited with &
* Parameters:
* $the_array - The array which it should be transformed
* $the_var - The initial string to which it will add this URL string representation
* $keepName - The name to be keeped if the array has multiple levels 
* $paramName - A key/array of keys name from the array whitch it should be eliminated
*/

function KT_keep_arrayParams($the_array, $the_var, $keepName='', $paramName=''){
	while (list($key, $value) = each($the_array)) {
		if ($paramName == '' OR (!(is_array($paramName)) AND $key != $paramName) OR (is_array($paramName) AND !(in_array($key, $paramName, TRUE)))) {
			if (!is_array($value)){
				$the_var .= "&" . ($keepName!=''?($keepName."["):"").urlencode($key) .($keepName!=''?"]":""). "=" . urlencode($value);
			}else{
				$the_var = KT_keep_arrayParams($value, $the_var, ($keepName!=''?($keepName."["):"").urlencode($key).($keepName!=''?"]":""),$paramName); 
			}
		}
	}
	return $the_var;
}

function KT_keepParams($paramName) {
	global $MM_keepURL, $MM_keepForm, $MM_keepBoth, $MM_keepNone ;
	$MM_keepNone="";

	// add the URL parameters to the MM_keepURL string
	$MM_keepURL = KT_keep_arrayParams($_GET, '', '', $paramName);
	
	// add the Form variables to the MM_keepForm string
	$MM_keepForm = KT_keep_arrayParams($_POST, '', '', $paramName);
	
	// create the Form + URL string and remove the intial '&' from each of the strings
	$MM_keepBoth = $MM_keepURL . $MM_keepForm;
	if (strlen($MM_keepBoth) > 0) $MM_keepBoth = substr($MM_keepBoth,1);
	if (strlen($MM_keepURL) > 0) $MM_keepURL = substr($MM_keepURL,1);
	if (strlen($MM_keepForm) > 0) $MM_keepForm = substr($MM_keepForm,1);
}
  
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
    $theValue = (get_magic_quotes_gpc()) ? stripslashes($theValue) : $theValue;
    switch ($theType) {
      case 'date':
      case 'text':
        $theValue = KT_escapeForSql($theValue, 'STRING_TYPE');
        break;    
      case 'long':
      case 'int':
        $theValue = KT_escapeForSql($theValue, 'NUMERIC_TYPE');
        break;
      case 'double':
        $theValue = KT_escapeForSql($theValue, 'DOUBLE_TYPE');
        break;
      case 'defined':
        $theValue = ($theValue != '') ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }


   class fakeRecordSet{
        var $fields=array();

        function prepareValue($field, $value){
            if($value==='NULL'){
                $value='';
            }
            $this->fields[$field]=$value;
        }
        
        function Fields($field){
            return @$this->fields[$field];
        }

        function Close(){
            unset($this->fields);
        }
    }
    
    function KT_parseError($a,$b) {
        //if(strstr($b, "Bad date external representation")){
        //    $b = "&nbsp;Data nu a fost bine introdusa.";
        //}
        echo "<font color=red><p class=\"error\">Error:<br>$b</p></font>";
    }
    
    function KT_DIE($a,$b) {
        echo "<p class=\"error\">An error occured!<br>Error no: $a<br>Error message: $b</p>";
        exit;
    }

   function addReplaceParam($KT_Url,$param,$value=""){
      $sep = (strpos($KT_Url, '?') == false)?'?':'&';
      $value = KT_descape($value);
      if(preg_match("#$param=[^&]*#",$KT_Url)){
         $KT_Url = preg_replace("#$param=[^\&]*#", "$param=$value", $KT_Url);
      }else {
         $KT_Url .="$sep$param=$value";
      }
      if ($value == "") {
        $KT_Url = preg_replace("#$param=#", "", $KT_Url);
      }
      $KT_Url = str_replace('?&', '?', $KT_Url);
      $KT_Url = preg_replace('#&+#', '&', $KT_Url);
      $KT_Url = preg_replace('#&$#', '', $KT_Url);
      $KT_Url = preg_replace('#\?$#', '', $KT_Url);
      return $KT_Url;
   }
   
   function KT_descape($KT_text){
     if(eregi("^'.*'$",$KT_text)){
         $KT_text = substr($KT_text, 1, strlen($KT_text)-2);
     }
     return $KT_text;
   }

   function KT_removeEsc($KT_text) {
          if (eregi("^'.*'$",$KT_text)) {
            return substr($KT_text, 1, strlen($KT_text)-2);
        } else {
            return $KT_text;
        }
   }
   

/**
	register a variable in the session taking in account the PHP version
	@params
		$varname - variable name
		$value - variable value
	@return 
		- none
*/
function KT_session_register($varname, $value = null) {
	global $$varname;
	if (is_null($value)) {
		$value = $$varname;
	}
	if (!function_exists('version_compare')) { //if the version is smaller than php 4.1.0
		if (ini_get('register_globals') == '1') { //if register globals is on
			if ($value != null) {
				$$varname = $value;
			}
			session_register($varname);
		}
	} else {
		$_SESSION[$varname] = $value;
	}

	if (version_compare('5.0.0', phpversion()) >= 0 && ini_get('register_long_arrays')>0 || version_compare('5.0.0', phpversion()) < 0){
	
		global $HTTP_SESSION_VARS;
		$HTTP_SESSION_VARS[$varname] = $value;
	}
}
/**
	unregister a variable from the session taking in account the PHP version
	@params
		$varname - variable name
	@return 
		- none
*/
function KT_session_unregister($varname) {
	if (!function_exists('version_compare')) { //if the version is smaller than php 4.1.0
		if (ini_get('register_globals') == '1') { //if register globals is on
			global $$varname;
			session_unregister($varname);
		}
		if (version_compare('5.0.0', phpversion()) >= 0 && ini_get('register_long_arrays')>0 || version_compare('5.0.0', phpversion()) < 0){
					global $HTTP_SESSION_VARS;
					unset($HTTP_SESSION_VARS[$varname]);
		}
		
	} else {
		unset($_SESSION[$varname]);
	}
}
/**
	Search an level name into an array of comma separated levels
	@params
		$levels - allowed levels
		$element - the element to be searched
	@return 
		- true if was found
		- false otherwise
*/
function KT_strpos($levels, $element){
    $to_array = explode(',', substr($levels,1)); // the first char is a white space.
	  return in_array($element, $to_array, false);	
}

if (version_compare('5.0.0', phpversion()) <= 0 && ini_get('register_long_arrays')>0 || version_compare('5.0.0', phpversion()) > 0){
				//normalize SERVER and ENV vars
				if (!isset($HTTP_SERVER_VARS['QUERY_STRING']) && isset($HTTP_ENV_VARS['QUERY_STRING'])) {
					$HTTP_SERVER_VARS['QUERY_STRING'] = $HTTP_ENV_VARS['QUERY_STRING'];
				}
				if (!isset($HTTP_SERVER_VARS['REQUEST_URI']) && isset($HTTP_ENV_VARS['REQUEST_URI'])) {
					$HTTP_SERVER_VARS['REQUEST_URI'] = $HTTP_ENV_VARS['REQUEST_URI'];
				}
				if (!isset($HTTP_SERVER_VARS['REQUEST_URI'])) {
					$HTTP_SERVER_VARS['REQUEST_URI'] = $HTTP_SERVER_VARS['SCRIPT_NAME'].(isset($HTTP_SERVER_VARS['QUERY_STRING'])?"?".$HTTP_SERVER_VARS['QUERY_STRING']:"");
				}
				if (!isset($HTTP_SERVER_VARS['HTTP_HOST']) && isset($HTTP_ENV_VARS['HTTP_HOST'])) {
					$HTTP_SERVER_VARS['HTTP_HOST'] = $HTTP_ENV_VARS['HTTP_HOST'];
				}
				if (!isset($HTTP_SERVER_VARS['HTTPS']) && isset($HTTP_ENV_VARS['HTTPS'])) {
					$HTTP_SERVER_VARS['HTTPS'] = $HTTP_ENV_VARS['HTTPS'];
				}
				if (!isset($HTTP_SERVER_VARS['PATH_TRANSLATED']) && isset($HTTP_ENV_VARS['PATH_TRANSLATED'])) {
					$HTTP_SERVER_VARS['PATH_TRANSLATED'] = $HTTP_ENV_VARS['PATH_TRANSLATED'];
				}
				if (!isset($HTTP_SERVER_VARS['SCRIPT_FILENAME']) && isset($HTTP_ENV_VARS['SCRIPT_FILENAME'])) {
					$HTTP_SERVER_VARS['SCRIPT_FILENAME'] = $HTTP_ENV_VARS['SCRIPT_FILENAME'];
				}

				if (!isset($HTTP_SERVER_VARS['HTTP_REFERER']) && isset($HTTP_ENV_VARS['HTTP_REFERER'])) {
					$HTTP_SERVER_VARS['HTTP_REFERER'] = $HTTP_ENV_VARS['HTTP_REFERER'];
				}
				if (!isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) && isset($HTTP_ENV_VARS['HTTP_USER_AGENT'])) {
					$HTTP_SERVER_VARS['HTTP_USER_AGENT'] = $HTTP_ENV_VARS['HTTP_USER_AGENT'];
				}
				// fixing #0003728
				if (empty($HTTP_SERVER_VARS['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
						$HTTP_SERVER_VARS['QUERY_STRING'] = $_SERVER['QUERY_STRING'];
				}elseif (!empty($HTTP_SERVER_VARS['QUERY_STRING']) && empty($_SERVER['QUERY_STRING'])){
						$_SERVER['QUERY_STRING'] = $HTTP_SERVER_VARS['QUERY_STRING'];
				}elseif (empty($_SERVER['QUERY_STRING']) && empty($HTTP_SERVER_VARS['QUERY_STRING'])){
						$HTTP_SERVER_VARS['QUERY_STRING'] = $_SERVER['QUERY_STRING'] = '';
				}
				// end fixing #0003728
}
KT_setServerVariables();
?>
