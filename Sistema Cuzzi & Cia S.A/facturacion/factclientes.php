<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$fecini = '2000/01/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$fecfin = '2000/01/01';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
// begin Recordset
$query_Recordset1 = "SELECT f.idfact,fecha,cliente,moneda,sum(monto*cantidad)as soles,sum(mdolar*cantidad)as dolar FROM factura f, detallefact df, clientes c WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and fecha BETWEEN '$fecini' and '$fecfin' and estado<>'anulada' GROUP BY f.idfact,fecha,cliente,moneda ORDER BY fecha";
$Recordset1 = $cnx_cuzzicia->SelectLimit($query_Recordset1) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_Recordset1 = $Recordset1->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturaci&oacute;n Clientes</title>
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
document.form1.action= "factclientes.php"
document.form1.submit();
}
</script>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="5" align="center" class="selected_cal"><form name="form1" method="post" >
      <input name="fecini" id="fecini" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      -
      <input name="fecfin" id="fecfin" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><strong>FACTURACION DEL <?php echo $fecini ?> AL <?php echo $fecfin ?></strong></td>
  </tr>
  
  <tr>
    <td class="selected_cal">N&ordm; FAct. </td>
    <td class="selected_cal">Fecha</td>
    <td class="selected_cal">Cliente</td>
    <td class="selected_cal">Moneda</td>
    <td class="selected_cal">Monto</td>
  </tr>
  <?php
  while (!$Recordset1->EOF) { 
?>
    <tr>
      <td><?php echo $Recordset1->Fields('idfact'); ?></td>
      <td><?php echo $Recordset1->Fields('fecha'); ?></td>
      <td><?php echo $Recordset1->Fields('cliente'); ?></td>
      <td><?php echo $Recordset1->Fields('moneda'); ?></td>
      <td align="right"><?php if ($Recordset1->Fields('moneda')=='soles'){echo number_format($Recordset1->Fields('soles'),2);} else{echo number_format($Recordset1->Fields('dolar'),2);} ?></td>
    </tr>
    <?php
    $Recordset1->MoveNext(); 
  }
?>
<tr class="KT_buttons">
     <td colspan="5"><a href="#"><img src="../images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>
<?php
$Recordset1->Close();
?>
