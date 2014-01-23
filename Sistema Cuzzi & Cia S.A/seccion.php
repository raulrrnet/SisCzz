<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO seccion (seccion, unidad, status, potencia) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['seccion'], "text"),
                       GetSQLValueString($_POST['unidad'], "text"),
					   GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['pot'], "text"));
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

	$qseccion = "SELECT * FROM seccion ORDER BY idseccion desc";
	$excseccion = $cnx_cuzzicia->Execute($qseccion) or die($cnx_cuzzicia->ErrorMsg());
	$idsec = $excseccion->Fields('idseccion');
	
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,1);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,2);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,3);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,4);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,1,8);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,2,0);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$inopera = "INSERT INTO operaciones (idseccion,iddestino,idoperacion) VALUES ($idsec,3,5);";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "seccion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" name="form2" method="POST" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Ingrese Secci&oacute;n </td>
    </tr>
    <tr>
      <td class="KT_th">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="label">Seccion:</label></td>
      <td><input type="text" name="seccion" id="seccion" /></td>
    </tr>
    <tr>
      <td class="KT_th">Unidad:</td>
      <td><label>
      <input name="unidad" type="text" id="unidad" size="12">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Status:</td>
      <td><select name="status" size="2" id="status">
        <option selected="selected">Vigente</option>
        <option value="x">No Vigente</option>
      </select></td>
    </tr>
    <tr>
      <td class="KT_th">Potencia:</td>
      <td><label>
        <input name="pot" type="text" id="pot">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Ingresar" />      </td>
    </tr>
  </table>
  
  <input type="hidden" name="MM_insert" value="form2">
</form>
<a href="tarifas/msecciones.php">Ver Secciones</a>
</body>
</html>