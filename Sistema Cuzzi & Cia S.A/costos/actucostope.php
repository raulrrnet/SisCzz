<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE costoperario SET idoperario=%s, mes=%s, costototal=%s WHERE idcosperario=%s",
                       GetSQLValueString($_POST['select'], "int"),
                       GetSQLValueString($_POST['fecham'], "date"),
                       GetSQLValueString($_POST['costot'], "double"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "../tarifas/mantecostope.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$colname__actucostope = '-1';
if (isset($_GET['idcos'])) {
  $colname__actucostope = $_GET['idcos'];
}
$query_actucostope = sprintf("SELECT * FROM costoperario WHERE idcosperario = %s", GetSQLValueString($colname__actucostope, "int"));
$actucostope = $cnx_cuzzicia->SelectLimit($query_actucostope) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actucostope = $actucostope->RecordCount();
// end Recordset

// begin Recordset
$query_operarios = "SELECT * FROM operario WHERE estado <> 'X' ORDER BY nombre ASC";
$operarios = $cnx_cuzzicia->SelectLimit($query_operarios) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operarios = $operarios->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
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
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Costo Operario Mes</td>
    </tr>
    <tr>
      <td class="KT_th"><input name="id" type="hidden" id="id" value="<?php echo $actucostope->Fields('idcosperario'); ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Operario:</td>
      <td><select name="select">
        <?php
  while(!$operarios->EOF){
?>
        <option value="<?php echo $operarios->Fields('idoperario')?>"<?php if (!(strcmp($operarios->Fields('idoperario'), $actucostope->Fields('idoperario')))) {echo "SELECTED";} ?>><?php echo $operarios->Fields('nombre')?></option>
        <?php
    $operarios->MoveNext();
  }
  $operarios->MoveFirst();
?>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Fecha Mes</td>
      <td><input name="fecham" id="fecham" value="<?php echo $actucostope->Fields('mes'); ?>" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="proveedor">Costo Total:</label></td>
      <td><input name="costot" type="text" id="costot" value="<?php echo $actucostope->Fields('costototal'); ?>" /></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Grabar" />      </td>
    </tr>
  </table>
    
  <input type="hidden" name="MM_update" value="form">
</form>
</body>
</html>
<?php
$actucostope->Close();
$operarios->Close();
?>