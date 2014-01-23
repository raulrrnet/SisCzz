<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO seguros (prima, seguro, fecha) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['prima'], "double"),
                       GetSQLValueString($_POST['seguro'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "distrisegu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="KT_th">Costo Seguros</td>
  </tr>
  <tr>
    <td colspan="2" class="KT_th">&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idoperario">Prima:</label>
    </td>
    <td><input name="prima" type="text" id="prima">
    </td>
  </tr>
  <tr>
    <td class="KT_th"><label for="label">Seguro:</label>
    </td>
    <td><input name="seguro" type="text" id="seguro">
    </td>
  </tr>
  <tr>
    <td class="KT_th">Fecha:</td>
    <td><label>
      <input name="fecha" id="fecha" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      </label>
    </td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insertar registro" />
    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<a href="mantesegu.php">Ver Costos Seguros
</a>
</body>
</html>
