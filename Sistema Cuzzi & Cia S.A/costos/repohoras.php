<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

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
$query_cnkardex = sprintf("select *,case when((ttiempo-tiempo) > 8 and dospri='35') then((ttiempo-tiempo)-8) when((ttiempo-tiempo) between 0.1 and 2 and dospri='25') then(ttiempo-tiempo) when((ttiempo-tiempo)>2 and dospri='25') then(2) end as veinticinco,case when(dospri='35' and sgts='35' and (ttiempo-tiempo)>8) then(8) when(dospri='35' and sgts='35' and (ttiempo-tiempo)<=8) then(ttiempo-tiempo) when((ttiempo-tiempo)>2 and sgts='35') then((ttiempo-tiempo)-2) end as treinticinco,case when(dospri='100' and (ttiempo-tiempo)>0) then(ttiempo-tiempo) end as cien,case when(dospri='200' and (ttiempo-tiempo)>0) then(ttiempo-tiempo) end as doscien,case when((ttiempo-tiempo)<0) then(ttiempo-tiempo) end as dmenos from v_calen where idope=$opera and fecha between '$fecini' and '$fecfin'");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$query_sum = sprintf("select sum(tiempo) as tdebio,sum(ttiempo) as treal,sum(case when((ttiempo-tiempo) > 8 and dospri='35') then((ttiempo-tiempo)-8) when((ttiempo-tiempo) between 0.1 and 2 and dospri='25') then(ttiempo-tiempo) when((ttiempo-tiempo)>2 and dospri='25') then(2) end) as veinticinco,sum(case when(dospri='35' and sgts='35' and (ttiempo-tiempo)>8) then(8) when(dospri='35' and sgts='35' and (ttiempo-tiempo)<=8) then(ttiempo-tiempo) when((ttiempo-tiempo)>2 and sgts='35') then((ttiempo-tiempo)-2) end) as treinticinco,sum(case when(dospri='100' and (ttiempo-tiempo)>0) then(ttiempo-tiempo) end) as cien,sum(case when(dospri='200' and (ttiempo-tiempo)>0) then(ttiempo-tiempo) end) as doscien,sum(case when((ttiempo-tiempo)<0) then(ttiempo-tiempo) end) as dmenos from v_calen where idope=$opera and fecha between '$fecini' and '$fecfin'");
$cnsum = $cnx_cuzzicia->SelectLimit($query_sum) or die($cnx_cuzzicia->ErrorMsg());
//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Informe Horas-Trabajador</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo8 {font-size: 14px; font-weight: bold; }
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="KT_th">NOMBRE:</td>
    <td colspan="8"><?php echo $cnkardex->Fields('nombre'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">%1</td>
    <td class="KT_th">%2</td>
    <td class="KT_th">DEBIO</td>
    <td class="KT_th">REAL</td>
    <td class="KT_th">25%</td>
    <td class="KT_th">35%</td>
    <td class="KT_th">100%</td>
    <td class="KT_th">200%</td>
    <td class="KT_th">DE (--) </td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('fecha'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('dospri');?></td>
    <td align="right"><?php echo $cnkardex->Fields('sgts');?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('tiempo'),2);?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('ttiempo'),2);?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('veinticinco'),2);?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('treinticinco'),2);?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('cien'),2);?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('doscien'),2);?></td>
    <td align="right"><?php echo number_format($cnkardex->Fields('dmenos'),2);?></td>
  </tr>
  <?php
    $cnkardex->MoveNext(); 
  }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('tdebio'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('treal'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('veinticinco'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('treinticinco'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('cien'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('doscien'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('dmenos'),2);?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong>^ TOTAL 25 ^ </strong></td>
    <td align="right"><strong>^ TOTAL 35 ^</strong></td>
    <td align="right"><strong>^ TOTAL 100 ^</strong></td>
    <td align="right"><strong>^ TOTAL 200 ^</strong></td>
    <td align="right"><strong>^ TOTAL (--) ^</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong> A PAGAR</strong></td>
    <td align="right"><span class="Estilo8"><?php $a=$cnsum->Fields('veinticinco');
	$b=$cnsum->Fields('dmenos');
	if(abs($a) > abs($b)){
	echo number_format($a+$b,2);
	}else{echo number_format(0,2);}?></span></td>
    <td align="right"><span class="Estilo8"><?php $c=$cnsum->Fields('treinticinco');
	if(abs($a) < abs($b)){
	echo number_format($c+($a+$b),2);
	}else{echo number_format($c,2);}
	?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('cien'),2);?></span></td>
    <td align="right"><span class="Estilo8"><?php echo number_format($cnsum->Fields('doscien'),2);?></span></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$cnkardex->Close();
?>