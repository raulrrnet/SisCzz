<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the rating classes
require_once('../includes/jaxon/widgets/editinplace/editinplace.php');

$edit1 = new EditInPlace("edit1");
$edit1->setConnection("cnx_cuzzicia");
$edit1->setTable("factura");
$edit1->setPrimaryKey("idfact");
$edit1->setEditField("gremi", "STRING_TYPE");
$edit1->setEnabledCondition("");

// begin Recordset
$query_Recordset1 = "SELECT * FROM factura f,clientes c WHERE f.idcliente=c.idcliente";
$Recordset1 = $cnx_cuzzicia->SelectLimit($query_Recordset1) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_Recordset1 = $Recordset1->RecordCount();
// end Recordset

$ajax_service = new AjaxService();

$ajax_service->exportMethod('edit1', 'updateValue'); 

$ajax_service->handleAjaxRequest();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/jaxon/widgets/editinplace/css/editinplace.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/editinplace/js/editinplace.js"></script>
<?php 
  echo $ajax_service->renderJavascriptStubs();
?>
</head>

<body>
<?php
  while (!$Recordset1->EOF) { 
?>
  <?php
echo $edit1->editForId($Recordset1->Fields('idfact'), $Recordset1->Fields('gremi'));
?>
  <?php
    $Recordset1->MoveNext(); 
  }
?></body>
</html>
<?php
$Recordset1->Close();
?>
