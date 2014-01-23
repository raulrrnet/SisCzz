<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "materiales")) {
  $insertSQL = sprintf("INSERT INTO matorden (idmdmat, idmddet) VALUES (%s, %s)",
                       GetSQLValueString($_POST['mate'], "int"),
                       GetSQLValueString($_POST['deta'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "mdorden.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$query_material = "SELECT * FROM mdmaterial ORDER BY material ASC";
$material = $cnx_cuzzicia->SelectLimit($query_material) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_material = $material->RecordCount();
// end Recordset

// begin Recordset
$query_mddet = "SELECT * FROM mddetalle ORDER BY detalle ASC";
$mddet = $cnx_cuzzicia->SelectLimit($query_mddet) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_mddet = $mddet->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Creaci&oacute;n de Materiales Directos</title>
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
      <td colspan="3" class="KT_th">CREACION DE MATERIALES DIRECTOS </td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Material:</td>
      <td><select name="mate" id="mate">
        <?php
  while(!$material->EOF){
?>
        <option value="<?php echo $material->Fields('idmdmat')?>"><?php echo $material->Fields('material')?></option>
        <?php
    $material->MoveNext();
  }
  $material->MoveFirst();
?>
              </select>      </td>
      <td><input name="ntipo" type="button" id="ntipo" onClick="MM_goToURL('self','mdmaterial.php');return document.MM_returnValue" value="++"></td>
    </tr>
    <tr>
      <td class="KT_th">Detalle:</td>
      <td><label>
        <select name="deta" id="deta">
          <?php
  while(!$mddet->EOF){
?>
          <option value="<?php echo $mddet->Fields('idmddet')?>"><?php echo $mddet->Fields('detalle')?></option>
          <?php
    $mddet->MoveNext();
  }
  $mddet->MoveFirst();
?>
        </select>
</label>      </td>
      <td><input name="ncategoria" type="button" id="ncategoria" onClick="MM_goToURL('self','mddeta.php');return document.MM_returnValue" value="++"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="3"><a href="javascript:close()">CERRAR</a>&nbsp;&nbsp;&nbsp;
      <input name="aceptar" type="submit" id="aceptar" value="Aceptar">      </td>
    </tr>
  </table>
<input type="hidden" name="MM_insert" value="materiales">
</form>
</body>
</html>
<?php
$material->Close();

$mddet->Close();
?>