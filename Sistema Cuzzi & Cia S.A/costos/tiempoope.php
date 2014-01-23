<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

// begin Recordset
$opera = '0';
if (isset($_POST['operario'])) {
  $opera = $_POST['operario'];
}
$fecini = '2003/01/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$fecfin = '2003/01/01';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
$query_consuor = sprintf("select sum(tiempo) from v_informes where idoperario = $opera and fecha BETWEEN '$fecini' and '$fecfin'");
$consuor = $cnx_cuzzicia->SelectLimit($query_consuor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_consuor = $consuor->RecordCount();
$query_cningresos = "select fecha,sum(tiempo) from v_informes where idoperario = $opera and fecha between '$fecini' and '$fecfin' group by fecha order by fecha";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Untitled Document</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr>
  <td>IDOPERARIO</td>
  <td>T. TIEMPO </td>
</tr>
<tr>
  <td height="23"><?php echo $opera; ?></td>
  <td align="right"><?php echo round($consuor->Fields('sum'),2); ?></td>
</tr>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td>FECHA</td>
    <td> TIEMPO </td>
  </tr>
  <?php
  while (!$cningresos->EOF) { 
?>
  <tr>
    <td><?php echo $cningresos->Fields('fecha'); ?></td>
    <td align="right"><?php 
	$canti = $cningresos->Fields('sum');
	if($canti<>0){ echo $cningresos->Fields('sum'); }
	else{echo '-';}?></td>
    </tr>
  <?php
    $cningresos->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$consuor->Close();
?>