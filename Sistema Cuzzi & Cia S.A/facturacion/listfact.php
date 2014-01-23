<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'facturas', 'dtable_DWAjaxTable1', 'factura');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(15);
$dtable_DWAjaxTable1->addColumn("idfact", "STRING_TYPE", "idfact", "%");
$dtable_DWAjaxTable1->addColumn("fecha", "DATE_TYPE", "fecha", "=");
$dtable_DWAjaxTable1->addColumn("cliente", "STRING_TYPE", "cliente", "%");
$dtable_DWAjaxTable1->addColumn("ruc", "NUMERIC_TYPE", "ruc", "=");
$dtable_DWAjaxTable1->addColumn("gremi", "STRING_TYPE", "gremi", "%");
$dtable_DWAjaxTable1->addColumn("pedido", "STRING_TYPE", "pedido", "%");
$dtable_DWAjaxTable1->addColumn("estado", "STRING_TYPE", "estado", "%");
$dtable_DWAjaxTable1->setPK("idfact", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('idfact', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

// Begin List Recordset
$maxRows_facturas = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_facturas = 0;
if (isset($_GET['pageNum_facturas'])) {
  $pageNum_facturas = $_GET['pageNum_facturas'];
}
$startRow_facturas = $pageNum_facturas * $maxRows_facturas;
// Defining List Recordset variable
$NXTFilter__facturas = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter__facturas = $dtable_DWAjaxTable1_filter_sql;
}
// Defining List Recordset variable
$NXTSort__facturas = "idfact DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort__facturas = $dtable_DWAjaxTable1_order_sql;
}
$query_facturas = "SELECT * FROM factura f, clientes c WHERE f.idcliente=c.idcliente AND  {$NXTFilter__facturas}  ORDER BY  {$NXTSort__facturas} ";
$facturas = $cnx_cuzzicia->SelectLimit($query_facturas, $maxRows_facturas, $startRow_facturas) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_facturas'])) {
  $totalRows_facturas = $_GET['totalRows_facturas'];
} else {
  $all_facturas = $cnx_cuzzicia->SelectLimit($query_facturas) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_facturas = $all_facturas->RecordCount();
}
$totalPages_facturas = (int)(($totalRows_facturas-1)/$maxRows_facturas);
// End List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_facturas);
$dtable_DWAjaxTable1->setPageNum($pageNum_facturas);
$dtable_DWAjaxTable1->setTotalRows($totalRows_facturas);
$dtable_DWAjaxTable1->setTotalPages($totalPages_facturas);

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/jaxon/widgets/dtable/js/dtable.js"></script>
</head>

<body>
<form class="dtable" id="<?php echo $dtable_DWAjaxTable1->listName; ?>" action="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterUri()); ?>" method="get">
  <div> <?php echo $dtable_DWAjaxTable1->beginList(); ?>
      <table border="0" cellpadding="0" cellspacing="0">
        <caption>
        <?php
					$dtable = &$dtable_DWAjaxTable1;
				?>
        <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Statistics.inc.php");?>
        </caption>
        <thead>
          <tr>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('idfact'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('idfact'); ?>">NºFact.</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha'); ?>">Fecha</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cliente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cliente'); ?>">Cliente</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('ruc'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('ruc'); ?>">Ruc</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('gremi'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('gremi'); ?>">G.Remisión</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('pedido'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('pedido'); ?>">Pedido</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('estado'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('estado'); ?>">Estado</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_idfact" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('idfact')); ?>" size="10" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fecha" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha'); ?>" size="10" maxlength="22" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cliente" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cliente')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_ruc" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('ruc')); ?>" size="12" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_gremi" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('gremi')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_pedido" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('pedido')); ?>" size="15" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_estado" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('estado')); ?>" size="10" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="9"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_facturas == 0) { ?>
          <tr>
            <td colspan="9">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_facturas > 0) { ?>
          <?php while (!$facturas->EOF) { ?>
            <tr>
              <td><?php echo KT_FormatForList($facturas->Fields('idfact'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('fecha'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('cliente'), 20); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('ruc'), 12); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('gremi'), 20); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('pedido'), 15); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('estado'), 10); ?></td>
              <td><a href="verfact.php?idfac=<?php echo $facturas->Fields('idfact'); ?>">Ver</a> | 
				  <a href="actudatos.php?idfac=<?php echo $facturas->Fields('idfact'); ?>">Modificar</a>         
			  </td>
            </tr>
            <?php
					$facturas->MoveNext(); 
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
$facturas->Close();
?>
