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
$mat__cnsalidas = '20';
if (isset($_POST['idmat'])) {
  $mat__cnsalidas = $_POST['idmat'];
}
$query_cnsalidas = sprintf("SELECT * FROM v_consultas WHERE movimiento='Salida' and idmateriales = %s and fecha = '%s'", $mat__cnsalidas,$fec__cnsalidas);
$cnsalidas = $cnx_cuzzicia->SelectLimit($query_cnsalidas) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnsalidas = $cnsalidas->RecordCount();
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
    <td>idsalida</td>
    <td>material</td>
    <td>motivo</td>
    <td>fecha</td>
    <td>idorden</td>
    <td>idseccion</td>
    <td>cantidad</td>
  </tr>
  <?php
  while (!$cnsalidas->EOF) { 
?>
  <tr>
    <td><?php echo $cnsalidas->Fields('idmovimiento'); ?></td>
    <td><A HREF="actusali2.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmovimiento=" . urlencode($cnsalidas->Fields('idmovimiento')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmaterial=" . urlencode($cnsalidas->Fields('idmateriales')) ?>"><?php echo $cnsalidas->Fields('idmateriales'); ?></A></td>
    <td><?php echo $cnsalidas->Fields('motivo'); ?></td>
    <td><?php echo $cnsalidas->Fields('fecha'); ?></td>
    <td><?php echo $cnsalidas->Fields('idorden'); ?></td>
    <td><?php echo $cnsalidas->Fields('idseccion'); ?></td>
    <td><?php echo $cnsalidas->Fields('cantidad'); ?></td>
  </tr>
  <?php
    $cnsalidas->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$cnsalidas->Close();
?>