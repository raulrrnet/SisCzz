<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

$idmate = '0';
if (isset($_POST['idmat'])) {
  $idmate = $_POST['idmat'];
}
$year=date('Y');
$query_tsaldo = sprintf("SELECT sum(saldo) as tsaldo FROM v_consultas WHERE movimiento='Ingreso' and idmateriales='$idmate' and saldo<>0 and date_part('year',fecha)=$year");
$tsaldo = $cnx_cuzzicia->SelectLimit($query_tsaldo) or die($cnx_cuzzicia->ErrorMsg());
// ----
$query_saldo = sprintf("SELECT * FROM v_consultas WHERE movimiento='Ingreso' and idmateriales='$idmate' and saldo<>0 and date_part('year',fecha)=$year ORDER BY fecha");
$detsaldo = $cnx_cuzzicia->SelectLimit($query_saldo) or die($cnx_cuzzicia->ErrorMsg());

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.Estilo7 {font-size: small}
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td>Material</td>
    <td colspan="5"><?php echo $detsaldo->Fields('tipoconsumo'); ?>/<?php echo $detsaldo->Fields('categoria'); ?>/<?php echo $detsaldo->Fields('materiales'); ?>/<?php echo $detsaldo->Fields('marcatipo'); ?>/<?php echo $detsaldo->Fields('gramajecalibre'); ?>/<?php echo $detsaldo->Fields('medida'); ?>/<?php echo $detsaldo->Fields('unidad'); ?></td>
  </tr>
  <tr>
    <td><span class="Estilo7"><strong>Saldo: <?php echo $tsaldo->Fields('tsaldo'); ?></strong></span></td>
    <td colspan="5"><strong>DETALLE SALDO </strong></td>
  </tr>
  <tr>
    <td>Fecha</td>
    <td>Cantidad Original </td>
    <td>Cantidad Restante </td>
    <td>Motivo</td>
    <td>Referencia</td>
    <td>Ordenes</td>
  </tr>
  <?php
  while (!$detsaldo->EOF) { 
?>
  <tr>
    <td><?php if($detsaldo->Fields('fecha')==''){
	echo $detsaldo->Fields('fecingreso');}
	else{echo $detsaldo->Fields('fecha');}?></td>
    <td><?php echo $detsaldo->Fields('cantidad'); ?></td>
    <td><?php echo $detsaldo->Fields('saldo'); ?></td>
    <td><?php echo $detsaldo->Fields('motivo'); ?></td>
    <td><?php if ($detsaldo->Fields('referencia')<>''){
		echo $detsaldo->Fields('referencia');
		}else{echo "-";}?></td>
    <td><?php if ($detsaldo->Fields('ordenes')<>''){
		echo $detsaldo->Fields('ordenes');
		}else{echo "-";}?></td>
  </tr>
  <?php
    $detsaldo->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$tsaldo->Close();

$detsaldo->Close();
?>
