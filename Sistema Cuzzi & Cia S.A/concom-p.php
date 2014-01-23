<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

$cprov = '0';
if (isset($_POST['prov'])) {
  $cprov = $_POST['prov'];
}
$cmate = '3';
if (isset($_POST['mate'])) {
  $cmate = $_POST['mate'];
}
$ctipo = '1';
if (isset($_POST['tipo'])) {
  $ctipo = $_POST['tipo'];
}
$ccatego = '2';
if (isset($_POST['catego'])) {
  $ccatego = $_POST['catego'];
}
$cmarcatipo = '4';
if (isset($_POST['marcatipo'])) {
  $cmarcatipo = $_POST['marcatipo'];
}
$cgramcal = '5';
if (isset($_POST['gramcal'])) {
  $cgramcal = $_POST['gramcal'];
}
$cmedi = '6';
if (isset($_POST['medi'])) {
  $cmedi = $_POST['medi'];
}
$cuni = '7';
if (isset($_POST['uni'])) {
  $cuni = $_POST['uni'];
}
$cfecini = '2002/01/01';
if (isset($_POST['fecini'])) {
  $cfecini = $_POST['fecini'];
}
$cfecfin = '2002/12/31';
if (isset($_POST['fecfin'])) {
  $cfecfin = $_POST['fecfin'];
}
$totalRows_qtotexc=0;

if ($ctipo=="-" and $ccatego=="-" and $cmate=="-" and $cmarcatipo=="-" and $cgramcal=="-" and $cmedi=="-" and $cuni=="-") {
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($ccatego=="-" and $cmate=="-" and $cmarcatipo=="-" and $cgramcal=="-" and $cmedi=="-" and $cuni=="-") {
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo='$ctipo' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo='$ctipo' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($cmate=="-" and $cmarcatipo=="-" and $cgramcal=="-" and $cmedi=="-" and $cuni=="-"){
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo='$ctipo' and categoria = '$ccatego' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo='$ctipo' and categoria = '$ccatego' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($cmarcatipo=="-" and $cgramcal=="-" and $cmedi=="-" and $cuni=="-"){
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($cgramcal=="-" and $cmedi=="-" and $cuni=="-"){
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($cmedi=="-" and $cuni=="-"){
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and gramajecalibre = '$cgramcal' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and gramajecalibre = '$cgramcal' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($cuni == "-"){
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and gramajecalibre = '$cgramcal' and medida = '$cmedi' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and gramajecalibre = '$cgramcal' and medida = '$cmedi' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}else{
$query = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,motivo,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and gramajecalibre = '$cgramcal' and medida = '$cmedi' and unidad = '$cuni' and fecha BETWEEN '$cfecini' and '$cfecfin' GROUP BY tmateriales,motivo,unidad";
$cncompras = $cnx_cuzzicia->SelectLimit($query) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(vusoles*cantidad) as soles,sum(vudolar*cantidad) as dolar FROM v_consultas WHERE movimiento='Ingreso' and tipoconsumo = '$ctipo' and categoria = '$ccatego' and materiales = '$cmate' and marcatipo = '$cmarcatipo' and gramajecalibre = '$cgramcal' and medida = '$cmedi' and unidad = '$cuni' and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
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
    <td colspan="7">MATERIALES</td>
    <td>TOTAL SOLES</td>
    <td>TOTAL DOLARES</td>
  </tr>
  <tr>
      <?php if ($totalRows_qtotexc > 0) { // Show if recordset not empty ?>
        <td><?php echo $ctipo?></td>
        <td><?php echo $ccatego?></td>
        <td><?php echo $cmate?></td>
        <td><?php echo $cmarcatipo?></td>
        <td><?php echo $cgramcal?></td>
        <td><?php echo $cmedi?></td>
        <td><?php echo $cuni?></td>
        <td align="right"><?php echo number_format($qtotexc->Fields('soles'),2); ?></td>
        <td align="right"><?php echo number_format($qtotexc->Fields('dolar'),2); ?></td>
        <?php } // Show if recordset not empty ?></tr>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr>
  <td colspan="6">DETALLES</td>
  </tr>
<tr>
  <td>MATERIALES</td>
  <td>MOTIVO</td>
  <td> CANTIDAD</td>
  <td> SOLES</td>
  <td> DOLARES</td>
  </tr>
<?php
  while (!$cncompras->EOF) { 
?>
  <tr>
    <td><?php echo $cncompras->Fields('tmateriales'); ?></td>
    <td align="right"><?php echo $cncompras->Fields('motivo'); ?></td>
    <td align="right"><?php echo $cncompras->Fields('cant'); ?></td>
    <td align="right"><?php echo number_format($cncompras->Fields('soles'),2); ?></td>
    <td align="right"><?php echo number_format($cncompras->Fields('dolar'),2); ?></td>
  </tr>
  <?php
    $cncompras->MoveNext(); 
  }
?>
</table>
</body>
</html>