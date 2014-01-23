<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_cliente = "SELECT * FROM clientes ORDER BY cliente ASC";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset
// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha DESC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

$maxidfac =	"select substr(max(idfact),3) as id from factura;";
$maxfact = $cnx_cuzzicia->SelectLimit($maxidfac) or die($cnx_cuzzicia->ErrorMsg());
$id = $maxfact->Fields('id')+1;
$idfact = "F-".$id;
$idcli = $_POST['cliente'];
$fecha = $_POST['fecha'];
$pedi = $_POST['pedido'];
$gremi = $_POST['gremi'];
$igv = $_POST['igv'];
$mone = $_POST['moneda'];

	  $insertSQL = "INSERT INTO factura (idfact,idcliente,fecha,pedido,gremi,igv,moneda,estado) VALUES ('$idfact',$idcli,'$fecha','$pedi','$gremi',$igv,'$mone','ok')";
	  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	
	  $insertGoTo = "detfact.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?idfac=".$idfact."&mone=".$mone;
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Factura</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="post" id="form2">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">DATOS FACTURA</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="selected_cal"><label for="idcliente">Cliente:</label></td>
      <td class="selected_cal"><label for="idcliente">Moneda:</label></td>
    </tr>
    <tr>
      <td><select name="cliente" id="cliente">
        <?php
  while(!$cliente->EOF){
?>
        <option value="<?php echo $cliente->Fields('idcliente')?>"><?php echo $cliente->Fields('cliente')?></option>
        <?php
    $cliente->MoveNext();
  }
  $cliente->MoveFirst();
?>
      </select>
      <input name="nclient" type="button" id="nclient" onclick="self.location='../clientes/clienten.php'" value="++" /></td>
      <td><span class="KT_th">
        <select name="moneda" id="moneda">
          <option value="soles" selected>Soles</option>
          <option value="dolar">Dolares</option>
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
        <option value="<?php echo $tcambio->Fields('fecha')?>"><?php echo $tcambio->Fields('fecha')?></option>
        <?php
    $tcambio->MoveNext();
  }
  $tcambio->MoveFirst();
?>
            </select>
      <input name="Button" type="button" onClick="self.location='../tcambio.php'" value="Fecha/Cambio"></td>
      <td><input name="igv" type="text" id="igv" value="18" size="2">
%</td>
    </tr>
    <tr>
      <td class="selected_cal">Pedidos:</td>
      <td class="selected_cal">G. Remisi&oacute;n:</td>
    </tr>
    <tr>
      <td><input name="pedido" type="text" id="pedido" value="" size="35"></td>
      <td><input name="gremi" type="text" id="gremi" value="" size="35"></td>
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
$cliente->Close();

$tcambio->Close();
?>