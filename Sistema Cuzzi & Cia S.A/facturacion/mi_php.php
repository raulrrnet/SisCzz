<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
$ord = $_POST["orden"];
// begin Recordset
$query_orden = "SELECT * FROM orden WHERE idorden=$ord ";
$orden = $cnx_cuzzicia->SelectLimit($query_orden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_orden = $orden->RecordCount();
// end Recordset
if($orden->Fields('idcliente')==53 or $orden->Fields('idorden')==0 or $orden->Fields('idorden')==1){
	echo "ok";}
else{echo "true";}
//Todo HTMl que se imprima en este archivo corresponde al valor de respuesta
//echo $_POST["orden"];
//daronwolff.blogspot.com
?>