<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

	//seleccion de movimientos para su actualizacion
	$qingresoactu = "SELECT * FROM infotiempo WHERE fecha >= '2007/05/01'";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());
	//actualizacion de ingresos segun material-año
	while (!$ingresact->EOF) {
		$idin = $ingresact->Fields('idinforme');
		$upingresos = "UPDATE infotiempo SET idcalen = 1 WHERE idinforme = $idin;";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
		echo $idin."<br>";
		$ingresact->MoveNext();
	}
?>