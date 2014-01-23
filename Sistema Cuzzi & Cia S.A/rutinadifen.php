<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
$fec = '2007/03/31';
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha);
	//seleccion de movimientos para su actualizacion
	$qingresoactu = "SELECT * FROM diferencias WHERE fecha = '$fec'";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());
	//actualizacion de ingresos segun material-año
	while (!$ingresact->EOF) {
	
	$material = $ingresact->Fields('idmaterial');
	$id = $ingresact->Fields('iddiferencia');
	
$query_saldos = "SELECT sum(saldo) as isaldo,sum(case when(movimiento='Ingreso') then(cantidad) end)-sum(case when(movimiento='Salida') then(cantidad) end) as saldo FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec' and idmateriales = $material";
$saldos = $cnx_cuzzicia->SelectLimit($query_saldos) or die($cnx_cuzzicia->ErrorMsg());

	if ($saldos->Fields('saldo')<>''){
		$saldo = $saldos->Fields('saldo');
		}else{$saldo = $saldos->Fields('isaldo');}

		$idin = $ingresact->Fields('idmovimiento');
		$upingresos = "UPDATE diferencias SET cantkardex = $saldo WHERE iddiferencia = $id;";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
		echo $idin."<br>";
		$ingresact->MoveNext();
	}
?>