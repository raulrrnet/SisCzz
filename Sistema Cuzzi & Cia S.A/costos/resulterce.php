<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

//keep all parameters except idterce
KT_keepParams('idterce');

$fec = '2003/01/01';
if (isset($_GET['fecha'])) {
  $fec = $_GET['fecha'];
}

// begin Recordset
$query_cnkardex = sprintf("select *
from trabterceros t, descripcion d, proveedor p
where t.iddescrip=d.iddescrip and t.idproveedor=p.idproveedor AND fecha='$fec'");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$tabla = 'trabterceros';
$idtabla = 'idterceros';
$goto = 'resulterce.php';
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
    <td class="KT_th">ID</td>
	<td class="KT_th">DESCRIPCION</td>
	<td class="KT_th">PROVEEDOR</td>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">REF.</td>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">CANT.</td>
    <td class="KT_th">V. S/. </td>
    <td class="KT_th">V. $. </td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('idterceros'); ?></td>
	<td><?php echo $cnkardex->Fields('descripcion'); ?></td>
	<td><?php echo $cnkardex->Fields('proveedor'); ?></td>
    <td><?php echo $cnkardex->Fields('fecha'); ?></td>
    <td><?php echo $cnkardex->Fields('referencia'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('idorden'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('cantidad'); ?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('valorus'),2); ?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('valorud'),2); ?></td>
    <td align="right"><a href="actuterce.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idterce=" . urlencode($cnkardex->Fields('idterceros')) ?>" target="_parent">MODIFICAR</a></td>
    <td align="right"><a href="elimina.php?tabla=<?php echo $tabla?>&idtabla=<?php echo $idtabla?>&goto=<?php echo $goto?>&id=<?php echo $cnkardex->Fields('idterceros');?>&fecha=<?php echo $fec;?>">ELIMINAR</a></td>
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