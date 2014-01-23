<?php
//Aditional Functions
require_once('includes/functions.inc.php');

//Connection statement
require_once('Connections/cnx_cuzzicia.php');

if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha);
// and idmaterial > 285
	$query_dife = "SELECT * FROM diferencias WHERE fecha='$fec' and cantkardex<>cantreport and idmaterial <= 285 ORDER BY idmaterial;";
	$dife = $cnx_cuzzicia->SelectLimit($query_dife) or die($cnx_cuzzicia->ErrorMsg());

 while (!$dife->EOF) { 
	$material = $dife->Fields('idmaterial');
	$fecha = $dife->Fields('fecha');
	$cantkar = $dife->Fields('cantkardex');
	$cantrep = $dife->Fields('cantreport');
	$vusoles = $dife->Fields('vusoles');
	$vudolar = $dife->Fields('vudolar');
	$cant = $cantkar-$cantrep;
	$cantidad = abs($cant);
//	echo '<h1> prueba';
	if($cantkar<$cantrep){
	$insertingres = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$material,'6Ajuste','$fecha',$cantidad,$cantidad,$vusoles,$vudolar);";
	$iningreexc = $cnx_cuzzicia->Execute($insertingres) or die($cnx_cuzzicia->ErrorMsg());
	}elseif($cantkar>$cantrep){
	$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,vusoles,vudolar) VALUES ('Salida',$material,'6Ajuste','$fecha',$cantidad,$vusoles,$vudolar);";
    $invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	require('form.php');
	}
   $dife->MoveNext();
  }
  $insertGoTo = "ajustes3.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?fecha=$fec";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
  
?>