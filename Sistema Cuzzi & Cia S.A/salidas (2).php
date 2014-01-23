<?php
//Aditional Functions
require_once('includes/functions.inc.php');

//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('includes/wdg/WDG.php');

// begin Recordset
$query_materiales = "SELECT * FROM materiales2";
$materiales = $cnx_cuzzicia->SelectLimit($query_materiales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales = $materiales->RecordCount();
// end Recordset

// begin Recordset
$query_orden = "SELECT * FROM orden ORDER BY idorden ASC";
$orden = $cnx_cuzzicia->SelectLimit($query_orden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_orden = $orden->RecordCount();
// end Recordset

// begin Recordset
$query_seccion = "SELECT * FROM seccion WHERE status<>'x' ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.6.0
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_salidas")) {
	$material = $_POST['idmat'];
	$motivo = $_POST['motivo'];
	$orden = $_POST['orden'];
	$seccion = $_POST['seccion'];
	$fecha = $_POST['fecha'];
	$cantsali = $_POST['cantidad'];
	$ref = $_POST['referencia'];
	$tipodoc = $_POST['tipodoc'];
	$serie = $_POST['serie'];
	$tipoope = $_POST['tipooper'];
	$ano = date("Y", strtotime($fecha));
	$query_uingresos = "select * from movimientos where movimiento='Ingreso' and idmaterial=$material and	fecha = (select max(fecha) from movimientos where movimiento='Ingreso' and idmaterial=$material)";
	$uingresos = $cnx_cuzzicia->Execute($query_uingresos) or die($cnx_cuzzicia->ErrorMsg());
	$ufecha = $uingresos->Fields('fecha');
		
	$query_tingreso = "SELECT sum(saldo) FROM movimientos WHERE movimiento='Ingreso' and idmaterial = '$material' and fecha <= '$ufecha' and date_part('year', fecha) = $ano;";
	$tingreso = $cnx_cuzzicia->Execute($query_tingreso) or die($cnx_cuzzicia->ErrorMsg());

	$query_ingresos = "SELECT * FROM movimientos WHERE movimiento='Ingreso' and idmaterial = '$material' and fecha <= '$fecha' and date_part('year', fecha) = $ano ORDER BY fecha,motivo,idmovimiento;";
	$ingresos = $cnx_cuzzicia->Execute($query_ingresos) or die($cnx_cuzzicia->ErrorMsg());

	$totingre = $tingreso->Fields('sum');
	$vtsoles=0;
	$vtdolares=0;
	$idingre = $ingresos->Fields('idmovimiento');
	$cantsaldo = $ingresos->Fields('saldo');
	$vusoles = $ingresos->Fields('vusoles');
	$vudolares = $ingresos->Fields('vudolar');
	$porconsu = $cantsali;
	$cansaltem = $cantsaldo;
	if ($porconsu > $totingre) {
	$insertGoTo = "error.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?idmovi=$idingre";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
  	KT_redir($insertGoTo);
	}else/*if($fecha<$ufecha)*/{
   		$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,idorden,idseccion,cantidad,vusoles,vudolar,referencia,tipodoc,serie,tipoope) VALUES ('Salida',$material,'$motivo','$fecha',$orden,$seccion,$cantsali,0,0,'$ref',$tipodoc,$serie,$tipoope);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
//	   require('form.php');
	}/*elseif($porconsu > $cansaltem) {
		while($porconsu > $cansaltem){
		$idingre = $ingresos->Fields('idmovimiento');
		$cantsaldo = $ingresos->Fields('saldo');
		$vusoles = $ingresos->Fields('vusoles');
		$vudolares = $ingresos->Fields('vudolar');
		$cansaltem = $cantsaldo;
			if($porconsu > $cansaltem){
			$porconsu = $porconsu - $cansaltem;
			$vtsoles = $vtsoles+$cansaltem*$vusoles;
			$vtdolares = $vtdolares+$cansaltem*$vudolares;
			$cansaltem = 0;
			$upingresos = "UPDATE movimientos SET saldo = 0 WHERE idmovimiento = $idingre;";
			$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
			$ingresos->MoveNext();
			}else{
			break;
			}
		}
	$cansaltem = $cansaltem - $porconsu;
	$upingresos = "UPDATE movimientos SET saldo = $cansaltem WHERE idmovimiento = $idingre;";
	$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
	$vtsoles = $vtsoles+$porconsu*$vusoles;
	$vtdolares = $vtdolares+$porconsu*$vudolares;
			if($cantsali==0){
				$vusolessali = 0;
				$vudolarsali = 0;
			}else{
			$vusolessali = $vtsoles/$cantsali;
			$vudolarsali = $vtdolares/$cantsali;
			}
		$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,idorden,idseccion,cantidad,vusoles,vudolar,referencia,tipodoc,serie,tipoope) VALUES ('Salida',$material,'$motivo','$fecha',$orden,$seccion,$cantsali,$vusolessali,$vudolarsali,'$ref',$tipodoc,$serie,$tipoope);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	}
	else {
	$cansaltem = $cansaltem - $porconsu;
	$upingresos = "UPDATE movimientos SET saldo = $cansaltem WHERE idmovimiento = $idingre;";
	$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
	$vtsoles = $vtsoles+$porconsu*$vusoles;
	$vtdolares = $vtdolares+$porconsu*$vudolares;
		if($cantsali==0){
			$vusolessali = 0;
			$vudolarsali = 0;
		}else{
		$vusolessali = $vtsoles/$cantsali;
		$vudolarsali = $vtdolares/$cantsali;
		}
	$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,idorden,idseccion,cantidad,vusoles,vudolar,referencia,tipodoc,serie,tipoope) VALUES ('Salida',$material,'$motivo','$fecha',$orden,$seccion,$cantsali,$vusolessali,$vudolarsali,'$ref',$tipodoc,$serie,$tipoope)";
	$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	}*/
require('form.php');
$insertGoTo = "salidas.php";
if (isset($_SERVER['QUERY_STRING'])) {
 $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
 $insertGoTo .= $_SERVER['QUERY_STRING'];
}
KT_redir($insertGoTo);
}
?>

<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/DynamicInput.js"></script>
<script type="text/javascript" src="valida.js"></script>
<script language="JavaScript" type="text/JavaScript">
function validacion(){
c = document.frm_salidas.cantidad.value;
n = document.frm_salidas.referencia.value;
f = document.frm_salidas.fecha.value;
m = document.frm_salidas.motivo.value;
o = document.frm_salidas.orden.value;
s = document.frm_salidas.seccion.value;
if(n==''){
      alert("numero.");
	  return false
    }else if(f==''){
      alert("fecha.");
	  return false
    }else if((o==0 && s==0 && m!='6Ajuste') || (s!=0 && o!=0)){
      alert("Consumo a una Orden o Seccion.");
	  return false
    }else if(c==''){
      alert("cantidad.");
	  return false
    }else{
	document.frm_salidas.enviar.disabled = true;
	document.frm_salidas.enviar.value = "Procesando ...";
	return true}
}
</script>
<?php
//begin JSRecordset
$jsObject_orden = new WDG_JsRecordset("orden");
echo $jsObject_orden->getOutput();
//end JSRecordset
?>

<form action="<?php echo $editFormAction; ?>" method="post" name="frm_salidas" onSubmit="return validacion();">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">SALIDA DE MATERIALES</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="tipoconsumo" name="tipoconsumo" onChange="tipoconsumo_reload(this)">
          <option selected>tipoconsumo</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><label>
        <select id="categoria" name="categoria" onChange="tipoconsumo_reload(this)">
          <option selected>categoria</option>
        </select>
        </label>
      </td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select" name="material" onChange="tipoconsumo_reload(this)">
          <option selected>material</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select2" name="marcatipo" onChange="tipoconsumo_reload(this)">
          <option selected>marcatipo</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select4" name="gramcal" onChange="tipoconsumo_reload(this)">
          <option selected>gramcal</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label>
      </td>
      <td>
        <select id="select3" name="medidas" onChange="tipoconsumo_reload(this)">
          <option selected>medidas</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="motivo">Motivo:</label>
      </td>
      <td>
        <select name="motivo" id="motivo">
          <option value="6Ajuste">Ajuste 
          <option value="5Consumo" selected>Consumo 
          <option value="5Conversion">Conversi&oacute;n 
        </select>
      </td>
    </tr>
    <tr>
      <td class="KT_th">Tipo Doc:</td>
      <td><label for="tipodoc"></label>
        <select name="tipodoc" id="tipodoc">
          <option value="01">Factura</option>
          <option value="09">Guia Remisi&oacute;n</option>
          <option value="00" selected="selected">Otros (Salida Materiales)</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Serie:</td>
      <td><input name="serie" type="text" id="serie" value="1" /></td>
    </tr>
    <tr>
      <td class="KT_th">Numero:</td>
      <td><input name="referencia" type="text" id="referencia4" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha:</label>
      </td>
      <td>
        <input name="fecha" id="fecha" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />         
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idorden2">Tipo Operacion:</label></td>
      <td><select name="tipooper" id="tipooper">
        <option value="01">Venta</option>
        <option value="02">Compra</option>
        <option value="10" selected="selected">Salida a Prod.</option>
        <option value="19">Saldo Inicial</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idorden">Idorden:</label>
      </td>
      <td>
        <input name="orden" id="orden" value="0" wdg:subtype="DynamicSearch" wdg:recordset="orden" wdg:type="widget" wdg:displayfield="idorden" wdg:norec="50" wdg:defaultoptiontext="no" wdg:selected="0">
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idseccion">Idseccion:</label>
      </td>
      <td><label>
        <select name="seccion" id="seccion">
          <?php
  while(!$seccion->EOF){
?>
          <option value="<?php echo $seccion->Fields('idseccion')?>"<?php if (!(strcmp($seccion->Fields('idseccion'), 0))) {echo "SELECTED";} ?>><?php echo $seccion->Fields('seccion')?></option>
          <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>
      </td>
      <td>
        <input type="text" name="cantidad" id="cantidad" />
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

        </script>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="enviar" id="enviar" value="Guardar" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="frm_salidas">
</form>
<?php
$orden->Close();
$seccion->Close();
$materiales->Close();
?>
