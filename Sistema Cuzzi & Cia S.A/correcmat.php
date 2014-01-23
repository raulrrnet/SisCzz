<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

	//seleccion de movimientos para su actualizacion
	$qingresoactu = "SELECT * FROM movimientos WHERE idmaterial = 32";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());
	//actualizacion de ingresos segun material-año
	while (!$ingresact->EOF) {
		$idin = $ingresact->Fields('idmovimiento');
		$upingresos = "UPDATE movimientos SET idmaterial = 31 WHERE idmovimiento = $idin;";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
		echo $idin."<br>";
		$ingresact->MoveNext();
	}
?>