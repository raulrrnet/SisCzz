<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('includes/wdg/WDG.php');

//MX Widgets3 include
require_once('includes/wdg/WDG.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_orden")) {

$detalle = "Formato: ".$_POST['formato']."\nColores: ".$_POST['ctinta']."\nMaterial: ".$_POST['material']."\nAcabados: ".$_POST['acabados']."\nOtros: ".$_POST['otros'];

$maxidord =	"select max(idorden) from orden";
$maxord = $cnx_cuzzicia->SelectLimit($maxidord) or die($cnx_cuzzicia->ErrorMsg());
$idorden = $maxord->Fields('max')+1;

  $insertSQL = sprintf("INSERT INTO orden (idorden, idcliente, idprodorden, descripcion, cantpedi, precios, preciod, fecha, pedido, detalle, observacion, fechacomp, tipoprecio) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($idorden, "int"),
					   GetSQLValueString($_POST['cliente'], "int"),
                       GetSQLValueString($_POST['tprod'], "int"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['cant'], "int"),
                       GetSQLValueString($_POST['precios'], "double"),
                       GetSQLValueString($_POST['preciod'], "double"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['pedido'], "text"),
                       GetSQLValueString($detalle, "text"),
					   GetSQLValueString($_POST['obser'], "text"),
					   GetSQLValueString($_POST['feccomp'], "date"),
					   GetSQLValueString($_POST['precio'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "ordenimp.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?idord=".$idorden;
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$query_cliente = "SELECT * FROM clientes order by cliente";
$cliente = $cnx_cuzzicia->SelectLimit($query_cliente) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cliente = $cliente->RecordCount();
// end Recordset

// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha DESC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset

// begin Recordset
$query_prodorden = "SELECT    p.idprodorden,   g.idgproduc,   g.grupop,   t.idtproduc,   t.tipop FROM   prodorden p,   gproducto g,   tproducto t WHERE   p.idgprod = g.idgproduc AND    p.idtprod = t.idtproduc";
$prodorden = $cnx_cuzzicia->SelectLimit($query_prodorden) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_prodorden = $prodorden->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nueva Orden</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="includes/wdg/classes/N1DependentField.js"></script>
<script>
 function validar(form1)
  {
       if (!form1.precio[0].checked && !form1.precio[1].checked && !form1.precio[2].checked && !form1.precio[3].checked){
            alert("Debe Seleccionar Tipo de Precio");
            return false;
        }else if(form1.precio[0].checked){
		// 	alert("Ha seleccionado: ts?");
			form1.precios.value = form1.valor.value/form1.cant.value*1000
			form1.preciod.value = form1.valor.value/form1.cant.value*1000/form1.tc.value
		//    alert("Ha seleccionado: \n" + form1.precio[0].value+form1.precios.value+form1.preciod.value);
			return true;
		}else if(form1.precio[1].checked){
		 //	alert("Ha seleccionado: td?");
			form1.preciod.value = form1.valor.value/form1.cant.value*1000
			form1.precios.value = form1.valor.value/form1.cant.value*1000*form1.tc.value
		//	alert("Ha seleccionado: \n" + form1.precio[1].value+form1.preciod.value+form1.precios.value);
	        return true;
		}else if(form1.precio[2].checked){
		 //	alert("Ha seleccionado: sm?");
			form1.precios.value = form1.valor.value
			form1.preciod.value = form1.valor.value/form1.tc.value
		//	alert("Ha seleccionado: \n" + form1.precio[2].value+form1.precios.value+form1.preciod.value);
	        return true;
		}else if(form1.precio[3].checked){
		 //	alert("Ha seleccionado: dm?");
			form1.preciod.value = form1.valor.value
			form1.precios.value = form1.valor.value*form1.tc.value
		//	alert("Ha seleccionado: \n" + form1.precio[3].value+form1.preciod.value+form1.precios.value);
	        return true;
		}
  }
</script>
<?php
//begin JSRecordset
$jsObject_tcambio = new WDG_JsRecordset("tcambio");
echo $jsObject_tcambio->getOutput();
//end JSRecordset
?>
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
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit='return validar(this)'>
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="4" class="KT_th">Abrir Orden</td>
    </tr>
    <tr>
      <td colspan="4" class="MXW_disabled">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Cliente:</td>
      <td colspan="3"><label>
        <select name="cliente" id="cliente">
          <?php
  while(!$cliente->EOF){
?>
          <option value="<?php echo $cliente->Fields('idcliente')?>"><?php echo $cliente->Fields('cliente')?></option>
<?php
    $cliente->MoveNext();
  }
  $cliente->MoveFirst();
?>
        </select>
        <input name="nclient" type="button" id="nclient" onclick="self.location='clientes/clienten.php'" value="++" />
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">T. Producto:</td>
      <td colspan="2"><select name="gprod" size="4" id="gprod" onChange="TCN_reload(this)">
        <option selected>gprod</option>
      </select>      </td>
	  <td rowspan="2"><p>&nbsp;
	    </p>
	    <p>
	      <input name="nclient2" type="button" id="nclient2" onclick="self.location='nuevoprod.php'" value="++" />
        </p></td>
    </tr>
    <tr>
      <td class="KT_th">Forma:</td>
      <td colspan="2"><select name="tprod" size="3" id="tprod" onChange="TCN_reload(this)">
          <option selected>tprod</option>
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
TCN_makeSelValueGroup("","");
TCN_makeComboGroup("gprod","tprod");
 var separator="+#+";
<?php while(!$prodorden->EOF){?>
TCN_addContent("<?php echo $prodorden->Fields('grupop'); ?>+#+<?php echo $prodorden->Fields('idgproduc'); ?>+#+<?php echo $prodorden->Fields('tipop'); ?>+#+<?php echo $prodorden->Fields('idprodorden'); ?>");
<?php $prodorden->MoveNext();
 }
$prodorden->MoveFirst();
 ?>TCN_reload();

        </script></td>
	</tr>
    <tr>
      <td class="KT_th">Descripci&oacute;n:</td>
      <td colspan="3"><textarea name="descripcion" cols="25" rows="2" id="descripcion"></textarea></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha Orden:</label>      </td>
      <td><select name="fecha" id="fecha">
        <?php
  while(!$tcambio->EOF){
?>
        <option value="<?php echo $tcambio->Fields('fecha')?>"><?php echo $tcambio->Fields('fecha')?></option>
        <?php
    $tcambio->MoveNext();
  }
  $tcambio->MoveFirst();
?>
            </select></td>
      <td class="KT_th"><label for="label">T/C:</label></td>
      <td><input name="tc" type="text" id="tc" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="tcambio" wdg:valuefield="tcambio" wdg:pkey="fecha" wdg:triggerobject="fecha" /></td>
    </tr>
    <tr>
      <td class="KT_th">Fec. Comprometida:</td>
      <td><input name="feccomp" id="feccomp" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no" wdg:readonly="true" /></td>
      <td rowspan="3" class="KT_th">Precio:</td>
      <td rowspan="3">
        <input type="radio" name="precio" value="totalsoles">T. Soles
        <input type="radio" name="precio" value="totaldolar">T. Dolar
        <br>
        <input type="radio" name="precio" value="solesmillar">S/.x Millar
        <input type="radio" name="precio" value="dolarmillar">$.x Millar
        <br>
        <input type="text" name="valor" id="valor"/>
        <input name="precios" type="hidden" id="precios">
        <input name="preciod" type="hidden" id="preciod"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">N&deg;Pedido:</label></td>
      <td><input type="text" name="pedido" id="orden3" /></td>
    </tr>
    <tr>
      <td class="KT_th">Cantidad:</td>
      <td valign="middle"><input type="text" name="cant" id="cant" /></td>
    </tr>
    <tr>
      <td colspan="4" class="KT_th">Detalles: (Descripci&oacute;n Larga)</td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td class="KT_th">Material: </td>
      <td colspan="2"><label>
        <textarea name="material" rows="2" id="material"></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td class="KT_th">Formato:</td>
      <td colspan="2"><label>
        <textarea name="formato" rows="2" id="formato"></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td class="KT_th">Colores Tinta:</td>
      <td colspan="2"><label>
        <textarea name="ctinta" rows="2" id="ctinta"></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td class="KT_th">Acabados:</td>
      <td colspan="2"><textarea name="acabados" rows="2" id="acabados"></textarea></td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td class="KT_th">Otros:</td>
      <td colspan="2"><label>
        <textarea name="otros" rows="2" id="otros"></textarea>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Observaciones:</td>
      <td colspan="3" class="KT_th"><textarea name="obser" cols="40" rows="2" id="obser"></textarea></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="4"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="frm_orden">
</form>
</body>
</html>
<?php
$cliente->Close();

$tcambio->Close();

$prodorden->Close();
?>