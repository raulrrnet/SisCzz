<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE seccion SET seccion=%s, unidad=%s, status=%s, potencia=%s WHERE idseccion=%s",
                       GetSQLValueString($_POST['seccion'], "text"),
                       GetSQLValueString($_POST['unidad'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['pot'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "tarifas/msecciones.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$colname__seccion = '-1';
if (isset($_GET['idsec'])) {
  $colname__seccion = $_GET['idsec'];
}
$query_seccion = sprintf("SELECT * FROM seccion WHERE idseccion = %s", GetSQLValueString($colname__seccion, "int"));
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Modificar Secci&oacute;n </td>
    </tr>
    <tr>
      <td class="KT_th"><input name="id" type="hidden" id="id"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">Seccion:</label></td>
      <td><input name="seccion" type="text" id="seccion" value="<?php echo $seccion->Fields('seccion'); ?>" size="40" /></td>
    </tr>
    <tr>
      <td class="KT_th">Unidad:</td>
      <td><label>
      <input name="unidad" type="text" id="unidad" value="<?php echo $seccion->Fields('unidad'); ?>" size="12">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Status:</td>
      <td><select name="status" size="2" id="status">
        <option selected="selected" value="" <?php if (!(strcmp("", $seccion->Fields('status')))) {echo "SELECTED";} ?>>Vigente</option>
        <option value="x" <?php if (!(strcmp("x", $seccion->Fields('status')))) {echo "SELECTED";} ?>>No Vigente</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Potencia:</td>
      <td><label>
        <input name="pot" type="text" id="pot" value="<?php echo $seccion->Fields('potencia'); ?>">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_update" value="form2">
</form>
</body>
</html>
<?php
$seccion->Close();
?>