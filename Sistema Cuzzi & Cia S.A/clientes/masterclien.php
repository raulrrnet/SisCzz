<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'gclientes', 'dtable_DWAjaxTable1', 'clientes');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(25);
$dtable_DWAjaxTable1->addColumn("cliente", "STRING_TYPE", "cliente", "%");
$dtable_DWAjaxTable1->addColumn("ruc", "NUMERIC_TYPE", "ruc", "=");
$dtable_DWAjaxTable1->addColumn("nombre", "STRING_TYPE", "nombre", "%");
$dtable_DWAjaxTable1->addColumn("orden", "STRING_TYPE", "orden", "%");
$dtable_DWAjaxTable1->setPK("idcliente", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('orden', 'ASC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

// Begin List Recordset
$maxRows_gclientes = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_gclientes = 0;
if (isset($_GET['pageNum_gclientes'])) {
  $pageNum_gclientes = $_GET['pageNum_gclientes'];
}
$startRow_gclientes = $pageNum_gclientes * $maxRows_gclientes;
// Defining List Recordset variable
$NXTFilter__gclientes = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter__gclientes = $dtable_DWAjaxTable1_filter_sql;
}
// Defining List Recordset variable
$NXTSort__gclientes = "orden";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort__gclientes = $dtable_DWAjaxTable1_order_sql;
}
$query_gclientes = "SELECT * FROM clientes c, gclientes g WHERE c.idgcliente=g.idgclien AND  {$NXTFilter__gclientes}  ORDER BY  {$NXTSort__gclientes} ";
$gclientes = $cnx_cuzzicia->SelectLimit($query_gclientes, $maxRows_gclientes, $startRow_gclientes) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_gclientes'])) {
  $totalRows_gclientes = $_GET['totalRows_gclientes'];
} else {
  $all_gclientes = $cnx_cuzzicia->SelectLimit($query_gclientes) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_gclientes = $all_gclientes->RecordCount();
}
$totalPages_gclientes = (int)(($totalRows_gclientes-1)/$maxRows_gclientes);
// End List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_gclientes);
$dtable_DWAjaxTable1->setPageNum($pageNum_gclientes);
$dtable_DWAjaxTable1->setTotalRows($totalRows_gclientes);
$dtable_DWAjaxTable1->setTotalPages($totalPages_gclientes);

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cliente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cliente'); ?>">Cliente</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('ruc'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('ruc'); ?>">Ruc</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nombre'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nombre'); ?>">Grupo</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('orden'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('orden'); ?>">Orden</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_cliente" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cliente')); ?>" size="30" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_ruc" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('ruc')); ?>" size="12" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_nombre" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nombre')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_orden" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('orden')); ?>" size="5" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="6"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_gclientes == 0) { ?>
          <tr>
            <td colspan="6">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_gclientes > 0) { ?>
          <?php while (!$gclientes->EOF) { ?>
            <tr>
              <td><?php echo KT_FormatForList($gclientes->Fields('cliente'), 30); ?></td>
              <td><?php echo KT_FormatForList($gclientes->Fields('ruc'), 12); ?></td>
              <td><?php echo KT_FormatForList($gclientes->Fields('nombre'), 20); ?></td>
              <td><?php echo KT_FormatForList($gclientes->Fields('orden'), 5); ?></td>
              <td><a href="asignaclien.php?idcliente=<?php echo $gclientes->Fields('idcliente'); ?>">Details</a></td>
            </tr>
            <?php
					$gclientes->MoveNext(); 
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
$gclientes->Close();
?>