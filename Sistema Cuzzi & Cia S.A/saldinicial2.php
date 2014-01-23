<?php
//Aditional Functions
require_once('includes/functions.inc.php');
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');

$ano = date("Y")-1;
$ano2 = date("Y");
$fecha = "$ano2/01/01";
$qsaldoini = "SELECT * FROM v_saldoinicial WHERE saldo<>0";
$saldosini = $cnx_cuzzicia->Execute($qsaldoini) or die($cnx_cuzzicia->ErrorMsg());
	
//ingreso de saldos iniciales
	while (!$saldosini->EOF) {
		$material = $saldosini->Fields('idmaterial');
		$saldo = $saldosini->Fields('saldo');
		$vusoles = $saldosini->Fields('totals')/$saldo;
		$vudolar = $saldosini->Fields('totald')/$saldo;
		$upingresos = "INSERT INTO movimientos (movimiento,idmaterial,fecha,motivo,cantidad,saldo,vusoles,vudolar) VALUES ('Ingreso',$material,'$fecha','1Saldo Inicial',$saldo,$saldo,$vusoles,$vudolar);";
		$upingreexc = $cnx_cuzzicia->Execute($upingresos) or die($cnx_cuzzicia->ErrorMsg());
		//echo $material."<br>";
		$saldosini->MoveNext();
	}
/*redireccionando con javascript 
 echo "<script type=\"text/javascript\"> javascript:history.go(-2) </script>";*/
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>-</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th">SALDOS INICIALES </td>
    </tr>
    <tr>
      <td>los saldos se corrieron correctamente </td>
    </tr>
    <tr class="KT_buttons">
      <td>&nbsp;</td>
    </tr>
  </table>
</body>
</html>