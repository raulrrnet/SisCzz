<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$idfact = '0';
if (isset($_GET['idfac'])) {
  $idfact = $_GET['idfac'];
}
// begin Recordset
$query_factura = "SELECT * FROM factura f,clientes c WHERE f.idcliente=c.idcliente and f.idfact='$idfact'";
$factura = $cnx_cuzzicia->SelectLimit($query_factura) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_factura = $factura->RecordCount();
// end Recordset
// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha DESC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset
// begin Recordset
$query_clientes = "SELECT * FROM clientes ORDER BY cliente ASC";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE factura SET idcliente=%s, fecha=%s, pedido=%s, gremi=%s, igv=%s, moneda=%s, estado=%s WHERE idfact=%s",
                       GetSQLValueString($_POST['cliente'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['pedido'], "text"),
                       GetSQLValueString($_POST['gremi'], "text"),
                       GetSQLValueString($_POST['igv'], "int"),
                       GetSQLValueString($_POST['moneda'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "listfact.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}
//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Factura</title>
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
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form2">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">DATOS FACTURA</td>
    </tr>
    <tr>
      <td colspan="2"><input name="id" type="hidden" id="id" value="<?php echo $factura->Fields('idfact'); ?>"></td>
    </tr>
    <tr>
      <td class="selected_cal"><label for="idcliente">Cliente:</label></td>
      <td class="selected_cal"><label for="idcliente">Moneda:</label></td>
    </tr>
    <tr>
      <td><select name="cliente" id="cliente">
        <?php
  while(!$clientes->EOF){
?>
        <option value="<?php echo $clientes->Fields('idcliente')?>"<?php if (!(strcmp($clientes->Fields('idcliente'), $factura->Fields('idcliente')))) {echo "SELECTED";} ?>><?php echo $clientes->Fields('cliente')?></option>
        <?php
    $clientes->MoveNext();
  }
  $clientes->MoveFirst();
?>
      </select>
      <input name="nclient" type="button" id="nclient" onClick="self.location='../clientes/clienten.php'" value="++" /></td>
      <td><span class="KT_th">
        <select name="moneda" id="moneda">
          <option value="soles" selected <?php if (!(strcmp("soles", $factura->Fields('moneda')))) {echo "SELECTED";} ?>>Soles</option>
          <option value="dolar" <?php if (!(strcmp("dolar", $factura->Fields('moneda')))) {echo "SELECTED";} ?>>Dolares</option>
        </select>
      </span></td>
    </tr>
    <tr>
      <td class="selected_cal"><label for="label">Fecha:</label></td>
      <td class="selected_cal"><label for="label">IGV:</label></td>
    </tr>
    <tr>
      <td><select name="fecha" id="fecha">
        <?php
  while(!$tcambio->EOF){
?>
        <option value="<?php echo $tcambio->Fields('fecha')?>"<?php if (!(strcmp($tcambio->Fields('fecha'), $factura->Fields('fecha')))) {echo "SELECTED";} ?>><?php echo $tcambio->Fields('fecha')?></option>
        <?php
    $tcambio->MoveNext();
  }
  $tcambio->MoveFirst();
?>
      </select>
      <input name="Button" type="button" onClick="self.location='../tcambio.php'" value="Fecha/Cambio"></td>
      <td><input name="igv" type="text" id="igv" value="<?php echo $factura->Fields('igv'); ?>" size="2">
%</td>
    </tr>
    <tr>
      <td class="selected_cal">Pedidos:</td>
      <td class="selected_cal">G. Remisi&oacute;n:</td>
    </tr>
    <tr>
      <td><input name="pedido" type="text" id="pedido" value="<?php echo $factura->Fields('pedido'); ?>" size="35"></td>
      <td><input name="gremi" type="text" id="gremi" value="<?php echo $factura->Fields('gremi'); ?>" size="35"></td>
    </tr>
    <tr>
      <td colspan="2" class="selected_cal">ESTADO:&nbsp;&nbsp;&nbsp;
        <select name="estado" id="estado">
          <option value="ok" selected <?php if (!(strcmp("ok", $factura->Fields('estado')))) {echo "SELECTED";} ?>>Activa</option>
          <option value="anulada" <?php if (!(strcmp("anulada", $factura->Fields('estado')))) {echo "SELECTED";} ?>>Anulada</option>
        </select></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Modificar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2">
</form>
</body>
</html>
<?php
$factura->Close();

$clientes->Close();
?>