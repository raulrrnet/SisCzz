<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

// begin Recordset
$fec__cningresos = '2012/12/31';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 

$query_cningresos = sprintf("SELECT sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end) as itotal,sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end)-sum(case when(movimiento='Salida') then(cantidad*vusoles) end) as total,sum(case when(movimiento='Ingreso') then(cantidad) end) as isaldo,sum(case when(movimiento='Ingreso') then(cantidad) end)-sum(case when(movimiento='Salida') then(cantidad) end) as saldo,idmateriales, materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,unidad,tipoconsumo||' / '||categoria as tipocate FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' GROUP BY idmateriales,tipocate,tmateriales,unidad ORDER BY tipocate,idmateriales");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$querytotal = sprintf("SELECT sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end) as itotal,sum(case when(movimiento='Ingreso') then(cantidad*vusoles) end)-sum(case when(movimiento='Salida') then(cantidad*vusoles) end) as total
FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos'");
$qtotal = $cnx_cuzzicia->SelectLimit($querytotal) or die($cnx_cuzzicia->ErrorMsg());
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<table class="KT_tngtable" align="center">
  <tr>
    <td colspan="2">LIBRO DE INVENTARIOS Y BALANCES<br>DETALLE DEL SALDO DE LA CUENTA 24 - MATERIAS PRIMAS<br>
      PERIODO/EJERCICIO: <?php echo $ano; ?><br>
      RUC: 20100186765<br>
      RAZON SOCIAL: CUZZI Y CIA S.A. </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td class="KT_th">Cod.<br>Existencia </td>
        <td class="KT_th">T. Existencia</td>
        <td class="KT_th">Descripci&oacute;n</td>
        <td class="KT_th">Unidad</td>
        <td class="KT_th">Cantidad</td>
        <td class="KT_th">C. Unitario </td>
        <td class="KT_th">C. Total </td>
      </tr>
      <?php
  while (!$cnkardex->EOF) { 
?>
      <tr>
        <td><?php echo $cnkardex->Fields('idmateriales'); ?></td>
        <td>03 Materia Prima </td>
        <td><?php echo $cnkardex->Fields('tmateriales'); ?></td>
        <td align="right"><?php echo $cnkardex->Fields('unidad'); ?></td>
        <td align="right"><?php if ($cnkardex->Fields('saldo')<>''){
		$saldo = $cnkardex->Fields('saldo');
		}else{$saldo = $cnkardex->Fields('isaldo');}
		echo number_format($saldo,2);
		?></td>
		<?php if ($cnkardex->Fields('total')<>''){
		$total = $cnkardex->Fields('total');
		}else{$total = $cnkardex->Fields('itotal');}
		?>
        <td align="right"><?php echo number_format($total/$saldo,2); ?></td>
        <td align="right"><?php echo number_format($total,2);
		?></td>
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
