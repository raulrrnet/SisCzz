<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

$material = '10';
if (isset($_GET['idmateriales'])) {
  $material = $_GET['idmateriales'];
}
$fecha = '2003/01/01';
if (isset($_GET['fecha'])) {
  $fecha = $_GET['fecha'];
}
$saldo = '-1';
if (isset($_GET['saldo'])) {
  $saldo = $_GET['saldo'];
}
$isaldo = '-2';
if (isset($_GET['isaldo'])) {
  $isaldo = $_GET['isaldo'];
}
// begin Recordset
$query_materiales = "SELECT * FROM materiales2";
$materiales = $cnx_cuzzicia->SelectLimit($query_materiales) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_materiales = $materiales->RecordCount();
// end Recordset
$query_difext = "SELECT * FROM diferencias WHERE idmaterial=$material and fecha='$fecha'";
$exdifext = $cnx_cuzzicia->SelectLimit($query_difext) or die($cnx_cuzzicia->ErrorMsg());
$totRows_difext = $exdifext->RecordCount();
if($totRows_difext==0){
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_diferen")) {
	$material = $_POST['unidad'];
	$fecha = $_POST['fecha'];
	$cantkar = $_POST['cantkar'];
	$cantrep = $_POST['cantrepo'];
	$fecfecha = strtotime($fecha); 
	$ano = date("Y", $fecfecha);
//consulta para obtener los valores en soles y dolares de ultima compra	
	$query_uingresos = "select *
					from movimientos
					where movimiento='Ingreso' and idmaterial=$material and
					fecha = (select max(fecha) from movimientos where movimiento='Ingreso' and idmaterial=$material)";
	$uingresos = $cnx_cuzzicia->Execute($query_uingresos) or die($cnx_cuzzicia->ErrorMsg());
	$vusolesi = $uingresos->Fields('vusoles');
	$vudolari = $uingresos->Fields('vudolar');
//sum del saldo
	$query_tingreso = "SELECT sum(saldo) FROM movimientos WHERE movimiento='Ingreso' and idmaterial = '$material' and fecha <= '$fecha' and date_part('year', fecha) = $ano;";
	$tingreso = $cnx_cuzzicia->Execute($query_tingreso) or die($cnx_cuzzicia->ErrorMsg());
//consulta de ingresos para las salidas (recorrer registro si saldo es insuficente)
	$query_ingresos = "SELECT * FROM movimientos WHERE movimiento='Ingreso' and idmaterial='$material' and fecha<='$fecha' and date_part('year',fecha)=$ano ORDER BY fecha,motivo,idmovimiento;";
	$ingresos = $cnx_cuzzicia->Execute($query_ingresos) or die($cnx_cuzzicia->ErrorMsg());
	
	$totingre = $tingreso->Fields('sum');
	$vtsoles=0;
	$vtdolares=0;
	$idingre = $ingresos->Fields('idmovimiento');
	$cantsaldo = $ingresos->Fields('saldo');
	$vusoles = $ingresos->Fields('vusoles');
	$vudolares = $ingresos->Fields('vudolar');
	$porconsu = abs($cantkar-$cantrep);
	$cantsali = $porconsu;
	$cansaltem = $cantsaldo;
	
	if($cantkar<$cantrep){
	$insvasal = "INSERT INTO diferencias (idmaterial,fecha,cantkardex,cantreport,vusoles,vudolar) VALUES ($material,'$fecha',$cantkar,$cantrep,$vusolesi,$vudolari);";
	$invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
	//redireccionando con javascript 
	echo "<script type=\"text/javascript\"> javascript:history.go(-2) </script>";
	//---------------------------
	}elseif($cantkar>$cantrep){
    if ($porconsu > $totingre) {
        $insertGoTo = "error.php";
          if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
          }
          KT_redir($insertGoTo);
        } elseif($porconsu > $cansaltem) {
            while($porconsu > $cansaltem){
            $cantsaldo = $ingresos->Fields('saldo');
            $vusoles = $ingresos->Fields('vusoles');
            $vudolares = $ingresos->Fields('vudolar');
            $cansaltem = $cantsaldo;
                if($porconsu > $cansaltem){
                $porconsu = $porconsu - $cansaltem;
                $vtsoles = $vtsoles+$cansaltem*$vusoles;
                $vtdolares = $vtdolares+$cansaltem*$vudolares;
                $cansaltem = 0;
                $ingresos->MoveNext();
                }else{
                break;
                }
            }
        $cansaltem = $cansaltem - $porconsu;
        $vtsoles = $vtsoles+$porconsu*$vusoles;
        $vtdolares = $vtdolares+$porconsu*$vudolares;
                if($porconsu==0){
                    $vusolessali = 0;
                    $vudolarsali = 0;
                }else{
                $vusolessali = $vtsoles/$cantsali;
                $vudolarsali = $vtdolares/$cantsali;
                }
            $insvasal = "INSERT INTO diferencias (idmaterial,fecha,cantkardex,cantreport,vusoles,vudolar) VALUES ($material,'$fecha',$cantkar,$cantrep,$vusolessali,$vudolarsali);";
            $invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
			//redireccionando con javascript 
			echo "<script type=\"text/javascript\"> javascript:history.go(-2) </script>";
			//---------------------------
        }
        else {
        $cansaltem = $cansaltem - $porconsu;
        $vtsoles = $vtsoles+$porconsu*$vusoles;
        $vtdolares = $vtdolares+$porconsu*$vudolares;
            if($porconsu==0){
                $vusolessali = 0;
                $vudolarsali = 0;
            }else{
            $vusolessali = $vtsoles/$cantsali;
            $vudolarsali = $vtdolares/$cantsali;
            }
        $insvasal = "INSERT INTO diferencias (idmaterial,fecha,cantkardex,cantreport,vusoles,vudolar) VALUES ($material,'$fecha',$cantkar,$cantrep,$vusolessali,$vudolarsali);";
        $invasalexc = $cnx_cuzzicia->Execute($insvasal) or die($cnx_cuzzicia->ErrorMsg());
    	//redireccionando con javascript 
		echo "<script type=\"text/javascript\"> javascript:history.go(-2) </script>";
		//---------------------------
        }
    }
}

//PHP ADODB document - made with PHAkt 3.7.1
//-------------------------------------------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_diferen" id="frm_diferen">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">INGRESO DE DIFERENCIAS</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha:</label>      </td>
      <td><label>
        <input name="fecha" type="text" id="fecha" value="<?php echo $fecha; ?>" readonly="true">
      </label></td>
    </tr>
    <tr>
      <td colspan="2"><hr />      </td>
    </tr>
    
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select name="tipo" disabled id="tipo" onChange="tipo_reload(this)">
        <option selected>tipo</option>
      </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><label>
        <select name="catego" disabled id="catego" onChange="tipo_reload(this)">
          <option selected>catego</option>
        </select>
</label>      </td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select name="material" disabled id="select27" onChange="tipo_reload(this)">
        <option selected>material</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select name="marcatipo" disabled id="select28" onChange="tipo_reload(this)">
        <option selected>marcatipo</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select name="gramcal" disabled id="select29" onChange="tipo_reload(this)">
        <option selected>gramcal</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idmaterial">Medidas:</label>      </td>
      <td><select name="medidas" disabled id="select30" onChange="tipo_reload(this)">
        <option selected>medidas</option>
      </select></td>
    </tr>
    
    
    
    <tr>
      <td class="KT_th"><label for="idseccion"></label>        Cant. Kardex:</td>
      <td><label>
        <input name="cantkar" type="text" id="cantkar" value="<?php if($saldo==''){echo $isaldo;}else{echo $saldo;}?>" readonly="true" />
        <select name="unidad" id="select31" onChange="tipo_reload(this)">
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
tipo_makeSelValueGroup("","","","","","","<?php echo $_GET['idmateriales']; ?>");
tipo_makeComboGroup("tipo","catego","material","marcatipo","gramcal","medidas","unidad");
 var separator="+#+";
<?php while(!$materiales->EOF){?>
tipo_addContent("<?php echo $materiales->Fields('tipoconsumo'); ?>+#+<?php echo $materiales->Fields('idtipoconsumo'); ?>+#+<?php echo $materiales->Fields('categoria'); ?>+#+<?php echo $materiales->Fields('idcategoria'); ?>+#+<?php echo $materiales->Fields('materiales'); ?>+#+<?php echo $materiales->Fields('idmaterial'); ?>+#+<?php echo $materiales->Fields('marcatipo'); ?>+#+<?php echo $materiales->Fields('idmarcatipo'); ?>+#+<?php echo $materiales->Fields('gramajecalibre'); ?>+#+<?php echo $materiales->Fields('idgramcal'); ?>+#+<?php echo $materiales->Fields('medida'); ?>+#+<?php echo $materiales->Fields('idmedidas'); ?>+#+<?php echo $materiales->Fields('unidad'); ?>+#+<?php echo $materiales->Fields('idmateriales'); ?>");
<?php $materiales->MoveNext();
 }
$materiales->MoveFirst();
 ?>tipo_reload();

        </script>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad"></label>      <label for="idseccion">Cant. Reportada:</label></td>
      <td><input name="cantrepo" type="text" id="cantrepo"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="frm_diferen">
</form>
</body>
</html>
}else{echo 'Ya existe un diferencia de ese material';}
<?php
$materiales->Close();
?>