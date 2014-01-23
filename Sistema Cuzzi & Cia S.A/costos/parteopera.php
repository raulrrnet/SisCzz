<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$idope__cnkardex = '1';
if (isset($_GET['idope'])) {
  $idope__cnkardex = $_GET['idope'];
}
$fec__cningresos = '2007/02/28';
if (isset($_GET['fecha'])) {
  $fec__cningresos = $_GET['fecha'];
}
$query_cnkardex = sprintf("SELECT di.iddetalle,i.idoperario,o.nombre,o.cargo,i.fecha,op.idseccion,s.seccion,op.iddestino,d.destino,op.idoperacion,oo.operacion,di.idorden,di.tiempo,di.cantidad FROM infotiempo i, detalleinforme di, operaciones op, operario o, seccion s, destino d, operacion oo WHERE (i.idinforme = di.idinforme) AND (op.id = di.idoperaciones) AND (o.idoperario = i.idoperario) AND (s.idseccion = op.idseccion) AND (d.iddestino = op.iddestino) AND (oo.idoperacion = op.idoperacion) and i.idoperario=$idope__cnkardex and i.fecha='$fec__cningresos'");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

// rebuild the query string by replacing pageNum and totalRows with the new values
$queryString_cnkardex = KT_removeParam("&" . @$_SERVER['QUERY_STRING'], "pageNum_cnkardex");
$queryString_cnkardex = KT_replaceParam($queryString_cnkardex, "totalRows_cnkardex", $totalRows_cnkardex);

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
    <td colspan="2" class="KT_th">OPERARIO:</td>
    <td colspan="2"><?php echo $cnkardex->Fields('nombre'); ?></td>
	<td class="KT_th">CARGO:</td>
	<td colspan="2"><?php echo $cnkardex->Fields('cargo'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">FECHA</td>
    <td colspan="5"><?php echo $cnkardex->Fields('fecha'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">ID</td>
	<td class="KT_th">SECCION</td>
	<td class="KT_th">DESTINO</td>
    <td class="KT_th">OPERACION</td>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">TIEMPO</td>
    <td class="KT_th">CANTIDAD</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('iddetalle'); ?></td>
	<td><?php echo $cnkardex->Fields('seccion'); ?></td>
	<td><?php echo $cnkardex->Fields('destino'); ?></td>
    <td><?php echo $cnkardex->Fields('operacion'); ?></td>
    <td><?php echo $cnkardex->Fields('idorden'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('tiempo'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('cantidad'); ?></td>
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