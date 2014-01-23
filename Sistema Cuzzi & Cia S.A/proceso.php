<?php require_once('includes/jaxon/widgets/request.php'); ?>
<?php // Widget region file. Do not remove this line. ?>
<?php //PHP ADODB document - made with PHAkt 3.7.1 ?>
<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$ord__procesos = '-1';
if (isset($_GET['idord'])) {
  $ord__procesos = $_GET['idord'];
}
$query_procesos = sprintf("SELECT fecha, seccion FROM v_informes WHERE idorden = %s GROUP BY fecha, seccion ORDER BY fecha DESC", GetSQLValueString($ord__procesos, "int"));
$procesos = $cnx_cuzzicia->SelectLimit($query_procesos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_procesos = $procesos->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
// HEAD content
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<style type="text/css">
<!--
*
{
	border: 0;
	margin: 0;
}
ul {
	font-size: 12px;
}
-->
</style>

<?php
// Begin HTML content
?>
<ul>
  <?php
  while (!$procesos->EOF) { 
?>
    <li><?php echo $procesos->Fields('fecha').' / '.$procesos->Fields('seccion'); ?></li>
    <?php
    $procesos->MoveNext(); 
  }
?></ul>

<?php
// End HTML content
?>
<?php
$procesos->Close();
?>
