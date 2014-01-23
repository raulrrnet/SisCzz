<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

$fecha = '2008/12/31';
if (isset($_POST['fecha'])) {
  $fec = $_POST['fecha'];
  $fecfecha = strtotime($fec); 
  $anio = date("Y",$fecfecha);
  $mes = date("m",$fecfecha);
  /*if($mes==1){
  $mes = 12;
  $anio = $anio-1;
  }else{$mes = $mes-1;}  */
  $dia = date("t",$fecfecha);
  $fecha = $anio."/".$mes."/".$dia;
}

$mes = "select date '$fecha' - interval '12 month' as mes12,date '$fecha' - interval '11 month' as mes11,date '$fecha' - interval '10 month' as mes10,date '$fecha' - interval '9 month' as mes9,date '$fecha' - interval '8 month' as mes8,date '$fecha' - interval '7 month' as mes7,date '$fecha' - interval '6 month' as mes6,date '$fecha' - interval '5 month' as mes5,date '$fecha' - interval '4 month' as mes4,date '$fecha' - interval '3 month' as mes3,date '$fecha' - interval '2 month' as mes2,date '$fecha' - interval '1 month' as mes1,date '$fecha' as mes";
$exmes = $cnx_cuzzicia->Execute($mes) or die($cnx_cuzzicia->ErrorMsg());
$mes12=date('m',strtotime($exmes->Fields('mes12')));$mes11=date('m',strtotime($exmes->Fields('mes11')));$mes10=date('m',strtotime($exmes->Fields('mes10')));$mes9=date('m',strtotime($exmes->Fields('mes9')));$mes8=date('m',strtotime($exmes->Fields('mes8')));$mes7=date('m',strtotime($exmes->Fields('mes7')));$mes6=date('m',strtotime($exmes->Fields('mes6')));$mes5=date('m',strtotime($exmes->Fields('mes5')));$mes4=date('m',strtotime($exmes->Fields('mes4')));$mes3=date('m',strtotime($exmes->Fields('mes3')));$mes2=date('m',strtotime($exmes->Fields('mes2')));$mes1=date('m',strtotime($exmes->Fields('mes1')));$mes=date('m',strtotime($exmes->Fields('mes')));
$an12=date('Y',strtotime($exmes->Fields('mes12')));$an11=date('Y',strtotime($exmes->Fields('mes11')));$an10=date('Y',strtotime($exmes->Fields('mes10')));$an9=date('Y',strtotime($exmes->Fields('mes9')));$an8=date('Y',strtotime($exmes->Fields('mes8')));$an7=date('Y',strtotime($exmes->Fields('mes7')));$an6=date('Y',strtotime($exmes->Fields('mes6')));$an5=date('Y',strtotime($exmes->Fields('mes5')));$an4=date('Y',strtotime($exmes->Fields('mes4')));$an3=date('Y',strtotime($exmes->Fields('mes3')));$an2=date('Y',strtotime($exmes->Fields('mes2')));$an1=date('Y',strtotime($exmes->Fields('mes1')));$an=date('Y',strtotime($exmes->Fields('mes')));
$fecha12=date('Y/m/d',strtotime($exmes->Fields('mes12')));$fecha11=date('Y/m/d',strtotime($exmes->Fields('mes11')));$fecha10=date('Y/m/d',strtotime($exmes->Fields('mes10')));$fecha9=date('Y/m/d',strtotime($exmes->Fields('mes9')));$fecha8=date('Y/m/d',strtotime($exmes->Fields('mes8')));$fecha7=date('Y/m/d',strtotime($exmes->Fields('mes7')));$fecha6=date('Y/m/d',strtotime($exmes->Fields('mes6')));$fecha5=date('Y/m/d',strtotime($exmes->Fields('mes5')));$fecha4=date('Y/m/d',strtotime($exmes->Fields('mes4')));$fecha3=date('Y/m/d',strtotime($exmes->Fields('mes3')));$fecha2=date('Y/m/d',strtotime($exmes->Fields('mes2')));$fecha1=date('Y/m/d',strtotime($exmes->Fields('mes1')));$fechan=date('Y/m/d',strtotime($exmes->Fields('mes')));
//----------------------------------------------------------------------------------------------------------
//costo total mano de obra
$q_costomo11 = sprintf("SELECT sum(costototal) as costotal FROM costoperario WHERE date_part('month',mes)=$mes11 and date_part('year',mes)=$an11");
$exqcostomo11 = $cnx_cuzzicia->SelectLimit($q_costomo11) or die($cnx_cuzzicia->ErrorMsg());
$totmo11 = $exqcostomo11->Fields('costotal');
//insumos
$q_insusec11 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idorden=0");
$insusec11 = $cnx_cuzzicia->SelectLimit($q_insusec11) or die($cnx_cuzzicia->ErrorMsg());
$totinsu11 = $insusec11->Fields('insu');
//electricidad
$q_facsec11 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11");
$exfacsec11 = $cnx_cuzzicia->SelectLimit($q_facsec11) or die($cnx_cuzzicia->ErrorMsg());
$totelectri11 = $exfacsec11->Fields('tiempo');
//depreciacion
$q_depsec11 = sprintf("SELECT sum(d.importe/(1/tasa*12)*porcentaje) as dep FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) and fecingreso<='$fecha11'");
$depresec11 = $cnx_cuzzicia->SelectLimit($q_depsec11) or die($cnx_cuzzicia->ErrorMsg());
$totdepre11 = $depresec11->Fields('dep');
//seguros
$q_segsec11 = sprintf("SELECT sum(prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and date_part('year',fecha)=2007");
$segusec11 = $cnx_cuzzicia->SelectLimit($q_segsec11) or die($cnx_cuzzicia->ErrorMsg());
$totseg11 = $segusec11->Fields('pm');
//mantenimiento
$q_cosmante11 = sprintf("SELECT sum(costototal) as costotal FROM costomante WHERE date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11");
$excosmante11 = $cnx_cuzzicia->SelectLimit($q_cosmante11) or die($cnx_cuzzicia->ErrorMsg());
$totmante11 = $excosmante11->Fields('costotal');
//generales planta
$q_cosgplan11 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes11 and date_part('year',mes)=$an11");
$excosgplan11 = $cnx_cuzzicia->SelectLimit($q_cosgplan11) or die($cnx_cuzzicia->ErrorMsg());
$totgp11 = $excosgplan11->Fields('costotal');
//otros Gp
$q_cosotros11 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE date_part('month',mes)=$mes11 and date_part('year',mes)=$an11");
$excosotros11 = $cnx_cuzzicia->SelectLimit($q_cosotros11) or die($cnx_cuzzicia->ErrorMsg());
$tototros11 = $excosotros11->Fields('costotal');
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body>
<form action="reptarifasec.php" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
 
  <TR>
    <TD>Fecha FIN </TD>
    <TD><label>
      <input name="fecha" id="fecha" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
    </label></TD>
  </TR>
  <TR>
    <TD>&nbsp;</TD>
    <TD><input name="mostrar" type="submit" id="fecini_btn" value="Mostrar"></TD>
  </TR>
</table>
</form>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="14" class="KT_th">TOTAL</td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th"><?php echo $mes11.'/'.$an11; ?></td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
  </tr>
  <tr>
    <td width="202" height="17" class="KT_th">MO</td>
    <td align="right"><?php echo number_format($totmo11,2);?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Insumos</td>
    <td align="right"><?php echo number_format($totinsu11,2); ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td width="202" class="KT_th">Energia Electrica </td>
      <td align="right"><?php echo number_format($totelectri11,2); ?></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
</tr>
  <tr>
    <td width="202" class="KT_th">Depreciaci&oacute;n</td>
    <td align="right"><?php echo number_format($totdepre11,2); ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
    <tr>
      <td class="KT_th">Seguros</td>
      <td align="right"><?php echo number_format($totseg11,2); ?></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
</tr>
<tr>
    <td class="KT_th">Mant. y rep.</td>
    <td align="right"><?php echo number_format($totmante11,2);?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td class="KT_th">Generales Planta</td>
    <td align="right"><?php echo number_format($totgp11,2); ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
</tr>
  <tr>
    <td class="KT_th">Otros</td>
    <td align="right"><?php echo number_format($tototros11,2); ?></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
</tr>
  <tr>
    <td class="KT_th">Total</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>