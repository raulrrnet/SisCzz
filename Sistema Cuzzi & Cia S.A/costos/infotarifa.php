<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$idtarifa = '1';
if (isset($_GET['idtarifa'])) {
  $idtarifa = $_GET['idtarifa'];
}
$query_cnkardex = sprintf("SELECT t.idtarifa,t.nombre,t.estado,t.vig_inicio,t.vig_fin,dt.idseccion,s.seccion,s.unidad,dt.tarifa FROM tarifa t,detalletarifa dt,seccion s WHERE t.idtarifa = $idtarifa AND dt.idseccion = s.idseccion");
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
    <td class="KT_th">NOMBRE:</td>
    <td><?php echo $cnkardex->Fields('nombre'); ?></td>
	<td class="KT_th">PREDETERMINADA:</td>
	<td><?php echo $cnkardex->Fields('estado'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">VIGENCIA INICIO </td>
    <td><?php echo $cnkardex->Fields('vig_inicio'); ?></td>
	<td class="KT_th">VIGENCIA FIN :</td>
	<td><?php echo $cnkardex->Fields('vig_fin'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">SECCION / unidad </td>
	<td colspan="2" class="KT_th">TARIFA</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td colspan="2"> <?php echo $cnkardex->Fields('seccion'); ?> <?php echo $cnkardex->Fields('unidad'); ?></td>
	<td colspan="2"><?php echo $cnkardex->Fields('tarifa'); ?></td>
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