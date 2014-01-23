<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_tcambio = "SELECT * FROM tipocambio ORDER BY fecha ASC";
$tcambio = $cnx_cuzzicia->SelectLimit($query_tcambio) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tcambio = $tcambio->RecordCount();
// end Recordset
// begin Recordset
$query_proveedor = "SELECT * FROM proveedor ORDER BY proveedor ASC";
$proveedor = $cnx_cuzzicia->SelectLimit($query_proveedor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_proveedor = $proveedor->RecordCount();
// end Recordset
// begin Recordset
$query_descripcion = "SELECT * FROM descripcion ORDER BY descripcion ASC";
$descripcion = $cnx_cuzzicia->SelectLimit($query_descripcion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_descripcion = $descripcion->RecordCount();
// end Recordset
// begin Recordset
$colname__actuterce = '-1';
if (isset($_GET['idterce'])) {
  $colname__actuterce = $_GET['idterce'];
}
$query_actuterce = sprintf("SELECT * FROM trabterceros WHERE idterceros = %s", GetSQLValueString($colname__actuterce, "int"));
$actuterce = $cnx_cuzzicia->SelectLimit($query_actuterce) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_actuterce = $actuterce->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_ingresos")) {
  $updateSQL = sprintf("UPDATE trabterceros SET iddescrip=%s, idproveedor=%s, fecha=%s, referencia=%s, idorden=%s, cantidad=%s, valorus=%s, valorud=%s WHERE idterceros=%s",
                       GetSQLValueString($_POST['descrip'], "int"),
                       GetSQLValueString($_POST['proveedor'], "int"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['orden'], "int"),
                       GetSQLValueString($_POST['cant'], "int"),
                       GetSQLValueString($_POST['valorsoles'], "double"),
                       GetSQLValueString($_POST['valordolar'], "double"),
                       GetSQLValueString($_POST['hiddenField'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "resulterce.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Trabajo Terceros</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/N1DependentField.js"></script>
<?php
//begin JSRecordset
$jsObject_tcambio = new WDG_JsRecordset("tcambio");
echo $jsObject_tcambio->getOutput();
//end JSRecordset
?>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="frm_ingresos" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">MODIFICAR TRABAJO TERCEROS 
        <input name="hiddenField" type="hidden" value="<?php echo $actuterce->Fields('idterceros'); ?>"></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
      <td class="KT_th">Descripci&oacute;n:</td>
      <td><select id="select2" name="descrip" onChange="tipoconsumo_reload(this)">
        <?php
  while(!$descripcion->EOF){
?>
        <option value="<?php echo $descripcion->Fields('iddescrip')?>"<?php if (!(strcmp($descripcion->Fields('iddescrip'), $actuterce->Fields('iddescrip')))) {echo "SELECTED";} ?>><?php echo $descripcion->Fields('descripcion')?></option>
        <?php
    $descripcion->MoveNext();
  }
  $descripcion->MoveFirst();
?>
      </select>
        <label>
        <input name="ndescrip" type="button" id="ndescrip" value="++" onClick="top.location='descripcion.php'">
      </label></td>
    </tr>
    
    <tr>
      <td class="KT_th">Proveedor:</td>
      <td><select name="proveedor" id="proveedor">
        <?php
  while(!$proveedor->EOF){
?>
        <option value="<?php echo $proveedor->Fields('idproveedor')?>"<?php if (!(strcmp($proveedor->Fields('idproveedor'), $actuterce->Fields('idproveedor')))) {echo "SELECTED";} ?>><?php echo $proveedor->Fields('proveedor')?></option>
        <?php
    $proveedor->MoveNext();
  }
  $proveedor->MoveFirst();
?>
      </select>
   <input name="nprov" type="button" id="nprov" value="++" onClick="top.location='../proveedor.php'"></td>
    </tr>
    
    <tr>
      <td class="KT_th"><label for="fecha"> Fecha T/C:</label>      </td>
      <td>
        <select name="fecha" id="fecha">
          <?php
  while(!$tcambio->EOF){
?>
          <option value="<?php echo $tcambio->Fields('fecha')?>"<?php if (!(strcmp($tcambio->Fields('fecha'), $actuterce->Fields('fecha')))) {echo "SELECTED";} ?>><?php echo $tcambio->Fields('fecha')?></option>
          <?php
    $tcambio->MoveNext();
  }
  $tcambio->MoveFirst();
?>
        </select>
        <input name="feccambio" type="text" id="feccambio" size="10" wdg:subtype="N1DependentField" wdg:type="widget" wdg:recordset="tcambio" wdg:valuefield="tcambio" wdg:pkey="fecha" wdg:triggerobject="fecha">
        <input name="tcambio" type="button" id="tcambio" onClick="top.location='../tcambio.php'" value="++"></td>
    </tr>
    
    <tr>
      <td class="KT_th">Referencia:</td>
      <td><input name="referencia" type="text" id="referencia" value="<?php echo $actuterce->Fields('referencia'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th">Orden:</td>
      <td><input name="orden" type="text" id="orden" value="<?php echo $actuterce->Fields('idorden'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="cantidad">Cantidad:</label>      </td>
      <td><input name="cant" type="text" id="cant" value="<?php echo $actuterce->Fields('cantidad'); ?>"></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="valorusoles">ValorSoles:</label></td>
      <td>
        <input name="valorsoles" type="text" id="valorsoles" value="<?php echo $actuterce->Fields('valorus'); ?>">
        <span class="Estilo1">Ingresar</span> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="valorudolar">ValorDolar:</label></td>
      <td><input name="valordolar" type="text" id="valordolar" value="<?php echo $actuterce->Fields('valorud'); ?>">
        <span class="Estilo1">Ambos</span></td>
    </tr>
    

    <tr>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input name="KT_Insert1" type="submit" id="KT_Insert1" value="Actualizar"/>      </td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_update" value="frm_ingresos">
</form>
</body>
</html>
<?php
$tcambio->Close();
$proveedor->Close();
$descripcion->Close();
$actuterce->Close();
?>