<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');

//Aditional Functions
require_once('includes/functions.inc.php');
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
$query_seccion = "SELECT * FROM seccion ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
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
    $motivo = $_POST['motivo'];
    $fecha = $_POST['fecha'];
	$fechad = $_POST['fecha2'];
    $orden = $_POST['orden'];
    $seccion = $_POST['seccion'];
	$refdev = $_POST['refdevo'];
    $cantsali = $_POST['cantidad'];
	$cantdev = $_POST['cantdevo'];
    $id = $_POST['hiddenField'];
	$ano = date("Y", strtotime($fecha));
	// calculo de valores
	$cantidad = $cantsali - $cantdev;
	//actulaizar salida
	$upsali = "UPDATE movimientos SET idmaterial=$material, motivo='$motivo', fecha='$fecha', idorden=$orden, idseccion=$seccion, cantidad=$cantidad WHERE idmovimiento=$id";
	$upsaliexc = $cnx_cuzzicia->Execute($upsali) or die($cnx_cuzzicia->ErrorMsg());
	
	require('form.php');
	// tomar valores de mov para devoluciones
	$selvals = "SELECT * FROM movimientos WHERE idmovimiento=$id";
	$selvalexc = $cnx_cuzzicia->Execute($selvals) or die($cnx_cuzzicia->ErrorMsg());
	$vusol = $selvalexc->Fields('vusoles');
	$vudol = $selvalexc->Fields('vudolar');
	//insertar salida devolucion
	$devolu = "INSERT INTO devoluciones (idmaterial,destino,fecha,referencia,cantidad,vusoles,vudolar) VALUES ($material,'Planta','$fechad','$refdev',$cantdev,$vusol,$vudol);";
	$devoluexc = $cnx_cuzzicia->Execute($devolu) or die($cnx_cuzzicia->ErrorMsg());

$updateGoTo = "buscadevplan.php";
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
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/DynamicInput.js"></script>
<?php
//begin JSRecordset
$jsObject_orden = new WDG_JsRecordset("orden");
echo $jsObject_orden->getOutput();
//end JSRecordset
?>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_salidas" id="frm_salidas">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">ACTUALIZA SALIDA</td>
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
      <td><select id="select29" name="gramcal" onChange= "tipo_reload(this)">
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
      <td class="KT_th"><label for="motivo">Motivo:</label>      </td>
      <td>
        <select name="motivo" id="motivo">
          <option value="6Ajuste" <?php if (!(strcmp("6Ajuste", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Ajuste
          <option value="5Consumo" <?php if (!(strcmp("5Consumo", $actuliza->Fields('motivo')))) {echo "SELECTED";} ?>>Consumo
          <option value="4Conversion">Conversi&oacute;n 
          <option value="5Devolucion" selected>Devolucion
        </select>      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha:</label>      </td>
      <td>
        <input name="fecha" id="fecha" value="<?php echo $actuliza->Fields('fecha'); ?>" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idorden">Idorden:</label>      </td>
      <td><input name="orden" id="orden" wdg:subtype="DynamicSearch" wdg:recordset="orden" wdg:type="widget" wdg:displayfield="idorden" wdg:norec="50" wdg:defaultoptiontext="no" wdg:selected="<?php echo $actuliza->Fields('idorden'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idseccion">Idseccion:</label>      </td>
      <td>
        <select name="seccion" id="seccion">
          <option value="" <?php if (!(strcmp("", $actuliza->Fields('idseccion')))) {echo "SELECTED";} ?>></option>
          <?php
  while(!$seccion->EOF){
?>
          <option value="<?php echo $seccion->Fields('idseccion')?>"<?php if (!(strcmp($seccion->Fields('idseccion'), $actuliza->Fields('idseccion')))) {echo "SELECTED";} ?>><?php echo $seccion->Fields('seccion')?></option>
          <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
?>
        </select>      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>      </td>
      <td>
        <input name="cantidad" type="text" id="cantidad" value="<?php echo $actuliza->Fields('cantidad'); ?>" />
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
      <td class="KT_th"><label for="cantidad">Fecha Devolucion:</label></td>
      <td><input name="fecha2" id="fecha2" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" /></td>
    </tr>
    <tr>
      <td class="KT_th">Cant. Devolucion:</td>
      <td><input name="cantdevo" type="text" id="cantdevo"></td>
    </tr>
    <tr>
      <td class="KT_th">Ref. Devolucion:</td>
      <td><label>
        <input name="refdevo" type="text" id="refdevo">
      </label></td>
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
$orden->Close();
$seccion->Close();
$actuliza->Close();
?>