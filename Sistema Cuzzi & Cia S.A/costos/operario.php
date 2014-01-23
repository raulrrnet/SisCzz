<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO operario (nombre, cargo, estado) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['operario'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "../asigna.php";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Nuevo Operario </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Operario:</td>
      <td><input type="text" name="operario" id="operario" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="proveedor">Cargo:</label></td>
      <td><input type="text" name="cargo" id="cargo" /></td>
    </tr>
    <tr>
      <td class="KT_th">Estado:</td>
      <td><label> Activo
          <input name="estado" type="radio" value="A" checked="checked">
Inactivo </label>
        <label>
        <input name="estado" type="radio" value="X">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  
  
  <input type="hidden" name="MM_insert" value="form2">
</form>
</body>
</html>