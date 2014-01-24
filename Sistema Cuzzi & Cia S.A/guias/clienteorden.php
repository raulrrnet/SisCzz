<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_ord = "SELECT idorden,min(descripcion) FROM salidaal s,detsalidaal d WHERE  s.idsalida=d.idsalidaal and estado<>'anulada' and idmotivo=2 GROUP BY idorden ORDER BY idorden";
$ord = $cnx_cuzzicia->SelectLimit($query_ord) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_ord = $ord->RecordCount();
// end Recordset
$orden[] = 0;
$orden[] = 0;
$arr[] = "CLIENTE";
$select = "";
$select2 = "";
$select3 = "";
while (!$ord->EOF) {
	$idord = $ord->Fields('idorden');
	$orden[] = $ord->Fields('idorden');
	$arr[] = $idord .'<br>'.$ord->Fields('min');
	$select .= ",sum(case when idorden='$idord' then cantidad end) ";
	$select2 .= ",sum(case when idorden='$idord' then cantprod end) ";
	$select3 .= ",sum(case when idorden='$idord' then cantidad end) ";
  $ord->MoveNext(); 
}
$query_rep = "SELECT c.idcliente,cliente".$select."FROM salidaal s,detsalidaal d,clientes c WHERE s.idsalida = d.idsalidaal AND s.idcliente = c.idcliente and estado<>'anulada' and (idmotivo=2 or idmotivo=5) GROUP BY c.idcliente,cliente ORDER BY cliente";
$Recordrep = $cnx_cuzzicia->SelectLimit($query_rep) or die($cnx_cuzzicia->ErrorMsg());
//echo $query_rep;

$query_cu = "SELECT 0".$select2."FROM orden";
$Recordcu = $cnx_cuzzicia->SelectLimit($query_cu) or die($cnx_cuzzicia->ErrorMsg());
//echo $query_cu;
$query_sa = "SELECT 0".$select3."FROM salidaal s,detsalidaal d WHERE  s.idsalida=d.idsalidaal and idmotivo=2 AND estado<>'anulada'";
$Recordsa = $cnx_cuzzicia->SelectLimit($query_sa) or die($cnx_cuzzicia->ErrorMsg());
//echo $query_sa;

 $pgsql_conn = pg_connect("host=192.168.1.55 port=5432 dbname=cuzzi user=postgres password=cd231285");
 $results = pg_query($pgsql_conn, "$query_rep");
 $totalCols_ord = pg_num_fields($results);
// echo $totalCols_ord;
$arr[] = "TOTAL";
$tarr = count($arr);
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Stock Cuzzi Editores</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.cdiv2 {
	height: auto;
	width: 70px;
	overflow:no;
	white-space:normal
}
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr align='center'>
<?php
  $i = pg_num_fields($results);
  for ($j = 0; $j < $tarr; $j++) {
	echo "<td><div class='cdiv2'>";
      echo $arr[$j];
	echo "</div></td>";
  }
?>
</tr>
<?php
$ttar = 0;
$tah=0;
while ($reg = pg_fetch_array($results, null, PGSQL_NUM)) {
$idcli = $reg[0];
echo "<tr align='right'>";
	for($y=1;$y<$totalCols_ord;$y++){
	echo  "<td>";
	$idord = $orden[$y];
if($idcli == 114){
$qf = "SELECT round(sum(case when und='Mill' then (cantidad * 1000) else cantidad end)) as scant FROM factura f, detallefact d WHERE f.idfact=d.idfact and f.idcliente not in (SELECT idcliente FROM salidaal WHERE idcliente<>114 and estado<>'anulada' GROUP BY idcliente) and d.idorden=$idord and estado<>'anulada'";
$datorden = $cnx_cuzzicia->SelectLimit($qf) or die($cnx_cuzzicia->ErrorMsg());
}else{
$qf = "SELECT round(sum(case when und='Mill' then (cantidad * 1000) else cantidad end)) as scant FROM factura f, detallefact d WHERE f.idfact=d.idfact and f.idcliente=$idcli and d.idorden=$idord and estado<>'anulada'";
$datorden = $cnx_cuzzicia->SelectLimit($qf) or die($cnx_cuzzicia->ErrorMsg());
}
$cfact = $datorden->Fields('scant');
	if(is_numeric($reg[$y])){$tah+=$reg[$y]-$cfact; $var[$y][]=$reg[$y]-$cfact; echo $reg[$y]-$cfact;}else{$tah+=$reg[$y]; $var[$y][]=$reg[$y]; echo $reg[$y];}
	echo  "</td>";
	}
	echo "<td>".$tah."</td>";
	$tah=0;
echo "</tr>";
}
?>
<tr align='right'>
<td>Cuzzi</td>
<?php
$tch=0;
$c=2;////-----////
for($y=1;$y<$totalCols_ord-1;$y++){
$tch+=$Recordcu->Fields($y)-$Recordsa->Fields($y); $var[$c][]=$Recordcu->Fields($y)-$Recordsa->Fields($y); echo "<td>".($Recordcu->Fields($y)-$Recordsa->Fields($y))."</td>";
$c++;
}
echo "<td>".$tch."</td>";
?>
</tr>
<tr align='right' class="MXW_disabled">
<td>TOTAL:</td>
<?php
$tt=0;
for($y=2;$y<$totalCols_ord;$y++){////-----////
$tt+= array_sum($var[$y]); echo "<td>".array_sum($var[$y])."</td>";
}
?>
<td><?php echo $tt; ?></td>
</tr>
</table>
</body>
</html>
<?php
$ord->Close();
?>
