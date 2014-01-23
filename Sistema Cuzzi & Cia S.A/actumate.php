<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');
// begin Recordset
$colname__materiales = '-1';
if (isset($_GET['idmateriales'])) {
  $colname__materiales = $_GET['idmateriales'];
}
$query_materiales = sprintf("SELECT * FROM materiales2 WHERE idmateriales = %s", GetSQLValueString($colname__materiales, "int"));
$materiales = $cnx_cuzzicia->SelectLimit($query_materiales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales = $materiales->RecordCount();
// end Recordset

// begin Recordset
$colname__actuliza = '-1';
if (isset($_GET['idmateriales'])) {
  $colname__actuliza = $_GET['idmateriales'];
}
$query_actuliza = sprintf("SELECT * FROM materiales WHERE idmateriales = %s", GetSQLValueString($colname__actuliza, "int"));
$actuliza = $cnx_cuzzicia->SelectLimit($query_actuliza) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuliza = $actuliza->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
//-------------------------------------------------------------------------------------------------
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_salidas")) {
    $diasrepo = $_POST['diasrepo'];
    $id = $_POST['hiddenField'];
	$sqlano = "SELECT date_part('year', fecha) FROM movimientos WHERE idmovimiento = $id;";
	$excano = $cnx_cuzzicia->Execute($sqlano) or die($cnx_cuzzicia->ErrorMsg());
	$ano = $excano->Fields('date_part');
	//actulaizar material
	$upingreg = "UPDATE materiales SET idmateriales=$id, diasrepo=$diasrepo WHERE idmateriales=$id";
	$upingrexc = $cnx_cuzzicia->Execute($upingreg) or die($cnx_cuzzicia->ErrorMsg());

$updateGoTo = "buscamate.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
KT_redir($updateGoTo);
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_ingresos" id="frm_ingresos">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">ACTUALIZA MATERIALES </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;<input name="hiddenField" type="hidden" value="<?php echo $actuliza->Fields('idmateriales'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><?php echo $materiales->Fields('tipoconsumo'); ?>/ <?php echo $materiales->Fields('categoria'); ?>/ <?php echo $materiales->Fields('materiales'); ?>/ <?php echo $materiales->Fields('marcatipo'); ?>/ <?php echo $materiales->Fields('gramajecalibre'); ?>/ <?php echo $materiales->Fields('medida'); ?>/ <?php echo $materiales->Fields('unidad'); ?></td>
    </tr>
    <tr>
      <td class="KT_th">Dias Reposici&oacute;n:</td>
      <td><input name="diasrepo" type="text" id="diasrepo" value="<?php echo $actuliza->Fields('diasrepo'); ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Actualizar"/>      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frm_salidas">
</form>
</body>
</html>
<?php
$materiales->Close();

$actuliza->Close();
?>