<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$colmat__actuliza = '1';
if (isset($_GET['idmaterial'])) {
  $colmat__actuliza = $_GET['idmaterial'];
}
$colname__actuliza = '100';
if (isset($_GET['iddiferencia'])) {
  $colname__actuliza = $_GET['iddiferencia'];
}
if (isset($_GET['fecha'])) {
  $fec = $_GET['fecha'];
}
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha);
$query_actuliza = sprintf("SELECT * FROM diferencias WHERE iddiferencia = %s and idmaterial = %s", GetSQLValueString($colname__actuliza, "int"),GetSQLValueString($colmat__actuliza, "int"));
$actuliza = $cnx_cuzzicia->SelectLimit($query_actuliza) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuliza = $actuliza->RecordCount();
// end Recordset

$query_saldos = "SELECT sum(saldo) as isaldo,sum(case when(movimiento='Ingreso') then(cantidad) end)-sum(case when(movimiento='Salida') then(cantidad) end) as saldo FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec' and idmateriales = $colmat__actuliza";
$saldos = $cnx_cuzzicia->SelectLimit($query_saldos) or die($cnx_cuzzicia->ErrorMsg());
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_salidas")) {
	$mat = $_POST['idmat'];
    $cant = $_POST['cantidad'];
    $id = $_POST['id'];
  $updateSQL = "UPDATE diferencias SET idmaterial=$mat, cantreport=$cant WHERE iddiferencia=$id";
                       
  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
	//redireccionando con javascript 
	echo "<script type=\"text/javascript\"> javascript:history.go(-2) </script>";
	echo "<script type=\"text/javascript\"> javascript:window.location.reload() </script>";
	//---------------------------
}
//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_salidas" id="frm_salidas">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">ACTUALIZA CANTIDAD </td>
    </tr>
    <tr>
      <td><input name="id" type="hidden" id="id" value="<?php echo $actuliza->Fields('iddiferencia'); ?>">
      <input name="idmat" type="hidden" id="idmat" value="<?php echo $actuliza->Fields('idmaterial'); ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Cantidad Kardex </td>
      <td class="KT_th">Cantidad Reportada</td>
    </tr>
    <tr>
     <td><input name="cantidad2" type="text" id="cantidad2" value="<?php if ($saldos->Fields('saldo')<>''){echo $saldos->Fields('saldo');
		}else{echo $saldos->Fields('isaldo');}?>" readonly="true" /></td>
     <td><input name="cantidad" type="text" id="cantidad" value="<?php echo $actuliza->Fields('cantreport'); ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Actualizar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frm_salidas">
</form>
</body>
</html>
<?php
$actuliza->Close();

$saldos->Close();
?>