<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// begin Recordset
$idclien = '1';
if (isset($_GET['idclien'])) {
  $idclien = $_GET['idclien'];
}
$query_actuasigope = "SELECT * FROM clientes WHERE idcliente = $idclien";
$actuasigope = $cnx_cuzzicia->SelectLimit($query_actuasigope) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuasigope = $actuasigope->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmactuasig")) {
  $insertSQL = sprintf("INSERT INTO locals (local, direccion, idcliente) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['local'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "listclientes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
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
<title>Asignar Local</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST"  class="dtable" name="frmactuasig" id="frmactuasig">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="MXW_ICT_visual_alert_div">Agregar Local Cliente</td>
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
    <td class="MXW_ICT_visual_alert_div">Nombre:</td>
    <td><label>
      <input name="local" type="text" id="local">
    </label></td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div">Direcci&ograve;n:</td>
    <td><label>
      <textarea name="direccion" id="direccion"></textarea>
    </label></td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input name="KT_Insert1" type="submit" class="MXW_ICT_visual_alert_div" id="KT_Insert1" value="Grabar" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="frmactuasig">
</form>
</body>
</html>
<?php
$actuasigope->Close();
?>
