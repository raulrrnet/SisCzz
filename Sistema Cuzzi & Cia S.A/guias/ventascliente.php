<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$idcli = '1=1';
if (isset($_POST['cliente'])) {
  $idcli = 'idcliente='.$_POST['cliente'];
}
$fec = date("Y/m/d");
// begin Recordset
$query_cnkardex = "SELECT date_part('year', fecha) as año,idorden,min(descripcion), sum(case when(date_part('month', fecha)=1) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as enero, sum(case when(date_part('month', fecha)=2) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as febrero, sum(case when(date_part('month', fecha)=3) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as marzo, sum(case when(date_part('month', fecha)=4) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as abril, sum(case when(date_part('month', fecha)=5) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as mayo, sum(case when(date_part('month', fecha)=6) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as junio, sum(case when(date_part('month', fecha)=7) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as julio, sum(case when(date_part('month', fecha)=8) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as agosto, sum(case when(date_part('month', fecha)=9) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as setiembre, sum(case when(date_part('month', fecha)=10) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as octubre, sum(case when(date_part('month', fecha)=11) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as noviembre, sum(case when(date_part('month', fecha)=12) then(case when und='Mill' then cantidad*1000 else cantidad end) end) as diciembre, sum(case when und='Mill' then cantidad*1000 else cantidad end) as th FROM factura f,detallefact df WHERE f.idfact=df.idfactura and $idcli and fecha <= '$fec' and estado<>'anulada' and idorden in (select idorden from detsalidaal group by idorden) GROUP BY idorden,date_part('year', fecha) ORDER BY idorden,date_part('year', fecha)";
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset

// begin Recordset
$query_clientes = "SELECT * FROM clientes c,gclientes g WHERE c.idgcliente = g.idgclien AND (idgcliente=3 OR c.cliente=g.nombre) ORDER BY cliente";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

$s_cliente = "SELECT * FROM clientes WHERE $idcli";
$excscli = $cnx_cuzzicia->SelectLimit($s_cliente) or die($cnx_cuzzicia->ErrorMsg());

//PHP ADODB document - made with PHAkt 3.7.1

$lastTFM_nest = "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ventas Cliente</title>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script language="javascript">
function envio_form(){
document.form1.target = "_self";
document.form1.action= "ventascliente.php"
document.form1.submit();
}
</script>
<style type="text/css">
<!--
.cdiv {
	height: auto;
	width: 300px;
	overflow:no;
	white-space:normal
}
-->
</style>
</head>
<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="16" align="center" class="selected_cal"><form name="form1" method="post" >
      <select name="cliente" id="cliente">
        <option value="0">>> Seleccione </option>
        <?php
  while(!$clientes->EOF){
?>
        <option value="<?php echo $clientes->Fields('idcliente')?>"><?php echo $clientes->Fields('cliente')?></option>
        <?php
    $clientes->MoveNext();
  }
  $clientes->MoveFirst();
?>
      </select>
      <input name="Submit"type="button" value="Mostrar" onClick="envio_form()">
      <a href="#"><img src="../images/imp.gif" name="Imprimir" width="24" height="22" border="0" align="absbottom" alt="Imprimir" onClick="window.print();"></a>
    </form></td>
  </tr>
  <tr>
    <td colspan="16" align="center"><strong>VENTAS: <?php if (isset($_POST['cliente'])){echo $fec." / ".$excscli->Fields('cliente');}else{echo $fec;}?></strong></td>
  </tr>
  <tr>
    <td align="center" class="selected_cal">A&Ntilde;O</td>
    <td align="center" class="selected_cal">ORDEN</td>
    <td align="center" class="selected_cal">DESCRIPCION</td>
    <td align="center" class="selected_cal">ENERO</td>
    <td align="center" class="selected_cal">FEBRERO</td>
    <td align="center" class="selected_cal">MARZO</td>
    <td align="center" class="selected_cal">ABRIL</td>
    <td align="center" class="selected_cal">MAYO</td>
    <td align="center" class="selected_cal">JUNIO</td>
    <td align="center" class="selected_cal">JULIO</td>
    <td align="center" class="selected_cal">AGOSTO</td>
    <td align="center" class="selected_cal">SETIEMBRE</td>
    <td align="center" class="selected_cal">OCTUBRE</td>
    <td align="center" class="selected_cal">NOVIEMBRE</td>
    <td align="center" class="selected_cal">DICIEMBRE</td>
    <td align="center" class="selected_cal">TOTAL</td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
<?php $TFM_nest = $cnkardex->Fields('idorden');
	if ($lastTFM_nest != $TFM_nest) { 
	$lastTFM_nest = $TFM_nest;
?>
  <tr>
    <td colspan="20"><hr></td>
  </tr>
<?php } //End of Basic-UltraDev Simulated Nested Repeat?>
    <tr>
      <td><?php echo $cnkardex->Fields('año');?></td>
      <td><?php echo $cnkardex->Fields('idorden');?></td>
      <td><div class="cdiv"><?php echo $cnkardex->Fields('min');?></div></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('enero'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('febrero'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('marzo'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('abril'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('mayo'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('junio'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('julio'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('agosto'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('setiembre'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('octubre'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('noviembre'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('diciembre'),2);?></td>
      <td align="right"><?php echo number_format($cnkardex->Fields('th'),2);?></td>
    </tr>
    <?php
    $cnkardex->MoveNext(); 
  }
?>
<tr>
    <td colspan="16"><hr></td>
  </tr>
</table>
</body>
</html>
<?php
$cnkardex->Close();

$clientes->Close();
?>