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

//PHP ADODB document - made with PHAkt 3.6.0
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consumos</title>
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('Verifique lo Siguiente:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
</head>

<body>
<table width="100%" height="0" border="0" cellpadding="0">
  <tr valign="top">
    <td><form action="consucant.php" method="post" name="frm_salidas" target="idiframe" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">SELECCIONE MATERIAL</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;      </td>
    </tr>
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select id="select7" name="tipo" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><select id="select" name="catego" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select id="select2" name="mate" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select id="select3" name="marcatipo" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select id="select4" name="gramcal" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label></td>
      <td><select id="select5" name="medi" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Unidad:</td>
      <td><select id="select6" name="uni" onChange="tipo_reload(this)">
      <option value="-">&gt;&gt;Seleccione Uno&lt;&lt;
      </select>
      <script language="JavaScript">
tipo_contents=new Array();
tipo_tempArray=new Array();
tipo_counter=0;
tipo_isDataOrdered=1;
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
tipo_comboGroup[daIndex].options.length=1;
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
tipo_makeSelValueGroup("","","","","","","");
tipo_makeComboGroup("tipo","catego","mate","marcatipo","gramcal","medi","uni");
 var separator="+#+";
<?php while(!$materiales->EOF){?>
tipo_addContent("<?php echo $materiales->Fields('tipoconsumo'); ?>+#+<?php echo $materiales->Fields('tipoconsumo'); ?>+#+<?php echo $materiales->Fields('categoria'); ?>+#+<?php echo $materiales->Fields('categoria'); ?>+#+<?php echo $materiales->Fields('materiales'); ?>+#+<?php echo $materiales->Fields('materiales'); ?>+#+<?php echo $materiales->Fields('marcatipo'); ?>+#+<?php echo $materiales->Fields('marcatipo'); ?>+#+<?php echo $materiales->Fields('gramajecalibre'); ?>+#+<?php echo $materiales->Fields('gramajecalibre'); ?>+#+<?php echo $materiales->Fields('medida'); ?>+#+<?php echo $materiales->Fields('medida'); ?>+#+<?php echo $materiales->Fields('unidad'); ?>+#+<?php echo $materiales->Fields('unidad'); ?>");
<?php $materiales->MoveNext();
 }
$materiales->MoveFirst();
 ?>tipo_reload();

        </script></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="motivo">Fecha Inicio:</label>
      </td>
      <td><input name="fecini" id="fecini" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />
</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha Fin:</label>
      </td>
      <td>
        <input name="fecfin" id="fecfin" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />         
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input name="KT_Insert1" type="submit" id="KT_Insert1" onClick="MM_validateForm('fecini','','R','fecfin','','R');return document.MM_returnValue" value="Buscar" />
      </td>
    </tr>
  </table>
	</form></td>
    <td><iframe  name="idiframe" id="idiframe" width="650" height="505" src="consucant.php" frameborder="0">
	</iframe></td>
  </tr>
</table>
</body>
</html>
<?php
$materiales->Close();
?>
