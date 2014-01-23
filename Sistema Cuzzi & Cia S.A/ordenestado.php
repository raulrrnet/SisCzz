<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

$fecha = '2001/01/01';
if (isset($_POST['fecha'])) {
  $fecha = $_POST['fecha'];
}
$fecfecha = strtotime($fecha); 
$anio = date("Y",$fecfecha);
$mes = date("m",$fecfecha);
$ud = date("t",$fecfecha);
$fecini = $anio."/".$mes."/01";
$fecfin = $anio."/".$mes."/".$ud;
// begin Recordset ordenes en proceso
$query_p="select idorden from orden where fechatermi is null and (fecha<='$fecha' or fecha is null) and (fechaliqui is null or fechaliqui > '$fecha') order by idorden";
$oproceso = $cnx_cuzzicia->SelectLimit($query_p) or die($cnx_cuzzicia->ErrorMsg());
$toproceso = $oproceso->RecordCount();
// end Recordset
// begin Recordset ordenes terminadas
$query_t = "select idorden from orden where fechaliqui BETWEEN '$fecini' and '$fecfin' order by idorden";
$otermi = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
$totermi = $otermi->RecordCount();
// end Recordset
$query_om = "SELECT * FROM movimientos m,orden o WHERE m.idorden=o.idorden and m.fecha BETWEEN '$fecini' and '$fecfin' and (o.fechaliqui<'$fecini' or o.fechatermi<'$fecini')and m.idorden<>0";
$otrosm = $cnx_cuzzicia->SelectLimit($query_om) or die($cnx_cuzzicia->ErrorMsg());
$tootrosm = $otrosm->RecordCount();
$query_ot = "SELECT * FROM v_tarifas t,v_informes i,orden o
WHERE i.fecha BETWEEN '$fecini' and '$fecfin' and t.estado='si' and i.idseccion=t.idseccion and i.idorden=o.idorden and (o.fechaliqui<'$fecini' or o.fechatermi<'$fecini') and i.idorden<>0;";
$otrost = $cnx_cuzzicia->SelectLimit($query_ot) or die($cnx_cuzzicia->ErrorMsg());
$tootrosi = $otrost->RecordCount();
$query_ote = "SELECT * FROM v_terceros t,orden o WHERE t.fecha BETWEEN '$fecini' and '$fecfin' and t.idorden=o.idorden and (o.fechaliqui<'$fecini' or o.fechatermi<'$fecini') and t.idorden<>0;";
$otroste = $cnx_cuzzicia->SelectLimit($query_ote) or die($cnx_cuzzicia->ErrorMsg());
$tootrost = $otroste->RecordCount();
//PHP ADODB document - made with PHAkt 3.6.0
$msolesi=0;$msolesm=0;$msolest=0;$msolesit=0;$msolesmt=0;$msolestt=0;$tsolesi=0;$tsolesm=0;$tsolest=0;$tsolesit=0;$tsolesmt=0;$tsolestt=0;$ttsolest=0;$ttsolestt=0;$msolesita=0;$tsolesita=0;$msolesmta=0;$tsolesmta=0;$msolestta=0;$tsolestta=0;$ttsolestta=0;
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Estado Ordenes</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 300px;
	overflow:auto;
	white-space:normal
}
-->
</style>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
<script language="javascript">
function envio_form(){
document.form1.target = "_self";
document.form1.action= "ordenestado.php"
document.form1.submit();
}
</script>
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 300px;
	overflow:auto;
	white-space:normal
}
-->
</style>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="10" align="center" class="selected_cal"><form name="form1" method="post" >
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="10" align="center"><strong>ORDENES AL <?php echo $fecfin ?></strong></td>
  </tr>
  <tr>
    <td colspan="10" class="selected_cal"><span class="KT_th"> EN PROCESO </span></td>
  </tr>
<?php if (isset($_POST['fecha']) && $_POST['fecha']<>"") { ?>
  
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">G. PROD. MES</td>
    <td class="selected_cal">G. PROD. TOTAL</td>
    <td class="selected_cal">MAT. MES</td>
    <td class="selected_cal">MAT. TOTAL</td>
    <td class="selected_cal">TERC. MES</td>
    <td class="selected_cal">TERC. TOTAL</td>
    <td class="selected_cal">COSTO TOTAL</td>
  </tr>
  <?php
  while (!$oproceso->EOF) { 
$orden = $oproceso->Fields('idorden');

$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$orden";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());

$query_cningresos = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vusoles*cantidad) end) as mes,sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$orden and fecha<='$fecha'";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vsoles*tiempo) end) as mes,sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$orden and fecha<='$fecha'";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(valorus*cantidad) end) as mes,sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$orden and fecha<='$fecha'";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
?>
  <tr>
    <td><?php echo $oproceso->Fields('idorden'); ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td><div class="cdiv"><?php echo $datorden->Fields('descripcion'); ?></div></td>
    <td align="right"><?php $msolesi+=$cndetinfo->Fields('mes');
		echo number_format($cndetinfo->Fields('mes'),2);?></td>
    <td align="right"><?php $tsolesi+=$cndetinfo->Fields('soles');
		echo number_format($cndetinfo->Fields('soles'),2);?></td>
    <td align="right"><?php $msolesm+=$cningresos->Fields('mes');
		echo number_format($cningresos->Fields('mes'),2); ?></td>
    <td align="right"><?php $tsolesm+=$cningresos->Fields('soles');
		echo number_format($cningresos->Fields('soles'),2); ?></td>
    <td align="right"><?php $msolest+=$cnterce->Fields('mes');
		echo number_format($cnterce->Fields('mes'),2); ?></td>
    <td align="right"><?php $tsolest+=$cnterce->Fields('soles');
		echo number_format($cnterce->Fields('soles'),2); ?></td>
    <td align="right"><?php $ttsolest+=$cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles');
		echo number_format($cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles'),2); ?></td>
  </tr>
<?php
    $oproceso->MoveNext();
  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right"><strong><?php echo number_format($msolesi,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesi,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesm,2); ?></strong></td>
  	<td align="right"><strong><?php echo number_format($tsolesm,2); ?></strong></td>
  	<td align="right"><strong><?php echo number_format($msolest,2); ?></strong></td>
  	<td align="right"><strong><?php echo number_format($tsolest,2); ?></strong></td>
  	<td align="right"><strong><?php echo number_format($ttsolest,2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="10" class="selected_cal"><span class="KT_th"> TERMINADAS </span></td>
  </tr>
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">G. PROD. MES</td>
    <td class="selected_cal">G. PROD. TOTAL</td>
    <td class="selected_cal">MAT. MES</td>
    <td class="selected_cal">MAT. TOTAL</td>
    <td class="selected_cal">TERC. MES</td>
    <td class="selected_cal">TERC. TOTAL</td>
    <td class="selected_cal">COSTO TOTAL</td>
  </tr>
  <?php
  while (!$otermi->EOF) { 
$ordent = $otermi->Fields('idorden');

$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$ordent";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());

$query_cningresos = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vusoles*cantidad) end) as mes,sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$ordent";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vsoles*tiempo) end) as mes,sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$ordent";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(valorus*cantidad) end) as mes,sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$ordent";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
?>
  <tr>
    <td><?php echo $otermi->Fields('idorden'); ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td><div class="cdiv"><?php echo $datorden->Fields('descripcion'); ?></div></td>
    <td align="right"><?php $msolesit+=$cndetinfo->Fields('mes');
		echo number_format($cndetinfo->Fields('mes'),2);?></td>
    <td align="right"><?php $tsolesit+=$cndetinfo->Fields('soles');
		echo number_format($cndetinfo->Fields('soles'),2);?></td>
    <td align="right"><?php $msolesmt+=$cningresos->Fields('mes');
		echo number_format($cningresos->Fields('mes'),2); ?></td>
    <td align="right"><?php $tsolesmt+=$cningresos->Fields('soles');
		echo number_format($cningresos->Fields('soles'),2); ?></td>
    <td align="right"><?php $msolestt+=$cnterce->Fields('mes');
		echo number_format($cnterce->Fields('mes'),2); ?></td>
    <td align="right"><?php $tsolestt+=$cnterce->Fields('soles');
		echo number_format($cnterce->Fields('soles'),2); ?></td>
    <td align="right"><?php $ttsolestt+=$cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles');
		echo number_format($cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles'),2); ?></td>
  </tr>
<?php
    $otermi->MoveNext();
  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right"><strong><?php echo number_format($msolesit,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesit,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesmt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesmt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolestt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolestt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($ttsolestt,2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="10" class="selected_cal"><span class="KT_th"> TERMINADAS MESES ANT.</span></td>
  </tr>
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">G. PROD. MES</td>
    <td class="selected_cal">G. PROD. TOTAL</td>
    <td class="selected_cal">MAT. MES</td>
    <td class="selected_cal">MAT. TOTAL</td>
    <td class="selected_cal">TERC. MES</td>
    <td class="selected_cal">TERC. TOTAL</td>
    <td class="selected_cal">COSTO TOTAL</td>
  </tr>
  <?php
  $xt = $tootrosm+$tootrosi+$tootrost;
  if($xt>0){
  while (!$otrost->EOF) { 
	$ord[] = $otrost->Fields('idorden');
  	$otrost->MoveNext();
  }
  while (!$otrosm->EOF) { 
	$ord[] = $otrosm->Fields('idorden');
	$otrosm->MoveNext();
  }
  while (!$otroste->EOF) { 
	$ord[] = $otroste->Fields('idorden');
	$otroste->MoveNext();
  }
  $ordsd = array_unique($ord);
  sort($ordsd);
  foreach($ordsd as $id){
$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$id";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());
$query_cningresos = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vusoles*cantidad) end) as mes,sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$id";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vsoles*tiempo) end) as mes,sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$id";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(valorus*cantidad) end) as mes,sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$id";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
  ?>
  <tr>
    <td><?php echo $id; ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td><div class="cdiv"><?php echo $datorden->Fields('descripcion'); ?></div></td>
    <td align="right"><?php $msolesita+=$cndetinfo->Fields('mes');
		echo number_format($cndetinfo->Fields('mes'),2);?></td>
    <td align="right"><?php $tsolesita+=$cndetinfo->Fields('soles');
		echo number_format($cndetinfo->Fields('soles'),2);?></td>
    <td align="right"><?php $msolesmta+=$cningresos->Fields('mes');
		echo number_format($cningresos->Fields('mes'),2); ?></td>
    <td align="right"><?php $tsolesmta+=$cningresos->Fields('soles');
		echo number_format($cningresos->Fields('soles'),2); ?></td>
    <td align="right"><?php $msolestta+=$cnterce->Fields('mes');
		echo number_format($cnterce->Fields('mes'),2); ?></td>
    <td align="right"><?php $tsolestta+=$cnterce->Fields('soles');
		echo number_format($cnterce->Fields('soles'),2); ?></td>
    <td align="right"><?php $ttsolestta+=$cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles');
		echo number_format($cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles'),2); ?></td>
  </tr>
<?php
}  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right"><strong><?php echo number_format($msolesita,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesita,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesmta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesmta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($ttsolestta,2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>TOTAL GENERAL:</strong></td>
    <td align="right"><strong><?php echo number_format($msolesi+$msolesit+$msolesita,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesi+$tsolesit+$tsolesita,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesm+$msolesmt+$msolesmta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolesm+$tsolesmt+$tsolesmta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolest+$msolestt+$msolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($tsolest+$tsolestt+$tsolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($ttsolest+$ttsolestt+$ttsolestta,2); ?></strong></td>
  </tr>
<tr class="KT_buttons">
     <td colspan="10"><a href="#"><img src="images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>
<?php } ?>