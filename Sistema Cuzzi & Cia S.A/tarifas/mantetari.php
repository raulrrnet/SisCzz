<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$fec = date("Y/m/d");
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha); 
$sql = sprintf("SELECT dt.idtarifadet,s.idseccion,s.seccion,s.status,dt.vdolar,dt.vsoles,dt.fechavigencia FROM detalletarifa dt, seccion s WHERE (dt.idseccion = s.idseccion) and status='Vigente' order by dt.fechavigencia desc,s.seccion");
$exsql = $cnx_cuzzicia->SelectLimit($sql) or die($cnx_cuzzicia->ErrorMsg());
$totalRowsSql = $exsql->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">
  
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td class="KT_th">Id</td>
        <td class="KT_th">Secci&oacute;n</td>
        <td class="KT_th">&nbsp;</td>
        <td class="KT_th">V. Soles</td>
        <td class="KT_th">F. Vigencia </td>
        <td class="KT_th">&nbsp;</td>
        </tr>
<?php
  while (!$exsql->EOF) { 
?>
      <tr>
        <td><?php echo $exsql->Fields('idtarifadet'); ?></td>
        <td><?php echo $exsql->Fields('seccion'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right"><?php echo number_format($exsql->Fields('vsoles'),2); ?></td>
        <td align="right"><?php echo $exsql->Fields('fechavigencia'); ?></td>
        <td align="right"><a href="ctarif.php">NUEVA TARIFA </a></td>
        </tr>
      <?php
    $exsql->MoveNext(); 
  }
?>
    </table></td>
  </tr>
</table>
</body>
</html>