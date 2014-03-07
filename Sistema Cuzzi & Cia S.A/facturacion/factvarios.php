<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//PHP ADODB document - made with PHAkt 3.7.1
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
// begin Recordset ordenes terminadas
$query_t = "SELECT idorden, sum(cantidad*monto) as tfact FROM factura f, detallefact df, clientes c
WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and fecha BETWEEN '2012/01/01' and '2012/12/31'
and estado<>'anulada' and idorden<>0
GROUP BY idorden ORDER BY idorden";
$otermi = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
$totermi = $otermi->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.6.0
$msolesi=0;$msolesm=0;$msolest=0;$msolesit=0;$msolesmt=0;$msolestt=0;$tsolesi=0;$tsolesm=0;$tsolest=0;$tsolesit=0;$tsolesmt=0;$tsolestt=0;$ttsolest=0;$ttsolestt=0;$msolesita=0;$tsolesita=0;$msolesmta=0;$tsolesmta=0;$msolestta=0;$tsolestta=0;$ttsolestta=0;
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
document.form1.action= "factvarios.php"
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
    <td colspan="9" align="center"><strong>ORDENES AL <?php echo $fecfin ?></strong></td>
  </tr>
  <tr>
    <td colspan="9" class="selected_cal"><span class="KT_th"> - </span></td>
  </tr>
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">TOT.FACT. </td>
    <td class="selected_cal">CANT.FACT.</td>
    <td class="selected_cal">TOT.MAT.</td>
    <td class="selected_cal">TOT.TERC.</td>
    <td class="selected_cal">CANT.PROD.</td>
    <td class="selected_cal">MAT.</td>
    <td class="selected_cal">TERC.</td>
  </tr>
  <?php
  while (!$otermi->EOF) { 
$ordent = $otermi->Fields('idorden');

$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$ordent";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());

$query_cningresos = "SELECT sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$ordent";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$ordent";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$ordent";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());

$qf = "SELECT sum(cantidad) as cant FROM  factura f,detallefact df WHERE f.idfact=df.idfactura and idorden=$ordent and f.fecha BETWEEN '2012/01/01' and '2012/12/31' and estado<>'anulada' and idorden<>0";
$exqf = $cnx_cuzzicia->SelectLimit($qf) or die($cnx_cuzzicia->ErrorMsg());
if($datorden->Fields('cantprod')==0 || $datorden->Fields('cantprod')==1){
$cantfact = $exqf->Fields('cant');}else{$cantfact = $exqf->Fields('cant')*1000;}
?>
  <tr>
    <td><?php echo $otermi->Fields('idorden'); ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td align="right"><?php echo number_format($otermi->Fields('tfact'),2); ?></td>
    <td align="right"><?php echo number_format($cantfact,2); ?></td>
    <td align="right"><?php echo number_format($cningresos->Fields('soles'),2); ?></td>
    <td align="right"><?php echo number_format($cnterce->Fields('soles'),2); ?></td>
    <td align="right"><?php echo number_format($datorden->Fields('cantprod'),2); ?></td>
    <td align="right"><?php $msolesmt+=$matet=$cningresos->Fields('soles')*$cantfact/$datorden->Fields('cantprod');
		echo number_format($matet,2); ?></td>
    <td align="right"><?php $msolestt+=$tercet=$cnterce->Fields('soles')*$cantfact/$datorden->Fields('cantprod');
		echo number_format($tercet,2); ?></td>
  </tr>
<?php
    $otermi->MoveNext();
  }
?>
  <tr>
    <td colspan="2"><strong>TOTAL:</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><strong><?php echo number_format($msolesmt,2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($msolestt,2); ?></strong></td>
  </tr>
<tr class="KT_buttons">
     <td colspan="9"><a href="#"><img src="../images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>