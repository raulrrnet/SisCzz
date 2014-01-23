<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// Load the rating classes
require_once('includes/jaxon/widgets/editinplace/editinplace.php');

$edit1 = new EditInPlace("edit1");
$edit1->setConnection("cnx_cuzzicia");
$edit1->setTable("orden");
$edit1->setPrimaryKey("idorden");
$edit1->setEditField("fechacomp", "DATE_TYPE");
$edit1->setEnabledCondition("");

$ajax_service = new AjaxService();
$ajax_service->exportMethod('edit1', 'updateValue'); 
$ajax_service->handleAjaxRequest();

$fecha = date('Y/m/d');
if (isset($_POST['fecha'])) {
  $fecha = $_POST['fecha'];
}
// begin Recordset ordenes en proceso
$query_p="select idorden from orden where fechatermi is null and (fecha<='$fecha' or fecha is null) and (fechaliqui is null or fechaliqui > '$fecha') order by fechacomp,idorden";
$oproceso = $cnx_cuzzicia->SelectLimit($query_p) or die($cnx_cuzzicia->ErrorMsg());
$toproceso = $oproceso->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.6.0
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Estado Ordenes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 600px;
	overflow:auto;
	white-space:normal
}
-->
</style>
<script type="text/javascript" src="includes/kore/kore.js"></script>
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
document.form1.action= "ordproce.php"
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
<link href="includes/jaxon/widgets/editinplace/css/editinplace.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/editinplace/js/editinplace.js"></script>
<?php 
  echo $ajax_service->renderJavascriptStubs();
?>
<link href="includes/jaxon/widgets/dialog/css/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/dialog/js/dialog.js"></script>
</head>
<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="7" align="center" class="selected_cal"><form name="form1" method="post" >
      <input name="fecha" id="fecha" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="7" align="center"><strong>ORDENES AL <?php echo $fecha; ?></strong></td>
  </tr>
  <tr>
    <td colspan="7" class="selected_cal"><span class="KT_th"> EN PROCESO </span></td>
  </tr>
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">CLIENTE</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">FECHA O. </td>
    <td class="selected_cal">ULT. PROCESO </td>
    <td class="selected_cal">F. COMP. O. </td>
    <td class="selected_cal">F. COMP. F. </td>
  </tr>
  <?php
  while (!$oproceso->EOF) { 
$orden = $oproceso->Fields('idorden');

$query_datorden = "SELECT * FROM orden o,clientes c WHERE o.idcliente = c.idcliente and idorden=$orden";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());

$query_detinfo = "SELECT seccion as proceso FROM v_informes WHERE idorden=$orden ORDER BY fecha desc, seccion asc";
$cndetinfo = $cnx_cuzzicia->SelectLimit($query_detinfo) or die($cnx_cuzzicia->ErrorMsg());
?>
  <tr>
    <td><?php echo $datorden->Fields('idorden'); ?></td>
    <td><?php echo $datorden->Fields('cliente'); ?></td>
    <td><div><?php echo $datorden->Fields('descripcion'); ?></div></td>
    <td><?php echo $datorden->Fields('fecha'); ?></td>
    <td><a href="procesos.php" onClick="new Widgets.Dialog('Procesos', 'proceso.php?idord=<?php echo $datorden->Fields('idorden'); ?>', { click_outside: true, width: 300, height: 300 }); return false;"><?php echo $cndetinfo->Fields('proceso'); ?></a></td>
    <td><?php echo $datorden->Fields('fechacomp2'); ?></td>
    <td><?php
echo $edit1->editForId($datorden->Fields('idorden'), $datorden->Fields('fechacomp'));
?></td>
  </tr>
<?php
    $oproceso->MoveNext();
  }
?>
<tr class="KT_buttons">
     <td colspan="7"><a href="#"><img src="images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>