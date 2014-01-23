<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

$qmateri = "SELECT * FROM orden order by idorden desc;";
$materiexc = $cnx_cuzzicia->Execute($qmateri) or die($cnx_cuzzicia->ErrorMsg());
while(!$materiexc->EOF) {
	$qingresoactu = "SELECT * FROM pruebas order by id desc";
	$ingresact = $cnx_cuzzicia->Execute($qingresoactu) or die($cnx_cuzzicia->ErrorMsg());

	$id = $materiexc->Fields('id');  
	$idin = $ingresact->Fields('idorden');

	if($id<>$idin){
		$upingresos = "INSERT INTO orden (idorden) VALUES ($idin)";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
	}else{
	$ingresact->MoveNext();
	$materiexc->MoveNext();
	}
echo $id."<br>";
}
echo "todo ok";
?>