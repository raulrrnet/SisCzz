<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO tarifa (nombre, estado, vig_inicio, vig_fin) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fechaini'], "date"),
                       GetSQLValueString($_POST['fechafin'], "date"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "detatarifa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingresos</title>
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
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Tarifa </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Nombre:</td>
      <td><label>
        <input name="nombre" type="text" id="nombre">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Predeterminada:</td>
      <td><label>SI
          <input name="estado" type="radio" value="si">
          NO
      </label>
        <label>
        <input name="estado" type="radio" value="no">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Vig. Inicio :</td>
      <td><input name="fechaini" id="fechaini" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Vig. Fin:</label></td>
      <td><label>
        <input name="fechafin" id="fechafin" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insertar registro" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
</body>
</html>