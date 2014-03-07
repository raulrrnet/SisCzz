<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_clientes = "SELECT * FROM clientes ORDER BY cliente ASC";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

$cliente = '13';
if (isset($_POST['cliente'])) {
  $cliente = $_POST['cliente'];
}
// begin Recordset ordenes terminadas
$query_t = "SELECT * FROM orden WHERE (cantprod is null or cantprod > 1) and idcliente=$cliente ORDER BY idorden desc";
$otermi = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
$totermi = $otermi->RecordCount();
// end Recordset
$ttotal=0;
//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Estado Ordenes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 300px;
	overflow:auto;
	white-space:normal
}
-->
</style>
<script language="javascript">
function envio_form(){
document.form1.target = "_self";
document.form1.action= "factcliente.php"
document.form1.submit();
}
</script>
<style type="text/css">
<!--
.cdiv {	height: auto;
	width: 300px;
	overflow:auto;
	white-space:normal
}
-->
</style>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="7" align="center" class="selected_cal"><form name="form1" method="post" >
      <label>
      <select name="cliente" id="cliente">
        <option value="0">>> Seleccione </option>
        <?php
  while(!$clientes->EOF){
?>
        <option value="<?php echo $clientes->Fields('idcliente')?>"><?php echo $clientes->Fields('cliente')?></option>
        <?php
    $clientes->MoveNext();
  }
  $clientes->MoveFirst();
?>
      </select>
      </label>
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="7" align="center">&nbsp;</td>
  </tr>
<?php if (isset($_POST['cliente']) && $_POST['cliente']<>"") { ?>
  
  <tr>
    <td class="selected_cal">ORDEN</td>
    <td class="selected_cal">DESCRIPCION</td>
    <td class="selected_cal">PED. C. </td>
    <td class="selected_cal">C. PEDIDA </td>
    <td class="selected_cal">C.PROD.</td>
    <td class="selected_cal">C.FACT.</td>
    <td class="selected_cal">SALDO</td>
  </tr>
  <?php
  while (!$otermi->EOF) { 
$ordent = $otermi->Fields('idorden');

$query_datorden ="SELECT sum(cantidad)*1000 as cant FROM factura f,detallefact df WHERE f.idfact=df.idfactura and estado<>'anulada' and idorden=$ordent";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());
?>
  <tr>
    <td><?php echo $otermi->Fields('idorden'); ?></td>
    <td><div class="cdiv"><?php echo $otermi->Fields('descripcion'); ?></div></td>
    <td><?php echo $otermi->Fields('pedido'); ?></td>
    <td align="right"><?php echo number_format($otermi->Fields('cantpedi'),2); ?></td>
    <td align="right"><?php echo number_format($otermi->Fields('cantprod'),2); ?></td>
    <td align="right"><?php echo number_format($datorden->Fields('cant'),2); ?></td>
    <td align="right"><?php echo number_format($otermi->Fields('cantprod')-$datorden->Fields('cant'),2); ?></td>
  </tr>
<?php
    $otermi->MoveNext();
  }
?>
  
<tr class="KT_buttons">
     <td colspan="7"><a href="#"><img src="../images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
  </tr>
</table>
</body>
</html>
<?php
$clientes->Close();
 } ?>