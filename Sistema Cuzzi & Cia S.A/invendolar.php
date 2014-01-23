<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

// begin Recordset
$fec__cningresos = '2005/12/31';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 

$qcatd = sprintf("SELECT tipoconsumo,categoria,sum(saldo*vudolar) as total1 FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' and saldo<>0 GROUP BY tipoconsumo,categoria ORDER BY tipoconsumo");
$qcatdex = $cnx_cuzzicia->SelectLimit($qcatd) or die($cnx_cuzzicia->ErrorMsg());

$querytotal = sprintf("select sum(saldo*vudolar) as totalt from v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos'");
$qtotal = $cnx_cuzzicia->SelectLimit($querytotal) or die($cnx_cuzzicia->ErrorMsg());

//PHP ADODB document - made with PHAkt 3.7.1
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<table class="KT_tngtable" align="center">
  <tr>
    <td colspan="2" align="center">INVETARIO MATERIALES AL <?php echo $fec__cningresos; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <?php
  while (!$qcatdex->EOF) { 
?>
      <?php $TFM_nest = $qcatdex->Fields('tipoconsumo');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
      <tr>
        <td colspan="2" class="KT_th"><?php echo $qcatdex->Fields('tipoconsumo'); ?></td>
        </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td><?php echo $qcatdex->Fields('categoria'); ?></td>
        <td align="right"><?php echo number_format($qcatdex->Fields('total1'),2); ?></td>
        </tr>
      <?php
    $qcatdex->MoveNext(); 
  }
?>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">$.</td>
    <td><?php echo number_format($qtotal->Fields('totalt'),2); ?></td>
  </tr>
</table>
<iframe  name="idiframe" id="idiframe" width="100%" height="150" frameborder="0" src="menug.php">
</iframe>
</body>
</html>