<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$responsable = 'Dember';
if (isset($_POST['resp'])) {
  $responsable = $_POST['resp'];
}
$fec__cningresos = date("Y/m/d");
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
//$fec__cningresos = date("Y/m/d");
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT idmateriales,tipoconsumo||' / '||categoria as tipocate, sum(saldo) as saldo,responsable,materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' and responsable='$responsable' GROUP BY idmateriales,tipocate,tmateriales,responsable ORDER BY responsable,tipocate,tmateriales");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<?php  $lastTFM_nest = "";?>
<?php
//PHP ADODB document - made with PHAkt 3.7.1

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html>
<head>
<title>Inventario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo2 {font-size: 14px}
-->
</style>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center">FECHA <span class="Estilo2"><?php echo $fec__cningresos; ?></span></td>
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
        <td colspan="2" class="KT_th Estilo2"><span class="Estilo2">Responsable: <?php echo $cnkardex->Fields('responsable'); ?></span></td>
      </tr>
      <tr>
        <td class="KT_th Estilo2"><span class="Estilo2"><?php echo $cnkardex->Fields('tipocate'); ?></span></td>
        <td width="100" class="KT_th Estilo2"><span class="Estilo2">Saldo</span></td>
      </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td><span class="Estilo2"><?php echo $cnkardex->Fields('tmateriales'); ?></span></td>
        <td width="100">&nbsp;</td>
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
<?php
$cnkardex->Close();
?>