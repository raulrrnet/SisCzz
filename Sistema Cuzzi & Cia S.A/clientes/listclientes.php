<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_clientes = "SELECT * FROM clientes c,gclientes g WHERE c.idgcliente = g.idgclien AND (idgcliente=3 OR c.cliente=g.nombre) ORDER BY cliente";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.format {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 12px;
	cursor: auto;
}
-->
</style>
</head>

<body>
<div class="format">
<?php
  while (!$clientes->EOF) { 
?>
<ul>
  <li> <?php echo $clientes->Fields('cliente'); ?>
<?php
$idcli = $clientes->Fields('idcliente');
// begin Recordset
$query_local = "SELECT * FROM locals WHERE idcliente = $idcli";
$local = $cnx_cuzzicia->SelectLimit($query_local) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_local = $local->RecordCount();
// end Recordset
?> 
<a href="asignalocal.php?idclien=<?php echo $clientes->Fields('idcliente');?>">Agregar Local</a>
<?php
  while (!$local->EOF) { 
?>
	<ul>
	  <li> <?php echo $local->Fields('nombre'); ?> </li>
	</ul>
    <?php
    $local->MoveNext(); 
  }
?>
</li>
</ul>
    <?php
    $clientes->MoveNext(); 
  }
?>
</div>
</body>
</html>
<?php
$clientes->Close();
$local->Close();
?>
