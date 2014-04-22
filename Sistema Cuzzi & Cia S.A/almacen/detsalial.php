<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

$idsali = '0';
if (isset($_GET['idsali'])) {
  $idsali = $_GET['idsali'];
}
$idlocal = '0';
if (isset($_GET['idlocal'])) {
  $idlocal = $_GET['idlocal'];
}
// begin Recordset
$query_cliente = "SELECT * FROM salidaal s, clientes c WHERE s.idcliente=c.idcliente and s.idsalida=$idsali";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset
// begin Recordset
$query_orden = "SELECT idorden,descripcion,round(precios, 2) as precios,round(preciod,2) as preciod FROM orden ORDER BY idorden DESC";
$orden = $cnx_cuzzicia->SelectLimit($query_orden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_orden = $orden->RecordCount();
// end Recordset

// begin Recordset
$query_stock = "select idorden,sum(packs)as packs, undpack from detingreal group by idorden,undpack";
$stock = $cnx_cuzzicia->SelectLimit($query_stock) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_stock = $stock->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$idsali = $_POST['hiddenField'];
$idord = $_POST['orden'];
$cant = $_POST['cantidad'];
$desc = $_POST['descrip'];
$pedi = $_POST['pedido'];
$und = $_POST['und'];
if($cant==''){$cant=1;}
  $insertSQL = "INSERT INTO detsalidaal (idsalidaal, idorden, cantidad, descripcion, pedido, und) VALUES ($idsali, $idord, $cant, '$desc', '$pedi', '$und')";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "guiadet.php";
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
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DynamicInput.js"></script>
<script language="JavaScript">
<!--
function calcHeight()
{
//find the height of the internal page
var the_height=
document.getElementById('the_iframe').contentWindow.
document.body.scrollHeight;
//change the height of the iframe
document.getElementById('the_iframe').height=
the_height;
}
//-->
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/N1DependentField.js"></script>
<?php
//begin JSRecordset
$jsObject_orden = new WDG_JsRecordset("orden");
echo $jsObject_orden->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="return validacion();">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="3" align="right" class="KT_tngtable">N&ordm; Guia:</td>
    <td><strong><?php echo $cliente->Fields('nroguia'); ?></strong></td>
  </tr>
  <tr>
    <td class="KT_th"><label for="idoperario">Cliente:</label></td>
    <td colspan="2"><?php echo $cliente->Fields('cliente'); ?></td>
    <td><?php echo $cliente->Fields('fecha'); ?>
      <input name="hiddenField" type="hidden" value="<?php echo $cliente->Fields('idsalida'); ?>"></td>
  </tr>
  
  <tr class="KT_tngtable">
    <td class="KT_th">Orden:</td>
    <td class="KT_th">Paquetes</td>
    <td class="KT_th">Und/Paq.</td>
    <td class="KT_th">Pedido N&ordm;:</td>
  </tr>
  <tr class="KT_tngtable">
    <td><select name="orden" id="orden" onChange="TCN_reload(this)">
      <option selected>orden</option>
    </select>
      <script language="JavaScript" type="text/javascript">
TCN_contents=new Array();
TCN_tempArray=new Array();
TCN_counter=0;
function TCN_addContent(str){
	TCN_contents[TCN_counter]=str;
	TCN_counter++;
}
function TCN_split(){
	TCN_arrayValues = new Array();
	for(i=0;i<TCN_contents.length;i++){
		TCN_arrayValues[i]=TCN_contents[i].split(separator);
		TCN_tempArray[0]=TCN_arrayValues;
	}
}
function TCN_makeSelValueGroup(){
	TCN_selValueGroup=new Array();
	var args=TCN_makeSelValueGroup.arguments;
	for(i=0;i<args.length;i++){
		TCN_selValueGroup[i]=args[i];
		TCN_tempArray[i]=new Array();
	}
}
function TCN_makeComboGroup(){
	TCN_comboGroup=new Array();
	var args=TCN_makeComboGroup.arguments;
	for(i=0;i<args.length;i++) TCN_comboGroup[i]=findObj(args[i]);
}
function TCN_setDefault(){
	for (i=TCN_selValueGroup.length-1;i>=0;i--){
		if(TCN_selValueGroup[i]!=""){
			for(j=0;j<TCN_contents.length;j++){
				if(TCN_arrayValues[j][(i*2)+1]==TCN_selValueGroup[i]){
					for(k=i;k>=0;k--){
						if(TCN_selValueGroup[k]=="") TCN_selValueGroup[k]=TCN_arrayValues[j][(k*2)+1];
					}
				}
			}
		}
	}
}
function TCN_loadMenu(daIndex){
	var selectionMade=false;
	daArray=TCN_tempArray[daIndex];
	TCN_comboGroup[daIndex].options.length=0;
	for(i=0;i<daArray.length;i++){
		existe=false;
		for(j=0;j<TCN_comboGroup[daIndex].options.length;j++){
			if(daArray[i][(daIndex*2)+1]==TCN_comboGroup[daIndex].options[j].value) existe=true;
		}
		if(existe==false){
			lastValue=TCN_comboGroup[daIndex].options.length;
			TCN_comboGroup[daIndex].options[TCN_comboGroup[daIndex].options.length]=new Option(daArray[i][daIndex*2],daArray[i][(daIndex*2)+1]);
			if(TCN_selValueGroup[daIndex]==TCN_comboGroup[daIndex].options[lastValue].value){
				TCN_comboGroup[daIndex].options[lastValue].selected=true;
				selectionMade=true;
			}
		}
	}
	if(selectionMade==false) TCN_comboGroup[daIndex].options[0].selected=true;
}	
function TCN_reload(from){
	if(!from){
		TCN_split();
		TCN_setDefault();
		TCN_loadMenu(0);
		TCN_reload(TCN_comboGroup[0]);
	}else{
		for(j=0; j<TCN_comboGroup.length; j++){
			if(TCN_comboGroup[j]==from) index=j+1;
		}
		if(index<TCN_comboGroup.length){
			TCN_tempArray[index].length=0;
			for(i=0;i<TCN_comboGroup[index-1].options.length;i++){
				if(TCN_comboGroup[index-1].options[i].selected==true){
					for(j=0;j<TCN_tempArray[index-1].length;j++){
						if(TCN_comboGroup[index-1].options[i].value==TCN_tempArray[index-1][j][(index*2)-1]) TCN_tempArray[index][TCN_tempArray[index].length]=TCN_tempArray[index-1][j];
					}
				}
			}
		TCN_loadMenu(index);
		TCN_reload(TCN_comboGroup[index]);
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
TCN_makeSelValueGroup("","","");
TCN_makeComboGroup("orden","packs","undpack");
 var separator="+#+";
<?php while(!$stock->EOF){?>
TCN_addContent("<?php echo $stock->Fields('idorden'); ?>+#+<?php echo $stock->Fields('idorden'); ?>+#+<?php echo $stock->Fields('packs'); ?>+#+<?php echo $stock->Fields('packs'); ?>+#+<?php echo $stock->Fields('undpack'); ?>+#+<?php echo $stock->Fields('undpack'); ?>");
<?php $stock->MoveNext();
 }
$stock->MoveFirst();
 ?>TCN_reload();

      </script></td>
    <td><select name="packs" id="packs" onChange="TCN_reload(this)">
      <option selected>packs</option>
    </select></td>
    <td><select name="undpack" id="undpack" onChange="TCN_reload(this)">
      <option selected>undpack</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="4"><input name="enviar" type="submit" id="enviar" value="Insertar Item" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<hr>
<iframe width="100%" id="the_iframe" onLoad="calcHeight();" src="verguia.php?idsali=<?php echo $idsali;?>&idlocal=<?php echo $idlocal;?>"></iframe>
</body>
</html>
<?php
$cliente->Close();
$orden->Close();

$stock->Close();
?>