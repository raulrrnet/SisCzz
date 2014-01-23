<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO detalletarifa (idtarifa, idseccion, tarifa) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['hiddenField'], "int"),
                       GetSQLValueString($_POST['seccion'], "int"),
                       GetSQLValueString($_POST['tarifa'], "double"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "detatarifa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$query_tarifa = "SELECT * FROM tarifa ORDER BY idtarifa DESC";
$tarifa = $cnx_cuzzicia->SelectLimit($query_tarifa) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tarifa = $tarifa->RecordCount();
// end Recordset

// begin Recordset
$query_seccion = "SELECT * FROM seccion ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

//keep all parameters except idtarifa
KT_keepParams('idtarifa');

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DynamicInput.js"></script>
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th"><label for="idoperario">Nombre T. :</label></td>
    <td><?php echo $tarifa->Fields('nombre'); ?></td>
  </tr>
  <tr>
    <td class="KT_th"><label for="fecha">Estado:</label></td>
    <td><?php echo $tarifa->Fields('estado'); ?></td>
  </tr>
  
  <tr>
    <td><input name="hiddenField" type="hidden" value="<?php echo $tarifa->Fields('idtarifa'); ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="idseccion">Seccion:</label></td>
    <td><select id="seccion" name="seccion" onChange="seccion_reload(this)">
      <?php
  while(!$seccion->EOF){
?>
      <option value="<?php echo $seccion->Fields('idseccion')?>"><?php echo $seccion->Fields('seccion')?></option>
      <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
?>
    </select></td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="cantidad">Tarifa:</label></td>
    <td><input type="text" name="tarifa" id="tarifa" /></td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insertar registro" />    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <th scope="col"><a href="infotiempo.php">Nuevo Informe</a></th>
    <th scope="col"><A HREF="infotarifa.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idtarifa=" . urlencode($tarifa->Fields('idtarifa')) ?>">Ver tarifa</A></th>
    <th scope="col"><input type="button" name="Submit" value="&lt;&lt; Atras" onClick="history.back()"></th>
  </tr>
</table>
</body>
</html>
<?php
$tarifa->Close();
$seccion->Close();
?>