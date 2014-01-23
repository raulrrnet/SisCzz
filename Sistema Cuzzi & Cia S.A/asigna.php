<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('includes/wdg/WDG.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO asignacion (idoperario, idseccion, porcentaje, fecha) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['oper'], "int"),
                       GetSQLValueString($_POST['seccion'], "int"),
                       GetSQLValueString($_POST['porcent'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "asigna.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$colname__operarios = '-1';
if (isset($_GET['idope'])) {
  $colname__operarios = $_GET['idope'];
}
$query_operarios = sprintf("SELECT * FROM operario WHERE idoperario = %s ORDER BY idoperario DESC", GetSQLValueString($colname__operarios, "int"));
$operarios = $cnx_cuzzicia->SelectLimit($query_operarios) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operarios = $operarios->RecordCount();
// end Recordset

// begin Recordset
$query_secciones = "SELECT * FROM seccion WHERE status <> 'x'";
$secciones = $cnx_cuzzicia->SelectLimit($query_secciones) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_secciones = $secciones->RecordCount();
// end Recordset

// begin Recordset
$query_fecasig = "SELECT * FROM asignacion ORDER BY idasigna DESC";
$fecasig = $cnx_cuzzicia->SelectLimit($query_fecasig) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_fecasig = $fecasig->RecordCount();
// end Recordset

// begin Recordset
$query_oper = "SELECT * FROM operario WHERE estado = 'A' ORDER BY idoperario DESC";
$oper = $cnx_cuzzicia->SelectLimit($query_oper) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_oper = $oper->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Asignaci&oacute;n</td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td><label></label></td>
    </tr>
    <tr>
      <td class="KT_th">Operario:</td>
      <td><label>
      <select name="oper" id="oper">
        <?php
  while(!$oper->EOF){
?>
        <option value="<?php echo $oper->Fields('idoperario')?>"<?php if (!(strcmp($oper->Fields('idoperario'), $operarios->Fields('idoperario')))) {echo "SELECTED";} ?>><?php echo $oper->Fields('nombre')?></option>
        <?php
    $oper->MoveNext();
  }
  $oper->MoveFirst();
?>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Secci&oacute;n</td>
      <td><select name="seccion" id="seccion">
        <?php
  while(!$secciones->EOF){
?>
        <option value="<?php echo $secciones->Fields('idseccion')?>"><?php echo $secciones->Fields('seccion')?></option>
        <?php
    $secciones->MoveNext();
  }
  $secciones->MoveFirst();
?>
            </select></td>
    </tr>
    <tr>
      <td class="KT_th">Porc.%</td>
      <td><input type="text" name="porcent" id="porcent" /></td>
    </tr>
    <tr>
      <td class="KT_th">Fecha Asignación</td>
      <td><label>
        <input name="fecha" id="fecha" value="<?php echo $fecasig->Fields('fecha'); ?>" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_insert" value="form2">
</form>
<br>
<a href="asinaoper.php">TERMINAR</a>
</body>
</html>
<?php
$operarios->Close();
$secciones->Close();

$fecasig->Close();

$oper->Close();
?>