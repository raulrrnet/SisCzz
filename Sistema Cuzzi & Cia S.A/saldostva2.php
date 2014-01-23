<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

// begin Recordset
$fec__cningresos = '2002/01/01';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT idmateriales,responsable,sum(saldo) as isaldo,sum(case when(movimiento='Ingreso') then(cantidad) end)-sum(case when(movimiento='Salida') then(cantidad) end) as saldo,tipoconsumo||' / '||categoria as tipocate, materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales FROM v_consultas WHERE fecha <= '$fec__cningresos' and date_part('year', fecha) = $ano GROUP BY idmateriales,responsable,tipocate,tmateriales ORDER BY responsable,tipocate,tmateriales");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

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
<table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center">RESUMEN SALDOS AL <?php echo $fec__cningresos; ?></td>
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
        <td class="KT_th"><?php echo $cnkardex->Fields('responsable'); ?></td>
        <td class="KT_th"><?php echo $cnkardex->Fields('tipocate'); ?></td>
        <td class="KT_th">Saldo</td>
        <td class="KT_th">Diferencias</td>
      </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td align="center">&quot;</td>
        <td><?php echo $cnkardex->Fields('tmateriales'); ?></td>
        <td align="right"><?php if ($cnkardex->Fields('saldo')<>''){
		echo number_format($cnkardex->Fields('saldo'),2);
		}else{
		echo number_format($cnkardex->Fields('isaldo'),2);}?></td>
        <td><a href="diferencias.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmateriales=" . urlencode($cnkardex->Fields('idmateriales')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "saldo=" . urlencode($cnkardex->Fields('saldo')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "isaldo=" . urlencode($cnkardex->Fields('isaldo')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "fecha=" . urlencode($fec__cningresos) ?>">Ingresar Diferencia</a></td>
      </tr>
      <?php
    $cnkardex->MoveNext(); 
  }
?>
    </table></td>
  </tr>
</table>
</body>
</html>