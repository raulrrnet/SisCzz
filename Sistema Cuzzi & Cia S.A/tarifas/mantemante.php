<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$fec = date('Y/m/d');
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}
$fecfecha = strtotime($fec); 
$anio = date("Y",$fecfecha);
$mes = date("m",$fecfecha);
// begin Recordset
$sql = sprintf("SELECT idcostmante,seccion,fecha,costototal From seccion s, costomante c WHERE s.idseccion=c.idseccion and date_part('year',fecha)=$anio ORDER BY fecha");
$exsql = $cnx_cuzzicia->SelectLimit($sql) or die($cnx_cuzzicia->ErrorMsg());
$totalRowsSql = $exsql->RecordCount();
// end Recordset
$sum[] = 0;
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
<table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center"><form name="form1" method="post" action="mantemante.php">
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input type="submit" name="Submit" value="Mostrar">
    </form></td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td colspan="5" class="KT_th"><span class="Estilo2"><strong>COSTOS MANTENIMIENTO</strong></span></td>
        </tr>
      <tr>
        <td class="KT_th">Seccion</td>
        <td class="KT_th">Fecha</td>
        <td class="KT_th">Costo</td>
        <td class="KT_th">&nbsp;</td>
        <td class="KT_th">&nbsp;</td>
      </tr>
<?php
  while (!$exsql->EOF) { 
?>
      <tr>
        <td><?php echo $exsql->Fields('seccion'); ?></td>
        <td><?php echo $exsql->Fields('fecha'); ?></td>
        <td align="right"><?php echo number_format($exsql->Fields('costototal'),2); ?></td>
        <td><a href="actumante.php?idcos=<?php echo $exsql->Fields('idcostmante'); ?>">MODIFICAR</a></td>
        <td><a href="elimina.php?tabla=costomante&idtabla=idcostmante&goto=mantemante.php&id=<?php echo $exsql->Fields('idcostmante');?>">ELIMINAR</a></td>
      </tr>
      <?php
	  $sum[]=$exsql->Fields('costototal');
    $exsql->MoveNext(); 
  }
?>
<tr>
<td></td>
<td></td>
<td align="right"><?php echo number_format(array_sum($sum),2); ?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>
    </table></td>
  </tr>
</table>
</body>
</html>