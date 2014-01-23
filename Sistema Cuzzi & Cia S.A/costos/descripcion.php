<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO descripcion (descripcion) VALUES (%s)",
                       GetSQLValueString($_POST['descrip'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "descripcion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Descripci&oacute;n</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Ingrese Descripci&oacute;n </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="proveedor">Descripci&oacute;n:</label></td>
      <td><input type="text" name="descrip" id="descrip" /></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input name="button" type="button" onClick="javascript:history.go(-2)" value="Volver" />
      <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
</body>
</html>