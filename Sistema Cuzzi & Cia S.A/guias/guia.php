<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
//Aditional Functions
require_once('../includes/functions.inc.php');
// begin Recordset
$query_clientes = "SELECT * FROM clientes c,gclientes g WHERE c.idgcliente = g.idgclien AND (idgcliente=3 OR c.cliente=g.nombre) ORDER BY cliente";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset

// begin Recordset
$query_local = "SELECT * FROM locals";
$local = $cnx_cuzzicia->SelectLimit($query_local) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_local = $local->RecordCount();
// end Recordset
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
$serie = $_POST['serie'];
$clien = $_POST['cliente'];
$guia = $_POST['guia'];
$fec = $_POST['fecha'];
$local = $_POST['local'];
$idmotivo = $_POST['motivo'];
if($local==''){$local=0;}
  $insertSQL = sprintf("INSERT INTO salidaal (serie, nroguia, idcliente, fecha, idlocal, idmotivo) VALUES ($serie, $guia, $clien, '$fec', $local, $idmotivo) RETURNING idsalida;");
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
  $idsali = $Result1->Fields('idsalida');

  $insertGoTo = "guiadet.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?idsali=".$idsali."&idlocal=".$local;
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Guias</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_local = new WDG_JsRecordset("local");
echo $jsObject_local->getOutput();
//end JSRecordset
?>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script><?php
//begin JSRecordset
$jsObject_clientes = new WDG_JsRecordset("clientes");
echo $jsObject_clientes->getOutput();
//end JSRecordset
?>
</head>
<body>
<form action="<?php echo $editFormAction; ?>" name="form" method="POST" id="form">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="4" class="KT_th">Ingreso Guias </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td class="selected_cal">Serie:</td>
      <td colspan="3">
      <input name="serie" type="text" id="serie" value="" size="10">
      Nro:
      <input name="guia" type="text" id="guia"></td>
    </tr>
    
    <tr>
      <td class="selected_cal">Cliente:</td>
      <td class="selected_cal">
        <select name="cliente" id="cliente">
          <?php
  while(!$clientes->EOF){
?>
          <option value="<?php echo $clientes->Fields('idcliente')?>"><?php echo $clientes->Fields('cliente')?></option>
          <?php
    $clientes->MoveNext();
  }
  $clientes->MoveFirst();
?>
        </select>
      </label>
      <input name="nclient" type="button" id="nclient" onclick="self.location='../clientes/clienten.php'" value="++" />      </td>
      <td class="selected_cal">Local:</td>
      <td><label>
        <select name="local" id="local" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="local" wdg:displayfield="local" wdg:valuefield="idlocal" wdg:fkey="idcliente" wdg:triggerobject="cliente">
        </select>
      </label></td>
    </tr>
    <tr>
      <td class="selected_cal">Fecha:</td>
      <td class="selected_cal"><input name="fecha" id="fecha" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">      </td>
      <td class="selected_cal">Motivo:</td>
	  <td class="selected_cal"><select name="motivo" id="motivo">
	    <option value="1">Venta</option>
	    <option value="2" selected>Consignaci&oacute;n</option>
	    <option value="3">Biblioteca</option>
	    <option value="5">Devolución</option>
		<option value="4">Otros</option>
      </select></td>
    </tr>
    
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="4"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Continuar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form">
</form>
</body>
</html>
<?php
$clientes->Close();
$local->Close();
?>