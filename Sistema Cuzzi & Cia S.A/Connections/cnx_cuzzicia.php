<?php 
	# PHP ADODB document - made with PHAkt
	# FileName="Connection_php_adodb.htm"
	# Type="ADODB"
	# HTTP="true"
	# DBTYPE="postgres7"
	
	$MM_cnx_cuzzicia_HOSTNAME = '192.168.1.55';
	$MM_cnx_cuzzicia_DATABASE = 'postgres7:cuzzi';
	$MM_cnx_cuzzicia_DBTYPE   = preg_replace('/:.*$/', '', $MM_cnx_cuzzicia_DATABASE);
	$MM_cnx_cuzzicia_DATABASE = preg_replace('/^[^:]*?:/', '', $MM_cnx_cuzzicia_DATABASE);
	$MM_cnx_cuzzicia_USERNAME = 'postgres';
	$MM_cnx_cuzzicia_PASSWORD = 'cd231285';
	$MM_cnx_cuzzicia_LOCALE = 'En';
	$MM_cnx_cuzzicia_MSGLOCALE = 'En';
	$MM_cnx_cuzzicia_CTYPE = 'P';
	$KT_locale = $MM_cnx_cuzzicia_MSGLOCALE;
	$KT_dlocale = $MM_cnx_cuzzicia_LOCALE;
	$KT_serverFormat = '%Y-%m-%d %H:%M:%S';
	$QUB_Caching = 'false';

	$KT_localFormat = $KT_serverFormat;
	
	if (!defined('CONN_DIR')) define('CONN_DIR',dirname(__FILE__));
	require_once(CONN_DIR.'/../adodb/adodb.inc.php');
	$cnx_cuzzicia=&KTNewConnection($MM_cnx_cuzzicia_DBTYPE);

	if($MM_cnx_cuzzicia_DBTYPE == 'access' || $MM_cnx_cuzzicia_DBTYPE == 'odbc'){
		if($MM_cnx_cuzzicia_CTYPE == 'P'){
			$cnx_cuzzicia->PConnect($MM_cnx_cuzzicia_DATABASE, $MM_cnx_cuzzicia_USERNAME,$MM_cnx_cuzzicia_PASSWORD);
		} else $cnx_cuzzicia->Connect($MM_cnx_cuzzicia_DATABASE, $MM_cnx_cuzzicia_USERNAME,$MM_cnx_cuzzicia_PASSWORD);
	} else if (($MM_cnx_cuzzicia_DBTYPE == 'ibase') or ($MM_cnx_cuzzicia_DBTYPE == 'firebird')) {
		if($MM_cnx_cuzzicia_CTYPE == 'P'){
			$cnx_cuzzicia->PConnect($MM_cnx_cuzzicia_HOSTNAME.':'.$MM_cnx_cuzzicia_DATABASE,$MM_cnx_cuzzicia_USERNAME,$MM_cnx_cuzzicia_PASSWORD);
		} else $cnx_cuzzicia->Connect($MM_cnx_cuzzicia_HOSTNAME.':'.$MM_cnx_cuzzicia_DATABASE,$MM_cnx_cuzzicia_USERNAME,$MM_cnx_cuzzicia_PASSWORD);
	}else {
		if($MM_cnx_cuzzicia_CTYPE == 'P'){
			$cnx_cuzzicia->PConnect($MM_cnx_cuzzicia_HOSTNAME,$MM_cnx_cuzzicia_USERNAME,$MM_cnx_cuzzicia_PASSWORD, $MM_cnx_cuzzicia_DATABASE);
		} else $cnx_cuzzicia->Connect($MM_cnx_cuzzicia_HOSTNAME,$MM_cnx_cuzzicia_USERNAME,$MM_cnx_cuzzicia_PASSWORD, $MM_cnx_cuzzicia_DATABASE);
   }

	if (!function_exists('updateMagicQuotes')) {
		function updateMagicQuotes($HTTP_VARS){
			if (is_array($HTTP_VARS)) {
				foreach ($HTTP_VARS as $name=>$value) {
					if (!is_array($value)) {
						$HTTP_VARS[$name] = addslashes($value);
					} else {
						foreach ($value as $name1=>$value1) {
							if (!is_array($value1)) {
								$HTTP_VARS[$name1][$value1] = addslashes($value1);
							}
						}
					}
				}
			}
			return $HTTP_VARS;
		}
		
		if (!get_magic_quotes_gpc()) {
			$_GET = updateMagicQuotes($_GET);
			$_POST = updateMagicQuotes($_POST);
			$_COOKIE = updateMagicQuotes($_COOKIE);
		}
	}
	if (!isset($_SERVER['REQUEST_URI']) && isset($_ENV['REQUEST_URI'])) {
		$_SERVER['REQUEST_URI'] = $_ENV['REQUEST_URI'];
	}
	if (!isset($_SERVER['REQUEST_URI'])) {
		$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'].(isset($_SERVER['QUERY_STRING'])?"?".$_SERVER['QUERY_STRING']:"");
	}
?>