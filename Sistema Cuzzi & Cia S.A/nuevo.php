<?php
//Aditional Functions
require_once('includes/functions.inc.php');

//Connection statement
require_once('Connections/cnx_cuzzicia.php');

// begin Recordset
$query_categoria = "SELECT * FROM categoria ORDER BY categoria ASC";
$categoria = $cnx_cuzzicia->SelectLimit($query_categoria) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_categoria = $categoria->RecordCount();
// end Recordset

// begin Recordset
$query_material = "SELECT * FROM material ORDER BY materiales ASC";
$material = $cnx_cuzzicia->SelectLimit($query_material) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_material = $material->RecordCount();
// end Recordset

// begin Recordset
$query_marcatipo = "SELECT * FROM marcatipo ORDER BY marcatipo ASC";
$marcatipo = $cnx_cuzzicia->SelectLimit($query_marcatipo) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_marcatipo = $marcatipo->RecordCount();
// end Recordset

// begin Recordset
$query_gramcal = "SELECT * FROM gramajecalibre ORDER BY gramajecalibre ASC";
$gramcal = $cnx_cuzzicia->SelectLimit($query_gramcal) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_gramcal = $gramcal->RecordCount();
// end Recordset

// begin Recordset
$query_medidas = "SELECT * FROM medidas ORDER BY medida ASC";
$medidas = $cnx_cuzzicia->SelectLimit($query_medidas) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_medidas = $medidas->RecordCount();
// end Recordset

// begin Recordset
$query_unidad = "SELECT * FROM unidad ORDER BY unidad ASC";
$unidad = $cnx_cuzzicia->SelectLimit($query_unidad) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_unidad = $unidad->RecordCount();
// end Recordset

// begin Recordset
$query_tipo = "SELECT * FROM tipoconsumo";
$tipo = $cnx_cuzzicia->SelectLimit($query_tipo) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_tipo = $tipo->RecordCount();
// end Recordset

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "materiales")) {
	$tipo = $_POST['tipo'];
	$cate = $_POST['categoria'];
	$mate = $_POST['material'];
	$marcatipo = $_POST['marcatipo'];
	$gramcal = $_POST['gramcal'];
	$medi = $_POST['medidas'];
	$uni = $_POST['unidad'];
	$diasrepo = $_POST['diasrepo'];
  $insertSQL = "INSERT INTO materiales (idtipoconsumo, idcategoria, idmaterial, idmarcatipo, idgramcal, idmedidas, idunidad, diasrepo) VALUES ($tipo, $cate, $mate, $marcatipo, $gramcal, $medi, $uni, $diasrepo)";
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

$selectSQL = "select tipoconsumo||' / '||categoria||' / '||materiales||' / '||marcatipo||' / '||gramajecalibre||' / '||medida||' / '||unidad as tmateriales from materiales2 where idtipoconsumo=$tipo and idcategoria=$cate and idmaterial=$mate and idmarcatipo=$marcatipo and idgramcal=$gramcal and idmedidas=$medi and idunidad=$uni";
  $Result2 = $cnx_cuzzicia->Execute($selectSQL) or die($cnx_cuzzicia->ErrorMsg());
  $materialc = $Result2->Fields('tmateriales');
mail('mario@cuzzinet.com','nuevo material','se creo ^ ',$materialc);
mail('sistemas@cuzzi.net','Nuevo material','se creo ^ ',$materialc);
  $insertGoTo = "nuevo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.6.0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Creaci&oacute;n de Materiales</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="materiales" id="form1">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="3" class="KT_th">CREACION DE MATERIALES</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Tipo:</td>
      <td><select name="tipo" id="tipo">
      <?php
  while(!$tipo->EOF){
?>
      <option value="<?php echo $tipo->Fields('idtipoconsumo')?>"><?php echo $tipo->Fields('tipoconsumo')?></option>
      <?php
    $tipo->MoveNext();
  }
  $tipo->MoveFirst();
?>
              </select>      </td>
      <td><input name="ntipo" type="button" id="ntipo" onClick="MM_goToURL('self','tipo.php');return document.MM_returnValue" value="Nuevo"></td>
    </tr>
    <tr>
      <td class="KT_th">Categoria:</td>
      <td><label>
        <select name="categoria" id="categoria">
          <?php
  while(!$categoria->EOF){
?>
          <option value="<?php echo $categoria->Fields('idcategoria')?>"><?php echo $categoria->Fields('categoria')?></option>
          <?php
    $categoria->MoveNext();
  }
  $categoria->MoveFirst();
?>
        </select>
</label>      </td>
      <td><input name="ncategoria" type="button" id="ncategoria" onClick="MM_goToURL('self','categoria.php');return document.MM_returnValue" value="Nuevo"></td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select name="material" id="select2">
        <?php
  while(!$material->EOF){
?>
        <option value="<?php echo $material->Fields('idmaterial')?>"><?php echo $material->Fields('materiales')?></option>
        <?php
    $material->MoveNext();
  }
  $material->MoveFirst();
?>
      </select></td>
      <td><input name="nmaterial" type="button" id="nmaterial" onClick="MM_goToURL('self','material.php');return document.MM_returnValue" value="Nuevo">      </td>
    </tr>
    <tr>
      <td class="KT_th">Marca/Tipo:</td>
      <td><select name="marcatipo" id="select3">
        <?php
  while(!$marcatipo->EOF){
?>
        <option value="<?php echo $marcatipo->Fields('idmarcatipo')?>"><?php echo $marcatipo->Fields('marcatipo')?></option>
        <?php
    $marcatipo->MoveNext();
  }
  $marcatipo->MoveFirst();
?>
      </select></td>
      <td><input name="nmarcatipo" type="button" id="nmarcatipo" onClick="MM_goToURL('self','marcatipo.php');return document.MM_returnValue" value="Nuevo"></td>
    </tr>
    <tr>
      <td class="KT_th">Gramaje/Calibre:</td>
      <td><select name="gramcal" id="select4">
        <?php
  while(!$gramcal->EOF){
?>
        <option value="<?php echo $gramcal->Fields('idgramcal')?>"><?php echo $gramcal->Fields('gramajecalibre')?></option>
        <?php
    $gramcal->MoveNext();
  }
  $gramcal->MoveFirst();
?>
      </select></td>
      <td><input name="ngramcal" type="button" id="ngramcal" onClick="MM_goToURL('self','gramcal.php');return document.MM_returnValue" value="Nuevo">      </td>
    </tr>
    <tr>
      <td class="KT_th">Medidas:</td>
      <td><select name="medidas" id="select5">
        <?php
  while(!$medidas->EOF){
?>
        <option value="<?php echo $medidas->Fields('idmedida')?>"><?php echo $medidas->Fields('medida')?></option>
        <?php
    $medidas->MoveNext();
  }
  $medidas->MoveFirst();
?>
      </select></td>
      <td><input name="nmedida" type="button" id="nmedida" onClick="MM_goToURL('self','medida.php');return document.MM_returnValue" value="Nuevo">      </td>
    </tr>
    <tr>
      <td class="KT_th">Unidad:</td>
      <td><select name="unidad" id="unidad">
        <?php
  while(!$unidad->EOF){
?>
        <option value="<?php echo $unidad->Fields('idunidad')?>"><?php echo $unidad->Fields('unidad')?></option>
        <?php
    $unidad->MoveNext();
  }
  $unidad->MoveFirst();
?>
      </select></td>
      <td><input name="nunidad" type="button" id="nunidad" onClick="MM_goToURL('self','unidad.php');return document.MM_returnValue" value="Nuevo"></td>
    </tr>
    <tr>
      <td class="KT_th">Dias Reposici&oacute;n</td>
      <td><label>
        <input name="diasrepo" type="text" id="diasrepo" value="0">
      </label></td>
      <td>*opc</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="3">
        <input name="cancelar" type="reset" id="cancelar" value="Cancelar">
		<input name="aceptar" type="submit" id="aceptar" value="Aceptar">      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="materiales">
</form>
</body>
</html>
<?php
$categoria->Close();

$material->Close();

$marcatipo->Close();

$gramcal->Close();

$medidas->Close();

$unidad->Close();

$tipo->Close();
?>
