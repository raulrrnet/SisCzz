<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

// begin Recordset
$fec__cningresos = '2003/01/01';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$query_cningresos = sprintf("SELECT iddiferencia,idmateriales,responsable,tipoconsumo||' / '||categoria as tipocate,materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales,cantreport FROM diferencias d,materiales2 m WHERE m.idmateriales=d.idmaterial and fecha = '$fec__cningresos' and cantkardex<>cantreport ORDER BY responsable,tipocate,tmateriales");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center"><span class="KT_th">Fecha Inventario </span><?php echo $fec__cningresos; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <?php
  while (!$cnkardex->EOF) { 
?>
      <?php $TFM_nest = $cnkardex->Fields('tipocate');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
      <tr>
        <td class="KT_th"><?php echo $cnkardex->Fields('responsable'); ?></td>
        <td class="KT_th"><?php echo $cnkardex->Fields('tipocate'); ?></td>
        <td class="KT_th">Cant. Reportada </td>
        <td class="KT_th">Ajustar</td>
      </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td align="center">&quot;</td>
        <td><?php echo $cnkardex->Fields('tmateriales'); ?></td>
        <td><?php echo $cnkardex->Fields('cantreport'); ?></td>
        <td><a href="actudife.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmaterial=" . urlencode($cnkardex->Fields('idmateriales')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "iddiferencia=" . urlencode($cnkardex->Fields('iddiferencia')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "fecha=" . urlencode($fec__cningresos) ?>" target="_self">Corecci&oacute;n Planta </a></td>
      </tr>
      <?php
    $cnkardex->MoveNext(); 
  }
?>
    </table></td>
  </tr>
</table>
</body>
</html>
