<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

// Load the drag n drop classes
require_once('../includes/jaxon/widgets/dragndrop/dragndrop.php');

// initialize the drag n drop sort classes DWAjaxDnDSort1
$DWAjaxDnDSort1 = new DragNDrop("DWAjaxDnDSort1");
$DWAjaxDnDSort1->setConnection('cnx_cuzzicia');
$DWAjaxDnDSort1->setTable('gclientes');
$DWAjaxDnDSort1->setPrimaryKey('idgclien');
$DWAjaxDnDSort1->setSortableList('orden');

// begin Recordset
$query_sort1gclientes = "SELECT * FROM gclientes ORDER BY orden";
$sort1gclientes = $cnx_cuzzicia->SelectLimit($query_sort1gclientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_sort1gclientes = $sort1gclientes->RecordCount();
// end Recordset

$ajax_service = new AjaxService();

$ajax_service->exportMethod('DWAjaxDnDSort1', 'setCategory');
$ajax_service->exportMethod('DWAjaxDnDSort1', 'sortList');

$ajax_service->handleAjaxRequest();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Grupo Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/jaxon/widgets/dragndrop/css/dragndrop.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/dragndrop/js/dragndrop.js"></script>
<?php 
  echo $ajax_service->renderJavascriptStubs();
?>
<style type="text/css">
<!--
.format {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 10px;
	cursor: auto;
}
-->
</style>
</head>

<body>
<div class="format" id="<?php echo $DWAjaxDnDSort1->renderDNDDropZone(""); ?>">
  <h3>Grupo Clientes </h3>
  <ul id="<?php echo $DWAjaxDnDSort1->renderDNDDropList(""); ?>">
    <?php if ($totalRows_sort1gclientes > 0) { // Show if recordset not empty ?>
      <?php while (!$sort1gclientes->EOF) { ?>
        <li id="<?php echo $DWAjaxDnDSort1->renderDNDItem($sort1gclientes->Fields('idgclien'), ""); ?>" class="drag_item"><?php echo $sort1gclientes->Fields('nombre'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../clientes/detgclientes.php?idgclien=<?php echo $sort1gclientes->Fields('idgclien');?>&grupo=<?php echo $sort1gclientes->Fields('nombre');?>">Editar</a></li>
        <?php
		$sort1gclientes->MoveNext(); 
	}
?>
      <?php } // Show if recordset not empty ?>
  </ul>
</div>
<?php echo $DWAjaxDnDSort1->renderDNDJsBindings(); ?>
</body>
</html>
<?php
$sort1gclientes->Close();
?>
