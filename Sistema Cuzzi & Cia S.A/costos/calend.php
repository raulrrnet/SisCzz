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
$fecha = $_POST['fecha'];
$idcalen = $_POST['idcalen'];
$query_valida = "SELECT * FROM detcalend WHERE fecha='$fecha' and idcalen=$idcalen";
$valida = $cnx_cuzzicia->SelectLimit($query_valida) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_valida = $valida->RecordCount();
	if($totalRows_valida==0){
  $insertSQL = sprintf("INSERT INTO detcalend (idcalen, fecha, dospri, sgts, tiempo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idcalen'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['dospri'], "int"),
                       GetSQLValueString($_POST['sgts'], "int"),
                       GetSQLValueString($_POST['horas'], "double"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "calend.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
  }else{echo "El Registro ya existe";}
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
</head>
<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Selecione Operario - Fecha </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Calendario:</td>
      <td><label>
        <select name="idcalen" id="idcalen">
        <option value="1" selected>Calendario 1
        <option value="2">Calendario 2
        <option value="3">Calendario 3        
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">Fecha:</label></td>
      <td><input name="fecha" id="fecha" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
    </tr>
    <tr>
      <td class="KT_th">Debio:</td>
      <td><label>
        <input name="horas" type="text" id="horas">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">%1</td>
      <td><label>
        <input name="dospri" type="text" id="dospri" value="25">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">%2</td>
      <td><label>
        <input name="sgts" type="text" id="sgts" value="35">
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