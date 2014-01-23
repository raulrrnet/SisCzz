<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('includes/wdg/WDG.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$query_seccion = "SELECT * FROM seccion WHERE status <> 'x' ORDER BY idseccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Consumos Secci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/DynamicInput.js"></script>
<?php
//begin JSRecordset
$jsObject_seccion = new WDG_JsRecordset("seccion");
echo $jsObject_seccion->getOutput();
//end JSRecordset
?>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0">
<tr valign="top">
<td><form action="consusec.php" method="post" name="frm_salidas" target="idiframe" id="form1">
  <table border="0" class="KT_tngtable">
    <tr>
      <td colspan="2">Consumos por Secci&oacute;n </td>
    </tr>
    
    <tr>
      <td>Secci&oacute;n
<label></label></td>
      <td><select name="seccion" id="seccion">
        <option value="-" selected>>>Seleccione<</option>
        <?php
  while(!$seccion->EOF){
?>
        <option value="<?php echo $seccion->Fields('idseccion')?>"><?php echo $seccion->Fields('seccion')?></option>
        <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
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
  </table>
</form></td>
<td><iframe  name="idiframe" id="idiframe" width="650" height="350" frameborder="0" src="consusec.php">
	</iframe></td>
</tr>
</table>
</body>
</html>
<?php
$seccion->Close();

$seccion->Close();
?>
