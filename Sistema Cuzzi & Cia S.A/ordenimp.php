<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

$maxidord =	"select max(idorden) from orden";
$maxord = $cnx_cuzzicia->SelectLimit($maxidord) or die($cnx_cuzzicia->ErrorMsg());
$idorden = $maxord->Fields('max');
if (isset($_GET['idord'])) {
  $idorden = $_GET['idord'];
}
// begin Recordset
$query_ordimp = "SELECT * FROM orden o,clientes c,prodorden p,tproducto tp,gproducto gp WHERE idorden=$idorden and o.idcliente = c.idcliente AND  o.idprodorden = p.idprodorden AND gp.idgproduc = p.idgprod AND tp.idtproduc = p.idtprod";
$ordimp = $cnx_cuzzicia->SelectLimit($query_ordimp) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_ordimp = $ordimp->RecordCount();
// end Recordset
$idorden = $ordimp->Fields('idorden');
// begin Recordset
$query_matorden = "SELECT * FROM detalleorden x, mdmaterial m, mddetalle d, matorden o WHERE idorden=$idorden and x.idmatord=o.idmatorden and o.idmdmat=m.idmdmat and o.idmddet=d.idmddet ORDER BY iddetalle";
$matorden = $cnx_cuzzicia->SelectLimit($query_matorden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_matorden = $matorden->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orden de Produccion</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/N1DependentField.js"></script>
<style type="text/css">
<!--
.cdiv {
	height: auto;
	width: 680px;
	overflow:auto;
	white-space:normal
}
.cdiv2 {
	height: auto;
	width: 150px;
	overflow:auto;
	white-space:normal
}
.Estilo7 {font-size: xx-large}
.Estilo10 {font-size: x-large}
-->
</style>
</head>

<body>
  <form name="frm_orden" method="POST" id="form1">
    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td><img src="images/modelo_r1_c1.jpg" width="162" height="54"></td>
	    <td colspan="3" align="center" valign="middle"><h1>ORDEN DE PRODUCCION Nº <?php echo $ordimp->Fields('idorden'); ?></h1></td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td width="127" class="selected_cal">Cliente:</td>
        <td colspan="3"><label><?php echo $ordimp->Fields('cliente'); ?></label></td>
      </tr>
      <tr>
        <td class="selected_cal">T. Producto:</td>
        <td colspan="3" valign="middle"><?php echo $ordimp->Fields('grupop'); ?></td>
      </tr>
      <tr>
        <td class="selected_cal">Forma:</td>
        <td colspan="3"><?php echo $ordimp->Fields('tipop'); ?></td>
      </tr>
      <tr>
        <td class="selected_cal">Descripci&oacute;n:</td>
        <td colspan="3"><?php echo $ordimp->Fields('descripcion'); ?></td>
      </tr>
      <tr>
        <td class="selected_cal"><label for="fecha">Fecha Orden:</label>      </td>
        <td colspan="3"><label for="label"><?php echo $ordimp->Fields('fecha'); ?></label></td>
      </tr>
      <tr>
        <td class="selected_cal">Fecha Comprometida:</td>
        <td colspan="3"><?php echo $ordimp->Fields('fechacomp'); ?></td>
      </tr>
      <tr>
        <td class="selected_cal">N&deg;Pedido:</td>
        <td colspan="3"><?php echo $ordimp->Fields('pedido'); ?></td>
      </tr>
      <tr>
        <td class="selected_cal">Cantidad:</td>
        <td colspan="3"><?php echo number_format($ordimp->Fields('cantpedi')); ?></td>
      </tr>
      <tr>
        <td colspan="4" class="selected_cal">Detalles:</td>
      </tr>
      <tr>
        <td colspan="4"><div class="cdiv"><?php echo nl2br($ordimp->Fields('detalle')); ?></div></td>
      </tr>
      <tr>
        <td colspan="4" class="selected_cal">Observaciones:</td>
      </tr>
      <tr>
        <td colspan="4">
          <div class="cdiv"><?php echo nl2br($ordimp->Fields('observacion')); ?></div></td>
      </tr>
      
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="selected_cal">
		<a href="mdorden.php?id=<?php echo $ordimp->Fields('idorden');?>" onClick="window.open(this.href, this.target, 'width=420,height=180');return false;window.close();exit">MATERIALES DIRECTOS</a></td>
      </tr>
      <tr>
        <td colspan="4"><table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="selected_cal">USO</td>
            <td class="selected_cal">MATERIAL</td>
            <td class="selected_cal">CANTIDAD</td>
            <td class="selected_cal">FORMAS P. I.</td>
            <td class="selected_cal">DEMASIA</td>
            <td class="selected_cal">PLIEGOS I.</td>
            <td class="selected_cal">MEDIDA P. I. </td>
            <td class="selected_cal">P.IMP/M.P.</td>
            <td class="selected_cal">PLIEGOS M.P.</td>
            <td class="selected_cal">MEDIDA M. P.</td>
            <td class="selected_cal">&nbsp;</td>
          </tr>
          <?php
  while (!$matorden->EOF) { 
?>
            <tr>
              <td><?php echo $matorden->Fields('uso'); ?></td>
              <td><div class="cdiv2"><?php echo $matorden->Fields('material'); ?> / <?php echo $matorden->Fields('detalle'); ?></div></td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right"><a href="costos/elimina.php?tabla=detalleorden&idtabla=iddetalle&goto=../ordenimp.php?idord=<?php echo $idorden;?>&id=<?php echo $matorden->Fields('iddetalle'); ?>">x</a></td>
            </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right">&nbsp;</td>
		    </tr>
            <?php
    $matorden->MoveNext(); 
  }
?>			<tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      

      <tr class="KT_buttons">
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="selected_cal">PROCESO DE PRODUCCION </td>
      </tr>
      <tr>
        <td class="selected_cal">&nbsp;</td>
        <td width="122" align="center" class="selected_cal">Fecha</td>
	    <td width="67" align="center" class="selected_cal">Producción</td>
        <td width="113" align="center" class="selected_cal">Firma</td>
      </tr>
      <tr>
        <td class="selected_cal">Dise&ntilde;o</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Planchas</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Roland</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Flexo</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Troquel</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Corte</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Convertidora</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Laqueadora</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Acabados</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">&nbsp;</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="selected_cal">Entrega</td>
        <td>&nbsp;</td>
	    <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr class="KT_buttons">
        <td colspan="4"><a href="#"><img src="images/imp.gif" alt="Imprimir" name="Imprimir" width="24" height="22" border="0" align="absbottom" id="Imprimir" onClick="window.print();"></a></td>
      </tr>
    </table>
  </form>
</body>
</html>
<?php
$ordimp->Close();

$matorden->Close();
?>