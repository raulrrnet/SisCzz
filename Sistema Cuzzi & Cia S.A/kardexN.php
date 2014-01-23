<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

// begin Recordset
$fec__cningresos = '2012/12/31';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT * FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' ORDER BY idtipoconsumo,categoria,materiales,idmateriales,fecha,motivo,idmovimiento");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$unisal=0;
$sa=0;
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
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <?php
  while (!$cnkardex->EOF) { 
?>
  <?php $TFM_nest = $cnkardex->Fields('idmateriales');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
	$unisal=0;
	$sa=0; ?>
<tr>
  <td colspan="4" class="KT_th">PERIODO:</td>
  <td colspan="10"><?php echo $ano; ?></td>
</tr>
<tr>
  <td colspan="4" class="KT_th">RUC:</td>
  <td>20100186765</td>
  <td colspan="3" class="KT_th">RAZON SOCIAL:</td>
  <td colspan="6">CUZZI Y CIA S.A.</td>
</tr>
<tr>
  <td colspan="4" class="KT_th">ESTABLECIMIENTO:</td>
  <td colspan="10">CASA MATRIZ</td>
</tr>
<tr>
  <td colspan="4" class="KT_th">CODIGO EXISTENCIA:</td>
  <td>&nbsp;</td>
  <td colspan="3" class="KT_th">TIPO:</td>
  <td colspan="6">03 MATERIAS PRIMAS Y AUXILIARES - MATERIALES</td>
</tr>
<tr>
  <td colspan="4" class="KT_th">DESCRIPCION:</td>
  <td colspan="10"><?php echo $cnkardex->Fields('tipoconsumo'); ?> / <?php echo $cnkardex->Fields('categoria'); ?> / <?php echo $cnkardex->Fields('materiales'); ?> / <?php echo $cnkardex->Fields('marcatipo'); ?> / <?php echo $cnkardex->Fields('gramajecalibre'); ?> / <?php echo $cnkardex->Fields('medida'); ?></td>
</tr>
<tr>
  <td colspan="4" class="KT_th">UNIDAD DE MEDIDA</td>
  <td><?php echo $cnkardex->Fields('unidad'); ?></td>
  <td colspan="3" class="KT_th">METODO VALUACION</td>
  <td colspan="6">PEPS</td>
</tr>
<tr>
  <td colspan="4" class="KT_th">DOCUMENTO / COMPROBANTE</td>
  <td class="KT_th">TIPO</td>
  <td colspan="3" class="KT_th"><div align="center">ENTRADAS</div></td>
  <td colspan="3" class="KT_th"><div align="center">SALIDAS</div></td>
  <td colspan="3" class="KT_th"><div align="center">SALDO FINAL</div></td>
</tr>
<tr>
  <td class="KT_th">FECHA</td>
  <td class="KT_th">TIPO</td>
  <td class="KT_th">SERIE</td>
  <td class="KT_th">NUMERO</td>
  <td align="center" class="KT_th">OPERACION</td>
  <td class="KT_th">CANTIDAD</td>
  <td class="KT_th">COSTOU</td>
  <td class="KT_th">COSTOT</td>
  <td class="KT_th">CANTIDAD</td>
  <td class="KT_th">COSTOU</td>
  <td class="KT_th">COSTOT</td>
  <td class="KT_th">CANTIDAD</td>
  <td class="KT_th">COSTOU</td>
  <td class="KT_th">COSTOT</td>
</tr>
<?php } //End of Basic-UltraDev Simulated Nested Repeat?>
<tr>
  <td><?php echo $cnkardex->Fields('fecha'); ?></td>
  <td><?php echo $cnkardex->Fields('tipodoc'); ?></td>
  <td><?php echo $cnkardex->Fields('serie'); ?></td>
  <td><?php if ($cnkardex->Fields('motivo')=='2Compra' or $cnkardex->Fields('motivo')=='2Devolucion'){
		echo $cnkardex->Fields('referencia');
		}else{echo "-";}?></td>
  <td><?php echo $cnkardex->Fields('tipoope'); ?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$cantin=$cnkardex->Fields('cantidad');
		echo $cantin;
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$sol=$cnkardex->Fields('vusoles');
		echo number_format($sol, 2);
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$vain=($cantin*$sol);
		echo number_format($vain, 2);
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Salida'){
		$cantsa=$cnkardex->Fields('cantidad');
		echo $cantsa;
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Salida'){
		$sol=$cnkardex->Fields('vusoles');
		echo number_format($sol, 2);
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Salida'){
		$vasa=($cantsa*$sol);
		echo number_format($vasa, 2);
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$unisal=$cantin+$unisal;
		echo number_format($unisal,2);
		}else{$unisal=$unisal-$cantsa;
		echo number_format($unisal,2);}?></td>
  <td align="right"><?php if ($cnkardex->Fields('vusoles')<>''){
		$sol=$cnkardex->Fields('vusoles');
		echo number_format($sol, 2);
		}else{echo "-";}?></td>
  <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$sa=($cantin*$sol)+$sa;
		echo number_format($sa, 2);
		}else{$sa=$sa-($cantsa*$sol);
		echo number_format($sa, 2);}?></td>
</tr>
<?php
    $cnkardex->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$cnkardex->Close();
?>