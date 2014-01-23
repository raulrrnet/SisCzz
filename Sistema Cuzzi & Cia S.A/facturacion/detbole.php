<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$mone = '';
if (isset($_GET['mone'])) {
  $mone = $_GET['mone'];
}
$idfact = '1';
if (isset($_GET['idfac'])) {
  $idfact = $_GET['idfac'];
}
// begin Recordset
$query_cliente = "SELECT * FROM factura f, clientes c WHERE f.idcliente=c.idcliente and f.idfact='$idfact'";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset
$fecha = $cliente->Fields('fecha');
$mone = $cliente->Fields('moneda');
// begin Recordset
$query_orden = "SELECT idorden,descripcion,round(precios, 2) as precios,round(preciod,2) as preciod FROM orden ORDER BY idorden DESC";
$orden = $cnx_cuzzicia->SelectLimit($query_orden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_orden = $orden->RecordCount();
// end Recordset
// begin Recordset
$query_tipocambio = "SELECT * FROM tipocambio WHERE fecha = '$fecha'";
$tipocambio = $cnx_cuzzicia->SelectLimit($query_tipocambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tipocambio = $tipocambio->RecordCount();
// end Recordset
$tc = $tipocambio->Fields('tcambio');
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

$idfact = $_POST['hiddenField'];
$idord = $_POST['orden'];
$cant = $_POST['cantidad'];
$desc = $_POST['descrip'];
$monto = $_POST['montou'];
$und = $_POST['und'];
if($mone=='dolar'){
	$dolar = $monto;
	$monto = $monto*$tc;}
else{$dolar = $monto/$tc;}
if($cant==''){$cant=1;}
  $insertSQL = "INSERT INTO detallefact (idfact, idorden, cantidad, descripcion, monto, mdolar, und) VALUES ('$idfact', $idord, $cant, '$desc', $monto, $dolar, '$und')";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "detbole.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Detalle Informe</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DynamicInput.js"></script>
<script language="JavaScript">
<!--
function calcHeight()
{
//find the height of the internal page
var the_height=
document.getElementById('the_iframe').contentWindow.
document.body.scrollHeight;
//change the height of the iframe
document.getElementById('the_iframe').height=
the_height;
}
//-->
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/N1DependentField.js"></script>
<?php
//begin JSRecordset
$jsObject_orden = new WDG_JsRecordset("orden");
echo $jsObject_orden->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="return validacion();">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">N&ordm; BOL. </td>
    <td colspan="2"><strong><?php echo $cliente->Fields('idfact'); ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idoperario">Cliente:</label></td>
    <td colspan="2"><?php echo $cliente->Fields('nombre'); ?></td>
    <td><?php echo $cliente->Fields('fecha'); ?>
      <input name="hiddenField" type="hidden" value="<?php echo $cliente->Fields('idfact'); ?>"></td>
  </tr>
  
  <tr class="KT_tngtable">
    <td class="KT_th">Orden:</td>
    <td class="KT_th">Cantidad:</td>
    <td class="KT_th">Descripci&oacute;n:</td>
    <td class="KT_th">C. Unitario:</td>
  </tr>
  <tr class="KT_tngtable">
    <td>
      <select name="orden" id="orden">
        <?php
  while(!$orden->EOF){
?>
        <option value="<?php echo $orden->Fields('idorden')?>"><?php echo $orden->Fields('idorden')?></option>
        <?php
    $orden->MoveNext();
  }
  $orden->MoveFirst();
?>
      </select>    </td>
    <td><input name="cantidad" type="text" id="cantidad" size="10" />
      <select name="und" id="und">
        <option value="Mill">Mill</option>
        <option value="KG">Kg</option>
        <option value="UN">Un</option>
        <option value="-">-</option>
      </select></td>
    <td><textarea name="descrip" cols="50" id="descrip" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="orden" wdg:valuefield="descripcion" wdg:pkey="idorden" wdg:triggerobject="orden"></textarea></td>
    <?php if($mone=='dolar'){ ?>	
	<td><input type="text" name="montou" id="montou" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="orden" wdg:valuefield="preciod" wdg:pkey="idorden" wdg:triggerobject="orden"/></td>
	<?php }else{ ?>
	<td><input type="text" name="montou" id="montou" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="orden" wdg:valuefield="precios" wdg:pkey="idorden" wdg:triggerobject="orden"/></td>
	<?php }?>
  </tr>
  <tr class="KT_buttons">
    <td colspan="4"><input name="enviar" type="submit" id="enviar" value="Insertar Item" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<hr>
<iframe width="100%" id="the_iframe" onLoad="calcHeight();" src="verbole.php?idfac=<?php echo $idfact;?>"></iframe>
</body>
</html>
<?php
$cliente->Close();
$orden->Close();
$tipocambio->Close();
?>