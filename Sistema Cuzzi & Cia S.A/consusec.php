<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

// begin Recordset
$seccion = '11111';
if (isset($_POST['seccion'])) {
  $seccion = $_POST['seccion'];
}
$fecini = '2003/01/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$fecfin = '2003/01/01';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
if ($seccion == "-"){
$query_consuor = sprintf("SELECT sum(cantidad*vusoles) as soles,sum(cantidad*vudolar) as dolar FROM v_consultas WHERE movimiento='Salida' and idorden=0 and idseccion<>0 and fecha BETWEEN '$fecini' and '$fecfin'");
$consuor = $cnx_cuzzicia->SelectLimit($query_consuor) or die($cnx_cuzzicia->ErrorMsg());
$query_cningresos = "SELECT seccion as tmateriales,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Salida' and idorden=0 and idseccion<>0 and fecha BETWEEN '$fecini' and '$fecfin' GROUP BY tmateriales ORDER BY tmateriales";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
}else{
$query_consuor = sprintf("SELECT sum(cantidad*vusoles) as soles,sum(cantidad*vudolar) as dolar FROM v_consultas WHERE movimiento='Salida' and idseccion=$seccion and fecha BETWEEN '$fecini' and '$fecfin'");
$consuor = $cnx_cuzzicia->SelectLimit($query_consuor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_consuor = $consuor->RecordCount();
$query_cningresos = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Salida' and idseccion=$seccion and fecha BETWEEN '$fecini' and '$fecfin' GROUP BY tmateriales,unidad ORDER BY tmateriales,unidad";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
}
//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Untitled Document</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr>
  <td colspan="3"><strong>CONSUMOS POR SECCION DEL <?php echo $fecini; ?> AL <?php echo $fecfin; ?></strong></td>
  </tr>
<tr>
  <td>SECCION</td>
  <td>CONSUMO SOLES</td>
  <td>CONSUMO DOLARES</td>
</tr>
<tr>
  <td><?php echo $seccion; ?></td>
  <td align="right"><?php echo round($consuor->Fields('soles'),2); ?></td>
  <td align="right"><?php echo round($consuor->Fields('dolar'),2); ?></td>
</tr>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td>MATERIALES</td>
    <td> CANTIDAD</td>
    <td>C. SOLES</td>
    <td>C. DOLARES</td>
  </tr>
  <?php
  while (!$cningresos->EOF) { 
?>
  <tr>
    <td><?php echo $cningresos->Fields('tmateriales'); ?></td>
    <td align="right"><?php 
	$canti = $cningresos->Fields('cant');
	if($canti<>0){ echo $cningresos->Fields('cant'); }
	else{echo '-';}?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('soles'),2); ?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('dolar'),2); ?></td>
  </tr>
  <?php
    $cningresos->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$consuor->Close();
?>