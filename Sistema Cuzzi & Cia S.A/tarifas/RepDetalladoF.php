<?php
set_time_limit(0);
require_once('config.php');
require_once('clsconexion.php');
include('adodb/adodb.inc.php');
	$db = ADONewConnection('postgres8'); # eg 'mysql' o 'postgres'
	$db->Connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$rsSeccion = $db->Execute("SELECT * FROM seccion where status<>'x' and idseccion<>0 ORDER BY seccion");
	$rsSeccion->MoveFirst();
	$rsReporte = $db->Execute("select * from reportefinal ORDER BY idreporte");
	$rsReporte->MoveFirst();
$cone=new conexion(DB_SERVER,DB_NAME,DB_USERNAME,DB_PASSWORD);
$con=$cone->Conexion("");
$tiempo_inicio = microtime(true);
// begin Recordset
$fechas=$cone->Fechas();
$fecha=$fechas[1];
$rsadminco = $db->Execute("SELECT * FROM  gastoadmincomer where fecha <= '$fecha' order by fecha desc limit 13");
$rsadminco->MoveFirst();
while(!$rsadminco->EOF){
	$adcoArray[]=$rsadminco->Fields(2);
	$rsadminco->MoveNext();
}

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
$fechastot=pg_query($mes);
while($rowFechas = pg_fetch_row($fechastot)){
	$mostrar="<p> fechas:";
	for($a=12;$a>=0;$a--){
		$mostrar.="<p>".$rowFechas[$a]."-";
		$fechArray[]=$rowFechas[$a];
	}
}
$mes12=date('m',strtotime($fechArray[12]));$mes11=date('m',strtotime($fechArray[11]));
$mes10=date('m',strtotime($fechArray[10]));$mes9=date('m',strtotime($fechArray[9]));
$mes8=date('m',strtotime($fechArray[8]));$mes7=date('m',strtotime($fechArray[7]));
$mes6=date('m',strtotime($fechArray[6]));$mes5=date('m',strtotime($fechArray[5]));
$mes4=date('m',strtotime($fechArray[4]));$mes3=date('m',strtotime($fechArray[3]));
$mes2=date('m',strtotime($fechArray[2]));$mes1=date('m',strtotime($fechArray[1]));
$mes=date('m',strtotime($fechArray[0]));$an12=date('Y',strtotime($fechArray[12]));
$an11=date('Y',strtotime($fechArray[11]));$an10=date('Y',strtotime($fechArray[10]));
$an9=date('Y',strtotime($fechArray[9]));$an8=date('Y',strtotime($fechArray[8]));
$an7=date('Y',strtotime($fechArray[7]));$an6=date('Y',strtotime($fechArray[6]));
$an5=date('Y',strtotime($fechArray[5]));$an4=date('Y',strtotime($fechArray[4]));
$an3=date('Y',strtotime($fechArray[3]));$an2=date('Y',strtotime($fechArray[2]));
$an1=date('Y',strtotime($fechArray[1]));$an=date('Y',strtotime($fechArray[0]));
$fecha12=date('Y/m/d',strtotime($fechArray[12]));$fecha11=date('Y/m/d',strtotime($fechArray[11]));
$fecha10=date('Y/m/d',strtotime($fechArray[10]));$fecha9=date('Y/m/d',strtotime($fechArray[9]));
$fecha8=date('Y/m/d',strtotime($fechArray[8]));$fecha7=date('Y/m/d',strtotime($fechArray[7]));
$fecha6=date('Y/m/d',strtotime($fechArray[6]));$fecha5=date('Y/m/d',strtotime($fechArray[5]));
$fecha4=date('Y/m/d',strtotime($fechArray[4]));$fecha3=date('Y/m/d',strtotime($fechArray[3]));
$fecha2=date('Y/m/d',strtotime($fechArray[2]));$fecha1=date('Y/m/d',strtotime($fechArray[1]));
$fechan=date('Y/m/d',strtotime($fechArray[0]));
$tCelda0=0;$tCelda1=0;$tCelda2=0;$tCelda3=0;$tCelda4=0;$tCelda5=0;$tCelda6=0;$tCelda7=0;$tCelda8=0;
$tCelda9=0;$tCelda10=0;$tCelda11=0;$tCelda12=0;$tCelda9=0;$tCelda10=0;$tCelda11=0;$tCelda12=0;
$tCelda13=0;$tCelda14=0;$tCelda15=0;$tCelda16=0;$tCelda17=0;$tCelda18=0;$tCelda19=0;$tCelda20=0;
$tCelda21=0;$tCelda22=0;$tCelda23=0;$tCelda24=0;$tCelda25=0;$tCelda26=0;$tCelda27=0;$tCelda28=0;
$tCelda29=0;$tCelda30=0;$tCelda31=0;$tCelda32=0;$tCelda33=0;$tCelda34=0;$tCelda35=0;$tCelda36=0;
$tCelda37=0;$tCelda38=0;$tCelda39=0;$tCelda40=0;$tCelda41=0;$tCelda42=0;$tCelda43=0;$tCelda44=0;
$tCelda45=0;$tCelda46=0;$tCelda47=0;$tCelda48=0;$tCelda49=0;$tCelda50=0;$tCelda51=0;$tCelda52=0;
$tCelda53=0;$tCelda54=0;$tCelda55=0;$tCelda56=0;$tCelda57=0;$tCelda58=0;$tCelda59=0;$tCelda60=0;
$tCelda61=0;$tCelda62=0;$tCelda63=0;$tCelda64=0;$tCelda65=0;$tCelda66=0;$tCelda67=0;$tCelda68=0;
$tCelda69=0;$tCelda70=0;$tCelda71=0;$tCelda72=0;$tCelda73=0;$tCelda74=0;$tCelda75=0;$tCelda76=0;
$tCelda77=0;$tCelda78=0;$tCelda79=0;$tCelda80=0;$tCelda81=0;$tCelda82=0;$tCelda83=0;$tCelda84=0;
$tCelda85=0;$tCelda86=0;$tCelda86=0;$tCelda87=0;$tCelda88=0;$tCelda89=0;$tCelda90=0;$tCelda91=0;
$tCelda92=0;$tCelda93=0;$tCelda94=0;$tCelda95=0;$tCelda96=0;$tCelda97=0;$tCelda98=0;$tCelda99=0;
$tCelda100=0;$tCelda101=0;$tCelda102=0;$tCelda103=0;$tCelda104=0;$tCelda105=0;$tCelda106=0;$tCelda107=0;
$tCelda108=0;$tCelda109=0;$tCelda110=0;$tCelda111=0;$tCelda112=0;$tCelda113=0;$tCelda114=0;$tCelda115=0;
$tCelda116=0;$tCelda117=0;$tCelda118=0;$tCelda119=0;$tCelda120=0;$tCelda121=0;$tCelda122=0;$tCelda123=0;
$tCelda124=0;$tCelda125=0;$tCelda126=0;$tCelda127=0;$tCelda128=0;$tCelda129=0;$tCelda130=0;$tCelda131=0;
$tCelda132=0;$tCelda133=0;$tCelda134=0;$tCelda135=0;$tCelda136=0;$tCelda137=0;$tCelda138=0;$tCelda139=0;
$tCelda140=0;$tCelda141=0;$tCelda142=0;$tCelda143=0;$tCelda144=0;$tCelda145=0;$tCelda146=0;$tCelda147=0;
$tCelda148=0;$tCelda149=0;$tCelda150=0;$tCelda151=0;$tCelda152=0;$tCelda153=0;$tCelda154=0;$tCelda155=0;
$tCelda156=0;$tCelda157=0;$tCelda158=0;$tCelda159=0;$tCelda160=0;$tCelda161=0;$tCelda161=0;$tCelda162=0;
$tCelda163=0;$tCelda164=0;$tCelda165=0;$tCelda166=0;$tCelda167=0;$tCelda168=0;$tCelda169=0;$tCelda170=0;
$tCelda171=0;$tCelda172=0;$tCelda173=0;$tCelda174=0;$tCelda175=0;$tCelda176=0;$tCelda177=0;$tCelda178=0;
$tCelda179=0;$tCelda180=0;$tCelda181=0;$tCelda182=0;

?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<table border=1 align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
<?php
while (!$rsSeccion->EOF) 
{
?>
  <tr>
    <td colspan="15" class="selected_cal"><hr>    </td>
  </tr>
  <tr>
    <td class="KT_th">SECCION:</td>
    <td colspan="14"><?php echo $rsSeccion->Fields(1); ?></td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th"><?php echo $mes12.'/'.$an12; ?></td>
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
    <td class="KT_th">   Totales    </td>
  </tr>
  <tr>
    <td width="202" height="17" class="KT_th">MO Productiva</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila=$rsReporte->Fields(2);
	$tRow1=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila+=$rsReporte->Fields(3);
	$tRow2=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila+=$rsReporte->Fields(4);
	$tRow3=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila+=$rsReporte->Fields(5);
	$tRow4=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila+=$rsReporte->Fields(6);
	$tRow5=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila+=$rsReporte->Fields(7);
	$tRow6=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila+=$rsReporte->Fields(8);
	$tRow7=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila+=$rsReporte->Fields(9);
	$tRow8=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila+=$rsReporte->Fields(10);
	$tRow9=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila+=$rsReporte->Fields(11);
	$tRow10=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila+=$rsReporte->Fields(12);
	$tRow11=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila+=$rsReporte->Fields(13);
	$tRow12=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila,2);?></td>
  </tr>
  
  	<?php if ($rsSeccion->Fields('idseccion')<>20 ){
  $tCelda0+=$rsReporte->Fields(1);
  $tCelda1+=$rsReporte->Fields(2);
  $tCelda2+=$rsReporte->Fields(3);
  $tCelda3+=$rsReporte->Fields(4); 
  $tCelda4+=$rsReporte->Fields(5);
  $tCelda5+=$rsReporte->Fields(6);
  $tCelda6+=$rsReporte->Fields(7);
  $tCelda7+=$rsReporte->Fields(8); 
  $tCelda8+=$rsReporte->Fields(9); 
  $tCelda9+=$rsReporte->Fields(10); 
  $tCelda10+=$rsReporte->Fields(11);
  $tCelda11+=$rsReporte->Fields(12);
  $tCelda12+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>  
  <tr>
    <td width="202" height="17" class="KT_th">MOIconSeccion</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila1=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila1+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila1+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila1+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila1+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila1+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila1+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila1+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila1+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila1+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila1+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila1+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila1,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){ 
  $tCelda13+=$rsReporte->Fields(1);
  $tCelda14+=$rsReporte->Fields(2);
  $tCelda15+=$rsReporte->Fields(3);
  $tCelda16+=$rsReporte->Fields(4); 
  $tCelda17+=$rsReporte->Fields(5);
  $tCelda18+=$rsReporte->Fields(6);
  $tCelda19+=$rsReporte->Fields(7);
  $tCelda20+=$rsReporte->Fields(8); 
  $tCelda21+=$rsReporte->Fields(9); 
  $tCelda22+=$rsReporte->Fields(10); 
  $tCelda23+=$rsReporte->Fields(11);
  $tCelda24+=$rsReporte->Fields(12);
  $tCelda25+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">MOIsinSeccion</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila2=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila2+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila2+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila2+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila2+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila2+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila2+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila2+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila2+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila2+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila2+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila2+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila2,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda26+=$rsReporte->Fields(1);
  $tCelda27+=$rsReporte->Fields(2);
  $tCelda28+=$rsReporte->Fields(3);
  $tCelda29+=$rsReporte->Fields(4); 
  $tCelda30+=$rsReporte->Fields(5);
  $tCelda31+=$rsReporte->Fields(6);
  $tCelda32+=$rsReporte->Fields(7);
  $tCelda33+=$rsReporte->Fields(8); 
  $tCelda34+=$rsReporte->Fields(9); 
  $tCelda35+=$rsReporte->Fields(10); 
  $tCelda36+=$rsReporte->Fields(11);
  $tCelda37+=$rsReporte->Fields(12);
  $tCelda38+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Insumos</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila3=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila3+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila3+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila3+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila3+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila3+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila3+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila3+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila3+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila3+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila3+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila3+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila3,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){ 
  $tCelda39+=$rsReporte->Fields(1);
  $tCelda40+=$rsReporte->Fields(2);
  $tCelda41+=$rsReporte->Fields(3);
  $tCelda42+=$rsReporte->Fields(4); 
  $tCelda43+=$rsReporte->Fields(5);
  $tCelda44+=$rsReporte->Fields(6);
  $tCelda45+=$rsReporte->Fields(7);
  $tCelda46+=$rsReporte->Fields(8); 
  $tCelda47+=$rsReporte->Fields(9); 
  $tCelda48+=$rsReporte->Fields(10); 
  $tCelda49+=$rsReporte->Fields(11);
  $tCelda50+=$rsReporte->Fields(12);
  $tCelda51+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td width="202" class="KT_th">Energia Electrica </td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila4=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila4+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila4+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila4+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila4+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila4+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila4+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila4+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila4+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila4+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila4+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila4+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila4,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda52+=$rsReporte->Fields(1);
  $tCelda53+=$rsReporte->Fields(2);
  $tCelda54+=$rsReporte->Fields(3);
  $tCelda55+=$rsReporte->Fields(4); 
  $tCelda56+=$rsReporte->Fields(5);
  $tCelda57+=$rsReporte->Fields(6);
  $tCelda58+=$rsReporte->Fields(7);
  $tCelda59+=$rsReporte->Fields(8); 
  $tCelda60+=$rsReporte->Fields(9); 
  $tCelda61+=$rsReporte->Fields(10); 
  $tCelda62+=$rsReporte->Fields(11);
  $tCelda63+=$rsReporte->Fields(12);
  $tCelda64+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td width="202" class="KT_th">Depreciaci&oacute;n</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila5=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila5+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila5+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila5+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila5+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila5+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila5+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila5+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila5+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila5+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila5+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila5+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila5,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda65+=$rsReporte->Fields(1);
  $tCelda66+=$rsReporte->Fields(2);
  $tCelda67+=$rsReporte->Fields(3);
  $tCelda68+=$rsReporte->Fields(4);
  $tCelda69+=$rsReporte->Fields(5);
  $tCelda70+=$rsReporte->Fields(6);
  $tCelda71+=$rsReporte->Fields(7);
  $tCelda72+=$rsReporte->Fields(8);
  $tCelda73+=$rsReporte->Fields(9); 
  $tCelda74+=$rsReporte->Fields(10); 
  $tCelda75+=$rsReporte->Fields(11);  
  $tCelda76+=$rsReporte->Fields(12);
  $tCelda77+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Seguros</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila6=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila6+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila6+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila6+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila6+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila6+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila6+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila6+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila6+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila6+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila6+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila6+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila6,2);?></td>
  </tr>  
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda78+=$rsReporte->Fields(1);
  $tCelda79+=$rsReporte->Fields(2);
  $tCelda80+=$rsReporte->Fields(3);
  $tCelda81+=$rsReporte->Fields(4);
  $tCelda82+=$rsReporte->Fields(5); 
  $tCelda83+=$rsReporte->Fields(6); 
  $tCelda84+=$rsReporte->Fields(7);
  $tCelda85+=$rsReporte->Fields(8);  
  $tCelda86+=$rsReporte->Fields(9);
  $tCelda87+=$rsReporte->Fields(10);
  $tCelda88+=$rsReporte->Fields(11);
  $tCelda89+=$rsReporte->Fields(12);
  $tCelda90+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Mant. y rep.</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila7=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila7+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila7+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila7+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila7+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila7+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila7+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila7+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila7+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila7+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila7+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila7+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila7,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda91+=$rsReporte->Fields(1);
  $tCelda92+=$rsReporte->Fields(2);
  $tCelda93+=$rsReporte->Fields(3);
  $tCelda94+=$rsReporte->Fields(4);
  $tCelda95+=$rsReporte->Fields(5);   
  $tCelda96+=$rsReporte->Fields(6);
  $tCelda97+=$rsReporte->Fields(7);
  $tCelda98+=$rsReporte->Fields(8);
  $tCelda99+=$rsReporte->Fields(9);
  $tCelda100+=$rsReporte->Fields(10);
  $tCelda101+=$rsReporte->Fields(11);
  $tCelda102+=$rsReporte->Fields(12);
  $tCelda103+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Generales Planta</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila8=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila8+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila8+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila8+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila8+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila8+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila8+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila8+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila8+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila8+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila8+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila8+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila8,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda104+=$rsReporte->Fields(1);
  $tCelda105+=$rsReporte->Fields(2);
  $tCelda106+=$rsReporte->Fields(3);
  $tCelda107+=$rsReporte->Fields(4);   
  $tCelda108+=$rsReporte->Fields(5);
  $tCelda109+=$rsReporte->Fields(6);
  $tCelda110+=$rsReporte->Fields(7);
  $tCelda111+=$rsReporte->Fields(8);
  $tCelda112+=$rsReporte->Fields(9);
  $tCelda113+=$rsReporte->Fields(10);
  $tCelda114+=$rsReporte->Fields(11);
  $tCelda115+=$rsReporte->Fields(12);
  $tCelda116+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Otros</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila9=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila9+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila9+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila9+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila9+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila9+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila9+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila9+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila9+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila9+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila9+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila9+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila9,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda117+=$rsReporte->Fields(1);
  $tCelda118+=$rsReporte->Fields(2);
  $tCelda119+=$rsReporte->Fields(3); 
  $tCelda120+=$rsReporte->Fields(4);
  $tCelda121+=$rsReporte->Fields(5);
  $tCelda122+=$rsReporte->Fields(6);
  $tCelda123+=$rsReporte->Fields(7);
  $tCelda124+=$rsReporte->Fields(8);
  $tCelda125+=$rsReporte->Fields(9);
  $tCelda126+=$rsReporte->Fields(10);
  $tCelda127+=$rsReporte->Fields(11);
  $tCelda128+=$rsReporte->Fields(12);  
  $tCelda129+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Total S/.</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);$a1=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila10=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);$a2=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila10+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);$a3=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila10+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);$a4=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila10+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);$a5=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila10+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);$a6=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila10+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);$a7=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila10+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);$a8=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila10+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);$a9=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila10+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);$a10=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila10+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);$a11=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila10+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);$a12=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila10+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);$a13=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($tFila10,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda130+=$rsReporte->Fields(1);
  $tCelda131+=$rsReporte->Fields(2); 
  $tCelda132+=$rsReporte->Fields(3);
  $tCelda133+=$rsReporte->Fields(4);
  $tCelda134+=$rsReporte->Fields(5);
  $tCelda135+=$rsReporte->Fields(6);
  $tCelda136+=$rsReporte->Fields(7);
  $tCelda137+=$rsReporte->Fields(8);
  $tCelda138+=$rsReporte->Fields(9);
  $tCelda139+=$rsReporte->Fields(10);
  $tCelda140+=$rsReporte->Fields(11);  
  $tCelda141+=$rsReporte->Fields(12);
  $tCelda142+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Horas Producci&oacute;n</td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);$v1=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila11=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);$v2=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila11+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);$v3=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila11+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);$v4=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila11+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);$v5=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila11+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);$v6=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila11+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);$v7=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila11+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);$v8=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila11+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);$v9=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila11+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);$v10=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila11+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);$v11=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila11+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);$v12=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila11+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);$v13=$rsReporte->Fields(13);?></td>
    <td align="right"><?php $vt=$tFila11; echo number_format($tFila11,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda143+=$rsReporte->Fields(1);  
  $tCelda144+=$rsReporte->Fields(2); 
  $tCelda145+=$rsReporte->Fields(3);
  $tCelda146+=$rsReporte->Fields(4);
  $tCelda147+=$rsReporte->Fields(5);
  $tCelda148+=$rsReporte->Fields(6);
  $tCelda149+=$rsReporte->Fields(7);
  $tCelda150+=$rsReporte->Fields(8);
  $tCelda151+=$rsReporte->Fields(9);
  $tCelda152+=$rsReporte->Fields(10);
  $tCelda153+=$rsReporte->Fields(11);
  $tCelda154+=$rsReporte->Fields(12);
  $tCelda155+=$rsReporte->Fields(13);}
  $rsReporte->MoveNext();?>
  <tr>
    <td class="KT_th">Costo x hora </td>
	<?php
	if ($v1==0){$cxho1=0;}else{$cxho1=$a1/$v1;}
	if ($v2==0){$cxho2=0;}else{$cxho2=$a2/$v2;}
	if ($v3==0){$cxho3=0;}else{$cxho3=$a3/$v3;}
	if ($v4==0){$cxho4=0;}else{$cxho4=$a4/$v4;}
	if ($v5==0){$cxho5=0;}else{$cxho5=$a5/$v5;}
	if ($v6==0){$cxho6=0;}else{$cxho6=$a6/$v6;}
	if ($v7==0){$cxho7=0;}else{$cxho7=$a7/$v7;}
	if ($v8==0){$cxho8=0;}else{$cxho8=$a8/$v8;}
	if ($v9==0){$cxho9=0;}else{$cxho9=$a9/$v9;}
	if ($v10==0){$cxho10=0;}else{$cxho10=$a10/$v10;}
	if ($v11==0){$cxho11=0;}else{$cxho11=$a11/$v11;}
	if ($v12==0){$cxho12=0;}else{$cxho12=$a12/$v12;}
	if ($v13==0){$cxho13=0;}else{$cxho13=$a13/$v13;}
	if ($vt==0){$cxhot=0;}else{$cxhot=$tFila10/$tFila11;}
	?>
    <td align="right"><?php echo number_format($cxho1,2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($cxho2,2);$tFila12=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($cxho3,2);$tFila12+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($cxho4,2);$tFila12+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($cxho5,2);$tFila12+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($cxho6,2);$tFila12+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($cxho7,2);$tFila12+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($cxho8,2);$tFila12+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($cxho9,2);$tFila12+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($cxho10,2);$tFila12+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($cxho11,2);$tFila12+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($cxho12,2);$tFila12+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($cxho13,2);$tFila12+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right"><?php echo number_format($cxhot,2);?></td>
  </tr>
  <?php if ($rsSeccion->Fields('idseccion')<>20){
  $tCelda156+=$rsReporte->Fields(1);
  $tCelda157+=$rsReporte->Fields(2);
  $tCelda158+=$rsReporte->Fields(3);
  $tCelda159+=$rsReporte->Fields(4);
  $tCelda160+=$rsReporte->Fields(5);
  $tCelda161+=$rsReporte->Fields(6);
  $tCelda162+=$rsReporte->Fields(7);
  $tCelda163+=$rsReporte->Fields(8);
  $tCelda164+=$rsReporte->Fields(9);
  $tCelda165+=$rsReporte->Fields(10);
  $tCelda166+=$rsReporte->Fields(11);
  $tCelda167+=$rsReporte->Fields(12);
  $tCelda168+=$rsReporte->Fields(13); }
  $rsReporte->MoveNext();?>
  <tr>
  	<td class="KT_th">Tarifa </td>
    <td align="right"><?php echo number_format($rsReporte->Fields(1),2);
	$tRow0+=$rsReporte->Fields(1);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(2),2);$tFila13=$rsReporte->Fields(2);
	$tRow1+=$rsReporte->Fields(2);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(3),2);$tFila13+=$rsReporte->Fields(3);
	$tRow2+=$rsReporte->Fields(3);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(4),2);$tFila13+=$rsReporte->Fields(4);
	$tRow3+=$rsReporte->Fields(4);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(5),2);$tFila13+=$rsReporte->Fields(5);
	$tRow4+=$rsReporte->Fields(5);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(6),2);$tFila13+=$rsReporte->Fields(6);
	$tRow5+=$rsReporte->Fields(6);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(7),2);$tFila13+=$rsReporte->Fields(7);
	$tRow6+=$rsReporte->Fields(7);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(8),2);$tFila13+=$rsReporte->Fields(8);
	$tRow7+=$rsReporte->Fields(8);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(9),2);$tFila13+=$rsReporte->Fields(9);
	$tRow8+=$rsReporte->Fields(9);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(10),2);$tFila13+=$rsReporte->Fields(10);
	$tRow9+=$rsReporte->Fields(10);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(11),2);$tFila13+=$rsReporte->Fields(11);
	$tRow10+=$rsReporte->Fields(11);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(12),2);$tFila13+=$rsReporte->Fields(12);
	$tRow11+=$rsReporte->Fields(12);?></td>
    <td align="right"><?php echo number_format($rsReporte->Fields(13),2);$tFila13+=$rsReporte->Fields(13);
	$tRow12+=$rsReporte->Fields(13);?></td>
    <td align="right">-</td>
  </tr>
    <?php if ($rsSeccion->Fields('idseccion')<>20){ 
  $tCelda169+=$rsReporte->Fields(1);
  $tCelda170+=$rsReporte->Fields(2);
  $tCelda171+=$rsReporte->Fields(3);
  $tCelda172+=$rsReporte->Fields(4);
  $tCelda173+=$rsReporte->Fields(5);
  $tCelda174+=$rsReporte->Fields(6);
  $tCelda175+=$rsReporte->Fields(7);
  $tCelda176+=$rsReporte->Fields(8);
  $tCelda177+=$rsReporte->Fields(9);
  $tCelda178+=$rsReporte->Fields(10);
  $tCelda179+=$rsReporte->Fields(11); 
  $tCelda180+=$rsReporte->Fields(12);
  $tCelda181+=$rsReporte->Fields(13); }
  $rsReporte->MoveNext();?>
   
  <?php
  	//$rsReporte->MoveNext();
	$rsSeccion->MoveNext();
  }
?>
<!--////////////////////////////////aqui el resumen del año//////////////////////////////////////-->
  <tr>
    <td colspan="15" class="selected_cal"><hr>    </td>
  </tr>
  <tr>
    <td class="KT_th">SECCION: Total Anual</td>
    <td colspan="14"><?php echo " Total Anual" ?></td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th"><?php echo $mes12.'/'.$an12; ?></td>
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
    <td class="KT_th">   Totales    </td>
  </tr>
  <tr>
  <?php $rsmo=$db->Execute("select * from reportefinal where idreporte=1") ?>
    <td width="202" height="17" class="KT_th">Total : MO Productiva</td>
    <td align="right"><?php echo number_format($tCelda0+$rsmo->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda1+$rsmo->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda2+$rsmo->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda3+$rsmo->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda4+$rsmo->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda5+$rsmo->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda6+$rsmo->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda7+$rsmo->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda8+$rsmo->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda9+$rsmo->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda10+$rsmo->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda11+$rsmo->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda12+$rsmo->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda1+$tCelda2+$tCelda3+$tCelda4+$tCelda5+$tCelda6+$tCelda7+$tCelda8+$tCelda9+$tCelda10+$tCelda11+$tCelda12+$rsmo->Fields(2)+$rsmo->Fields(3)+$rsmo->Fields(4)+$rsmo->Fields(5)+$rsmo->Fields(6)+$rsmo->Fields(7)+$rsmo->Fields(8)+$rsmo->Fields(9)+$rsmo->Fields(10)+$rsmo->Fields(11)+$rsmo->Fields(12)+$rsmo->Fields(13)),2);?></td>
  </tr>
  <tr>
  <?php $rsmcs=$db->Execute("select * from reportefinal where idreporte=2") ?>
    <td width="202" height="17" class="KT_th">Total : MOIconSeccion</td>
    <td align="right"><?php echo number_format($tCelda13+$rsmcs->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda14+$rsmcs->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda15+$rsmcs->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda16+$rsmcs->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda17+$rsmcs->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda18+$rsmcs->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda19+$rsmcs->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda20+$rsmcs->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda21+$rsmcs->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda22+$rsmcs->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda23+$rsmcs->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda24+$rsmcs->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda25+$rsmcs->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda14+$tCelda15+$tCelda16+$tCelda17+$tCelda18+$tCelda19+$tCelda20+$tCelda21+$tCelda22+$tCelda23+$tCelda24+$tCelda25+$rsmcs->Fields(2)+$rsmcs->Fields(3)+$rsmcs->Fields(4)+$rsmcs->Fields(5)+$rsmcs->Fields(6)+$rsmcs->Fields(7)+$rsmcs->Fields(8)+$rsmcs->Fields(9)+$rsmcs->Fields(10)+$rsmcs->Fields(11)+$rsmcs->Fields(12)+$rsmcs->Fields(13)),2);?></td>
  </tr>

  <tr>
   <?php $rsmss=$db->Execute("select * from reportefinal where idreporte=3") ?>
    <td class="KT_th">Total : MOIsinSeccion</td>
    <td align="right"><?php echo number_format($tCelda26+$rsmss->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda27+$rsmss->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda28+$rsmss->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda29+$rsmss->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda30+$rsmss->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda31+$rsmss->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda32+$rsmss->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda33+$rsmss->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda34+$rsmss->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda35+$rsmss->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda36+$rsmss->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda37+$rsmss->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda38+$rsmss->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda27+$tCelda28+$tCelda29+$tCelda30+$tCelda31+$tCelda32+$tCelda33+$tCelda34+$tCelda35+$tCelda36+$tCelda37+$tCelda38+$rsmss->Fields(2)+$rsmss->Fields(3)+$rsmss->Fields(4)+$rsmss->Fields(5)+$rsmss->Fields(6)+$rsmss->Fields(7)+$rsmss->Fields(8)+$rsmss->Fields(9)+$rsmss->Fields(10)+$rsmss->Fields(11)+$rsmss->Fields(12)+$rsmss->Fields(13)),2);?></td>
  </tr>
  <tr>
  <?php $rsi=$db->Execute("select * from reportefinal where idreporte=4") ?>
    <td class="KT_th">Total : Insumos</td>
    <td align="right"><?php echo number_format($tCelda39+$rsi->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda40+$rsi->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda41+$rsi->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda42+$rsi->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda43+$rsi->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda44+$rsi->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda45+$rsi->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda46+$rsi->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda47+$rsi->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda48+$rsi->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda49+$rsi->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda50+$rsi->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda51+$rsi->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda40+$tCelda41+$tCelda42+$tCelda43+$tCelda44+$tCelda45+$tCelda46+$tCelda47+$tCelda48+$tCelda49+$tCelda50+$tCelda51+$rsi->Fields(2)+$rsi->Fields(3)+$rsi->Fields(4)+$rsi->Fields(5)+$rsi->Fields(6)+$rsi->Fields(7)+$rsi->Fields(8)+$rsi->Fields(9)+$rsi->Fields(10)+$rsi->Fields(11)+$rsi->Fields(12)+$rsi->Fields(13)),2);?></td>
  </tr>
  <tr>
  <?php $rse=$db->Execute("select * from reportefinal where idreporte=5") ?>
    <td width="202" class="KT_th">Total : Energia Electrica </td>
    <td align="right"><?php echo number_format($tCelda52+$rse->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda53+$rse->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda54+$rse->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda55+$rse->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda56+$rse->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda57+$rse->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda58+$rse->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda59+$rse->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda60+$rse->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda61+$rse->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda62+$rse->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda63+$rse->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda64+$rse->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda53+$tCelda54+$tCelda55+$tCelda56+$tCelda57+$tCelda58+$tCelda59+$tCelda60+$tCelda61+$tCelda62+$tCelda63+$tCelda64+$rse->Fields(2)+$rse->Fields(3)+$rse->Fields(4)+$rse->Fields(5)+$rse->Fields(6)+$rse->Fields(7)+$rse->Fields(8)+$rse->Fields(9)+$rse->Fields(10)+$rse->Fields(11)+$rse->Fields(12)+$rse->Fields(13)),2);?></td>  
  </tr>
  <tr>
    <?php $rsd=$db->Execute("select * from reportefinal where idreporte=6") ?>
    <td width="202" class="KT_th">Total : Depreciaci&oacute;n</td>
    <td align="right"><?php echo number_format($tCelda65+$rsd->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda66+$rsd->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda67+$rsd->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda68+$rsd->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda69+$rsd->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda70+$rsd->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda71+$rsd->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda72+$rsd->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda73+$rsd->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda74+$rsd->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda75+$rsd->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda76+$rsd->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda77+$rsd->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda66+$tCelda67+$tCelda68+$tCelda69+$tCelda70+$tCelda71+$tCelda72+$tCelda73+$tCelda74+$tCelda75+$tCelda76+$tCelda77+$rsd->Fields(2)+$rsd->Fields(3)+$rsd->Fields(4)+$rsd->Fields(5)+$rsd->Fields(6)+$rsd->Fields(7)+$rsd->Fields(8)+$rsd->Fields(9)+$rsd->Fields(10)+$rsd->Fields(11)+$rsd->Fields(12)+$rsd->Fields(13)),2);?></td>  
  </tr>
  <tr>
    <?php $rss=$db->Execute("select * from reportefinal where idreporte=7") ?>
    <td class="KT_th">Total: Seguros</td>
    <td align="right"><?php echo number_format($tCelda78+$rss->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda79+$rss->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda80+$rss->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda81+$rss->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda82+$rss->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda83+$rss->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda84+$rss->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda85+$rss->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda86+$rss->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda87+$rss->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda88+$rss->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda89+$rss->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda90+$rss->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda79+$tCelda80+$tCelda81+$tCelda82+$tCelda83+$tCelda84+$tCelda85+$tCelda86+$tCelda87+$tCelda88+$tCelda89+$tCelda90+$rss->Fields(2)+$rss->Fields(3)+$rss->Fields(4)+$rss->Fields(5)+$rss->Fields(6)+$rss->Fields(7)+$rss->Fields(8)+$rss->Fields(9)+$rss->Fields(10)+$rss->Fields(11)+$rss->Fields(12)+$rss->Fields(13)),2);?></td> 
  </tr>  
  <tr>
  <?php $rsm=$db->Execute("select * from reportefinal where idreporte=8") ?>
  <?php $rso=$db->Execute("select * from reportefinal where idreporte=10") ?>
    <td class="KT_th">Total: Mant. y rep.</td>
    <td align="right"><?php echo number_format($tCelda91+$rsm->Fields(1),2);?></td>
    <td align="right"><?php echo number_format($tCelda92+$rsm->Fields(2),2);?></td>
    <td align="right"><?php echo number_format($tCelda93+$rsm->Fields(3),2);?></td>
    <td align="right"><?php echo number_format($tCelda94+$rsm->Fields(4),2);?></td>
    <td align="right"><?php echo number_format($tCelda95+$rsm->Fields(5),2);?></td>
    <td align="right"><?php echo number_format($tCelda96+$rsm->Fields(6),2);?></td>
    <td align="right"><?php echo number_format($tCelda97+$rsm->Fields(7),2);?></td>
    <td align="right"><?php echo number_format($tCelda98+$rsm->Fields(8),2);?></td>
    <td align="right"><?php echo number_format($tCelda99+$rsm->Fields(9),2);?></td>
    <td align="right"><?php echo number_format($tCelda100+$rsm->Fields(10),2);?></td>
    <td align="right"><?php echo number_format($tCelda101+$rsm->Fields(11),2);?></td>
    <td align="right"><?php echo number_format($tCelda102+$rsm->Fields(12),2);?></td>
    <td align="right"><?php echo number_format($tCelda103+$rsm->Fields(13),2);?></td>
    <td align="right"><?php echo number_format(($tCelda92+$tCelda93+$tCelda94+$tCelda95+$tCelda96+$tCelda97+$tCelda98+$tCelda99+$tCelda100+$tCelda101+$tCelda102+$tCelda103+$rsm->Fields(2)+$rsm->Fields(3)+$rsm->Fields(4)+$rsm->Fields(5)+$rsm->Fields(6)+$rsm->Fields(7)+$rsm->Fields(8)+$rsm->Fields(9)+$rsm->Fields(10)+$rsm->Fields(11)+$rsm->Fields(12)+$rsm->Fields(13)),2);?></td> 
  </tr>
  
  <tr>
  
    <td class="KT_th">Total : Otros</td>
    <td align="right"><?php echo number_format($tCelda117+$rso->Fields('costo'),2);?></td>
    <td align="right"><?php echo number_format($tCelda118+$rso->Fields('costo1'),2);?></td>
    <td align="right"><?php echo number_format($tCelda119+$rso->Fields('costo2'),2);?></td>
    <td align="right"><?php echo number_format($tCelda120+$rso->Fields('costo3'),2);?></td>
    <td align="right"><?php echo number_format($tCelda121+$rso->Fields('costo4'),2);?></td>
    <td align="right"><?php echo number_format($tCelda122+$rso->Fields('costo5'),2);?></td>
    <td align="right"><?php echo number_format($tCelda123+$rso->Fields('costo6'),2);?></td>
    <td align="right"><?php echo number_format($tCelda124+$rso->Fields('costo7'),2);?></td>
    <td align="right"><?php echo number_format($tCelda125+$rso->Fields('costo8'),2);?></td>
    <td align="right"><?php echo number_format($tCelda126+$rso->Fields('costo9'),2);?></td>
    <td align="right"><?php echo number_format($tCelda127+$rso->Fields('costo10'),2);?></td>
    <td align="right"><?php echo number_format($tCelda128+$rso->Fields('costo11'),2);?></td>	
    <td align="right"><?php echo number_format($tCelda129+$rso->Fields('costo12'),2);?></td>
    <td align="right"><?php echo number_format(($tCelda118+$tCelda119+$tCelda120+$tCelda121+$tCelda122+$tCelda123+$tCelda124+$tCelda125+$tCelda126+$tCelda127+$tCelda128+$tCelda129+$rso->Fields(2)+$rso->Fields(3)+$rso->Fields(4)+$rso->Fields(5)+$rso->Fields(6)+$rso->Fields(7)+$rso->Fields(8)+$rso->Fields(9)+$rso->Fields(10)+$rso->Fields(11)+$rso->Fields(12)+$rso->Fields(13)),2);?></td>     
  </tr>
  <tr>
    <td class="KT_th">Total : Total S/.</td>
    <td align="right"><?php echo number_format($tCelda130,2);?></td>
    <td align="right"><?php echo number_format($tCelda131,2);?></td>
    <td align="right"><?php echo number_format($tCelda132,2);?></td>
    <td align="right"><?php echo number_format($tCelda133,2);?></td>
    <td align="right"><?php echo number_format($tCelda134,2);?></td>
    <td align="right"><?php echo number_format($tCelda135,2);?></td>
    <td align="right"><?php echo number_format($tCelda136,2);?></td>
    <td align="right"><?php echo number_format($tCelda137,2);?></td>
    <td align="right"><?php echo number_format($tCelda138,2);?></td>
    <td align="right"><?php echo number_format($tCelda139,2);?></td>
    <td align="right"><?php echo number_format($tCelda140,2);?></td>
    <td align="right"><?php echo number_format($tCelda141,2);?></td>
    <td align="right"><?php echo number_format($tCelda142,2);?></td>
    <td align="right"><?php $ta=$tCelda131+$tCelda132+$tCelda133+$tCelda134+$tCelda135+$tCelda136+$tCelda137+$tCelda138+$tCelda139+$tCelda140+$tCelda141+$tCelda142;echo number_format($ta,2);?></td>    
  </tr>
  <tr>
    <td class="KT_th">Total : Horas Producci&oacute;n</td>
    <td align="right"><?php echo number_format($tCelda143,2);?></td>
    <td align="right"><?php echo number_format($tCelda144,2);?></td>
    <td align="right"><?php echo number_format($tCelda145,2);?></td>
    <td align="right"><?php echo number_format($tCelda146,2);?></td>
    <td align="right"><?php echo number_format($tCelda147,2);?></td>
    <td align="right"><?php echo number_format($tCelda148,2);?></td>
    <td align="right"><?php echo number_format($tCelda149,2);?></td>
    <td align="right"><?php echo number_format($tCelda150,2);?></td>
    <td align="right"><?php echo number_format($tCelda151,2);?></td>
    <td align="right"><?php echo number_format($tCelda152,2);?></td>
    <td align="right"><?php echo number_format($tCelda153,2);?></td>
    <td align="right"><?php echo number_format($tCelda154,2);?></td>
    <td align="right"><?php echo number_format($tCelda155,2);?></td>
    <td align="right"><?php $to=$tCelda144+$tCelda145+$tCelda146+$tCelda147+$tCelda148+$tCelda149+$tCelda150+$tCelda151+$tCelda152+$tCelda153+$tCelda154+$tCelda155; echo number_format($to,2);?></td>
  </tr>
<!--/////////////////////Absorcion Gastos Administrativos y Comerciales//////////////////////////-->
  <tr>
    <td colspan="15" class="selected_cal"><hr>    </td>
  </tr>
  <tr>
    <td colspan="15"  class="KT_th"> Absorci&oacute;n Gastos Administrativos y Comerciales</td>
  </tr>
  <tr>
    <td class="KT_th">&nbsp;</td>
    <td class="KT_th"><?php echo $mes12.'/'.$an12; ?></td>
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
    <td class="KT_th"> Totales </td>
  </tr>
  <tr>
    <td class="KT_th">Adm. y Comerciales:</td>
    <td align="right"><?php echo number_format($ad0=$adcoArray[12],2);?></td>
    <td align="right"><?php echo number_format($ad1=$adcoArray[11],2);?></td>
    <td align="right"><?php echo number_format($ad2=$adcoArray[10],2);?></td>
    <td align="right"><?php echo number_format($ad3=$adcoArray[9],2);?></td>
    <td align="right"><?php echo number_format($ad4=$adcoArray[8],2);?></td>
    <td align="right"><?php echo number_format($ad5=$adcoArray[7],2);?></td>
    <td align="right"><?php echo number_format($ad6=$adcoArray[6],2);?></td>
    <td align="right"><?php echo number_format($ad7=$adcoArray[5],2);?></td>
    <td align="right"><?php echo number_format($ad8=$adcoArray[4],2);?></td>
    <td align="right"><?php echo number_format($ad9=$adcoArray[3],2);?></td>
    <td align="right"><?php echo number_format($ad10=$adcoArray[2],2);?></td>
    <td align="right"><?php echo number_format($ad11=$adcoArray[1],2);?></td>
    <td align="right"><?php echo number_format($ad12=$adcoArray[0],2);?></td>
    <td align="right"><?php $tad=$ad1+$ad2+$ad3+$ad4+$ad5+$ad6+$ad7+$ad8+$ad9+$ad10+$ad11+$ad12; echo number_format($tad,2);?></td>
  </tr>
  <tr>
    <td class="KT_th">Total General: </td>
    <td align="right"><?php echo number_format($ad0=$adcoArray[12],2);?></td>
    <td align="right"><?php echo number_format($ad1=$adcoArray[11],2);?></td>
    <td align="right"><?php echo number_format($ad2=$adcoArray[10],2);?></td>
    <td align="right"><?php echo number_format($ad3=$adcoArray[9],2);?></td>
    <td align="right"><?php echo number_format($ad4=$adcoArray[8],2);?></td>
    <td align="right"><?php echo number_format($ad5=$adcoArray[7],2);?></td>
    <td align="right"><?php echo number_format($ad6=$adcoArray[6],2);?></td>
    <td align="right"><?php echo number_format($ad7=$adcoArray[5],2);?></td>
    <td align="right"><?php echo number_format($ad8=$adcoArray[4],2);?></td>
    <td align="right"><?php echo number_format($ad9=$adcoArray[3],2);?></td>
    <td align="right"><?php echo number_format($ad10=$adcoArray[2],2);?></td>
    <td align="right"><?php echo number_format($ad11=$adcoArray[1],2);?></td>
    <td align="right"><?php echo number_format($ad12=$adcoArray[0],2);?></td>
    <td align="right"><?php $tad=$ad1+$ad2+$ad3+$ad4+$ad5+$ad6+$ad7+$ad8+$ad9+$ad10+$ad11+$ad12; echo number_format($tad,2);?></td>
  </tr>
  <tr>
    <td class="KT_th">% sobre Prod. </td>
    <td align="right"><?php echo number_format($adcoArray[12]/$tCelda130,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[11]/$tCelda131,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[10]/$tCelda132,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[9]/$tCelda133,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[8]/$tCelda134,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[7]/$tCelda135,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[6]/$tCelda136,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[5]/$tCelda137,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[4]/$tCelda138,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[3]/$tCelda139,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[2]/$tCelda140,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[1]/$tCelda141,2)*100;?>%</td>
    <td align="right"><?php echo number_format($adcoArray[0]/$tCelda142,2)*100;?>%</td>
    <td align="right"><?php echo number_format($tad/$ta,2)*100;?>%</td>
  </tr>
</table>
</body>
</html>
<?php
$db->Close();

//}
?>