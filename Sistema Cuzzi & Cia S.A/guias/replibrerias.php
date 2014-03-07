<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_Recordset1 = "SELECT c.idcliente,c.cliente,d.idorden,max(d.descripcion),sum(d.cantidad) FROM salidaal s,detsalidaal d,clientes c,locals l WHERE s.idsalida = d.idsalidaal AND s.idcliente = c.idcliente AND s.idlocal = l.idlocal GROUP BY c.idcliente,cliente, idorden ORDER BY cliente,idorden";
$Recordset1 = $cnx_cuzzicia->SelectLimit($query_Recordset1) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_Recordset1 = $Recordset1->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">ID</td>
    <td class="KT_th">CLIENTE</td>
    <td class="KT_th">ORDEN</td>
    <td class="KT_th">DESCRIPCION</td>
    <td class="KT_th">CANT. ENT. </td>
    <td class="KT_th">CANT. FACT. </td>
    <td class="KT_th">X FACT. </td>
  </tr>
  <?php
  while (!$Recordset1->EOF) { 
$idcli = $Recordset1->Fields('idcliente');
$idord = $Recordset1->Fields('idorden');
if($idcli == 114){
$query_datorden = "SELECT round(sum(case when und='Mill' then (cantidad * 1000) else cantidad end)) as scant FROM factura f, detallefact d WHERE f.idfact=d.idfactura and f.idcliente not in (SELECT idcliente FROM salidaal WHERE idcliente<>114 GROUP BY idcliente) and d.idorden=$idord and estado<>'anulada'";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());  
}else{
$query_datorden = "SELECT round(sum(case when und='Mill' then (cantidad * 1000) else cantidad end)) as scant FROM factura f, detallefact d WHERE f.idfact=d.idfactura and f.idcliente=$idcli and d.idorden=$idord and estado<>'anulada'";
$datorden = $cnx_cuzzicia->SelectLimit($query_datorden) or die($cnx_cuzzicia->ErrorMsg());  
}
?>
    <tr>
      <td><?php echo $Recordset1->Fields('idcliente'); ?></td>
      <td><?php echo $Recordset1->Fields('cliente'); ?></td>
      <td><?php echo $Recordset1->Fields('idorden'); ?></td>
      <td><?php echo $Recordset1->Fields('max'); ?></td>
      <td align="right"><?php echo $Recordset1->Fields('sum'); ?></td>
      <td align="right"><?php echo $datorden->Fields('scant'); ?></td>
      <td align="right"><?php echo $Recordset1->Fields('sum')-$datorden->Fields('scant'); ?></td>
    </tr>
    <?php
    $Recordset1->MoveNext(); 
  }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$Recordset1->Close();
?>
