<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('includes/wdg/WDG.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmactuasig")) {
  $updateSQL = sprintf("UPDATE asignacion SET idoperario=%s, idseccion=%s, porcentaje=%s, fecha=%s WHERE idasigna=%s",
                       GetSQLValueString($_POST['idope'], "int"),
                       GetSQLValueString($_POST['seccion'], "int"),
                       GetSQLValueString($_POST['porcent'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['idasig'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "modasig.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$colname__actuasigope = '5';
if (isset($_GET['idasigna'])) {
  $colname__actuasigope = $_GET['idasigna'];
}
$query_actuasigope = sprintf("SELECT a.idasigna, o.idoperario,   o.nombre,   o.estado,   s.seccion,   s.idseccion, a.porcentaje, a.fecha FROM operario o,   asignacion a,   seccion s WHERE (o.idoperario = a.idoperario) and   s.idseccion = a.idseccion and  idasigna = %s", GetSQLValueString($colname__actuasigope, "int"));
$actuasigope = $cnx_cuzzicia->SelectLimit($query_actuasigope) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuasigope = $actuasigope->RecordCount();
// end Recordset

// begin Recordset
$query_secciones = "SELECT * FROM seccion ORDER BY seccion ASC";
$secciones = $cnx_cuzzicia->SelectLimit($query_secciones) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_secciones = $secciones->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<link href="includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>"  class="dtable" name="frmactuasig" id="frmactuasig">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="MXW_ICT_visual_alert_div">Modificar Asignaci&oacute;n</td>
  </tr>
  <tr>
    <td class="nav_cal"><input name="idasig" type="hidden" id="idasig" value="<?php echo $actuasigope->Fields('idasigna'); ?>">
    <input name="idope" type="hidden" id="idope" value="<?php echo $actuasigope->Fields('idoperario'); ?>"></td>
    <td class="nav_cal">&nbsp;</td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div">Operario:</td>
    <td><label><?php echo $actuasigope->Fields('nombre'); ?></label></td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div">Secci&oacute;n:</td>
    <td><select name="seccion" id="seccion">
      <?php
  while(!$secciones->EOF){
?><option value="<?php echo $secciones->Fields('idseccion')?>"<?php if (!(strcmp($secciones->Fields('idseccion'), $actuasigope->Fields('idseccion')))) {echo "SELECTED";} ?>><?php echo $secciones->Fields('seccion')?></option>
      <?php
    $secciones->MoveNext();
  }
  $secciones->MoveFirst();
?>
    </select></td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div">Porcentaje</td>
    <td><input name="porcent" type="text" id="porcent" value="<?php echo $actuasigope->Fields('porcentaje'); ?>" /></td>
  </tr>
  <tr>
    <td class="MXW_ICT_visual_alert_div"><label for="proveedor">Fecha Asignaci&oacute;n </label></td>
    <td><input name="fecha" id="fecha" value="<?php echo $actuasigope->Fields('fecha'); ?>" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input name="KT_Insert1" type="submit" class="MXW_ICT_visual_alert_div" id="KT_Insert1" value="Grabar" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="frmactuasig">
</form>
<a href="asigna.php?idope=<?php echo $actuasigope->Fields('idoperario'); ?>">CREAR ASIGNACION
</a>
</body>
</html>
<?php
$actuasigope->Close();

$secciones->Close();
?>
