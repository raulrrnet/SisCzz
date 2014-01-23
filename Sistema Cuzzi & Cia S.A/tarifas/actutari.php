<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmactuasig")) {
  $updateSQL = sprintf("UPDATE detalletarifa SET idseccion=%s, vdolar=%s, vsoles=%s, fechavigencia=%s WHERE idtarifadet=%s",
                       GetSQLValueString($_POST['seccion'], "int"),
                       GetSQLValueString($_POST['vdolar'], "double"),
                       GetSQLValueString($_POST['vsoles'], "double"),
                       GetSQLValueString($_POST['vigencia'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "mantetari.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$query_secciones = "SELECT * FROM seccion WHERE status = 'Vigente' ORDER BY seccion ASC";
$secciones = $cnx_cuzzicia->SelectLimit($query_secciones) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_secciones = $secciones->RecordCount();
// end Recordset

// begin Recordset
$colname__actutari = '-1';
if (isset($_GET['idtari'])) {
  $colname__actutari = $_GET['idtari'];
}
$query_actutari = sprintf("SELECT * FROM detalletarifa WHERE idtarifadet = %s", GetSQLValueString($colname__actutari, "int"));
$actutari = $cnx_cuzzicia->SelectLimit($query_actutari) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actutari = $actutari->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST"  class="dtable" name="frmactuasig" id="frmactuasig">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="MXW_ICT_visual_alert_div">Tarifas</td>
  </tr>
  <tr>
    <td class="nav_cal"><input name="id" type="hidden" id="id" value="<?php echo $actutari->Fields('idtarifadet'); ?>"></td>
    <td class="nav_cal">&nbsp;</td>
  </tr>
  
  <tr>
    <td>Sección:</td>
    <td><select name="seccion" id="seccion">
      <?php
  while(!$secciones->EOF){
?><option value="<?php echo $secciones->Fields('idseccion')?>"<?php if (!(strcmp($secciones->Fields('idseccion'), $actutari->Fields('idseccion')))) {echo "SELECTED";} ?>><?php echo $secciones->Fields('seccion')?></option>
      <?php
    $secciones->MoveNext();
  }
  $secciones->MoveFirst();
?>
    </select></td>
  </tr>
  <tr>
    <td>V. Soles </td>
    <td><input name="vsoles" type="text" id="vsoles" value="<?php echo $actutari->Fields('vsoles'); ?>" /></td>
  </tr>
  <tr>
    <td>V. Dolar </td>
    <td><input name="vdolar" type="text" id="vdolar" value="<?php echo $actutari->Fields('vdolar'); ?>"></td>
  </tr>
  <tr>
    <td>Vigencia</td>
    <td><input name="vigencia" id="vigencia" value="<?php echo $actutari->Fields('fechavigencia'); ?>" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
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
$secciones->Close();

$actutari->Close();
?>
