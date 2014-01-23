<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');
//Aditional Functions
require_once('includes/functions.inc.php');
// begin Recordset
$query_matmaster = "SELECT * FROM materiales2";
$matmaster = $cnx_cuzzicia->SelectLimit($query_matmaster) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_matmaster = $matmaster->RecordCount();
// end Recordset
// begin Recordset
$query_materiales = "SELECT * FROM materiales2";
$materiales = $cnx_cuzzicia->SelectLimit($query_materiales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales = $materiales->RecordCount();
// end Recordset
// begin Recordset
$query_materiales2 = "SELECT * FROM materiales2";
$materiales2 = $cnx_cuzzicia->SelectLimit($query_materiales2) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales2 = $materiales2->RecordCount();
// end Recordset
//PHP ADODB document - made with PHAkt 3.7.1
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_salidas")) {
	$matsa = $_POST['unim'];
	$matin1 = $_POST['idmat'];
	$matin2 = $_POST['select20'];
	$porv1 = $_POST['pv1'];
	$porv2 = $_POST['pv2'];
	$fecha = $_POST['fecha'];
	$cantsali = $_POST['cants'];
	$canting1 = $_POST['canti1'];
	$canting2 = $_POST['canti2'];
	$ano = date("Y", strtotime($fecha));
//		
	$query_tingreso = "SELECT sum(saldo) FROM movimientos WHERE movimiento='Ingreso' and idmaterial='$matsa' and fecha<='$fecha' and date_part('year',fecha)=$ano;";
	$tingreso = $cnx_cuzzicia->Execute($query_tingreso) or die($cnx_cuzzicia->ErrorMsg());

	$query_ingresos = "SELECT * FROM movimientos WHERE movimiento='Ingreso' and idmaterial='$matsa' and fecha<='$fecha' and date_part('year',fecha)=$ano ORDER BY fecha;";
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
if($canting2<>0){
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
		$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,vusoles,vudolar) VALUES ('Salida',$matsa,'4Conversion','$fecha',$cantsali,$vusolessali,$vudolarsali);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	//calculo valores ingresos
	$vusolesing1 = ($vtsoles*$porv1/100)/$canting1;
	$vudolaring1 = ($vtdolares*$porv1/100)/$canting1;
	$vusolesing2 = ($vtsoles*$porv1/100)/$canting1;
	$vudolaring2 = ($vtdolares*$porv1/100)/$canting1;
		$insvaing1 = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$matin1,'3Conversion','$fecha',$canting1,$canting1,$vusolesing1,$vudolaring1);";
		$invaingexc1 = $cnx_cuzzicia->Execute($insvaing1) or die($cnx_cuzzicia->ErrorMsg());
		$insvaing2 = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$matin2,'3Conversion','$fecha',$canting2,$canting2,$vusolesing2,$vudolaring2);";
		$invaingexc2 = $cnx_cuzzicia->Execute($insvaing2) or die($cnx_cuzzicia->ErrorMsg());

		$insertGoTo = "conversiones.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
		    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		    $insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  KT_redir($insertGoTo);
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
	$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,vusoles,vudolar) VALUES ('Salida',$matsa,'4Conversion','$fecha',$cantsali,$vusolessali,$vudolarsali);";
	$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	//calculo valores ingresos
	$vusolesing1 = ($vtsoles*$porv1/100)/$canting1;
	$vudolaring1 = ($vtdolares*$porv1/100)/$canting1;
	$vusolesing2 = ($vtsoles*$porv1/100)/$canting1;
	$vudolaring2 = ($vtdolares*$porv1/100)/$canting1;
		$insvaing1 = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$matin1,'3Conversion','$fecha',$canting1,$canting1,$vusolesing1,$vudolaring1);";
		$invaingexc1 = $cnx_cuzzicia->Execute($insvaing1) or die($cnx_cuzzicia->ErrorMsg());
		$insvaing2 = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$matin2,'3Conversion','$fecha',$canting2,$canting2,$vusolesing2,$vudolaring2);";
		$invaingexc2 = $cnx_cuzzicia->Execute($insvaing2) or die($cnx_cuzzicia->ErrorMsg());

	$insertGoTo = "conversiones.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		    $insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  KT_redir($insertGoTo);
	}
}else{
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
		$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,vusoles,vudolar) VALUES ('Salida',$matsa,'4Conversion','$fecha',$cantsali,$vusolessali,$vudolarsali);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
		//calculo valores ingreso
	$vusolesing = $vtsoles/$canting1;
	$vudolaring = $vtdolares/$canting1;
		$insvaing = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$matin1,'3Conversion','$fecha',$canting1,$canting1,$vusolesing,$vudolaring);";
		$invaingexc = $cnx_cuzzicia->Execute($insvaing) or die($cnx_cuzzicia->ErrorMsg());

		$insertGoTo = "conversiones.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
		    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		    $insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  KT_redir($insertGoTo);
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
		$insvasal = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,vusoles,vudolar) VALUES ('Salida',$matsa,'4Conversion','$fecha',$cantsali,$vusolessali,$vudolarsali);";
		$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	//calculo valores ingreso
	$vusolesing = $vtsoles/$canting1;
	$vudolaring = $vtdolares/$canting1;
		$insvaing = "INSERT INTO movimientos (movimiento,idmaterial,motivo,fecha,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$matin1,'3Conversion','$fecha',$canting1,$canting1,$vusolesing,$vudolaring);";
		$invaingexc = $cnx_cuzzicia->Execute($insvaing) or die($cnx_cuzzicia->ErrorMsg());

	$insertGoTo = "conversiones.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		    $insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  KT_redir($insertGoTo);
	}
}
}
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Conversi&oacute;n</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="frm_salidas" id="frm_salidas">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">CONVERSIONES</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha:</label>      </td>
      <td>
        <input name="fecha" id="fecha" value="" size="25" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />      </td>
    </tr>
   <tr class="KT_buttons">
      <td colspan="2">
        <hr />      </td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">SALIDA</td>
    </tr>
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="tipom" name="tipom" onChange="tipom_reload(this)">
        <option selected>tipom</option>
      </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><select id="categom" name="categom" onChange="tipom_reload(this)">
        <option selected>categom</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select8" name="matm" onChange="tipom_reload(this)">
        <option selected>matm</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select9" name="marcatipm" onChange="tipom_reload(this)">
        <option selected>marcatipm</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select10" name="gramcalm" onChange="tipom_reload(this)">
        <option selected>gramcalm</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label>      </td>
      <td><select id="select11" name="medim" onChange="tipom_reload(this)">
        <option selected>medim</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>      </td>
      <td>
        <input type="text" name="cants" id="cants" />
        <select id="select13" name="unim" onChange="tipom_reload(this)">
          <option selected>unim</option>
        </select>
        <script language="JavaScript">
tipom_contents=new Array();
tipom_tempArray=new Array();
tipom_counter=0;
tipom_isDataOrdered=1;
function tipom_addContent(str){
	tipom_contents[tipom_counter]=str;
	tipom_counter++;
}
function tipom_split(){
	tipom_arrayValues = new Array();
	for(i=0;i<tipom_contents.length;i++){
		tipom_arrayValues[i]=tipom_contents[i].split(separator);
		tipom_tempArray[0]=tipom_arrayValues;
	}
}
function tipom_makeSelValueGroup(){
	tipom_selValueGroup=new Array();
	var args=tipom_makeSelValueGroup.arguments;
	for(i=0;i<args.length;i++){
		tipom_selValueGroup[i]=args[i];
		tipom_tempArray[i]=new Array();
	}
}
function tipom_makeComboGroup(){
	tipom_comboGroup=new Array();
	var args=tipom_makeComboGroup.arguments;
	for(i=0;i<args.length;i++) tipom_comboGroup[i]=findObj(args[i]);
}
function tipom_setDefault(){
	for (i=tipom_selValueGroup.length-1;i>=0;i--){
		if(tipom_selValueGroup[i]!=""){
			for(j=0;j<tipom_contents.length;j++){
				if(tipom_arrayValues[j][(i*2)+1]==tipom_selValueGroup[i]){
					for(k=i;k>=0;k--){
						if(tipom_selValueGroup[k]=="") tipom_selValueGroup[k]=tipom_arrayValues[j][(k*2)+1];
					}
				}
			}
		}
	}
}
function tipom_loadMenu(daIndex){
var selectionMade=false;
daArray=tipom_tempArray[daIndex];
tipom_comboGroup[daIndex].options.length=0;
var tipom_cur_daArrayValue="";
if(tipom_isDataOrdered==1){
	for(i=0;i<daArray.length;i++){
		if(tipom_cur_daArrayValue!=daArray[i][(daIndex*2)+1]){
			tipom_comboGroup[daIndex].options[tipom_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			tipom_cur_daArrayValue=daArray[i][(daIndex*2)+1];
		}
	}
}else{
	for(i=0;i<daArray.length;i++){
		existe=false;
		for(j=0;j<tipom_comboGroup[daIndex].options.length;j++){
			if(daArray[i][(daIndex*2)+1]==tipom_comboGroup[daIndex].options[j].value) existe=true;
		}
		if(existe==false){
			lastValue=tipom_comboGroup[daIndex].options.length;
			tipom_comboGroup[daIndex].options[tipom_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			if(tipom_selValueGroup[daIndex]==tipom_comboGroup[daIndex].options[lastValue].value){
				tipom_comboGroup[daIndex].options[lastValue].selected=true;
				selectionMade=true;
			}
		}
	}
}
if(selectionMade==false) tipom_comboGroup[daIndex].options[0].selected=true;
}
function tipom_reload(from){
	if(!from){
		tipom_split();
		tipom_setDefault();
		tipom_loadMenu(0);
		tipom_reload(tipom_comboGroup[0]);
	}else{
		for(j=0; j<tipom_comboGroup.length; j++){
			if(tipom_comboGroup[j]==from) index=j+1;
		}
		if(index<tipom_comboGroup.length){
			tipom_tempArray[index].length=0;
			for(i=0;i<tipom_comboGroup[index-1].options.length;i++){
				if(tipom_comboGroup[index-1].options[i].selected==true){
					for(j=0;j<tipom_tempArray[index-1].length;j++){
						if(tipom_comboGroup[index-1].options[i].value==tipom_tempArray[index-1][j][(index*2)-1]) tipom_tempArray[index][tipom_tempArray[index].length]=tipom_tempArray[index-1][j];
					}
				}
			}
		tipom_loadMenu(index);
		tipom_reload(tipom_comboGroup[index]);
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
tipom_makeSelValueGroup("","","","","","","");
tipom_makeComboGroup("tipom","categom","matm","marcatipm","gramcalm","medim","unim");
 var separator="+#+";
<?php while(!$matmaster->EOF){?>
tipom_addContent("<?php echo $matmaster->Fields('tipoconsumo'); ?>+#+<?php echo $matmaster->Fields('idtipoconsumo'); ?>+#+<?php echo $matmaster->Fields('categoria'); ?>+#+<?php echo $matmaster->Fields('idcategoria'); ?>+#+<?php echo $matmaster->Fields('materiales'); ?>+#+<?php echo $matmaster->Fields('idmaterial'); ?>+#+<?php echo $matmaster->Fields('marcatipo'); ?>+#+<?php echo $matmaster->Fields('idmarcatipo'); ?>+#+<?php echo $matmaster->Fields('gramajecalibre'); ?>+#+<?php echo $matmaster->Fields('idgramcal'); ?>+#+<?php echo $matmaster->Fields('medida'); ?>+#+<?php echo $matmaster->Fields('idmedidas'); ?>+#+<?php echo $matmaster->Fields('unidad'); ?>+#+<?php echo $matmaster->Fields('idmateriales'); ?>");
<?php $matmaster->MoveNext();
 }
$matmaster->MoveFirst();
 ?>tipom_reload();

        </script>      </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <hr />      </td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">INGRESO 1 </td>
    </tr>
 <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="tipoconsumo" name="tipoconsumo" onChange="tipoconsumo_reload(this)">
        <option selected>tipoconsumo</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><select id="categoria" name="categoria" onChange="tipoconsumo_reload(this)">
        <option selected>categoria</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select" name="material" onChange="tipoconsumo_reload(this)">
        <option selected>material</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select3" name="marcatipo" onChange="tipoconsumo_reload(this)">
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
      <td class="KT_th"><label for="idmaterial">Medidas:</label>      </td>
      <td><select id="select5" name="medidas" onChange="tipoconsumo_reload(this)">
        <option selected>medidas</option>
      </select>      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label></td>
      <td><input type="text" name="canti1" id="canti1" />
        <select id="select7" name="idmat" onChange="tipoconsumo_reload(this)">
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
      <td class="KT_th">Valor %. </td>
      <td><label>
        <input name="pv1" type="text" id="pv1" size="10">
      *solo si son 2 mat. </label></td>
    </tr>
	<tr>
	  <td colspan="2" class="KT_th"><hr /></td>
    </tr>
	<tr>
      <td colspan="2" class="KT_th">INGRESO 2 </td>
    </tr>
 <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="select14" name="select14" onChange="select14_reload(this)">
        <option selected>select14</option>
      </select></td>
 </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><select id="select15" name="select15" onChange="select14_reload(this)">
        <option selected>select15</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select16" name="select16" onChange="select14_reload(this)">
        <option selected>select16</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select17" name="select17" onChange="select14_reload(this)">
        <option selected>select17</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select18" name="select18" onChange="select14_reload(this)">
        <option selected>select18</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label>      </td>
      <td><select id="select19" name="select19" onChange="select14_reload(this)">
        <option selected>select19</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label></td>
      <td><input name="canti2" type="text" id="canti2" value="0" size="25" />
        <select id="select20" name="select20" onChange="select14_reload(this)">
          <option selected>select20</option>
        </select>
        <script language="JavaScript">
select14_contents=new Array();
select14_tempArray=new Array();
select14_counter=0;
select14_isDataOrdered=1;
function select14_addContent(str){
	select14_contents[select14_counter]=str;
	select14_counter++;
}
function select14_split(){
	select14_arrayValues = new Array();
	for(i=0;i<select14_contents.length;i++){
		select14_arrayValues[i]=select14_contents[i].split(separator);
		select14_tempArray[0]=select14_arrayValues;
	}
}
function select14_makeSelValueGroup(){
	select14_selValueGroup=new Array();
	var args=select14_makeSelValueGroup.arguments;
	for(i=0;i<args.length;i++){
		select14_selValueGroup[i]=args[i];
		select14_tempArray[i]=new Array();
	}
}
function select14_makeComboGroup(){
	select14_comboGroup=new Array();
	var args=select14_makeComboGroup.arguments;
	for(i=0;i<args.length;i++) select14_comboGroup[i]=findObj(args[i]);
}
function select14_setDefault(){
	for (i=select14_selValueGroup.length-1;i>=0;i--){
		if(select14_selValueGroup[i]!=""){
			for(j=0;j<select14_contents.length;j++){
				if(select14_arrayValues[j][(i*2)+1]==select14_selValueGroup[i]){
					for(k=i;k>=0;k--){
						if(select14_selValueGroup[k]=="") select14_selValueGroup[k]=select14_arrayValues[j][(k*2)+1];
					}
				}
			}
		}
	}
}
function select14_loadMenu(daIndex){
var selectionMade=false;
daArray=select14_tempArray[daIndex];
select14_comboGroup[daIndex].options.length=0;
var select14_cur_daArrayValue="";
if(select14_isDataOrdered==1){
	for(i=0;i<daArray.length;i++){
		if(select14_cur_daArrayValue!=daArray[i][(daIndex*2)+1]){
			select14_comboGroup[daIndex].options[select14_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			select14_cur_daArrayValue=daArray[i][(daIndex*2)+1];
		}
	}
}else{
	for(i=0;i<daArray.length;i++){
		existe=false;
		for(j=0;j<select14_comboGroup[daIndex].options.length;j++){
			if(daArray[i][(daIndex*2)+1]==select14_comboGroup[daIndex].options[j].value) existe=true;
		}
		if(existe==false){
			lastValue=select14_comboGroup[daIndex].options.length;
			select14_comboGroup[daIndex].options[select14_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			if(select14_selValueGroup[daIndex]==select14_comboGroup[daIndex].options[lastValue].value){
				select14_comboGroup[daIndex].options[lastValue].selected=true;
				selectionMade=true;
			}
		}
	}
}
if(selectionMade==false) select14_comboGroup[daIndex].options[0].selected=true;
}
function select14_reload(from){
	if(!from){
		select14_split();
		select14_setDefault();
		select14_loadMenu(0);
		select14_reload(select14_comboGroup[0]);
	}else{
		for(j=0; j<select14_comboGroup.length; j++){
			if(select14_comboGroup[j]==from) index=j+1;
		}
		if(index<select14_comboGroup.length){
			select14_tempArray[index].length=0;
			for(i=0;i<select14_comboGroup[index-1].options.length;i++){
				if(select14_comboGroup[index-1].options[i].selected==true){
					for(j=0;j<select14_tempArray[index-1].length;j++){
						if(select14_comboGroup[index-1].options[i].value==select14_tempArray[index-1][j][(index*2)-1]) select14_tempArray[index][select14_tempArray[index].length]=select14_tempArray[index-1][j];
					}
				}
			}
		select14_loadMenu(index);
		select14_reload(select14_comboGroup[index]);
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
select14_makeSelValueGroup("","","","","","","");
select14_makeComboGroup("select14","select15","select16","select17","select18","select19","select20");
 var separator="+#+";
<?php while(!$materiales2->EOF){?>
select14_addContent("<?php echo $materiales2->Fields('tipoconsumo'); ?>+#+<?php echo $materiales2->Fields('idtipoconsumo'); ?>+#+<?php echo $materiales2->Fields('categoria'); ?>+#+<?php echo $materiales2->Fields('idcategoria'); ?>+#+<?php echo $materiales2->Fields('materiales'); ?>+#+<?php echo $materiales2->Fields('idmaterial'); ?>+#+<?php echo $materiales2->Fields('marcatipo'); ?>+#+<?php echo $materiales2->Fields('idmarcatipo'); ?>+#+<?php echo $materiales2->Fields('gramajecalibre'); ?>+#+<?php echo $materiales2->Fields('idgramcal'); ?>+#+<?php echo $materiales2->Fields('medida'); ?>+#+<?php echo $materiales2->Fields('idmedidas'); ?>+#+<?php echo $materiales2->Fields('unidad'); ?>+#+<?php echo $materiales2->Fields('idmateriales'); ?>");
<?php $materiales2->MoveNext();
 }
$materiales2->MoveFirst();
 ?>select14_reload();

        </script></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Valor %. </label></td>
      <td><input name="pv2" type="text" id="pv2" size="10">
      *solo sin son 2 mat. </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="frm_salidas">
</form>
</body>
</html>
<?php
$matmaster->Close();
$materiales->Close();
$materiales2->Close();
?>