<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

// begin Recordset
$fec_ = '2003/05/20';
if (isset($_POST['fecha'])) {
  $fec_ = $_POST['fecha'];
}
$fecfecha = strtotime($fec_); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT g.nombre,date_part('year', fecha) as año,
sum(case when(date_part('month', fecha)=1) then(cantidad*monto) end) as enero,
sum(case when(date_part('month', fecha)=2) then(cantidad*monto) end) as febrero,
sum(case when(date_part('month', fecha)=3) then(cantidad*monto) end) as marzo,
sum(case when(date_part('month', fecha)=4) then(cantidad*monto) end) as abril,
sum(case when(date_part('month', fecha)=5) then(cantidad*monto) end) as mayo,
sum(case when(date_part('month', fecha)=6) then(cantidad*monto) end) as junio,
sum(case when(date_part('month', fecha)=7) then(cantidad*monto) end) as julio,
sum(case when(date_part('month', fecha)=8) then(cantidad*monto) end) as agosto,
sum(case when(date_part('month', fecha)=9) then(cantidad*monto) end) as setiembre,
sum(case when(date_part('month', fecha)=10) then(cantidad*monto) end) as octubre,
sum(case when(date_part('month', fecha)=11) then(cantidad*monto) end) as noviembre,
sum(case when(date_part('month', fecha)=12) then(cantidad*monto) end) as diciembre,
sum(cantidad*monto) as th
FROM factura f,detallefact df,clientes c,gclientes g
WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and c.idgcliente = g.idgclien and fecha <= '$fec_' and estado<>'anulada' and idorden<>0
GROUP BY g.nombre,orden,date_part('year', fecha) ORDER BY orden");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$query_t = sprintf("SELECT date_part('year', fecha) as año,
sum(case when(date_part('month', fecha)=1) then(cantidad*monto) end) as enero,
sum(case when(date_part('month', fecha)=2) then(cantidad*monto) end) as febrero,
sum(case when(date_part('month', fecha)=3) then(cantidad*monto) end) as marzo,
sum(case when(date_part('month', fecha)=4) then(cantidad*monto) end) as abril,
sum(case when(date_part('month', fecha)=5) then(cantidad*monto) end) as mayo,
sum(case when(date_part('month', fecha)=6) then(cantidad*monto) end) as junio,
sum(case when(date_part('month', fecha)=7) then(cantidad*monto) end) as julio,
sum(case when(date_part('month', fecha)=8) then(cantidad*monto) end) as agosto,
sum(case when(date_part('month', fecha)=9) then(cantidad*monto) end) as setiembre,
sum(case when(date_part('month', fecha)=10) then(cantidad*monto) end) as octubre,
sum(case when(date_part('month', fecha)=11) then(cantidad*monto) end) as noviembre,
sum(case when(date_part('month', fecha)=12) then(cantidad*monto) end) as diciembre,
sum(cantidad*monto) as tt
FROM factura f,detallefact df,clientes c 
WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and fecha <= '$fec_' and estado<>'anulada' and idorden<>0
GROUP BY date_part('year', fecha) ORDER BY date_part('year', fecha)");
$exect = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
//PHP ADODB document - made with PHAkt 3.6.0
?>
<?php  $lastTFM_nest = "";?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Facturaci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<script language="javascript">
function envio_form(){
document.form1.target = "_self";
document.form1.action= "facturacion.php"
document.form1.submit();
}
</script>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="14" align="center" class="selected_cal">
	<form name="form1" method="post" >
      <input name="fecha" id="fecha" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form>	</td>
  </tr>
  <tr>
    <td colspan="14" align="center"><strong>FACTURACION AL <?php echo $fec_ ?></strong></td>
  </tr>
<?php if (isset($_POST['fecha']) && $_POST['fecha']<>"") { ?>
  <tr>
    <td align="center" class="selected_cal">A&Ntilde;O</td>
    <td align="center" class="selected_cal">ENERO</td>
    <td align="center" class="selected_cal">FEBRERO</td>
    <td align="center" class="selected_cal">MARZO</td>
    <td align="center" class="selected_cal">ABRIL</td>
    <td align="center" class="selected_cal">MAYO</td>
    <td align="center" class="selected_cal">JUNIO</td>
    <td align="center" class="selected_cal">JULIO</td>
    <td align="center" class="selected_cal">AGOSTO</td>
    <td align="center" class="selected_cal">SETIEMBRE</td>
    <td align="center" class="selected_cal">OCTUBRE</td>
    <td align="center" class="selected_cal">NOVIEMBRE</td>
    <td align="center" class="selected_cal">DICIEMBRE</td>
    <td align="center" class="selected_cal">TOTAL</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>

  <?php $TFM_nest = $cnkardex->Fields('nombre');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
	$unisal=0;
	$sa=0; ?>
  <tr>
    <td colspan="14" class="selected_cal"><?php echo $cnkardex->Fields('nombre');?></td>
    </tr>
   <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
   <tr>
     <td><?php echo $cnkardex->Fields('año');?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('enero'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('febrero'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('marzo'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('abril'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('mayo'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('junio'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('julio'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('agosto'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('setiembre'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('octubre'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('noviembre'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('diciembre'),2);?></td>
     <td align="right"><?php echo number_format($cnkardex->Fields('th'),2);?></td>
   </tr>
<?php
    $cnkardex->MoveNext(); 
  }
?>
   <tr>
     <td colspan="14"><hr></td>
   </tr>
  <?php
  while (!$exect->EOF) { 
?>
   <tr>
     <td><?php echo $exect->Fields('año');?></td>
     <td align="right"><?php echo number_format($exect->Fields('enero'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('febrero'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('marzo'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('abril'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('mayo'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('junio'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('julio'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('agosto'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('setiembre'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('octubre'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('noviembre'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('diciembre'),2);?></td>
     <td align="right"><?php echo number_format($exect->Fields('tt'),2);?></td>
   </tr>
<?php
    $exect->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php } ?>