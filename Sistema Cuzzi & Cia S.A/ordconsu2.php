<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$fecliq=$_POST['fecliq'];
	$cantprod=abs($_POST['cantprod']);
	$obser=$_POST['obser'];
	$orden=$_POST['idord'];
  $updateSQL = "UPDATE orden SET fechaliqui='$fecliq',cantprod='$cantprod',obserliqui='$obser' WHERE idorden=$orden";
  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "liqimp.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?idord=".$_POST['idord'];
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$orden__consuor = '11111';
if (isset($_POST['orden'])) {
  $orden__consuor = $_POST['orden'];
}
$query_consuor = sprintf("SELECT sum(cantidad*vusoles) as soles,sum(cantidad*vudolar) as dolar FROM movimientos WHERE movimiento='Salida' and idorden=$orden__consuor");
$consuor = $cnx_cuzzicia->SelectLimit($query_consuor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_consuor = $consuor->RecordCount();
// end Recordset

// begin Recordset
$query_datorden = "SELECT * FROM orden o,clientes c,prodorden p,tproducto tp,gproducto gp WHERE idorden=$orden__consuor and o.idcliente = c.idcliente AND  o.idprodorden = p.idprodorden AND gp.idgproduc = p.idgprod AND tp.idtproduc = p.idtprod";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_datorden = $datorden->RecordCount();
if($totalRows_datorden<1){
$query_datorden = "SELECT * FROM orden o,clientes c WHERE idorden=$orden__consuor and o.idcliente = c.idcliente";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());}
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
$query_cningresos = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,max(vusoles) as vusoles FROM v_consultas WHERE movimiento='Salida' and idorden=$orden__consuor GROUP BY tmateriales,unidad ORDER BY tmateriales";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "Select i.seccion,i.destino,i.operacion,sum(tiempo) AS tiempo,sum(cantidad) AS cantidad,sum(vsoles * tiempo) as solest,sum(vsoles * cantidad) as solesc,max(vsoles) as vusoles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and idorden = $orden__consuor and t.estado='si' GROUP BY i.seccion,i.destino,i.operacion ORDER BY i.seccion";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());
/*$query_detinfo = "Select i.seccion,i.unidad,sum(vdolar * tiempo) as dolart,sum(vdolar * cantidad) as dolarc,  sum(vsoles * tiempo) as solest,sum(vsoles * cantidad) as solesc,sum(tiempo) AS tiempo,sum(cantidad) AS cantidad FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and idorden = $orden__consuor and t.estado='si' GROUP BY i.seccion,i.unidad";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());*/

$query_terce = "SELECT descripcion,sum(cantidad) as cantidad,sum(cantidad*valorus) as soles,max(valorus) as vusoles FROM v_terceros WHERE idorden=$orden__consuor group by descripcion";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
$qtoterce = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE idorden=$orden__consuor";
$qtoterceexc = $cnx_cuzzicia->SelectLimit($qtoterce) or die($cnx_cuzzicia->ErrorMsg());
//PHP ADODB document - made with PHAkt 3.6.0
$tsoles=0;$tdolar=0;
?>
<html>
<head>
<title>Consumos Orden</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.cdiv {
	height: auto;
	width: 200px;
	overflow:auto;
	white-space:normal
}
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">ORDEN</td>
    <td colspan="2" class="KT_th">Cliente</td>
    <td class="KT_th">C. Pedida </td>
    <td class="KT_th">F. Orden </td>
  </tr>
  <tr>
    <td><?php echo $orden__consuor; ?></td>
    <td colspan="2"><?php echo $datorden->Fields('cliente'); ?></td>
    <td align="right"><?php echo $datorden->Fields('cantpedi'); ?></td>
    <td align="right"><?php echo $datorden->Fields('fecha'); ?></td>
  </tr>
<tr>
  <td class="KT_th">T.Producto</td>
  <td colspan="2" class="KT_th">Detalles</td>
  <td colspan="2" class="KT_th">Observaciones</td>
</tr>
<tr>
  <td><?php echo $datorden->Fields('grupop').' / '.$datorden->Fields('tipop'); ?></td>
  <td colspan="2" rowspan="3"><div class="cdiv"><?php echo nl2br($datorden->Fields('detalle')); ?></div></td>
  <td colspan="2" rowspan="3"><div class="cdiv"><?php echo nl2br($datorden->Fields('observacion')); ?></div></td>
</tr>
<tr>
  <td class="KT_th">Descripcion</td>
  </tr>
<tr>
  <td><div class="cdiv"><?php echo $datorden->Fields('descripcion'); ?></div></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">GASTOS DE PRODUCCION </td>
    <td class="KT_th"> TIEMPO</td>
    <td class="KT_th">V. UNIT. </td>
    <td class="KT_th">C. SOLES</td>
  </tr>
  <?php
  while (!$cndetinfo->EOF) { 
?>
  <tr>
    <td><?php echo $cndetinfo->Fields('seccion').' / '.$cndetinfo->Fields('destino').' / '.$cndetinfo->Fields('operacion'); ?></td>
    <td align="right"><?php echo number_format($cndetinfo->Fields('tiempo'),2);?></td>
    <td align="right"><?php echo number_format($cndetinfo->Fields('vusoles'),2);?></td>
    <td align="right"><?php $tsoles+=$cndetinfo->Fields('solest');
		echo number_format($cndetinfo->Fields('solest'),2);?></td>
    </tr>
<?php
    $cndetinfo->MoveNext(); 
  }
?>
  <tr>
    <td colspan="3" class="KT_topbuttons">TOTAL:</td>
    <td align="right"><?php echo number_format($tsoles,2); ?></td>
  </tr>
  <tr>
    <td class="KT_th">MATERIALES</td>
    <td class="KT_th"> CANTIDAD</td>
    <td class="KT_th">V. UNIT. </td>
    <td class="KT_th">C. SOLES</td>
  </tr>
  <?php
  while (!$cningresos->EOF) { 
?>
  <tr>
    <td><?php echo $cningresos->Fields('tmateriales'); ?></td>
    <td align="right"><?php echo $cningresos->Fields('cant'); ?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('vusoles'),2); ?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('soles'),2); ?></td>
    </tr>
  <?php
    $cningresos->MoveNext(); 
  }
?>
<tr>
	<td colspan="3" class="KT_topbuttons">TOTAL:</td>
	<td align="right"><?php echo number_format($consuor->Fields('soles'),2); ?></td>
  </tr>
<tr>
  <td class="KT_th">TRABAJOS DE TERCEROS </td>
  <td class="KT_th"> CANTIDAD</td>
  <td class="KT_th">V. UNIT. </td>
  <td class="KT_th">C. SOLES</td>
  </tr>
<?php
  while (!$cnterce->EOF) { 
?>
  <tr>
    <td><?php echo $cnterce->Fields('descripcion'); ?></td>
    <td align="right"><?php echo $cnterce->Fields('cantidad'); ?></td>
    <td align="right"><?php echo number_format($cnterce->Fields('vusoles'),2); ?></td>
    <td align="right"><?php echo number_format($cnterce->Fields('soles'),2); ?></td>
    </tr>
  <?php
    $cnterce->MoveNext(); 
  }
?>
<tr>
  <td colspan="3" class="KT_topbuttons">TOTAL:</td>
  <td align="right"><?php echo number_format($qtoterceexc->Fields('soles'),2); ?></td>
  </tr>
<tr>
  <td class="KT_th">TOTAL COSTO PRODUCCION:</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($consuor->Fields('soles')+$qtoterceexc->Fields('soles')+$tsoles,2); ?></td>
  </tr>
</table>
</body>
</html>
<?php
$consuor->Close();

$datorden->Close();
?>