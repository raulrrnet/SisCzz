<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_ordenes = "SELECT * FROM orden ORDER BY idorden ASC";
$ordenes = $cnx_cuzzicia->SelectLimit($query_ordenes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_ordenes = $ordenes->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Consumos Ordenes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DynamicInput.js"></script>
<?php
//begin JSRecordset
$jsObject_ordenes = new WDG_JsRecordset("ordenes");
echo $jsObject_ordenes->getOutput();
//end JSRecordset
?>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0">
<tr valign="top">
<td><form action="ordinfor.php" method="post" name="frm_salidas" target="idiframe" id="form1">
<table border="0" class="KT_tngtable">
  <tr>
    <td colspan="2">Orden - Informes </td>
  </tr>
  <tr>
    <td>Seleccione orden:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="idord" id="idord" wdg:subtype="DynamicSearch" wdg:recordset="ordenes" wdg:type="widget" wdg:displayfield="idorden" wdg:norec="50" wdg:defaultoptiontext="no"></td>
    <td><input type="submit" name="Submit" value="Consultar"></td>
  </tr>
</table></form></td>
<td><iframe  name="idiframe" id="idiframe" width="600" height="500" frameborder="0" src="ordinfor.php">
	</iframe></td>
</tr>
</table>
</body>
</html>
<?php
$ordenes->Close();
?>
