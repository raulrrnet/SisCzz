<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$fec__cningresos = '2001/01/01';
if (isset($_POST['fecha'])) {
  $fec__cningresos = $_POST['fecha'];
}
$tiposec = '';
if (isset($_POST['tiposec'])) {
  $tiposec = $_POST['tiposec'];
}
if($tiposec == 'Rotativa'){
// begin Recordset
$query_cnkardex = "SELECT * FROM v_informes WHERE fecha='$fec__cningresos' and cargo like '%Rotativa%' ORDER BY cargo,idinforme";
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
}else{
// begin Recordset
$query_cnkardex = "SELECT * FROM v_informes WHERE fecha='$fec__cningresos' and cargo not like '%Rotativa%' ORDER BY cargo,idinforme";
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
}
?>
<?php  $lastTFM_nest = "";?>
<?php
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Resumen Informes x Dia</title>
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
document.form1.action= "inforeporte.php"
document.form1.submit();
document.form1.target = "popup";
document.form1.action = "resultado.php"
document.form1.submit();
}
</script>
</head>
<body>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center" scope="col"><form name="form1" method="post" >
      <label>
      <select name="tiposec" id="tiposec">
        <option value="*" selected></option>
        <option value="Rotativa">Rotativa</option>
      </select>
      </label>
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td align="center" scope="col"><span class="Estilo2"><strong>INFORMES <?php echo $cnkardex->Fields('fecha'); ?></strong></span></td>
  </tr>
  <tr>
    <td scope="col"><table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <?php
  while (!$cnkardex->EOF) { 
?>
  <?php $TFM_nest = $cnkardex->Fields('idinforme');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
	?>
  <tr>
    <td colspan="8" class="selected_cal"><hr></td>
    </tr>
  <tr>
    <td colspan="2" class="KT_th">OPERARIO:</td>
    <td colspan="2"><?php echo $cnkardex->Fields('nombre'); ?></td>
	<td class="KT_th">CARGO:</td>
	<td colspan="3"><?php echo $cnkardex->Fields('cargo'); ?></td>
	</tr>
  <tr>
    <td colspan="2" class="KT_th">TOTAL TIEMPO: </td>
    <td colspan="6">
	<strong><?php
	$idope = $cnkardex->Fields('idoperario');
	$query_sumtiempo = "SELECT sum(tiempo) as sumtiempo FROM v_informes WHERE idoperario=$idope and fecha='$fec__cningresos'";
$sumtiempo = $cnx_cuzzicia->SelectLimit($query_sumtiempo) or die($cnx_cuzzicia->ErrorMsg());
	 echo $sumtiempo->Fields('sumtiempo');
	 ?></strong></td>
  </tr>
  <tr>
    <td class="KT_th">ID</td>
	<td class="KT_th">SECCION</td>
	<td class="KT_th">DESTINO</td>
    <td class="KT_th">OPERACION</td>
    <td class="KT_th">DETALLES</td>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">TIEMPO</td>
    <td class="KT_th">CANT.</td>
  </tr>
   <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
  <tr>
    <td><?php echo $cnkardex->Fields('iddetalle'); ?></td>
    <td><?php echo $cnkardex->Fields('seccion'); ?></td>
    <td><?php echo $cnkardex->Fields('destino'); ?></td>
    <td><?php echo $cnkardex->Fields('operacion'); ?></td>
    <td><?php echo $cnkardex->Fields('detalles'); ?></td>
    <td><?php echo $cnkardex->Fields('idorden'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('tiempo'); ?></td>
    <td align="right"><?php echo $cnkardex->Fields('cantidad'); ?></td>
  </tr>
  <?php
    $cnkardex->MoveNext(); 
  }
?>
</table>
    </td>
  </tr>
</table>
</body>
</html>