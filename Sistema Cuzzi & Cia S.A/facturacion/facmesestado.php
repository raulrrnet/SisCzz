<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$fecha = '2013/02/28';
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
$query_p="SELECT idorden,max(cliente)as cliente,max(descripcion)as descripcion,sum(cantidad) as cant, max(monto) as pu, sum(cantidad*monto) as tot
FROM factura f,detallefact df, clientes c
WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and f.fecha BETWEEN '2013/02/01' and '2013/02/28' and estado<>'anulada' and idorden<>0
and idorden in (select idorden from orden where fechatermi is null and (fecha<='2013/02/28' or fecha is null) and (fechaliqui is null or fechaliqui > '2013/02/28'))
GROUP BY idorden ORDER BY idorden";
$oproceso = $cnx_cuzzicia->SelectLimit($query_p) or die($cnx_cuzzicia->ErrorMsg());
$toproceso = $oproceso->RecordCount();
// end Recordset
// begin Recordset ordenes terminadas
$query_t = "SELECT idorden,max(cliente)as cliente,max(descripcion)as descripcion,sum(cantidad) as cant, max(monto) as pu, sum(cantidad*monto) as tot
FROM factura f,detallefact df, clientes c
WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and f.fecha BETWEEN '2013/02/01' and '2013/02/28' and estado<>'anulada' and idorden<>0
and idorden in (select idorden from orden where fechaliqui BETWEEN '2013/02/01' and '2013/02/28')
GROUP BY idorden ORDER BY idorden";
$otermi = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
$totermi = $otermi->RecordCount();
// end Recordset
// begin Recordset ordenes terminadas meses ant.
$query_ma = "SELECT idorden,max(cliente)as cliente,max(descripcion)as descripcion,sum(cantidad) as cant, max(monto) as pu, sum(cantidad*monto) as tot
FROM factura f,detallefact df, clientes c
WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and f.fecha BETWEEN '2013/02/01' and '2013/02/28' and estado<>'anulada' and idorden<>0
and idorden in (select idorden from orden where fechaliqui < '2013/02/01' or fechatermi < '2013/02/01')
GROUP BY idorden ORDER BY idorden";
$otermima = $cnx_cuzzicia->SelectLimit($query_ma) or die($cnx_cuzzicia->ErrorMsg());
$tootermima = $otermima->RecordCount();
//PHP ADODB document - made with PHAkt 3.6.0
$msolesi=0;$msolesm=0;$msolest=0;$msolesit=0;$msolesmt=0;$msolestt=0;$tsolesi=0;$tsolesm=0;$tsolest=0;$tsolesit=0;$tsolesmt=0;$tsolestt=0;$ttsolest=0;$ttsolestt=0;$msolesita=0;$tsolesita=0;$msolesmta=0;$tsolesmta=0;$msolestta=0;$tsolestta=0;$ttsolestta=0;
$factp=0;
$factt=0;
$factta=0;
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Estado Ordenes</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 300px;
	overflow:auto;
	white-space:normal
}
-->
</style>
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
document.form1.action= "facmesestado.php"
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
    <td colspan="11" align="center" class="selected_cal"><form name="form1" method="post" >
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="11" align="center"><strong>ORDENES AL <?php echo $fecfin ?></strong></td>
  </tr>
  <tr>
    <td height="29" colspan="11" class="selected_cal"><span class="KT_th"> EN PROCESO </span></td>
  </tr>
<?php if (isset($_POST['fecha']) && $_POST['fecha']<>"") { ?>
  
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">CANT./M.</td>
    <td class="selected_cal">P.U./M.</td>
    <td class="selected_cal">TOTAL F. </td>
    <td class="selected_cal">G. PROD.</td>
    <td class="selected_cal">MAT.</td>
    <td class="selected_cal">TERC.</td>
    <td class="selected_cal"> TOTAL C.F. </td>
    <td class="selected_cal">MARGEN</td>
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
    <td><div class="cdiv"><?php echo $oproceso->Fields('descripcion'); ?></div></td>
    <td align="right"><?php echo $oproceso->Fields('cant'); ?></td>
    <td align="right"><?php echo $oproceso->Fields('pu'); ?></td>
    <td align="right"><?php $factp+=$tfactp=$oproceso->Fields('tot');
	echo number_format($oproceso->Fields('tot'),2); ?></td>
    <td align="right"><?php $msolesi+=$produc=0;
		echo number_format($produc,2);?></td>
    <td align="right"><?php $msolesm+=$mate=0;
		echo number_format($mate,2); ?></td>
    <td align="right"><?php $msolest+=$terce=0;
		echo number_format($terce,2); ?></td>
    <td align="right"><?php $ttsolest+=$tcfactp=$produc+$mate+$terce;
		echo number_format($produc+$mate+$terce,2); ?></td>
    <td align="right"><?php echo number_format($tfactp-$tcfactp,2); ?></td>
  </tr>
<?php
    $oproceso->MoveNext();
  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><?php echo number_format($factp,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesi,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesm,2); ?></strong></td>
  	<td align="right"><strong><?php echo number_format($msolest,2); ?></strong></td>
  	<td align="right"><strong><?php echo number_format($ttsolest,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($factp-$ttsolest,2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="11" class="selected_cal"><span class="KT_th"> TERMINADAS </span></td>
  </tr>
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">CANT./M.</td>
    <td class="selected_cal">P.U./M.</td>
    <td class="selected_cal">TOTAL F. </td>
    <td class="selected_cal">G. PROD.</td>
    <td class="selected_cal">MAT.</td>
    <td class="selected_cal">TERC.</td>
    <td class="selected_cal"> TOTAL C.F. </td>
    <td class="selected_cal">MARGEN</td>
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

$qf = "SELECT sum(cantidad) as cant FROM  factura f,detallefact df WHERE f.idfact=df.idfactura and idorden=$ordent and f.fecha <= '$fecfin' and estado<>'anulada' and idorden<>0";
$exqf = $cnx_cuzzicia->SelectLimit($qf) or die($cnx_cuzzicia->ErrorMsg());
if($datorden->Fields('cantprod')==0 || $datorden->Fields('cantprod')==1){
$cantfact = $exqf->Fields('cant');}else{$cantfact = $exqf->Fields('cant')*1000;}
?>
  <tr>
    <td><?php echo $otermi->Fields('idorden'); ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td><div class="cdiv"><?php echo $otermi->Fields('descripcion'); ?></div></td>
	<td align="right"><?php echo $otermi->Fields('cant'); ?></td>
    <td align="right"><?php echo $otermi->Fields('pu'); ?></td>
    <td align="right"><?php $factt+=$tfactt=$otermi->Fields('tot');
	echo number_format($otermi->Fields('tot'),2); ?></td>
    <td align="right"><?php $msolesit+=$prodt=$cndetinfo->Fields('soles')/$datorden->Fields('cantprod')*$cantfact;
		echo number_format($prodt,2);?></td>
    <td align="right"><?php $msolesmt+=$matet=$cningresos->Fields('soles')/$datorden->Fields('cantprod')*$cantfact;
		echo number_format($matet,2); ?></td>
    <td align="right"><?php $msolestt+=$tercet=$cnterce->Fields('soles')/$datorden->Fields('cantprod')*$cantfact;
		echo number_format($tercet,2); ?></td>
    <td align="right"><?php $ttsolestt+=$tcfactt=$prodt+$matet+$tercet;
		echo number_format($prodt+$matet+$tercet,2); ?></td>
    <td align="right"><?php echo number_format($tfactt-$tcfactt,2); ?></td>
  </tr>
<?php
    $otermi->MoveNext();
  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><?php echo number_format($factt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesit,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesmt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolestt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($ttsolestt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($factt-$ttsolestt,2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="11" class="selected_cal"><span class="KT_th"> TERMINADAS MESES ANT. </span></td>
  </tr>
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">CANT./M.</td>
    <td class="selected_cal">P.U./M.</td>
    <td class="selected_cal">TOTAL F. </td>
    <td class="selected_cal">G. PROD.</td>
    <td class="selected_cal">MAT.</td>
    <td class="selected_cal">TERC.</td>
    <td class="selected_cal"> TOTAL C.F. </td>
    <td class="selected_cal">MARGEN</td>
  </tr>
<?php
  while (!$otermima->EOF) { 
$ordentme = $otermima->Fields('idorden');

$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$ordentme";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());

$query_cningresos = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vusoles*cantidad) end) as mes,sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$ordentme";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vsoles*tiempo) end) as mes,sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$ordentme";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(valorus*cantidad) end) as mes,sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$ordentme";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());

if($datorden->Fields('cantprod')==0 || $datorden->Fields('cantprod')==1){
$cantfact = $otermima->Fields('cant');}else{$cantfact = $otermima->Fields('cant')*1000;}
?>
  <tr>
    <td><?php echo $otermima->Fields('idorden'); ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td><div class="cdiv"><?php echo $otermima->Fields('descripcion'); ?></div></td>
    <td align="right"><?php echo $otermima->Fields('cant'); ?></td>
    <td align="right"><?php echo $otermima->Fields('pu'); ?></td>
    <td align="right"><?php $factta+=$tfactt=$otermima->Fields('tot');
	echo number_format($otermima->Fields('tot'),2); ?></td>
    <td align="right"><?php $msolesita+=$prodt=$cndetinfo->Fields('soles')/$datorden->Fields('cantprod')*$cantfact;
		echo number_format($prodt,2);?></td>
    <td align="right"><?php $msolesmta+=$matet=$cningresos->Fields('soles')/$datorden->Fields('cantprod')*$cantfact;
		echo number_format($matet,2); ?></td>
    <td align="right"><?php $msolestta+=$tercet=$cnterce->Fields('soles')/$datorden->Fields('cantprod')*$cantfact;
		echo number_format($tercet,2); ?></td>
    <td align="right"><?php $ttsolestta+=$tcfactt=$prodt+$matet+$tercet;
		echo number_format($prodt+$matet+$tercet,2); ?></td>
    <td align="right"><?php echo number_format($tfactt-$tcfactt,2); ?></td>
  </tr>
<?php
    $otermima->MoveNext();
  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><?php echo number_format($factta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesita,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesmta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($ttsolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($factta-$ttsolestta,2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>TOTAL GENERAL:</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><?php echo number_format($factp+$factt+$factta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesi+$msolesit+$msolesita,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolesm+$msolesmt+$msolesmta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolest+$msolestt+$msolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($ttsolest+$ttsolestt+$ttsolestta,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format(($factp+$factt+$factta)-($ttsolest+$ttsolestt+$ttsolestta),2); ?></strong></td>
  </tr>
<tr class="KT_buttons">
     <td colspan="11"><a href="#"><img src="../images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>
<?php } ?>