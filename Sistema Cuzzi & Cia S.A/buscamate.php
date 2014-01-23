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

//PHP ADODB document - made with PHAkt 3.7.1

$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_salidas")) {
	$material = $_POST['idmat'];
	$motivo = $_POST['motivo'];
	$orden = $_POST['orden'];
	$seccion = $_POST['seccion'];
	$fecha = $_POST['fecha'];
	$cantsali = $_POST['cantidad'];
	$ano = date("Y");
		
	$query_tingreso = "SELECT sum(cantsaldo) FROM vingresos WHERE idmateriales = '$material' and fecha <= '$fecha' and a�o = $ano;";
	$tingreso = $cnx_cuzzicia->Execute($query_tingreso) or die($cnx_cuzzicia->ErrorMsg());

	$query_ingresos = "SELECT * FROM vingresos WHERE idmateriales = '$material' and fecha <= '$fecha' and a�o = $ano ORDER BY fecha;";
	$ingresos = $cnx_cuzzicia->Execute($query_ingresos) or die($cnx_cuzzicia->ErrorMsg());

	$totingre = $tingreso->Fields('sum');
	$vtsoles=0;
	$vtdolares=0;
	$idingre = $ingresos->Fields('idingreso');
	$cantsaldo = $ingresos->Fields('cantsaldo');
	$vusoles = $ingresos->Fields('valorusoles');
	$vudolares = $ingresos->Fields('valorudolar');
	$porconsu = $cantsali;
	$cansaltem = $cantsaldo;
	if ($porconsu > $totingre) {
	/*echo " no es posible realizar transaccion"."<br>";
	echo " cantidad de salida mayor a los ingresos realizados"."<br>";*/
	$insertGoTo = "error.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
  	KT_redir($insertGoTo);
	} elseif($porconsu > $cansaltem) {
		while($porconsu > $cansaltem){
		$idingre = $ingresos->Fields('idingreso');
		$cantsaldo = $ingresos->Fields('cantsaldo');
		$vusoles = $ingresos->Fields('valorusoles');
		$vudolares = $ingresos->Fields('valorudolar');
		$cansaltem = $cantsaldo;
			if($porconsu > $cansaltem){
			$porconsu = $porconsu - $cansaltem;
			$vtsoles = $vtsoles+$cansaltem*$vusoles;
			$vtdolares = $vtdolares+$cansaltem*$vudolares;
			$upingresos = "UPDATE ingresos SET cantsaldo = 0 WHERE idingreso = $idingre;";
			$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
			$ingresos->MoveNext();
			}else{
			break;
			}
		}
		$cansaltem = $cansaltem - $porconsu;
		$upingresos = "UPDATE ingresos SET cantsaldo = $cansaltem WHERE idingreso = $idingre;";
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
		$insvasal = "INSERT INTO salidas (idmaterial,motivo,fecha,idorden,idseccion,cantidad,valorusoles,valorudolar) VALUES ($material,'$motivo','$fecha',$orden,$seccion,$cantsali,$vusolessali,$vudolarsali);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
		$insertGoTo = "Untitled-3.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
		    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		    $insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  KT_redir($insertGoTo);
	}
	else {
	$cansaltem = $cansaltem - $porconsu;
	$upingresos = "UPDATE ingresos SET cantsaldo = $cansaltem WHERE idingreso = $idingre;";
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
	$insvasal = "INSERT INTO salidas (idmaterial,motivo,fecha,idorden,idseccion,cantidad,valorusoles,valorudolar) VALUES ($material,'$motivo','$fecha',$orden,$seccion,$cantsali,$vusolessali,$vudolarsali);";
	$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	$insertGoTo = "Untitled-3.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		    $insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  KT_redir($insertGoTo);
	}
}
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Salidas OK</title>
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
</head>
<body>
<form action="resulingre.php" method="post" name="frm_salidas" id="frm_salidas">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th"> MATERIALES</td>
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
        </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select2" name="marcatipo" onChange="tipoconsumo_reload(this)">
          <option selected>marcatipo</option>
        </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select4" name="gramcal" onChange="tipoconsumo_reload(this)">
          <option selected>gramcal</option>
        </select>      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label>      </td>
      <td>
        <select id="select3" name="medidas" onChange="tipoconsumo_reload(this)">
          <option selected>medidas</option>
        </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Unidad:</label></td>
      <td><select id="select5" name="idmat" onChange="tipoconsumo_reload(this)">
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

        </script></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Buscar" />      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
$materiales->Close();
?>
