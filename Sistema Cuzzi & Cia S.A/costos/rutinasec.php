<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

	$qingresoactu = "SELECT * FROM seccion WHERE idseccion > 1";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());

	//actualizacion de ingresos segun material-año
	while (!$ingresact->EOF) {
	$idsec = $ingresact->Fields('idseccion');
	   	$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,1);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,2);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,3);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,4);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,7);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,8);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,2,0);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,3,5);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,3,6);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());

		echo $idsec."<br>";
		$ingresact->MoveNext();
	}
?>