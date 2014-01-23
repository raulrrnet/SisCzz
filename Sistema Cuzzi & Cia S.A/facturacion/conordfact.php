<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_descripcion = "SELECT * FROM descripcion ORDER BY descripcion ASC";
$descripcion = $cnx_cuzzicia->SelectLimit($query_descripcion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_descripcion = $descripcion->RecordCount();
// end Recordset

// begin Recordset
$query_proveedor = "SELECT * FROM proveedor ORDER BY proveedor ASC";
$proveedor = $cnx_cuzzicia->SelectLimit($query_proveedor) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_proveedor = $proveedor->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturas Orden</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body>
<table height="0" border="0" cellpadding="0">
  <tr valign="top">
    <td>
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <form action="../facturacion/factorden.php" method="post" name="frm_salidas" target="idiframe" id="form1">
    <tr>
      <td colspan="2" class="KT_th">FACTURACION ORDENES </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;      </td>
    </tr>
    <tr>
      <td>Ingrese N&ordm; Orden: </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="orden" type="text" id="orden"></td>
      <td><input type="submit" name="Submit" value="Consultar"></td>
    </tr>
    <tr>
      <td colspan="2" class="KT_buttons">&nbsp;</td>
	  </tr>
    </form>
  </table>
	</td>
    <td><iframe  name="idiframe" id="idiframe" width="650" height="450" src="factorden.php">
	</iframe></td>
  </tr>
</table>
</body>
</html>
<?php
$descripcion->Close();
$proveedor->Close();
?>
