<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

$fec = '2003/01/01';
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}
if (isset($_GET['fecha'])) {
  $fec = $_GET['fecha'];
}
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha);

// begin Recordset para validar actualizacion 
$query_cnmovimi = "SELECT * FROM movimientos WHERE motivo = '6Ajuste' and fecha='$fec'";
$cnmovimi = $cnx_cuzzicia->SelectLimit($query_cnmovimi) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnmovimi = $cnmovimi->RecordCount();
// end Recordset
if($totalRows_cnmovimi==0){
	//seleccion de diferencias para su actualizacion
	$qingresoactu = "SELECT * FROM diferencias WHERE fecha = '$fec'";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());
	//actualizacion de deferencias segun actualizacion kardex
	while (!$ingresact->EOF) {
	
	$material = $ingresact->Fields('idmaterial');
	$id = $ingresact->Fields('iddiferencia');
	
$query_saldos = "SELECT sum(saldo) as isaldo,sum(case when(movimiento='Ingreso') then(cantidad) end)-sum(case when(movimiento='Salida') then(cantidad) end) as saldo FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec' and idmateriales = $material";
$saldos = $cnx_cuzzicia->SelectLimit($query_saldos) or die($cnx_cuzzicia->ErrorMsg());

	if ($saldos->Fields('saldo')<>''){
		$saldo = $saldos->Fields('saldo');
		}elseif ($saldos->Fields('isaldo')<>''){
		$saldo = $saldos->Fields('isaldo');}
		else{$saldo = 0;}
		//$idin = $ingresact->Fields('idmovimiento');
		$upingresos = "UPDATE diferencias SET cantkardex = $saldo WHERE iddiferencia = $id;";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
		$ingresact->MoveNext();
	}
}
// begin Recordset
$query_totales = sprintf("SELECT sum(case when(cantkardex>cantreport) then((cantkardex-cantreport)*vusoles) end) as kar, sum(case when(cantkardex<cantreport) then((cantreport-cantkardex)*vusoles) end) as pla,(sum(case when(cantkardex>cantreport) then((cantkardex-cantreport)*vusoles) end)-sum(case when(cantkardex<cantreport) then((cantreport-cantkardex)*vusoles) end)) as tdif FROM diferencias WHERE fecha = '$fec' and cantkardex<>cantreport");
$totales = $cnx_cuzzicia->SelectLimit($query_totales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_totales = $totales->RecordCount();
// end Recordset

// begin Recordset
$query_cningresos = sprintf("SELECT iddiferencia,idmateriales,tipoconsumo||' / '||categoria as tipocate,
materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales,
cantkardex,cantreport,fecha,vusoles,vudolar FROM diferencias,materiales2 WHERE diferencias.idmaterial=materiales2.idmateriales and fecha = '$fec' and cantkardex<>cantreport ORDER BY responsable,tipocate,tmateriales");
$diferen = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Reporte de Diferencias</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
  <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th">REPORTE DE DIFERENCIAS</td>
    </tr>
  </table>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <?php
  while (!$diferen->EOF) { 
?>
  <?php $TFM_nest = $diferen->Fields('tipocate');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
  
  <tr>
    <td class="KT_th">Fecha Inv. </td>
    <td class="KT_th"><?php echo $diferen->Fields('tipocate'); ?></td>
    <td class="KT_th"> C. Kardex</td>
    <td class="KT_th"> C. Planta</td>
    <td class="KT_th">C. +</td>
    <td class="KT_th">C. -</td>
    <td class="KT_th">V. +</td>
    <td class="KT_th">V. -</td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
  <tr>
    <td><?php echo $fec; ?></td>
    <td><?php echo $diferen->Fields('tmateriales'); ?></td>
    <td align="right"><?php echo number_format($diferen->Fields('cantkardex'),2); ?></td>
    <td align="right"><?php echo number_format($diferen->Fields('cantreport'),2); ?></td>
    <td align="right"><?php if ($diferen->Fields('cantreport') > $diferen->Fields('cantkardex')){
		$posi = $diferen->Fields('cantreport') - $diferen->Fields('cantkardex');
		echo number_format($posi,2);
		}else{echo "-";}?></td>
    <td align="right"><?php if ($diferen->Fields('cantreport') < $diferen->Fields('cantkardex')){
		$nega = $diferen->Fields('cantkardex') - $diferen->Fields('cantreport');
		echo number_format($nega,2);
		}else{echo "-";}?></td>
    <td align="right"><?php if ($diferen->Fields('cantreport') > $diferen->Fields('cantkardex')){
		$vposi = $diferen->Fields('vusoles') * $posi;
		echo number_format($vposi, 2);
		}else{echo "-";}?></td>
    <td align="right"><?php if ($diferen->Fields('cantreport') < $diferen->Fields('cantkardex')){
		$vnega = $diferen->Fields('vusoles') * $nega;
		echo number_format($vnega, 2);
		}else{echo "-";}?></td>
    <td align="right"><a href="costos/elimina.php?fecha=<?php echo $fec;?>&tabla=diferencias&idtabla=iddiferencia&goto=../repodife2.php&id=<?php echo $diferen->Fields('iddiferencia');?>">ELIMINAR</a></td>
  </tr>
  <?php
    $diferen->MoveNext(); 
  }
?>
</table>
<table width="25%" align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td>TOTAL + </td>
    <td align="right"><?php echo number_format($totales->Fields('pla'),2); ?></td>
  </tr>
  <tr>
    <td>TOTAL - </td>
    <td align="right"><?php echo number_format($totales->Fields('kar'),2); ?></td>
  </tr>
  <tr>
    <td>DIF. INVENT. </td>
    <td align="right"><?php echo number_format($totales->Fields('pla')-$totales->Fields('kar'),2); ?></td>
  </tr>
</table>
<script language="JavaScript" type="text/JavaScript">
function bloqueo(){
	document.form1.btnajustes.disabled = true;
	document.form1.btnajustes.value = "Procesando ...";
	return true
}
</script>
<form action="ajustes2.php" method="post" name="form1" onSubmit="return bloqueo();">
  <label>
  <div align="center">
    <input name="fecha" type="hidden" id="fecha" value="<?php echo $fec; ?>">
    <input name="btnajustes" type="submit" id="btnajustes" value="Ingresar Ajustes">
  </div>
  </label>
</form>
</body>
</html>
<?php
$cnmovimi->Close();
?>