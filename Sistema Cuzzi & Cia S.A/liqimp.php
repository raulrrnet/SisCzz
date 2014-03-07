<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$ordenc = '11111';
if (isset($_GET['idord'])) {
  $ordenc = $_GET['idord'];
}
$query_consuor = sprintf("SELECT sum(cantidad*vusoles) as soles,sum(cantidad*vudolar) as dolar FROM movimientos WHERE movimiento='Salida' and idorden=$ordenc");
$consuor = $cnx_cuzzicia->SelectLimit($query_consuor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_consuor = $consuor->RecordCount();
// end Recordset
// begin Recordset
$query_datorden = "SELECT * FROM orden o,clientes c,prodorden p,tproducto tp,gproducto gp WHERE idorden=$ordenc and o.idcliente = c.idcliente AND  o.idprodorden = p.idprodorden AND gp.idgproduc = p.idgprod AND tp.idtproduc = p.idtprod";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_datorden = $datorden->RecordCount();
if($totalRows_datorden<1){
$query_datorden = "SELECT * FROM orden o,clientes c WHERE idorden=$ordenc and o.idcliente = c.idcliente";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());}
// end Recordset
// begin Recordset
$query_centre = "SELECT round(sum(case when und='Mill' then (cantidad * 1000) else cantidad end)) as cant FROM factura f,detallefact df WHERE f.idfact=df.idfactura and estado<>'anulada' and idorden=$ordenc";
$centre = $cnx_cuzzicia->SelectLimit($query_centre) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_centre = $centre->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.7.1
$query_cningresos = "SELECT materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida as tmateriales,sum(cantidad)||' '||unidad as cant,sum(vusoles*cantidad) as soles,max(vusoles) as vusoles FROM v_consultas WHERE movimiento='Salida' and idorden=$ordenc GROUP BY tmateriales,unidad ORDER BY tmateriales";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "Select i.seccion,i.destino,i.operacion,sum(tiempo) AS tiempo,sum(cantidad) AS cantidad,sum(vsoles * tiempo) as solest,sum(vsoles * cantidad) as solesc,max(vsoles) as vusoles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and idorden = $ordenc and t.estado='si' GROUP BY i.seccion,i.destino,i.operacion ORDER BY i.seccion";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());
/*$query_detinfo = "Select i.seccion,i.unidad,sum(vdolar * tiempo) as dolart,sum(vdolar * cantidad) as dolarc,  sum(vsoles * tiempo) as solest,sum(vsoles * cantidad) as solesc,sum(tiempo) AS tiempo,sum(cantidad) AS cantidad FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and idorden = $ordenc and t.estado='si' GROUP BY i.seccion,i.unidad";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());*/

$query_terce = "SELECT descripcion,sum(cantidad) as cantidad,sum(cantidad*valorus) as soles,max(valorus) as vusoles FROM v_terceros WHERE idorden=$ordenc group by descripcion";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
$qtoterce = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE idorden=$ordenc";
$qtoterceexc = $cnx_cuzzicia->SelectLimit($qtoterce) or die($cnx_cuzzicia->ErrorMsg());
//PHP ADODB document - made with PHAkt 3.6.0
$tsoles=0;$tdolar=0;
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Liquidaci&oacute;n Orden</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 300px;
	overflow:auto;
	white-space:normal
}
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">&nbsp;</td>
    <td class="selected_cal">F. ORDEN </td>
  </tr>
  <tr>
    <td><?php echo $datorden->Fields('idorden'); ?></td>
    <td colspan="2"><?php echo $datorden->Fields('cliente'); ?></td>
    <td><?php echo $datorden->Fields('fecha'); ?></td>
  </tr>
  <tr>
    <td class="selected_cal"><span class="KT_th">T.PRODUCTO</span></td>
    <td class="selected_cal">FECHA LIQ. </td>
    <td class="selected_cal">C. PEDIDA</td>
    <td class="selected_cal">C. PRODUCIDA </td>
  </tr>
  <tr>
    <td><?php echo $datorden->Fields('grupop').' / '.$datorden->Fields('tipop'); ?></td>
    <td><?php echo $datorden->Fields('fechaliqui'); ?></td>
    <td align="right"><?php echo $datorden->Fields('cantpedi'); ?></td>
    <td align="right"><?php echo $datorden->Fields('cantprod'); ?></td>
  </tr>
  <tr>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">&nbsp;</td>
    <td class="selected_cal">C. FACTURADA </td>
    <td align="right"><?php echo $centre->Fields('cant'); ?></td>
  </tr>
  <tr>
    <td colspan="4"><div class="cdiv"><?php echo nl2br($datorden->Fields('descripcion')); ?></div></td>
  </tr>
  <tr>
    <td><span class="selected_cal">DETALLES:</span></td>
    <td colspan="3"><div class="cdiv"><?php echo nl2br($datorden->Fields('detalle')); ?></div></td>
  </tr>
  
  <tr>
    <td><span class="selected_cal">OBSERVACIONES:</span></td>
    <td colspan="3"><div class="cdiv"><?php echo nl2br($datorden->Fields('obserliqui')); ?></div></td>
  </tr>
  
  <tr class="KT_buttons">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td class="selected_cal">GASTOS DE PRODUCCION </td>
    <td class="selected_cal"> TIEMPO</td>
    <td class="selected_cal">V. UNIT. </td>
    <td class="selected_cal">C. SOLES </td>
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
  	<td></td>
    <td class="KT_topbuttons">TOTAL:</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format($tsoles,2); ?></td>
  </tr>
  <tr>
    <td class="selected_cal">MATERIALES</td>
    <td class="selected_cal"> CANTIDAD</td>
    <td class="selected_cal">V. UNIT. </td>
    <td class="selected_cal">C. SOLES</td>
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
	<td></td>
    <td class="KT_topbuttons">TOTAL:</td>
	<td align="right"></td>
	<td align="right"><?php echo number_format($consuor->Fields('soles'),2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">TRABAJOS DE TERCEROS </td>
  <td class="selected_cal"> CANTIDAD</td>
  <td class="selected_cal">V. UNIT. </td>
  <td class="selected_cal">C. SOLES</td>
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
  <td></td>
    <td class="KT_topbuttons">TOTAL:</td>
    <td align="right"></td>
    <td align="right"><?php echo number_format($qtoterceexc->Fields('soles'),2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">T. COSTO PRODUCCION:</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($consuor->Fields('soles')+$qtoterceexc->Fields('soles')+$tsoles,2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">ADMINISTRATIVOS (60%):</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($ads=$tsoles*0.60,2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">COSTO TOTAL:</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($consuor->Fields('soles')+$qtoterceexc->Fields('soles')+$tsoles+$ads,2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">MARGEN:</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($ms=($consuor->Fields('soles')+$qtoterceexc->Fields('soles')+$tsoles+$ads)*0.2,2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">VALOR:</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($ms+$consuor->Fields('soles')+$qtoterceexc->Fields('soles')+$tsoles+$ads,2); ?></td>
  </tr>
<tr>
  <td class="selected_cal">FACTURACION:</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php echo number_format($datorden->Fields('precios')*$datorden->Fields('cantprod')/1000,2); ?></td>
  </tr>
<tr class="KT_buttons">
        <td colspan="4"><a href="#"><img src="images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
      </tr>
</table>
</body>
</html>
<?php
$centre->Close();

$consuor->Close();
$datorden->Close();
?>