<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// begin Recordset
$query_seccion = "SELECT * FROM seccion where idseccion<>0 and  seccion > 'Impresión Offset Rotativa' or idseccion=20 ORDER BY seccion limit 5";
$seccion = $cnx_cuzzicia->SelectLimit($query_seccion) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_seccion = $seccion->RecordCount();// end Recordset
// begin Recordset
$query_facgac = "SELECT * FROM factorgac";
$exfacgac = $cnx_cuzzicia->SelectLimit($query_facgac) or die($cnx_cuzzicia->ErrorMsg());
$factgac = $exfacgac->Fields('factor');
// end Recordset
//PHP ADODB document - made with PHAkt 3.7.1
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
?>
<html>
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
<?php
$vartgn11=0;;$vartgn10=0;$vartgn9=0;$vartgn8=0;$vartgn7=0;$vartgn6=0;$vartgn5=0;$vartgn4=0;$vartgn3=0;$vartgn2=0;;$vartgn1=0;$vartgn=0;
//-----------consultas unicas sin depender de secciones-------------
//consultas para calculo electricidad 12 meses
		$q_totsec11 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1  and date_part('year',fecha)=$an11 and date_part('month',fecha)=$mes11");
		$extotsec11 = $cnx_cuzzicia->SelectLimit($q_totsec11) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec11 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes11 and date_part('year',mes)=$an11");
		$excoselec11 = $cnx_cuzzicia->SelectLimit($q_coselec11) or die($cnx_cuzzicia->ErrorMsg());
		$factor11 = $excoselec11->Fields('costotal')/$extotsec11->Fields('tiempo');

		$q_totsec10 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1  and date_part('year',fecha)=$an10 and date_part('month',fecha)=$mes10");
		$extotsec10 = $cnx_cuzzicia->SelectLimit($q_totsec10) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec10 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes10 and date_part('year',mes)=$an10");
		$excoselec10 = $cnx_cuzzicia->SelectLimit($q_coselec10) or die($cnx_cuzzicia->ErrorMsg());
		$factor10 = $excoselec10->Fields('costotal')/$extotsec10->Fields('tiempo');
		
		$q_totsec9 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an9 and date_part('month',fecha)=$mes9");
		$extotsec9 = $cnx_cuzzicia->SelectLimit($q_totsec9) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec9 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes9 and date_part('year',mes)=$an9");
		$excoselec9 = $cnx_cuzzicia->SelectLimit($q_coselec9) or die($cnx_cuzzicia->ErrorMsg());
		$factor9 = $excoselec9->Fields('costotal')/$extotsec9->Fields('tiempo');

		$q_totsec8 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an8 and date_part('month',fecha)=$mes8");
		$extotsec8 = $cnx_cuzzicia->SelectLimit($q_totsec8) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec8 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes8 and date_part('year',mes)=$an8");
		$excoselec8 = $cnx_cuzzicia->SelectLimit($q_coselec8) or die($cnx_cuzzicia->ErrorMsg());
		$factor8 = $excoselec8->Fields('costotal')/$extotsec8->Fields('tiempo');
		
		$q_totsec7 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an7 and date_part('month',fecha)=$mes7");
		$extotsec7 = $cnx_cuzzicia->SelectLimit($q_totsec7) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec7 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes7 and date_part('year',mes)=$an7");
		$excoselec7 = $cnx_cuzzicia->SelectLimit($q_coselec7) or die($cnx_cuzzicia->ErrorMsg());
		$factor7 = $excoselec7->Fields('costotal')/$extotsec7->Fields('tiempo');
		
		$q_totsec6 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an6 and date_part('month',fecha)=$mes6");
		$extotsec6 = $cnx_cuzzicia->SelectLimit($q_totsec6) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec6 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes6 and date_part('year',mes)=$an6");
		$excoselec6 = $cnx_cuzzicia->SelectLimit($q_coselec6) or die($cnx_cuzzicia->ErrorMsg());
		$factor6 = $excoselec6->Fields('costotal')/$extotsec6->Fields('tiempo');

		$q_totsec5 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an5 and date_part('month',fecha)=$mes5");
		$extotsec5 = $cnx_cuzzicia->SelectLimit($q_totsec5) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec5 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes5 and date_part('year',mes)=$an5");
		$excoselec5 = $cnx_cuzzicia->SelectLimit($q_coselec5) or die($cnx_cuzzicia->ErrorMsg());
		$factor5 = $excoselec5->Fields('costotal')/$extotsec5->Fields('tiempo');

		$q_totsec4 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an4 and date_part('month',fecha)=$mes4");
		$extotsec4 = $cnx_cuzzicia->SelectLimit($q_totsec4) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec4 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes4 and date_part('year',mes)=$an4");
		$excoselec4 = $cnx_cuzzicia->SelectLimit($q_coselec4) or die($cnx_cuzzicia->ErrorMsg());
		$factor4 = $excoselec4->Fields('costotal')/$extotsec4->Fields('tiempo');

		$q_totsec3 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an3 and date_part('month',fecha)=$mes3");
		$extotsec3 = $cnx_cuzzicia->SelectLimit($q_totsec3) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec3 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes3 and date_part('year',mes)=$an3");
		$excoselec3 = $cnx_cuzzicia->SelectLimit($q_coselec3) or die($cnx_cuzzicia->ErrorMsg());
		$factor3 = $excoselec3->Fields('costotal')/$extotsec3->Fields('tiempo');

		$q_totsec2 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an2 and date_part('month',fecha)=$mes2");
		$extotsec2 = $cnx_cuzzicia->SelectLimit($q_totsec2) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec2 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes2 and date_part('year',mes)=$an2");
		$excoselec2 = $cnx_cuzzicia->SelectLimit($q_coselec2) or die($cnx_cuzzicia->ErrorMsg());
		$factor2 = $excoselec2->Fields('costotal')/$extotsec2->Fields('tiempo');

		$q_totsec1 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an1 and date_part('month',fecha)=$mes1");
		$extotsec1 = $cnx_cuzzicia->SelectLimit($q_totsec1) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec1 = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes1 and date_part('year',mes)=$an1");
		$excoselec1 = $cnx_cuzzicia->SelectLimit($q_coselec1) or die($cnx_cuzzicia->ErrorMsg());
		$factor1 = $excoselec1->Fields('costotal')/$extotsec1->Fields('tiempo');

		$q_totsec = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('year',fecha)=$an and date_part('month',fecha)=$mes");
		$extotsec = $cnx_cuzzicia->SelectLimit($q_totsec) or die($cnx_cuzzicia->ErrorMsg());
		$q_coselec = sprintf("SELECT costototal as costotal FROM costoelec WHERE date_part('month',mes)=$mes and date_part('year',mes)=$an");
		$excoselec = $cnx_cuzzicia->SelectLimit($q_coselec) or die($cnx_cuzzicia->ErrorMsg());
		$factor = $excoselec->Fields('costotal')/$extotsec->Fields('tiempo');

//generales planta
		$q_secti11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11");
		$exsecti11 = $cnx_cuzzicia->SelectLimit($q_secti11) or die($cnx_cuzzicia->ErrorMsg());
		
		$q_secti10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10");
		$exsecti10 = $cnx_cuzzicia->SelectLimit($q_secti10) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9");
		$exsecti9 = $cnx_cuzzicia->SelectLimit($q_secti9) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8");
		$exsecti8 = $cnx_cuzzicia->SelectLimit($q_secti8) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7");
		$exsecti7 = $cnx_cuzzicia->SelectLimit($q_secti7) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6");
		$exsecti6 = $cnx_cuzzicia->SelectLimit($q_secti6) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5");
		$exsecti5 = $cnx_cuzzicia->SelectLimit($q_secti5) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4");
		$exsecti4 = $cnx_cuzzicia->SelectLimit($q_secti4) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3");
		$exsecti3 = $cnx_cuzzicia->SelectLimit($q_secti3) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2");
		$exsecti2 = $cnx_cuzzicia->SelectLimit($q_secti2) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1");
		$exsecti1 = $cnx_cuzzicia->SelectLimit($q_secti1) or die($cnx_cuzzicia->ErrorMsg());

		$q_secti = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and date_part('month',fecha)=$mes and date_part('year',fecha)=$an");
		$exsecti = $cnx_cuzzicia->SelectLimit($q_secti) or die($cnx_cuzzicia->ErrorMsg());
?>
</head>

<body>
<form action="reptarifasecdep.php" method="post">
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
  <?php
    while (!$seccion->EOF) {
	//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11");
	$tiemsec11 = $cnx_cuzzicia->SelectLimit($q_tiemsec11) or die($cnx_cuzzicia->ErrorMsg());
	$totiem11t[] = $tiemsec11->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec11 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 GROUP BY idoperario ORDER BY idoperario");
	$operasec11 = $cnx_cuzzicia->SelectLimit($q_opesec11) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec11->RecordCount();
		while (!$operasec11->EOF) {
		$idope = $operasec11->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope11 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes11 and date_part('year',mes)=$an11 and idoperario=$idope");
		$exqcostoope11 = $cnx_cuzzicia->SelectLimit($q_costoope11) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idoperario=$idope");
		$exqtitoope11 = $cnx_cuzzicia->SelectLimit($q_titoope11) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra11 = $exqcostoope11->Fields('costotal')/$exqtitoope11->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idoperario = $idope");
		$extpopesec11 = $cnx_cuzzicia->SelectLimit($q_tpopesec11) or die($cnx_cuzzicia->ErrorMsg());
		$product11 = $extpopesec11->Fields('tiempo')*$costxhra11;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idoperario = $idope");
		$extiopesec11 = $cnx_cuzzicia->SelectLimit($q_tiopesec11) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts11 = $extiopesec11->Fields('tiempo')*$costxhra11;
		// consulta asignacion operarios
		$q_asigsec11 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec11 = $cnx_cuzzicia->SelectLimit($q_asigsec11) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idoperario = $idope");
		$extiopesin11 = $cnx_cuzzicia->SelectLimit($q_tiopesin11) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct11 = $exqasigsec11->Fields('porcent')*$costxhra11*$extiopesin11->Fields('tiempo');
		$totmoprod11[] = $product11;
		$totmoprod11t[] = $product11;
		$totmoinprosec11[] = $inproducts11;
		$totmoinprosec11t[] = $inproducts11;
		$totmoinprosinsec11[] = $inproduct11;
		$totmoinprosinsec11t[] = $inproduct11;
		$total11[] = $product11 + $inproducts11 + $inproduct11;
		$operasec11->MoveNext();
		}
		if($tRows_operasec==0){
		$total11[]=0;
		$totmoinprosec11t[]=0;
		$totmoprod11t[]=0;
		$totmoprod11[]=0;
		$totmoinprosec11[]=0;
		$totmoinprosec11t[]=0;
		$totmoinprosinsec11[]=0;
		$totmoinprosinsec11t[]=0;}
		//depreciacion
		$q_depsec11 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha11' ORDER BY iddeprecia");
		$depresec11 = $cnx_cuzzicia->SelectLimit($q_depsec11) or die($cnx_cuzzicia->ErrorMsg());
		$totdep11[] = 0;
		$totdep11t[] = 0;
		while (!$depresec11->EOF) {
		$fecingre11 = $depresec11->Fields('fecingreso');
		$q_meses11 = sprintf("select (DATE '$fecha11'-'$fecingre11')/30 as diff;");
		$excmeses11 = $cnx_cuzzicia->SelectLimit($q_meses11) or die($cnx_cuzzicia->ErrorMsg());
		$diff11 = $excmeses11->Fields('diff');
		if($fecingre11<=$fecha11 and $diff11<=$depresec11->Fields('nrocuotas')){
			$totdep11[] = $depresec11->Fields('dep');
			$totdep11t[] = $depresec11->Fields('dep');
		}
		$depresec11->MoveNext();
		}
		//insumos
		$q_insusec11 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idseccion=$idsec and idorden=0");
		$insusec11 = $cnx_cuzzicia->SelectLimit($q_insusec11) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu11 = $insusec11->Fields('insu');
		$totinsu11t[] = $insusec11->Fields('insu');
		//mantenimiento
		$q_cosmante11 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11 and idseccion = $idsec");
		$excosmante11 = $cnx_cuzzicia->SelectLimit($q_cosmante11) or die($cnx_cuzzicia->ErrorMsg());
		$totmante11 = $excosmante11->Fields('costotal');
		$totmante11t[] = $excosmante11->Fields('costotal');
		//seguros
		$q_segsec11 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an11 ORDER BY fecha");
		$segusec11 = $cnx_cuzzicia->SelectLimit($q_segsec11) or die($cnx_cuzzicia->ErrorMsg());
		$totseg11[] = 0;
		$totseg11t[] = 0;
		while (!$segusec11->EOF) {
			$totseg11[] = $segusec11->Fields('pm');
			$totseg11t[] = $segusec11->Fields('pm');
		$segusec11->MoveNext();
		}
		//electricidad
		$q_facsec11 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11");
		$exfacsec11 = $cnx_cuzzicia->SelectLimit($q_facsec11) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri11[] = $factor11*$exfacsec11->Fields('tiempo');
		$totelectri11t[] = $factor11*$exfacsec11->Fields('tiempo');
		//generales planta
		$q_cosgplan11 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes11 and date_part('year',mes)=$an11 and idseccion=$idsec");
		$excosgplan11 = $cnx_cuzzicia->SelectLimit($q_cosgplan11) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp11 = ($excosgplan11->Fields('costotal')+$vartgn11)/$exsecti11->Fields('tiempo');
		$q_facgpsec11 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes11 and date_part('year',fecha)=$an11");
		$exfacgpsec11 = $cnx_cuzzicia->SelectLimit($q_facgpsec11) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan11[] = $factorgp11*$exfacgpsec11->Fields('tiempo');
		$totgenplan11t[] = $factorgp11*$exfacgpsec11->Fields('tiempo');
		//otros Gp
		$q_cosotros11 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes11 and date_part('year',mes)=$an11");
		$excosotros11 = $cnx_cuzzicia->SelectLimit($q_cosotros11) or die($cnx_cuzzicia->ErrorMsg());
		$tototros11 = $excosotros11->Fields('costotal');
		$tototros11t[] = $excosotros11->Fields('costotal');

		$totalt11[] = 0;
		array_splice($totalt11,0);
		$totalt11[] = array_sum($totgenplan11)+$totmante11+array_sum($totelectri11)+$totinsu11+array_sum($totseg11)+array_sum($total11)+$tototros11+array_sum($totdep11);
		if($vartgn11==0){
		$vartgn11 = array_sum($totalt11);}
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10");
	$tiemsec10 = $cnx_cuzzicia->SelectLimit($q_tiemsec10) or die($cnx_cuzzicia->ErrorMsg());
	$totiem10t[] = $tiemsec10->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec10 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 GROUP BY idoperario ORDER BY idoperario");
	$operasec10 = $cnx_cuzzicia->SelectLimit($q_opesec10) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec10->RecordCount();
		while (!$operasec10->EOF) {
		$idope = $operasec10->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope10 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes10 and date_part('year',mes)=$an10 and idoperario=$idope");
		$exqcostoope10 = $cnx_cuzzicia->SelectLimit($q_costoope10) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 and idoperario=$idope");
		$exqtitoope10 = $cnx_cuzzicia->SelectLimit($q_titoope10) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra10 = $exqcostoope10->Fields('costotal')/$exqtitoope10->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 and idoperario = $idope");
		$extpopesec10 = $cnx_cuzzicia->SelectLimit($q_tpopesec10) or die($cnx_cuzzicia->ErrorMsg());
		$product10 = $extpopesec10->Fields('tiempo')*$costxhra10;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 and idoperario = $idope");
		$extiopesec10 = $cnx_cuzzicia->SelectLimit($q_tiopesec10) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts10 = $extiopesec10->Fields('tiempo')*$costxhra10;
		// consulta asignacion operarios
		$q_asigsec10 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec10 = $cnx_cuzzicia->SelectLimit($q_asigsec10) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 and idoperario = $idope");
		$extiopesin10 = $cnx_cuzzicia->SelectLimit($q_tiopesin10) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct10 = $exqasigsec10->Fields('porcent')*$costxhra10*$extiopesin10->Fields('tiempo');
		$totmoprod10[] = $product10;
		$totmoprod10t[] = $product10;
		$totmoinprosec10[] = $inproducts10;
		$totmoinprosec10t[] = $inproducts10;		
		$totmoinprosinsec10[] = $inproduct10;
		$totmoinprosinsec10t[] = $inproduct10;
		$total10[] = $product10 + $inproducts10 + $inproduct10;
		$operasec10->MoveNext();
		}
		if($tRows_operasec==0){
		$total10[]=0;
		$totmoprod10t[]=0;
		$totmoprod10[]=0;
		$totmoinprosec10[] = 0;
		$totmoinprosec10t[] = 0;		
		$totmoinprosinsec10[] = 0;
		$totmoinprosinsec10t[] = 0;}
		//depreciacion
		$q_depsec10 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha10' ORDER BY iddeprecia");
		$depresec10 = $cnx_cuzzicia->SelectLimit($q_depsec10) or die($cnx_cuzzicia->ErrorMsg());
		$totdep10[] = 0;
		$totdep10t[] = 0;
		while (!$depresec10->EOF) {
		$fecingre10 = $depresec10->Fields('fecingreso');
		$q_meses10 = sprintf("select (DATE '$fecha10'-'$fecingre10')/30 as diff;");
		$excmeses10 = $cnx_cuzzicia->SelectLimit($q_meses10) or die($cnx_cuzzicia->ErrorMsg());
		$diff10 = $excmeses10->Fields('diff');
		if($fecingre10<=$fecha10 and $diff10<=$depresec10->Fields('nrocuotas')){
			$totdep10[] = $depresec10->Fields('dep');
			$totdep10t[] = $depresec10->Fields('dep');
		}
		$depresec10->MoveNext();
		}
		//insumos
		$q_insusec10 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 and idseccion=$idsec and idorden=0");
		$insusec10 = $cnx_cuzzicia->SelectLimit($q_insusec10) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu10 = $insusec10->Fields('insu');
		$totinsu10t[] = $insusec10->Fields('insu');
		//mantenimiento
		$q_cosmante10 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10 and idseccion = $idsec");
		$excosmante10 = $cnx_cuzzicia->SelectLimit($q_cosmante10) or die($cnx_cuzzicia->ErrorMsg());
		$totmante10 = $excosmante10->Fields('costotal');
		$totmante10t[] = $excosmante10->Fields('costotal');
		//seguros
		$q_segsec10 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an10 ORDER BY fecha");
		$segusec10 = $cnx_cuzzicia->SelectLimit($q_segsec10) or die($cnx_cuzzicia->ErrorMsg());
		$totseg10[] = 0;
		$totseg10t[] = 0;
		while (!$segusec10->EOF) {
			$totseg10[] = $segusec10->Fields('pm');
			$totseg10t[] = $segusec10->Fields('pm');
		$segusec10->MoveNext();
		}
		//electricidad
		$q_facsec10 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10");
		$exfacsec10 = $cnx_cuzzicia->SelectLimit($q_facsec10) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri10[] = $factor10*$exfacsec10->Fields('tiempo');
		$totelectri10t[] = $factor10*$exfacsec10->Fields('tiempo');
		//generales planta
		$q_cosgplan10 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes10 and date_part('year',mes)=$an10 and idseccion=$idsec");
		$excosgplan10 = $cnx_cuzzicia->SelectLimit($q_cosgplan10) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp10 = ($excosgplan10->Fields('costotal')+$vartgn10)/$exsecti10->Fields('tiempo');
		$q_facgpsec10 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes10 and date_part('year',fecha)=$an10");
		$exfacgpsec10 = $cnx_cuzzicia->SelectLimit($q_facgpsec10) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan10[] = $factorgp10*$exfacgpsec10->Fields('tiempo');
		$totgenplan10t[] = $factorgp10*$exfacgpsec10->Fields('tiempo');
		//otros Gp
		$q_cosotros10 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes10 and date_part('year',mes)=$an10");
		$excosotros10 = $cnx_cuzzicia->SelectLimit($q_cosotros10) or die($cnx_cuzzicia->ErrorMsg());
		$tototros10 = $excosotros10->Fields('costotal');
		$tototros10t[] = $excosotros10->Fields('costotal');
				
		$totalt10[] = 0;
		array_splice($totalt10,0);
		$totalt10[] = array_sum($totgenplan10)+$totmante10+array_sum($totelectri10)+$totinsu10+array_sum($totseg10)+array_sum($total10)+$tototros10+array_sum($totdep10);
		if($vartgn10==0){
		$vartgn10 = array_sum($totalt10);}
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9");
	$tiemsec9 = $cnx_cuzzicia->SelectLimit($q_tiemsec9) or die($cnx_cuzzicia->ErrorMsg());
	$totiem9t[] = $tiemsec9->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec9 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 GROUP BY idoperario ORDER BY idoperario");
	$operasec9 = $cnx_cuzzicia->SelectLimit($q_opesec9) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec9->RecordCount();
		while (!$operasec9->EOF) {
		$idope = $operasec9->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope9 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes9 and date_part('year',mes)=$an9 and idoperario=$idope");
		$exqcostoope9 = $cnx_cuzzicia->SelectLimit($q_costoope9) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 and idoperario=$idope");
		$exqtitoope9 = $cnx_cuzzicia->SelectLimit($q_titoope9) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra9 = $exqcostoope9->Fields('costotal')/$exqtitoope9->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 and idoperario = $idope");
		$extpopesec9 = $cnx_cuzzicia->SelectLimit($q_tpopesec9) or die($cnx_cuzzicia->ErrorMsg());
		$product9 = $extpopesec9->Fields('tiempo')*$costxhra9;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 and idoperario = $idope");
		$extiopesec9 = $cnx_cuzzicia->SelectLimit($q_tiopesec9) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts9 = $extiopesec9->Fields('tiempo')*$costxhra9;
		// consulta asignacion operarios
		$q_asigsec9 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec9 = $cnx_cuzzicia->SelectLimit($q_asigsec9) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 and idoperario = $idope");
		$extiopesin9 = $cnx_cuzzicia->SelectLimit($q_tiopesin9) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct9 = $exqasigsec9->Fields('porcent')*$costxhra9*$extiopesin9->Fields('tiempo');
		$totmoprod9[] = $product9;
		$totmoprod9t[] = $product9;
		$totmoinprosec9[] = $inproducts9;
		$totmoinprosec9t[] = $inproducts9;
		$totmoinprosinsec9[] = $inproduct9;
		$totmoinprosinsec9t[] = $inproduct9;
		$total9[] = $product9 + $inproducts9 + $inproduct9;
		$operasec9->MoveNext();
		}
		if($tRows_operasec==0){
		$total9[]=0;
		$totmoprod9t[]=0;
		$totmoprod9[]=0;
		$totmoinprosec9[] = 0;
		$totmoinprosec9t[] = 0;
		$totmoinprosinsec9[] = 0;
		$totmoinprosinsec9t[] = 0;}
		//depreciacion
		$q_depsec9 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha9' ORDER BY iddeprecia");
		$depresec9 = $cnx_cuzzicia->SelectLimit($q_depsec9) or die($cnx_cuzzicia->ErrorMsg());
		$totdep9[] = 0;
		$totdep9t[] = 0;
		while (!$depresec9->EOF) {
		$fecingre9 = $depresec9->Fields('fecingreso');
		$q_meses9 = sprintf("select (DATE '$fecha9'-'$fecingre9')/30 as diff;");
		$excmeses9 = $cnx_cuzzicia->SelectLimit($q_meses9) or die($cnx_cuzzicia->ErrorMsg());
		$diff9 = $excmeses9->Fields('diff');
		if($fecingre9<=$fecha9 and $diff9<=$depresec9->Fields('nrocuotas')){
			$totdep9[] = $depresec9->Fields('dep');
			$totdep9t[] = $depresec9->Fields('dep');
		}
		$depresec9->MoveNext();
		}
		//insumos
		$q_insusec9 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 and idseccion=$idsec and idorden=0");
		$insusec9 = $cnx_cuzzicia->SelectLimit($q_insusec9) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu9 = $insusec9->Fields('insu');
		$totinsu9t[] = $insusec9->Fields('insu');
		//mantenimiento
		$q_cosmante9 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9 and idseccion = $idsec");
		$excosmante9 = $cnx_cuzzicia->SelectLimit($q_cosmante9) or die($cnx_cuzzicia->ErrorMsg());
		$totmante9 = $excosmante9->Fields('costotal');
		$totmante9t[] = $excosmante9->Fields('costotal');
		//seguros
		$q_segsec9 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an9 ORDER BY fecha");
		$segusec9 = $cnx_cuzzicia->SelectLimit($q_segsec9) or die($cnx_cuzzicia->ErrorMsg());
		$totseg9[] = 0;
		$totseg9t[] = 0;
		while (!$segusec9->EOF) {
			$totseg9[] = $segusec9->Fields('pm');
			$totseg9t[] = $segusec9->Fields('pm');
		$segusec9->MoveNext();
		}
		//electricidad
		$q_facsec9 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9");
		$exfacsec9 = $cnx_cuzzicia->SelectLimit($q_facsec9) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri9[] = $factor9*$exfacsec9->Fields('tiempo');
		$totelectri9t[] = $factor9*$exfacsec9->Fields('tiempo');
		//generales planta
		$q_cosgplan9 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes9 and date_part('year',mes)=$an9 and idseccion=$idsec");
		$excosgplan9 = $cnx_cuzzicia->SelectLimit($q_cosgplan9) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp9 = ($excosgplan9->Fields('costotal')+$vartgn9)/$exsecti9->Fields('tiempo');
		$q_facgpsec9 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes9 and date_part('year',fecha)=$an9");
		$exfacgpsec9 = $cnx_cuzzicia->SelectLimit($q_facgpsec9) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan9[] = $factorgp9*$exfacgpsec9->Fields('tiempo');
		$totgenplan9t[] = $factorgp9*$exfacgpsec9->Fields('tiempo');
		//otros Gp
		$q_cosotros9 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes9 and date_part('year',mes)=$an9");
		$excosotros9 = $cnx_cuzzicia->SelectLimit($q_cosotros9) or die($cnx_cuzzicia->ErrorMsg());
		$tototros9 = $excosotros9->Fields('costotal');
		$tototros9t[] = $excosotros9->Fields('costotal');

		$totalt9[] = 0;
		array_splice($totalt9,0);
		$totalt9[] = array_sum($totgenplan9)+$totmante9+array_sum($totelectri9)+$totinsu9+array_sum($totseg9)+array_sum($total9)+$tototros9+array_sum($totdep9);
		if($vartgn9==0){
		$vartgn9 = array_sum($totalt9);}
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8");
	$tiemsec8 = $cnx_cuzzicia->SelectLimit($q_tiemsec8) or die($cnx_cuzzicia->ErrorMsg());
	$totiem8t[] = $tiemsec8->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec8 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 GROUP BY idoperario ORDER BY idoperario");
	$operasec8 = $cnx_cuzzicia->SelectLimit($q_opesec8) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec8->RecordCount();
		while (!$operasec8->EOF) {
		$idope = $operasec8->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope8 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes8 and date_part('year',mes)=$an8 and idoperario=$idope");
		$exqcostoope8 = $cnx_cuzzicia->SelectLimit($q_costoope8) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 and idoperario=$idope");
		$exqtitoope8 = $cnx_cuzzicia->SelectLimit($q_titoope8) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra8 = $exqcostoope8->Fields('costotal')/$exqtitoope8->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 and idoperario = $idope");
		$extpopesec8 = $cnx_cuzzicia->SelectLimit($q_tpopesec8) or die($cnx_cuzzicia->ErrorMsg());
		$product8 = $extpopesec8->Fields('tiempo')*$costxhra8;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 and idoperario = $idope");
		$extiopesec8 = $cnx_cuzzicia->SelectLimit($q_tiopesec8) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts8 = $extiopesec8->Fields('tiempo')*$costxhra8;
		// consulta asignacion operarios
		$q_asigsec8 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec8 = $cnx_cuzzicia->SelectLimit($q_asigsec8) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 and idoperario = $idope");
		$extiopesin8 = $cnx_cuzzicia->SelectLimit($q_tiopesin8) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct8 = $exqasigsec8->Fields('porcent')*$costxhra8*$extiopesin8->Fields('tiempo');
		$totmoprod8[] = $product8;
		$totmoprod8t[] = $product8;
		$totmoinprosec8[] = $inproducts8;
		$totmoinprosec8t[] = $inproducts8;
		$totmoinprosinsec8[] = $inproduct8;
		$totmoinprosinsec8t[] = $inproduct8;
		$total8[] = $product8 + $inproducts8 + $inproduct8;
		$operasec8->MoveNext();
		}
		if($tRows_operasec==0){
		$total8[]=0;
		$totmoprod8t[]=0;
		$totmoprod8[]=0;
		$totmoinprosec8[] = 0;
		$totmoinprosec8t[] = 0;
		$totmoinprosinsec8[] = 0;
		$totmoinprosinsec8t[] = 0;}
		//depreciacion
		$q_depsec8 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha8' ORDER BY iddeprecia");
		$depresec8 = $cnx_cuzzicia->SelectLimit($q_depsec8) or die($cnx_cuzzicia->ErrorMsg());
		$totdep8[] = 0;
		$totdep8t[] = 0;
		while (!$depresec8->EOF) {
		$fecingre8 = $depresec8->Fields('fecingreso');
		$q_meses8 = sprintf("select (DATE '$fecha8'-'$fecingre8')/30 as diff;");
		$excmeses8 = $cnx_cuzzicia->SelectLimit($q_meses8) or die($cnx_cuzzicia->ErrorMsg());
		$diff8 = $excmeses8->Fields('diff');
		if($fecingre8<=$fecha8 and $diff8<=$depresec8->Fields('nrocuotas')){
			$totdep8[] = $depresec8->Fields('dep');
			$totdep8t[] = $depresec8->Fields('dep');
		}
		$depresec8->MoveNext();
		}
		//insumos
		$q_insusec8 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 and idseccion=$idsec and idorden=0");
		$insusec8 = $cnx_cuzzicia->SelectLimit($q_insusec8) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu8 = $insusec8->Fields('insu');
		$totinsu8t[] = $insusec8->Fields('insu');
		//mantenimiento
		$q_cosmante8 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8 and idseccion = $idsec");
		$excosmante8 = $cnx_cuzzicia->SelectLimit($q_cosmante8) or die($cnx_cuzzicia->ErrorMsg());
		$totmante8 = $excosmante8->Fields('costotal');
		$totmante8t[] = $excosmante8->Fields('costotal');
		//seguros
		$q_segsec8 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an8 ORDER BY fecha");
		$segusec8 = $cnx_cuzzicia->SelectLimit($q_segsec8) or die($cnx_cuzzicia->ErrorMsg());
		$totseg8[] = 0;
		$totseg8t[] = 0;
		while (!$segusec8->EOF) {
			$totseg8[] = $segusec8->Fields('pm');
			$totseg8t[] = $segusec8->Fields('pm');
		$segusec8->MoveNext();
		}
		//electricidad
		$q_facsec8 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8");
		$exfacsec8 = $cnx_cuzzicia->SelectLimit($q_facsec8) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri8[] = $factor8*$exfacsec8->Fields('tiempo');
		$totelectri8t[] = $factor8*$exfacsec8->Fields('tiempo');
		//generales planta
		$q_cosgplan8 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes8 and date_part('year',mes)=$an8 and idseccion=$idsec");
		$excosgplan8 = $cnx_cuzzicia->SelectLimit($q_cosgplan8) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp8 = ($excosgplan8->Fields('costotal')+$vartgn8)/$exsecti8->Fields('tiempo');
		$q_facgpsec8 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes8 and date_part('year',fecha)=$an8");
		$exfacgpsec8 = $cnx_cuzzicia->SelectLimit($q_facgpsec8) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan8[] = $factorgp8*$exfacgpsec8->Fields('tiempo');
		$totgenplan8t[] = $factorgp8*$exfacgpsec8->Fields('tiempo');
		//otros Gp
		$q_cosotros8 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes8 and date_part('year',mes)=$an8");
		$excosotros8 = $cnx_cuzzicia->SelectLimit($q_cosotros8) or die($cnx_cuzzicia->ErrorMsg());
		$tototros8 = $excosotros8->Fields('costotal');
		$tototros8t[] = $excosotros8->Fields('costotal');

		$totalt8[] = 0;
		array_splice($totalt8,0);
		$totalt8[] = array_sum($totgenplan8)+$totmante8+array_sum($totelectri8)+$totinsu8+array_sum($totseg8)+array_sum($total8)+$tototros8+array_sum($totdep8);
		if($vartgn8==0){
		$vartgn8 = array_sum($totalt8);}
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7");
	$tiemsec7 = $cnx_cuzzicia->SelectLimit($q_tiemsec7) or die($cnx_cuzzicia->ErrorMsg());
	$totiem7t[] = $tiemsec7->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec7 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 GROUP BY idoperario ORDER BY idoperario");
	$operasec7 = $cnx_cuzzicia->SelectLimit($q_opesec7) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec7->RecordCount();
		while (!$operasec7->EOF) {
		$idope = $operasec7->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope7 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes7 and date_part('year',mes)=$an7 and idoperario=$idope");
		$exqcostoope7 = $cnx_cuzzicia->SelectLimit($q_costoope7) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 and idoperario=$idope");
		$exqtitoope7 = $cnx_cuzzicia->SelectLimit($q_titoope7) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra7 = $exqcostoope7->Fields('costotal')/$exqtitoope7->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 and idoperario = $idope");
		$extpopesec7 = $cnx_cuzzicia->SelectLimit($q_tpopesec7) or die($cnx_cuzzicia->ErrorMsg());
		$product7 = $extpopesec7->Fields('tiempo')*$costxhra7;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 and idoperario = $idope");
		$extiopesec7 = $cnx_cuzzicia->SelectLimit($q_tiopesec7) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts7 = $extiopesec7->Fields('tiempo')*$costxhra7;
		// consulta asignacion operarios
		$q_asigsec7 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec7 = $cnx_cuzzicia->SelectLimit($q_asigsec7) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 and idoperario = $idope");
		$extiopesin7 = $cnx_cuzzicia->SelectLimit($q_tiopesin7) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct7 = $exqasigsec7->Fields('porcent')*$costxhra7*$extiopesin7->Fields('tiempo');
		$totmoprod7[] = $product7;
		$totmoprod7t[] = $product7;
		$totmoinprosec7[] = $inproducts7;
		$totmoinprosec7t[] = $inproducts7;
		$totmoinprosinsec7[] = $inproduct7;
		$totmoinprosinsec7t[] = $inproduct7;
		$total7[] = $product7 + $inproducts7 + $inproduct7;
		$operasec7->MoveNext();
		}
		if($tRows_operasec==0){
		$total7[]=0;
		$totmoprod7t[]=0;
		$totmoprod7[]=0;
		$totmoinprosec7[] = 0;
		$totmoinprosec7t[] = 0;
		$totmoinprosinsec7[] = 0;
		$totmoinprosinsec7t[] = 0;}

		//depreciacion
		$q_depsec7 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha7' ORDER BY iddeprecia");
		$depresec7 = $cnx_cuzzicia->SelectLimit($q_depsec7) or die($cnx_cuzzicia->ErrorMsg());
		$totdep7[] = 0;
		$totdep7t[] = 0;
		while (!$depresec7->EOF) {
		$fecingre7 = $depresec7->Fields('fecingreso');
		$q_meses7 = sprintf("select (DATE '$fecha7'-'$fecingre7')/30 as diff;");
		$excmeses7 = $cnx_cuzzicia->SelectLimit($q_meses7) or die($cnx_cuzzicia->ErrorMsg());
		$diff7 = $excmeses7->Fields('diff');
		if($fecingre7<=$fecha7 and $diff7<=$depresec7->Fields('nrocuotas')){
			$totdep7[] = $depresec7->Fields('dep');
			$totdep7t[] = $depresec7->Fields('dep');
		}
		$depresec7->MoveNext();
		}
		//insumos
		$q_insusec7 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 and idseccion=$idsec and idorden=0");
		$insusec7 = $cnx_cuzzicia->SelectLimit($q_insusec7) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu7 = $insusec7->Fields('insu');
		$totinsu7t[] = $insusec7->Fields('insu');
		//mantenimiento
		$q_cosmante7 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7 and idseccion = $idsec");
		$excosmante7 = $cnx_cuzzicia->SelectLimit($q_cosmante7) or die($cnx_cuzzicia->ErrorMsg());
		$totmante7 = $excosmante7->Fields('costotal');
		$totmante7t[] = $excosmante7->Fields('costotal');
		//seguros
		$q_segsec7 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an7 ORDER BY fecha");
		$segusec7 = $cnx_cuzzicia->SelectLimit($q_segsec7) or die($cnx_cuzzicia->ErrorMsg());
		$totseg7[] = 0;
		$totseg7t[] = 0;
		while (!$segusec7->EOF) {
			$totseg7[] = $segusec7->Fields('pm');
			$totseg7t[] = $segusec7->Fields('pm');
		$segusec7->MoveNext();
		}
		//electricidad
		$q_facsec7 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7");
		$exfacsec7 = $cnx_cuzzicia->SelectLimit($q_facsec7) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri7[] = $factor7*$exfacsec7->Fields('tiempo');
		$totelectri7t[] = $factor7*$exfacsec7->Fields('tiempo');
		//generales planta
		$q_cosgplan7 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes7 and date_part('year',mes)=$an7 and idseccion=$idsec");
		$excosgplan7 = $cnx_cuzzicia->SelectLimit($q_cosgplan7) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp7 = ($excosgplan7->Fields('costotal')+$vartgn7)/$exsecti7->Fields('tiempo');
		$q_facgpsec7 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes7 and date_part('year',fecha)=$an7");
		$exfacgpsec7 = $cnx_cuzzicia->SelectLimit($q_facgpsec7) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan7[] = $factorgp7*$exfacgpsec7->Fields('tiempo');
		$totgenplan7t[] = $factorgp7*$exfacgpsec7->Fields('tiempo');
		//otros Gp
		$q_cosotros7 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes7 and date_part('year',mes)=$an7");
		$excosotros7 = $cnx_cuzzicia->SelectLimit($q_cosotros7) or die($cnx_cuzzicia->ErrorMsg());
		$tototros7 = $excosotros7->Fields('costotal');
		$tototros7t[] = $excosotros7->Fields('costotal');
		
		$totalt7[] = 0;
		array_splice($totalt7,0);
		$totalt7[] = array_sum($totgenplan7)+$totmante7+array_sum($totelectri7)+$totinsu7+array_sum($totseg7)+array_sum($total7)+$tototros7+array_sum($totdep7);
		if($vartgn7==0){
		$vartgn7 = array_sum($totalt7);}		
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6");
	$tiemsec6 = $cnx_cuzzicia->SelectLimit($q_tiemsec6) or die($cnx_cuzzicia->ErrorMsg());
	$totiem6t[] = $tiemsec6->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec6 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 GROUP BY idoperario ORDER BY idoperario");
	$operasec6 = $cnx_cuzzicia->SelectLimit($q_opesec6) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec6->RecordCount();
		while (!$operasec6->EOF) {
		$idope = $operasec6->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope6 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes6 and date_part('year',mes)=$an6 and idoperario=$idope");
		$exqcostoope6 = $cnx_cuzzicia->SelectLimit($q_costoope6) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 and idoperario=$idope");
		$exqtitoope6 = $cnx_cuzzicia->SelectLimit($q_titoope6) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra6 = $exqcostoope6->Fields('costotal')/$exqtitoope6->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 and idoperario = $idope");
		$extpopesec6 = $cnx_cuzzicia->SelectLimit($q_tpopesec6) or die($cnx_cuzzicia->ErrorMsg());
		$product6 = $extpopesec6->Fields('tiempo')*$costxhra6;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 and idoperario = $idope");
		$extiopesec6 = $cnx_cuzzicia->SelectLimit($q_tiopesec6) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts6 = $extiopesec6->Fields('tiempo')*$costxhra6;
		// consulta asignacion operarios
		$q_asigsec6 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec6 = $cnx_cuzzicia->SelectLimit($q_asigsec6) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 and idoperario = $idope");
		$extiopesin6 = $cnx_cuzzicia->SelectLimit($q_tiopesin6) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct6 = $exqasigsec6->Fields('porcent')*$costxhra6*$extiopesin6->Fields('tiempo');
		$totmoprod6[] = $product6;
		$totmoprod6t[] = $product6;
		$totmoinprosec6[] = $inproducts6;
		$totmoinprosec6t[] = $inproducts6;
		$totmoinprosinsec6[] = $inproduct6;
		$totmoinprosinsec6t[] = $inproduct6;
		$total6[] = $product6 + $inproducts6 + $inproduct6;
		$operasec6->MoveNext();
		}
		if($tRows_operasec==0){
		$total6[]=0;
		$totmoprod6t[]=0;
		$totmoprod6[]=0;
		$totmoinprosec6[] = 0;
		$totmoinprosec6t[] = 0;
		$totmoinprosinsec6[] = 0;
		$totmoinprosinsec6t[] = 0;}
		//depreciacion
		$q_depsec6 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha6' ORDER BY iddeprecia");
		$depresec6 = $cnx_cuzzicia->SelectLimit($q_depsec6) or die($cnx_cuzzicia->ErrorMsg());
		$totdep6[] = 0;
		$totdep6t[] = 0;
		while (!$depresec6->EOF) {
		$fecingre6 = $depresec6->Fields('fecingreso');
		$q_meses6 = sprintf("select (DATE '$fecha6'-'$fecingre6')/30 as diff;");
		$excmeses6 = $cnx_cuzzicia->SelectLimit($q_meses6) or die($cnx_cuzzicia->ErrorMsg());
		$diff6 = $excmeses6->Fields('diff');
		if($fecingre6<=$fecha6 and $diff6<=$depresec6->Fields('nrocuotas')){
			$totdep6[] = $depresec6->Fields('dep');
			$totdep6t[] = $depresec6->Fields('dep');
		}
		$depresec6->MoveNext();
		}
		//insumos
		$q_insusec6 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 and idseccion=$idsec and idorden=0");
		$insusec6 = $cnx_cuzzicia->SelectLimit($q_insusec6) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu6 = $insusec6->Fields('insu');
		$totinsu6t[] = $insusec6->Fields('insu');
		//mantenimiento
		$q_cosmante6 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6 and idseccion = $idsec");
		$excosmante6 = $cnx_cuzzicia->SelectLimit($q_cosmante6) or die($cnx_cuzzicia->ErrorMsg());
		$totmante6 = $excosmante6->Fields('costotal');
		$totmante6t[] = $excosmante6->Fields('costotal');
		//seguros
		$q_segsec6 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an6 ORDER BY fecha");
		$segusec6 = $cnx_cuzzicia->SelectLimit($q_segsec6) or die($cnx_cuzzicia->ErrorMsg());
		$totseg6[] = 0;
		$totseg6t[] = 0;
		while (!$segusec6->EOF) {
			$totseg6[] = $segusec6->Fields('pm');
			$totseg6t[] = $segusec6->Fields('pm');
		$segusec6->MoveNext();
		}
		//electricidad
		$q_facsec6 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6");
		$exfacsec6 = $cnx_cuzzicia->SelectLimit($q_facsec6) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri6[] = $factor6*$exfacsec6->Fields('tiempo');
		$totelectri6t[] = $factor6*$exfacsec6->Fields('tiempo');
		//generales planta
		$q_cosgplan6 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes6 and date_part('year',mes)=$an6 and idseccion=$idsec");
		$excosgplan6 = $cnx_cuzzicia->SelectLimit($q_cosgplan6) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp6 = ($excosgplan6->Fields('costotal')+$vartgn6)/$exsecti6->Fields('tiempo');
		$q_facgpsec6 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes6 and date_part('year',fecha)=$an6");
		$exfacgpsec6 = $cnx_cuzzicia->SelectLimit($q_facgpsec6) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan6[] = $factorgp6*$exfacgpsec6->Fields('tiempo');
		$totgenplan6t[] = $factorgp6*$exfacgpsec6->Fields('tiempo');
		//otros Gp
		$q_cosotros6 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes6 and date_part('year',mes)=$an6");
		$excosotros6 = $cnx_cuzzicia->SelectLimit($q_cosotros6) or die($cnx_cuzzicia->ErrorMsg());
		$tototros6 = $excosotros6->Fields('costotal');
		$tototros6t[] = $excosotros6->Fields('costotal');
		
		$totalt6[] = 0;
		array_splice($totalt6,0);
		$totalt6[] = array_sum($totgenplan6)+$totmante6+array_sum($totelectri6)+$totinsu6+array_sum($totseg6)+array_sum($total6)+$tototros6+array_sum($totdep6);
		if($vartgn6==0){
		$vartgn6 = array_sum($totalt6);}
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5");
	$tiemsec5 = $cnx_cuzzicia->SelectLimit($q_tiemsec5) or die($cnx_cuzzicia->ErrorMsg());
	$totiem5t[] = $tiemsec5->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec5 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 GROUP BY idoperario ORDER BY idoperario");
	$operasec5 = $cnx_cuzzicia->SelectLimit($q_opesec5) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec5->RecordCount();
		while (!$operasec5->EOF) {
		$idope = $operasec5->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope5 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes5 and date_part('year',mes)=$an5 and idoperario=$idope");
		$exqcostoope5 = $cnx_cuzzicia->SelectLimit($q_costoope5) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 and idoperario=$idope");
		$exqtitoope5 = $cnx_cuzzicia->SelectLimit($q_titoope5) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra5 = $exqcostoope5->Fields('costotal')/$exqtitoope5->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 and idoperario = $idope");
		$extpopesec5 = $cnx_cuzzicia->SelectLimit($q_tpopesec5) or die($cnx_cuzzicia->ErrorMsg());
		$product5 = $extpopesec5->Fields('tiempo')*$costxhra5;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 and idoperario = $idope");
		$extiopesec5 = $cnx_cuzzicia->SelectLimit($q_tiopesec5) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts5 = $extiopesec5->Fields('tiempo')*$costxhra5;
		// consulta asignacion operarios
		$q_asigsec5 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec5 = $cnx_cuzzicia->SelectLimit($q_asigsec5) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 and idoperario = $idope");
		$extiopesin5 = $cnx_cuzzicia->SelectLimit($q_tiopesin5) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct5 = $exqasigsec5->Fields('porcent')*$costxhra5*$extiopesin5->Fields('tiempo');
		$totmoprod5[] = $product5;
		$totmoprod5t[] = $product5;
		$totmoinprosec5[] = $inproducts5;
		$totmoinprosec5t[] = $inproducts5;
		$totmoinprosinsec5[] = $inproduct5;
		$totmoinprosinsec5t[] = $inproduct5;
		$total5[] = $product5 + $inproducts5 + $inproduct5;
		$operasec5->MoveNext();
		}
		if($tRows_operasec==0){
		$total5[]=0;
		$totmoprod5t[]=0;
		$totmoprod5[]=0;
		$totmoinprosec5[] = 0;
		$totmoinprosec5t[] = 0;
		$totmoinprosinsec5[] = 0;
		$totmoinprosinsec5t[] = 0;}
		//depreciacion
		$q_depsec5 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha5' ORDER BY iddeprecia");
		$depresec5 = $cnx_cuzzicia->SelectLimit($q_depsec5) or die($cnx_cuzzicia->ErrorMsg());
		$totdep5[] = 0;
		$totdep5t[] = 0;
		while (!$depresec5->EOF) {
		$fecingre5 = $depresec5->Fields('fecingreso');
		$q_meses5 = sprintf("select (DATE '$fecha5'-'$fecingre5')/30 as diff;");
		$excmeses5 = $cnx_cuzzicia->SelectLimit($q_meses5) or die($cnx_cuzzicia->ErrorMsg());
		$diff5 = $excmeses5->Fields('diff');
		if($fecingre5<=$fecha5 and $diff5<=$depresec5->Fields('nrocuotas')){
			$totdep5[] = $depresec5->Fields('dep');
			$totdep5t[] = $depresec5->Fields('dep');
		}
		$depresec5->MoveNext();
		}
		//insumos
		$q_insusec5 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 and idseccion=$idsec and idorden=0");
		$insusec5 = $cnx_cuzzicia->SelectLimit($q_insusec5) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu5 = $insusec5->Fields('insu');
		$totinsu5t[] = $insusec5->Fields('insu');
		//mantenimiento
		$q_cosmante5 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5 and idseccion = $idsec");
		$excosmante5 = $cnx_cuzzicia->SelectLimit($q_cosmante5) or die($cnx_cuzzicia->ErrorMsg());
		$totmante5 = $excosmante5->Fields('costotal');
		$totmante5t[] = $excosmante5->Fields('costotal');
		//seguros
		$q_segsec5 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an5 ORDER BY fecha");
		$segusec5 = $cnx_cuzzicia->SelectLimit($q_segsec5) or die($cnx_cuzzicia->ErrorMsg());
		$totseg5[] = 0;
		$totseg5t[] = 0;
		while (!$segusec5->EOF) {
			$totseg5[] = $segusec5->Fields('pm');
			$totseg5t[] = $segusec5->Fields('pm');
		$segusec5->MoveNext();
		}
		//electricidad
		$q_facsec5 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5");
		$exfacsec5 = $cnx_cuzzicia->SelectLimit($q_facsec5) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri5[] = $factor5*$exfacsec5->Fields('tiempo');
		$totelectri5t[] = $factor5*$exfacsec5->Fields('tiempo');
		//generales planta
		$q_cosgplan5 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes5 and date_part('year',mes)=$an5 and idseccion=$idsec");
		$excosgplan5 = $cnx_cuzzicia->SelectLimit($q_cosgplan5) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp5 = ($excosgplan5->Fields('costotal')+$vartgn5)/$exsecti5->Fields('tiempo');
		$q_facgpsec5 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes5 and date_part('year',fecha)=$an5");
		$exfacgpsec5 = $cnx_cuzzicia->SelectLimit($q_facgpsec5) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan5[] = $factorgp5*$exfacgpsec5->Fields('tiempo');
		$totgenplan5t[] = $factorgp5*$exfacgpsec5->Fields('tiempo');
		//otros Gp
		$q_cosotros5 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes5 and date_part('year',mes)=$an5");
		$excosotros5 = $cnx_cuzzicia->SelectLimit($q_cosotros5) or die($cnx_cuzzicia->ErrorMsg());
		$tototros5 = $excosotros5->Fields('costotal');
		$tototros5t[] = $excosotros5->Fields('costotal');
				
		$totalt5[] = 0;
		array_splice($totalt5,0);
		$totalt5[] = array_sum($totgenplan5)+$totmante5+array_sum($totelectri5)+$totinsu5+array_sum($totseg5)+array_sum($total5)+$tototros5+array_sum($totdep5);
		if($vartgn5==0){
		$vartgn5 = array_sum($totalt5);}
//---------------------------------------------------------------------------------
		$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4");
	$tiemsec4 = $cnx_cuzzicia->SelectLimit($q_tiemsec4) or die($cnx_cuzzicia->ErrorMsg());
	$totiem4t[] = $tiemsec4->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec4 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 GROUP BY idoperario ORDER BY idoperario");
	$operasec4 = $cnx_cuzzicia->SelectLimit($q_opesec4) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec4->RecordCount();
		while (!$operasec4->EOF) {
		$idope = $operasec4->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope4 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes4 and date_part('year',mes)=$an4 and idoperario=$idope");
		$exqcostoope4 = $cnx_cuzzicia->SelectLimit($q_costoope4) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 and idoperario=$idope");
		$exqtitoope4 = $cnx_cuzzicia->SelectLimit($q_titoope4) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra4 = $exqcostoope4->Fields('costotal')/$exqtitoope4->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 and idoperario = $idope");
		$extpopesec4 = $cnx_cuzzicia->SelectLimit($q_tpopesec4) or die($cnx_cuzzicia->ErrorMsg());
		$product4 = $extpopesec4->Fields('tiempo')*$costxhra4;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 and idoperario = $idope");
		$extiopesec4 = $cnx_cuzzicia->SelectLimit($q_tiopesec4) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts4 = $extiopesec4->Fields('tiempo')*$costxhra4;
		// consulta asignacion operarios
		$q_asigsec4 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec4 = $cnx_cuzzicia->SelectLimit($q_asigsec4) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 and idoperario = $idope");
		$extiopesin4 = $cnx_cuzzicia->SelectLimit($q_tiopesin4) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct4 = $exqasigsec4->Fields('porcent')*$costxhra4*$extiopesin4->Fields('tiempo');
		$totmoprod4[] = $product4;
		$totmoprod4t[] = $product4;
		$totmoinprosec4[] = $inproducts4;
		$totmoinprosec4t[] = $inproducts4;
		$totmoinprosinsec4[] = $inproduct4;
		$totmoinprosinsec4t[] = $inproduct4;
		$total4[] = $product4 + $inproducts4 + $inproduct4;
		$operasec4->MoveNext();
		}
		if($tRows_operasec==0){
		$total4[]=0;
		$totmoprod4t[]=0;
		$totmoprod4[]=0;
		$totmoinprosec4[] = 0;
		$totmoinprosec4t[] = 0;
		$totmoinprosinsec4[] = 0;
		$totmoinprosinsec4t[] = 0;}
		//depreciacion
		$q_depsec4 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha4' ORDER BY iddeprecia");
		$depresec4 = $cnx_cuzzicia->SelectLimit($q_depsec4) or die($cnx_cuzzicia->ErrorMsg());
		$totdep4[] = 0;
		$totdep4t[] = 0;
		while (!$depresec4->EOF) {
		$fecingre4 = $depresec4->Fields('fecingreso');
		$q_meses4 = sprintf("select (DATE '$fecha4'-'$fecingre4')/30 as diff;");
		$excmeses4 = $cnx_cuzzicia->SelectLimit($q_meses4) or die($cnx_cuzzicia->ErrorMsg());
		$diff4 = $excmeses4->Fields('diff');
		if($fecingre4<=$fecha4 and $diff4<=$depresec4->Fields('nrocuotas')){
			$totdep4[] = $depresec4->Fields('dep');
			$totdep4t[] = $depresec4->Fields('dep');
		}
		$depresec4->MoveNext();
		}
		//insumos
		$q_insusec4 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 and idseccion=$idsec and idorden=0");
		$insusec4 = $cnx_cuzzicia->SelectLimit($q_insusec4) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu4 = $insusec4->Fields('insu');
		$totinsu4t[] = $insusec4->Fields('insu');
		//mantenimiento
		$q_cosmante4 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4 and idseccion = $idsec");
		$excosmante4 = $cnx_cuzzicia->SelectLimit($q_cosmante4) or die($cnx_cuzzicia->ErrorMsg());
		$totmante4 = $excosmante4->Fields('costotal');
		$totmante4t[] = $excosmante4->Fields('costotal');
		//seguros
		$q_segsec4 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an4 ORDER BY fecha");
		$segusec4 = $cnx_cuzzicia->SelectLimit($q_segsec4) or die($cnx_cuzzicia->ErrorMsg());
		$totseg4[] = 0;
		$totseg4t[] = 0;
		while (!$segusec4->EOF) {
			$totseg4[] = $segusec4->Fields('pm');
			$totseg4t[] = $segusec4->Fields('pm');
		$segusec4->MoveNext();
		}
		//electricidad
		$q_facsec4 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4");
		$exfacsec4 = $cnx_cuzzicia->SelectLimit($q_facsec4) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri4[] = $factor4*$exfacsec4->Fields('tiempo');
		$totelectri4t[] = $factor4*$exfacsec4->Fields('tiempo');
		//generales planta
		$q_cosgplan4 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes4 and date_part('year',mes)=$an4 and idseccion=$idsec");
		$excosgplan4 = $cnx_cuzzicia->SelectLimit($q_cosgplan4) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp4 = ($excosgplan4->Fields('costotal')+$vartgn4)/$exsecti4->Fields('tiempo');
		$q_facgpsec4 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes4 and date_part('year',fecha)=$an4");
		$exfacgpsec4 = $cnx_cuzzicia->SelectLimit($q_facgpsec4) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan4[] = $factorgp4*$exfacgpsec4->Fields('tiempo');
		$totgenplan4t[] = $factorgp4*$exfacgpsec4->Fields('tiempo');
		//otros Gp
		$q_cosotros4 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes4 and date_part('year',mes)=$an4");
		$excosotros4 = $cnx_cuzzicia->SelectLimit($q_cosotros4) or die($cnx_cuzzicia->ErrorMsg());
		$tototros4 = $excosotros4->Fields('costotal');
		$tototros4t[] = $excosotros4->Fields('costotal');
		
		$totalt4[] = 0;
		array_splice($totalt4,0);
		$totalt4[] = array_sum($totgenplan4)+$totmante4+array_sum($totelectri4)+$totinsu4+array_sum($totseg4)+array_sum($total4)+$tototros4+array_sum($totdep4);
		if($vartgn4==0){
		$vartgn4 = array_sum($totalt4);}
//--------------------------------------------------------------------------------- 
	$idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3");
	$tiemsec3 = $cnx_cuzzicia->SelectLimit($q_tiemsec3) or die($cnx_cuzzicia->ErrorMsg());
	$totiem3t[] = $tiemsec3->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec3 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 GROUP BY idoperario ORDER BY idoperario");
	$operasec3 = $cnx_cuzzicia->SelectLimit($q_opesec3) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec3->RecordCount();
		while (!$operasec3->EOF) {
		$idope = $operasec3->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope3 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes3 and date_part('year',mes)=$an3 and idoperario=$idope");
		$exqcostoope3 = $cnx_cuzzicia->SelectLimit($q_costoope3) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 and idoperario=$idope");

		$exqtitoope3 = $cnx_cuzzicia->SelectLimit($q_titoope3) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra3 = $exqcostoope3->Fields('costotal')/$exqtitoope3->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 and idoperario = $idope");
		$extpopesec3 = $cnx_cuzzicia->SelectLimit($q_tpopesec3) or die($cnx_cuzzicia->ErrorMsg());
		$product3 = $extpopesec3->Fields('tiempo')*$costxhra3;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 and idoperario = $idope");
		$extiopesec3 = $cnx_cuzzicia->SelectLimit($q_tiopesec3) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts3 = $extiopesec3->Fields('tiempo')*$costxhra3;
		// consulta asignacion operarios
		$q_asigsec3 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec3 = $cnx_cuzzicia->SelectLimit($q_asigsec3) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 and idoperario = $idope");
		$extiopesin3 = $cnx_cuzzicia->SelectLimit($q_tiopesin3) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct3 = $exqasigsec3->Fields('porcent')*$costxhra3*$extiopesin3->Fields('tiempo');
		$totmoprod3[] = $product3;
		$totmoprod3t[] = $product3;
		$totmoinprosec3[] = $inproducts3;
		$totmoinprosec3t[] = $inproducts3;
		$totmoinprosinsec3[] = $inproduct3;
		$totmoinprosinsec3t[] = $inproduct3;
		$total3[] = $product3 + $inproducts3 + $inproduct3;
		$operasec3->MoveNext();
		}
		if($tRows_operasec==0){
		$total3[]=0;
		$totmoprod3t[]=0;
		$totmoprod3[]=0;
		$totmoinprosec3[] = 0;
		$totmoinprosec3t[] = 0;
		$totmoinprosinsec3[] = 0;
		$totmoinprosinsec3t[] = 0;}
		//depreciacion
		$q_depsec3 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha3' ORDER BY iddeprecia");
		$depresec3 = $cnx_cuzzicia->SelectLimit($q_depsec3) or die($cnx_cuzzicia->ErrorMsg());
		$totdep3[] = 0;
		$totdep3t[] = 0;
		while (!$depresec3->EOF) {
		$fecingre3 = $depresec3->Fields('fecingreso');
		$q_meses3 = sprintf("select (DATE '$fecha3'-'$fecingre3')/30 as diff;");
		$excmeses3 = $cnx_cuzzicia->SelectLimit($q_meses3) or die($cnx_cuzzicia->ErrorMsg());
		$diff3 = $excmeses3->Fields('diff');
		if($fecingre3<=$fecha3 and $diff3<=$depresec3->Fields('nrocuotas')){
			$totdep3[] = $depresec3->Fields('dep');
			$totdep3t[] = $depresec3->Fields('dep');
		}
		$depresec3->MoveNext();
		}
		//insumos
		$q_insusec3 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 and idseccion=$idsec and idorden=0");
		$insusec3 = $cnx_cuzzicia->SelectLimit($q_insusec3) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu3 = $insusec3->Fields('insu');
		$totinsu3t[] = $insusec3->Fields('insu');
		//mantenimiento
		$q_cosmante3 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3 and idseccion = $idsec");
		$excosmante3 = $cnx_cuzzicia->SelectLimit($q_cosmante3) or die($cnx_cuzzicia->ErrorMsg());
		$totmante3 = $excosmante3->Fields('costotal');
		$totmante3t[] = $excosmante3->Fields('costotal');
		//seguros
		$q_segsec3 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an3 ORDER BY fecha");
		$segusec3 = $cnx_cuzzicia->SelectLimit($q_segsec3) or die($cnx_cuzzicia->ErrorMsg());
		$totseg3[] = 0;
		$totseg3t[] = 0;
		while (!$segusec3->EOF) {
			$totseg3[] = $segusec3->Fields('pm');
			$totseg3t[] = $segusec3->Fields('pm');
		$segusec3->MoveNext();
		}
		//electricidad
		$q_facsec3 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3");
		$exfacsec3 = $cnx_cuzzicia->SelectLimit($q_facsec3) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri3[] = $factor3*$exfacsec3->Fields('tiempo');
		$totelectri3t[] = $factor3*$exfacsec3->Fields('tiempo');
		//generales planta
		$q_cosgplan3 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes3 and date_part('year',mes)=$an3 and idseccion=$idsec");
		$excosgplan3 = $cnx_cuzzicia->SelectLimit($q_cosgplan3) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp3 = ($excosgplan3->Fields('costotal')+$vartgn3)/$exsecti3->Fields('tiempo');
		$q_facgpsec3 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes3 and date_part('year',fecha)=$an3");
		$exfacgpsec3 = $cnx_cuzzicia->SelectLimit($q_facgpsec3) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan3[] = $factorgp3*$exfacgpsec3->Fields('tiempo');
		$totgenplan3t[] = $factorgp3*$exfacgpsec3->Fields('tiempo');
		//otros Gp
		$q_cosotros3 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes3 and date_part('year',mes)=$an3");
		$excosotros3 = $cnx_cuzzicia->SelectLimit($q_cosotros3) or die($cnx_cuzzicia->ErrorMsg());
		$tototros3 = $excosotros3->Fields('costotal');
		$tototros3t[] = $excosotros3->Fields('costotal');

		$totalt3[] = 0;
		array_splice($totalt3,0);
		$totalt3[] = array_sum($totgenplan3)+$totmante3+array_sum($totelectri3)+$totinsu3+array_sum($totseg3)+array_sum($total3)+$tototros3+array_sum($totdep3);
		if($vartgn3==0){
		$vartgn3 = array_sum($totalt3);}
//-----------------------------------------------------------------------------------------------
    $idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2");
	$tiemsec2 = $cnx_cuzzicia->SelectLimit($q_tiemsec2) or die($cnx_cuzzicia->ErrorMsg());
	$totiem2t[] = $tiemsec2->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec2 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 GROUP BY idoperario ORDER BY idoperario");
	$operasec2 = $cnx_cuzzicia->SelectLimit($q_opesec2) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec2->RecordCount();
		while (!$operasec2->EOF) {
		$idope = $operasec2->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope2 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes2 and date_part('year',mes)=$an2 and idoperario=$idope");
		$exqcostoope2 = $cnx_cuzzicia->SelectLimit($q_costoope2) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 and idoperario=$idope");
		$exqtitoope2 = $cnx_cuzzicia->SelectLimit($q_titoope2) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra2 = $exqcostoope2->Fields('costotal')/$exqtitoope2->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 and idoperario = $idope");
		$extpopesec2 = $cnx_cuzzicia->SelectLimit($q_tpopesec2) or die($cnx_cuzzicia->ErrorMsg());
		$product2 = $extpopesec2->Fields('tiempo')*$costxhra2;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 and idoperario = $idope");
		$extiopesec2 = $cnx_cuzzicia->SelectLimit($q_tiopesec2) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts2 = $extiopesec2->Fields('tiempo')*$costxhra2;
		// consulta asignacion operarios
		$q_asigsec2 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec2 = $cnx_cuzzicia->SelectLimit($q_asigsec2) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 and idoperario = $idope");
		$extiopesin2 = $cnx_cuzzicia->SelectLimit($q_tiopesin2) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct2 = $exqasigsec2->Fields('porcent')*$costxhra2*$extiopesin2->Fields('tiempo');
		$totmoprod2[] = $product2;
		$totmoprod2t[] = $product2;
		$totmoinprosec2[] = $inproducts2;
		$totmoinprosec2t[] = $inproducts2;
		$totmoinprosinsec2[] = $inproduct2;
		$totmoinprosinsec2t[] = $inproduct2;
		$total2[] = $product2 + $inproducts2 + $inproduct2;
		$operasec2->MoveNext();
		}
		if($tRows_operasec==0){
		$total2[]=0;
		$totmoprod2t[]=0;
		$totmoprod2[]=0;
		$totmoinprosec2[] = 0;
		$totmoinprosec2t[] = 0;
		$totmoinprosinsec2[] = 0;
		$totmoinprosinsec2t[] = 0;}
		//depreciacion
		$q_depsec2 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha2' ORDER BY iddeprecia");
		$depresec2 = $cnx_cuzzicia->SelectLimit($q_depsec2) or die($cnx_cuzzicia->ErrorMsg());
		$totdep2[] = 0;
		$totdep2t[] = 0;
		while (!$depresec2->EOF) {
		$fecingre2 = $depresec2->Fields('fecingreso');
		$q_meses2 = sprintf("select (DATE '$fecha2'-'$fecingre2')/30 as diff;");
		$excmeses2 = $cnx_cuzzicia->SelectLimit($q_meses2) or die($cnx_cuzzicia->ErrorMsg());
		$diff2 = $excmeses2->Fields('diff');
		if($fecingre2<=$fecha2 and $diff2<=$depresec2->Fields('nrocuotas')){
			$totdep2[] = $depresec2->Fields('dep');
			$totdep2t[] = $depresec2->Fields('dep');
		}
		$depresec2->MoveNext();
		}
		//insumos
		$q_insusec2 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 and idseccion=$idsec and idorden=0");
		$insusec2 = $cnx_cuzzicia->SelectLimit($q_insusec2) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu2 = $insusec2->Fields('insu');
		$totinsu2t[] = $insusec2->Fields('insu');
		//mantenimiento
		$q_cosmante2 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2 and idseccion = $idsec");
		$excosmante2 = $cnx_cuzzicia->SelectLimit($q_cosmante2) or die($cnx_cuzzicia->ErrorMsg());
		$totmante2 = $excosmante2->Fields('costotal');
		$totmante2t[] = $excosmante2->Fields('costotal');
		//seguros
		$q_segsec2 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an2 ORDER BY fecha");
		$segusec2 = $cnx_cuzzicia->SelectLimit($q_segsec2) or die($cnx_cuzzicia->ErrorMsg());
		$totseg2[] = 0;
		$totseg2t[] = 0;
		while (!$segusec2->EOF) {
			$totseg2[] = $segusec2->Fields('pm');
			$totseg2t[] = $segusec2->Fields('pm');
		$segusec2->MoveNext();
		}
		//electricidad
		$q_facsec2 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2");
		$exfacsec2 = $cnx_cuzzicia->SelectLimit($q_facsec2) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri2[] = $factor2*$exfacsec2->Fields('tiempo');
		$totelectri2t[] = $factor2*$exfacsec2->Fields('tiempo');
		//generales planta
		$q_cosgplan2 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes2 and date_part('year',mes)=$an2 and idseccion=$idsec");
		$excosgplan2 = $cnx_cuzzicia->SelectLimit($q_cosgplan2) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp2 = ($excosgplan2->Fields('costotal')+$vartgn2)/$exsecti2->Fields('tiempo');
		$q_facgpsec2 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes2 and date_part('year',fecha)=$an2");
		$exfacgpsec2 = $cnx_cuzzicia->SelectLimit($q_facgpsec2) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan2[] = $factorgp2*$exfacgpsec2->Fields('tiempo');
		$totgenplan2t[] = $factorgp2*$exfacgpsec2->Fields('tiempo');
		//otros Gp
		$q_cosotros2 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes2 and date_part('year',mes)=$an2");
		$excosotros2 = $cnx_cuzzicia->SelectLimit($q_cosotros2) or die($cnx_cuzzicia->ErrorMsg());
		$tototros2 = $excosotros2->Fields('costotal');
		$tototros2t[] = $excosotros2->Fields('costotal');
		
		$totalt2[] = 0;
		array_splice($totalt2,0);
		$totalt2[] = array_sum($totgenplan2)+$totmante2+array_sum($totelectri2)+$totinsu2+array_sum($totseg2)+array_sum($total2)+$tototros2+array_sum($totdep2);
		if($vartgn2==0){
		$vartgn2 = array_sum($totalt2);}
//-----------------------------------------------------------------------------------------------
    $idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1");
	$tiemsec1 = $cnx_cuzzicia->SelectLimit($q_tiemsec1) or die($cnx_cuzzicia->ErrorMsg());
	$totiem1t[] = $tiemsec1->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec1 = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 GROUP BY idoperario ORDER BY idoperario");
	$operasec1 = $cnx_cuzzicia->SelectLimit($q_opesec1) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec1->RecordCount();
		while (!$operasec1->EOF) {
		$idope = $operasec1->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope1 = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes1 and date_part('year',mes)=$an1 and idoperario=$idope");
		$exqcostoope1 = $cnx_cuzzicia->SelectLimit($q_costoope1) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 and idoperario=$idope");
		$exqtitoope1 = $cnx_cuzzicia->SelectLimit($q_titoope1) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra1 = $exqcostoope1->Fields('costotal')/$exqtitoope1->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 and idoperario = $idope");
		$extpopesec1 = $cnx_cuzzicia->SelectLimit($q_tpopesec1) or die($cnx_cuzzicia->ErrorMsg());
		$product1 = $extpopesec1->Fields('tiempo')*$costxhra1;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 and idoperario = $idope");
		$extiopesec1 = $cnx_cuzzicia->SelectLimit($q_tiopesec1) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts1 = $extiopesec1->Fields('tiempo')*$costxhra1;
		// consulta asignacion operarios
		$q_asigsec1 = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec1 = $cnx_cuzzicia->SelectLimit($q_asigsec1) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 and idoperario = $idope");
		$extiopesin1 = $cnx_cuzzicia->SelectLimit($q_tiopesin1) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct1 = $exqasigsec1->Fields('porcent')*$costxhra1*$extiopesin1->Fields('tiempo');
		$totmoprod1[] = $product1;
		$totmoprod1t[] = $product1;
		$totmoinprosec1[] = $inproducts1;
		$totmoinprosec1t[] = $inproducts1;
		$totmoinprosinsec1[] = $inproduct1;
		$totmoinprosinsec1t[] = $inproduct1;
		$total1[] = $product1 + $inproducts1 + $inproduct1;
		$operasec1->MoveNext();
		}
		if($tRows_operasec==0){
		$total1[]=0;
		$totmoprod1t[]=0;
		$totmoprod1[]=0;
		$totmoinprosec1[] = 0;
		$totmoinprosec1t[] = 0;
		$totmoinprosinsec1[] = 0;
		$totmoinprosinsec1t[] = 0;}
		//depreciacion
		$q_depsec1 = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fecha1' ORDER BY iddeprecia");
		$depresec1 = $cnx_cuzzicia->SelectLimit($q_depsec1) or die($cnx_cuzzicia->ErrorMsg());
		$totalRowsdep1 = $depresec1->RecordCount();
		$totdep1[] = 0;
		$totdep1t[] = 0;
		while (!$depresec1->EOF) {
		$fecingre1 = $depresec1->Fields('fecingreso');
		$q_meses1 = sprintf("select (DATE '$fecha1'-'$fecingre1')/30 as diff;");
		$excmeses1 = $cnx_cuzzicia->SelectLimit($q_meses1) or die($cnx_cuzzicia->ErrorMsg());
		$diff1 = $excmeses1->Fields('diff');
		if($fecingre1<=$fecha1 and $diff1<=$depresec1->Fields('nrocuotas')){
			$totdep1[] = $depresec1->Fields('dep');
			$totdep1t[] = $depresec1->Fields('dep');
		}
		$depresec1->MoveNext();
		}
		//insumos
		$q_insusec1 = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 and idseccion=$idsec and idorden=0");
		$insusec1 = $cnx_cuzzicia->SelectLimit($q_insusec1) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu1 = $insusec1->Fields('insu');
		$totinsu1t[] = $insusec1->Fields('insu');
		//mantenimiento
		$q_cosmante1 = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1 and idseccion = $idsec");
		$excosmante1 = $cnx_cuzzicia->SelectLimit($q_cosmante1) or die($cnx_cuzzicia->ErrorMsg());
		$totmante1 = $excosmante1->Fields('costotal');
		$totmante1t[] = $excosmante1->Fields('costotal');
		//seguros
		$q_segsec1 = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an1 ORDER BY fecha");
		$segusec1 = $cnx_cuzzicia->SelectLimit($q_segsec1) or die($cnx_cuzzicia->ErrorMsg());
		$totseg1[] = 0;
		$totseg1t[] = 0;
		while (!$segusec1->EOF) {
			$totseg1[] = $segusec1->Fields('pm');
			$totseg1t[] = $segusec1->Fields('pm');
		$segusec1->MoveNext();
		}
		//electricidad
		$q_facsec1 = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1");
		$exfacsec1 = $cnx_cuzzicia->SelectLimit($q_facsec1) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri1[] = $factor1*$exfacsec1->Fields('tiempo');
		$totelectri1t[] = $factor1*$exfacsec1->Fields('tiempo');
		//generales planta
		$q_cosgplan1 = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes1 and date_part('year',mes)=$an1 and idseccion=$idsec");
		$excosgplan1 = $cnx_cuzzicia->SelectLimit($q_cosgplan1) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp1 = ($excosgplan1->Fields('costotal')+$vartgn1)/$exsecti1->Fields('tiempo');
		$q_facgpsec1 = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes1 and date_part('year',fecha)=$an1");
		$exfacgpsec1 = $cnx_cuzzicia->SelectLimit($q_facgpsec1) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan1[] = $factorgp1*$exfacgpsec1->Fields('tiempo');
		$totgenplan1t[] = $factorgp1*$exfacgpsec1->Fields('tiempo');
		//otros Gp
		$q_cosotros1 = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes1 and date_part('year',mes)=$an1");
		$excosotros1 = $cnx_cuzzicia->SelectLimit($q_cosotros1) or die($cnx_cuzzicia->ErrorMsg());
		$tototros1 = $excosotros1->Fields('costotal');
		$tototros1t[] = $excosotros1->Fields('costotal');

		$totalt1[] = 0;
		array_splice($totalt1,0);
		$totalt1[] = array_sum($totgenplan1)+$totmante1+array_sum($totelectri1)+$totinsu1+array_sum($totseg1)+array_sum($total1)+$tototros1+array_sum($totdep1);
		if($vartgn1==0){
		$vartgn1 = array_sum($totalt1);}
//--------------------------------------------------------------------------------------------
    $idsec = $seccion->Fields('idseccion');
	// consulta tiempo productivo seccion
	$q_tiemsec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino=1 and idseccion = $idsec and date_part('month',fecha)=$mes and date_part('year',fecha)=$an");
	$tiemsec = $cnx_cuzzicia->SelectLimit($q_tiemsec) or die($cnx_cuzzicia->ErrorMsg());
	$totiemvt[] = $tiemsec->Fields('tiempo');
	// consulta operarios seccion
	$q_opesec = sprintf("SELECT idoperario FROM v_informes WHERE (idseccion = $idsec or idseccion=0) and date_part('month',fecha)=$mes and date_part('year',fecha)=$an GROUP BY idoperario ORDER BY idoperario");
	$operasec = $cnx_cuzzicia->SelectLimit($q_opesec) or die($cnx_cuzzicia->ErrorMsg());
	$tRows_operasec = $operasec->RecordCount();
		while (!$operasec->EOF) {
		$idope = $operasec->Fields('idoperario');
		//consultas para hallar costo x hora x operario
		$q_costoope = sprintf("SELECT sum(costototal) as costotal FROM v_operario WHERE date_part('month',mes)=$mes and date_part('year',mes)=$an and idoperario=$idope");
		$exqcostoope = $cnx_cuzzicia->SelectLimit($q_costoope) or die($cnx_cuzzicia->ErrorMsg());
		$q_titoope = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE date_part('month',fecha)=$mes and date_part('year',fecha)=$an and idoperario=$idope");
		$exqtitoope = $cnx_cuzzicia->SelectLimit($q_titoope) or die($cnx_cuzzicia->ErrorMsg());
		$costxhra = $exqcostoope->Fields('costotal')/$exqtitoope->Fields('tiempo');
		// consulta tiempos produc operario seccion
		$q_tpopesec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino=1 or iddestino = 2) and idseccion = $idsec and date_part('month',fecha)=$mes and date_part('year',fecha)=$an and idoperario = $idope");
		$extpopesec = $cnx_cuzzicia->SelectLimit($q_tpopesec) or die($cnx_cuzzicia->ErrorMsg());
		$product = $extpopesec->Fields('tiempo')*$costxhra;
		// consulta tiempos Inproduc operario seccion
		$q_tiopesec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE idoperacion = 5 and idseccion = $idsec and date_part('month',fecha)=$mes and date_part('year',fecha)=$an and idoperario = $idope");
		$extiopesec = $cnx_cuzzicia->SelectLimit($q_tiopesec) or die($cnx_cuzzicia->ErrorMsg());
		$inproducts = $extiopesec->Fields('tiempo')*$costxhra;
		// consulta asignacion operarios
		$q_asigsec = sprintf("SELECT porcentaje/100 as porcent FROM operario o, asignacion a WHERE idseccion=$idsec and (o.idoperario = a.idoperario) and o.idoperario = $idope");
		$exqasigsec = $cnx_cuzzicia->SelectLimit($q_asigsec) or die($cnx_cuzzicia->ErrorMsg());
		// consulta tiempos Inproduc operario sin seccion
		$q_tiopesin = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE (iddestino = 5 or iddestino = 6 or iddestino = 7 or iddestino = 8) and date_part('month',fecha)=$mes and date_part('year',fecha)=$an and idoperario = $idope");
		$extiopesin = $cnx_cuzzicia->SelectLimit($q_tiopesin) or die($cnx_cuzzicia->ErrorMsg());
		$inproduct = $exqasigsec->Fields('porcent')*$costxhra*$extiopesin->Fields('tiempo');
		$totmoprod[] = $product;
		$totmoprodt[] = $product;
		$totmoinprosec[] = $inproducts;
		$totmoinprosect[] = $inproducts;
		$totmoinprosinsec[] = $inproduct;
		$totmoinprosinsect[] = $inproduct;
		$total[] = $product + $inproducts + $inproduct;
		$operasec->MoveNext();
		}
		if($tRows_operasec==0){
		$total[]=0;
		$totmoprodt[]=0;
		$totmoprod[]=0;
		$totmoinprosec[] = 0;
		$totmoinprosect[] = 0;
		$totmoinprosinsec[] = 0;
		$totmoinprosinsect[] = 0;}
		//depreciacion
		$q_depsec = sprintf("SELECT d.iddeprecia,d.descripcion,dd.idseccion,d.fecingreso,d.importe,1/tasa*12 AS nrocuotas,d.tasa,d.importe/(1/tasa*12)*porcentaje as dep,dd.porcentaje FROM depreciacion d,distribuciond dd WHERE(d.iddeprecia = dd.iddeprecia) AND (idseccion = $idsec) and fecingreso<='$fechan' ORDER BY iddeprecia");
		$depresec = $cnx_cuzzicia->SelectLimit($q_depsec) or die($cnx_cuzzicia->ErrorMsg());
		$totdep[] = 0;
		$totdept[] = 0;
		while (!$depresec->EOF) {
		$fecingre = $depresec->Fields('fecingreso');
		$q_meses = sprintf("select (DATE '$fechan'-'$fecingre')/30 as diff;");
		$excmeses = $cnx_cuzzicia->SelectLimit($q_meses) or die($cnx_cuzzicia->ErrorMsg());
		$diff = $excmeses->Fields('diff');
		if($fecingre<=$fechan and $diff<=$depresec->Fields('nrocuotas')){
			$totdep[] = $depresec->Fields('dep');
			$totdept[] = $depresec->Fields('dep');

		}
		$depresec->MoveNext();
		}
		//insumos
		$q_insusec = sprintf("SELECT sum(vusoles*cantidad) as insu From movimientos WHERE motivo='5Consumo' and date_part('month',fecha)=$mes and date_part('year',fecha)=$an and idseccion=$idsec and idorden=0");
		$insusec = $cnx_cuzzicia->SelectLimit($q_insusec) or die($cnx_cuzzicia->ErrorMsg());
		$totinsu = $insusec->Fields('insu');
		$totinsut[] = $insusec->Fields('insu');
		//mantenimiento
		$q_cosmante = sprintf("SELECT costototal as costotal FROM costomante WHERE date_part('month',fecha)=$mes and date_part('year',fecha)=$an and idseccion = $idsec");
		$excosmante = $cnx_cuzzicia->SelectLimit($q_cosmante) or die($cnx_cuzzicia->ErrorMsg());
		$totmante = $excosmante->Fields('costotal');
		$totmantet[] = $excosmante->Fields('costotal');
		//seguros
		$q_segsec = sprintf("SELECT (prima/(13-date_part('month',fecha))*porcentaje) as pm From seguros s, distribucions ds WHERE s.idseguro=ds.idseguro and idseccion = $idsec and date_part('year',fecha)=$an ORDER BY fecha");
		$segusec = $cnx_cuzzicia->SelectLimit($q_segsec) or die($cnx_cuzzicia->ErrorMsg());
		$totseg[] = 0;
		$totsegt[] = 0;
		while (!$segusec->EOF) {
			$totseg[] = $segusec->Fields('pm');
			$totsegt[] = $segusec->Fields('pm');
		$segusec->MoveNext();
		}
		//electricidad
		$q_facsec = sprintf("SELECT sum(tiempo*potencia) as tiempo FROM v_informes WHERE (iddestino = 1) and idseccion = $idsec and date_part('month',fecha)=$mes and date_part('year',fecha)=$an");
		$exfacsec = $cnx_cuzzicia->SelectLimit($q_facsec) or die($cnx_cuzzicia->ErrorMsg());
		$totelectri[] = $factor*$exfacsec->Fields('tiempo');
		$totelectrit[] = $factor*$exfacsec->Fields('tiempo');
		//generales planta
		$q_cosgplan = sprintf("SELECT sum(costototal) as costotal FROM costogp WHERE date_part('month',mes)=$mes and date_part('year',mes)=$an and idseccion=$idsec");
		$excosgplan = $cnx_cuzzicia->SelectLimit($q_cosgplan) or die($cnx_cuzzicia->ErrorMsg());
		$factorgp = ($excosgplan->Fields('costotal')+$vartgn)/$exsecti->Fields('tiempo');
		$q_facgpsec = sprintf("SELECT sum(tiempo) as tiempo FROM v_informes WHERE iddestino = 1 and idseccion = $idsec and date_part('month',fecha)=$mes and date_part('year',fecha)=$an");
		$exfacgpsec = $cnx_cuzzicia->SelectLimit($q_facgpsec) or die($cnx_cuzzicia->ErrorMsg());
		$totgenplan[] = $factorgp*$exfacgpsec->Fields('tiempo');
		$totgenplant[] = $factorgp*$exfacgpsec->Fields('tiempo');
		//otros Gp
		$q_cosotros = sprintf("SELECT sum(costototal) as costotal FROM costotros WHERE idsec=$idsec and date_part('month',mes)=$mes and date_part('year',mes)=$an");
		$excosotros = $cnx_cuzzicia->SelectLimit($q_cosotros) or die($cnx_cuzzicia->ErrorMsg());
		$tototros = $excosotros->Fields('costotal');
		$tototrost[] = $excosotros->Fields('costotal');
		
		$totalt[] = 0;
		array_splice($totalt,0);
		$totalt[] = array_sum($totgenplan)+$totmante+array_sum($totelectri)+$totinsu+array_sum($totseg)+array_sum($total)+$tototros+array_sum($totdep);
		if($vartgn==0){
		$vartgn = array_sum($totalt);}
//-------------------------------------------------------------------------------------------
?>
  <tr>
    <td colspan="14" class="selected_cal"><hr>
    </td>
  </tr>
  <tr>
    <td class="KT_th">SECCION:</td>
    <td colspan="13"><?php echo $seccion->Fields('seccion'); ?></td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th"><?php echo $mes11.'/'.$an11; ?></td>
    <td class="KT_th"><?php echo $mes10.'/'.$an10; ?></td>
    <td class="KT_th"><?php echo $mes9.'/'.$an9; ?></td>
    <td class="KT_th"><?php echo $mes8.'/'.$an8; ?></td>
    <td class="KT_th"><?php echo $mes7.'/'.$an7; ?></td>
    <td class="KT_th"><?php echo $mes6.'/'.$an6; ?></td>
    <td class="KT_th"><?php echo $mes5.'/'.$an5; ?></td>
    <td class="KT_th"><?php echo $mes4.'/'.$an4; ?></td>
    <td class="KT_th"><?php echo $mes3.'/'.$an3; ?></td>
    <td class="KT_th"><?php echo $mes2.'/'.$an2; ?></td>
    <td class="KT_th"><?php echo $mes1.'/'.$an1 ?></td>
    <td class="KT_th"><?php echo $mes.'/'.$an; ?></td>
  </tr>
  <tr>
    <td width="202" height="17" class="KT_th">MO Productiva</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totmoprod11),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod10),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod9),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod8),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod7),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod6),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod5),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod4),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod3),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod2),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod1),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoprod),2);?></td>
  </tr>
  <tr>
    <td width="202" height="17" class="KT_th">MOIconSeccion</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec11),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec10),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec9),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec8),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec7),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec6),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec5),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec4),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec3),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec2),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec1),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec),2);?></td>
  </tr>
  <tr>
    <td class="KT_th">MOIsinSeccion</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec11),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec10),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec9),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec8),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec7),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec6),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec5),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec4),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec3),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec2),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec1),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec),2);?></td>
  </tr>
  <tr>
    <td class="KT_th">Insumos</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format($totinsu11,2); ?></td>
    <td align="right"><?php echo number_format($totinsu10,2); ?></td>
    <td align="right"><?php echo number_format($totinsu9,2); ?></td>
    <td align="right"><?php echo number_format($totinsu8,2); ?></td>
    <td align="right"><?php echo number_format($totinsu7,2); ?></td>
    <td align="right"><?php echo number_format($totinsu6,2); ?></td>
    <td align="right"><?php echo number_format($totinsu5,2); ?></td>
    <td align="right"><?php echo number_format($totinsu4,2); ?></td>
    <td align="right"><?php echo number_format($totinsu3,2); ?></td>
    <td align="right"><?php echo number_format($totinsu2,2); ?></td>
    <td align="right"><?php echo number_format($totinsu1,2); ?></td>
    <td align="right"><?php echo number_format($totinsu,2); ?></td>
  </tr>
  <tr>
    <td width="202" class="KT_th">Energia Electrica </td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totelectri11),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri10),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri9),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri8),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri7),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri6),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri5),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri4),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri3),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri2),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri1),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totelectri),2); ?></td>
    <?php
	/*
array_splice($totelectri,0);array_splice($totelectri1,0);array_splice($totelectri2,0);
array_splice($totelectri3,0);array_splice($totelectri4,0);array_splice($totelectri5,0);
array_splice($totelectri6,0);array_splice($totelectri7,0);array_splice($totelectri8,0);
array_splice($totelectri9,0);array_splice($totelectri10,0);array_splice($totelectri11,0);
array_splice($totelectri12,0);
*/?>
  </tr>
  <tr>
    <td width="202" class="KT_th">Depreciaci&oacute;n</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totdep11),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep10),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep9),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep8),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep7),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep6),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep5),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep4),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep3),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep2),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep1),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totdep),2); ?></td>
    <?php
array_splice($totdep,0);array_splice($totdep1,0);array_splice($totdep2,0);array_splice($totdep3,0);array_splice($totdep4,0);array_splice($totdep5,0);array_splice($totdep6,0);array_splice($totdep7,0);array_splice($totdep8,0);array_splice($totdep9,0);array_splice($totdep10,0);array_splice($totdep11,0);
?>
  </tr>
  <tr>
    <td class="KT_th">Seguros</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totseg11),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg10),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg9),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg8),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg7),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg6),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg5),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg4),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg3),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg2),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg1),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totseg),2); ?></td>
    <?php
/*array_splice($totseg,0);array_splice($totseg1,0);array_splice($totseg2,0);array_splice($totseg3,0);array_splice($totseg4,0);array_splice($totseg5,0);array_splice($totseg6,0);array_splice($totseg7,0);array_splice($totseg8,0);array_splice($totseg9,0);array_splice($totseg10,0);array_splice($totseg11,0);array_splice($totseg12,0);*/
?>
  </tr>
  <tr>
    <td class="KT_th">Mant. y rep.</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format($totmante11,2);?></td>
    <td align="right"><?php echo number_format($totmante10,2);?></td>
    <td align="right"><?php echo number_format($totmante9,2);?></td>
    <td align="right"><?php echo number_format($totmante8,2);?></td>
    <td align="right"><?php echo number_format($totmante7,2);?></td>
    <td align="right"><?php echo number_format($totmante6,2);?></td>
    <td align="right"><?php echo number_format($totmante5,2);?></td>
    <td align="right"><?php echo number_format($totmante4,2);?></td>
    <td align="right"><?php echo number_format($totmante3,2);?></td>
    <td align="right"><?php echo number_format($totmante2,2);?></td>
    <td align="right"><?php echo number_format($totmante1,2);?></td>
    <td align="right"><?php echo number_format($totmante,2);?></td>
  </tr>
  <tr>
    <td class="KT_th">Generales Planta</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totgenplan11),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan10),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan9),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan8),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan7),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan6),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan5),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan4),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan3),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan2),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan1),2); ?></td>
    <td align="right"><?php echo number_format(array_sum($totgenplan),2); ?></td>
    <?php
/*array_splice($totgenplan,0);array_splice($totgenplan1,0);array_splice($totgenplan2,0);array_splice($totgenplan3,0);array_splice($totgenplan4,0);array_splice($totgenplan5,0);array_splice($totgenplan6,0);array_splice($totgenplan7,0);array_splice($totgenplan8,0);array_splice($totgenplan9,0);array_splice($totgenplan10,0);array_splice($totgenplan11,0);array_splice($totgenplan12,0);*/
?>
  </tr>
  <tr>
    <td class="KT_th">Otros</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format($tototros11,2);?></td>
    <td align="right"><?php echo number_format($tototros10,2);?></td>
    <td align="right"><?php echo number_format($tototros9,2);?></td>
    <td align="right"><?php echo number_format($tototros8,2);?></td>
    <td align="right"><?php echo number_format($tototros7,2);?></td>
    <td align="right"><?php echo number_format($tototros6,2);?></td>
    <td align="right"><?php echo number_format($tototros5,2);?></td>
    <td align="right"><?php echo number_format($tototros4,2);?></td>
    <td align="right"><?php echo number_format($tototros3,2);?></td>
    <td align="right"><?php echo number_format($tototros2,2);?></td>
    <td align="right"><?php echo number_format($tototros1,2);?></td>
    <td align="right"><?php echo number_format($tototros,2);?></td>
    <?php
/*array_splice($tototros,0);array_splice($tototros1,0);array_splice($tototros2,0);array_splice($tototros3,0);array_splice($tototros4,0);array_splice($tototros5,0);array_splice($tototros6,0);array_splice($tototros7,0);array_splice($tototros8,0);array_splice($tototros9,0);array_splice($tototros10,0);array_splice($tototros11,0);array_splice($tototros12,0);*/
?>
  </tr>
  <tr>
    <td class="KT_th">Total S/.</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php echo number_format(array_sum($totalt11),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt10),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt9),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt8),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt7),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt6),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt5),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt4),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt3),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt2),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt1),2);?></td>
    <td align="right"><?php echo number_format(array_sum($totalt),2);?></td>
  </tr>
  <tr>
    <td class="KT_th"><strong>Horas Producci&oacute;n </strong></td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php $totiem11 = $tiemsec11->Fields('tiempo');
	  	echo number_format($totiem11, 2); ?>
    </td>
    <td align="right"><?php $totiem10 = $tiemsec10->Fields('tiempo');
	  	echo number_format($totiem10, 2); ?>
    </td>
    <td align="right"><?php $totiem9 = $tiemsec9->Fields('tiempo');
	  	echo number_format($totiem9, 2); ?>
    </td>
    <td align="right"><?php $totiem8 = $tiemsec8->Fields('tiempo');
	  	echo number_format($totiem8, 2); ?>
    </td>
    <td align="right"><?php $totiem7 = $tiemsec7->Fields('tiempo');
	  	echo number_format($totiem7, 2); ?>
    </td>
    <td align="right"><?php $totiem6 = $tiemsec6->Fields('tiempo');
	  	echo number_format($totiem6, 2); ?>
    </td>
    <td align="right"><?php $totiem5 = $tiemsec5->Fields('tiempo');
	  	echo number_format($totiem5, 2); ?>
    </td>
    <td align="right"><?php $totiem4 = $tiemsec4->Fields('tiempo');
	  	echo number_format($totiem4, 2); ?>
    </td>
    <td align="right"><?php $totiem3 = $tiemsec3->Fields('tiempo');
	  	echo number_format($totiem3, 2); ?>
    </td>
    <td align="right"><?php $totiem2 = $tiemsec2->Fields('tiempo');
	  	echo number_format($totiem2, 2); ?>
    </td>
    <td align="right"><?php $totiem1 = $tiemsec1->Fields('tiempo');
	  	echo number_format($totiem1, 2); ?>
    </td>
    <td align="right"><?php $totiem = $tiemsec->Fields('tiempo');
	  	echo number_format($totiem, 2); ?>
    </td>
  </tr>
  <tr>
    <td class="KT_th">Costo x hora </td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php if ($totiem11 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt11)/$totiem11, 2);
	array_splice($totalt11,0);} ?>
    </td>
    <td align="right"><?php if ($totiem10 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt10)/$totiem10, 2);
	array_splice($totalt10,0);} ?>
    </td>
    <td align="right"><?php if ($totiem9 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt9)/$totiem9, 2);
	array_splice($totalt9,0);} ?>
    </td>
    <td align="right"><?php if ($totiem8 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt8)/$totiem8, 2);
	array_splice($totalt8,0);} ?>
    </td>
    <td align="right"><?php if ($totiem7 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt7)/$totiem7, 2);
	array_splice($totalt7,0);} ?>
    </td>
    <td align="right"><?php if ($totiem6 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt6)/$totiem6, 2);
	array_splice($totalt6,0);} ?>
    </td>
    <td align="right"><?php if ($totiem5 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt5)/$totiem5, 2);
	array_splice($totalt5,0);} ?>
    </td>
    <td align="right"><?php if ($totiem4 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt4)/$totiem4, 2);
	array_splice($totalt4,0);} ?>
    </td>
    <td align="right"><?php if ($totiem3 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt3)/$totiem3, 2);
	array_splice($totalt3,0);} ?>
    </td>
    <td align="right"><?php if ($totiem2 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt2)/$totiem2, 2);
	array_splice($totalt2,0);} ?>
    </td>
    <td align="right"><?php if ($totiem1 == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt1)/$totiem1, 2);
	array_splice($totalt1,0);} ?>
    </td>
    <td align="right"><?php if ($totiem == 0){
	echo number_format(0, 2);}else{
	echo number_format(array_sum($totalt)/$totiem, 2);
	array_splice($totalt,0);} ?>
    </td>
  </tr>
  <tr>
    <?php $tft[] = $seccion->Fields('vsoles');?>
    <td class="KT_th">Tarifa</td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
    <td align="right"><?php $tf = $seccion->Fields('vsoles');
	echo number_format($tf,2);?>
    </td>
  </tr>
  <?php
  //resetear arrays MO
	array_splice($totmoprod11,0);array_splice($totmoinprosec11,0);array_splice($totmoinprosinsec11,0);array_splice($total11,0);
	array_splice($totmoprod10,0);array_splice($totmoinprosec10,0);array_splice($totmoinprosinsec10,0);array_splice($total10,0);
	array_splice($totmoprod9,0);array_splice($totmoinprosec9,0);array_splice($totmoinprosinsec9,0);array_splice($total9,0);
	array_splice($totmoprod8,0);array_splice($totmoinprosec8,0);array_splice($totmoinprosinsec8,0);array_splice($total8,0);
	array_splice($totmoprod7,0);array_splice($totmoinprosec7,0);array_splice($totmoinprosinsec7,0);array_splice($total7,0);
	array_splice($totmoprod6,0);array_splice($totmoinprosec6,0);array_splice($totmoinprosinsec6,0);array_splice($total6,0);
	array_splice($totmoprod5,0);array_splice($totmoinprosec5,0);array_splice($totmoinprosinsec5,0);array_splice($total5,0);
	array_splice($totmoprod4,0);array_splice($totmoinprosec4,0);array_splice($totmoinprosinsec4,0);array_splice($total4,0);
	array_splice($totmoprod3,0);array_splice($totmoinprosec3,0);array_splice($totmoinprosinsec3,0);array_splice($total3,0);
	array_splice($totmoprod2,0);array_splice($totmoinprosec2,0);array_splice($totmoinprosinsec2,0);array_splice($total2,0);
	array_splice($totmoprod1,0);array_splice($totmoinprosec1,0);array_splice($totmoinprosinsec1,0);array_splice($total1,0);
	array_splice($totmoprod,0);array_splice($totmoinprosec,0);array_splice($totmoinprosinsec,0);array_splice($total,0);
	//resetear arrays seguros
array_splice($totseg,0);array_splice($totseg1,0);array_splice($totseg2,0);array_splice($totseg3,0);array_splice($totseg4,0);array_splice($totseg5,0);array_splice($totseg6,0);array_splice($totseg7,0);array_splice($totseg8,0);array_splice($totseg9,0);array_splice($totseg10,0);array_splice($totseg11,0);
	//resetear arrays electricidad
	array_splice($totelectri,0);array_splice($totelectri1,0);array_splice($totelectri2,0);
array_splice($totelectri3,0);array_splice($totelectri4,0);array_splice($totelectri5,0);
array_splice($totelectri6,0);array_splice($totelectri7,0);array_splice($totelectri8,0);
array_splice($totelectri9,0);array_splice($totelectri10,0);array_splice($totelectri11,0);
	//resetear arrays generales planta
	array_splice($totgenplan,0);array_splice($totgenplan1,0);array_splice($totgenplan2,0);array_splice($totgenplan3,0);array_splice($totgenplan4,0);array_splice($totgenplan5,0);array_splice($totgenplan6,0);array_splice($totgenplan7,0);array_splice($totgenplan8,0);array_splice($totgenplan9,0);array_splice($totgenplan10,0);array_splice($totgenplan11,0);
	
	$seccion->MoveNext();
  }
?>
</table>
<p align="center"><a href="reptarifasecdep3x.php?fecha=<? echo $fecha; ?>">SIGUIENTE</a></p>
</body>
</html>
<?php
$seccion->Close();
$exfacgac->Close();
?>