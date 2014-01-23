<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');
$idgclien = '-1';
if (isset($_GET['idgclien'])) {
  $idgclien = $_GET['idgclien'];
}
// begin Recordset
$idclien = '1';
if (isset($_GET['idclien'])) {
  $idclien = $_GET['idclien'];
}
$query_actuasigope = "SELECT * FROM clientes WHERE idcliente = $idclien";
$actuasigope = $cnx_cuzzicia->SelectLimit($query_actuasigope) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuasigope = $actuasigope->RecordCount();
// end Recordset
$nomclien = $actuasigope->Fields('cliente');
$idgclien = $actuasigope->Fields('idgcliente');
// begin Recordset
$query_grupos = "SELECT * FROM gclientes ORDER BY nombre";
$grupos = $cnx_cuzzicia->SelectLimit($query_grupos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_grupos = $grupos->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmactuasig")) {
  $updateSQL = sprintf("UPDATE clientes SET idgcliente=%s WHERE idcliente=%s",
                       GetSQLValueString($_POST['gclientes'], "int"),
                       GetSQLValueString($_POST['id'], "int"));
  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  // begin Recordset
$query_gc = "SELECT * FROM clientes WHERE idgcliente = $idgclien";
$grupoc = $cnx_cuzzicia->SelectLimit($query_gc) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_grupoc = $grupoc->RecordCount();
// end Recordset
	if($totalRows_grupoc==0){
  $updateSQL = "DELETE FROM gclientes WHERE nombre='$nomclien';";
  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  	}
  $updateGoTo = "listgruposc.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
<head>
<title>Asignar Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>"  class="dtable" name="frmactuasig" id="frmactuasig">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="MXW_ICT_visual_alert_div">Agrupar Clientes</td>
  </tr>
  <tr>
    <td class="nav_cal"><input name="id" type="hidden" id="id" value="<?php echo $actuasigope->Fields('idcliente'); ?>"></td>
    <td class="nav_cal">&nbsp;</td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div">Cliente:</td>
    <td><label><?php echo $actuasigope->Fields('cliente'); ?></label></td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div">Grupo:</td>
    <td><select name="gclientes" id="gclientes">
      <?php
  while(!$grupos->EOF){
?><option value="<?php echo $grupos->Fields('idgclien')?>"><?php echo $grupos->Fields('nombre')?></option>
      <?php
    $grupos->MoveNext();
  }
  $grupos->MoveFirst();
?>
    </select>
      <span class="selected_cal">
      <input name="Button" type="button" onClick="self.location='ngrupo.php'" value="Nuevo">
      </span></td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input name="KT_Insert1" type="submit" class="MXW_ICT_visual_alert_div" id="KT_Insert1" value="Grabar" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="frmactuasig">
</form>
</body>
</html>
<?php
$actuasigope->Close();
$grupos->Close();
?>
