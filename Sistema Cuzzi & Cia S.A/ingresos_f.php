<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_ingresos")) {
	$material = $_POST['idmat'];
    $fecha = $_POST['fecha'];
	$fecingre = $_POST['fecingre'];
    $motivo = $_POST['motivo'];
    $ref = $_POST['referencia'];
    $cant = $_POST['cant'];
    $prov = $_POST['proveedor'];
    $cambio = $_POST['feccambio'];
	$valorsoles = $_POST['valorsoles'];
    $valordolar = $_POST['valordolar'];
	$votross = $_POST['votross'];
	$votrosd = $_POST['votrosd'];
	$tipodoc = $_POST['tipodoc'];
	$serie = $_POST['serie'];
	$tipoope = $_POST['tipooper'];
	$ano = date("Y", strtotime($fecha));
	$query_uingresos = "select * from movimientos where movimiento='Ingreso' and idmaterial=$material and	fecha = (select max(fecha) from movimientos where movimiento='Ingreso' and idmaterial=$material)";
	$uingresos = $cnx_cuzzicia->Execute($query_uingresos) or die($cnx_cuzzicia->ErrorMsg());
	$ufecha = $uingresos->Fields('fecha');
	if ($fecha == "" and $fecingre <> ""){
	$vusoles = $valorsoles/$cant;
	$vudolar = $valordolar/$cant;
	$vuotross = $votross/$cant;//
	$vuotrosd = $votrosd/$cant;//
  $insertSQL = "INSERT INTO movimientos (movimiento, idmaterial, motivo, referencia, cantidad, idproveedor, saldo, vusoles, vudolar, fecha, feccambio, vuotross, vuotrosd,tipodoc,serie,tipoope) VALUES ('Ingreso', '$material', '$motivo', '$ref', '$cant', '$prov', '$cant', $vusoles, $vudolar,'$fecingre','-',$vuotross,$vuotrosd,$tipodoc,$serie,$tipoope);";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	}
    if($fecha <> "" and $fecingre <> ""){
	if ($valordolar == 0){
	$valordolar = $valorsoles/$cambio;
	}else{$valorsoles = $valordolar*$cambio;}
	if ($votrosd == 0){
	$votrosd = $votross/$cambio;
	}else{$votross = $votrosd*$cambio;}
	
	$valorsoles = $valorsoles+$votross;/*vdolar+votros=vtotal*/
	$valordolar = $valordolar+$votrosd;/*vdolar+votros=vtotal*/
	
	$vusoles = $valorsoles/$cant;
	$vudolar = $valordolar/$cant;
	$vuotross = $votross/$cant;//
	$vuotrosd = $votrosd/$cant;//
  $insertSQL = "INSERT INTO movimientos (movimiento, idmaterial, motivo, referencia, cantidad, idproveedor, saldo, vusoles, vudolar, fecha, feccambio, vuotross, vuotrosd,tipodoc,serie,tipoope) VALUES ('Ingreso', '$material', '$motivo', '$ref', '$cant', '$prov', '$cant', $vusoles, $vudolar,'$fecingre', '$fecha', $vuotross, $vuotrosd,$tipodoc,$serie,$tipoope)";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	}
	if($fecha <> "" and $fecingre == ""){
	if ($valordolar == 0){
	$valordolar = $valorsoles/$cambio;
	}else{$valorsoles = $valordolar*$cambio;}
	if ($votrosd == 0){
	$votrosd = $votross/$cambio;
	}else{$votross = $votrosd*$cambio;}
	
	$valorsoles = $valorsoles+$votross;/*vdolar+votros=vtotal*/
	$valordolar = $valordolar+$votrosd;/*vdolar+votros=vtotal*/
	
	$vusoles = $valorsoles/$cant;
	$vudolar = $valordolar/$cant;
	$vuotross = $votross/$cant;//
	$vuotrosd = $votrosd/$cant;//
  $insertSQL = "INSERT INTO movimientos (movimiento, idmaterial, motivo, referencia, cantidad, idproveedor, saldo, vusoles, vudolar, fecha, feccambio, vuotross, vuotrosd,tipodoc,serie,tipoope) VALUES ('Ingreso', '$material', '$motivo', '$ref', '$cant', '$prov', '$cant', $vusoles, $vudolar,'$fecha','$fecha', $vuotross, $vuotrosd,$tipodoc,$serie,$tipoope)";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
	}
if($fecha<$ufecha){
   require('form.php');
}	
  $insertGoTo = "ingresos_f.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}
// begin Recordset
$query_materiales = "SELECT * FROM materiales2";
$materiales = $cnx_cuzzicia->SelectLimit($query_materiales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales = $materiales->RecordCount();
// end Recordset
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

//PHP ADODB document - made with PHAkt 3.7.1
?>
<?php
// HEAD content
?>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function validacion(){
c = document.frm_ingresos.cant.value;
p = document.frm_ingresos.proveedor.value;
ff = document.frm_ingresos.fecha.value;
ref = document.frm_ingresos.referencia.value;
fi = document.frm_ingresos.fecingre.value;
if(p==0){
      alert("Proveedor.");
	  return false
    }else if(ff=='' && fi==''){
      alert("Fecha.");
	  return false
    }else if(ref==''){
      alert("Referencia.");
	  return false
    }else if(c==''){
      alert("Cantidad.");
	  return false
    }else{
	document.frm_ingresos.enviar.disabled = true;
	document.frm_ingresos.enviar.value = "Procesando ...";
	return true}
}
//-->
</script>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/N1DependentField.js"></script>
<?php
//begin JSRecordset
$jsObject_tcambio = new WDG_JsRecordset("tcambio");
echo $jsObject_tcambio->getOutput();
//end JSRecordset
?>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>

<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_ingresos" onSubmit="return validacion();">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">INGRESO DE MATERIALES</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="tipoconsumo" name="tipoconsumo" onChange="tipoconsumo_reload(this)">
        <option selected>tipoconsumo</option>
      </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><label>
        <select id="categoria" name="categoria" onChange="tipoconsumo_reload(this)">
          <option selected>categoria</option>
        </select>
        </label>      </td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select" name="material" onChange="tipoconsumo_reload(this)">
        <option selected>material</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select2" name="marcatipo" onChange="tipoconsumo_reload(this)">
        <option selected>marcatipo</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select4" name="gramcal" onChange="tipoconsumo_reload(this)">
        <option selected>gramcal</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label></td>
      <td><select id="select3" name="medidas" onChange="tipoconsumo_reload(this)">
        <option selected>medidas</option>
      </select></td>
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
      <input name="nprov" type="button" id="nprov" value="++" onClick="self.location='proveedor.php'"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="motivo">Motivo:</label>      </td>
      <td>
        <select name="motivo" id="motivo">
          <option value="6Ajuste">Ajuste 
          <option value="2Compra" selected>Compra 
        </select>
        <input name="Button" type="button" onClick="MM_goToURL('self','tcambio.php');return document.MM_returnValue" value="Fecha/Cambio">      </td>
    </tr>
    <tr>
      <td class="KT_th">Tipo Doc.</td>
      <td><label for="tipodoc"></label>
        <select name="tipodoc" id="tipodoc">
          <option value="01" selected="selected">Factura</option>
          <option value="09">Guia Remisi&oacute;n</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Serie:</td>
      <td><input name="serie" type="text" id="serie" /></td>
    </tr>
    <tr>
      <td class="KT_th">Numero:</td>
      <td><input name="referencia" type="text" id="referencia4" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha Factura:</label>      </td>
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
        <input name="feccambio" type="text" id="feccambio" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="tcambio" wdg:valuefield="tcambio" wdg:pkey="fecha" wdg:triggerobject="fecha">      </td>
    </tr>
    <tr>
      <td class="KT_th">Fecha Ingreso: </td>
      <td><input name="fecingre" id="fecingre" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idorden">Tipo Operacion:</label>      </td>
      <td><select name="tipooper" id="tipooper">
        <option value="01">Venta</option>
        <option value="02" selected="selected">Compra</option>
        <option value="10">Salida a Prod.</option>
        <option value="19">Saldo Inicial</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>      </td>
      <td><input name="cant" type="text" id="cant">
        <select id="select5" name="idmat" onChange="tipoconsumo_reload(this)">
          <option selected>idmat</option>
        </select>
        <script language="JavaScript">
tipoconsumo_contents=new Array();
tipoconsumo_tempArray=new Array();
tipoconsumo_counter=0;
tipoconsumo_isDataOrdered=1;
function tipoconsumo_addContent(str){
	tipoconsumo_contents[tipoconsumo_counter]=str;
	tipoconsumo_counter++;
}
function tipoconsumo_split(){
	tipoconsumo_arrayValues = new Array();
	for(i=0;i<tipoconsumo_contents.length;i++){
		tipoconsumo_arrayValues[i]=tipoconsumo_contents[i].split(separator);
		tipoconsumo_tempArray[0]=tipoconsumo_arrayValues;
	}
}
function tipoconsumo_makeSelValueGroup(){
	tipoconsumo_selValueGroup=new Array();
	var args=tipoconsumo_makeSelValueGroup.arguments;
	for(i=0;i<args.length;i++){
		tipoconsumo_selValueGroup[i]=args[i];
		tipoconsumo_tempArray[i]=new Array();
	}
}
function tipoconsumo_makeComboGroup(){
	tipoconsumo_comboGroup=new Array();
	var args=tipoconsumo_makeComboGroup.arguments;
	for(i=0;i<args.length;i++) tipoconsumo_comboGroup[i]=findObj(args[i]);
}
function tipoconsumo_setDefault(){
	for (i=tipoconsumo_selValueGroup.length-1;i>=0;i--){
		if(tipoconsumo_selValueGroup[i]!=""){
			for(j=0;j<tipoconsumo_contents.length;j++){
				if(tipoconsumo_arrayValues[j][(i*2)+1]==tipoconsumo_selValueGroup[i]){
					for(k=i;k>=0;k--){
						if(tipoconsumo_selValueGroup[k]=="") tipoconsumo_selValueGroup[k]=tipoconsumo_arrayValues[j][(k*2)+1];
					}
				}
			}
		}
	}
}
function tipoconsumo_loadMenu(daIndex){
var selectionMade=false;
daArray=tipoconsumo_tempArray[daIndex];
tipoconsumo_comboGroup[daIndex].options.length=0;
var tipoconsumo_cur_daArrayValue="";
if(tipoconsumo_isDataOrdered==1){
	for(i=0;i<daArray.length;i++){
		if(tipoconsumo_cur_daArrayValue!=daArray[i][(daIndex*2)+1]){
			tipoconsumo_comboGroup[daIndex].options[tipoconsumo_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			tipoconsumo_cur_daArrayValue=daArray[i][(daIndex*2)+1];
		}
	}
}else{
	for(i=0;i<daArray.length;i++){
		existe=false;
		for(j=0;j<tipoconsumo_comboGroup[daIndex].options.length;j++){
			if(daArray[i][(daIndex*2)+1]==tipoconsumo_comboGroup[daIndex].options[j].value) existe=true;
		}
		if(existe==false){
			lastValue=tipoconsumo_comboGroup[daIndex].options.length;
			tipoconsumo_comboGroup[daIndex].options[tipoconsumo_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			if(tipoconsumo_selValueGroup[daIndex]==tipoconsumo_comboGroup[daIndex].options[lastValue].value){
				tipoconsumo_comboGroup[daIndex].options[lastValue].selected=true;
				selectionMade=true;
			}
		}
	}
}
if(selectionMade==false) tipoconsumo_comboGroup[daIndex].options[0].selected=true;
}
function tipoconsumo_reload(from){
	if(!from){
		tipoconsumo_split();
		tipoconsumo_setDefault();
		tipoconsumo_loadMenu(0);
		tipoconsumo_reload(tipoconsumo_comboGroup[0]);
	}else{
		for(j=0; j<tipoconsumo_comboGroup.length; j++){
			if(tipoconsumo_comboGroup[j]==from) index=j+1;
		}
		if(index<tipoconsumo_comboGroup.length){
			tipoconsumo_tempArray[index].length=0;
			for(i=0;i<tipoconsumo_comboGroup[index-1].options.length;i++){
				if(tipoconsumo_comboGroup[index-1].options[i].selected==true){
					for(j=0;j<tipoconsumo_tempArray[index-1].length;j++){
						if(tipoconsumo_comboGroup[index-1].options[i].value==tipoconsumo_tempArray[index-1][j][(index*2)-1]) tipoconsumo_tempArray[index][tipoconsumo_tempArray[index].length]=tipoconsumo_tempArray[index-1][j];
					}
				}
			}
		tipoconsumo_loadMenu(index);
		tipoconsumo_reload(tipoconsumo_comboGroup[index]);
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
tipoconsumo_makeSelValueGroup("","","","","","","");
tipoconsumo_makeComboGroup("tipoconsumo","categoria","material","marcatipo","gramcal","medidas","idmat");
 var separator="+#+";
<?php while(!$materiales->EOF){?>
tipoconsumo_addContent("<?php echo $materiales->Fields('tipoconsumo'); ?>+#+<?php echo $materiales->Fields('idtipoconsumo'); ?>+#+<?php echo $materiales->Fields('categoria'); ?>+#+<?php echo $materiales->Fields('idcategoria'); ?>+#+<?php echo $materiales->Fields('materiales'); ?>+#+<?php echo $materiales->Fields('idmaterial'); ?>+#+<?php echo $materiales->Fields('marcatipo'); ?>+#+<?php echo $materiales->Fields('idmarcatipo'); ?>+#+<?php echo $materiales->Fields('gramajecalibre'); ?>+#+<?php echo $materiales->Fields('idgramcal'); ?>+#+<?php echo $materiales->Fields('medida'); ?>+#+<?php echo $materiales->Fields('idmedidas'); ?>+#+<?php echo $materiales->Fields('unidad'); ?>+#+<?php echo $materiales->Fields('idmateriales'); ?>");
<?php $materiales->MoveNext();
 }
$materiales->MoveFirst();
 ?>tipoconsumo_reload();

        </script>      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="valorusoles">Valorsoles:</label></td>
      <td>
        <input name="valorsoles" type="text" id="valorsoles" value="0">      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="valorudolar">Valordolar:</label></td>
      <td><input name="valordolar" type="text" id="valordolar" value="0"></td>
    </tr>
    <tr>
      <td class="KT_th">VOtrosSoles: </td>
      <td><input name="votross" type="text" id="votross" value="0"></td>
    </tr>
    <tr>
      <td class="KT_th">VOtrosDolar: </td>
      <td><input name="votrosd" type="text" id="votrosd" value="0"></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input name="enviar" type="submit" id="enviar" value="Guardar"/></td>
    </tr>
  </table>
  
    <input type="hidden" name="MM_insert" value="frm_ingresos">
</form>
<?php
$materiales->Close();
$tcambio->Close();
$proveedor->Close();
?>