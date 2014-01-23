<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

// begin Recordset
$colname__segudistri = '6';
if (isset($_GET['idse'])) {
  $colname__segudistri = $_GET['idse'];
}
$query_segudistri = sprintf("SELECT * FROM seguros s,distribucions d,seccion sc WHERE s.idseguro=d.idseguro and sc.idseccion=d.idseccion and s.idseguro = %s", $colname__segudistri);
$segudistri = $cnx_cuzzicia->SelectLimit($query_segudistri) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_segudistri = $segudistri->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">Seguro</td>
    <td><?php echo $segudistri->Fields('seguro'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th" colspan="3">Distribucion</td>
  </tr>
  <?php
  while (!$segudistri->EOF) { 
?>
  <tr>
    <td>&gt;&gt;&gt;</td>
    <td><?php echo $segudistri->Fields('seccion'); ?></td>
    <td><?php echo $segudistri->Fields('porcentaje')*100; ?>%</td>
  </tr>
  <?php
  	$sum[]=$segudistri->Fields('porcentaje');
    $segudistri->MoveNext(); 
  }
?>
<tr>
<td></td>
<td>TOTAL:</td>
<td><? echo array_sum($sum)*100; ?>%</td>
</tr>
</table>
</body>
</html>
<?php
$segudistri->Close();
?>
