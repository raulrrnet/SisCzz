<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

// begin Recordset
$query_seccion = "SELECT * FROM seccion ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingresos</title>
</head>
<body>
<form method="post" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Drepreciacion Costo/Distribicion</td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">&nbsp;</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="descripcion">Descripcion:</label>
      </td>
      <td>
        <input type="text" name="descripcion" id="descripcion" size="32" />         
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="fecingreso">Fecingreso:</label>
      </td>
      <td>
        <input name="fecingreso" type="text" id="fecingreso" size="32" />         
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="importe">Importe:</label>
      </td>
      <td>
        <input type="text" name="importe" id="importe" size="32" />         
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="tasa">Tasa:</label>
      </td>
      <td>
        <input type="text" name="tasa" id="tasa" size="32" />
        %         </td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th">Distribici&oacute;n</td>
    </tr>
    <tr>
      <td class="KT_th"><label for="idseccion">Idseccion:</label>
      </td>
      <td>
        <select name="idseccion" id="idseccion">
        </select>
        </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="porcentaje">Porcentaje:</label>
      </td>
      <td>
        <input type="text" name="porcentaje" id="porcentaje" size="32" />         
      </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2">
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Aceptar" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
$seccion->Close();
?>
