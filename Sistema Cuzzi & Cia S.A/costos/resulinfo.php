<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

//keep all parameters except iddetainfo
KT_keepParams('iddetainfo');

$idope__cnkardex = '20';
if (isset($_GET['idope'])) {
  $idope__cnkardex = $_GET['idope'];
}
$fec__cningresos = '2007/05/02';
if (isset($_GET['fecha'])) {
  $fec__cningresos = $_GET['fecha'];
}
// begin Recordset
$query_infotiempo = sprintf("SELECT * FROM infotiempo i, operario o WHERE i.idoperario = o.idoperario and i.idoperario = $idope__cnkardex and i.fecha = '$fec__cningresos'");
$infotiempo = $cnx_cuzzicia->SelectLimit($query_infotiempo) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_infotiempo = $infotiempo->RecordCount();
// end Recordset
// begin Recordset
$query_sumtiempo = "SELECT sum(tiempo) as sumtiempo FROM v_informes WHERE idoperario=$idope__cnkardex and fecha='$fec__cningresos'";
$sumtiempo = $cnx_cuzzicia->SelectLimit($query_sumtiempo) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_sumtiempo = $sumtiempo->RecordCount();
// end Recordset
// begin Recordset
$query_cnkardex = sprintf("SELECT di.iddetalle,i.idoperario,o.nombre,o.cargo,i.fecha,op.idseccion,s.seccion,op.id,op.iddestino,d.destino,op.idoperacion,oo.operacion,di.detalles,di.idorden,di.tiempo,di.cantidad FROM infotiempo i, detalleinforme di, operaciones op, operario o, seccion s, destino d, operacion oo WHERE (i.idinforme = di.idinforme) AND (op.id = di.idoperaciones) AND (o.idoperario = i.idoperario) AND (s.idseccion = op.idseccion) AND (d.iddestino = op.iddestino) AND (oo.idoperacion = op.idoperacion) and i.idoperario=$idope__cnkardex and i.fecha='$fec__cningresos' ORDER BY di.iddetalle Asc");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$idinfo = $infotiempo->Fields('idinforme');
//$id = $cnkardex->Fields('id');
$tabla = 'detalleinforme';
$idtabla = 'iddetalle';
$goto = 'resulinfo.php';
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
    <td colspan="3"><?php echo $infotiempo->Fields('nombre'); ?></td>
	<td class="KT_th">CARGO:</td>
	<td colspan="4"><?php echo $infotiempo->Fields('cargo'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">FECHA</td>
    <td colspan="8"><?php echo $infotiempo->Fields('fecha'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">ID</td>
	<td class="KT_th">SECCION</td>
	<td class="KT_th">DESTINO</td>
    <td class="KT_th">OPERACION</td>
    <td class="KT_th">DETALLES</td>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">TIEMPO</td>
    <td class="KT_th">CANTIDAD</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('iddetalle'); ?></td>
	<td><?php echo $cnkardex->Fields('seccion'); ?></td>
	<td><?php echo $cnkardex->Fields('destino'); ?></td>
    <td><?php echo $cnkardex->Fields('operacion'); ?></td>
    <td><?php echo $cnkardex->Fields('detalles'); ?></td>
    <td><?php echo $cnkardex->Fields('idorden'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('tiempo'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('cantidad'); ?></td>
    <td align="right"><a href="actuinfo2.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "iddetainfo=" . urlencode($cnkardex->Fields('iddetalle')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idoperac=" . urlencode($cnkardex->Fields('id')) ?>">MODIFICAR</a></td>
    <td align="right"><a href="elimina.php?tabla=<?php echo $tabla?>&idtabla=<?php echo $idtabla?>&goto=<?php echo $goto?>&id=<?php echo $cnkardex->Fields('iddetalle');?>&idope=<?php echo $infotiempo->Fields('idoperario');?>&fecha=<?php echo $infotiempo->Fields('fecha');?>">ELIMINAR</a></td>
  </tr>
  <?php
    $cnkardex->MoveNext(); 
  }
?>
  <tr>
    <td colspan="6" align="right"><strong>TOTAL TIEMPO </strong></td>
    <td align="right"><strong><?php echo $sumtiempo->Fields('sumtiempo'); ?></strong></td>
  </tr>
</table>
<a href="detainfo.php?id=<?php echo $idinfo;?>">Continuar Informe</a>
</body>
</html>
<?php
$sumtiempo->Close();

$infotiempo->Close();
?>