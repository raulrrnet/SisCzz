<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// Load the common classes
require_once('includes/common/KT_common.php');

// Load the common classes
require_once('includes/jaxon/widgets/dtable/dtable.php');

$dtable_DWAjaxTable1 = new dtable($cnx_cuzzicia, 'Recordset1', 'dtable_DWAjaxTable1', 'orden');
$dtable_DWAjaxTable1->setUrl(KT_getFullUri());
$dtable_DWAjaxTable1->setMaxRows(25);
$dtable_DWAjaxTable1->addColumn("idorden", "NUMERIC_TYPE", "idorden", "=");
$dtable_DWAjaxTable1->addColumn("fecha", "DATE_TYPE", "fecha", "=");
$dtable_DWAjaxTable1->addColumn("cliente", "STRING_TYPE", "cliente", "%");
$dtable_DWAjaxTable1->addColumn("descripcion", "STRING_TYPE", "descripcion", "%");
$dtable_DWAjaxTable1->addColumn("fechaliqui", "DATE_TYPE", "fechaliqui", "=");
$dtable_DWAjaxTable1->addColumn("fechatermi", "DATE_TYPE", "fechatermi", "=");
$dtable_DWAjaxTable1->setPK("idorden", "NUMERIC_TYPE");
$dtable_DWAjaxTable1->setDefaultSortColumn('idorden', 'DESC');
$dtable_DWAjaxTable1->Execute();

$dtable_DWAjaxTable1_filter_sql = $dtable_DWAjaxTable1->getFilter();
$dtable_DWAjaxTable1_order_sql = $dtable_DWAjaxTable1->getSorter();

// Begin List Recordset
$maxRows_Recordset1 = $dtable_DWAjaxTable1->getMaxRows();
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
// Defining List Recordset variable
$NXTFilter__Recordset1 = "1=1";
if (isset($dtable_DWAjaxTable1_filter_sql)) {
  $NXTFilter__Recordset1 = $dtable_DWAjaxTable1_filter_sql;
}
// Defining List Recordset variable
$NXTSort__Recordset1 = "idorden DESC";
if (isset($dtable_DWAjaxTable1_order_sql)) {
  $NXTSort__Recordset1 = $dtable_DWAjaxTable1_order_sql;
}
$query_Recordset1 = "SELECT o.idorden,o.fecha,o.idcliente,c.cliente,o.descripcion,o.fechaliqui,o.fechatermi FROM orden o, clientes c WHERE o.idcliente=c.idcliente AND  {$NXTFilter__Recordset1} ORDER BY {$NXTSort__Recordset1} ";
$Recordset1 = $cnx_cuzzicia->SelectLimit($query_Recordset1, $maxRows_Recordset1, $startRow_Recordset1) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = $cnx_cuzzicia->SelectLimit($query_Recordset1) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_Recordset1 = $all_Recordset1->RecordCount();
}
$totalPages_Recordset1 = (int)(($totalRows_Recordset1-1)/$maxRows_Recordset1);
// End List Recordset

// begin Recordset
$query_clientes = "SELECT c.idcliente,c.cliente FROM clientes c,orden o WHERE o.idcliente = c.idcliente GROUP BY c.idcliente,c.cliente ORDER BY  c.cliente";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

// AJAX Dynamic Table statistics
$dtable_DWAjaxTable1->setStartRow($startRow_Recordset1);
$dtable_DWAjaxTable1->setPageNum($pageNum_Recordset1);
$dtable_DWAjaxTable1->setTotalRows($totalRows_Recordset1);
$dtable_DWAjaxTable1->setTotalPages($totalPages_Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<link href="includes/jaxon/widgets/dtable/css/dtable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/kore/kore.js"></script>
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
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('idorden'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('idorden'); ?>">Idorden</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fecha'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fecha'); ?>">Fecha</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('cliente'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('cliente'); ?>">Cliente</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('descripcion'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('descripcion'); ?>">Descripcion</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fechaliqui'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fechaliqui'); ?>">Fechaliqui</a></th>
            <th class="KT_sort <?php echo $dtable_DWAjaxTable1->getSortIcon('fechatermi'); ?>"><a href="<?php echo $dtable_DWAjaxTable1->getSortLink('fechatermi'); ?>">Fechatermi</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
?>
          <tr class="filter">
            <th><input type="text" name="dtable_DWAjaxTable1_idorden" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('idorden')); ?>" size="10" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fecha" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fecha'); ?>" size="10" maxlength="22" /></th>
            <th><select name="dtable_DWAjaxTable1_cliente" >
              <option value="" <?php if (!(strcmp("", $dtable_DWAjaxTable1->getFilterValue('cliente')))) {echo "SELECTED";} ?>></option>
              <?php
  while(!$clientes->EOF){
?>
              <option value="<?php echo $clientes->Fields('cliente')?>"<?php if (!(strcmp($clientes->Fields('cliente'), $dtable_DWAjaxTable1->getFilterValue('cliente')))) {echo "SELECTED";} ?>><?php echo $clientes->Fields('cliente')?></option>
              <?php
    $clientes->MoveNext();
  }
  $clientes->MoveFirst();
?>
            </select></th>
            <th><input type="text" name="dtable_DWAjaxTable1_descripcion" value="<?php echo KT_escapeAttribute($dtable_DWAjaxTable1->getFilterValue('descripcion')); ?>" size="50" maxlength="100" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fechaliqui" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fechaliqui'); ?>" size="10" maxlength="22" /></th>
            <th><input type="text" name="dtable_DWAjaxTable1_fechatermi" value="<?php echo $dtable_DWAjaxTable1->getFilterValue('fechatermi'); ?>" size="10" maxlength="22" /></th>
            <th><input class="filterButton" type="submit" name="dtable_DWAjaxTable1" value="Filter"/></th>
          </tr>
          <?php 
  // endif Conditional region3
?>
        </thead>
        <tfoot>
          <tr>
            <td colspan="8"><?php $dtable = &$dtable_DWAjaxTable1; ?>
                <?php require("includes/jaxon/widgets/dtable/nav/NAV_Text_Navigation.inc.php");?>            </td>
          </tr>
        </tfoot>
        <tbody class="data">
          <?php if ($totalRows_Recordset1 == 0) { ?>
          <tr>
            <td colspan="8">The table is empty or the filter you've selected is too restrictive.</td>
          </tr>
          <?PHP } ?>
          <?php if ($totalRows_Recordset1 > 0) { ?>
          <?php while (!$Recordset1->EOF) { ?>
            <tr>
              <td><?php echo KT_FormatForList($Recordset1->Fields('idorden'), 10); ?></td>
              <td><?php echo KT_FormatForList($Recordset1->Fields('fecha'), 10); ?></td>
              <td><?php echo KT_FormatForList($Recordset1->Fields('cliente'), 30); ?></td>
              <td><?php echo KT_FormatForList($Recordset1->Fields('descripcion'), 50); ?></td>
              <td><?php echo KT_FormatForList($Recordset1->Fields('fechaliqui'), 10); ?></td>
              <td><?php echo KT_FormatForList($Recordset1->Fields('fechatermi'), 10); ?></td>
              <td><a href="liqimp.php?idord=<?php echo $Recordset1->Fields('idorden'); ?>">Detalle</a></td>
            </tr>
            <?php
					$Recordset1->MoveNext(); 
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
$Recordset1->Close();

$clientes->Close();
?>
