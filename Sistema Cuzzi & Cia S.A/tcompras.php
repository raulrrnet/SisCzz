<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

$fecini = '2003/01/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$fecfin = '2003/01/01';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
// begin Recordset
$query_consumos = "select referencia,fecha,materiales||' '||marcatipo||' '||gramajecalibre||' '||medida as material,proveedor,cantidad,vusoles-vuotross as vs,vudolar-vuotrosd as vd,vuotross,vuotrosd from v_consultas WHERE fecha BETWEEN '$fecini' and '$fecfin' and (motivo='2Compra' or motivo='2Devolucion') ORDER BY fecha";
$consumos = $cnx_cuzzicia->SelectLimit($query_consumos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_consumos = $consumos->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td height="17" width="64">Referencia</td>
    <td width="86">Fecha</td>
    <td width="240">Material</td>
    <td width="100">Proveedor</td>
    <td width="104">Cantidad</td>
    <td width="96">Valor S/. </td>
    <td width="86">Valor $</td>
    <td width="86">V. Otros S/. </td>
    <td width="86">V. Otros $.</td>
  </tr>
  <?php
  while (!$consumos->EOF) { 
?>
    <tr>
      <td height="17"><?php echo $consumos->Fields('referencia'); ?></td>
      <td><?php echo $consumos->Fields('fecha'); ?></td>
      <td><?php echo $consumos->Fields('material'); ?></td>
      <td><?php echo $consumos->Fields('proveedor'); ?></td>
      <td><?php echo $consumos->Fields('cantidad'); ?></td>
      <td><?php echo $consumos->Fields('vs'); ?></td>
      <td><?php echo $consumos->Fields('vd'); ?></td>
      <td><?php echo $consumos->Fields('vuotross'); ?></td>
      <td><?php echo $consumos->Fields('vuotrosd'); ?></td>
    </tr>
    <?php
    $consumos->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$consumos->Close();
?>
