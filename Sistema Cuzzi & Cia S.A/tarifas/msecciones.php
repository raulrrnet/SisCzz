<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$fec = '2008/01/01';
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}
$fecfecha = strtotime($fec); 
$anio = date("Y",$fecfecha);
$mes = date("m",$fecfecha);
// begin Recordset
$sql = sprintf("SELECT * From seccion ORDER BY status,seccion");
$exsql = $cnx_cuzzicia->SelectLimit($sql) or die($cnx_cuzzicia->ErrorMsg());
$totalRowsSql = $exsql->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
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
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="5" class="KT_th"><span class="Estilo2"><strong>SECCIONES</strong></span></td>
  </tr>
  <tr>
    <td class="KT_th">Secci&oacute;n</td>
    <td class="KT_th">Unidad</td>
    <td class="KT_th">Estado</td>
    <td class="KT_th">Potencia</td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <?php
	while (!$exsql->EOF) { 
?>
  <tr>
    <td><?php echo $exsql->Fields('seccion'); ?></td>
    <td><?php echo $exsql->Fields('unidad'); ?></td>
    <td><?php echo $exsql->Fields('status'); ?></td>
    <td><?php echo $exsql->Fields('potencia'); ?></td>
    <td><a href="../modseccion.php?idsec=<?php echo $exsql->Fields('idseccion'); ?>">MODIFICAR</a></td>
  </tr>
  <?php
	  $sum[]=$exsql->Fields('costototal');
    $exsql->MoveNext(); 
  }
?>
  <tr>
    <td></td>
    <td align="right">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>