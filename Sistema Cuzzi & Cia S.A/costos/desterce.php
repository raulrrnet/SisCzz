<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$cfecini = '2007/06/01';
if (isset($_POST['fecini'])) {
  $cfecini = $_POST['fecini'];
}
$cfecfin = '2007/06/30';
if (isset($_POST['fecfin'])) {
  $cfecfin = $_POST['fecfin'];
}
$provee = '3';
if (isset($_POST['proveedor'])) {
  $provee = $_POST['proveedor'];
}
$descrip = '3';
if (isset($_POST['descrip'])) {
  $descrip = $_POST['descrip'];
}
$orden = '34066';
if (isset($_POST['orden'])) {
  $orden = $_POST['orden'];
}

if ($provee=="0" and $orden=="" and $descrip=="-") {
$query_cningresos = "SELECT * FROM v_terceros WHERE fecha BETWEEN '$cfecini' and '$cfecfin' ORDER BY fecha";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif($provee<>"0" and $orden=="" and $descrip=="-") {
$query_cningresos = "SELECT * FROM v_terceros WHERE idproveedor=$provee and fecha BETWEEN '$cfecini' and '$cfecfin' ORDER BY fecha";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE idproveedor=$provee and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($orden<>"" and $descrip=="-") {
$query_cningresos = "SELECT * FROM v_terceros WHERE idorden=$orden and fecha BETWEEN '$cfecini' and '$cfecfin' ORDER BY fecha";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE idorden=$orden and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}elseif ($orden=="" and $descrip<>"-") {
$query_cningresos = "SELECT * FROM v_terceros WHERE iddescrip=$descrip and fecha BETWEEN '$cfecini' and '$cfecfin' ORDER BY fecha";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE iddescrip=$descrip and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}else{
$query_cningresos = "SELECT * FROM v_terceros WHERE idorden=$orden and iddescrip=$descrip and fecha BETWEEN '$cfecini' and '$cfecfin' ORDER BY fecha";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$qtotal = "SELECT sum(valorus*cantidad) as soles,sum(valorud*cantidad) as dolar FROM v_terceros WHERE idorden=$orden and iddescrip=$descrip and fecha BETWEEN '$cfecini' and '$cfecfin'";
$qtotexc = $cnx_cuzzicia->SelectLimit($qtotal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_qtotexc = $qtotexc->RecordCount();
}
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
    <td class="KT_th">-</td>
    <td class="KT_th">TSOLES</td>
    <td class="KT_th">TDOLAR</td>
  </tr>
  <tr>
    <td>TOTAL SELECCION:&gt;&gt;&gt; </td>
    <td><?php echo number_format($qtotexc->Fields('soles'),2); ?></td>
    <td><?php echo number_format($qtotexc->Fields('dolar'),2); ?></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">PROVEEDOR</td>
    <td class="KT_th">DEESCRIPCION</td>
    <td class="KT_th">REF.</td>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">CANT.</td>
    <td class="KT_th">V. S/. </td>
    <td class="KT_th">V. $. </td>
  </tr>
    <?php
  while (!$cningresos->EOF) { 
?>
  <tr>
    <td><?php echo $cningresos->Fields('fecha'); ?></td>
    <td><?php echo $cningresos->Fields('proveedor'); ?></td>
    <td><?php echo $cningresos->Fields('descripcion'); ?></td>
    <td><?php echo $cningresos->Fields('referencia'); ?></td>
    <td align="right"><?php echo $cningresos->Fields('idorden'); ?></td>
    <td align="right"><?php echo $cningresos->Fields('cantidad'); ?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('valorus'),2); ?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('valorud'),2); ?></td>
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