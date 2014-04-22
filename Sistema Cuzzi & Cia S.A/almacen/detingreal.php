<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$idingre = '0';
if (isset($_GET['idingre'])) {
  $idingre = $_GET['idingre'];
}

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO detingreal (idingresoal, idorden, packs, undpack, canttotal) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idingreso'], "int"),
                       GetSQLValueString($_POST['idorden'], "int"),
                       GetSQLValueString($_POST['packs'], "int"),
                       GetSQLValueString($_POST['undpack'], "int"),
                       GetSQLValueString($_POST['canttotal'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "detingreal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form name="form2" method="post" id="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Idorden:</td>
      <td><input type="text" name="idorden" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Paquetes:</td>
      <td><input type="text" name="packs" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Und/Paq.:</td>
      <td><input type="text" name="undpack" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input name="idingreso" type="hidden" id="idingreso" value="<?php echo $idingre;?>" />
  <input type="hidden" name="canttotal" value="" />
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
</body>
</html>
