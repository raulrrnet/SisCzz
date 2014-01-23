<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$fec__cningresos = '2003/05/20';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha);
$mat__cnkardex = '45';
if (isset($_POST['idmat'])) {
  $mat__cnkardex = $_POST['idmat'];
}
$query_cnkardex = sprintf("SELECT * FROM v_consultas WHERE idmateriales = $mat__cnkardex and date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' ORDER BY fecha,motivo,idmovimiento");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

// rebuild the query string by replacing pageNum and totalRows with the new values
$queryString_cnkardex = KT_removeParam("&" . @$_SERVER['QUERY_STRING'], "pageNum_cnkardex");
$queryString_cnkardex = KT_replaceParam($queryString_cnkardex, "totalRows_cnkardex", $totalRows_cnkardex);

$unisal=0;
$sa=0;
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
    <td colspan="2" class="KT_th">MATERIAL:</td>
    <td colspan="10"><?php echo $cnkardex->Fields('tipoconsumo'); ?> / <?php echo $cnkardex->Fields('categoria'); ?> / <?php echo $cnkardex->Fields('materiales'); ?> / <?php echo $cnkardex->Fields('marcatipo'); ?> / <?php echo $cnkardex->Fields('gramajecalibre'); ?> / <?php echo $cnkardex->Fields('medida'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">UNIDAD DE MEDIDA</td>
    <td colspan="3"><?php echo $cnkardex->Fields('unidad'); ?></td>
    <td colspan="3" class="KT_th"><div align="center">CANTIDAD UNIDADES</div></td>
    <td colspan="2" class="KT_th"><div align="center">COSTOS UNITARIOS</div></td>
    <td colspan="3" class="KT_th"><div align="center">VALORES</div></td>
  </tr>
  <tr>
    <td class="KT_th">FECHA</td>
	<td class="KT_th">MOTIVO</td>
	<td class="KT_th">REFERENCIA</td>
    <td class="KT_th">PROVEEDOR</td>
    <td class="KT_th">ORDEN / SECCION</td>
    <td class="KT_th">ENTRADAS</td>
    <td class="KT_th">SALIDAS</td>
    <td class="KT_th">SALDO</td>
    <td class="KT_th">COSTO S/.</td>
    <td class="KT_th">COSTO $</td>
    <td class="KT_th">ENTRADA</td>
    <td class="KT_th">SALIDA</td>
    <td class="KT_th">SALDO</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('fecha'); ?></td>
	<td><?php echo $cnkardex->Fields('motivo');?></td>
	<td><?php if ($cnkardex->Fields('motivo')=='2Compra' or $cnkardex->Fields('motivo')=='2Devolucion'){
		echo $cnkardex->Fields('referencia');
		}else{echo "-";}?></td>
    <td><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		echo $cnkardex->Fields('proveedor');
		}else{echo "-";}?></td>
    <td><?php if ($cnkardex->Fields('movimiento')=='Salida'){
		if($cnkardex->Fields('seccion')=='-Ninguna-'){
		echo $cnkardex->Fields('idorden');
		}else{echo $cnkardex->Fields('seccion');}
        }else{echo "-";}?></td>
    <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$cantin=$cnkardex->Fields('cantidad');
		echo $cantin;
		}else{echo "-";}?></td>
    <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Salida'){
		$cantsa=$cnkardex->Fields('cantidad');
		echo $cantsa;
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
    <td align="right"><?php if ($cnkardex->Fields('vudolar')<>''){
		$dol=$cnkardex->Fields('vudolar');
		echo number_format($dol, 2);
		}else{echo "-";}?>    </td>
    <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Ingreso'){
		$vain=($cantin*$sol);
		echo number_format($vain, 2);
		}else{echo "-";}?></td>
    <td align="right"><?php if ($cnkardex->Fields('movimiento')=='Salida'){
		$vasa=($cantsa*$sol);
		echo number_format($vasa, 2);
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