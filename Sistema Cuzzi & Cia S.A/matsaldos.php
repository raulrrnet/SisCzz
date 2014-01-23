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
$query_cningresos = sprintf("SELECT idmateriales,diasrepo,tipoconsumo||' / '||categoria as tipocate, sum(saldo) as saldo,sum(case when(movimiento='Salida') then(cantidad) end) as cant,materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales FROM v_consultas WHERE date_part('year', fecha) = $ano and fecha <= '$fec__cningresos' GROUP BY idmateriales,diasrepo,tipocate,tmateriales ORDER BY tipocate,tmateriales");
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
    <td align="center">RESUMEN SALDOS AL <?php echo $fec__cningresos; ?></td>
  </tr>
  <tr>
    <td><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <?php
  while (!$cnkardex->EOF) { 
  $idmat = $cnkardex->Fields('idmateriales');
  $cncant = sprintf("SELECT sum(case when(movimiento='Salida') then(cantidad) end) as cant
FROM movimientos WHERE date_part('year', fecha) = $ano-1 and idmaterial=$idmat");
$excant = $cnx_cuzzicia->SelectLimit($cncant) or die($cnx_cuzzicia->ErrorMsg());
?>
<?php if($cnkardex->Fields('saldo')<>0){ ?>
      <?php $TFM_nest = $cnkardex->Fields('tipocate');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
  ?>
      <tr>
        <td class="KT_th"><?php echo $cnkardex->Fields('tipocate'); ?></td>
        <td class="KT_th">Saldo</td>
        <td class="KT_th">Dias Stock </td>
        <td class="KT_th">Dias Reposici&oacute;n </td>
        <td class="KT_th">*</td>
      </tr>
      <?php } //End of Basic-UltraDev Simulated Nested Repeat?>
      <tr>
        <td><?php echo $cnkardex->Fields('tmateriales'); ?></td>
        <td align="right"><?php echo number_format($cnkardex->Fields('saldo'),2); ?></td>
        <td align="right"><?php
		$cantconsu = $excant->Fields('cant');
		if($cantconsu == ''){
		echo '-';
		}else{
		$ds = $cnkardex->Fields('saldo') * 360 / $excant->Fields('cant');
		echo number_format($ds,2);}?></td>
        <td align="right"><?php if ($cnkardex->Fields('diasrepo')<>''){
		$dr = $cnkardex->Fields('diasrepo');
		echo $dr;
		}else{echo "-";}?></td>
        <td align="right"><span class="Estilo1">
          <?php if ($cnkardex->Fields('diasrepo')<>''){
		if($ds < $dr){echo "-Alerta-";}
		}else{echo "-";}?>
        </span></td>
      </tr>
<?php }?>
      <?php
    $cnkardex->MoveNext();
	$excant->MoveNext(); 
  }
?>
    </table></td>
  </tr>
</table>
</body>
</html>