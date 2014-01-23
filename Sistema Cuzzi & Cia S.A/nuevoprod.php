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
  $insertSQL = sprintf("INSERT INTO prodorden (idgprod, idtprod) VALUES (%s, %s)",
                       GetSQLValueString($_POST['gprod'], "int"),
                       GetSQLValueString($_POST['tprod'], "int"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "orden.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$query_material = "SELECT * FROM gproducto ORDER BY grupop ASC";
$material = $cnx_cuzzicia->SelectLimit($query_material) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_material = $material->RecordCount();
// end Recordset

// begin Recordset
$query_mddet = "SELECT * FROM tproducto ORDER BY tipop ASC";
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
      <td colspan="3" class="KT_th">CREACION DE NUEVOS PRODUCTOS </td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th">Grupo Prod.:</td>
      <td><select name="gprod" id="gprod">
        <?php
  while(!$material->EOF){
?>
        <option value="<?php echo $material->Fields('idgproduc')?>"><?php echo $material->Fields('grupop')?></option>
<?php
    $material->MoveNext();
  }
  $material->MoveFirst();
?>
              </select>      </td>
      <td><input name="ngrupo" type="button" id="ngrupo" onClick="MM_goToURL('self','gprod.php');return document.MM_returnValue" value="++"></td>
    </tr>
    <tr>
      <td class="KT_th">Tipo Prod.:</td>
      <td><label>
        <select name="tprod" id="tprod">
          <?php
  while(!$mddet->EOF){
?>
          <option value="<?php echo $mddet->Fields('idtproduc')?>"><?php echo $mddet->Fields('tipop')?></option>
          <?php
    $mddet->MoveNext();
  }
  $mddet->MoveFirst();
?>
        </select>
</label>      </td>
      <td><input name="ntipo" type="button" id="ntipo" onClick="MM_goToURL('self','tprod.php');return document.MM_returnValue" value="++"></td>
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
$material->Close();

$mddet->Close();
?>