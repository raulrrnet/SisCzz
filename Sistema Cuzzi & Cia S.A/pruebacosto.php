<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//MX Widgets3 include
require_once('includes/wdg/WDG.php');

$fecha = '2007/12/31';
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

echo $fecha12;
?>