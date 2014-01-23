<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$maxRows_tcambio = 30;
$pageNum_tcambio = 0;
if (isset($_GET['pageNum_tcambio'])) {
  $pageNum_tcambio = $_GET['pageNum_tcambio'];
}
$startRow_tcambio = $pageNum_tcambio * $maxRows_tcambio;
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha DESC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio, $maxRows_tcambio, $startRow_tcambio) or die($cnx_cuzzicia->ErrorMsg());
if (isset($_GET['totalRows_tcambio'])) {
  $totalRows_tcambio = $_GET['totalRows_tcambio'];
} else {
  $all_tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
  $totalRows_tcambio = $all_tcambio->RecordCount();
}
$totalPages_tcambio = (int)(($totalRows_tcambio-1)/$maxRows_tcambio);
// end Recordset

// rebuild the query string by replacing pageNum and totalRows with the new values
$queryString_tcambio = KT_removeParam("&" . @$_SERVER['QUERY_STRING'], "pageNum_tcambio");
$queryString_tcambio = KT_replaceParam($queryString_tcambio, "totalRows_tcambio", $totalRows_tcambio);

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/kore/kore.js"></script>
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="3" class="KT_th">TIPO CAMBIO </td>
  </tr>
  <tr>
    <td class="selected_cal">Fecha</td>
    <td class="selected_cal">T. Cambio </td>
    <td>&nbsp;</td>
  </tr>
  <?php
  while (!$tcambio->EOF) { 
?>
    <tr>
      <td><?php echo $tcambio->Fields('fecha'); ?></td>
      <td align="right"><?php echo $tcambio->Fields('tcambio'); ?></td>
      <td><a href="elimina.php?tabla=tipocambio&idtabla=fecha&goto=tcambio.php&id=<?php echo $tcambio->Fields('fecha');?>">Borrar</a></td>
    </tr>
    <?php
    $tcambio->MoveNext(); 
  }
?>
<tr>
<td colspan="3" align="center"><table width="200" border="0">
  <tr>
    <td><a href="<?php printf("%s?pageNum_tcambio=%d%s", $_SERVER["PHP_SELF"], 0, $queryString_tcambio); ?>">Primero</a></td>
    <td><a href="<?php printf("%s?pageNum_tcambio=%d%s", $_SERVER["PHP_SELF"], max(0, $pageNum_tcambio - 1), $queryString_tcambio); ?>">Anterior</a></td>
    <td><a href="<?php printf("%s?pageNum_tcambio=%d%s", $_SERVER["PHP_SELF"], min($totalPages_tcambio, $pageNum_tcambio + 1), $queryString_tcambio); ?>">Siguiente</a></td>
    <td><a href="<?php printf("%s?pageNum_tcambio=%d%s", $_SERVER["PHP_SELF"], $totalPages_tcambio, $queryString_tcambio); ?>">Último</a></td>
  </tr>
</table></td>
</tr>
</table>

</body>
</html>
<?php
$tcambio->Close();
?>