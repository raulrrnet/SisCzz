<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$fec__cnsalidas = '2004/12/30';
if (isset($_POST['fecha'])) {
  $fec__cnsalidas = $_POST['fecha'];
}
$mat__cningresos = '16';
if (isset($_POST['idmat'])) {
  $mat__cningresos = $_POST['idmat'];
}
$query_cningresos = sprintf("SELECT * FROM movimientos WHERE movimiento='Ingreso' and idmaterial = %sand fecha = '%s'", $mat__cningresos,$fec__cnsalidas);
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cningresos = $cningresos->RecordCount();
// end Recordset

//keep all parameters except idmovimiento
KT_keepParams('idmovimiento');

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
    <td>Idmovimiento</td>
    <td>Idmaterial</td>
    <td>motivo</td>
	<td>referencia</td>
    <td>fecha</td>
    <td>idorden</td>
    <td>cantidad</td>
  </tr>
  <?php
  while (!$cningresos->EOF) { 
?>
  <tr>
    <td><?php echo $cningresos->Fields('idmovimiento'); ?></td>
    <td><A HREF="actuingre.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmovimiento=" . urlencode($cningresos->Fields('idmovimiento')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmaterial=" . urlencode($cningresos->Fields('idmaterial')) ?>"><?php echo $cningresos->Fields('idmaterial'); ?></A></td>
    <td><?php echo $cningresos->Fields('motivo'); ?></td>
    <td><?php echo $cningresos->Fields('referencia'); ?></td>
	<td><?php echo $cningresos->Fields('fecha'); ?></td>
    <td><?php echo $cningresos->Fields('ordenes'); ?></td>
    <td><?php echo $cningresos->Fields('cantidad'); ?></td>
    </tr>
  <?php
    $cningresos->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$cningresos->Close();
?>