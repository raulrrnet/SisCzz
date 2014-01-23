<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

// begin Recordset
$fec__cningresos = '2006/12/30';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 

$query_cningresos = sprintf("SELECT sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end) as itotal,sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end)-sum(case when(movimiento='Salida') then(cantidad*vusoles) end) as total,sum(case when(movimiento='Ingreso') then(cantidad) end) as isaldo,sum(case when(movimiento='Ingreso') then(cantidad) end)-sum(case when(movimiento='Salida') then(cantidad) end) as saldo,idmateriales, materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales,tipoconsumo||' / '||categoria as tipocate FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' GROUP BY idmateriales,tipocate,tmateriales ORDER BY tipocate,idmateriales");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$querytotal = sprintf("SELECT sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end) as itotal,sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end)-sum(case when(movimiento='Salida') then(cantidad*vusoles) end) as total
FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos'");
$qtotal = $cnx_cuzzicia->SelectLimit($querytotal) or die($cnx_cuzzicia->ErrorMsg());
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
    <td colspan="2" align="center">RESUMEN SALDOS  AL <?php echo $fec__cningresos; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <?php
  while (!$cnkardex->EOF) { 
?>
      <?php $TFM_nest = $cnkardex->Fields('tipocate');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
      <tr>
        <td class="KT_th"><?php echo $cnkardex->Fields('tipocate'); ?></td>
        <td class="KT_th">Saldo</td>
        <td class="KT_th">Total Valor </td>
      </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td><?php echo $cnkardex->Fields('tmateriales'); ?></td>
        <td align="right"><?php if ($cnkardex->Fields('saldo')<>''){
		echo number_format($cnkardex->Fields('saldo'),2);
		}else{
		echo number_format($cnkardex->Fields('isaldo'),2);}?></td>
        <td align="right"><?php if ($cnkardex->Fields('total')<>''){
		echo number_format($cnkardex->Fields('total'),2);
		}else{
		echo number_format($cnkardex->Fields('itotal'),2);}?></td>
      </tr>
      <?php
    $cnkardex->MoveNext(); 
  }
?>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">S/.</td>
    <td><?php if ($qtotal->Fields('total')<>''){
		echo number_format($qtotal->Fields('total'),2);
		}else{
		echo number_format($qtotal->Fields('itotal'),2);}?></td>
  </tr>
</table>
</body>
</html>
