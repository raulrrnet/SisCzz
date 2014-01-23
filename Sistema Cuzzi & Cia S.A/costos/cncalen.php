<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// begin Recordset
$query_calend = "SELECT * FROM calend ORDER BY nombre ASC";
$calend = $cnx_cuzzicia->SelectLimit($query_calend) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_calend = $calend->RecordCount();
// end Recordset
//Aditional Functions
require_once('../includes/functions.inc.php');

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
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body><form action="vercalen.php" method="post">
<table border="0" class="KT_tngtable">
  <tr>
    <td colspan="2">Ver Calendario </td>
  </tr>
  <tr>
    <td>Calendario
      <label></label></td>
    <td><select name="idcalen" id="idcalen">
      <?php
  while(!$calend->EOF){
?>
      <option value="<?php echo $calend->Fields('id')?>"><?php echo $calend->Fields('nombre')?></option>
      <?php
    $calend->MoveNext();
  }
  $calend->MoveFirst();
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
$calend->Close();
?>
