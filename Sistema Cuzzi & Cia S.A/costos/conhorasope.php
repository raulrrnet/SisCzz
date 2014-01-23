<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_operario = "SELECT * FROM operario WHERE estado='A' ORDER BY nombre ASC";
$operario = $cnx_cuzzicia->SelectLimit($query_operario) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operario = $operario->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Consumos Secci&oacute;n</title>
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
$jsObject_operario = new WDG_JsRecordset("operario");
echo $jsObject_operario->getOutput();
//end JSRecordset
?>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body><form action="repohoras.php" method="post">
<table border="0" class="KT_tngtable">
  <tr>
    <td colspan="2">Horas Operario </td>
  </tr>
  <tr>
    <td>Operario
      <label></label></td>
    <td><select name="operario" id="operario">
      <?php
  while(!$operario->EOF){
?>
      <option value="<?php echo $operario->Fields('idoperario')?>"><?php echo $operario->Fields('nombre')?></option>
      <?php
    $operario->MoveNext();
  }
  $operario->MoveFirst();
?>
    </select></td>
  </tr>
  <tr>
    <td>Fecha Inicio </td>
    <td><label>
      <input name="fecini" id="fecini" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no">
    </label></td>
  </tr>
  <tr>
    <td>Fecha Fin </td>
    <td><label>
      <input name="fecfin" id="fecfin" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no">
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Consultar"></td>
  </tr>
</table></form>
</body>
</html>
<?php
$operario->Close();
?>
