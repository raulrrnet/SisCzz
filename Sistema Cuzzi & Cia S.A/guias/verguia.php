<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$idsali = '0';
if (isset($_GET['idsali'])) {
  $idsali = $_GET['idsali'];
}
$idlocal = '0';
if (isset($_GET['idlocal'])) {
  $idlocal = $_GET['idlocal'];
}
// begin Recordset
$query_cliente = "SELECT s.nroguia,s.fecha,c.cliente,c.direccion as dir,l.local,l.direccion as dirl FROM salidaal s, clientes c, locals l WHERE s.idcliente=c.idcliente and s.idlocal=l.idlocal and s.idsalida=$idsali and s.idlocal=$idlocal";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset

// begin Recordset
$query_factura = "SELECT * FROM salidaal s,detsalidaal ds,clientes c WHERE s.idsalida=ds.idsalidaal and s.idcliente=c.idcliente and s.idsalida=$idsali ORDER BY iddetsali";
$factura = $cnx_cuzzicia->SelectLimit($query_factura) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_factura = $factura->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
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
    <td colspan="4" align="right"><strong>N&ordm;GUIA</strong></td>
    <td><?php echo $cliente->Fields('nroguia'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">CLIENTE:</td>
    <td colspan="2"><?php echo $cliente->Fields('cliente'); ?></td>
	<td class="KT_th">FECHA:</td>
	<td><?php echo $cliente->Fields('fecha'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">DIRECCION:</td>
    <td colspan="2"><?php if($idlocal==0){echo $cliente->Fields('dir');}else{echo $cliente->Fields('dirl');} ?></td>
    <td class="KT_th">LOCAL:</td>
    <td><?php echo $cliente->Fields('local'); ?></td>
  </tr>
  
  
  
  <tr>
    <td class="KT_th">ORDEN</td>
	<td class="KT_th">CANT.</td>
	<td class="KT_th">DETALLE</td>
    <td class="KT_th">PEDIDO</td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <?php
  while (!$factura->EOF) { 
?>
    <tr>
      <td><?php echo $factura->Fields('idorden'); ?></td>
      <td align="right"><?php $cant=$factura->Fields('cantidad'); if($factura->Fields('und')=='Mill'){echo number_format($cant,3);}else{echo number_format($cant,2);} ?>
        <?php echo $factura->Fields('und'); ?></td>
      <td><?php echo nl2br($factura->Fields('descripcion')); ?></td>
      <td align="right"><?php echo $factura->Fields('pedido'); ?></td>
      <td align="right"><a href="../elimina.php?tabla=detsalidaal&idtabla=iddetsali&goto=guias/verguia.php&id=<?php echo $factura->Fields('iddetsali');?>&idsali=<?php echo $idsali;?>">Eliminar Item </a></td>
    </tr>
    <?php
    $factura->MoveNext(); 
  }
?>
  <tr>
    <td colspan="4" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="right"><a href="../guias/guiadet.php?idsali=<?php echo $idsali;?>&idlocal=<?php echo $idlocal;?>" target="mainFrame">Completar Guia </a></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$cliente->Close();
$factura->Close();
?>