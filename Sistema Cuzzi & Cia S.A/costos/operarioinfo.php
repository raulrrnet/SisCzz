<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_operario = "SELECT * FROM operario WHERE estado='A' ORDER BY nombre ASC";
$operario = $cnx_cuzzicia->SelectLimit($query_operario) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_operario = $operario->RecordCount();
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
$idope = '0';
if (isset($_POST['idope'])){
  $idope = $_POST['idope'];}
$query_prepa = sprintf("SELECT nombre,sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and operacion = 'Preparacion' GROUP BY nombre");
$cnprepa = $cnx_cuzzicia->SelectLimit($query_prepa) or die($cnx_cuzzicia->ErrorMsg());
$query_produ = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and operacion = 'Produccion'");
$cnprodu = $cnx_cuzzicia->SelectLimit($query_produ) or die($cnx_cuzzicia->ErrorMsg());
$query_limpi = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and operacion = 'Limpieza'");
$cnlimpi = $cnx_cuzzicia->SelectLimit($query_limpi) or die($cnx_cuzzicia->ErrorMsg());
$query_espec = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and idoperacion = 4");
$cnespec = $cnx_cuzzicia->SelectLimit($query_espec) or die($cnx_cuzzicia->ErrorMsg());
$query_espem = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and idoperacion = 6");
$cnespem = $cnx_cuzzicia->SelectLimit($query_espem) or die($cnx_cuzzicia->ErrorMsg());
$query_apo = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and iddestino = 2");
$cnapoyo = $cnx_cuzzicia->SelectLimit($query_apo) or die($cnx_cuzzicia->ErrorMsg());
$query_mante = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and idoperacion = 5");
$cnmante = $cnx_cuzzicia->SelectLimit($query_mante) or die($cnx_cuzzicia->ErrorMsg());
$query_tproduc = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and (idoperacion = 1 or idoperacion = 2 or idoperacion = 3 or idoperacion = 4 or idoperacion = 5 or idoperacion = 8 or iddestino = 2)");
$cntproduc = $cnx_cuzzicia->SelectLimit($query_tproduc) or die($cnx_cuzzicia->ErrorMsg());

$query_prept = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and iddestino = 8");
$cnprept = $cnx_cuzzicia->SelectLimit($query_prept) or die($cnx_cuzzicia->ErrorMsg());
$query_adco = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and iddestino = 6");
$cnadco = $cnx_cuzzicia->SelectLimit($query_adco) or die($cnx_cuzzicia->ErrorMsg());
$query_sint = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and iddestino = 5");
$cnsint = $cnx_cuzzicia->SelectLimit($query_sint) or die($cnx_cuzzicia->ErrorMsg());
$query_tinproduc = sprintf("SELECT sum(case when(fecha='$fecha') then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha') then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha') then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope and (iddestino = 6 or iddestino = 5 or iddestino = 8)");
$cntinproduc = $cnx_cuzzicia->SelectLimit($query_tinproduc) or die($cnx_cuzzicia->ErrorMsg());

/*$query_eficit = sprintf("SELECT sum(case when(fecha='$fecha' and (idoperacion = 1 or idoperacion = 2 or idoperacion = 3 or idoperacion = 4 or idoperacion = 5 or idoperacion = 8 or iddestino = 2)) then(tiempo) end)/sum(case when(fecha='$fecha' and (iddestino = 6 or iddestino = 5 or iddestino = 8)) then(tiempo) end) as hoy,sum(case when(fecha between '$fecsemana' and '$fecha' and (idoperacion = 1 or idoperacion = 2 or idoperacion = 3 or idoperacion = 4 or idoperacion = 5 or idoperacion = 8 or iddestino = 2)) then(tiempo) end)/sum(case when(fecha between '$fecsemana' and '$fecha' and (iddestino = 6 or iddestino = 5 or iddestino = 8)) then(tiempo) end) as semana,sum(case when(fecha between '$fecmes' and '$fecha' and (idoperacion = 1 or idoperacion = 2 or idoperacion = 3 or idoperacion = 4 or idoperacion = 5 or idoperacion = 8 or iddestino = 2)) then(tiempo) end)/sum(case when(fecha between '$fecmes' and '$fecha' and (iddestino = 6 or iddestino = 5 or iddestino = 8)) then(tiempo) end) as mes,sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and (idoperacion = 1 or idoperacion = 2 or idoperacion = 3 or idoperacion = 4 or idoperacion = 5 or idoperacion = 8 or iddestino = 2)) then(tiempo) end)/sum(case when(date_part('month',fecha) = $mes1 and date_part('year',fecha)=$anio2 and (iddestino = 6 or iddestino = 5 or iddestino = 8)) then(tiempo) end) as mes1,sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and (idoperacion = 1 or idoperacion = 2 or idoperacion = 3 or idoperacion = 4 or idoperacion = 5 or idoperacion = 8 or iddestino = 2)) then(tiempo) end)/sum(case when(date_part('month',fecha) = $mes2 and date_part('year',fecha)=$anio2 and (iddestino = 6 or iddestino = 5 or iddestino = 8)) then(tiempo) end) as mes2 FROM v_informes WHERE idoperario = $idope");
$cneficit = $cnx_cuzzicia->SelectLimit($query_eficit) or die($cnx_cuzzicia->ErrorMsg());*/
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
<form action="operarioinfo.php" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
 <TR>
    <TD>Operario</TD>
    <TD><label>
      <select name="idope" id="idope">
        <?php
  while(!$operario->EOF){
?>
        <option value="<?php echo $operario->Fields('idoperario')?>"><?php echo $operario->Fields('nombre')?></option>
        <?php
    $operario->MoveNext();
  }
  $operario->MoveFirst();
?>
      </select>
    </label></TD>
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
    <td class="KT_th">OPERARIO:</td>
	<td colspan="5"><?php echo $cnprepa->Fields('nombre'); ?></td>
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
    <td class="KT_th">APOYO</td>
    <td align="right"><?php echo number_format($cnapoyo->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnapoyo->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnapoyo->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnapoyo->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnapoyo->Fields('hoy'),2); ?></td>
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
    <td class="KT_th"><strong>T. ASIGNADO SECCION </strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('mes2'),2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('mes1'),2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('mes'),2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('semana'),2); ?></strong></td>
    <td align="right"><strong><?php echo number_format($cntproduc->Fields('hoy'),2); ?></strong></td>
  </tr>
  
  <tr>
    <td class="KT_th">PREP. PUESTO TRABAJO </td>
    <td align="right"><?php echo number_format($cnprept->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnprept->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnprept->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnprept->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnprept->Fields('hoy'),2); ?></td>
  </tr>
  <tr>
    <td class="KT_th">LABOR ADMIN/COMERCIAL</td>
    <td align="right"><?php echo number_format($cnadco->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnadco->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnadco->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnadco->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnadco->Fields('hoy'),2); ?></td>
  </tr>
  <tr>
    <td class="KT_th">SIN TRABAJO </td>
    <td align="right"><?php echo number_format($cnsint->Fields('mes2'),2); ?></td>
    <td align="right"><?php echo number_format($cnsint->Fields('mes1'),2); ?></td>
    <td align="right"><?php echo number_format($cnsint->Fields('mes'),2); ?></td>
    <td align="right"><?php echo number_format($cnsint->Fields('semana'),2); ?></td>
    <td align="right"><?php echo number_format($cnsint->Fields('hoy'),2); ?></td>
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
    <td class="KT_th"><strong>EFICIENCIA</strong></td>
    <td align="right"><strong><?php $tp = $cntproduc->Fields('mes2');
	$tt = $cntproduc->Fields('mes2')+$cntinproduc->Fields('mes2');
	if($tt==0){echo "0.00";}else{echo number_format(($tp/$tt)*100,2);} ?>%</strong></td>
    <td align="right"><strong>
      <?php $tp = $cntproduc->Fields('mes1');
	$tt = $cntproduc->Fields('mes1')+$cntinproduc->Fields('mes1');
	if($tt==0){echo "0.00";}else{echo number_format(($tp/$tt)*100,2);} ?>
    %</strong></td>
    <td align="right"><strong>
      <?php $tp = $cntproduc->Fields('mes');
	$tt = $cntproduc->Fields('mes')+$cntinproduc->Fields('mes');
	if($tt==0){echo "0.00";}else{echo number_format(($tp/$tt)*100,2);} ?>
    %</strong></td>
    <td align="right"><strong>
      <?php $tp = $cntproduc->Fields('semana');
	$tt = $cntproduc->Fields('semana')+$cntinproduc->Fields('semana');
	if($tt==0){echo "0.00";}else{echo number_format(($tp/$tt)*100,2);} ?>
    %</strong></td>
    <td align="right"><strong>
      <?php $tp = $cntproduc->Fields('hoy');
	$tt = $cntproduc->Fields('hoy')+$cntinproduc->Fields('hoy');
	if($tt==0){echo "0.00";}else{echo number_format(($tp/$tt)*100,2);} ?>
    %</strong></td>
  </tr>
</table>
</body>
</html>
<?php
$operario->Close();
?>