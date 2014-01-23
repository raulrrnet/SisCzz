<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_operaciones = "SELECT * FROM v_operaciones WHERE estado<>'x'";
$operaciones = $cnx_cuzzicia->SelectLimit($query_operaciones) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operaciones = $operaciones->RecordCount();
// end Recordset
$idinfo = '1';
if (isset($_GET['id'])) {
  $idinfo = $_GET['id'];
}
// begin Recordset
$query_operario = "SELECT * FROM infotiempo i, operario o WHERE i.idoperario=o.idoperario and i.idinforme=$idinfo";
$operario = $cnx_cuzzicia->SelectLimit($query_operario) or die($cnx_cuzzicia->ErrorMsg());
$oper = $operario->Fields('nombre');
// end Recordset
$fecha = $operario->Fields('fecha');	
//keep all parameters except idope
KT_keepParams('idope');

if ($_POST) {
$idord = $_POST['orden'];
if($idord==""){$idord = 1;}
$query_t = "select * from orden where idorden = $idord and (fechaliqui <= '$fecha' or fechatermi <= '$fecha')";
$otermi = $cnx_cuzzicia->SelectLimit($query_t) or die($cnx_cuzzicia->ErrorMsg());
$totermi = $otermi->RecordCount();
	if($totermi>0){
	echo $idord." ORDEN LIQUIDADA";
	$error = "Tiempo a Orden Liquida ".$idord."\nOperario: ".$oper."\nFecha: ".$fecha;
	mail('mario@cuzzi.net,produccion@cuzzi.net,sistemas@cuzzi.net','Movimiento a Orden Liquidada',$error);
	}
}
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO detalleinforme (idinforme, idorden, tiempo, cantidad, idoperaciones, detalles) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idinforme'], "int"),
                       GetSQLValueString($_POST['orden'], "int"),
                       GetSQLValueString($_POST['tiempo'], "double"),
                       GetSQLValueString($_POST['cantidad'], "double"),
                       GetSQLValueString($_POST['operacion'], "int"),
                       GetSQLValueString($_POST['observacion'], "text"));
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());	
  echo "<script type=\"text/javascript\"> location.href='detainfo2.php?id='".$idinfo."</script>";
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Detalle Informe</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
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
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="return validacion();">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th"><label for="idoperario">Operario:</label></td>
    <td><?php echo $operario->Fields('nombre'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="fecha">Fecha:</label></td>
    <td><?php echo $operario->Fields('fecha'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><input name="idinforme" type="hidden" id="idinforme" value="<?php echo $operario->Fields('idinforme'); ?>"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="idseccion">Seccion:</label></td>
    <td><select id="seccion" name="seccion" onChange="seccion_reload(this)">
      <option selected>seccion</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="iddestino">Destino:</label></td>
    <td><select id="destino" name="destino" onChange="seccion_reload(this)">
      <option selected>destino</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idoperaciones">Operacion:</label></td>
    <td><select id="operacion" name="operacion" onChange="seccion_reload(this)">
      <option selected>operacion</option>
    </select>
      <script language="JavaScript" type="text/javascript">
//<![CDATA[
seccion_contents=new Array();
seccion_tempArray=new Array();
seccion_counter=0;
seccion_isDataOrdered=1;
function seccion_addContent(str){
	seccion_contents[seccion_counter]=str;
	seccion_counter++;
}
function seccion_split(){
	seccion_arrayValues = new Array();
	for(i=0;i<seccion_contents.length;i++){
		seccion_arrayValues[i]=seccion_contents[i].split(separator);
		seccion_tempArray[0]=seccion_arrayValues;
	}
}
function seccion_makeSelValueGroup(){
	seccion_selValueGroup=new Array();
	var args=seccion_makeSelValueGroup.arguments;
	for(i=0;i<args.length;i++){
		seccion_selValueGroup[i]=args[i];
		seccion_tempArray[i]=new Array();
	}
}
function seccion_makeComboGroup(){
	seccion_comboGroup=new Array();
	var args=seccion_makeComboGroup.arguments;
	for(i=0;i<args.length;i++) seccion_comboGroup[i]=findObj(args[i]);
}
function seccion_setDefault(){
	for (i=seccion_selValueGroup.length-1;i>=0;i--){
		if(seccion_selValueGroup[i]!=""){
			for(j=0;j<seccion_contents.length;j++){
				if(seccion_arrayValues[j][(i*2)+1]==seccion_selValueGroup[i]){
					for(k=i;k>=0;k--){
						if(seccion_selValueGroup[k]=="") seccion_selValueGroup[k]=seccion_arrayValues[j][(k*2)+1];
					}
				}
			}
		}
	}
}
function seccion_loadMenu(daIndex){
var selectionMade=false;
daArray=seccion_tempArray[daIndex];
seccion_comboGroup[daIndex].options.length=0;
var seccion_cur_daArrayValue="";
if(seccion_isDataOrdered==1){
	for(i=0;i<daArray.length;i++){
		if(seccion_cur_daArrayValue!=daArray[i][(daIndex*2)+1]){
			seccion_comboGroup[daIndex].options[seccion_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			seccion_cur_daArrayValue=daArray[i][(daIndex*2)+1];
		}
	}
}else{
	for(i=0;i<daArray.length;i++){
		existe=false;
		for(j=0;j<seccion_comboGroup[daIndex].options.length;j++){
			if(daArray[i][(daIndex*2)+1]==seccion_comboGroup[daIndex].options[j].value) existe=true;
		}
		if(existe==false){
			lastValue=seccion_comboGroup[daIndex].options.length;
			seccion_comboGroup[daIndex].options[seccion_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			if(seccion_selValueGroup[daIndex]==seccion_comboGroup[daIndex].options[lastValue].value){
				seccion_comboGroup[daIndex].options[lastValue].selected=true;
				selectionMade=true;
			}
		}
	}
}
if(selectionMade==false) seccion_comboGroup[daIndex].options[0].selected=true;
}
function seccion_reload(from){
	if(!from){
		seccion_split();
		seccion_setDefault();
		seccion_loadMenu(0);
		seccion_reload(seccion_comboGroup[0]);
	}else{
		for(j=0; j<seccion_comboGroup.length; j++){
			if(seccion_comboGroup[j]==from) index=j+1;
		}
		if(index<seccion_comboGroup.length){
			seccion_tempArray[index].length=0;
			for(i=0;i<seccion_comboGroup[index-1].options.length;i++){
				if(seccion_comboGroup[index-1].options[i].selected==true){
					for(j=0;j<seccion_tempArray[index-1].length;j++){
						if(seccion_comboGroup[index-1].options[i].value==seccion_tempArray[index-1][j][(index*2)-1]) seccion_tempArray[index][seccion_tempArray[index].length]=seccion_tempArray[index-1][j];
					}
				}
			}
		seccion_loadMenu(index);
		seccion_reload(seccion_comboGroup[index]);
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
seccion_makeSelValueGroup("","","");
seccion_makeComboGroup("seccion","destino","operacion");
 var separator="+#+";
<?php while(!$operaciones->EOF){?>
seccion_addContent("<?php echo $operaciones->Fields('seccion'); ?>+#+<?php echo $operaciones->Fields('idseccion'); ?>+#+<?php echo $operaciones->Fields('destino'); ?>+#+<?php echo $operaciones->Fields('iddestino'); ?>+#+<?php echo $operaciones->Fields('operacion'); ?>+#+<?php echo $operaciones->Fields('idoperaciones'); ?>");
<?php $operaciones->MoveNext();
 }
$operaciones->MoveFirst();
 ?>seccion_reload();
//]]>
      </script></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="idorden">Orden:</label></td>
    <td><input name="orden" type="text" id="orden"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="tiempo">Tiempo:</label></td>
    <td><input name="tiempo" type="text" id="tiempo" /></td>
    <td class="KT_th"><label for="label">Cantidad:</label></td>
    <td><input name="cantidad" type="text" id="cantidad" /></td>
  </tr>
  
  <tr class="KT_tngtable">
    <td class="KT_th">Detalles:</td>
    <td><label>
      <textarea name="observacion" id="observacion"></textarea>
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="4"><input type="submit" name="enviar" id="enviar" value="Insertar Registro" />    </td>
  </tr>
</table>

<input type="hidden" name="MM_insert" value="form1">
</form>
<A HREF="resulinfo.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idope=" . urlencode($operario->Fields('idoperario')) ?>&<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "fecha=" . urlencode($operario->Fields('fecha')) ?>">Ver Informe</A>
</body>
</html>
<?php
$operaciones->Close();
$operario->Close();
?>