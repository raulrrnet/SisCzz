<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_operario = "SELECT * FROM operario WHERE estado='A' ORDER BY nombre ASC";
$operario = $cnx_cuzzicia->SelectLimit($query_operario) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operario = $operario->RecordCount();
// end Recordset

// begin Recordset
$query_calend = "SELECT * FROM calend ORDER BY nombre ASC";
$calend = $cnx_cuzzicia->SelectLimit($query_calend) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_calend = $calend->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
$fecha = $_POST['fecha'];
$opera = $_POST['idoperario'];
$calen = $_POST['idcalen'];
$query_valida = "SELECT * FROM infotiempo WHERE fecha='$fecha' and idoperario=$opera";
$valida = $cnx_cuzzicia->SelectLimit($query_valida) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_valida = $valida->RecordCount();
	if($totalRows_valida==0){
	  $insertSQL = "INSERT INTO infotiempo (fecha, idoperario, idcalen) VALUES ('$fecha',$opera,$calen) RETURNING idinforme;";
	  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	  $idinfo = $Result1->Fields('idinforme');
	
	  $insertGoTo = "detainfo.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?id=".$idinfo;
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  KT_redir($insertGoTo);
	  }else{echo "El Registro ya existe";}
}

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
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
<form action="<?php echo $editFormAction; ?>" name="form2" method="post" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Selecione Operario - Fecha </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idoperario">Operario:</label></td>
      <td><select name="idoperario" id="idoperario">
        <?php
  while(!$operario->EOF){
?>
        <option value="<?php echo $operario->Fields('idoperario')?>"><?php echo $operario->Fields('nombre')?></option>
        <?php
    $operario->MoveNext();
  }
  $operario->MoveFirst();
?>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">Fecha:</label></td>
      <td><input name="fecha" id="fecha" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></td>
    </tr>
    <tr>
      <td class="KT_th">Calendario:</td>
      <td><label>
        <select name="idcalen" id="idcalen">
          <?php
  while(!$calend->EOF){
?>
          <option value="<?php echo $calend->Fields('id')?>"><?php echo $calend->Fields('nombre')?></option>
          <?php
    $calend->MoveNext();
  }
  $calend->MoveFirst();
?>
        </select>
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
<?php
$operario->Close();

$calend->Close();
?>