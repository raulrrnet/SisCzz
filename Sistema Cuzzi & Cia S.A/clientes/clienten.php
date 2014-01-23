<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$clien = $_POST['cliente'];
$direc = $_POST['direccion'];
$ruc = $_POST['ruc'];
  $insertSQL = sprintf("INSERT INTO clientes (cliente, direccion, ruc) VALUES ('$clien', '$direc', $ruc) RETURNING idcliente;");
  $Result1 = $cnx_cuzzicia->Execute($insertSQL) or die($cnx_cuzzicia->ErrorMsg());
  $idcli = $Result1->Fields('idcliente');

		$inopera = "INSERT INTO gclientes (nombre) VALUES ('$clien') RETURNING idgclien;";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
		$idgcli = $inoperaex->Fields('idgclien');
		$inopera = "UPDATE clientes set idgcliente = $idgcli where idcliente = $idcli;";
		$inoperaex = $cnx_cuzzicia->Execute($inopera) or die($cnx_cuzzicia->ErrorMsg());
	//redireccionando con javascript 
		echo "<script type=\"text/javascript\"> javascript:history.go(-2) </script>";
		echo "<script type=\"text/javascript\"> javascript:window.location.reload() </script>";
	//---------------------------
}

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nuevo Cliente</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form method="post" id="form1" action="<?php echo $editFormAction; ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr valign="baseline">
      <td colspan="2" class="KT_th">Nuevo Cliente </td>
    </tr>
    <tr valign="baseline">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td class="KT_th">Cliente:</td>
      <td><input type="text" name="cliente" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td class="KT_th">Direccion:</td>
      <td><input type="text" name="direccion" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td class="KT_th">Ruc:</td>
      <td><input type="text" name="ruc" value="" size="32" /></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" /> 
</form>
<a href="vclientes.php">VER/EDITAR CLIENTES
</a>
</body>
</html>
