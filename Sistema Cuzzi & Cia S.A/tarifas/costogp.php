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
$fecha = strtotime($_POST['fecha']);
$mes = date("m",$fecha);
$year = date("Y",$fecha);
$query_valida = "SELECT * FROM costogp WHERE date_part('month',mes)='$mes' and date_part('year',mes)=$year";
$valida = $cnx_cuzzicia->SelectLimit($query_valida) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_valida = $valida->RecordCount();
	if($totalRows_valida==0){
  $insertSQL = sprintf("INSERT INTO costogp (mes, costototal) VALUES (%s, %s)",
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['costo'], "double"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "costogp.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
  }else{echo "El Registro ya existe";}
}

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
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
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Costo Generales Planta</td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">FechaMes:</label></td>
      <td><input name="fecha" id="fecha" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
    </tr>
    <tr>
      <td class="KT_th">Costo Total: </td>
      <td><label>
      <input name="costo" type="text" id="costo" value="">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<a href="mantegp.php">Ver Costos Generales Planta</a>
</body>
</html>