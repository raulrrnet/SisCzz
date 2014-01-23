<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$idmate = $_POST['idmat'];
$fec = $_POST['fecha'];
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha);

$query_Recordset1 = sprintf("SELECT fecha,idmateriales,tipoconsumo||'/'||categoria||'/'||materiales||'/'||marcatipo||'/'||gramajecalibre||'/'||medida||'/'||unidad as tmateriales, sum(saldo) as saldo FROM v_consultas WHERE idmateriales='$idmate' and fecha<='$fec' and  date_part('year',fecha)=$ano GROUP BY tmateriales,idmateriales,fecha ORDER BY idmateriales");
$Recordset1 = $cnx_cuzzicia->SelectLimit($query_Recordset1) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_Recordset1 = $Recordset1->RecordCount();
// end Recordset

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

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
    <td>Materiales</td>
    <td>Fecha</td>
    <td>Saldos</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  while (!$Recordset1->EOF) { 
?>
  <tr>
    <td><?php echo $Recordset1->Fields('tmateriales'); ?></td>
    <td><?php echo $Recordset1->Fields('fecha'); ?></td>
    <td><?php echo $Recordset1->Fields('saldo'); ?></td>
    <td><a href="detasal.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idmateriales=" . urlencode($Recordset1->Fields('idmateriales')) ?>">Detalle</a></td>
  </tr>
  <?php
    $Recordset1->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$Recordset1->Close();
?>
