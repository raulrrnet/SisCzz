<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');
if (isset($_GET['id'])) {
  $idorden = $_GET['id'];
}
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO detalleorden (idorden, idmatord, uso) VALUES (%s, %s, %s)",
                       GetSQLValueString($idorden, "int"),
					   GetSQLValueString($_POST['dmat'], "int"),
                       GetSQLValueString($_POST['uso'], "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "mdorden.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$query_mdirec = "SELECT * FROM mdmaterial m, mddetalle d, matorden o WHERE o.idmdmat=m.idmdmat and o.idmddet=d.idmddet ORDER BY material ASC";
$mdirec = $cnx_cuzzicia->SelectLimit($query_mdirec) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_mdirec = $mdirec->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Materiales Orden</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
//refresca la ventana madre del popup
window.opener.location.href=window.opener.location.href;
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<form name="form2" method="post" id="form1" action="<?php echo $editFormAction; ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr valign="baseline">
      <td nowrap align="right">Orden:</td>
      <td><?php echo $idorden;?></td>
    <tr valign="baseline">
      <td nowrap align="right">Material:</td>
      <td><select name="mat" id="mat" onChange="TCN_reload(this)">
          <option selected>mat</option>
        </select>
        <select name="dmat" id="dmat" onChange="TCN_reload(this)">
          <option selected>dmat</option>
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
TCN_makeComboGroup("mat","dmat");
 var separator="+#+";
<?php while(!$mdirec->EOF){?>
TCN_addContent("<?php echo $mdirec->Fields('material'); ?>+#+<?php echo $mdirec->Fields('idmdmat'); ?>+#+<?php echo $mdirec->Fields('detalle'); ?>+#+<?php echo $mdirec->Fields('idmatorden'); ?>");
<?php $mdirec->MoveNext();
 }
$mdirec->MoveFirst();
 ?>TCN_reload();

        </script>
        <input name="ntipo" type="button" id="ntipo" onClick="MM_goToURL('self','nuevomd.php');return document.MM_returnValue" value="++"></td>
    <tr valign="baseline">
      <td nowrap align="right">Uso:</td>
      <td><input type="text" name="uso" value="" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap><a href="javascript:close()">CERRAR</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
</body>
</html>
<?php
$mdirec->Close();
?>
