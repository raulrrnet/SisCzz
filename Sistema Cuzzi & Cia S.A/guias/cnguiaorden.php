<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturas Orden</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table height="0" border="0" cellpadding="0">
  <tr valign="top">
    <td>
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <form action="../guias/guiaorden.php" method="post" name="frm_salidas" target="idiframe" id="form1">
    <tr>
      <td colspan="2" class="KT_th">GUIAS ORDENES </td>
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
    <td><iframe  name="idiframe" id="idiframe" width="650" height="450" src="guiaorden.php">
	</iframe></td>
  </tr>
</table>
</body>
</html>