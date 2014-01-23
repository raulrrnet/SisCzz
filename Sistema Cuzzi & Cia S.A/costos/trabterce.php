<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_ingresos")) {
	$descrip = $_POST['descrip'];
    $fecha = $_POST['fecha'];
    $ref = $_POST['referencia'];
    $cant = $_POST['cant'];
    $prov = $_POST['proveedor'];
    $orden = $_POST['orden'];
    $cambio = $_POST['feccambio'];
	$valorsoles = $_POST['valorsoles'];
    $valordolar = $_POST['valordolar'];
	
	if ($valordolar == 0){
	$valordolar = $valorsoles/$cambio;
	}else{$valorsoles = $valordolar*$cambio;}
	$vusoles = $valorsoles/$cant;
	$vudolar = $valordolar/$cant;

  $insertSQL = "INSERT INTO trabterceros (iddescrip, idproveedor, fecha, referencia, idorden, cantidad, valorus, valorud) VALUES ($descrip, $prov, '$fecha', '$ref', $orden, $cant, $vusoles, $vudolar)";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
		
  $insertGoTo = "trabterce.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}
// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha ASC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset
// begin Recordset
$query_proveedor = "SELECT * FROM proveedor ORDER BY proveedor ASC";
$proveedor = $cnx_cuzzicia->SelectLimit($query_proveedor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_proveedor = $proveedor->RecordCount();
// end Recordset
// begin Recordset
$query_descripcion = "SELECT * FROM descripcion ORDER BY descripcion ASC";
$descripcion = $cnx_cuzzicia->SelectLimit($query_descripcion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_descripcion = $descripcion->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Trabajo Terceros</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/N1DependentField.js"></script>

<script language="JavaScript" type="text/JavaScript">
function validacion(){
c = document.frm_ingresos.cant.value;
p = document.frm_ingresos.proveedor.value;
o = document.frm_ingresos.orden.value;
vs = document.frm_ingresos.valorsoles.value;
vd = document.frm_ingresos.valordolar.value;
if(p==0){
      alert("Proveedor.");
	  return false
    }else if(o==''){
      alert("Orden.");
	  return false
    }else if(c==''){
      alert("Cantidad.");
	  return false
    }else if(vs==0 && vd==0){
      alert("Valor Soles o Dolares.");
	  return false
    }else{
	document.frm_ingresos.enviar.disabled = true;
	document.frm_ingresos.enviar.value = "Procesando ...";
	return true}
}
</script>
<?php
//begin JSRecordset
$jsObject_tcambio = new WDG_JsRecordset("tcambio");
echo $jsObject_tcambio->getOutput();
//end JSRecordset
?>
</head>
<body>
<form name="frm_ingresos" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="return validacion(this);">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">INGRESO TRABAJO TERCEROS </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td class="KT_th">Descripci&oacute;n:</td>
      <td><select id="select2" name="descrip" onChange="tipoconsumo_reload(this)">
        <?php
  while(!$descripcion->EOF){
?>
        <option value="<?php echo $descripcion->Fields('iddescrip')?>"><?php echo $descripcion->Fields('descripcion')?></option>
        <?php
    $descripcion->MoveNext();
  }
  $descripcion->MoveFirst();
?>
      </select>
        <label>
        <input name="ndescrip" type="button" id="ndescrip" value="++" onClick="self.location='descripcion.php'">
      </label></td>
    </tr>
    
    <tr>
      <td class="KT_th">Proveedor:</td>
      <td><select name="proveedor" id="proveedor">
      <?php
  while(!$proveedor->EOF){
?>
      <option value="<?php echo $proveedor->Fields('idproveedor')?>"><?php echo $proveedor->Fields('proveedor')?></option>
      <?php
    $proveedor->MoveNext();
  }
  $proveedor->MoveFirst();
?>
      </select>
   <input name="nprov" type="button" id="nprov" value="++" onClick="self.location='../proveedor.php'"></td>
    </tr>
    
    <tr>
      <td class="KT_th"><label for="fecha"> Fecha T/C:</label>      </td>
      <td>
        <select name="fecha" id="fecha">
          <option value="">Pendiente</option>
          <?php
  while(!$tcambio->EOF){
?>
          <option value="<?php echo $tcambio->Fields('fecha')?>" selected><?php echo $tcambio->Fields('fecha')?></option>
          <?php
    $tcambio->MoveNext();
  }
  $tcambio->MoveFirst();
?>
        </select>
        <input name="feccambio" type="text" id="feccambio" size="10" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="tcambio" wdg:valuefield="tcambio" wdg:pkey="fecha" wdg:triggerobject="fecha">
        <input name="tcambio" type="button" id="tcambio" onClick="self.location='../tcambio.php'" value="++"></td>
    </tr>
    
    <tr>
      <td class="KT_th">Referencia:</td>
      <td><input name="referencia" type="text" id="referencia"></td>
    </tr>
    <tr>
      <td class="KT_th">Orden:</td>
      <td><input name="orden" type="text" id="orden"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>      </td>
      <td><input name="cant" type="text" id="cant"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="valorusoles">ValorSoles:</label></td>
      <td>
        <input name="valorsoles" type="text" id="valorsoles" value="0">      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="valorudolar">ValorDolar:</label></td>
      <td><input name="valordolar" type="text" id="valordolar" value="0"></td>
    </tr>
    

    <tr>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="enviar" value="Guardar"/>      </td>
    </tr>
  </table>
  
    <input type="hidden" name="MM_insert" value="frm_ingresos">
</form>
</body>
</html>
<?php
$tcambio->Close();
$proveedor->Close();
$descripcion->Close();
?>