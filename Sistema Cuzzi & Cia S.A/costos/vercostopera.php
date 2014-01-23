<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');
$sum[]=0;
$fec = '2001/01/01';
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}
$fecfecha = strtotime($fec); 
$anio = date("Y",$fecfecha);
$mes = date("m",$fecfecha);
// begin Recordset
$query_cnkardex = sprintf("SELECT * FROM v_operario WHERE date_part('month',mes)=$mes and date_part('year',mes)=$anio ORDER BY nombre");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Resumen Informes x Dia</title>
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
</head>

<body>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center" valign="middle" scope="col"><form name="form1" method="post" action="vercostopera.php">
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input type="submit" name="Submit" value="Mostrar">
    </form></td>
  </tr>
  
  <tr>
    <td scope="col"><table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="KT_th"><span class="Estilo2"><strong>COSTOS OPERARIO <?php echo $cnkardex->Fields('mes'); ?> (mes)</strong></span></td>
    </tr>
  
  <tr>
    <td class="KT_th">Operario</td>
	<td class="KT_th">Costo Total </td>
	</tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('nombre'); ?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('costototal'),2); ?></td>
    </tr>
  <?php
 	 $sum[]=$cnkardex->Fields('costototal');
    $cnkardex->MoveNext(); 
  }
?>
<tr>
    <td>TOTAL</td>
    <td align="right"><?php echo number_format(array_sum($sum),2); ?></td>
    </tr>
</table></td>
  </tr>
</table>
<p><a href="../tarifas/mantecostope.php">MODIFICAR / ELIMINAR</a> </p>
</body>
</html>