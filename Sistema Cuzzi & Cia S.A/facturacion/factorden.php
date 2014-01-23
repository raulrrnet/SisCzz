<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$idorden = -1;
if (isset($_POST['orden'])) {
  $idorden = $_POST['orden'];
}
//cabecera
$query_ordc = sprintf("SELECT idorden,cliente,max(descripcion),sum(cantpedi) as cantpedi,sum(cantprod) as cantprod FROM orden o,clientes c WHERE o.idcliente=c.idcliente and idorden=$idorden GROUP BY idorden,cliente");
$exqordc = $cnx_cuzzicia->SelectLimit($query_ordc) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_exqordc = $exqordc->RecordCount();
//detalle
$query_ordd = sprintf("SELECT f.idfact,fecha,sum(cantidad) as cant, max(monto) as pu, sum(cantidad*monto) as tot, max(und) as und FROM factura f,detallefact df WHERE f.idfact=df.idfact and estado<>'anulada' and idorden=$idorden GROUP BY f.idfact,fecha ORDER BY fecha,f.idfact");
$exqordd = $cnx_cuzzicia->SelectLimit($query_ordd) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_exqordd = $exqordd->RecordCount();
//PHP ADODB document - made with PHAkt 3.6.0
$sumcant=0;
?>
<html>
<head>
<title>Facturas Orden</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">CLIENTE</td>
    <td class="KT_th">DESCRIPCION</td>
    <td class="KT_th">CANT. PEDIDA </td>
    <td class="KT_th">CANT. PROD. </td>
  </tr>
  <tr>
    <td><?php echo $exqordc->Fields('idorden'); ?></td>
    <td><?php echo $exqordc->Fields('cliente'); ?></td>
    <td><?php echo $exqordc->Fields('max'); ?></td>
    <td align="right"><?php echo number_format($exqordc->Fields('cantpedi'),2); ?></td>
    <td align="right"><?php echo number_format($exqordc->Fields('cantprod'),2); ?></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">N&ordm; FACT.</td>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">CANTIDAD</td>
    <td class="KT_th">P.UNIT.</td>
    <td class="KT_th">P. TOTAL</td>
  </tr>
    <?php
  while (!$exqordd->EOF) { 
?>
  <tr>
    <td><?php echo $exqordd->Fields('idfact'); ?></td>
    <td><?php echo $exqordd->Fields('fecha'); ?></td>
    <td align="right"><?php 
	if($exqordd->Fields('und')=='Mill'){
	$sumcant+=$exqordd->Fields('cant');}else{$sumcant+=$exqordd->Fields('cant')/1000;}
	if($exqordd->Fields('und')=='Mill'){echo number_format($exqordd->Fields('cant'),3);}else{echo number_format($exqordd->Fields('cant'),2);} ?> 
      <?php echo $exqordd->Fields('und'); ?></td>
    <td align="right"><?php echo number_format($exqordd->Fields('pu'),2); ?></td>
    <td align="right"><?php echo number_format($exqordd->Fields('tot'),2); ?></td>
    </tr>
  <?php
    $exqordd->MoveNext(); 
  }
?>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">T. ENTREGADO: </td>
    <td><?php echo number_format($sumcant,3); ?> Mill </td>
    <td class="KT_th">SALDO:</td>
    <td><?php echo number_format($exqordc->Fields('cantprod')/1000-$sumcant,3); ?> Mill</td>
  </tr>
</table>
</body>
</html>
<?php
$exqordc->Close();
$exqordd->Close();
?>