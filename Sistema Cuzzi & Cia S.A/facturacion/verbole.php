<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$idfact = '0';
if (isset($_GET['idfac'])) {
  $idfact = $_GET['idfac'];
}
// begin Recordset
$query_cliente = "SELECT * FROM factura f, clientes c WHERE f.idcliente=c.idcliente and f.idfact='$idfact'";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset
$mone = $cliente->Fields('moneda');
// begin Recordset
$query_factura = "SELECT * FROM factura f,detallefact df,clientes c WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and f.idfact='$idfact' ORDER BY iddetfact";
$factura = $cnx_cuzzicia->SelectLimit($query_factura) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_factura = $factura->RecordCount();
// end Recordset
$tfact = 0;
$igv = $factura->Fields('igv')/100;
$mone = $factura->Fields('moneda');
//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="4" align="right"><strong>N&ordm;FACT.</strong></td>
    <td colspan="2"><strong><?php echo $cliente->Fields('idfact'); ?></strong></td>
  </tr>
  <tr>
    <td class="KT_th">CLIENTE:</td>
    <td colspan="2"><?php echo $cliente->Fields('nombre'); ?></td>
	<td class="KT_th">DNI:</td>
	<td colspan="2"><?php echo $cliente->Fields('dni'); ?><strong></strong></td>
  </tr>
  <tr>
    <td class="KT_th">DIRECCION:</td>
    <td colspan="2"><?php echo $cliente->Fields('direcbol'); ?></td>
    <td class="KT_th">FECHA:</td>
    <td colspan="2"><?php echo $cliente->Fields('fecha'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">PEDIDO:</td>
    <td colspan="2"><?php echo $cliente->Fields('pedido'); ?></td>
    <td class="KT_th">G. REMISON:</td>
    <td colspan="2"><?php echo $cliente->Fields('gremi'); ?></td>
  </tr>
  
  
  <tr>
    <td class="KT_th">ORDEN</td>
	<td class="KT_th">CANT.</td>
	<td class="KT_th">DETALLES</td>
    <td class="KT_th">P. UNIT. </td>
    <td class="KT_th">P. TOTAL </td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <?php
  while (!$factura->EOF) { 
	if($mone=='dolar'){
	$monto = $factura->Fields('mdolar');}
	else{$monto = $factura->Fields('monto');}
?>
    <tr>
      <td><?php echo $factura->Fields('idorden'); ?></td>
      <td align="right"><?php $cant=$factura->Fields('cantidad'); if($factura->Fields('und')=='Mill'){echo number_format($cant,3);}else{echo number_format($cant,2);} ?> <?php echo $factura->Fields('und'); ?></td>
      <td><?php echo nl2br($factura->Fields('descripcion')); ?></td>
      <td align="right"><?php echo number_format($monto,2); ?></td>
      <td align="right"><?php $tfact+=round($cant*$monto,2); echo number_format($cant*$monto,2); ?></td>
      <td align="right"><a href="../elimina.php?tabla=detallefact&idtabla=iddetfact&goto=facturacion/verbole.php&id=<?php echo $factura->Fields('iddetfact');?>&idfac=<?php echo $idfact;?>">eliminar</a></td>
    </tr>
    <?php
    $factura->MoveNext(); 
  }
?>
    <tr>
      <td colspan="4" align="right"><strong>SUBTOTAL</strong></td>
      <td align="right"><?php echo number_format($tfact,2); ?></td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right"><strong>IGV</strong></td>
      <td align="right"><?php $tigv=round($tfact*$igv,2);
	  echo number_format($tigv,2); ?></td>
      <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4" align="right"><strong>TOTAL </strong></td>
    <td align="right"><?php echo number_format($tfact+$tigv,2); ?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="right"><a href="detfact.php?idfac=<?php echo $idfact;?>&mone=<?php echo $mone;?>" target="mainFrame">Completar Boleta</a></td>
    <td colspan="2" align="right"><a href="../fpdf/imprimir_boleta.php?idfac=<?php echo $idfact;?>" target="mainFrame">Imprimir Boleta</a></td>
  </tr>
</table>
</body>
</html>
<?php
$cliente->Close();
$factura->Close();
?>