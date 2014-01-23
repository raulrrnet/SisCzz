<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE operario SET nombre=%s, cargo=%s, estado=%s WHERE idoperario=%s",
                       GetSQLValueString($_POST['operario'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "manteope.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}

// begin Recordset
$colname__sql = '-1';
if (isset($_GET['idope'])) {
  $colname__sql = $_GET['idope'];
}
$query_sql = sprintf("SELECT * FROM operario WHERE idoperario = %s", GetSQLValueString($colname__sql, "int"));
$sql = $cnx_cuzzicia->SelectLimit($query_sql) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_sql = $sql->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Nuevo Operario </td>
    </tr>
    <tr>
      <td class="KT_th"><input name="id" type="hidden" id="id" value="<?php echo $sql->Fields('idoperario'); ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Operario:</td>
      <td><input name="operario" type="text" id="operario" value="<?php echo $sql->Fields('nombre'); ?>" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="proveedor">Cargo:</label></td>
      <td><input name="cargo" type="text" id="cargo" value="<?php echo $sql->Fields('cargo'); ?>" /></td>
    </tr>
    <tr>
      <td class="KT_th">Estado:</td>
      <td><label> Activo
          <input <?php if (!(strcmp($sql->Fields('estado'),"A"))) {echo "CHECKED";} ?> name="estado" type="radio" value="A">
Inactivo </label>
        <label>
        <input <?php if (!(strcmp($sql->Fields('estado'),"X"))) {echo "CHECKED";} ?> name="estado" type="radio" value="X">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Grabar" />      </td>
    </tr>
  </table>
    <input type="hidden" name="MM_update" value="form">
</form>
</body>
</html>
<?php
$sql->Close();
?>