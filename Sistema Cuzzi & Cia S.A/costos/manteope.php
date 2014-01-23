<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$fec = date("Y/m/d");
$fecfecha = strtotime($fec); 
$ano = date("Y", $fecfecha); 
$sql = sprintf("SELECT * FROM operario ORDER BY nombre");
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
    <td align="center">RELACION OPERARIOS  AL <?php echo $fec; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td class="KT_th">Id</td>
        <td class="KT_th">Operarios</td>
        <td class="KT_th">Cargo</td>
        <td class="KT_th">Estado</td>
        <td class="KT_th">&nbsp;</td>
        <td class="KT_th">&nbsp;</td>
      </tr>
<?php
  while (!$exsql->EOF) { 
?>
      <tr>
        <td><?php echo $exsql->Fields('idoperario'); ?></td>
        <td><?php echo $exsql->Fields('nombre'); ?></td>
        <td align="right"><?php echo $exsql->Fields('cargo'); ?></td>
        <td align="right"><?php echo $exsql->Fields('estado'); ?></td>
        <td align="right"><a href="actuope.php?idope=<?php echo $exsql->Fields('idoperario'); ?>">MODIFICAR</a></td>
        <td align="right"><a href="elimina.php?tabla=operario&idtabla=idoperario&goto=manteope.php&id=<?php echo $exsql->Fields('idoperario');?>">ELIMINAR</a></td>
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