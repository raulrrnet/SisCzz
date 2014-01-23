<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO distribucions (idseguro, idseccion, porcentaje) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['idsegu'], "int"),
                       GetSQLValueString($_POST['seccion'], "int"),
                       GetSQLValueString($_POST['porcent'], "double"));

  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());

  $insertGoTo = "distrisegu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($insertGoTo);
}

// begin Recordset
$query_seccion = "SELECT * FROM seccion ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

// begin Recordset
$query_seguro = "SELECT * FROM seguros ORDER BY idseguro DESC";
$seguro = $cnx_cuzzicia->SelectLimit($query_seguro) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seguro = $seguro->RecordCount();
// end Recordset

//keep all parameters except idse
KT_keepParams('idse');

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th"><label for="idoperario">Seguro:</label>
    </td>
    <td><?php echo $seguro->Fields('seguro'); ?></td>
  </tr>
  <tr>
    <td><input name="idsegu" type="hidden" id="idsegu" value="<?php echo $seguro->Fields('idseguro'); ?>">
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="idorden">Secci&oacute;n:</label>
    </td>
    <td><label>
      <select name="seccion" id="seccion">
        <?php
  while(!$seccion->EOF){
?>
        <option value="<?php echo $seccion->Fields('idseccion')?>"><?php echo $seccion->Fields('seccion')?></option>
        <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
?>
      </select>
      </label>
    </td>
  </tr>
  <tr class="KT_tngtable">
    <td class="KT_th"><label for="tiempo">Porcentaje:</label>
    </td>
    <td><input type="text" name="porcent" id="porcent" />
    </td>
  </tr>
  <tr class="KT_buttons">
    <td colspan="2"><input name="enviar" type="submit" id="enviar" value="Insertar Registro" />
    </td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1">
</form>
<a href="repsegdist.php?<?php echo $MM_keepURL . (($MM_keepURL!="")?"&":"") . "idse=" . urlencode($seguro->Fields('idseguro')) ?>">Ver Distribuci&oacute;n del Seguro
</a>
</body>
</html>
<?php
$seccion->Close();
$seguro->Close();
?>
