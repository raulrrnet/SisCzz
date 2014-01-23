<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha DESC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

$maxidfac =	"SELECT max(CAST(substr(idfact,3) as integer)) as id FROM factura WHERE idfact LIKE 'B-%'";
$maxfact = $cnx_cuzzicia->SelectLimit($maxidfac) or die($cnx_cuzzicia->ErrorMsg());
$id = $maxfact->Fields('id')+1;
$idfact = "B-".$id;
$idcli = $_POST['idcliente'];
$nombre = $_POST['cliente'];
$dir = $_POST['direccion'];
$dni = $_POST['dni'];
$fecha = $_POST['fecha'];
$gremi = $_POST['gremi'];
$igv = $_POST['igv'];
$mone = $_POST['moneda'];

	  $insertSQL = "INSERT INTO factura (idfact,idcliente,nombre,direcbol,fecha,dni,gremi,igv,moneda,estado) VALUES ('$idfact',$idcli,'$nombre','$dir','$fecha','$dni','$gremi',$igv,'$mone','ok')";
	  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	
	  $insertGoTo = "detbole.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?idfac=".$idfact."&mone=".$mone;
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boleta</title>
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
<form action="<?php echo $editFormAction; ?>" name="form2" method="post" id="form2">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">DATOS BOLETA </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="selected_cal"><label for="idcliente">CLIENTE:
          <input name="idcliente" type="hidden" id="idcliente" value="103">
        <input name="cliente" type="text" id="cliente" size="50">
      </label></td>
      <td class="selected_cal"><label for="idcliente">DNI:<span class="KT_th">
        <input name="dni" type="text" id="dni" value="">
      </span></label></td>
    </tr>
    
    <tr>
      <td colspan="2" class="selected_cal"><label>
        DIRECCION: 
        <input name="direccion" type="text" id="direccion" size="80">
      </label></td>
    </tr>
    <tr>
      <td class="selected_cal"><label for="label">MONEDA:<span class="KT_th">
        <select name="moneda" id="moneda">
          <option value="soles" selected>Soles</option>
          <option value="dolar">Dolar</option>
        </select>
      </span></label></td>
      <td class="selected_cal"><label for="label">IGV:
        
          <input name="igv" type="text" id="igv" value="18" size="2">
%</label></td>
    </tr>
    <tr>
      <td class="selected_cal">FECHA:        
        <select name="fecha" id="fecha">
          <?php
  while(!$tcambio->EOF){
?>
          <option value="<?php echo $tcambio->Fields('fecha')?>"><?php echo $tcambio->Fields('fecha')?></option>
          <?php
    $tcambio->MoveNext();
  }
  $tcambio->MoveFirst();
?>
        </select>
        <input name="Button" type="button" onClick="self.location='../tcambio.php'" value="Fecha/Cambio"></td>
      <td class="selected_cal">G.R.:
        <input name="gremi" type="text" id="gremi" value=""></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Continuar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
</body>
</html>
<?php
$tcambio->Close();
?>
