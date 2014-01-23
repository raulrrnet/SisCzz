<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_seccion = "SELECT * FROM seccion WHERE status <> 'x' ORDER BY idseccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset
$fecfin = '2007/07/31';//date('Y/m/d');
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
$fecfecha = strtotime($fecfin); 
$anio = date("Y",$fecfecha);
$mes = date("m",$fecfecha);
$fecini = '2007/07/01';//$anio."/".$mes."/01";
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
/*
	while (!$seccion->EOF) {
		$idsec = $seccion->Fields('idseccion');
	// consulta operarios seccion
	$q_opesec = sprintf("SELECT idoperario FROM v_informes WHERE idseccion = $idsec and fecha between '2007/07/01' and '2007/07/31' GROUP BY idoperario ORDER BY idoperario");
	$operasec = $cnx_cuzzicia->SelectLimit($q_opesec) or die($cnx_cuzzicia->ErrorMsg());
		while (!$operasec->EOF) {
		$idope = $operasec->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE mes between '2007/07/01' and '2007/07/31' and idoperario=$idope");
		$exqcostoope = $cnx_cuzzicia->SelectLimit($q_costoope) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE fecha between '2007/07/01' and '2007/07/31' and idoperario=$idope");
		$exqtitoope = $cnx_cuzzicia->SelectLimit($q_titoope) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra = $exqcostoope->Fields('costotal')/$exqtitoope->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (idoperacion = 1 or idoperacion = 2	or idoperacion = 3 or iddestino = 2) and idseccion = $idsec and fecha between '2007/07/01' and '2007/07/31' and idoperario = $idope");
		$extpopesec = $cnx_cuzzicia->SelectLimit($q_tpopesec) or die($cnx_cuzzicia->ErrorMsg());
		$product = $extpopesec->Fields('tiempo')*$costxhra;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and fecha between '2007/07/01' and '2007/07/31' and idoperario = $idope");
		$extiopesec = $cnx_cuzzicia->SelectLimit($q_tiopesec) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts = $extiopesec->Fields('tiempo')*$costxhra;
		// consulta asignacion operarios
		$q_asigsec = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec = $cnx_cuzzicia->SelectLimit($q_asigsec) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 5 and idseccion = $idsec and fecha between '2007/07/01' and '2007/07/31' and idoperario = $idope");
		$extiopesin = $cnx_cuzzicia->SelectLimit($q_tiopesin) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct = $exqasigsec->Fields('porcent')*$costxhra*$extiopesin->Fields('tiempo');
		/*echo 'seccion '.$idsec.'  '.*//*$total[] = $product + $inproducts + $inproduct.'<br>';
		$operasec->MoveNext();
		}
	echo 'Tseccion '.$idsec.'  '.array_sum($total).'<br>';
	array_splice($total,0);
	$seccion->MoveNext();
	}
*/
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<!--<title>Untitled Document</title>-->
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
<form action="tarifaseccion.php" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
 <TR>
    <TD>Inicio de Mes </TD>
    <TD><input name="fecini" id="fecini" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></TD>
 </TR>
  <TR>
    <TD>Fin de Mes</TD>
    <TD><label>
      <input name="fecfin" id="fecfin" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
    </label></TD>
  </TR>
  <TR>
    <TD>&nbsp;</TD>
    <TD><input name="mostrar" type="submit" id="fecini_btn" value="Mostrar"></TD>
  </TR>
</table></form>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">FECHA:</td>
    <td colspan="6">DEL <?php echo $fecini; ?> AL <?php echo $fecfin; ?></td>
  </tr>
  <tr>
    <td class="KT_th">SECCION:</td>
	<td class="KT_th">MO Prod </td>
	<td class="KT_th">MO Mant+Impro </td>
	<td class="KT_th">Dep.</td>
	<td class="KT_th">Costo Total </td>
    <td class="KT_th">T. Productivo </td>
    <td class="KT_th">Tarifa Soles </td>
  </tr>
  <?php
  while (!$seccion->EOF) { 
  		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (idoperacion=1 or idoperacion=2 or idoperacion=3) and idseccion = $idsec and fecha between '$fecini' and '$fecfin'");
	$tiemsec = $cnx_cuzzicia->SelectLimit($q_tiemsec) or die($cnx_cuzzicia->ErrorMsg());
	// consulta operarios seccion
	$q_opesec = sprintf("SELECT idoperario FROM v_informes WHERE idseccion = $idsec and fecha between '$fecini' and '$fecfin' GROUP BY idoperario ORDER BY idoperario");
	$operasec = $cnx_cuzzicia->SelectLimit($q_opesec) or die($cnx_cuzzicia->ErrorMsg());
		while (!$operasec->EOF) {
		$idope = $operasec->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE mes between '$fecini' and '$fecfin' and idoperario=$idope");
		$exqcostoope = $cnx_cuzzicia->SelectLimit($q_costoope) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE fecha between '$fecini' and '$fecfin' and idoperario=$idope");
		$exqtitoope = $cnx_cuzzicia->SelectLimit($q_titoope) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra = $exqcostoope->Fields('costotal')/$exqtitoope->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (idoperacion = 1 or idoperacion = 2	or idoperacion = 3 or iddestino = 2) and idseccion = $idsec and fecha between '$fecini' and '$fecfin' and idoperario = $idope");
		$extpopesec = $cnx_cuzzicia->SelectLimit($q_tpopesec) or die($cnx_cuzzicia->ErrorMsg());
		$product = $extpopesec->Fields('tiempo')*$costxhra;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and fecha between '$fecini' and '$fecfin' and idoperario = $idope");
		$extiopesec = $cnx_cuzzicia->SelectLimit($q_tiopesec) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts = $extiopesec->Fields('tiempo')*$costxhra;
		// consulta asignacion operarios
		$q_asigsec = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec = $cnx_cuzzicia->SelectLimit($q_asigsec) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 5 and idseccion = $idsec and fecha between '$fecini' and '$fecfin' and idoperario = $idope");
		$extiopesin = $cnx_cuzzicia->SelectLimit($q_tiopesin) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct = $exqasigsec->Fields('porcent')*$costxhra*$extiopesin->Fields('tiempo');
		$totmoprod[] = $product;
		$totmoinprod[] = $inproducts + $inproduct;
		$total[] = $product + $inproducts + $inproduct;
		$operasec->MoveNext();
		}
		$q_depsec = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nºcuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) ORDER BY iddeprecia");
		$depresec = $cnx_cuzzicia->SelectLimit($q_depsec) or die($cnx_cuzzicia->ErrorMsg());
		$totalRowsdep = $depresec->RecordCount();
		while (!$depresec->EOF) {
		$fecingre = $depresec->Fields('fecingreso');
		//echo $fecingre.'---'.$fecfin;
		$q_meses = sprintf("select (DATE '$fecfin'-'$fecingre')/30 as date;");
		$excmeses = $cnx_cuzzicia->SelectLimit($q_meses) or die($cnx_cuzzicia->ErrorMsg());
		$diff = $excmeses->Fields('diff');
		if($diff<=$depresec->Fields('nºcuotas')){
			$totdep[] = $depresec->Fields('dep');
		}
		$depresec->MoveNext();
		}
?>
    <tr>
      <td><?php echo $seccion->Fields('seccion'); ?></td>
      <td align="right"><?php echo number_format(array_sum($totmoprod),2);?></td>
      <td align="right"><?php echo number_format(array_sum($totmoinprod),2);?></td>
      <td align="right"><?php if ($totalRowsdep > 0){
			echo number_format(array_sum($totdep),2);
			array_splice($totdep,0);
		}else{echo "-";} ?></td>
      <td align="right"><?php $tocosto = array_sum($total);
	  	echo number_format($tocosto, 2); ?></td>
      <td align="right"><?php $totiem = $tiemsec->Fields('tiempo');
	  	echo number_format($totiem, 2); ?></td>
      <td align="right"><?php if ($tocosto<>0 and $totiem<>''){
			$tari = $tocosto/$totiem;
		echo number_format($tari, 2);
		}else{echo "-";} ?></td>
    </tr>
    <?php
	array_splice($totmoprod,0);
	array_splice($totmoinprod,0);
	array_splice($total,0);
    $seccion->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$seccion->Close();
?>