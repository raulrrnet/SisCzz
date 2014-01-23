<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$colname__ordinfor = '-1';
if (isset($_POST['idord'])) {
  $colname__ordinfor = $_POST['idord'];
}
$query_ordinfor = sprintf("SELECT * FROM v_informes WHERE idorden = %s ORDER BY fecha DESC, seccion asc", GetSQLValueString($colname__ordinfor, "int"));
$ordinfor = $cnx_cuzzicia->SelectLimit($query_ordinfor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_ordinfor = $ordinfor->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr>
  <td class="KT_th">ORDEN:</td>
  <td colspan="4" class="KT_th"><?php echo $ordinfor->Fields('idorden'); ?></td>
  </tr>
<tr>
  <td class="KT_th">FECHA</td>
  <td class="KT_th">OPERARIO </td>
  <td class="KT_th">SECCION</td>
  <td class="KT_th">DESTINO/OPERACION </td>
  <td class="KT_th">TIEMPO</td>
  </tr>
<?php
  while (!$ordinfor->EOF) { 
?>
  <tr>
    <td><?php echo $ordinfor->Fields('fecha'); ?></td>
    <td><?php echo $ordinfor->Fields('nombre'); ?></td>
    <td><?php echo $ordinfor->Fields('seccion'); ?></td>
    <td><?php echo $ordinfor->Fields('destino'); ?>/<?php echo $ordinfor->Fields('operacion'); ?></td>
    <td align="right"><?php echo number_format($ordinfor->Fields('tiempo'),2); ?></td>
  </tr>
  <?php
    $ordinfor->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$ordinfor->Close();
?>
