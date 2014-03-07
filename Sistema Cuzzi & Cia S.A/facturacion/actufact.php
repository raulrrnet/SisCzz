<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

$iddet = '0';
if (isset($_GET['iddet'])) {
  $iddet = $_GET['iddet'];
}
$idfact = '0';
if (isset($_GET['idfac'])) {
  $idfact = $_GET['idfac'];
}
// begin Recordset
$query_factura = "SELECT * FROM factura f,detallefact df,clientes c WHERE f.idfact=df.idfactura and f.idcliente=c.idcliente and df.iddetfact=$iddet";
$factura = $cnx_cuzzicia->SelectLimit($query_factura) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_factura = $factura->RecordCount();
// end Recordset
// begin Recordset
$query_orden = "SELECT idorden,descripcion,round(precios, 2) as precios,round(preciod,2) as preciod FROM orden ORDER BY idorden DESC";
$orden = $cnx_cuzzicia->SelectLimit($query_orden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_orden = $orden->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

$idfact = $_POST['hiddenField'];
$idorden = $_POST['orden'];
$cant = $_POST['cantidad'];
$descrip = $_POST['descrip'];
$montou = $_POST['montou'];

  $insertSQL = sprintf("UPDATE detallefact SET idfactura='$idfact',idorden=$idorden,cantidad=$cant,descripcion='$descrip',monto=$montou WHERE iddetfact=$iddet");

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "verfact.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Detalle Informe</title>
<script type="text/javascript" src="../includes/wdg/classes/DynamicInput.js"></script>
<script language="JavaScript" type="text/JavaScript">
function validacion(){
s = document.form1.seccion.value;
x = document.form1.destino.value;
y = document.form1.orden.value;
z = document.form1.tiempo.value;
enviar = document.form1.enviar;
if((y=="" && x==1)||(y!="" && s==0)||(y==0 && x==1) || (y!=0 && s==0) || (x==3 && y!="")){
	alert('Verifique Operación')
	return false
	}else if(x==1 && z==""){
	alert('Verifique Tiempo')
	return false
	}else if((y!="" && x==2)||(y!=0 && x==2)){
	alert('Verifique Destino')
	return false
	}else{
	enviar.disabled = true;
	enviar.value = "Procesando ...";
	return true
	}
}
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="return validacion();">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">N&ordm; FACT. </td>
    <td colspan="2"><strong><?php echo $factura->Fields('idfact'); ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idoperario">Cliente:</label></td>
    <td colspan="2"><?php echo $factura->Fields('cliente'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="fecha">Fecha:</label></td>
    <td><?php echo $factura->Fields('fecha'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input name="hiddenField" type="hidden" value="<?php echo $factura->Fields('idfact'); ?>"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th">Orden:</td>
    <td class="KT_th">Cantidad:</td>
    <td class="KT_th">Descripci&oacute;n:</td>
    <td class="KT_th">C. Unitario:</td>
  </tr>
  <tr class="KT_tngtable">
    <td>
      <select name="orden" id="orden">
        <?php
  while(!$orden->EOF){
?>
        <option value="<?php echo $orden->Fields('idorden')?>"<?php if (!(strcmp($orden->Fields('idorden'), $factura->Fields('idorden')))) {echo "SELECTED";} ?>><?php echo $orden->Fields('idorden')?></option>
        <?php
    $orden->MoveNext();
  }
  $orden->MoveFirst();
?>
      </select>    </td>
    <td><input name="cantidad" type="text" id="cantidad" value="<?php echo $factura->Fields('cantidad'); ?>" size="10" />
      mill</td>
    <td><textarea name="descrip" cols="50" id="descrip"><?php echo $factura->Fields('descripcion'); ?></textarea></td>
	<td><input name="montou" type="text" id="montou" value="<?php echo $factura->Fields('monto'); ?>"/></td>
  </tr>
  
  <tr class="KT_tngtable">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="4"><input name="enviar" type="submit" id="enviar" value="Modificar Item" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<a href="verfact.php?idfac=<?php echo $idfact;?>">Ver Factura</a>
</body>
</html>
<?php
$factura->Close();
$orden->Close();
?>