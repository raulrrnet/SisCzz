<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');

$fec = '2003/01/01';
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
}

// begin Recordset
$fali = sprintf("select sum(cantidad*vusoles) as mas from movimientos where fecha='$fec' and motivo='6Ajuste' and movimiento='Ingreso'");
$faliex = $cnx_cuzzicia->SelectLimit($fali) or die($cnx_cuzzicia->ErrorMsg());
// end Recordset
// begin Recordset
$fals = sprintf("select sum(cantidad*vusoles) as menos from movimientos where fecha='$fec' and motivo='6Ajuste' and movimiento='Salida'");
$falsex = $cnx_cuzzicia->SelectLimit($fals) or die($cnx_cuzzicia->ErrorMsg());
// end Recordset

// begin Recordset
$falid = sprintf("select sum(cantidad*vudolar) as mas from movimientos where fecha='$fec' and motivo='6Ajuste' and movimiento='Ingreso'");
$falidex = $cnx_cuzzicia->SelectLimit($falid) or die($cnx_cuzzicia->ErrorMsg());
// end Recordset
// begin Recordset
$falsd = sprintf("select sum(cantidad*vudolar) as menos from movimientos where fecha='$fec' and motivo='6Ajuste' and movimiento='Salida'");
$falsdex = $cnx_cuzzicia->SelectLimit($falsd) or die($cnx_cuzzicia->ErrorMsg());
// end Recordset

//PHP ADODB document - made with PHAkt 3.6.0
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
<table width="100%" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td colspan="2">FALLAS DE INVENTARIO S/. AL <?php echo $fec; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>FALLA + </td>
        <td align="right">S/.<?php echo number_format($faliex->Fields('mas'),2); ?></td>
      </tr>
      <tr>
        <td>FALLA  - </td>
        <td align="right">S/.<?php echo number_format($falsex->Fields('menos'),2); ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>DIF. INVENT. </td>
        <td align="right">S/.<?php echo number_format(($faliex->Fields('mas')-$falsex->Fields('menos')),2); ?></td>
      </tr>
    </table></td>
    <td align="center"><table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td colspan="2">FALLAS DE INVENTARIO $. AL <?php echo $fec; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>FALLA + </td>
        <td align="right">$.<?php echo number_format($falidex->Fields('mas'),2); ?></td>
      </tr>
      <tr>
        <td>FALLA  - </td>
        <td align="right">$.<?php echo number_format($falsdex->Fields('menos'),2); ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>DIF. INVENT. </td>
        <td align="right">$.<?php echo number_format(($falidex->Fields('mas')-$falsdex->Fields('menos')),2); ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
