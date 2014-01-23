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

$query_seccion = "SELECT * FROM seccion where idseccion<>0 ORDER BY seccion";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
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
.Estilo2 {font-weight: bold}
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
    <td align="center"><form name="form1" method="post" action="mantedepre.php">
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input type="submit" name="Submit" value="Mostrar">
    </form></td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td colspan="7" class="KT_th"><span class="Estilo2"><strong>COSTOS DEPRECIACION</strong></span></td>
        </tr>
      <tr>
        <td width="500" class="KT_th">Descripci&oacute;n</td>
        <td class="KT_th">Fecha I.</td>
        <td class="KT_th">Importe</td>
        <td class="KT_th">Tasa</td>
        <td class="KT_th">Dep.</td>
        <td class="KT_th">%</td>
        <td class="KT_th">&nbsp;</td>
      </tr>
<?php
//
$oldname="";
while (!$seccion->EOF) {
	//---------------------------------------------------------------------------------
$idsec = $seccion->Fields('idseccion');

//depreciacion
$q_depsec12 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fec' ORDER BY fecingreso");
$depresec12 = $cnx_cuzzicia->SelectLimit($q_depsec12) or die($cnx_cuzzicia->ErrorMsg());
		$totdep12[] = 0;
		$totdep12t[] = 0;
		while (!$depresec12->EOF) {
		$fecingre12 = $depresec12->Fields('fecingreso');
		$q_meses12 = sprintf("select (DATE '$fec'-'$fecingre12')/30 as diff;");
		$excmeses12 = $cnx_cuzzicia->SelectLimit($q_meses12) or die($cnx_cuzzicia->ErrorMsg());
		$diff12 = $excmeses12->Fields('diff');
		if($fecingre12<=$fec and $diff12<=$depresec12->Fields('nrocuotas')){
			$totdep12[] = $depresec12->Fields('dep');
			$totdep12t[] = $depresec12->Fields('dep');
		
$newnom=$seccion->Fields('seccion');
if($newnom=$oldname){}else{
?><tr> <td><strong><?php echo $seccion->Fields('seccion');$oldname=$seccion->Fields('seccion'); ?></strong></td>
</tr>
<?php }?>
<tr>
       <td width="500"><?php echo $depresec12->Fields('descripcion'); ?></td>
        <td><?php echo $depresec12 ->Fields('fecingreso'); ?></td>
        <td><?php echo $depresec12 ->Fields('importe'); ?></td>
        <td><?php echo number_format($depresec12->Fields('tasa'),2); ?></td>
        <td align="right"><?php echo number_format($depresec12->Fields('dep'),2); ?></td>
        <td align="right"><?php echo $depresec12->Fields('porcentaje')*100; ?>%</td>
        <td align="right"><a href="elimina.php?tabla=depreciacion&idtabla=iddeprecia&goto=mantedepre.php&id=<?php echo $depresec12->Fields('iddeprecia');?>">ELIMINAR</a></td>
      </tr>
      <?php
		  }
	$depresec12->MoveNext();
	}					
$seccion->MoveNext();
$oldname="";
}
?>
    <tr>
	<td width="500"></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="right"><?php echo number_format(array_sum($totdep12),2); ?></td>
	</tr>
	</table></td>
  </tr>
</table>
</body>
</html>