<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$idsali = '0';
if (isset($_GET['idsali'])) {
  $idsali = $_GET['idsali'];
}
$idlocal = '0';
if (isset($_GET['idlocal'])) {
  $idlocal = $_GET['idlocal'];
}
// begin Recordset
$query_cliente = "SELECT * FROM salidaal s, clientes c WHERE s.idcliente=c.idcliente and s.idsalida=$idsali";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset
// begin Recordset
$query_orden = "SELECT idorden,descripcion,round(precios, 2) as precios,round(preciod,2) as preciod FROM orden ORDER BY idorden DESC";
$orden = $cnx_cuzzicia->SelectLimit($query_orden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_orden = $orden->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$idsali = $_POST['hiddenField'];
$idord = $_POST['orden'];
$cant = $_POST['cantidad'];
$desc = $_POST['descrip'];
$pedi = $_POST['pedido'];
$und = $_POST['und'];
if($cant==''){$cant=1;}
  $insertSQL = "INSERT INTO detsalidaal (idsalidaal, idorden, cantidad, descripcion, pedido, und) VALUES ($idsali, $idord, $cant, '$desc', '$pedi', '$und')";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "guiadet.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
    <td colspan="3" align="right" class="KT_tngtable">N&ordm; Guia:</td>
    <td><strong><?php echo $cliente->Fields('nroguia'); ?></strong></td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idoperario">Cliente:</label></td>
    <td colspan="2"><?php echo $cliente->Fields('cliente'); ?></td>
    <td><?php echo $cliente->Fields('fecha'); ?>
      <input name="hiddenField" type="hidden" value="<?php echo $cliente->Fields('idsalida'); ?>"></td>
  </tr>
  
  <tr class="KT_tngtable">
    <td class="KT_th">Orden:</td>
    <td class="KT_th">Cantidad:</td>
    <td class="KT_th">Descripci&oacute;n:</td>
    <td class="KT_th">Pedido N&ordm;:</td>
  </tr>
  <tr class="KT_tngtable">
    <td>
      <select name="orden" id="orden">
        <?php
  while(!$orden->EOF){
?>
        <option value="<?php echo $orden->Fields('idorden')?>"<?php if (!(strcmp($orden->Fields('idorden'), 0))) {echo "SELECTED";} ?>><?php echo $orden->Fields('idorden')?></option>
        <?php
    $orden->MoveNext();
  }
  $orden->MoveFirst();
?>
      </select>    </td>
    <td><input name="cantidad" type="text" id="cantidad" size="10" />
      <select name="und" id="und" onchange="selecOp()">
        <option value="Mill">Mill</option>
        <option value="KG">Kg</option>
        <option value="UN" selected="selected">Un</option>
        <option value="-">-</option>
      </select></td>
    <td><textarea name="descrip" cols="50" id="descrip" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="orden" wdg:valuefield="descripcion" wdg:pkey="idorden" wdg:triggerobject="orden"></textarea></td>
	<td><input type="text" name="pedido" id="pedido"/>	</td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="4"><input name="enviar" type="submit" id="enviar" value="Insertar Item" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<hr>
<iframe width="100%" id="the_iframe" onLoad="calcHeight();" src="verguia.php?idsali=<?php echo $idsali;?>&idlocal=<?php echo $idlocal;?>"></iframe>
</body>
</html>
<?php
$cliente->Close();
$orden->Close();
?>