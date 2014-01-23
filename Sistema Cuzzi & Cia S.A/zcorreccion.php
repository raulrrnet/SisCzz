<?php
set_time_limit(0);
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

$qseltot = "SELECT * FROM movimientos WHERE motivo='1Saldo Inicial' and date_part('year', fecha) = 2012 ORDER BY idmaterial";
$exqseltot = $cnx_cuzzicia->Execute($qseltot) or die($cnx_cuzzicia->ErrorMsg());
while (!$exqseltot->EOF) {
$material = $exqseltot->Fields('idmaterial');
$ano = 2012;
	//seleccion de ingresos para su actualizacion
	$qingresoactu = "SELECT * FROM movimientos WHERE movimiento='Ingreso' and idmaterial = '$material' and date_part('year', fecha) = $ano;";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());
	//actualizacion de ingresos segun material-año
	while (!$ingresact->EOF) {
		$idin = $ingresact->Fields('idmovimiento');
		$canti = $ingresact->Fields('cantidad');
		$upingresos = "UPDATE movimientos SET saldo = $canti WHERE idmovimiento = $idin;";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
		$ingresact->MoveNext();
	}
	//seleccion salidas para actualizacion de salidas con nuevos valores
	$query_salidas = "SELECT * FROM movimientos WHERE movimiento='Salida' and date_part('year', fecha) = $ano and idmaterial = $material ORDER BY fecha,motivo,idmovimiento;";
	$exsalidas = $cnx_cuzzicia->Execute($query_salidas) or die($cnx_cuzzicia->ErrorMsg());
	//bucle de actualizacion
	while (!$exsalidas->EOF) {
	$idsali = $exsalidas->Fields('idmovimiento');
	$cantsali = $exsalidas->Fields('cantidad');
	$fecha = $exsalidas->Fields('fecha');
	//sel sumatoria de saldo del material
	$query_tingreso = "SELECT sum(saldo) FROM movimientos WHERE movimiento='Ingreso' and idmaterial = '$material' and fecha <= '$fecha' and date_part('year', fecha) = $ano;";
	$tingreso = $cnx_cuzzicia->Execute($query_tingreso) or die($cnx_cuzzicia->ErrorMsg());
	//sel para captar valores de ingresos
	$query_ingresos = "SELECT * FROM movimientos WHERE movimiento='Ingreso' and idmaterial = '$material' and fecha <= '$fecha' and date_part('year', fecha) = $ano ORDER BY fecha,motivo,idmovimiento;";
	$ingresos = $cnx_cuzzicia->Execute($query_ingresos) or die($cnx_cuzzicia->ErrorMsg());
	// toma de valores sumasaldos y val de ingresos
	$totingre = $tingreso->Fields('sum');
	$vtsoles=0;
	$vtdolares=0;
	$idingre = $ingresos->Fields('idmovimiento');
	$cantsaldo = $ingresos->Fields('saldo');
	$vusoles = $ingresos->Fields('vusoles');
	$vudolares = $ingresos->Fields('vudolar');
	$porconsu = $cantsali;
	$cansaltem = $cantsaldo;
	if ($porconsu > $totingre) {
	$insertGoTo = "error2.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
  	KT_redir($insertGoTo);
	} elseif($porconsu > $cansaltem) {
		while($porconsu > $cansaltem){
		$idingre = $ingresos->Fields('idmovimiento');
		$cantsaldo = $ingresos->Fields('saldo');
		$vusoles = $ingresos->Fields('vusoles');
		$vudolares = $ingresos->Fields('vudolar');
		$cansaltem = $cantsaldo;
			if($porconsu > $cansaltem){
			$porconsu = $porconsu - $cansaltem;
			$vtsoles = $vtsoles+$cansaltem*$vusoles;
			$vtdolares = $vtdolares+$cansaltem*$vudolares;
			$cansaltem = 0;
			$upingresos = "UPDATE movimientos SET saldo = 0 WHERE idmovimiento = $idingre;";
			$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
			$ingresos->MoveNext();
			}else{
			break;
			}
		}
	$cansaltem = $cansaltem - $porconsu;
	$upingresos = "UPDATE movimientos SET saldo = $cansaltem WHERE idmovimiento = $idingre;";
	$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
	$vtsoles = $vtsoles+$porconsu*$vusoles;
	$vtdolares = $vtdolares+$porconsu*$vudolares;
			if($cantsali==0){
				$vusolessali = 0;
				$vudolarsali = 0;
			}else{
			$vusolessali = $vtsoles/$cantsali;
			$vudolarsali = $vtdolares/$cantsali;
			}
	$upsalidas = "UPDATE movimientos SET vusoles=$vusolessali, vudolar=$vudolarsali WHERE idmovimiento = $idsali;";
	$upsalidasexc = $cnx_cuzzicia->Execute($upsalidas) or die($cnx_cuzzicia->ErrorMsg());
	}
	else {
	$cansaltem = $cansaltem - $porconsu;
	$upingresos = "UPDATE movimientos SET saldo = $cansaltem WHERE idmovimiento = $idingre;";
	$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
	$vtsoles = $vtsoles+$porconsu*$vusoles;
	$vtdolares = $vtdolares+$porconsu*$vudolares;
		if($cantsali==0){
			$vusolessali = 0;
			$vudolarsali = 0;
		}else{
		$vusolessali = $vtsoles/$cantsali;
		$vudolarsali = $vtdolares/$cantsali;
		}
	$upsalidas = "UPDATE movimientos SET vusoles=$vusolessali, vudolar=$vudolarsali WHERE idmovimiento = $idsali;";
	$upsalidasexc = $cnx_cuzzicia->Execute($upsalidas) or die($cnx_cuzzicia->ErrorMsg());
	}
$exsalidas->MoveNext();
}
$exqseltot->MoveNext();
echo $exqseltot->Fields('idmaterial').'<br>';
}
echo "FIN";
?>