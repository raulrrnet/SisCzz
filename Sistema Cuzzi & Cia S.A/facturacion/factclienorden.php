<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'facturas', 'dtable_DWAjaxTable1', 'detallefact');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(25);
$dtable_DWAjaxTable1->addColumn("idfact", "STRING_TYPE", "idfact", "%");
$dtable_DWAjaxTable1->addColumn("fecha", "DATE_TYPE", "fecha", "=");
$dtable_DWAjaxTable1->addColumn("idcliente", "NUMERIC_TYPE", "idcliente", "=");
$dtable_DWAjaxTable1->addColumn("idorden", "NUMERIC_TYPE", "idorden", "=");
$dtable_DWAjaxTable1->addColumn("gremi", "STRING_TYPE", "gremi", "%");
$dtable_DWAjaxTable1->addColumn("cantidad", "NUMERIC_TYPE", "cantidad", "=");
$dtable_DWAjaxTable1->addColumn("und", "STRING_TYPE", "und", "%");
$dtable_DWAjaxTable1->addColumn("descripcion", "STRING_TYPE", "descripcion", "%");
$dtable_DWAjaxTable1->setPK("idfact", "STRING_TYPE");
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
$query_facturas = "SELECT   f.idfact,   f.idcliente,   f.fecha,   f.gremi,   d.idorden,   d.cantidad,   d.descripcion,   d.und FROM factura f,   detallefact d WHERE f.idfact = d.idfactura AND  estado <> 'anulada' AND  {$NXTFilter__facturas} ORDER BY {$NXTSort__facturas} ";
$facturas = $cnx_cuzzicia->SelectLimit($query_facturas, $maxRows_facturas, $startRow_facturas) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_facturas'])) {
  $totalRows_facturas = $_GET['totalRows_facturas'];
} else {
  $all_facturas = $cnx_cuzzicia->SelectLimit($query_facturas) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_facturas = $all_facturas->RecordCount();
}
$totalPages_facturas = (int)(($totalRows_facturas-1)/$maxRows_facturas);
// End List Recordset

// begin Recordset
$query_clientes = "SELECT * FROM clientes c,gclientes g WHERE c.idgcliente = g.idgclien AND (idgcliente=3 OR c.cliente=g.nombre) ORDER BY cliente";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_facturas);
$dtable_DWAjaxTable1->setPageNum($pageNum_facturas);
$dtable_DWAjaxTable1->setTotalRows($totalRows_facturas);
$dtable_DWAjaxTable1->setTotalPages($totalPages_facturas);
?>
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('idfact'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('idfact'); ?>">Idfact</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha'); ?>">Fecha</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('idcliente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('idcliente'); ?>">Idcliente</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('idorden'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('idorden'); ?>">Idorden</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('gremi'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('gremi'); ?>">Gremi</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cantidad'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cantidad'); ?>">Cantidad</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('und'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('und'); ?>">Und</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('descripcion'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('descripcion'); ?>">Descripcion</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_idfact" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('idfact')); ?>" size="10" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fecha" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha'); ?>" size="10" maxlength="22" /></th>
            <th> <select name="dtable_DWAjaxTable1_idcliente" >
                <option value="" <?php if (!(strcmp("", $dtable_DWAjaxTable1->getFilterValue('idcliente')))) {echo "SELECTED";} ?>></option>
                <?php
  while(!$clientes->EOF){
?>
                <option value="<?php echo $clientes->Fields('idcliente')?>"<?php if (!(strcmp($clientes->Fields('idcliente'), $dtable_DWAjaxTable1->getFilterValue('idcliente')))) {echo "SELECTED";} ?>><?php echo $clientes->Fields('cliente')?></option>
                <?php
    $clientes->MoveNext();
  }
  $clientes->MoveFirst();
?>
              </select>
            </th>
            <th><input type="text" name="dtable_DWAjaxTable1_idorden" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('idorden')); ?>" size="10" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_gremi" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('gremi')); ?>" size="10" maxlength="20" /></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th><input type="text" name="dtable_DWAjaxTable1_descripcion" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('descripcion')); ?>" size="30" maxlength="20" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="10"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>
            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_facturas == 0) { ?>
          <tr>
            <td colspan="10">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_facturas > 0) { ?>
          <?php while (!$facturas->EOF) { ?>
            <tr>
              <td><?php echo KT_FormatForList($facturas->Fields('idfact'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('fecha'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('idcliente'), 20); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('idorden'), 20); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('gremi'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('cantidad'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('und'), 10); ?></td>
              <td><?php echo KT_FormatForList($facturas->Fields('descripcion'), 30); ?></td>
              <td>&nbsp;</td>
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

$clientes->Close();
?>