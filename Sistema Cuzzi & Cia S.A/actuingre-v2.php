<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');
// begin Recordset
$query_materiales = "SELECT * FROM materiales2";
$materiales = $cnx_cuzzicia->SelectLimit($query_materiales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales = $materiales->RecordCount();
// end Recordset
// begin Recordset
$query_proveedor = "SELECT * FROM proveedor ORDER BY proveedor ASC";
$proveedor = $cnx_cuzzicia->SelectLimit($query_proveedor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_proveedor = $proveedor->RecordCount();
// end Recordset
// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha ASC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset
// begin Recordset
$colmat__actuliza = '-1';
if (isset($_GET['idmaterial'])) {
  $colmat__actuliza = $_GET['idmaterial'];
}
$colname__actuliza = '-1';
if (isset($_GET['idmovimiento'])) {
  $colname__actuliza = $_GET['idmovimiento'];
}
$query_actuliza = sprintf("SELECT * FROM movimientos WHERE idmovimiento = %s and idmaterial = %s", $colname__actuliza,$colmat__actuliza);
$actuliza = $cnx_cuzzicia->SelectLimit($query_actuliza) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuliza = $actuliza->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
//-------------------------------------------------------------------------------------------------
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_salidas")) {
	$material = $_POST['unidad'];
    $prov = $_POST['proveedor'];
    $motivo = $_POST['motivo'];
    $fecha = $_POST['fecha'];
    $ref = $_POST['referen'];
    $cantsali = $_POST['cantidad'];
	$cambio = $_POST['feccambio'];
    $ordens = $_POST['ordenes'];
    $valorsoles = $_POST['valorsoles'];
    $valordolar = $_POST['valordolar'];
	$votross = $_POST['votross'];
	$votrosd = $_POST['votrosd'];
    $id = $_POST['hiddenField'];
	$ano = date("Y", strtotime($fecha));

if($fecha <> ""){
	if ($valordolar == 0){
	$valordolar = $valorsoles/$cambio;
	}else{$valorsoles = $valordolar*$cambio;}
	if ($votrosd == 0){
	$votrosd = $votross/$cambio;
	}else{$votross = $votrosd*$cambio;}

	$valorsoles = $valorsoles+$votross;/*vdolar+votros=vtotal*/
	$valordolar = $valordolar+$votrosd;/*vdolar+votros=vtotal*/

$vusoles = $valorsoles/$cantsali;
$vudolar = $valordolar/$cantsali;
$vuotross = $votross/$cantsali;//
$vuotrosd = $votrosd/$cantsali;//

	//actulaizar ingreso
	$upingreg = "UPDATE movimientos SET idmaterial=$material, idproveedor=$prov, motivo='$motivo', referencia='$ref', cantidad='$cantsali', ordenes='$ordens', vusoles=$vusoles, vudolar=$vudolar,feccambio='$fecha', vuotross=$vuotross, vuotrosd=$vuotrosd WHERE idmovimiento=$id";
	$upingrexc = $cnx_cuzzicia->Execute($upingreg) or die($cnx_cuzzicia->ErrorMsg());
	require('form.php');
}else{
	if ($votross <> 0){
	$vuotross = $votross/$cantsali;//
	$vuotrosd = 0;
	}else{
	$vuotrosd = $votrosd/$cantsali;//
	$vuotross = 0;
	}
	$upingreg = "UPDATE movimientos SET idmaterial=$material, idproveedor=$prov, motivo='$motivo', referencia='$ref', cantidad='$cantsali', ordenes='$ordens', vusoles=0, vudolar=0, vuotross=$vuotross, vuotrosd=$vuotrosd WHERE idmovimiento=$id";
	$upingrexc = $cnx_cuzzicia->Execute($upingreg) or die($cnx_cuzzicia->ErrorMsg());
}
	if($material<>$colmat__actuliza){
		$material = $colmat__actuliza;
		require('form.php');
	}
$updateGoTo = "resulingre-v.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
KT_redir($updateGoTo);
}
//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function calculos(){
document.frm_ingresos.vusoles.value = (parseFloat(document.frm_ingresos.valorsoles.value) / parseFloat(document.frm_ingresos.cantidad.value));
document.frm_ingresos.vudolar.value = (parseFloat(document.frm_ingresos.valordolar.value) / parseFloat(document.frm_ingresos.cantidad.value));
}
//-->
</script>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/N1DependentField.js"></script>
<?php
//begin JSRecordset
$jsObject_tcambio = new WDG_JsRecordset("tcambio");
echo $jsObject_tcambio->getOutput();
//end JSRecordset
?>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_ingresos" id="frm_ingresos">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">ACTUALIZA INGRESO</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;<input name="hiddenField" type="hidden" value="<?php echo $actuliza->Fields('idmovimiento'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="tipo" name="tipo" onChange="tipo_reload(this)">
        <option selected>tipo</option>
      </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><label>
        <select id="catego" name="catego" onChange="tipo_reload(this)">
          <option selected>catego</option>
        </select>
</label>      </td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select27" name="material" onChange="tipo_reload(this)">
        <option selected>material</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select28" name="marcatipo" onChange="tipo_reload(this)">
        <option selected>marcatipo</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select29" name="gramcal" onChange="tipo_reload(this)">
        <option selected>gramcal</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label>      </td>
      <td><select id="select30" name="medidas" onChange="tipo_reload(this)">
        <option selected>medidas</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Proveedor:</td>
      <td><select name="proveedor" id="proveedor">
        <?php
  while(!$proveedor->EOF){
?>
        <option value="<?php echo $proveedor->Fields('idproveedor')?>"<?php if (!(strcmp($proveedor->Fields('idproveedor'), $actuliza->Fields('idproveedor')))) {echo "SELECTED";} ?>><?php echo $proveedor->Fields('proveedor')?></option>
        <?php
    $proveedor->MoveNext();
  }
  $proveedor->MoveFirst();
?>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Motivo:</td>
	<td>
      <select name="motivo" id="motivo">
        <option value="6Ajuste" <?php if (!(strcmp("6Ajuste", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Ajuste</option>
        <option value="2Compra" <?php if (!(strcmp("2Compra", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Compra</option>
        <option value="1Saldo Inicial" <?php if (!(strcmp("1Saldo Inicial", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Saldo Inicial</option>
        <option value="3Conversion" <?php if (!(strcmp("3Conversion", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Conversion</option>
        <option value="2Devolucion" <?php if (!(strcmp("2Devolucion", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Devolucion</option>
      </select>      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha:</label>      </td>
      <td><select name="fecha" id="fecha">
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
      <input name="feccambio" type="text" id="feccambio" size="4" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="tcambio" wdg:valuefield="tcambio" wdg:pkey="fecha" wdg:triggerobject="fecha">
      <span class="Estilo1">Cambiar Fecha</span> </td>
    </tr>
    
    <tr>
      <td class="KT_th">Referencia:</td>
      <td><input name="referen" type="text" id="referen" value="<?php echo $actuliza->Fields('referencia'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idproveedor">Ordenes:</label>      </td>
      <td><input name="ordenes" type="text" id="ordenes" value="<?php echo $actuliza->Fields('ordenes'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>      </td>
      <td>
        <input name="cantidad" type="text" id="cantidad" value="<?php echo $actuliza->Fields('cantidad'); ?>">
        <select id="select31" name="unidad" onChange="tipo_reload(this)">
          <option selected>unidad</option>
        </select>
        <script language="JavaScript">
tipo_contents=new Array();
tipo_tempArray=new Array();
tipo_counter=0;
tipo_isDataOrdered=0;
function tipo_addContent(str){
	tipo_contents[tipo_counter]=str;
	tipo_counter++;
}
function tipo_split(){
	tipo_arrayValues = new Array();
	for(i=0;i<tipo_contents.length;i++){
		tipo_arrayValues[i]=tipo_contents[i].split(separator);
		tipo_tempArray[0]=tipo_arrayValues;
	}
}
function tipo_makeSelValueGroup(){
	tipo_selValueGroup=new Array();
	var args=tipo_makeSelValueGroup.arguments;
	for(i=0;i<args.length;i++){
		tipo_selValueGroup[i]=args[i];
		tipo_tempArray[i]=new Array();
	}
}
function tipo_makeComboGroup(){
	tipo_comboGroup=new Array();
	var args=tipo_makeComboGroup.arguments;
	for(i=0;i<args.length;i++) tipo_comboGroup[i]=findObj(args[i]);
}
function tipo_setDefault(){
	for (i=tipo_selValueGroup.length-1;i>=0;i--){
		if(tipo_selValueGroup[i]!=""){
			for(j=0;j<tipo_contents.length;j++){
				if(tipo_arrayValues[j][(i*2)+1]==tipo_selValueGroup[i]){
					for(k=i;k>=0;k--){
						if(tipo_selValueGroup[k]=="") tipo_selValueGroup[k]=tipo_arrayValues[j][(k*2)+1];
					}
				}
			}
		}
	}
}
function tipo_loadMenu(daIndex){
var selectionMade=false;
daArray=tipo_tempArray[daIndex];
tipo_comboGroup[daIndex].options.length=0;
var tipo_cur_daArrayValue="";
if(tipo_isDataOrdered==1){
	for(i=0;i<daArray.length;i++){
		if(tipo_cur_daArrayValue!=daArray[i][(daIndex*2)+1]){
			tipo_comboGroup[daIndex].options[tipo_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			tipo_cur_daArrayValue=daArray[i][(daIndex*2)+1];
		}
	}
}else{
	for(i=0;i<daArray.length;i++){
		existe=false;
		for(j=0;j<tipo_comboGroup[daIndex].options.length;j++){
			if(daArray[i][(daIndex*2)+1]==tipo_comboGroup[daIndex].options[j].value) existe=true;
		}
		if(existe==false){
			lastValue=tipo_comboGroup[daIndex].options.length;
			tipo_comboGroup[daIndex].options[tipo_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			if(tipo_selValueGroup[daIndex]==tipo_comboGroup[daIndex].options[lastValue].value){
				tipo_comboGroup[daIndex].options[lastValue].selected=true;
				selectionMade=true;
			}
		}
	}
}
if(selectionMade==false) tipo_comboGroup[daIndex].options[0].selected=true;
}
function tipo_reload(from){
	if(!from){
		tipo_split();
		tipo_setDefault();
		tipo_loadMenu(0);
		tipo_reload(tipo_comboGroup[0]);
	}else{
		for(j=0; j<tipo_comboGroup.length; j++){
			if(tipo_comboGroup[j]==from) index=j+1;
		}
		if(index<tipo_comboGroup.length){
			tipo_tempArray[index].length=0;
			for(i=0;i<tipo_comboGroup[index-1].options.length;i++){
				if(tipo_comboGroup[index-1].options[i].selected==true){
					for(j=0;j<tipo_tempArray[index-1].length;j++){
						if(tipo_comboGroup[index-1].options[i].value==tipo_tempArray[index-1][j][(index*2)-1]) tipo_tempArray[index][tipo_tempArray[index].length]=tipo_tempArray[index-1][j];
					}
				}
			}
		tipo_loadMenu(index);
		tipo_reload(tipo_comboGroup[index]);
		}
	}
}
function findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
tipo_makeSelValueGroup("","","","","","","<?php echo $_GET['idmaterial']; ?>");
tipo_makeComboGroup("tipo","catego","material","marcatipo","gramcal","medidas","unidad");
 var separator="+#+";
<?php while(!$materiales->EOF){?>
tipo_addContent("<?php echo $materiales->Fields('tipoconsumo'); ?>+#+<?php echo $materiales->Fields('idtipoconsumo'); ?>+#+<?php echo $materiales->Fields('categoria'); ?>+#+<?php echo $materiales->Fields('idcategoria'); ?>+#+<?php echo $materiales->Fields('materiales'); ?>+#+<?php echo $materiales->Fields('idmaterial'); ?>+#+<?php echo $materiales->Fields('marcatipo'); ?>+#+<?php echo $materiales->Fields('idmarcatipo'); ?>+#+<?php echo $materiales->Fields('gramajecalibre'); ?>+#+<?php echo $materiales->Fields('idgramcal'); ?>+#+<?php echo $materiales->Fields('medida'); ?>+#+<?php echo $materiales->Fields('idmedidas'); ?>+#+<?php echo $materiales->Fields('unidad'); ?>+#+<?php echo $materiales->Fields('idmateriales'); ?>");
<?php $materiales->MoveNext();
 }
$materiales->MoveFirst();
 ?>tipo_reload();

        </script>      </td>
    </tr>
    <tr>
      <td class="KT_th">ValorSoles:        </td>
      <td><input name="valorsoles" type="text" id="valorsoles" value="<?php echo $actuliza->Fields('vusoles')*$actuliza->Fields('cantidad'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th">ValorDolar: </td>
      <td><input name="valordolar" type="text" id="valordolar" value="<?php echo $actuliza->Fields('vudolar')*$actuliza->Fields('cantidad'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th">VOtrosSoles:      </td>
      <td><input name="votross" type="text" id="votross" value="<?php echo $actuliza->Fields('vuotross')*$actuliza->Fields('cantidad'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th">VOtrosDolar:      </td>
      <td><input name="votrosd" type="text" id="votrosd" value="<?php echo $actuliza->Fields('vuotrosd')*$actuliza->Fields('cantidad'); ?>"></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Actualizar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frm_salidas">
</form>
</body>
</html>
<?php
$materiales->Close();
$proveedor->Close();
$actuliza->Close();
$tcambio->Close();
?>