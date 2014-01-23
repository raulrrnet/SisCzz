<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

// begin Recordset
$fec__cningresos = '2006/11/20';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT * FROM v_devoluciones WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' ORDER BY idmateriales,fecha,iddevolucion");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<table width="80%" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <?php
  while (!$cnkardex->EOF) { 
?>
  <?php $TFM_nest = $cnkardex->Fields('idmateriales');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
	$tso=0;
	$tdo=0; ?>
	<tr>
		<td colspan="2" class="KT_th">MATERIAL:</td>
		<td colspan="10"><?php echo $cnkardex->Fields('tipoconsumo'); ?> / <?php echo $cnkardex->Fields('categoria'); ?> / <?php echo $cnkardex->Fields('materiales'); ?> / <?php echo $cnkardex->Fields('marcatipo'); ?> / <?php echo $cnkardex->Fields('gramajecalibre'); ?> / <?php echo $cnkardex->Fields('medida'); ?> </td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">UNIDAD DE MEDIDA:</td>
    <td colspan="2"><?php echo $cnkardex->Fields('unidad'); ?></td>
    <td class="KT_th">CANT. UNIDADES </td>
    <td colspan="2" class="KT_th"><div align="center">COSTOS UNITARIOS</div></td>
    <td colspan="2" class="KT_th"><div align="center">
      <p>VALORES TOTALES </p>
      </div></td>
  </tr>
  <tr>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">DESTINO</td>
	<td class="KT_th">REFERENCIA</td>
	<td class="KT_th">PROVEEDOR</td>
    <td class="KT_th">CANTIDAD</td>
    <td class="KT_th">COSTO S/.</td>
    <td class="KT_th">COSTO $</td>
    <td class="KT_th">TOTAL S/. </td>
    <td class="KT_th">TOTAL $ </td>
   </tr>
   <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
   <tr>
     <td><?php echo $cnkardex->Fields('fecha'); ?></td>
     <td><?php echo $cnkardex->Fields('destino');?></td>
     <td><?php echo $cnkardex->Fields('referencia');?></td>
     <td><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		echo $cnkardex->Fields('proveedor');
		}else{echo "-";}?>     </td>
     <td><?php $cant=$cnkardex->Fields('cantidad');
	 	echo number_format($cant, 2);?></td>
     <td align="right"><?php $sol=$cnkardex->Fields('vusoles');
		echo number_format($sol, 2);?></td>
     <td align="right"><?php $dol=$cnkardex->Fields('vudolar');
		echo number_format($dol, 2);?></td>
     <td align="right"><?php
	 $tso=($cant*$sol)+$tso;
	 echo number_format($tso, 2);?>     </td>
     <td align="right"><?php
	 $tdo=($cant*$dol)+$tdo;
	 echo number_format($tdo, 2);
	?></td>
    </tr>
<?php
    $cnkardex->MoveNext(); 
  }
?>
</table>
</body>
</html>
