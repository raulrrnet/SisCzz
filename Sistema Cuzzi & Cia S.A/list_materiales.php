<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//keep all parameters except idmateriales
KT_keepParams('idmateriales');

// begin Recordset
$fec__cningresos = date("Y/m/d");
$fecfecha = strtotime($fec__cningresos); 
$ano = date("Y", $fecfecha); 
$query_cningresos = sprintf("SELECT idmateriales,tipoconsumo||' / '||categoria as tipocate,materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales FROM materiales1 GROUP BY idmateriales,tipocate,tmateriales ORDER BY tipocate,idmateriales");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cningresos) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<?php  $lastTFM_nest = "";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" class="KT_tngtable">
  <tr>
    <td align="center">LISTADO MATERIALES   AL <?php echo $fec__cningresos; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <?php
  while (!$cnkardex->EOF) { 
?>
<?php if($totalRows_cnkardex>=0){ ?>
      <?php $TFM_nest = $cnkardex->Fields('tipocate');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
      <tr>
        <td class="KT_th">Id</td>
        <td class="KT_th"><?php echo $cnkardex->Fields('tipocate'); ?></td>
        <td class="KT_th">&nbsp;</td>
      </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td><?php echo $cnkardex->Fields('idmateriales'); ?></td>
        <td><?php echo $cnkardex->Fields('tmateriales'); ?></td>
        <td align="right"><a href="costos/elimina.php?tabla=materiales&idtabla=idmateriales&goto=../list_materiales.php&id=<?php echo $cnkardex->Fields('idmateriales');?>">ELIMINAR</a></td>
      </tr>
<?php }?>
      <?php
    $cnkardex->MoveNext(); 
  }
?>
    </table></td>
  </tr>
</table>
</body>
</html>