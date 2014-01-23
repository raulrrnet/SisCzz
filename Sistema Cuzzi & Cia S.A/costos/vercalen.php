<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the rating classes
require_once('../includes/jaxon/widgets/editinplace/editinplace.php');

$edit1 = new EditInPlace("edit1");
$edit1->setConnection("cnx_cuzzicia");
$edit1->setTable("detcalend");
$edit1->setPrimaryKey("iddetacalen");
$edit1->setEditField("dospri", "NUMERIC_TYPE");
$edit1->setEnabledCondition("");

$edit2 = new EditInPlace("edit2");
$edit2->setConnection("cnx_cuzzicia");
$edit2->setTable("detcalend");
$edit2->setPrimaryKey("iddetacalen");
$edit2->setEditField("sgts", "NUMERIC_TYPE");
$edit2->setEnabledCondition("");

$edit3 = new EditInPlace("edit3");
$edit3->setConnection("cnx_cuzzicia");
$edit3->setTable("detcalend");
$edit3->setPrimaryKey("iddetacalen");
$edit3->setEditField("tiempo", "decimal");
$edit3->setEnabledCondition("");

$ajax_service = new AjaxService();

$ajax_service->exportMethod('edit1', 'updateValue'); 

$ajax_service->exportMethod('edit2', 'updateValue'); 

$ajax_service->exportMethod('edit3', 'updateValue'); 

$ajax_service->handleAjaxRequest();

// begin Recordset
$idcalen = '0';
if (isset($_POST['idcalen'])) {
  $idcalen = $_POST['idcalen'];
}
$fecini = '2003/01/01';
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$fecfin = '2003/01/01';
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
$query_cnkardex = sprintf("select * from detcalend where idcalen=$idcalen and fecha between '$fecini' and '$fecfin' Order by fecha");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$query_sum = sprintf("select sum(tiempo) from detcalend where idcalen=$idcalen and fecha between '$fecini' and '$fecfin'");
$cnsum = $cnx_cuzzicia->SelectLimit($query_sum) or die($cnx_cuzzicia->ErrorMsg());

//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.Estilo3 {font-size: 14px}
-->
</style>
<link href="../includes/jaxon/widgets/editinplace/css/editinplace.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/editinplace/js/editinplace.js"></script>
<?php 
  echo $ajax_service->renderJavascriptStubs();
?>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="KT_th">NOMBRE:</td>
    <td colspan="2">Calendario <?php echo $cnkardex->Fields('idcalen'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">FECHA</td>
    <td class="KT_th">%1</td>
    <td class="KT_th">%2</td>
    <td class="KT_th">DEBIO</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
      <tr>
        <td><?php echo $cnkardex->Fields('fecha'); ?></td>
        <td align="right"><?php
echo $edit1->editForId($cnkardex->Fields('iddetacalen'), $cnkardex->Fields('dospri'));
?></td>
        <td align="right"><?php
echo $edit2->editForId($cnkardex->Fields('iddetacalen'), $cnkardex->Fields('sgts'));
?></td>
        <td align="right"><?php
echo $edit3->editForId($cnkardex->Fields('iddetacalen'), $cnkardex->Fields('tiempo'));
?></td>
      </tr>
  <?php
    $cnkardex->MoveNext(); 
  }
?>
    <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><span class="Estilo3"><strong>TOTAL</strong></span></td>
    <td align="right"><span class="Estilo3"><strong><?php echo number_format($cnsum->Fields('sum'),2);?></strong></span></td>
    </tr>
</table>
<A HREF=" javascript: location. reload() "> Actualizar </a>
</body>
</html>
<?php
$cnkardex->Close();
?>