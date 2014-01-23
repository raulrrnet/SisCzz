<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// Load the common classes
require_once('includes/common/KT_common.php');

// Load the common classes
require_once('includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'ordimp', 'dtable_DWAjaxTable1', 'orden');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(20);
$dtable_DWAjaxTable1->addColumn("fecha", "DATE_TYPE", "fecha", "=");
$dtable_DWAjaxTable1->addColumn("idorden", "NUMERIC_TYPE", "idorden", "=");
$dtable_DWAjaxTable1->addColumn("cliente", "STRING_TYPE", "cliente", "%");
$dtable_DWAjaxTable1->addColumn("descripcion", "STRING_TYPE", "descripcion", "%");
$dtable_DWAjaxTable1->addColumn("cantpedi", "NUMERIC_TYPE", "cantpedi", "=");
$dtable_DWAjaxTable1->setPK("idorden", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('idorden', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

// Begin List Recordset
$maxRows_ordimp = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_ordimp = 0;
if (isset($_GET['pageNum_ordimp'])) {
  $pageNum_ordimp = $_GET['pageNum_ordimp'];
}
$startRow_ordimp = $pageNum_ordimp * $maxRows_ordimp;
// Defining List Recordset variable
$NXTFilter__ordimp = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter__ordimp = $dtable_DWAjaxTable1_filter_sql;
}
// Defining List Recordset variable
$NXTSort__ordimp = "fecha DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort__ordimp = $dtable_DWAjaxTable1_order_sql;
}
$query_ordimp = "SELECT * FROM orden o,clientes c,prodorden p,tproducto tp,gproducto gp WHERE o.idcliente = c.idcliente AND  o.idprodorden = p.idprodorden AND gp.idgproduc = p.idgprod AND tp.idtproduc = p.idtprod AND  {$NXTFilter__ordimp}  ORDER BY  {$NXTSort__ordimp} ";
$ordimp = $cnx_cuzzicia->SelectLimit($query_ordimp, $maxRows_ordimp, $startRow_ordimp) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_ordimp'])) {
  $totalRows_ordimp = $_GET['totalRows_ordimp'];
} else {
  $all_ordimp = $cnx_cuzzicia->SelectLimit($query_ordimp) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_ordimp = $all_ordimp->RecordCount();
}
$totalPages_ordimp = (int)(($totalRows_ordimp-1)/$maxRows_ordimp);
// End List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_ordimp);
$dtable_DWAjaxTable1->setPageNum($pageNum_ordimp);
$dtable_DWAjaxTable1->setTotalRows($totalRows_ordimp);
$dtable_DWAjaxTable1->setTotalPages($totalPages_ordimp);

//PHP ADODB document - made with PHAkt 3.7.1

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orden de Produccion</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/kore/kore.js"></script>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/N1DependentField.js"></script>
<style type="text/css">
<!--
.cdiv {
	height: auto;
	width: 550px;
	overflow:auto;
	white-space:normal
}
-->
</style>
<link href="includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/jaxon/widgets/dtable/js/dtable.js"></script>
</head>

<body>
<form class="dtable" id="<?php echo $dtable_DWAjaxTable1->listName; ?>" action="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterUri()); ?>" method="get">
  <div> <?php echo $dtable_DWAjaxTable1->beginList(); ?>
      <table border="0" cellpadding="0" cellspacing="0">
        <caption>
        <?php
					$dtable = &$dtable_DWAjaxTable1;
				?>
        <?php require("includes/jaxon/widgets/dtable/nav/NAV_Text_Statistics.inc.php");?>
        </caption>
        <thead>
          <tr>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha'); ?>">Fecha</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('idorden'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('idorden'); ?>">Orden</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cliente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cliente'); ?>">Cliente</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('descripcion'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('descripcion'); ?>">Descripción</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cantpedi'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cantpedi'); ?>">Cantidad</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_fecha" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha'); ?>" size="10" maxlength="22" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_idorden" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('idorden')); ?>" size="10" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cliente" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cliente')); ?>" size="30" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_descripcion" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('descripcion')); ?>" size="40" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cantpedi" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cantpedi')); ?>" size="15" maxlength="50" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="7"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_ordimp == 0) { ?>
          <tr>
            <td colspan="7">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_ordimp > 0) { ?>
          <?php while (!$ordimp->EOF) { ?>
          <tr>
            <td><?php echo KT_FormatForList($ordimp->Fields('fecha'), 10); ?></td>
            <td><?php echo KT_FormatForList($ordimp->Fields('idorden'), 10); ?></td>
            <td><?php echo KT_FormatForList($ordimp->Fields('cliente'), 30); ?></td>
            <td><?php echo KT_FormatForList($ordimp->Fields('descripcion'), 40); ?></td>
            <td><?php echo KT_FormatForList($ordimp->Fields('cantpedi'), 15); ?></td>
            <td><a href="ordenimp.php?idord=<?php echo $ordimp->Fields('idorden'); ?>">Ver</a>&nbsp;&nbsp;&nbsp;<a href="actuorden.php?idord=<?php echo $ordimp->Fields('idorden'); ?>">Modificar</a></td>
          </tr>
          <?php
					$ordimp->MoveNext(); 
				}
			?>
          <?php }?>
        </tbody>
      </table>
    <script type="text/javascript">
		new Widgets.DataTable("<?php echo $dtable_DWAjaxTable1->listName; ?>");
	</script>
      <?php echo $dtable_DWAjaxTable1->endList(); ?> </div>
</form>
</body>
</html>
<?php
$ordimp->Close();
?>