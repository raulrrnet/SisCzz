<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$query_ordenliq = "SELECT  o.idorden, o.fecha, o.fechaliqui, c.cliente, o.descripcion, o.precios, o.cantprod FROM orden o, clientes c WHERE   o.idcliente = c.idcliente AND fechaliqui IS NOT NULL ORDER BY idorden";
$ordenliq = $cnx_cuzzicia->SelectLimit($query_ordenliq) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_ordenliq = $ordenliq->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<table width="200" border="1">
  <tr>
    <td>Orden</td>
    <td>Fecha O.</td>
    <td>Fecha Liq. O. </td>
    <td>Cliente</td>
    <td>Descripci&oacute;n</td>
    <td>Precio/Millar</td>
    <td>G. Produccion </td>
    <td>G. Materiales </td>
    <td>G. Terceros </td>
    <td>Total G.Prod. </td>
    <td>Admin 60% </td>
    <td>Margen</td>
    <td>Facturaci&oacute;n</td>
  </tr>
  <?php
  while (!$ordenliq->EOF) { 

$ordent = $ordenliq->Fields('idorden');

$query_cningresos = "SELECT sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$ordent";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$ordent";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$ordent";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
?>
    <tr>
      <td><?php echo $ordenliq->Fields('idorden'); ?></td>
      <td><?php echo $ordenliq->Fields('fecha'); ?></td>
      <td><?php echo $ordenliq->Fields('fechaliqui'); ?></td>
      <td><?php echo $ordenliq->Fields('cliente'); ?></td>
      <td><?php echo $ordenliq->Fields('descripcion'); ?></td>
      <td><?php echo number_format($ordenliq->Fields('precios'),2); ?></td>
      <td><?php $tsolesit=$cndetinfo->Fields('soles');
		echo number_format($cndetinfo->Fields('soles'),2);?></td>
      <td><?php $tsolesmt=$cningresos->Fields('soles');
		echo number_format($cningresos->Fields('soles'),2); ?></td>
      <td><?php $tsolestt=$cnterce->Fields('soles');
		echo number_format($cnterce->Fields('soles'),2); ?></td>
      <td><?php $totalt=$tsolesit+$tsolesmt+$tsolestt;
		echo number_format($totalt,2); ?></td>
      <td><?php $totalta=$tsolesit*0.6;
		echo number_format($totalta,2); ?></td>
      <td><?php echo number_format($totalt+$totalta+(($totalt+$totalta)*0.2),2); ?></td>
      <td><?php echo number_format($ordenliq->Fields('precios')*$ordenliq->Fields('cantprod')/1000,2); ?></td>
    </tr>
    <?php
    $ordenliq->MoveNext(); 
  }
$ordenliq->Close();
?>
</table>