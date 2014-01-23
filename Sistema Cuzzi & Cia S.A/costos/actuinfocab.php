<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');
// begin Recordset
$fec__actiinfocabe = '2008/03/12';
if (isset($_POST['fecha'])) {
  $fec__actiinfocabe = $_POST['fecha'];
}
$idope__actiinfocabe = '4';
if (isset($_POST['idope'])) {
  $idope__actiinfocabe = $_POST['idope'];
}
$query_actiinfocabe = sprintf("SELECT * FROM infotiempo WHERE fecha = '%s' and idoperario =  %s", $fec__actiinfocabe,$idope__actiinfocabe);
$actiinfocabe = $cnx_cuzzicia->SelectLimit($query_actiinfocabe) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actiinfocabe = $actiinfocabe->RecordCount();
// end Recordset
// begin Recordset
$query_operarios = "SELECT * FROM operario WHERE estado <> 'X' ORDER BY nombre ASC";
$operarios = $cnx_cuzzicia->SelectLimit($query_operarios) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operarios = $operarios->RecordCount();
// end Recordset
// begin Recordset
$query_calend = "SELECT * FROM calend ORDER BY nombre ASC";
$calend = $cnx_cuzzicia->SelectLimit($query_calend) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_calend = $calend->RecordCount();
// end Recordset
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE infotiempo SET fecha=%s, idoperario=%s, idcalen=%s WHERE idinforme=%s",
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['idoperario'], "int"),
                       GetSQLValueString($_POST['idcalen'], "int"),
                       GetSQLValueString($_POST['idinfo'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "conhorasope.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="../includes/kore/kore.js"></script>
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
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Modificar Informe Cabecera </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td><input name="idinfo" type="hidden" id="idinfo" value="<?php echo $actiinfocabe->Fields('idinforme'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idoperario">Operario:</label></td>
      <td><select name="idoperario" id="idoperario">
        <?php
  while(!$operarios->EOF){
?>
        <option value="<?php echo $operarios->Fields('idoperario')?>"<?php if (!(strcmp($operarios->Fields('idoperario'), $actiinfocabe->Fields('idoperario')))) {echo "SELECTED";} ?>><?php echo $operarios->Fields('nombre')?></option>
        <?php
    $operarios->MoveNext();
  }
  $operarios->MoveFirst();
?>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">Fecha:</label></td>
      <td><input name="fecha" id="fecha" value="<?php echo $actiinfocabe->Fields('fecha'); ?>" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
    </tr>
    <tr>
      <td class="KT_th">Calendario:</td>
      <td><label>
        <select name="idcalen" id="idcalen">
        <?php
  while(!$calend->EOF){
?>
        <option value="<?php echo $calend->Fields('id')?>"<?php if (!(strcmp($calend->Fields('id'), $actiinfocabe->Fields('idcalen')))) {echo "SELECTED";} ?>><?php echo $calend->Fields('nombre')?></option>
        <?php
    $calend->MoveNext();
  }
  $calend->MoveFirst();
?>
        </select>
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="btnactu" id="btnactu" value="Actualizar" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2">
</form>
</body>
</html>
<?php
$actiinfocabe->Close();
$operarios->Close();
?>
