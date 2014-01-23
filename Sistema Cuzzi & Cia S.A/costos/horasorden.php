<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
//$fecini = '2007/05/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
//$fecfin = '2007/05/30';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
$query_cnkardex = sprintf("select idorden,fecha,sum(tiempo) as tiempo from v_informes where fecha between '$fecini' and '$fecfin' and idorden<>0 group by idorden,fecha order by fecha,idorden");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Informe Total-Horas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo8 {font-size: 14px; font-weight: bold; }
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">FECHA :</td>
    <td colspan="2">DEL <?php echo $fecini;?> AL <?php echo $fecfin;?></td>
  </tr>
  <tr>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">TIEMPO</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('idorden'); ?></td>
    <td align="right"><?php echo $cndebio->Fields('fecha');?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('tiempo'),2);?></td>
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