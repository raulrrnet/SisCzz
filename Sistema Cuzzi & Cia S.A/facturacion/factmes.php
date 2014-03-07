<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

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
// begin Recordset ordenes terminadas
$query_t = "SELECT idorden,cliente,max(descripcion),sum(cantidad) as cant, sum(monto) as pu, sum(cantidad*monto) as tot, und FROM factura f,detallefact df,clientes c WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and fecha BETWEEN '$fecini' and '$fecfin' and estado<>'anulada' and idorden<>0 group by idorden,cliente,und order by idorden";
$otermi = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
$totermi = $otermi->RecordCount();
// end Recordset
$ttotal=0;
//PHP ADODB document - made with PHAkt 3.6.0
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
document.form1.action= "factmes.php"
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
    <td colspan="4" align="center" class="selected_cal"><form name="form1" method="post" >
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>FACTURACION AL <?php echo $fecfin ?></strong></td>
  </tr>
<?php if (isset($_POST['fecha']) && $_POST['fecha']<>"") { ?>
  
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">CANT.</td>
  </tr>
  <?php
  while (!$otermi->EOF) { 
/*$ordent = $otermi->Fields('idorden');

$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$ordent";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());

$query_cningresos = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vusoles*cantidad) end) as mes,sum(vusoles*cantidad) as soles FROM movimientos WHERE movimiento='Salida' and idorden=$ordent";
$cningresos = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(vsoles*tiempo) end) as mes,sum(vsoles*tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and t.estado='si' and i.idorden=$ordent";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());

$query_terce = "SELECT sum(case when(fecha BETWEEN '$fecini' and '$fecfin') then(valorus*cantidad) end) as mes,sum(valorus*cantidad) as soles FROM v_terceros WHERE idorden=$ordent";
$cnterce = $cnx_cuzzicia->SelectLimit($query_terce) or die($cnx_cuzzicia->ErrorMsg());
*/
?>
  <tr>
    <td><?php echo $otermi->Fields('idorden'); ?></td>
    <td><?php echo $otermi->Fields('cliente'); ?></td>
    <td><div class="cdiv"><?php echo $otermi->Fields('max'); ?></div></td>
    <td align="right"><?php 
	if($otermi->Fields('und')=='Mill'){echo number_format($otermi->Fields('cant'),3);}else{echo number_format($otermi->Fields('cant'),2);}?>
    <?php echo $otermi->Fields('und'); ?></td>
  </tr>
<?php
    $otermi->MoveNext();
  }
?>
  <tr>
    <td colspan="3"><strong>TOTAL:</strong></td>
    <td align="right">&nbsp;</td>
  </tr>
<tr class="KT_buttons">
     <td colspan="4"><a href="#"><img src="../images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>
<?php } ?>