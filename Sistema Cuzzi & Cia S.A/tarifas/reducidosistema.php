<?php
set_time_limit(0);
include_once('config.php');
include_once('conexionpostgres.php');
require_once('../includes/wdg/WDG.php');
?>
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
if (isset($_POST['fecha']) && $_POST['fecha']<>"") {

$cone=new conexion(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
$funciones=new fposg(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
//$con=$cone->Conexion("");
$tiempo_inicio = microtime(true);
// begin Recordset
$bdata=$funciones->BorrarData();
$seccion=new seccion(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
$seccion->conectar();
//$query_tarifas = "SELECT * FROM v_tarifas where idseccion<>0 ORDER BY seccion";
//$tarifas = $cnx_cuzzicia->SelectLimit($query_tarifas) or die($cnx_cuzzicia->ErrorMsg());
//$vtarifas=new fvtarifas(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
//
//------------------descomentar estas lineas para cambiar de funcion
$vtarifas=new fvtarifas2(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
//
$factor=new factor(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
$factor->conectar();
$depreciacion=new depreciacion(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
$seguros=new seguros(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
$factgac = $factor->get_factor();
$Opesecion=new opseccion(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
//$fecha = '2009/06/30';

  $fec = $_POST['fecha'];
  $fecfecha = strtotime($fec); 
  $anio = date("Y",$fecfecha);
  $mes = date("m",$fecfecha);
  if($mes==1){
  $mes = 12;
  $anio = $anio-1;
  }//else{$mes = $mes-1;}  
  $dia = date("t",$fecfecha);
  $fecha = $anio."/".$mes."/".$dia;

}

?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<form action="reducidosistema.php" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
 
  <TR>
    <TD>Fecha FIN </TD>
    <TD><label>
    <input name="fecha" id="fecha" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
    </label></TD>
  </TR>
  <TR>
    <TD>(yyyy/mm/dd)</TD>
    <TD><input name="mostrar" type="submit" id="fecini_btn" value="Mostrar"></TD>
  </TR>
</table>
</form>
<?php
if (isset($_POST['fecha']) && $_POST['fecha']<>"") {

$Insert=$funciones->insertFecReporte(1,$fecha);

  $mes=new meses(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
	$mes->fechas($fecha);
$vartgn12=0;$vartgn11=0;$vartgn10=0;$vartgn9=0;$vartgn8=0;$vartgn7=0;$vartgn6=0;$vartgn5=0;$vartgn4=0;$vartgn3=0;$vartgn2=0;;$vartgn1=0;$vartgn=0;
//-----------consultas unicas sin depender de secciones-------------
//consultas para calculo electricidad 13 meses
        
        $extotsec12 =  $funciones->electricidad_a($mes->get_mes12(),$mes->get_anio12());		
		$excoselec12 =  $funciones->electricidad_b($mes->get_mes12(),$mes->get_anio12());
		$factor12 = $excoselec12/$extotsec12;
    
        $extotsec11 =  $funciones->electricidad_a($mes->get_mes11(),$mes->get_anio11());		
		$excoselec11 =  $funciones->electricidad_b($mes->get_mes11(),$mes->get_anio11());
		$factor11 = $excoselec11/$extotsec11;
    
        $extotsec10 =  $funciones->electricidad_a($mes->get_mes10(),$mes->get_anio10());		
		$excoselec10 =  $funciones->electricidad_b($mes->get_mes10(),$mes->get_anio10());
		$factor10 = $excoselec10/$extotsec10;
    
        $extotsec9 =  $funciones->electricidad_a($mes->get_mes9(),$mes->get_anio9());		
		$excoselec9 =  $funciones->electricidad_b($mes->get_mes9(),$mes->get_anio9());
		$factor9 = $excoselec9/$extotsec9;
    
        $extotsec8 =  $funciones->electricidad_a($mes->get_mes8(),$mes->get_anio8());		
		$excoselec8 =  $funciones->electricidad_b($mes->get_mes8(),$mes->get_anio8());
		$factor8 = $excoselec8/$extotsec8;
    
        $extotsec7 =  $funciones->electricidad_a($mes->get_mes7(),$mes->get_anio7());		
		$excoselec7 =  $funciones->electricidad_b($mes->get_mes7(),$mes->get_anio7());
		$factor7 = $excoselec7/$extotsec7;
    
        $extotsec6 =  $funciones->electricidad_a($mes->get_mes6(),$mes->get_anio6());		
		$excoselec6 =  $funciones->electricidad_b($mes->get_mes6(),$mes->get_anio6());
		$factor6 = $excoselec6/$extotsec6;
    
        $extotsec5 =  $funciones->electricidad_a($mes->get_mes5(),$mes->get_anio5());		
		$excoselec5 =  $funciones->electricidad_b($mes->get_mes5(),$mes->get_anio5());
		$factor5 = $excoselec5/$extotsec5;
    
        $extotsec4 =  $funciones->electricidad_a($mes->get_mes4(),$mes->get_anio4());		
		$excoselec4 =  $funciones->electricidad_b($mes->get_mes4(),$mes->get_anio4());
		$factor4 = $excoselec4/$extotsec4;
    
        $extotsec3 =  $funciones->electricidad_a($mes->get_mes3(),$mes->get_anio3());		
		$excoselec3 =  $funciones->electricidad_b($mes->get_mes3(),$mes->get_anio3());
		$factor3 = $excoselec3/$extotsec3;
        
        $extotsec2 =  $funciones->electricidad_a($mes->get_mes2(),$mes->get_anio2());		
		$excoselec2 =  $funciones->electricidad_b($mes->get_mes2(),$mes->get_anio2());
		$factor2 = $excoselec2/$extotsec2;
    
        $extotsec1 =  $funciones->electricidad_a($mes->get_mes1(),$mes->get_anio1());		
		$excoselec1 =  $funciones->electricidad_b($mes->get_mes1(),$mes->get_anio1());
		$factor1 = $excoselec1/$extotsec1;
    
        $extotsec =  $funciones->electricidad_a($mes->get_mes(),$mes->get_anio());		
		$excoselec =  $funciones->electricidad_b($mes->get_mes(),$mes->get_anio());
		$factor = $excoselec/$extotsec;   
   //generales planta
        $exsecti12 = $funciones->generalesplanta($mes->get_mes12(),$mes->get_anio12());
        //echo "$ exsecti12=".$exsecti12."<br>";
        $exsecti11 = $funciones->generalesplanta($mes->get_mes11(),$mes->get_anio11());
        $exsecti10 = $funciones->generalesplanta($mes->get_mes10(),$mes->get_anio10());
        $exsecti9 = $funciones->generalesplanta($mes->get_mes9(),$mes->get_anio9());
        $exsecti8 = $funciones->generalesplanta($mes->get_mes8(),$mes->get_anio8());
        $exsecti7 = $funciones->generalesplanta($mes->get_mes7(),$mes->get_anio7());
        $exsecti6 = $funciones->generalesplanta($mes->get_mes6(),$mes->get_anio6());
        $exsecti5 = $funciones->generalesplanta($mes->get_mes5(),$mes->get_anio5());
        $exsecti4 = $funciones->generalesplanta($mes->get_mes4(),$mes->get_anio4());
        $exsecti3 = $funciones->generalesplanta($mes->get_mes3(),$mes->get_anio3());
        $exsecti2 = $funciones->generalesplanta($mes->get_mes2(),$mes->get_anio2());
        $exsecti1 = $funciones->generalesplanta($mes->get_mes1(),$mes->get_anio1());
        $exsecti = $funciones->generalesplanta($mes->get_mes(),$mes->get_anio());    
?>
<table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
  <?php
  $x=0;
    while (!$seccion->EOF) {
     //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec12=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio12(),$mes->get_mes12());
    //echo "$ tiemsec12=".$tiemsec12."<br>";
    $totiem12t[] =$tiemsec12;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio12(),$mes->get_mes12());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
      //      echo "idope=".$idope."<br>";
            //consultas para hallar costo x hora x operario
            $exqcostoope12 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio12(),$mes->get_mes12());
        //    echo "$ exqcostoope12=".$exqcostoope12."<br>";
            $exqtitoope12 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio12(),$mes->get_mes12());
          //  echo "$ exqtitoope12=".$exqtitoope12."<br>";
            $costxhra12 = $exqcostoope12/$exqtitoope12;
           //echo "$ costxhra12=".$exqcostoope12/$exqtitoope12."<br>";
            // consulta tiempos produc operario seccion
            $product12=$funciones->tprodopesec($idsec,$mes->get_mes12(),$mes->get_anio12(),$idope)*$costxhra12;
            //echo "$ product12=".$product12."<br>";
            // consulta tiempos Inproduc operario seccion
            $inproducts12 =$funciones->timprodopesec($idsec,$mes->get_mes12(),$mes->get_anio12(),$idope)*$costxhra12;
            //echo "$ inproducts12=".$inproducts12."<br>";
            // consulta asignacion operarios
            $exqasigsec12=$funciones->asignacionope($idsec,$idope);
            //echo "$ exqasigsec12=".$exqasigsec12."<br>";
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin12=$funciones->timpopesinsec($mes->get_mes12(),$mes->get_anio12(),$idope);
            //echo "$ extiopesin12=".$extiopesin12."<br>";
            $inproduct12 = $exqasigsec12*$costxhra12*$extiopesin12;
            //echo "$ inproduct12=".$inproduct12."<br>";
            $totmoprod12[] = $product12;
            $totmoprod12t[] = $product12;
            $totmoinprosec12[] = $inproducts12;
            $totmoinprosec12t[] = $inproducts12;
            $totmoinprosinsec12[] = $inproduct12;
            $totmoinprosinsec12t[] = $inproduct12;
            $total12[] = $product12 + $inproducts12 + $inproduct12;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total12[]=0;
                $totmoinprosec12t[]=0;
                $totmoprod12t[]=0;
                $totmoprod12[]=0;
                $totmoinprosec12[]=0;
                $totmoinprosec12t[]=0;
                $totmoinprosinsec12[]=0;
                $totmoinprosinsec12t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha12());
        $depreciacion->moveFirst();
        $totdep12[] = 0;
        $totdep12t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre12 =$depreciacion->get_fecingreso();
            //echo "-------------$ fecingre12=".$fecingre12."<br>";
            $diff12=$funciones->diferenciafechas($mes->get_fecha12(),$fecingre12);
            //echo "-------------$ diff12=".$diff12."<br>";
            if($fecingre12<=$mes->get_fecha12() and $diff12<=$depreciacion->get_nrocuotas())
                {
                    $totdep12[] = $depreciacion->get_dep ();
              //      echo "-------------$ totdep12=".$depreciacion->get_dep()."<br>";
                    $totdep12t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec12=$funciones->insumos($mes->get_mes12(),$mes->get_anio12(),$idsec);
        //echo "$ insusec12=".$insusec12."<br>";
        $totinsu12=$insusec12;
        $totinsu12t[]=$insusec12;
        //mantenimiento
        $excosmante12=$funciones->consumos($mes->get_mes12(),$mes->get_anio12(),$idsec);
        //echo "$ excosmante12=".$excosmante12."<br>";
        $totmante12 =$excosmante12;
        $totmante12t[] =$excosmante12;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio12(),$mes->get_mes12());
        $seguros->moveFirst();
        $totseg12[] = 0;
        $totseg12t[] = 0;
        while (!$seguros->EOF) {
            $totseg12[] = $seguros->get_pm();
          //  echo "-----------$ totseg12[]=".$seguros->get_pm()."<br>";
            $totseg12t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec12=$funciones->electricidad2($idsec,$mes->get_mes12(),$mes->get_anio12());
        $totelectri12[] =$factor12*$exfacsec12;
        //echo "$ totelectri12[]=".$factor12*$exfacsec12."<br>";
        $totelectri12t[] =$factor12*$exfacsec12;
        //costo generales planta
        $excosgplan12=$funciones->genplanta($mes->get_mes12(),$mes->get_anio12(),$idsec);
        $factorgp12 = ($excosgplan12+$vartgn12)/$exsecti12;
        //echo "$ factorgp12=".$factorgp12."<br>";
        //factor generales planta por seccion
        $exfacgpsec12 = $funciones->facgpseccion($idsec,$mes->get_mes12(),$mes->get_anio12());
        if($idsec<>20)
        {	$totgenplan12[] = $factorgp12*$exfacgpsec12;
          //  echo "$ totgenplan12[]=".$factorgp12*$exfacgpsec12."<br>";
        }
        else
        { 	
        	$totgenplan12[] = $excosgplan12;
        	//echo "$ totgenplan12[]=".$exfacgpsec12."<br>";
        }
        //otros Gp
        $excosotros12=$funciones->otrosgp($idsec,$mes->get_mes12(),$mes->get_anio12());
        $tototros12 = $excosotros12;
        //echo "$ tototros12=".$tototros12."<br>";
        $tototros12t[] = $excosotros12;
        
        $totalt12[] = 0;
        array_splice($totalt12,0);
        $totalt12[] = array_sum($totgenplan12)+$totmante12+array_sum($totelectri12)+$totinsu12+array_sum($totseg12)+array_sum($total12)+$tototros12+array_sum($totdep12);
        //echo "$ totalt12 [ ]=".array_sum($totgenplan12)+$totmante12+array_sum($totelectri12)+$totinsu12+array_sum($totseg12)+array_sum($total12)+$tototros12+array_sum($totdep12)."<br>";
        if($vartgn12==0){
        $vartgn12 = array_sum($totalt12);
        //echo "$ vartgn12=".array_sum($totalt12)."<br>";
        }
    //---------------------------------------------------------------------------------
   //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec11=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio11(),$mes->get_mes11());
    $totiem11t[] =$tiemsec11;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio11(),$mes->get_mes11());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope11 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio11(),$mes->get_mes11());
            $exqtitoope11 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio11(),$mes->get_mes11());
            $costxhra11 = $exqcostoope11/$exqtitoope11;
            // consulta tiempos produc operario seccion
            $product11=$funciones->tprodopesec($idsec,$mes->get_mes11(),$mes->get_anio11(),$idope)*$costxhra11;
            // consulta tiempos Inproduc operario seccion
            $inproducts11 =$funciones->timprodopesec($idsec,$mes->get_mes11(),$mes->get_anio11(),$idope)*$costxhra11;
            // consulta asignacion operarios
            $exqasigsec11=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin11=$funciones->timpopesinsec($mes->get_mes11(),$mes->get_anio11(),$idope);
            $inproduct11 = $exqasigsec11*$costxhra11*$extiopesin11;
            $totmoprod11[] = $product11;
            $totmoprod11t[] = $product11;
            $totmoinprosec11[] = $inproducts11;
            $totmoinprosec11t[] = $inproducts11;
            $totmoinprosinsec11[] = $inproduct11;
            $totmoinprosinsec11t[] = $inproduct11;
            $total11[] = $product11 + $inproducts11 + $inproduct11;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total11[]=0;
                $totmoinprosec11t[]=0;
                $totmoprod11t[]=0;
                $totmoprod11[]=0;
                $totmoinprosec11[]=0;
                $totmoinprosec11t[]=0;
                $totmoinprosinsec11[]=0;
                $totmoinprosinsec11t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha11());
        $depreciacion->moveFirst();
        $totdep11[] = 0;
        $totdep11t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre11 =$depreciacion->get_fecingreso();
            $diff11=$funciones->diferenciafechas($mes->get_fecha11(),$fecingre11);
            if($fecingre11<=$mes->get_fecha11() and $diff11<=$depreciacion->get_nrocuotas())
                {
                    $totdep11[] = $depreciacion->get_dep ();
                    $totdep11t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec11=$funciones->insumos($mes->get_mes11(),$mes->get_anio11(),$idsec);
        $totinsu11=$insusec11;
        $totinsu11t[]=$insusec11;
        //mantenimiento
        $excosmante11=$funciones->consumos($mes->get_mes11(),$mes->get_anio11(),$idsec);
        $totmante11 =$excosmante11;
        $totmante11t[] =$excosmante11;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio11(),$mes->get_mes11());
        $seguros->moveFirst();
        $totseg11[] = 0;
        $totseg11t[] = 0;
        while (!$seguros->EOF) {
            $totseg11[] = $seguros->get_pm();
            $totseg11t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec11=$funciones->electricidad2($idsec,$mes->get_mes11(),$mes->get_anio11());
        $totelectri11[] =$factor11*$exfacsec11;
        $totelectri11t[] =$factor11*$exfacsec11;
        //costo generales planta
        $excosgplan11=$funciones->genplanta($mes->get_mes11(),$mes->get_anio11(),$idsec);
        $factorgp11 = ($excosgplan11+$vartgn11)/$exsecti11;
        //factor generales planta por seccion
        $exfacgpsec11 = $funciones->facgpseccion($idsec,$mes->get_mes11(),$mes->get_anio11());
        if($idsec<>20)
        {   $totgenplan11[] = $factorgp11*$exfacgpsec11;}
        else
        {   
            $totgenplan11[] = $excosgplan11;}
        //otros Gp
        $excosotros11=$funciones->otrosgp($idsec,$mes->get_mes11(),$mes->get_anio11());
        $tototros11 = $excosotros11;
        $tototros11t[] = $excosotros11;
        
        $totalt11[] = 0;
        array_splice($totalt11,0);
        $totalt11[] = array_sum($totgenplan11)+$totmante11+array_sum($totelectri11)+$totinsu11+array_sum($totseg11)+array_sum($total11)+$tototros11+array_sum($totdep11);
        if($vartgn11==0){
        $vartgn11 = array_sum($totalt11);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec10=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio10(),$mes->get_mes10());
    $totiem10t[] =$tiemsec10;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio10(),$mes->get_mes10());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope10 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio10(),$mes->get_mes10());
            $exqtitoope10 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio10(),$mes->get_mes10());
            $costxhra10 = $exqcostoope10/$exqtitoope10;
            // consulta tiempos produc operario seccion
            $product10=$funciones->tprodopesec($idsec,$mes->get_mes10(),$mes->get_anio10(),$idope)*$costxhra10;
            // consulta tiempos Inproduc operario seccion
            $inproducts10 =$funciones->timprodopesec($idsec,$mes->get_mes10(),$mes->get_anio10(),$idope)*$costxhra10;
            // consulta asignacion operarios
            $exqasigsec10=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin10=$funciones->timpopesinsec($mes->get_mes10(),$mes->get_anio10(),$idope);
            $inproduct10 = $exqasigsec10*$costxhra10*$extiopesin10;
            $totmoprod10[] = $product10;
            $totmoprod10t[] = $product10;
            $totmoinprosec10[] = $inproducts10;
            $totmoinprosec10t[] = $inproducts10;
            $totmoinprosinsec10[] = $inproduct10;
            $totmoinprosinsec10t[] = $inproduct10;
            $total10[] = $product10 + $inproducts10 + $inproduct10;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total10[]=0;
                $totmoinprosec10t[]=0;
                $totmoprod10t[]=0;
                $totmoprod10[]=0;
                $totmoinprosec10[]=0;
                $totmoinprosec10t[]=0;
                $totmoinprosinsec10[]=0;
                $totmoinprosinsec10t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha10());
        $depreciacion->moveFirst();
        $totdep10[] = 0;
        $totdep10t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre10 =$depreciacion->get_fecingreso();
            $diff10=$funciones->diferenciafechas($mes->get_fecha10(),$fecingre10);
            if($fecingre10<=$mes->get_fecha10() and $diff10<=$depreciacion->get_nrocuotas())
                {
                    $totdep10[] = $depreciacion->get_dep ();
                    $totdep10t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec10=$funciones->insumos($mes->get_mes10(),$mes->get_anio10(),$idsec);
        $totinsu10=$insusec10;
        $totinsu10t[]=$insusec10;
        //mantenimiento
        $excosmante10=$funciones->consumos($mes->get_mes10(),$mes->get_anio10(),$idsec);
        $totmante10 =$excosmante10;
        $totmante10t[] =$excosmante10;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio10(),$mes->get_mes10());
        $seguros->moveFirst();
        $totseg10[] = 0;
        $totseg10t[] = 0;
        while (!$seguros->EOF) {
            $totseg10[] = $seguros->get_pm();
            $totseg10t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec10=$funciones->electricidad2($idsec,$mes->get_mes10(),$mes->get_anio10());
        $totelectri10[] =$factor10*$exfacsec10;
        $totelectri10t[] =$factor10*$exfacsec10;
        //costo generales planta
        $excosgplan10=$funciones->genplanta($mes->get_mes10(),$mes->get_anio10(),$idsec);
        $factorgp10 = ($excosgplan10+$vartgn10)/$exsecti10;
        //factor generales planta por seccion
        $exfacgpsec10 = $funciones->facgpseccion($idsec,$mes->get_mes10(),$mes->get_anio10());
        if($idsec<>20)
        {   $totgenplan10[] = $factorgp10*$exfacgpsec10;}
        else
        {   
            $totgenplan10[] = $excosgplan10;}
        //otros Gp
        $excosotros10=$funciones->otrosgp($idsec,$mes->get_mes10(),$mes->get_anio10());
        $tototros10 = $excosotros10;
        $tototros10t[] = $excosotros10;
        
        $totalt10[] = 0;
        array_splice($totalt10,0);
        $totalt10[] = array_sum($totgenplan10)+$totmante10+array_sum($totelectri10)+$totinsu10+array_sum($totseg10)+array_sum($total10)+$tototros10+array_sum($totdep10);
        if($vartgn10==0){
        $vartgn10 = array_sum($totalt10);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec9=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio9(),$mes->get_mes9());
    $totiem9t[] =$tiemsec9;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio9(),$mes->get_mes9());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope9 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio9(),$mes->get_mes9());
            $exqtitoope9 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio9(),$mes->get_mes9());
            $costxhra9 = $exqcostoope9/$exqtitoope9;
            // consulta tiempos produc operario seccion
            $product9=$funciones->tprodopesec($idsec,$mes->get_mes9(),$mes->get_anio9(),$idope)*$costxhra9;
            // consulta tiempos Inproduc operario seccion
            $inproducts9 =$funciones->timprodopesec($idsec,$mes->get_mes9(),$mes->get_anio9(),$idope)*$costxhra9;
            // consulta asignacion operarios
            $exqasigsec9=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin9=$funciones->timpopesinsec($mes->get_mes9(),$mes->get_anio9(),$idope);
            $inproduct9 = $exqasigsec9*$costxhra9*$extiopesin9;
            $totmoprod9[] = $product9;
            $totmoprod9t[] = $product9;
            $totmoinprosec9[] = $inproducts9;
            $totmoinprosec9t[] = $inproducts9;
            $totmoinprosinsec9[] = $inproduct9;
            $totmoinprosinsec9t[] = $inproduct9;
            $total9[] = $product9 + $inproducts9 + $inproduct9;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total9[]=0;
                $totmoinprosec9t[]=0;
                $totmoprod9t[]=0;
                $totmoprod9[]=0;
                $totmoinprosec9[]=0;
                $totmoinprosec9t[]=0;
                $totmoinprosinsec9[]=0;
                $totmoinprosinsec9t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha9());
        $depreciacion->moveFirst();
        $totdep9[] = 0;
        $totdep9t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre9 =$depreciacion->get_fecingreso();
            $diff9=$funciones->diferenciafechas($mes->get_fecha9(),$fecingre9);
            if($fecingre9<=$mes->get_fecha9() and $diff9<=$depreciacion->get_nrocuotas())
                {
                    $totdep9[] = $depreciacion->get_dep ();
                    $totdep9t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec9=$funciones->insumos($mes->get_mes9(),$mes->get_anio9(),$idsec);
        $totinsu9=$insusec9;
        $totinsu9t[]=$insusec9;
        //mantenimiento
        $excosmante9=$funciones->consumos($mes->get_mes9(),$mes->get_anio9(),$idsec);
        $totmante9 =$excosmante9;
        $totmante9t[] =$excosmante9;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio9(),$mes->get_mes9());
        $seguros->moveFirst();
        $totseg9[] = 0;
        $totseg9t[] = 0;
        while (!$seguros->EOF) {
            $totseg9[] = $seguros->get_pm();
            $totseg9t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec9=$funciones->electricidad2($idsec,$mes->get_mes9(),$mes->get_anio9());
        $totelectri9[] =$factor9*$exfacsec9;
        $totelectri9t[] =$factor9*$exfacsec9;
        //costo generales planta
        $excosgplan9=$funciones->genplanta($mes->get_mes9(),$mes->get_anio9(),$idsec);
        $factorgp9 = ($excosgplan9+$vartgn9)/$exsecti9;
        //factor generales planta por seccion
        $exfacgpsec9 = $funciones->facgpseccion($idsec,$mes->get_mes9(),$mes->get_anio9());
        if($idsec<>20)
        {   $totgenplan9[] = $factorgp9*$exfacgpsec9;}
        else
        {   
            $totgenplan9[] = $excosgplan9;}
        //otros Gp
        $excosotros9=$funciones->otrosgp($idsec,$mes->get_mes9(),$mes->get_anio9());
        $tototros9 = $excosotros9;
        $tototros9t[] = $excosotros9;
        
        $totalt9[] = 0;
        array_splice($totalt9,0);
        $totalt9[] = array_sum($totgenplan9)+$totmante9+array_sum($totelectri9)+$totinsu9+array_sum($totseg9)+array_sum($total9)+$tototros9+array_sum($totdep9);
        if($vartgn9==0){
        $vartgn9 = array_sum($totalt9);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec8=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio8(),$mes->get_mes8());
    $totiem8t[] =$tiemsec8;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio8(),$mes->get_mes8());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope8 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio8(),$mes->get_mes8());
            $exqtitoope8 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio8(),$mes->get_mes8());
            $costxhra8 = $exqcostoope8/$exqtitoope8;
            // consulta tiempos produc operario seccion
            $product8=$funciones->tprodopesec($idsec,$mes->get_mes8(),$mes->get_anio8(),$idope)*$costxhra8;
            // consulta tiempos Inproduc operario seccion
            $inproducts8 =$funciones->timprodopesec($idsec,$mes->get_mes8(),$mes->get_anio8(),$idope)*$costxhra8;
            // consulta asignacion operarios
            $exqasigsec8=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin8=$funciones->timpopesinsec($mes->get_mes8(),$mes->get_anio8(),$idope);
            $inproduct8 = $exqasigsec8*$costxhra8*$extiopesin8;
            $totmoprod8[] = $product8;
            $totmoprod8t[] = $product8;
            $totmoinprosec8[] = $inproducts8;
            $totmoinprosec8t[] = $inproducts8;
            $totmoinprosinsec8[] = $inproduct8;
            $totmoinprosinsec8t[] = $inproduct8;
            $total8[] = $product8 + $inproducts8 + $inproduct8;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total8[]=0;
                $totmoinprosec8t[]=0;
                $totmoprod8t[]=0;
                $totmoprod8[]=0;
                $totmoinprosec8[]=0;
                $totmoinprosec8t[]=0;
                $totmoinprosinsec8[]=0;
                $totmoinprosinsec8t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha8());
        $depreciacion->moveFirst();
        $totdep8[] = 0;
        $totdep8t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre8 =$depreciacion->get_fecingreso();
            $diff8=$funciones->diferenciafechas($mes->get_fecha8(),$fecingre8);
            if($fecingre8<=$mes->get_fecha8() and $diff8<=$depreciacion->get_nrocuotas())
                {
                    $totdep8[] = $depreciacion->get_dep ();
                    $totdep8t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec8=$funciones->insumos($mes->get_mes8(),$mes->get_anio8(),$idsec);
        $totinsu8=$insusec8;
        $totinsu8t[]=$insusec8;
        //mantenimiento
        $excosmante8=$funciones->consumos($mes->get_mes8(),$mes->get_anio8(),$idsec);
        $totmante8 =$excosmante8;
        $totmante8t[] =$excosmante8;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio8(),$mes->get_mes8());
        $seguros->moveFirst();
        $totseg8[] = 0;
        $totseg8t[] = 0;
        while (!$seguros->EOF) {
            $totseg8[] = $seguros->get_pm();
            $totseg8t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec8=$funciones->electricidad2($idsec,$mes->get_mes8(),$mes->get_anio8());
        $totelectri8[] =$factor8*$exfacsec8;
        $totelectri8t[] =$factor8*$exfacsec8;
        //costo generales planta
        $excosgplan8=$funciones->genplanta($mes->get_mes8(),$mes->get_anio8(),$idsec);
        $factorgp8 = ($excosgplan8+$vartgn8)/$exsecti8;
        //factor generales planta por seccion
        $exfacgpsec8 = $funciones->facgpseccion($idsec,$mes->get_mes8(),$mes->get_anio8());
        if($idsec<>20)
        {   $totgenplan8[] = $factorgp8*$exfacgpsec8;}
        else
        {   
            $totgenplan8[] = $excosgplan8;}
        //otros Gp
        $excosotros8=$funciones->otrosgp($idsec,$mes->get_mes8(),$mes->get_anio8());
        $tototros8 = $excosotros8;
        $tototros8t[] = $excosotros8;
        
        $totalt8[] = 0;
        array_splice($totalt8,0);
        $totalt8[] = array_sum($totgenplan8)+$totmante8+array_sum($totelectri8)+$totinsu8+array_sum($totseg8)+array_sum($total8)+$tototros8+array_sum($totdep8);
        if($vartgn8==0){
        $vartgn8 = array_sum($totalt8);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec7=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio7(),$mes->get_mes7());
    $totiem7t[] =$tiemsec7;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio7(),$mes->get_mes7());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope7 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio7(),$mes->get_mes7());
            $exqtitoope7 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio7(),$mes->get_mes7());
            $costxhra7 = $exqcostoope7/$exqtitoope7;
            // consulta tiempos produc operario seccion
            $product7=$funciones->tprodopesec($idsec,$mes->get_mes7(),$mes->get_anio7(),$idope)*$costxhra7;
            // consulta tiempos Inproduc operario seccion
            $inproducts7 =$funciones->timprodopesec($idsec,$mes->get_mes7(),$mes->get_anio7(),$idope)*$costxhra7;
            // consulta asignacion operarios
            $exqasigsec7=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin7=$funciones->timpopesinsec($mes->get_mes7(),$mes->get_anio7(),$idope);
            $inproduct7 = $exqasigsec7*$costxhra7*$extiopesin7;
            $totmoprod7[] = $product7;
            $totmoprod7t[] = $product7;
            $totmoinprosec7[] = $inproducts7;
            $totmoinprosec7t[] = $inproducts7;
            $totmoinprosinsec7[] = $inproduct7;
            $totmoinprosinsec7t[] = $inproduct7;
            $total7[] = $product7 + $inproducts7 + $inproduct7;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total7[]=0;
                $totmoinprosec7t[]=0;
                $totmoprod7t[]=0;
                $totmoprod7[]=0;
                $totmoinprosec7[]=0;
                $totmoinprosec7t[]=0;
                $totmoinprosinsec7[]=0;
                $totmoinprosinsec7t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha7());
        $depreciacion->moveFirst();
        $totdep7[] = 0;
        $totdep7t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre7 =$depreciacion->get_fecingreso();
            $diff7=$funciones->diferenciafechas($mes->get_fecha7(),$fecingre7);
            if($fecingre7<=$mes->get_fecha7() and $diff7<=$depreciacion->get_nrocuotas())
                {
                    $totdep7[] = $depreciacion->get_dep ();
                    $totdep7t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec7=$funciones->insumos($mes->get_mes7(),$mes->get_anio7(),$idsec);
        $totinsu7=$insusec7;
        $totinsu7t[]=$insusec7;
        //mantenimiento
        $excosmante7=$funciones->consumos($mes->get_mes7(),$mes->get_anio7(),$idsec);
        $totmante7 =$excosmante7;
        $totmante7t[] =$excosmante7;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio7(),$mes->get_mes7());
        $seguros->moveFirst();
        $totseg7[] = 0;
        $totseg7t[] = 0;
        while (!$seguros->EOF) {
            $totseg7[] = $seguros->get_pm();
            $totseg7t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec7=$funciones->electricidad2($idsec,$mes->get_mes7(),$mes->get_anio7());
        $totelectri7[] =$factor7*$exfacsec7;
        $totelectri7t[] =$factor7*$exfacsec7;
        //costo generales planta
        $excosgplan7=$funciones->genplanta($mes->get_mes7(),$mes->get_anio7(),$idsec);
        $factorgp7 = ($excosgplan7+$vartgn7)/$exsecti7;
        //factor generales planta por seccion
        $exfacgpsec7 = $funciones->facgpseccion($idsec,$mes->get_mes7(),$mes->get_anio7());
        if($idsec<>20)
        {   $totgenplan7[] = $factorgp7*$exfacgpsec7;}
        else
        {   
            $totgenplan7[] = $excosgplan7;}
        //otros Gp
        $excosotros7=$funciones->otrosgp($idsec,$mes->get_mes7(),$mes->get_anio7());
        $tototros7 = $excosotros7;
        $tototros7t[] = $excosotros7;
        
        $totalt7[] = 0;
        array_splice($totalt7,0);
        $totalt7[] = array_sum($totgenplan7)+$totmante7+array_sum($totelectri7)+$totinsu7+array_sum($totseg7)+array_sum($total7)+$tototros7+array_sum($totdep7);
        if($vartgn7==0){
        $vartgn7 = array_sum($totalt7);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec6=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio6(),$mes->get_mes6());
    $totiem6t[] =$tiemsec6;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio6(),$mes->get_mes6());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope6 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio6(),$mes->get_mes6());
            $exqtitoope6 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio6(),$mes->get_mes6());
            $costxhra6 = $exqcostoope6/$exqtitoope6;
            // consulta tiempos produc operario seccion
            $product6=$funciones->tprodopesec($idsec,$mes->get_mes6(),$mes->get_anio6(),$idope)*$costxhra6;
            // consulta tiempos Inproduc operario seccion
            $inproducts6 =$funciones->timprodopesec($idsec,$mes->get_mes6(),$mes->get_anio6(),$idope)*$costxhra6;
            // consulta asignacion operarios
            $exqasigsec6=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin6=$funciones->timpopesinsec($mes->get_mes6(),$mes->get_anio6(),$idope);
            $inproduct6 = $exqasigsec6*$costxhra6*$extiopesin6;
            $totmoprod6[] = $product6;
            $totmoprod6t[] = $product6;
            $totmoinprosec6[] = $inproducts6;
            $totmoinprosec6t[] = $inproducts6;
            $totmoinprosinsec6[] = $inproduct6;
            $totmoinprosinsec6t[] = $inproduct6;
            $total6[] = $product6 + $inproducts6 + $inproduct6;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total6[]=0;
                $totmoinprosec6t[]=0;
                $totmoprod6t[]=0;
                $totmoprod6[]=0;
                $totmoinprosec6[]=0;
                $totmoinprosec6t[]=0;
                $totmoinprosinsec6[]=0;
                $totmoinprosinsec6t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha6());
        $depreciacion->moveFirst();
        $totdep6[] = 0;
        $totdep6t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre6 =$depreciacion->get_fecingreso();
            $diff6=$funciones->diferenciafechas($mes->get_fecha6(),$fecingre6);
            if($fecingre6<=$mes->get_fecha6() and $diff6<=$depreciacion->get_nrocuotas())
                {
                    $totdep6[] = $depreciacion->get_dep ();
                    $totdep6t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec6=$funciones->insumos($mes->get_mes6(),$mes->get_anio6(),$idsec);
        $totinsu6=$insusec6;
        $totinsu6t[]=$insusec6;
        //mantenimiento
        $excosmante6=$funciones->consumos($mes->get_mes6(),$mes->get_anio6(),$idsec);
        $totmante6 =$excosmante6;
        $totmante6t[] =$excosmante6;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio6(),$mes->get_mes6());
        $seguros->moveFirst();
        $totseg6[] = 0;
        $totseg6t[] = 0;
        while (!$seguros->EOF) {
            $totseg6[] = $seguros->get_pm();
            $totseg6t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec6=$funciones->electricidad2($idsec,$mes->get_mes6(),$mes->get_anio6());
        $totelectri6[] =$factor6*$exfacsec6;
        $totelectri6t[] =$factor6*$exfacsec6;
        //costo generales planta
        $excosgplan6=$funciones->genplanta($mes->get_mes6(),$mes->get_anio6(),$idsec);
        $factorgp6 = ($excosgplan6+$vartgn6)/$exsecti6;
        //factor generales planta por seccion
        $exfacgpsec6 = $funciones->facgpseccion($idsec,$mes->get_mes6(),$mes->get_anio6());
        if($idsec<>20)
        {   $totgenplan6[] = $factorgp6*$exfacgpsec6;}
        else
        {   
            $totgenplan6[] = $excosgplan6;}
        //otros Gp
        $excosotros6=$funciones->otrosgp($idsec,$mes->get_mes6(),$mes->get_anio6());
        $tototros6 = $excosotros6;
        $tototros6t[] = $excosotros6;
        
        $totalt6[] = 0;
        array_splice($totalt6,0);
        $totalt6[] = array_sum($totgenplan6)+$totmante6+array_sum($totelectri6)+$totinsu6+array_sum($totseg6)+array_sum($total6)+$tototros6+array_sum($totdep6);
        if($vartgn6==0){
        $vartgn6 = array_sum($totalt6);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec5=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio5(),$mes->get_mes5());
    $totiem5t[] =$tiemsec5;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio5(),$mes->get_mes5());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope5 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio5(),$mes->get_mes5());
            $exqtitoope5 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio5(),$mes->get_mes5());
            $costxhra5 = $exqcostoope5/$exqtitoope5;
            // consulta tiempos produc operario seccion
            $product5=$funciones->tprodopesec($idsec,$mes->get_mes5(),$mes->get_anio5(),$idope)*$costxhra5;
            // consulta tiempos Inproduc operario seccion
            $inproducts5 =$funciones->timprodopesec($idsec,$mes->get_mes5(),$mes->get_anio5(),$idope)*$costxhra5;
            // consulta asignacion operarios
            $exqasigsec5=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin5=$funciones->timpopesinsec($mes->get_mes5(),$mes->get_anio5(),$idope);
            $inproduct5 = $exqasigsec5*$costxhra5*$extiopesin5;
            $totmoprod5[] = $product5;
            $totmoprod5t[] = $product5;
            $totmoinprosec5[] = $inproducts5;
            $totmoinprosec5t[] = $inproducts5;
            $totmoinprosinsec5[] = $inproduct5;
            $totmoinprosinsec5t[] = $inproduct5;
            $total5[] = $product5 + $inproducts5 + $inproduct5;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total5[]=0;
                $totmoinprosec5t[]=0;
                $totmoprod5t[]=0;
                $totmoprod5[]=0;
                $totmoinprosec5[]=0;
                $totmoinprosec5t[]=0;
                $totmoinprosinsec5[]=0;
                $totmoinprosinsec5t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha5());
        $depreciacion->moveFirst();
        $totdep5[] = 0;
        $totdep5t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre5 =$depreciacion->get_fecingreso();
            $diff5=$funciones->diferenciafechas($mes->get_fecha5(),$fecingre5);
            if($fecingre5<=$mes->get_fecha5() and $diff5<=$depreciacion->get_nrocuotas())
                {
                    $totdep5[] = $depreciacion->get_dep ();
                    $totdep5t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec5=$funciones->insumos($mes->get_mes5(),$mes->get_anio5(),$idsec);
        $totinsu5=$insusec5;
        $totinsu5t[]=$insusec5;
        //mantenimiento
        $excosmante5=$funciones->consumos($mes->get_mes5(),$mes->get_anio5(),$idsec);
        $totmante5 =$excosmante5;
        $totmante5t[] =$excosmante5;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio5(),$mes->get_mes5());
        $seguros->moveFirst();
        $totseg5[] = 0;
        $totseg5t[] = 0;
        while (!$seguros->EOF) {
            $totseg5[] = $seguros->get_pm();
            $totseg5t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec5=$funciones->electricidad2($idsec,$mes->get_mes5(),$mes->get_anio5());
        $totelectri5[] =$factor5*$exfacsec5;
        $totelectri5t[] =$factor5*$exfacsec5;
        //costo generales planta
        $excosgplan5=$funciones->genplanta($mes->get_mes5(),$mes->get_anio5(),$idsec);
        $factorgp5 = ($excosgplan5+$vartgn5)/$exsecti5;
        //factor generales planta por seccion
        $exfacgpsec5 = $funciones->facgpseccion($idsec,$mes->get_mes5(),$mes->get_anio5());
        if($idsec<>20)
        {   $totgenplan5[] = $factorgp5*$exfacgpsec5;}
        else
        {   
            $totgenplan5[] = $excosgplan5;}
        //otros Gp
        $excosotros5=$funciones->otrosgp($idsec,$mes->get_mes5(),$mes->get_anio5());
        $tototros5 = $excosotros5;
        $tototros5t[] = $excosotros5;
        
        $totalt5[] = 0;
        array_splice($totalt5,0);
        $totalt5[] = array_sum($totgenplan5)+$totmante5+array_sum($totelectri5)+$totinsu5+array_sum($totseg5)+array_sum($total5)+$tototros5+array_sum($totdep5);
        if($vartgn5==0){
        $vartgn5 = array_sum($totalt5);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec4=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio4(),$mes->get_mes4());
    $totiem4t[] =$tiemsec4;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio4(),$mes->get_mes4());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope4 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio4(),$mes->get_mes4());
            $exqtitoope4 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio4(),$mes->get_mes4());
            $costxhra4 = $exqcostoope4/$exqtitoope4;
            // consulta tiempos produc operario seccion
            $product4=$funciones->tprodopesec($idsec,$mes->get_mes4(),$mes->get_anio4(),$idope)*$costxhra4;
            // consulta tiempos Inproduc operario seccion
            $inproducts4 =$funciones->timprodopesec($idsec,$mes->get_mes4(),$mes->get_anio4(),$idope)*$costxhra4;
            // consulta asignacion operarios
            $exqasigsec4=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin4=$funciones->timpopesinsec($mes->get_mes4(),$mes->get_anio4(),$idope);
            $inproduct4 = $exqasigsec4*$costxhra4*$extiopesin4;
            $totmoprod4[] = $product4;
            $totmoprod4t[] = $product4;
            $totmoinprosec4[] = $inproducts4;
            $totmoinprosec4t[] = $inproducts4;
            $totmoinprosinsec4[] = $inproduct4;
            $totmoinprosinsec4t[] = $inproduct4;
            $total4[] = $product4 + $inproducts4 + $inproduct4;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total4[]=0;
                $totmoinprosec4t[]=0;
                $totmoprod4t[]=0;
                $totmoprod4[]=0;
                $totmoinprosec4[]=0;
                $totmoinprosec4t[]=0;
                $totmoinprosinsec4[]=0;
                $totmoinprosinsec4t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha4());
        $depreciacion->moveFirst();
        $totdep4[] = 0;
        $totdep4t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre4 =$depreciacion->get_fecingreso();
            $diff4=$funciones->diferenciafechas($mes->get_fecha4(),$fecingre4);
            if($fecingre4<=$mes->get_fecha4() and $diff4<=$depreciacion->get_nrocuotas())
                {
                    $totdep4[] = $depreciacion->get_dep ();
                    $totdep4t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec4=$funciones->insumos($mes->get_mes4(),$mes->get_anio4(),$idsec);
        $totinsu4=$insusec4;
        $totinsu4t[]=$insusec4;
        //mantenimiento
        $excosmante4=$funciones->consumos($mes->get_mes4(),$mes->get_anio4(),$idsec);
        $totmante4 =$excosmante4;
        $totmante4t[] =$excosmante4;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio4(),$mes->get_mes4());
        $seguros->moveFirst();
        $totseg4[] = 0;
        $totseg4t[] = 0;
        while (!$seguros->EOF) {
            $totseg4[] = $seguros->get_pm();
            $totseg4t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec4=$funciones->electricidad2($idsec,$mes->get_mes4(),$mes->get_anio4());
        $totelectri4[] =$factor4*$exfacsec4;
        $totelectri4t[] =$factor4*$exfacsec4;
        //costo generales planta
        $excosgplan4=$funciones->genplanta($mes->get_mes4(),$mes->get_anio4(),$idsec);
        $factorgp4 = ($excosgplan4+$vartgn4)/$exsecti4;
        //factor generales planta por seccion
        $exfacgpsec4 = $funciones->facgpseccion($idsec,$mes->get_mes4(),$mes->get_anio4());
        if($idsec<>20)
        {   $totgenplan4[] = $factorgp4*$exfacgpsec4;}
        else
        {   
            $totgenplan4[] = $excosgplan4;}
        //otros Gp
        $excosotros4=$funciones->otrosgp($idsec,$mes->get_mes4(),$mes->get_anio4());
        $tototros4 = $excosotros4;
        $tototros4t[] = $excosotros4;
        
        $totalt4[] = 0;
        array_splice($totalt4,0);
        $totalt4[] = array_sum($totgenplan4)+$totmante4+array_sum($totelectri4)+$totinsu4+array_sum($totseg4)+array_sum($total4)+$tototros4+array_sum($totdep4);
        if($vartgn4==0){
        $vartgn4 = array_sum($totalt4);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec3=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio3(),$mes->get_mes3());
    $totiem3t[] =$tiemsec3;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio3(),$mes->get_mes3());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope3 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio3(),$mes->get_mes3());
            $exqtitoope3 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio3(),$mes->get_mes3());
            $costxhra3 = $exqcostoope3/$exqtitoope3;
            // consulta tiempos produc operario seccion
            $product3=$funciones->tprodopesec($idsec,$mes->get_mes3(),$mes->get_anio3(),$idope)*$costxhra3;
            // consulta tiempos Inproduc operario seccion
            $inproducts3 =$funciones->timprodopesec($idsec,$mes->get_mes3(),$mes->get_anio3(),$idope)*$costxhra3;
            // consulta asignacion operarios
            $exqasigsec3=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin3=$funciones->timpopesinsec($mes->get_mes3(),$mes->get_anio3(),$idope);
            $inproduct3 = $exqasigsec3*$costxhra3*$extiopesin3;
            $totmoprod3[] = $product3;
            $totmoprod3t[] = $product3;
            $totmoinprosec3[] = $inproducts3;
            $totmoinprosec3t[] = $inproducts3;
            $totmoinprosinsec3[] = $inproduct3;
            $totmoinprosinsec3t[] = $inproduct3;
            $total3[] = $product3 + $inproducts3 + $inproduct3;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total3[]=0;
                $totmoinprosec3t[]=0;
                $totmoprod3t[]=0;
                $totmoprod3[]=0;
                $totmoinprosec3[]=0;
                $totmoinprosec3t[]=0;
                $totmoinprosinsec3[]=0;
                $totmoinprosinsec3t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha3());
        $depreciacion->moveFirst();
        $totdep3[] = 0;
        $totdep3t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre3 =$depreciacion->get_fecingreso();
            $diff3=$funciones->diferenciafechas($mes->get_fecha3(),$fecingre3);
            if($fecingre3<=$mes->get_fecha3() and $diff3<=$depreciacion->get_nrocuotas())
                {
                    $totdep3[] = $depreciacion->get_dep ();
                    $totdep3t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec3=$funciones->insumos($mes->get_mes3(),$mes->get_anio3(),$idsec);
        $totinsu3=$insusec3;
        $totinsu3t[]=$insusec3;
        //mantenimiento
        $excosmante3=$funciones->consumos($mes->get_mes3(),$mes->get_anio3(),$idsec);
        $totmante3 =$excosmante3;
        $totmante3t[] =$excosmante3;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio3(),$mes->get_mes3());
        $seguros->moveFirst();
        $totseg3[] = 0;
        $totseg3t[] = 0;
        while (!$seguros->EOF) {
            $totseg3[] = $seguros->get_pm();
            $totseg3t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec3=$funciones->electricidad2($idsec,$mes->get_mes3(),$mes->get_anio3());
        $totelectri3[] =$factor3*$exfacsec3;
        $totelectri3t[] =$factor3*$exfacsec3;
        //costo generales planta
        $excosgplan3=$funciones->genplanta($mes->get_mes3(),$mes->get_anio3(),$idsec);
        $factorgp3 = ($excosgplan3+$vartgn3)/$exsecti3;
        //factor generales planta por seccion
        $exfacgpsec3 = $funciones->facgpseccion($idsec,$mes->get_mes3(),$mes->get_anio3());
        if($idsec<>20)
        {   $totgenplan3[] = $factorgp3*$exfacgpsec3;}
        else
        {   
            $totgenplan3[] = $excosgplan3;}
        //otros Gp
        $excosotros3=$funciones->otrosgp($idsec,$mes->get_mes3(),$mes->get_anio3());
        $tototros3 = $excosotros3;
        $tototros3t[] = $excosotros3;
        
        $totalt3[] = 0;
        array_splice($totalt3,0);
        $totalt3[] = array_sum($totgenplan3)+$totmante3+array_sum($totelectri3)+$totinsu3+array_sum($totseg3)+array_sum($total3)+$tototros3+array_sum($totdep3);
        if($vartgn3==0){
        $vartgn3 = array_sum($totalt3);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec2=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio2(),$mes->get_mes2());
    $totiem2t[] =$tiemsec2;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio2(),$mes->get_mes2());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope2 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio2(),$mes->get_mes2());
            $exqtitoope2 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio2(),$mes->get_mes2());
            $costxhra2 = $exqcostoope2/$exqtitoope2;
            // consulta tiempos produc operario seccion
            $product2=$funciones->tprodopesec($idsec,$mes->get_mes2(),$mes->get_anio2(),$idope)*$costxhra2;
            // consulta tiempos Inproduc operario seccion
            $inproducts2 =$funciones->timprodopesec($idsec,$mes->get_mes2(),$mes->get_anio2(),$idope)*$costxhra2;
            // consulta asignacion operarios
            $exqasigsec2=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin2=$funciones->timpopesinsec($mes->get_mes2(),$mes->get_anio2(),$idope);
            $inproduct2 = $exqasigsec2*$costxhra2*$extiopesin2;
            $totmoprod2[] = $product2;
            $totmoprod2t[] = $product2;
            $totmoinprosec2[] = $inproducts2;
            $totmoinprosec2t[] = $inproducts2;
            $totmoinprosinsec2[] = $inproduct2;
            $totmoinprosinsec2t[] = $inproduct2;
            $total2[] = $product2 + $inproducts2 + $inproduct2;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total2[]=0;
                $totmoinprosec2t[]=0;
                $totmoprod2t[]=0;
                $totmoprod2[]=0;
                $totmoinprosec2[]=0;
                $totmoinprosec2t[]=0;
                $totmoinprosinsec2[]=0;
                $totmoinprosinsec2t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha2());
        $depreciacion->moveFirst();
        $totdep2[] = 0;
        $totdep2t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre2 =$depreciacion->get_fecingreso();
            $diff2=$funciones->diferenciafechas($mes->get_fecha2(),$fecingre2);
            if($fecingre2<=$mes->get_fecha2() and $diff2<=$depreciacion->get_nrocuotas())
                {
                    $totdep2[] = $depreciacion->get_dep ();
                    $totdep2t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec2=$funciones->insumos($mes->get_mes2(),$mes->get_anio2(),$idsec);
        $totinsu2=$insusec2;
        $totinsu2t[]=$insusec2;
        //mantenimiento
        $excosmante2=$funciones->consumos($mes->get_mes2(),$mes->get_anio2(),$idsec);
        $totmante2 =$excosmante2;
        $totmante2t[] =$excosmante2;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio2(),$mes->get_mes2());
        $seguros->moveFirst();
        $totseg2[] = 0;
        $totseg2t[] = 0;
        while (!$seguros->EOF) {
            $totseg2[] = $seguros->get_pm();
            $totseg2t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec2=$funciones->electricidad2($idsec,$mes->get_mes2(),$mes->get_anio2());
        $totelectri2[] =$factor2*$exfacsec2;
        $totelectri2t[] =$factor2*$exfacsec2;
        //costo generales planta
        $excosgplan2=$funciones->genplanta($mes->get_mes2(),$mes->get_anio2(),$idsec);
        $factorgp2 = ($excosgplan2+$vartgn2)/$exsecti2;
        //factor generales planta por seccion
        $exfacgpsec2 = $funciones->facgpseccion($idsec,$mes->get_mes2(),$mes->get_anio2());
        if($idsec<>20)
        {   $totgenplan2[] = $factorgp2*$exfacgpsec2;}
        else
        {   
            $totgenplan2[] = $excosgplan2;}
        //otros Gp
        $excosotros2=$funciones->otrosgp($idsec,$mes->get_mes2(),$mes->get_anio2());
        $tototros2 = $excosotros2;
        $tototros2t[] = $excosotros2;
        
        $totalt2[] = 0;
        array_splice($totalt2,0);
        $totalt2[] = array_sum($totgenplan2)+$totmante2+array_sum($totelectri2)+$totinsu2+array_sum($totseg2)+array_sum($total2)+$tototros2+array_sum($totdep2);
        if($vartgn2==0){
        $vartgn2 = array_sum($totalt2);}
    //---------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec1=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio1(),$mes->get_mes1());
    $totiem1t[] =$tiemsec1;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio1(),$mes->get_mes1());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope1 = $funciones->CostoHoraOperario_A($idope,$mes->get_anio1(),$mes->get_mes1());
            $exqtitoope1 = $funciones->CostoHoraOperario_B($idope,$mes->get_anio1(),$mes->get_mes1());
            $costxhra1 = $exqcostoope1/$exqtitoope1;
            // consulta tiempos produc operario seccion
            $product1=$funciones->tprodopesec($idsec,$mes->get_mes1(),$mes->get_anio1(),$idope)*$costxhra1;
            // consulta tiempos Inproduc operario seccion
            $inproducts1 =$funciones->timprodopesec($idsec,$mes->get_mes1(),$mes->get_anio1(),$idope)*$costxhra1;
            // consulta asignacion operarios
            $exqasigsec1=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin1=$funciones->timpopesinsec($mes->get_mes1(),$mes->get_anio1(),$idope);
            $inproduct1 = $exqasigsec1*$costxhra1*$extiopesin1;
            $totmoprod1[] = $product1;
            $totmoprod1t[] = $product1;
            $totmoinprosec1[] = $inproducts1;
            $totmoinprosec1t[] = $inproducts1;
            $totmoinprosinsec1[] = $inproduct1;
            $totmoinprosinsec1t[] = $inproduct1;
            $total1[] = $product1 + $inproducts1 + $inproduct1;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total1[]=0;
                $totmoinprosec1t[]=0;
                $totmoprod1t[]=0;
                $totmoprod1[]=0;
                $totmoinprosec1[]=0;
                $totmoinprosec1t[]=0;
                $totmoinprosinsec1[]=0;
                $totmoinprosinsec1t[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha1());
        $depreciacion->moveFirst();
        $totdep1[] = 0;
        $totdep1t[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre1 =$depreciacion->get_fecingreso();
            $diff1=$funciones->diferenciafechas($mes->get_fecha1(),$fecingre1);
            if($fecingre1<=$mes->get_fecha1() and $diff1<=$depreciacion->get_nrocuotas())
                {
                    $totdep1[] = $depreciacion->get_dep ();
                    $totdep1t[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec1=$funciones->insumos($mes->get_mes1(),$mes->get_anio1(),$idsec);
        $totinsu1=$insusec1;
        $totinsu1t[]=$insusec1;
        //mantenimiento
        $excosmante1=$funciones->consumos($mes->get_mes1(),$mes->get_anio1(),$idsec);
        $totmante1 =$excosmante1;
        $totmante1t[] =$excosmante1;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio1(),$mes->get_mes1());
        $seguros->moveFirst();
        $totseg1[] = 0;
        $totseg1t[] = 0;
        while (!$seguros->EOF) {
            $totseg1[] = $seguros->get_pm();
            $totseg1t[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec1=$funciones->electricidad2($idsec,$mes->get_mes1(),$mes->get_anio1());
        $totelectri1[] =$factor1*$exfacsec1;
        $totelectri1t[] =$factor1*$exfacsec1;
        //costo generales planta
        $excosgplan1=$funciones->genplanta($mes->get_mes1(),$mes->get_anio1(),$idsec);
        $factorgp1 = ($excosgplan1+$vartgn1)/$exsecti1;
        //factor generales planta por seccion
        $exfacgpsec1 = $funciones->facgpseccion($idsec,$mes->get_mes1(),$mes->get_anio1());
        if($idsec<>20)
        {   $totgenplan1[] = $factorgp1*$exfacgpsec1;}
        else
        {   
            $totgenplan1[] = $excosgplan1;}
        //otros Gp
        $excosotros1=$funciones->otrosgp($idsec,$mes->get_mes1(),$mes->get_anio1());
        $tototros1 = $excosotros1;
        $tototros1t[] = $excosotros1;
        
        $totalt1[] = 0;
        array_splice($totalt1,0);
        $totalt1[] = array_sum($totgenplan1)+$totmante1+array_sum($totelectri1)+$totinsu1+array_sum($totseg1)+array_sum($total1)+$tototros1+array_sum($totdep1);
        if($vartgn1==0){
        $vartgn1 = array_sum($totalt1);}
    //---------------------------------------------------------------------------------    
    //---------------------------------------------------------------------------------
    $idsec = $seccion->get_idseccion();
    // consulta tiempo productivo seccion
    $tiemsec=$funciones->TiempoProductivoSeccion($idsec,$mes->get_anio(),$mes->get_mes());
    $totiemt[] =$tiemsec;
    $Opesecion->OperariosSeccion($idsec,$mes->get_anio(),$mes->get_mes());
    $Opesecion->moveFirst();
    $tRows_operasec = $Opesecion->RecordCount();
        while (!$Opesecion->EOF) 
        {
            $idope = $Opesecion->get_idoperario();
            //consultas para hallar costo x hora x operario
           $exqcostoope = $funciones->CostoHoraOperario_A($idope,$mes->get_anio(),$mes->get_mes());
            $exqtitoope = $funciones->CostoHoraOperario_B($idope,$mes->get_anio(),$mes->get_mes());
            $costxhra = $exqcostoope/$exqtitoope;
            // consulta tiempos produc operario seccion
            $product=$funciones->tprodopesec($idsec,$mes->get_mes(),$mes->get_anio(),$idope)*$costxhra;
            // consulta tiempos Inproduc operario seccion
            $inproducts =$funciones->timprodopesec($idsec,$mes->get_mes(),$mes->get_anio(),$idope)*$costxhra;
            // consulta asignacion operarios
            $exqasigsec=$funciones->asignacionope($idsec,$idope);
            // consulta tiempos Inproduc operario sin seccion
            $extiopesin=$funciones->timpopesinsec($mes->get_mes(),$mes->get_anio(),$idope);
            $inproduct = $exqasigsec*$costxhra*$extiopesin;
            $totmoprod[] = $product;
            $totmoprodt[] = $product;
            $totmoinprosec[] = $inproducts;
            $totmoinprosect[] = $inproducts;
            $totmoinprosinsec[] = $inproduct;
            $totmoinprosinsect[] = $inproduct;
            $total[] = $product + $inproducts + $inproduct;
            $Opesecion->MoveNext();
        }
        if($tRows_operasec==0)
            {
                $total[]=0;
                $totmoinprosect[]=0;
                $totmoprodt[]=0;
                $totmoprod[]=0;
                $totmoinprosec[]=0;
                $totmoinprosect[]=0;
                $totmoinprosinsec[]=0;
                $totmoinprosinsect[]=0;
            }
        //depreciacion -- ahora es una clase
        $depreciacion->conectar($idsec,$mes->get_fecha());
        $depreciacion->moveFirst();
        $totdep[] = 0;
        $totdept[] = 0;
        while (!$depreciacion->EOF) 
        {
            $fecingre =$depreciacion->get_fecingreso();
            $diff=$funciones->diferenciafechas($mes->get_fecha(),$fecingre);
            if($fecingre<=$mes->get_fecha() and $diff<=$depreciacion->get_nrocuotas())
                {
                    $totdep[] = $depreciacion->get_dep ();
                    $totdept[] = $depreciacion->get_dep ();
                }
            $depreciacion->MoveNext();
        }
        //insumos
        $insusec=$funciones->insumos($mes->get_mes(),$mes->get_anio(),$idsec);
        $totinsu=$insusec;
        $totinsut[]=$insusec;
        //mantenimiento
        $excosmante=$funciones->consumos($mes->get_mes(),$mes->get_anio(),$idsec);
        $totmante =$excosmante;
        $totmantet[] =$excosmante;
        //seguros
        //declaracion de la variable seguros al inicio
        $seguros->conectar($idsec,$mes->get_anio(),$mes->get_mes());
        $seguros->moveFirst();
        $totseg[] = 0;
        $totsegt[] = 0;
        while (!$seguros->EOF) {
            $totseg[] = $seguros->get_pm();
            $totsegt[] = $seguros->get_pm();
            $seguros->MoveNext();
        }
        //electricidad
        $exfacsec=$funciones->electricidad2($idsec,$mes->get_mes(),$mes->get_anio());
        $totelectri[] =$factor*$exfacsec;
        $totelectrit[] =$factor*$exfacsec;
        //costo generales planta
        $excosgplan=$funciones->genplanta($mes->get_mes(),$mes->get_anio(),$idsec);
        $factorgp = ($excosgplan+$vartgn)/$exsecti;
        //factor generales planta por seccion
        $exfacgpsec = $funciones->facgpseccion($idsec,$mes->get_mes(),$mes->get_anio());
        if($idsec<>20)
        {   $totgenplan[] = $factorgp*$exfacgpsec;}
        else
        {   
            $totgenplan[] = $excosgplan;}
        //otros Gp
        $excosotros=$funciones->otrosgp($idsec,$mes->get_mes(),$mes->get_anio());
        $tototros = $excosotros;
        $tototrost[] = $excosotros;
        
        $totalt[] = 0;
        array_splice($totalt,0);
        $totalt[] = array_sum($totgenplan)+$totmante+array_sum($totelectri)+$totinsu+array_sum($totseg)+array_sum($total)+$tototros+array_sum($totdep);
        if($vartgn==0){
        $vartgn = array_sum($totalt);}
    //---------------------------------------------------------------------------------
?>
  <tr>
    <td colspan="14" class="selected_cal"><hr>
    </td>
  </tr>
  <tr>
    <td class="KT_th">SECCION:</td>
    <td colspan="13"><?php echo $seccion->get_seccion(); ?></td>
  </tr>
  <tr>
    <td class="KT_th"></td>
    <td class="KT_th"><?php echo $mes->get_mes12().'/'.$mes->get_anio12(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes11().'/'.$mes->get_anio11(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes10().'/'.$mes->get_anio10(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes9().'/'.$mes->get_anio9(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes8().'/'.$mes->get_anio8(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes7().'/'.$mes->get_anio7(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes6().'/'.$mes->get_anio6(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes5().'/'.$mes->get_anio5(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes4().'/'.$mes->get_anio4(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes3().'/'.$mes->get_anio3(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes2().'/'.$mes->get_anio1(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes1().'/'.$mes->get_anio1(); ?></td>
    <td class="KT_th"><?php echo $mes->get_mes().'/'.$mes->get_anio(); ?></td>
  </tr>
  <tr>
    <td width="202" height="17" class="KT_th">MO Productiva</td>
    <td align="right"><?php echo number_format(array_sum($totmoprod12),2);?></td>
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
    <?php 
    $n=array_sum($totmoprod12);
    $n1=array_sum($totmoprod11);
    $n2=array_sum($totmoprod10);
    $n3=array_sum($totmoprod9);
    $n4=array_sum($totmoprod8);
    $n5=array_sum($totmoprod7);
    $n6=array_sum($totmoprod6);
    $n7=array_sum($totmoprod5);
    $n8=array_sum($totmoprod4);
    $n9=array_sum($totmoprod3);
    $n10=array_sum($totmoprod2);
    $n11=array_sum($totmoprod1);
    $n12=array_sum($totmoprod);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td width="202" height="17" class="KT_th">MOIconSeccion</td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosec12),2);?></td>
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
      <?php 
    $n=array_sum($totmoinprosec12);
    $n1=array_sum($totmoinprosec11);
    $n2=array_sum($totmoinprosec10);
    $n3=array_sum($totmoinprosec9);
    $n4=array_sum($totmoinprosec8);
    $n5=array_sum($totmoinprosec7);
    $n6=array_sum($totmoinprosec6);
    $n7=array_sum($totmoinprosec5);
    $n8=array_sum($totmoinprosec4);
    $n9=array_sum($totmoinprosec3);
    $n10=array_sum($totmoinprosec2);
    $n11=array_sum($totmoinprosec1);

    $n12=array_sum($totmoinprosec);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">MOIsinSeccion</td>
    <td align="right"><?php echo number_format(array_sum($totmoinprosinsec12),2);?></td>
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
    <?php 
    $n=array_sum($totmoinprosinsec12);
    $n1=array_sum($totmoinprosinsec11);
    $n2=array_sum($totmoinprosinsec10);
    $n3=array_sum($totmoinprosinsec9);
    $n4=array_sum($totmoinprosinsec8);
    $n5=array_sum($totmoinprosinsec7);
    $n6=array_sum($totmoinprosinsec6);
    $n7=array_sum($totmoinprosinsec5);
    $n8=array_sum($totmoinprosinsec4);
    $n9=array_sum($totmoinprosinsec3);
    $n10=array_sum($totmoinprosinsec2);
    $n11=array_sum($totmoinprosinsec1);
    $n12=array_sum($totmoinprosinsec);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Insumos</td>
    <td align="right"><?php echo number_format($totinsu12,2); ?></td>
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
    <?php
    if ($totinsu12==0){$n=0;}else{$n=$totinsu12;}
    if ($totinsu11==0){$n1=0;}else{$n1=$totinsu11;}
    if ($totinsu10==0){$n2=0;}else{$n2=$totinsu10;}
    if ($totinsu9==0){$n3=0;}else{$n3=$totinsu9;}
    if ($totinsu8==0){$n4=0;}else{$n4=$totinsu8;}
    if ($totinsu7==0){$n5=0;}else{$n5=$totinsu7;} 
    if ($totinsu6==0){$n6=0;}else{$n6=$totinsu6;}
    if ($totinsu5==0){$n7=0;}else{$n7=$totinsu5;}  
    if ($totinsu4==0){$n8=0;}else{$n8=$totinsu4;}  
    if ($totinsu3==0){$n9=0;}else{$n9=$totinsu3;}  
    if ($totinsu2==0){$n10=0;}else{$n10=$totinsu2;}  
    if ($totinsu1==0){$n11=0;}else{$n11=$totinsu1;}  
    if ($totinsu==0){$n12=0;}else{$n12=$totinsu;}  
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td width="202" class="KT_th">Energia Electrica </td>
    <td align="right"><?php echo number_format(array_sum($totelectri12),2); ?></td>
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
    $n=array_sum($totelectri12);
    $n1=array_sum($totelectri11);
    $n2=array_sum($totelectri10);
    $n3=array_sum($totelectri9);
    $n4=array_sum($totelectri8);
    $n5=array_sum($totelectri7);
    $n6=array_sum($totelectri6);
    $n7=array_sum($totelectri5);
    $n8=array_sum($totelectri4);
    $n9=array_sum($totelectri3);
    $n10=array_sum($totelectri2);
    $n11=array_sum($totelectri1);
    $n12=array_sum($totelectri);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td width="202" class="KT_th">Depreciaci&oacute;n</td>
    <td align="right"><?php echo number_format(array_sum($totdep12),2); ?></td>
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
    $n=array_sum($totdep12); 
    $n1=array_sum($totdep11);
    $n2=array_sum($totdep10);
    $n3=array_sum($totdep9);
    $n4=array_sum($totdep8);
    $n5=array_sum($totdep7);
    $n6=array_sum($totdep6);
    $n7=array_sum($totdep5);
    $n8=array_sum($totdep4);
    $n9=array_sum($totdep3);
    $n10=array_sum($totdep2);
    $n11=array_sum($totdep1);
    $n12=array_sum($totdep);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
    <?php
array_splice($totdep,0);array_splice($totdep1,0);array_splice($totdep2,0);array_splice($totdep3,0);array_splice($totdep4,0);array_splice($totdep5,0);array_splice($totdep6,0);array_splice($totdep7,0);array_splice($totdep8,0);array_splice($totdep9,0);array_splice($totdep10,0);array_splice($totdep11,0);array_splice($totdep12,0);
?>
  </tr>
  <tr>
    <td class="KT_th">Seguros</td>
    <td align="right"><?php echo number_format(array_sum($totseg12),2); ?></td>
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
    $n=array_sum($totseg12);
    $n1=array_sum($totseg11);
    $n2=array_sum($totseg10);
    $n3=array_sum($totseg9);
    $n4=array_sum($totseg8);
    $n5=array_sum($totseg7);
    $n6=array_sum($totseg6);
    $n7=array_sum($totseg5);
    $n8=array_sum($totseg4);
    $n9=array_sum($totseg3);
    $n10=array_sum($totseg2);
    $n11=array_sum($totseg1);
    $n12=array_sum($totseg);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Mant. y rep.</td>
    <td align="right"><?php echo number_format($totmante12,2);?></td>
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
    <?php 
    if ($totmante12==0){$n=0;}else{$n=$totmante12;}
    if ($totmante11==0){$n1=0;}else{$n1=$totmante11;}
    if ($totmante10==0){$n2=0;}else{ $n2=$totmante10;}
    if ($totmante9==0){$n3=0;}else{$n3=$totmante9;}
    if ($totmante8==0){$n4=0;}else{$n4=$totmante8;}
    if ($totmante7==0){$n5=0;}else{$n5=$totmante7;}
    if ($totmante6==0){$n6=0;}else{$n6=$totmante6;}
    if ($totmante5==0){$n7=0;}else{$n7=$totmante5;}
    if ($totmante4==0){$n8=0;}else{$n8=$totmante4;}
    if ($totmante3==0){$n9=0;}else{$n9=$totmante3;}
    if ($totmante2==0){$n10=0;}else{$n10=$totmante2;}
    if ($totmante1==0){$n11=0;}else{$n11=$totmante1;}
    if ($totmante==0){$n12=0;}else{$n12=$totmante;}
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Generales Planta</td>
    <td align="right"><?php echo number_format(array_sum($totgenplan12),2); ?></td>
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
    $n=array_sum($totgenplan12);
    $n1=array_sum($totgenplan11);
    $n2=array_sum($totgenplan10);
    $n3=array_sum($totgenplan9);
    $n4=array_sum($totgenplan8);
    $n5=array_sum($totgenplan7);
    $n6=array_sum($totgenplan6);
    $n7=array_sum($totgenplan5);
    $n8=array_sum($totgenplan4);
    $n9=array_sum($totgenplan3);
    $n10=array_sum($totgenplan2);
    $n11=array_sum($totgenplan1);
    $n12=array_sum($totgenplan);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Otros</td>
    <td align="right"><?php echo number_format($tototros12,2);?></td>
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
    if ($tototros12==0){$n=0;}else{$n=$tototros12;}
    if ($tototros11==0){$n1=0;}else{$n1=$tototros11;}
    if ($tototros10==0){$n2=0;}else{$n2=$tototros10;}
    if ($tototros9==0){$n3=0;}else{$n3=$tototros9;}
    if ($tototros8==0){$n4=0;}else{$n4=$tototros8;}
    if ($tototros7==0){$n5=0;}else{$n5=$tototros7;}
    if ($tototros6==0){$n6=0;}else{$n6=$tototros6;}
    if ($tototros5==0){$n7=0;}else{$n7=$tototros5;}
    if ($tototros4==0){$n8=0;}else{$n8=$tototros4;}
    if ($tototros3==0){$n9=0;}else{$n9=$tototros3;}
    if ($tototros2==0){$n10=0;}else{$n10=$tototros2;}
    if ($tototros1==0){$n11=0;}else{$n11=$tototros1;}
    if ($tototros==0){$n12=0;}else{$n12=$tototros;}
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Total S/.</td>
    <td align="right"><?php echo number_format(array_sum($totalt12),2);?></td>
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
    <?php
    $n=array_sum($totalt12); 
    $n1=array_sum($totalt11);
    $n2=array_sum($totalt10);
    $n3=array_sum($totalt9);
    $n4=array_sum($totalt8);
    $n5=array_sum($totalt7);
    $n6=array_sum($totalt6);
    $n7=array_sum($totalt5);
    $n8=array_sum($totalt4);
    $n9=array_sum($totalt3);
    $n10=array_sum($totalt2);
    $n11=array_sum($totalt1);
    $n12=array_sum($totalt);
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th"><strong>Horas Producci&oacute;n </strong></td>
    <td align="right"><?php $totiem12 = $tiemsec12;
        echo number_format($totiem12, 2); ?></td>
    <td align="right"><?php $totiem11 = $tiemsec11;
        echo number_format($totiem11, 2); ?>
    </td>
    <td align="right"><?php $totiem10 = $tiemsec10;
        echo number_format($totiem10, 2); ?>
    </td>
    <td align="right"><?php $totiem9 = $tiemsec9;
        echo number_format($totiem9, 2); ?>
    </td>
    <td align="right"><?php $totiem8 = $tiemsec8;
        echo number_format($totiem8, 2); ?>
    </td>
    <td align="right"><?php $totiem7 = $tiemsec7;
        echo number_format($totiem7, 2); ?>
    </td>
    <td align="right"><?php $totiem6 = $tiemsec6;
        echo number_format($totiem6, 2); ?>
    </td>
    <td align="right"><?php $totiem5 = $tiemsec5;
        echo number_format($totiem5, 2); ?>
    </td>
    <td align="right"><?php $totiem4 = $tiemsec4;
        echo number_format($totiem4, 2); ?>
    </td>
    <td align="right"><?php $totiem3 = $tiemsec3;
        echo number_format($totiem3, 2); ?>
    </td>
    <td align="right"><?php $totiem2 = $tiemsec2;
        echo number_format($totiem2, 2); ?>
    </td>
    <td align="right"><?php $totiem1 = $tiemsec1;
        echo number_format($totiem1, 2); ?>
    </td>
    <td align="right"><?php $totiem = $tiemsec;
        echo number_format($totiem, 2); ?>
    </td>
    <?php 
    if ($totiem12==0){$n=0;}else{$n=$totiem12;}
    if ($totiem11==0){$n1=0;}else{$n1=$totiem11;}
    if ($totiem10==0){$n2=0;}else{$n2=$totiem10;}
    if ($totiem9==0){$n3=0;}else{$n3=$totiem9;}
    if ($totiem8==0){$n4=0;}else{$n4=$totiem8;}
    if ($totiem7==0){$n5=0;}else{$n5=$totiem7;}
    if ($totiem6==0){$n6=0;}else{$n6=$totiem6;}
    if ($totiem5==0){$n7=0;}else{$n7=$totiem5;}
    if ($totiem4==0){$n8=0;}else{$n8=$totiem4;}
    if ($totiem3==0){$n9=0;}else{$n9=$totiem3;}
    if ($totiem2==0){$n10=0;}else{$n10=$totiem2;}
    if ($totiem1==0){$n11=0;}else{$n11=$totiem1;}
    if ($totiem==0){$n12=0;}else{$n12=$totiem;}
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Costo x hora </td>
    <td align="right"><?php if ($totiem12 == 0){
    echo number_format(0, 2);$n=0;}else{
    echo number_format(array_sum($totalt12)/$totiem12, 2);$n=(array_sum($totalt12)/$totiem12);
    array_splice($totalt12,0);} ?></td>
    <td align="right"><?php if ($totiem11 == 0){
    echo number_format(0, 2);$n1=0;}else{
    echo number_format(array_sum($totalt11)/$totiem11, 2);$n1=(array_sum($totalt11)/$totiem11);
    array_splice($totalt11,0);} ?>
    </td>
    <td align="right"><?php if ($totiem10 == 0){
    echo number_format(0, 2);$n2=0;}else{
    echo number_format(array_sum($totalt10)/$totiem10, 2);$n2=(array_sum($totalt10)/$totiem10);
    array_splice($totalt10,0);} ?>
    </td>
    <td align="right"><?php if ($totiem9 == 0){
    echo number_format(0, 2);$n3=0;}else{
    echo number_format(array_sum($totalt9)/$totiem9, 2);$n3=(array_sum($totalt9)/$totiem9);
    array_splice($totalt9,0);} ?>
    </td>
    <td align="right"><?php if ($totiem8 == 0){
    echo number_format(0, 2);$n4=0;}else{
    echo number_format(array_sum($totalt8)/$totiem8, 2);$n4=(array_sum($totalt8)/$totiem8);
    array_splice($totalt8,0);} ?>
    </td>
    <td align="right"><?php if ($totiem7 == 0){
    echo number_format(0, 2);$n5=0;}else{
    echo number_format(array_sum($totalt7)/$totiem7, 2);$n5=(array_sum($totalt7)/$totiem7);
    array_splice($totalt7,0);} ?>
    </td>
    <td align="right"><?php if ($totiem6 == 0){
    echo number_format(0, 2);$n6=0;}else{
    echo number_format(array_sum($totalt6)/$totiem6, 2);$n6=(array_sum($totalt6)/$totiem6);
    array_splice($totalt6,0);} ?>
    </td>
    <td align="right"><?php if ($totiem5 == 0){
    echo number_format(0, 2);$n7=0;}else{
    echo number_format(array_sum($totalt5)/$totiem5, 2);$n7=(array_sum($totalt5)/$totiem5);
    array_splice($totalt5,0);} ?>
    </td>
    <td align="right"><?php if ($totiem4 == 0){
    echo number_format(0, 2);$n8=0;}else{
    echo number_format(array_sum($totalt4)/$totiem4, 2);$n8=(array_sum($totalt4)/$totiem4);
    array_splice($totalt4,0);} ?>
    </td>
    <td align="right"><?php if ($totiem3 == 0){
    echo number_format(0, 2);$n9=0;}else{
    echo number_format(array_sum($totalt3)/$totiem3, 2);$n9=(array_sum($totalt3)/$totiem3);
    array_splice($totalt3,0);} ?>
    </td>
    <td align="right"><?php if ($totiem2 == 0){
    echo number_format(0, 2);$n10=0;}else{
    echo number_format(array_sum($totalt2)/$totiem2, 2);$n10=(array_sum($totalt2)/$totiem2);
    array_splice($totalt2,0);} ?>
    </td>
    <td align="right"><?php if ($totiem1 == 0){
    echo number_format(0, 2);$n11=0;}else{
    echo number_format(array_sum($totalt1)/$totiem1, 2);$n11=(array_sum($totalt)/$totiem1);
    array_splice($totalt1,0);} ?>
    </td>
    <td align="right"><?php if ($totiem == 0){
    echo number_format(0, 2);$n12=0;}else{
    echo number_format(array_sum($totalt)/$totiem, 2);$n12=(array_sum($totalt)/$totiem);
    array_splice($totalt,0);} ?>
    </td><?php
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <tr>
    <td class="KT_th">Tarifa</td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio12(),$mes->get_mes12(),"1");
    $tf = $vtarifas->get_vsoles();$n = $vtarifas->get_vsoles(); echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio11(),$mes->get_mes11());
    $tf = $vtarifas->get_vsoles();$n1 = $vtarifas->get_vsoles(); echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio10(),$mes->get_mes10());
    $tf = $vtarifas->get_vsoles();$n2 = $vtarifas->get_vsoles();
    echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio9(),$mes->get_mes9());
    $tf = $vtarifas->get_vsoles();$n3 = $vtarifas->get_vsoles();
    echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio8(),$mes->get_mes8());
    $tf = $vtarifas->get_vsoles();$n4 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio7(),$mes->get_mes7());
    $tf = $vtarifas->get_vsoles();$n5 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio6(),$mes->get_mes6());
    $tf = $vtarifas->get_vsoles();$n6 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio5(),$mes->get_mes5());
    $tf = $vtarifas->get_vsoles();$n7 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio4(),$mes->get_mes4());
    $tf = $vtarifas->get_vsoles();$n8 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio3(),$mes->get_mes3());
    $tf = $vtarifas->get_vsoles();$n9 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio2(),$mes->get_mes2());
    $tf = $vtarifas->get_vsoles();$n10 = $vtarifas->get_vsoles();
    echo number_format($tf,2);?>
    </td>
    <td align="right"><?php 
    $vtarifas->conectar($idsec,$mes->get_anio1(),$mes->get_mes1());
    $tf = $vtarifas->get_vsoles();$n11 = $vtarifas->get_vsoles();
    echo number_format($tf,2);?>
    </td>
    <td align="right"><?php
    $vtarifas->conectar($idsec,$mes->get_anio(),$mes->get_mes());
    $tf = $vtarifas->get_vsoles();$n12 = $vtarifas->get_vsoles();echo number_format($tf,2);?>
    </td>
    <?php
    $Insert=$funciones->insertReporte($n,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12);
    ?>
  </tr>
  <?php
  //resetear arrays MO
    array_splice($totmoprod12,0);array_splice($totmoinprosec12,0);array_splice($totmoinprosinsec12,0);array_splice($total12,0);
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
array_splice($totseg,0);array_splice($totseg1,0);array_splice($totseg2,0);array_splice($totseg3,0);array_splice($totseg4,0);array_splice($totseg5,0);array_splice($totseg6,0);array_splice($totseg7,0);array_splice($totseg8,0);array_splice($totseg9,0);array_splice($totseg10,0);array_splice($totseg11,0);array_splice($totseg12,0);
    //resetear arrays electricidad
    array_splice($totelectri,0);array_splice($totelectri1,0);array_splice($totelectri2,0);
array_splice($totelectri3,0);array_splice($totelectri4,0);array_splice($totelectri5,0);
array_splice($totelectri6,0);array_splice($totelectri7,0);array_splice($totelectri8,0);
array_splice($totelectri9,0);array_splice($totelectri10,0);array_splice($totelectri11,0);array_splice($totelectri12,0);
    //resetear arrays generales planta
    array_splice($totgenplan,0);array_splice($totgenplan1,0);array_splice($totgenplan2,0);array_splice($totgenplan3,0);array_splice($totgenplan4,0);array_splice($totgenplan5,0);array_splice($totgenplan6,0);array_splice($totgenplan7,0);array_splice($totgenplan8,0);array_splice($totgenplan9,0);array_splice($totgenplan10,0);array_splice($totgenplan11,0);
    array_splice($totgenplan12,0);
        $seccion->MoveNext();
    
  }
?>
</table>
</body>
</html>
<?php
//$seccion->Close();
//$exfacgac->Close();
$tiempo_final = microtime(true);
$tiempo = $tiempo_final - $tiempo_inicio;
$tiempo=$tiempo/60;
echo "<p> tiempo total del script: $tiempo segundos\n";
}
?>