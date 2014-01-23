<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the rating classes
require_once('../includes/jaxon/widgets/editinplace/editinplace.php');

$edit1 = new EditInPlace("edit1");
$edit1->setConnection("cnx_cuzzicia");
$edit1->setTable("clientes");
$edit1->setPrimaryKey("idcliente");
$edit1->setEditField("cliente", "STRING_TYPE");
$edit1->setEnabledCondition("");

$edit2 = new EditInPlace("edit2");
$edit2->setConnection("cnx_cuzzicia");
$edit2->setTable("clientes");
$edit2->setPrimaryKey("idcliente");
$edit2->setEditField("direccion", "STRING_TYPE");
$edit2->setEnabledCondition("");

$edit3 = new EditInPlace("edit3");
$edit3->setConnection("cnx_cuzzicia");
$edit3->setTable("clientes");
$edit3->setPrimaryKey("idcliente");
$edit3->setEditField("ruc", "STRING_TYPE");
$edit3->setEnabledCondition("");

// begin Recordset
$maxRows_clientes = 30;
$pageNum_clientes = 0;
if (isset($_GET['pageNum_clientes'])) {
  $pageNum_clientes = $_GET['pageNum_clientes'];
}
$startRow_clientes = $pageNum_clientes * $maxRows_clientes;
$query_clientes = "SELECT * FROM clientes ORDER BY cliente ASC";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes, $maxRows_clientes, $startRow_clientes) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_clientes'])) {
  $totalRows_clientes = $_GET['totalRows_clientes'];
} else {
  $all_clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_clientes = $all_clientes->RecordCount();
}
$totalPages_clientes = (int)(($totalRows_clientes-1)/$maxRows_clientes);
// end Recordset

// rebuild the query string by replacing pageNum and totalRows with the new values
$queryString_clientes = KT_removeParam("&" . @$_SERVER['QUERY_STRING'], "pageNum_clientes");
$queryString_clientes = KT_replaceParam($queryString_clientes, "totalRows_clientes", $totalRows_clientes);

$ajax_service = new AjaxService();

$ajax_service->exportMethod('edit1', 'updateValue'); 

$ajax_service->exportMethod('edit2', 'updateValue'); 

$ajax_service->exportMethod('edit3', 'updateValue'); 

$ajax_service->handleAjaxRequest();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/jaxon/widgets/editinplace/css/editinplace.css" rel="stylesheet" type="text/css" />
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/editinplace/js/editinplace.js"></script>
<?php 
  echo $ajax_service->renderJavascriptStubs();
?>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="4" class="KT_th">CLIENTES</td>
  </tr>
  <tr>
    <td class="selected_cal">Id</td>
    <td class="selected_cal">Raz&oacute;n Social </td>
    <td class="selected_cal">Direcci&oacute;n</td>
    <td class="selected_cal">RUC</td>
  </tr>
  <?php
  while (!$clientes->EOF) { 
?>
    <tr>
      <td><?php echo $clientes->Fields('idcliente'); ?></td>
      <td><?php
echo $edit1->editForId($clientes->Fields('idcliente'), $clientes->Fields('cliente'));
?></td>
      <td><?php
echo $edit2->editForId($clientes->Fields('idcliente'), $clientes->Fields('direccion'));
?></td>
      <td><?php
echo $edit3->editForId($clientes->Fields('idcliente'), $clientes->Fields('ruc'));
?></td>
    </tr>
    <?php
    $clientes->MoveNext(); 
  }
?>
<tr>
<td colspan="4" align="center"><a href="<?php printf("%s?pageNum_clientes=%d%s", $_SERVER["PHP_SELF"], 0, $queryString_clientes); ?>">Primero</a><a href="<?php printf("%s?pageNum_clientes=%d%s", $_SERVER["PHP_SELF"], min($totalPages_clientes, $pageNum_clientes + 1), $queryString_clientes); ?>">Siguiente</a> <a href="<?php printf("%s?pageNum_clientes=%d%s", $_SERVER["PHP_SELF"], $totalPages_clientes, $queryString_clientes); ?>">Último</a> </td>
</tr>
</table>
</body>
</html>
<?php
$clientes->Close();
?>
