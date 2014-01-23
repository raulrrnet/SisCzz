<?php
//PHP ADODB document - made with PHAkt 3.7.1

//Connection statement
require_once('Connections/cnx_cuzzicia.php');

// begin Recordset
$fec__cningresos = '2006/10/20';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT * FROM v_consultas WHERE movimiento='Salida' and fecha <= '$fec__cningresos' and idorden<>0 ORDER BY idorden,fecha");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<table width="10%" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <?php
  while (!$cnkardex->EOF) { 
?>
  <?php $TFM_nest = $cnkardex->Fields('idorden');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
	$unisal=0;
	$sa=0; ?>
  <tr>
    <td class="nav_cal">ORDEN:</td>
    <td><?php echo $cnkardex->Fields('idorden'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="selected_cal">SISTEMA</td>
    </tr>
  <tr>
    <td width="336" class="selected_cal">Material</td>
    <td width="319" class="selected_cal">Cantidad</td>
    </tr>
  <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
  <tr>
    <td><?php echo $cnkardex->Fields('categoria'); ?> / <?php echo $cnkardex->Fields('materiales'); ?> / <?php echo $cnkardex->Fields('marcatipo'); ?> / <?php echo $cnkardex->Fields('gramajecalibre'); ?> / <?php echo $cnkardex->Fields('medida'); ?></td>
    <td><?php echo $cnkardex->Fields('cantidad');?></td>
    </tr>
  <?php
    $cnkardex->MoveNext(); 
  }
?>
</table>
<iframe  name="idiframe" id="idiframe" width="100%" height="150" frameborder="0" src="menug.php">
</iframe>
</body>
</html>