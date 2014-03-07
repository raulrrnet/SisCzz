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
// begin Recordset
$query_saldos = "SELECT o.idorden,
         o.idcliente,
         max(d.descripcion) AS descripcion,
         max(o.cantprod) AS cantprod,
         max(o.cantpedi) AS cantpedi,
         sum(CASE
               WHEN d.und = 'Mill' THEN d.cantidad * 1000
               ELSE d.cantidad
             END) AS cantfact,
         max(o.cantprod) - sum(CASE
                                 WHEN d.und = 'Mill'  THEN
                                  d.cantidad * 1000
                                 ELSE d.cantidad
                               END) AS saldo
  FROM orden o,
       detallefact d,
       factura f
  WHERE f.idfact = d.idfactura AND
        d.idorden = o.idorden AND
        o.fechaliqui <= '$fecha' AND
        f.fecha <= '$fecha' AND
        f.estado <> 'anulada'  AND
        d.idorden <> 0
  GROUP BY o.idorden,
           o.idcliente ORDER BY idorden";
$saldos = $cnx_cuzzicia->SelectLimit($query_saldos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_saldos = $saldos->RecordCount();
// end Recordset
$tcsaldo = 0;
//PHP ADODB document - made with PHAkt 3.7.1
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
<script language="javascript">
function envio_form(){
document.form1.target = "_self";
document.form1.action= "inventario.php"
document.form1.submit();
}
</script>
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
</head>
<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="7" align="center" class="selected_cal"><form name="form1" method="post" >
      <input name="fecha" id="fecha" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
                        </form></td>
  </tr>
<?php if (isset($_POST['fecha']) && $_POST['fecha']<>"") { ?>
  <tr>
    <td colspan="7" align="center" class="KT_tngtable"><strong>INVENTARIO PRODUCTOS TERMINADOS  AL <?php echo $fecha; ?></strong></td>
  </tr>
  <tr>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">DESCRIPCION</td>
    <td align="right" class="KT_th">CANT. PROD. </td>
    <td align="right" class="KT_th">CANT. FACT.</td>
    <td align="right" class="KT_th">SALDO</td>
    <td align="right" class="KT_th">COSTO TOTAL </td>
    <td align="right" class="KT_th">COSTO SALDO </td>
  </tr>
  <?php
  while (!$saldos->EOF) { 
if($saldos->Fields('saldo') > 0 ){
$ord = $saldos->Fields('idorden');
$q_cningresos = "SELECT sum(vusoles*cantidad) as soles FROM v_consultas WHERE movimiento='Salida' and idorden=$ord";
$cningresos = $cnx_cuzzicia->SelectLimit($q_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$q_detinfo = "Select sum(vsoles * tiempo) as soles FROM v_informes i,v_tarifas t WHERE i.idseccion=t.idseccion and idorden = $ord and t.estado='si'";
$cndetinfo = $cnx_cuzzicia->SelectLimit($q_detinfo) or die($cnx_cuzzicia->ErrorMsg());
$q_terce = "SELECT sum(cantidad*valorus) as soles FROM v_terceros WHERE idorden=$ord";
$cnterce = $cnx_cuzzicia->SelectLimit($q_terce) or die($cnx_cuzzicia->ErrorMsg());

$ctotal = $cndetinfo->Fields('soles')+$cningresos->Fields('soles')+$cnterce->Fields('soles');
?>
    <tr>
      <td><?php echo $saldos->Fields('idorden'); ?></td>
      <td><div class="cdiv"><?php echo $saldos->Fields('descripcion'); ?></div></td>
      <td align="right"><?php echo number_format($saldos->Fields('cantprod'),0); ?></td>
      <td align="right"><?php echo number_format($saldos->Fields('cantfact'),0); ?></td>
      <td align="right"><?php echo number_format($saldos->Fields('saldo'),0); ?></td>
      <td align="right"><?php echo number_format($ctotal,2); ?></td>
      <td align="right"><?php $tcsaldo += $ctotal/$saldos->Fields('cantprod')*$saldos->Fields('saldo');
	  echo number_format($ctotal/$saldos->Fields('cantprod')*$saldos->Fields('saldo'),2); ?></td>
    </tr>
    <?php
    $saldos->MoveNext(); 
  	}else{$saldos->MoveNext();}
  }
?>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="right"><strong><?php echo number_format($tcsaldo,2); ?></strong></td>
</tr>
</table>
</body>
</html>
<?php
}
$saldos->Close();
?>