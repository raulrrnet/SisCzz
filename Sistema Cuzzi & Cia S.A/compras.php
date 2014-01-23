<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$maxRows_detsaldo = 20;
$pageNum_detsaldo = 0;
if (isset($_GET['pageNum_detsaldo'])) {
  $pageNum_detsaldo = $_GET['pageNum_detsaldo'];
}
$startRow_detsaldo = $pageNum_detsaldo * $maxRows_detsaldo;
$colname__detsaldo = '-1';
$idmate = '0';
if (isset($_POST['idmat'])) {
  $idmate = $_POST['idmat'];
}
$query_detsaldo = sprintf("SELECT * FROM v_consultas WHERE movimiento='Ingreso' and motivo='2Compra' and idmateriales='$idmate' ORDER BY fecha DESC");
$detsaldo = $cnx_cuzzicia->SelectLimit($query_detsaldo, $maxRows_detsaldo, $startRow_detsaldo) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_detsaldo'])) {
  $totalRows_detsaldo = $_GET['totalRows_detsaldo'];
} else {
  $all_detsaldo = $cnx_cuzzicia->SelectLimit($query_detsaldo) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_detsaldo = $all_detsaldo->RecordCount();
}
$totalPages_detsaldo = (int)(($totalRows_detsaldo-1)/$maxRows_detsaldo);
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="nav_cal"><strong>Material</strong></td>
    <td colspan="4"><?php echo $detsaldo->Fields('tipoconsumo'); ?> / <?php echo $detsaldo->Fields('categoria'); ?> / <?php echo $detsaldo->Fields('materiales'); ?> / <?php echo $detsaldo->Fields('marcatipo'); ?> / <?php echo $detsaldo->Fields('gramajecalibre'); ?> / <?php echo $detsaldo->Fields('medida'); ?> / <?php echo $detsaldo->Fields('unidad'); ?></td>
  </tr>
  
  <tr>
    <td class="nav_cal"><strong>Fecha</strong></td>
    <td class="nav_cal"><strong>Proveedor</strong></td>
    <td class="nav_cal"><strong>Cantidad</strong></td>
    <td class="nav_cal"><strong>ValorUSoles</strong></td>
    <td class="nav_cal"><strong>ValorUDolar</strong></td>
  </tr>
  <?php
  while (!$detsaldo->EOF) { 
?>
  <tr>
    <td><?php if($detsaldo->Fields('fecha')==''){
	echo $detsaldo->Fields('fecingreso');}
	else{echo $detsaldo->Fields('fecha');}?></td>
    <td align="center"><?php echo $detsaldo->Fields('proveedor'); ?></td>
    <td align="right"><?php echo number_format($detsaldo->Fields('cantidad'),2); ?></td>
    <td align="right"><?php echo number_format($detsaldo->Fields('vusoles')-$detsaldo->Fields('vuotross'),4); ?></td>
    <td align="right"><?php echo number_format($detsaldo->Fields('vudolar')-$detsaldo->Fields('vuotrosd'),4); ?></td>
    </tr>
  <?php
    $detsaldo->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$detsaldo->Close();
?>