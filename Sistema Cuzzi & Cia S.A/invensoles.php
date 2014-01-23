<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('tipoconsumo');

// begin Recordset
$fec__cningresos = '2006/09/30';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 

$querytotal = "SELECT sum(case when(movimiento='Ingreso') then(cantidad*vudolar) end) as itotaltd,sum(case when(movimiento='Ingreso') then(cantidad*vudolar) end)-sum(case when(movimiento='Salida') then(cantidad*vudolar) end) as totaltd,
sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end) as itotalts,sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end)-sum(case when(movimiento='Salida') then(cantidad*vusoles) end) as totalts
FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos'";
$qtotal = $cnx_cuzzicia->SelectLimit($querytotal) or die($cnx_cuzzicia->ErrorMsg());

$qcatd = "SELECT sum(case when(movimiento='Ingreso') then(cantidad*vudolar) end) as itotal1d,sum(case when(movimiento='Ingreso') then(cantidad*vudolar) end)-sum(case when(movimiento='Salida') then(cantidad*vudolar) end) as total1d,
sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end) as itotal1s,sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end)-sum(case when(movimiento='Salida') then(cantidad*vusoles) end) as total1s,tipoconsumo,categoria
FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' GROUP BY tipoconsumo,categoria ORDER BY tipoconsumo,categoria";
$qcatdex = $cnx_cuzzicia->SelectLimit($qcatd) or die($cnx_cuzzicia->ErrorMsg());
//PHP ADODB document - made with PHAkt 3.7.1
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<table class="KT_tngtable" align="center">
  <tr>
    <td colspan="4" align="center">INVENTARIO MATERIALES AL <?php echo $fec__cningresos; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <?php
  while (!$qcatdex->EOF) { 
?>
      <?php $TFM_nest = $qcatdex->Fields('tipoconsumo');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
      <tr>
        <td class="KT_th"><?php echo $qcatdex->Fields('tipoconsumo'); ?></td>
        <td class="KT_th">Valor Soles  </td>
		<td class="KT_th">Valor Dolar  </td>
		</tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td><?php echo $qcatdex->Fields('categoria'); ?></td>
        <td align="right"><?php if ($qcatdex->Fields('total1s')<>''){
		echo number_format($qcatdex->Fields('total1s'),2);
		}else{
		echo number_format($qcatdex->Fields('itotal1s'),2);}?></td>
        <td align="right"><?php if ($qcatdex->Fields('total1d')<>''){
		echo number_format($qcatdex->Fields('total1d'),2);
		}else{
		echo number_format($qcatdex->Fields('itotal1d'),2);}?></td>
      </tr>
      <?php
    $qcatdex->MoveNext(); 
  }
?>
    </table></td>
  </tr>
  <tr>
    <td align="right">TOTAL S/.</td>
    <td><?php if ($qtotal->Fields('totalts')<>''){
		echo number_format($qtotal->Fields('totalts'),2);
		}else{
		echo number_format($qtotal->Fields('itotalts'),2);}?></td>
    <td>TOTAL $.</td>
    <td><?php if ($qtotal->Fields('totaltd')<>''){
		echo number_format($qtotal->Fields('totaltd'),2);
		}else{
		echo number_format($qtotal->Fields('itotaltd'),2);}?></td>
  </tr>
</table>
</body>
</html>
