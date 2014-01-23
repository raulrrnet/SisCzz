<?php
//Aditional Functions
require_once('includes/functions.inc.php');

//Connection statement
require_once('Connections/cnx_cuzzicia.php');

$query_ajustes = "SELECT * FROM ajustes WHERE date_part('year',fecha)=2006 ORDER BY idmateriales;";
$ajustes = $cnx_cuzzicia->SelectLimit($query_ajustes) or die($cnx_cuzzicia->ErrorMsg());

 while (!$ajustes->EOF) { 

	$material = $ajustes->Fields('idmateriales');
	$fecha = $ajustes->Fields('fecha');
	$id = $ajustes->Fields('id');
	$motivo = $ajustes->Fields('motivo');
	$cant = $ajustes->Fields('cantidad');
	$cantsaldo = $ajustes->Fields('catsaldo');

	$query_ingresos = "SELECT * FROM ingresos WHERE idmateriales = '$material' and fecha <= '$fecha' and date_part('year',fecha)=2006 ORDER BY fecha DESC";
	$selingreexc = $cnx_cuzzicia->SelectLimit($query_ingresos) or die($cnx_cuzzicia->ErrorMsg());

	$valorsoles = $selingreexc->Fields('valorusoles');
	$valordolares = $selingreexc->Fields('valorudolar');

	$insertingres = "INSERT INTO ingresos (idmateriales,motivo,fecha,cantidad,valorusoles,valorudolar,cantsaldo) VALUES ($material,'6Ajuste','$fecha',$cant,$valorsoles,$valordolares,$cantsaldo)";
	$iningreexc = $cnx_cuzzicia->Execute($insertingres) or die($cnx_cuzzicia->ErrorMsg());

$ajustes->MoveNext(); 
echo "ok".$id."<br>";
}
echo "<h1>transaccion terminada satisfactoriamente</h1>";
?>