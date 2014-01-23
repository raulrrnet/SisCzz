<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// Load the common classes
require_once('includes/common/KT_common.php');

// Load the common classes
require_once('includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'asignaoper', 'dtable_DWAjaxTable1', 'asignacion');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(25);
$dtable_DWAjaxTable1->addColumn("idoperario", "NUMERIC_TYPE", "idoperario", "=");
$dtable_DWAjaxTable1->addColumn("nombre", "STRING_TYPE", "nombre", "%");
$dtable_DWAjaxTable1->addColumn("estado", "STRING_TYPE", "estado", "%");
$dtable_DWAjaxTable1->addColumn("idseccion", "NUMERIC_TYPE", "idseccion", "=");
$dtable_DWAjaxTable1->addColumn("seccion", "STRING_TYPE", "seccion", "%");
$dtable_DWAjaxTable1->addColumn("porcentaje", "NUMERIC_TYPE", "porcentaje", "=");
$dtable_DWAjaxTable1->setPK("idasigna", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('nombre', 'ASC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

// Begin List Recordset
$maxRows_asignaoper = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_asignaoper = 0;
if (isset($_GET['pageNum_asignaoper'])) {
  $pageNum_asignaoper = $_GET['pageNum_asignaoper'];
}
$startRow_asignaoper = $pageNum_asignaoper * $maxRows_asignaoper;
// Defining List Recordset variable
$NXTFilter__asignaoper = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter__asignaoper = $dtable_DWAjaxTable1_filter_sql;
}
// Defining List Recordset variable
$NXTSort__asignaoper = "nombre";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort__asignaoper = $dtable_DWAjaxTable1_order_sql;
}
$query_asignaoper = "SELECT a.idasigna, o.idoperario,   o.nombre,   o.estado,   s.seccion,   s.idseccion,   a.porcentaje FROM operario o,   asignacion a,   seccion s WHERE (o.idoperario = a.idoperario) and   s.idseccion = a.idseccion and estado = 'A' AND  {$NXTFilter__asignaoper}  ORDER BY  {$NXTSort__asignaoper} ";
$asignaoper = $cnx_cuzzicia->SelectLimit($query_asignaoper, $maxRows_asignaoper, $startRow_asignaoper) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_asignaoper'])) {
  $totalRows_asignaoper = $_GET['totalRows_asignaoper'];
} else {
  $all_asignaoper = $cnx_cuzzicia->SelectLimit($query_asignaoper) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_asignaoper = $all_asignaoper->RecordCount();
}
$totalPages_asignaoper = (int)(($totalRows_asignaoper-1)/$maxRows_asignaoper);
// End List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_asignaoper);
$dtable_DWAjaxTable1->setPageNum($pageNum_asignaoper);
$dtable_DWAjaxTable1->setTotalRows($totalRows_asignaoper);
$dtable_DWAjaxTable1->setTotalPages($totalPages_asignaoper);
//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="includes/kore/kore.js"></script>
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nombre'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nombre'); ?>">Nombre</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('estado'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('estado'); ?>">Estado</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('seccion'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('seccion'); ?>">Seccion</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('porcentaje'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('porcentaje'); ?>">%</a></th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="6"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_asignaoper == 0) { ?>
          <tr>
            <td colspan="6">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_asignaoper > 0) { ?>
          <?php while (!$asignaoper->EOF) { ?>
            <tr>
              <td><?php echo KT_FormatForList($asignaoper->Fields('nombre'), 30); ?></td>
              <td><?php echo KT_FormatForList($asignaoper->Fields('estado'), 10); ?></td>
              <td><?php echo KT_FormatForList($asignaoper->Fields('seccion'), 40); ?></td>
              <td align="right"><?php echo KT_FormatForList($asignaoper->Fields('porcentaje'), 20); ?>%</td>
              <td><a href="modasig.php?idasigna=<?php echo $asignaoper->Fields('idasigna'); ?>">Editar</a></td>
            </tr>
            <?php
					$asignaoper->MoveNext(); 
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
$asignaoper->Close();
?>