<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE depreciacion SET descripcion=%s, fecingreso=%s, importe=%s, tasa=%s WHERE iddeprecia=%s",
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['fecingreso'], "date"),
                       GetSQLValueString($_POST['importe'], "double"),
                       GetSQLValueString($_POST['tasa'], "double"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "mantedepre.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$colname__actumante = '139';
if (isset($_GET['iddep'])) {
  $colname__actumante = $_GET['iddep'];
}
$query_actumante = sprintf("SELECT * FROM depreciacion WHERE iddeprecia = %s", GetSQLValueString($colname__actumante, "int"));
$actumante = $cnx_cuzzicia->SelectLimit($query_actumante) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actumante = $actumante->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ActuDepre</title>
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
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="KT_th">Drepreciacion Costo/Distribicion</td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">
      <input name="id" type="hidden" id="id" value="<?php echo $actumante->Fields('iddeprecia'); ?>">
    </td>
  </tr>
  <tr>
    <td class="KT_th"><label for="descripcion">Descripcion:</label>    </td>
    <td><input name="descripcion" type="text" id="descripcion" value="<?php echo $actumante->Fields('descripcion'); ?>" size="32" /></td>
  </tr>
  <tr>
    <td class="KT_th"><label for="fecingreso">Fecingreso:</label>    </td>
    <td><input name="fecingreso" id="fecingreso" value="<?php echo $actumante->Fields('fecingreso'); ?>" size="32" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no" /></td>
  </tr>
  <tr>
    <td class="KT_th"><label for="importe">Importe:</label>    </td>
    <td><input name="importe" type="text" id="importe" value="<?php echo $actumante->Fields('importe'); ?>" size="32" /></td>
  </tr>
  <tr>
    <td class="KT_th"><label for="tasa">Tasa:</label>    </td>
    <td><input name="tasa" type="text" id="tasa" value="<?php echo $actumante->Fields('tasa'); ?>" size="32" /></td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">&nbsp;</td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Actualizar" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
$actumante->Close();
?>