<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_descripcion = "SELECT * FROM descripcion ORDER BY descripcion ASC";
$descripcion = $cnx_cuzzicia->SelectLimit($query_descripcion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_descripcion = $descripcion->RecordCount();
// end Recordset

// begin Recordset
$query_proveedor = "SELECT * FROM proveedor ORDER BY proveedor ASC";
$proveedor = $cnx_cuzzicia->SelectLimit($query_proveedor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_proveedor = $proveedor->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consulta Compras</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
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
    <td>
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <form action="desterce.php" method="post" name="frm_salidas" target="idiframe" id="form1">
    <tr>
      <td colspan="2" class="KT_th">SELECCIONE</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;      </td>
    </tr>
    <tr>
      <td class="KT_th">Proveedor:</td>
      <td><label>
        <select name="proveedor" id="proveedor">
          <?php
  while(!$proveedor->EOF){
?>
          <option value="<?php echo $proveedor->Fields('idproveedor')?>"><?php echo $proveedor->Fields('proveedor')?></option>
          <?php
    $proveedor->MoveNext();
  }
  $proveedor->MoveFirst();
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Descrici&oacute;n:</label>      </td>
      <td><select name="descrip" id="descrip">
          <option value="-">-Seleccione uno-</option>
          <?php
  while(!$descripcion->EOF){
?><option value="<?php echo $descripcion->Fields('iddescrip')?>"><?php echo $descripcion->Fields('descripcion')?></option>
          <?php
    $descripcion->MoveNext();
  }
  $descripcion->MoveFirst();
?>
        </select>      </td>
    </tr>
    <tr>
      <td class="KT_th">Orden:</td>
      <td><label>
        <input name="orden" type="text" id="orden">
      </label></td>
    </tr>
    
    <tr>
      <td class="KT_th"><label for="motivo">Fecha Inicio:</label>      </td>
      <td><input name="fecini" id="fecini" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecha">Fecha Fin:</label>      </td>
      <td>
        <input name="fecfin" id="fecfin" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" />      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="reset" name="cancel" id="cancel" value="Cancelar" />
        <input name="KT_Insert1" type="submit" id="KT_Insert1" onClick="MM_validateForm('fecini','','R','fecfin','','R');return document.MM_returnValue" value="Buscar" />      </td>
    </tr></form>
  </table>
	</td>
    <td><iframe  name="idiframe" id="idiframe" width="545" height="405" src="desterce.php">
	</iframe></td>
  </tr>
</table>
</body>
</html>
<?php
$descripcion->Close();
$proveedor->Close();
?>
