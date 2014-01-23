<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

$registro = $_POST['registro'];
$ids = implode(',', $registro); // registro es la variable que uso como "name".

  $updateSQL = "UPDATE orden SET preciook='ok' WHERE idorden in ($ids)";
  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  
  $updateGoTo = "ordenprecio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$maxRows_ordenprecio = 20;
$pageNum_ordenprecio = 0;
if (isset($_GET['pageNum_ordenprecio'])) {
  $pageNum_ordenprecio = $_GET['pageNum_ordenprecio'];
}
$startRow_ordenprecio = $pageNum_ordenprecio * $maxRows_ordenprecio;
$query_ordenprecio = "SELECT o.idorden, o.fecha, c.cliente, o.descripcion, o.cantpedi, o.tipoprecio, o.precios, o.preciod FROM orden o, clientes c WHERE o.idcliente = c.idcliente and o.preciook<>'ok' ORDER BY idorden desc";
$ordenprecio = $cnx_cuzzicia->SelectLimit($query_ordenprecio, $maxRows_ordenprecio, $startRow_ordenprecio) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_ordenprecio'])) {
  $totalRows_ordenprecio = $_GET['totalRows_ordenprecio'];
} else {
  $all_ordenprecio = $cnx_cuzzicia->SelectLimit($query_ordenprecio) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_ordenprecio = $all_ordenprecio->RecordCount();
}
$totalPages_ordenprecio = (int)(($totalRows_ordenprecio-1)/$maxRows_ordenprecio);
// end Recordset

// rebuild the query string by replacing pageNum and totalRows with the new values
$queryString_ordenprecio = KT_removeParam("&" . @$_SERVER['QUERY_STRING'], "pageNum_ordenprecio");
$queryString_ordenprecio = KT_replaceParam($queryString_ordenprecio, "totalRows_ordenprecio", $totalRows_ordenprecio);

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<tr>
<td class="KT_th">Orden</td>
<td class="KT_th">Fecha</td>
<td class="KT_th">Cliente</td>
<td class="KT_th">Descripción</td>
<td class="KT_th">Cantidad</td>
<td class="KT_th">T. Precio</td>
<td class="KT_th">Millar</td>
<td class="KT_th">Total</td>
<td class="KT_th">Estado</td>
<td class="KT_th"></td>
</tr>
  <?php
  while (!$ordenprecio->EOF) { 
?>
    <tr>
        <td><?php echo $ordenprecio->Fields('idorden'); ?></td>
      <td><?php echo $ordenprecio->Fields('fecha'); ?></td>
      <td><?php echo $ordenprecio->Fields('cliente'); ?></td>
      <td><?php echo $ordenprecio->Fields('descripcion'); ?></td>
      <td align="right"><?php $cant = $ordenprecio->Fields('cantpedi'); echo number_format($cant,2); ?></td>
      <td align="right"><?php echo $ordenprecio->Fields('tipoprecio'); ?></td>
      <td align="right"><?php if($ordenprecio->Fields('tipoprecio')=='solesmillar' || $ordenprecio->Fields('tipoprecio')=='totalsoles'){$pre = $ordenprecio->Fields('precios');echo number_format($pre,2);}else{$pre = $ordenprecio->Fields('preciod');echo number_format($pre,2);} ?></td>
      <td align="right"><?php echo number_format($cant*$pre/1000,2); ?></td>
      <td>&nbsp;</td>
      <td><input type="checkbox" name="registro[]" value="<?php echo $ordenprecio->Fields('idorden');?>"></td>
    </tr>
    <?php
    $ordenprecio->MoveNext(); 
  }
?>
    <tr>
      <td colspan="10" align="center"><table width="30%" border="0" cellpadding="0" cellspacing="0">
        <tr class="KT_tngtable">
          <td class="selected_cal" width="30%"><a href="<?php printf("%s?pageNum_ordenprecio=%d%s", $_SERVER["PHP_SELF"], 0, $queryString_ordenprecio); ?>">&lt;&lt;&lt;</a></td>
          <td class="selected_cal" width="20%"><a href="<?php printf("%s?pageNum_ordenprecio=%d%s", $_SERVER["PHP_SELF"], max(0, $pageNum_ordenprecio - 1), $queryString_ordenprecio); ?>">&lt;&lt;</a></td>
          <td class="selected_cal" width="20%" align="right"><a href="<?php printf("%s?pageNum_ordenprecio=%d%s", $_SERVER["PHP_SELF"], min($totalPages_ordenprecio, $pageNum_ordenprecio + 1), $queryString_ordenprecio); ?>">&gt;&gt;</a></td>
          <td class="selected_cal" width="30%" align="right"><a href="<?php printf("%s?pageNum_ordenprecio=%d%s", $_SERVER["PHP_SELF"], $totalPages_ordenprecio, $queryString_ordenprecio); ?>">&gt;&gt;&gt;</a></td>
        </tr>
        
      </table>
      <input name="aceptar" type="submit" id="aceptar" value="Confirmar" /></td>
    </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
$ordenprecio->Close();
?>