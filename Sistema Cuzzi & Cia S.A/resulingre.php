<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$colname__cningresos = '-1';
if (isset($_POST['idmat'])) {
  $colname__cningresos = $_POST['idmat'];
}
$query_cningresos = sprintf("SELECT * FROM materiales WHERE idmateriales = %s", GetSQLValueString($colname__cningresos, "int"));
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cningresos = $cningresos->RecordCount();
// end Recordset

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

//PHP ADODB document - made with PHAkt 3.7.1

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table  border="1">
  <tr>
    <td>idmaterial</td>
    <td>dias reposicion </td>
  </tr>
  <tr>
    <td><A HREF="actumate.php?<?php echo $MM_keepNone . (($MM_keepNone!="")?"&":"") . "idmateriales=" . urlencode($cningresos->Fields('idmateriales')) ?>">--]<?php echo $cningresos->Fields('idmateriales'); ?>[--</A></td>
    <td><?php echo $cningresos->Fields('diasrepo'); ?></td>
  </tr>
</table>
</body>
</html>
<?php
$cningresos->Close();
?>