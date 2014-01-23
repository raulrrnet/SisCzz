<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO mdmaterial (material) VALUES (%s)",
                       GetSQLValueString($_POST['mate'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "nuevomd.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>MD Material</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
     <tr>
      <td colspan="2" class="KT_th">MATERIAL DIRECTO ORDEN </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
      <td class="KT_th">Material:</td>
      <td>
        <input type="text" name="mate" id="mate" /></td>
    </tr>
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="button" name="cancel" id="cancel" value="Cancelar" onClick="history.go(-1)" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Aceptar"/>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
</body>
</html>
