<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO ingresoal (fecha, entrega, recibe) VALUES (%s, %s, %s) RETURNING idingreso",
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['entrega'], "text"),
                       GetSQLValueString($_POST['recibe'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	$idingre = $Result1->Fields('idingreso');
  $insertGoTo = "detingreal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?idingre=".$idingre;
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<form name="form2" method="post" id="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Entregado Por: </td>
      <td><label>
        <input name="entrega" type="text" id="entrega">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Recibido Por: </td>
      <td><label>
        <input name="recibe" type="text" id="recibe">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fecha:</td>
      <td><input type="text" name="fecha" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="idinsert" value="" />
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
</body>
</html>
