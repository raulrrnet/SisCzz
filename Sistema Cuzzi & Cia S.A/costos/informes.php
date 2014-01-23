<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$fecini = '2003/01/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$fecfin = '2003/01/01';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
// begin Recordset
$query_informes = "SELECT * FROM v_informes WHERE fecha BETWEEN '$fecini' and '$fecfin' and idorden<>0 and idorden is not null ORDER BY fecha";
$informes = $cnx_cuzzicia->SelectLimit($query_informes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_informes = $informes->RecordCount();
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
    <td height="17" width="64">Pres./Real</td>
    <td width="86">Fecha</td>
    <td width="114">Concepto</td>
    <td width="240">Descripci&oacute;n</td>
    <td width="100">Orden</td>
    <td width="104">Tiempo</td>
    <td width="104">Tarifa S/.</td>
    <td width="104">Tarifa $.</td>
  </tr>
  <?php
  while (!$informes->EOF) { 
?>
    <tr>
      <td height="17">Real</td>
      <td><?php echo $informes->Fields('fecha'); ?></td>
      <td>Gastos de Prod.</td>
      <td><?php echo $informes->Fields('seccion'); ?> <?php echo $informes->Fields('destino'); ?> <?php echo $informes->Fields('operacion'); ?> </td>
      <td>o<?php echo $informes->Fields('idorden'); ?></td>
      <td><?php echo $informes->Fields('tiempo'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php
    $informes->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$informes->Close();
?>
