<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// begin Recordset
$query_img = "SELECT * FROM pruebas";
$img = $cnx_cuzzicia->SelectLimit($query_img) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_img = $img->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

//Guardar imagen
if(is_uploaded_file($_FILES['imagen']['tmp_name'])) { // verifica haya sido cargado el archivo
$ruta= "images/".$_FILES['imagen']['name'];
move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
}

  $insertSQL = sprintf("INSERT INTO pruebas (text, imagen) VALUES (%s, %s)",
                       GetSQLValueString($_POST['text'], "text"),
                       GetSQLValueString($ruta, "text"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "phpinfo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1

//$insertSQL = "UPDATE clientes SET direccion="qqq" where idcliente=56";
//$Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
//phpinfo();
?>
<html>
<head>
<title>zzz</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1" enctype="multipart/form-data">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="text">Text:</label></td>
      <td><input type="text" name="text" id="text" size="32" /></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="imagen">Imagen:</label></td>
      <td><input type="file" name="imagen" id="imagen" size="32" /></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insertar registro" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<table width="50%" border="1" cellspacing="0" cellpadding="0">
  <?php
  while (!$img->EOF) { 
?>
    <tr>
      <td><?php echo $img->Fields('text'); ?></td>
      <td><embed src="<?php echo $img->Fields('imagen'); ?>" width="auto" height="auto"> </td>
    </tr>
    <?php
    $img->MoveNext(); 
  }
?>
</table>
<?php
$let = 'Fábrica';
echo utf8_decode ($let);
?>
</body>
</html>
<?php
$img->Close();
?>