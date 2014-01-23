<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

$query_temsalida = "SELECT * FROM vtemsalida where año = 2006 and id>13636 ORDER BY idmaterial,fecha,motivo,id;";
$temsalida = $cnx_cuzzicia->Execute($query_temsalida) or die($cnx_cuzzicia->ErrorMsg());

//	$i = 1;
//	while ($i <= 1100) {
while (!$temsalida->EOF) {

	$año = $temsalida->Fields('año');
	$id = $temsalida->Fields('id');
	$material = $temsalida->Fields('idmaterial');
	$motivo = $temsalida->Fields('motivo');
	$orden = $temsalida->Fields('idorden');
	$seccion = $temsalida->Fields('idseccion');
	$fecha = $temsalida->Fields('fecha');
	$cantsali = $temsalida->Fields('cantidad');

$query_tingreso = "SELECT sum(cantsaldo) FROM vingresos WHERE idmateriales = '$material' and fecha <= '$fecha' and año = '$año';";
$tingreso = $cnx_cuzzicia->Execute($query_tingreso) or die($cnx_cuzzicia->ErrorMsg());

$query_ingresos = "SELECT * FROM vingresos WHERE idmateriales = '$material' and fecha <= '$fecha' and año = '$año' ORDER BY fecha,motivo,idingreso;";
$ingresos = $cnx_cuzzicia->Execute($query_ingresos) or die($cnx_cuzzicia->ErrorMsg());
	
	$totingre = $tingreso->Fields('sum');

	$vtsoles=0;
	$vtdolares=0;
	
	$idingre = $ingresos->Fields('idingreso');
	$cantsaldo = $ingresos->Fields('cantsaldo');
	$vusoles = $ingresos->Fields('valorusoles');
	$vudolares = $ingresos->Fields('valorudolar');
	
	$porconsu = $cantsali;
	$cansaltem = $cantsaldo;
	
	if ($porconsu > $totingre) {
	echo $temsalida->Fields('id')." no es posible realizar transaccion"."<br>";
	} elseif($porconsu > $cansaltem) {
		while($porconsu > $cansaltem){
		$idingre = $ingresos->Fields('idingreso');
		$cantsaldo = $ingresos->Fields('cantsaldo');
		$vusoles = $ingresos->Fields('valorusoles');
		$vudolares = $ingresos->Fields('valorudolar');
		$cansaltem = $cantsaldo;
			if($porconsu > $cansaltem){
			$porconsu = $porconsu - $cansaltem;
			$vtsoles = $vtsoles+$cansaltem*$vusoles;
			$vtdolares = $vtdolares+$cansaltem*$vudolares;
			$cansaltem = 0;
			$upingresos = "UPDATE ingresos SET cantsaldo = 0 WHERE idingreso = $idingre;";
			$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
			$ingresos->MoveNext();
			}else{
			break;
			}
		}
		$cansaltem = $cansaltem - $porconsu;
		$upingresos = "UPDATE ingresos SET cantsaldo = $cansaltem WHERE idingreso = $idingre;";
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
		$insvasal = "INSERT INTO salidas (idsalida,idmaterial,motivo,fecha,idorden,idseccion,cantidad,valorusoles,valorudolar) VALUES ($id, $material,'$motivo','$fecha',$orden,$seccion,$cantsali,$vusolessali,$vudolarsali);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
		echo $temsalida->Fields('id')." while insert ok"."<br>";
	} else {
	$cansaltem = $cansaltem - $porconsu;
	$upingresos = "UPDATE ingresos SET cantsaldo = $cansaltem WHERE idingreso = $idingre;";
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
	$insvasal = "INSERT INTO salidas (idsalida,idmaterial,motivo,fecha,idorden,idseccion,cantidad,valorusoles,valorudolar) VALUES ($id, $material,'$motivo','$fecha',$orden,$seccion,$cantsali,$vusolessali,$vudolarsali);";
	$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	echo $temsalida->Fields('id')." insert ok"."<br>";
	}
$temsalida->MoveNext();
//	$i++;	
	}
echo "<h1>transaccion terminada satisfactoriamente</h1>";
?>