<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'guiasc', 'dtable_DWAjaxTable1', 'salidaal');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(20);
$dtable_DWAjaxTable1->addColumn("nroguia", "NUMERIC_TYPE", "nroguia", "=");
$dtable_DWAjaxTable1->addColumn("fecha", "DATE_TYPE", "fecha", "=");
$dtable_DWAjaxTable1->addColumn("estado", "STRING_TYPE", "estado", "%");
$dtable_DWAjaxTable1->addColumn("cliente", "STRING_TYPE", "cliente", "%");
$dtable_DWAjaxTable1->addColumn("direccion", "STRING_TYPE", "direccion", "%");
$dtable_DWAjaxTable1->addColumn("local", "STRING_TYPE", "local", "%");
$dtable_DWAjaxTable1->setPK("idsalida", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('fecha', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

// Begin List Recordset
$maxRows_guiasc = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_guiasc = 0;
if (isset($_GET['pageNum_guiasc'])) {
  $pageNum_guiasc = $_GET['pageNum_guiasc'];
}
$startRow_guiasc = $pageNum_guiasc * $maxRows_guiasc;
// Defining List Recordset variable
$NXTFilter__guiasc = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter__guiasc = $dtable_DWAjaxTable1_filter_sql;
}
// Defining List Recordset variable
$NXTSort__guiasc = "fecha DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort__guiasc = $dtable_DWAjaxTable1_order_sql;
}
$query_guiasc = "SELECT s.idsalida,s.nroguia,s.fecha,s.estado,c.cliente,c.direccion,l.idlocal,l.local FROM salidaal s,clientes c,locals l WHERE s.idcliente = c.idcliente AND s.idlocal = l.idlocal AND  {$NXTFilter__guiasc} ORDER BY {$NXTSort__guiasc},s.nroguia desc";
$guiasc = $cnx_cuzzicia->SelectLimit($query_guiasc, $maxRows_guiasc, $startRow_guiasc) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_guiasc'])) {
  $totalRows_guiasc = $_GET['totalRows_guiasc'];
} else {
  $all_guiasc = $cnx_cuzzicia->SelectLimit($query_guiasc) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_guiasc = $all_guiasc->RecordCount();
}
$totalPages_guiasc = (int)(($totalRows_guiasc-1)/$maxRows_guiasc);
// End List Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_guiasc);
$dtable_DWAjaxTable1->setPageNum($pageNum_guiasc);
$dtable_DWAjaxTable1->setTotalRows($totalRows_guiasc);
$dtable_DWAjaxTable1->setTotalPages($totalPages_guiasc);

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('nroguia'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('nroguia'); ?>">Nroguia</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha'); ?>">Fecha</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cliente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cliente'); ?>">Cliente</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('direccion'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('direccion'); ?>">Direccion</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('local'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('local'); ?>">Local</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('estado'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('estado'); ?>">Estado</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_nroguia" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('nroguia')); ?>" size="10" maxlength="10" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fecha" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha'); ?>" size="10" maxlength="22" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_cliente" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('cliente')); ?>" size="20" maxlength="20" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_direccion" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('direccion')); ?>" size="30" maxlength="30" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_local" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('local')); ?>" size="15" maxlength="15" /></th>
            <th>&nbsp;</th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="8"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("../includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_guiasc == 0) { ?>
          <tr>
            <td colspan="8">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_guiasc > 0) { ?>
          <?php while (!$guiasc->EOF) { ?>
            <tr>
              <td align="right"><?php echo KT_FormatForList($guiasc->Fields('nroguia'), 10); ?></td>
              <td><?php echo KT_FormatForList($guiasc->Fields('fecha'), 10); ?></td>
              <td><?php echo KT_FormatForList($guiasc->Fields('cliente'), 20); ?></td>
              <td><?php echo KT_FormatForList($guiasc->Fields('direccion'), 30); ?></td>
              <td><?php echo KT_FormatForList($guiasc->Fields('local'), 15); ?></td>
              <td><?php echo KT_FormatForList($guiasc->Fields('estado'), 15); ?></td>
              <td><a href="verguia.php?idsali=<?php echo $guiasc->Fields('idsalida'); ?>&idlocal=<?php echo $guiasc->Fields('idlocal'); ?>">Ver</a> | 
				  <a href="actudatos.php?idsali=<?php echo $guiasc->Fields('idsalida'); ?>">Modificar</a><a href="verguia.php?idsali=<?php echo $guiasc->Fields('idsalida'); ?>&idlocal=<?php echo $guiasc->Fields('idlocal'); ?>"></a> | <a href="actudatos.php?idsali=<?php echo $guiasc->Fields('idsalida'); ?>"></a><a href="../elimina.php?tabla=salidaal&idtabla=idsalida&goto=guias/listaguiasc.php&id=<?php echo $guiasc->Fields('idsalida'); ?>"><img src="../images/del.gif" alt="Eliminar" width="16" height="16" border="0" longdesc="Eliminar Guia"> </a></td>
            </tr>
            <?php
					$guiasc->MoveNext(); 
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
$guiasc->Close();
?>
