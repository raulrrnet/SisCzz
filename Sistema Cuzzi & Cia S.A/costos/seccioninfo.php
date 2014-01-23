<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_seccion = "SELECT * FROM seccion WHERE status <> 'x' ORDER BY seccion ASC";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1

$fecha = '2001/01/01';
if (isset($_POST['fecha'])) {
  $fecha = $_POST['fecha'];
}
$fecfecha = strtotime($fecha); 

//$fecha = date("Y/m/d");
$anio = date("Y",$fecfecha);
$anio2 = $anio;
$mes = date("m",$fecfecha);
$mes1 = $mes - 1;
$mes2 = $mes - 2;
$mesf = date("t",$fecfecha);
$dia = date("d",$fecfecha);
$semini = $dia - date("N",$fecfecha);
if($semini <= 0){
	$semini = 1;
}
$fecsemana = $anio."/".$mes."/".$semini;
$fecmes = $anio."/".$mes."/01";
if($mes1 =='1'){
	$mes2 = 12;
	$anio2 = $anio - 1;
}if($mes1 =='0'){
	$mes1 = 12;
	$mes2 = 11;
	$anio2 = $anio - 1;
}
$idsec = '0';
if (isset($_POST['idsec'])){
  $idsec = $_POST['idsec'];}
$query_prepa = sprintf("SELECT seccion,sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and operacion = 'Preparacion' GROUP BY seccion");
$cnprepa = $cnx_cuzzicia->SelectLimit($query_prepa) or die($cnx_cuzzicia->ErrorMsg());
$query_produ = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and operacion = 'Produccion'");
$cnprodu = $cnx_cuzzicia->SelectLimit($query_produ) or die($cnx_cuzzicia->ErrorMsg());
$query_limpi = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and operacion = 'Limpieza'");
$cnlimpi = $cnx_cuzzicia->SelectLimit($query_limpi) or die($cnx_cuzzicia->ErrorMsg());
$query_tproduc = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and (operacion = 'Preparacion' or operacion = 'Produccion' or operacion = 'Limpieza')");
$cntproduc = $cnx_cuzzicia->SelectLimit($query_tproduc) or die($cnx_cuzzicia->ErrorMsg());

$query_espec = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and idoperacion = 4");
$cnespec = $cnx_cuzzicia->SelectLimit($query_espec) or die($cnx_cuzzicia->ErrorMsg());
$query_espem = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and idoperacion = 6");
$cnespem = $cnx_cuzzicia->SelectLimit($query_espem) or die($cnx_cuzzicia->ErrorMsg());
$query_mante = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and idoperacion = 5");
$cnmante = $cnx_cuzzicia->SelectLimit($query_mante) or die($cnx_cuzzicia->ErrorMsg());
$query_tinproduc = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec and (idoperacion = 4 or idoperacion = 5 or idoperacion = 6)");
$cntinproduc = $cnx_cuzzicia->SelectLimit($query_tinproduc) or die($cnx_cuzzicia->ErrorMsg());

$query_cantp = sprintf("SELECT sum(case when(fecha='$fecha') then(cantidad) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(cantidad) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(cantidad) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(cantidad) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(cantidad) end) as mes2 FROM v_informes WHERE idseccion = $idsec and operacion = 'Produccion'");
$cncantp = $cnx_cuzzicia->SelectLimit($query_cantp) or die($cnx_cuzzicia->ErrorMsg());
$query_prodh = sprintf("SELECT sum(case when(fecha='$fecha' and idoperacion=2) then(cantidad) end)/sum(case when(fecha='$fecha' and idoperacion=2) then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha' and idoperacion=2) then(cantidad) end)/sum(case when(fecha between '$fecsemana' and '$fecha' and idoperacion=2) then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha' and idoperacion=2) then(cantidad) end)/sum(case when(fecha between '$fecmes' and '$fecha' and idoperacion=2) then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and idoperacion=2) then(cantidad) end)/sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and idoperacion=2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and idoperacion=2) then(cantidad) end)/sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and idoperacion=2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec");
$cnprodh = $cnx_cuzzicia->SelectLimit($query_prodh) or die($cnx_cuzzicia->ErrorMsg());
$query_efipro = sprintf("SELECT sum(case when(fecha='$fecha' and idoperacion=2) then(tiempo) end)/sum(case when(fecha='$fecha' and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha' and idoperacion=2) then(tiempo) end)/sum(case when(fecha between '$fecsemana' and '$fecha' and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha' and idoperacion=2) then(tiempo) end)/sum(case when(fecha between '$fecmes' and '$fecha' and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and idoperacion =2) then(tiempo) end)/sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and idoperacion=2) then(tiempo) end)/sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec");
$cnefipro = $cnx_cuzzicia->SelectLimit($query_efipro) or die($cnx_cuzzicia->ErrorMsg());
$query_eficit = sprintf("SELECT sum(case when(fecha='$fecha' and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end)/sum(case when(fecha='$fecha' and iddestino<>2) then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha' and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end)/sum(case when(fecha between '$fecsemana' and '$fecha' and iddestino<>2) then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha' and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end)/sum(case when(fecha between '$fecmes' and '$fecha' and iddestino<>2) then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end)/sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and iddestino<>2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and (idoperacion=1 or idoperacion=2 or idoperacion=3)) then(tiempo) end)/sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and iddestino<>2) then(tiempo) end) as mes2 FROM v_informes WHERE idseccion = $idsec");
$cneficit = $cnx_cuzzicia->SelectLimit($query_eficit) or die($cnx_cuzzicia->ErrorMsg());
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
<form action="seccioninfo.php" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
 <TR>
    <TD>Secci&oacute;n</TD>
    <TD><SELECT id="idsec" name="idsec">
      <?php
  while(!$seccion->EOF){
?>
      <option value="<?php echo $seccion->Fields('idseccion')?>"><?php echo $seccion->Fields('seccion')?></option>
      <?php
    $seccion->MoveNext();
  }
  $seccion->MoveFirst();
?>
    </SELECT></TD>
  </TR>
  <TR>
    <TD>Fecha HOY </TD>
    <TD><label>
      <input name="fecha" id="fecha" value="" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
    </label></TD>
  </TR>
  <TR>
    <TD>&nbsp;</TD>
    <TD><input name="mostrar" type="submit" id="fecini_btn" value="Mostrar"></TD>
  </TR>
</table></form>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td class="KT_th">FECHA HOY:</td>
    <td colspan="5"><?php echo $fecha; ?></td>
  </tr>
  <tr>
    <td class="KT_th">SECCION:</td>
	<td colspan="5"><?php echo $cnprepa->Fields('seccion'); ?></td>
  </tr>
  <tr>
    <td class="KT_th"><div align="center">-----</div></td>
	<td class="KT_th">MES - 2 </td>
	<td class="KT_th">MES - 1 </td>
	<td class="KT_th">MES</td>
	<td class="KT_th">SEMANA/M</td>
	<td class="KT_th">HOY</td>
  </tr>
  <tr>
    <td class="KT_th">PREPARACION</td>
    <td align="right"><?php echo number_format($cnprepa->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnprepa->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnprepa->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnprepa->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnprepa->Fields('hoy'),2); ?></td>
  </tr>
  
  <tr>
    <td class="KT_th">PRODUCCION</td>
    <td align="right"><?php echo number_format($cnprodu->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodu->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodu->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodu->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodu->Fields('hoy'),2); ?></td>
  </tr>
  <tr>
    <td class="KT_th">LIMPIEZA</td>
    <td align="right"><?php echo number_format($cnlimpi->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnlimpi->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnlimpi->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnlimpi->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnlimpi->Fields('hoy'),2); ?></td>
  </tr>
  <tr>
    <td class="KT_th"><strong>T. PRODUCTIVO </strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('mes2'),2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('mes1'),2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('mes'),2); ?></strong></td>
   <td align="right"><strong><?php echo number_format($cntproduc->Fields('semana'),2);?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('hoy'),2); ?></strong></td>
  </tr>
  
  <tr>
      <td class="KT_th">ESPERA  CLIENTE </td>
      <td align="right"><?php echo number_format($cnespec->Fields('mes2'),2); ?></td>
      <td align="right"><?php echo number_format($cnespec->Fields('mes1'),2); ?></td>
      <td align="right"><?php echo number_format($cnespec->Fields('mes'),2); ?></td>
      <td align="right"><?php echo number_format($cnespec->Fields('semana'),2); ?></td>
      <td align="right"><?php echo number_format($cnespec->Fields('hoy'),2); ?></td>
</tr>
  <tr>
    <td class="KT_th">ESPERA DE MATERIAL </td>
    <td align="right"><?php echo number_format($cnespem->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnespem->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnespem->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnespem->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnespem->Fields('hoy'),2); ?></td>
  </tr>
    <tr>
      <td class="KT_th">MANTENIMIENTO/REPARACION</td>
      <td align="right"><?php echo number_format($cnmante->Fields('mes2'),2); ?></td>
      <td align="right"><?php echo number_format($cnmante->Fields('mes1'),2); ?></td>
      <td align="right"><?php echo number_format($cnmante->Fields('mes'),2); ?></td>
      <td align="right"><?php echo number_format($cnmante->Fields('semana'),2); ?></td>
      <td align="right"><?php echo number_format($cnmante->Fields('hoy'),2); ?></td>
    </tr>
  <tr>
    <td class="KT_th"><strong> T. INPRODUCTIVOS</strong></td>
  <td align="right"><strong><?php echo number_format($cntinproduc->Fields('mes2'),2); ?></strong></td>
  <td align="right"><strong><?php echo number_format($cntinproduc->Fields('mes1'),2); ?></strong></td>
  <td align="right"><strong><?php echo number_format($cntinproduc->Fields('mes'),2); ?></strong></td>
<td align="right"><strong><?php echo number_format($cntinproduc->Fields('semana'),2); ?></strong></td>
  <td align="right"><strong><?php echo number_format($cntinproduc->Fields('hoy'),2); ?></strong></td>
  </tr>
  <tr>
    <td class="KT_th">CANTIDAD PRODUCIDA </td>
    <td align="right"><?php echo number_format($cncantp->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cncantp->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cncantp->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cncantp->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cncantp->Fields('hoy'),2); ?></td>
  </tr>
  <tr>
    <td class="KT_th">VELOCIDAD. PRODUCCION </td>
    <td align="right"><?php echo number_format($cnprodh->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodh->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodh->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodh->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnprodh->Fields('hoy'),2); ?></td>
  </tr>
  <tr>
    <td class="KT_th">EFICIENCIA PRODUCCION</td>
    <td align="right"><strong><?php echo number_format($cnefipro->Fields('mes2')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cnefipro->Fields('mes1')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cnefipro->Fields('mes')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cnefipro->Fields('semana')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cnefipro->Fields('hoy')*100,2); ?>%</strong></td>
  </tr>
  <tr>
    <td class="KT_th"><strong>EFICIENCIA TOTAL </strong></td>
    <td align="right"><strong><?php echo number_format($cneficit->Fields('mes2')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cneficit->Fields('mes1')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cneficit->Fields('mes')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cneficit->Fields('semana')*100,2); ?>%</strong></td>
    <td align="right"><strong><?php echo number_format($cneficit->Fields('hoy')*100,2); ?>%</strong></td>
  </tr>
</table>
</body>
</html>
<?php
$seccion->Close();
?>