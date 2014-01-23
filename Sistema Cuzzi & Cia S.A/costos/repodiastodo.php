<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$fecfin = date('Y/m/d');
if (isset($_POST['fecfin'])) {
  $fecfin = $_POST['fecfin'];
}
$fecfecha = strtotime($fecfin); 
$anio = date("Y",$fecfecha);
$mes = date("m",$fecfecha);
$fecini = $anio."/".$mes."/01";
if (isset($_POST['fecini'])) {
  $fecini = $_POST['fecini'];
}
$query_cnkardex = sprintf("Select nombre,count(*) as trabajo from v_calen where fecha between '$fecini' and '$fecfin' and ttiempo<>0 group by nombre");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
$query_debio = sprintf("select count(*) as tdebio from detcalend where fecha between '$fecini' and '$fecfin' and tiempo<>0");
$cndebio = $cnx_cuzzicia->SelectLimit($query_debio) or die($cnx_cuzzicia->ErrorMsg());

//PHP ADODB document - made with PHAkt 3.6.0
?>
<html xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<title>Informe Total-Horas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
<!--
.Estilo8 {font-size: 14px; font-weight: bold; }
-->
</style>
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
<form action="repodiastodo.php" method="post">
  <table border="0" align="center" cellpadding="0" cellspacing="0" class="KT_tngtable">
    <TR>
      <TD>Inicio de Mes </TD>
      <TD><input name="fecini" id="fecini" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no"></TD>
    </TR>
    <TR>
      <TD>Fin de Mes</TD>
      <TD><label>
        <input name="fecfin" id="fecfin" value="" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="no">
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
    <td class="KT_th">FECHA :</td>
    <td colspan="3">DEL <?php echo $fecini;?> AL <?php echo $fecfin;?></td>
  </tr>
  <tr>
    <td class="KT_th">NOMBRE</td>
    <td class="KT_th">DEBIO</td>
    <td class="KT_th">TRABAJO</td>
    <td class="KT_th">DIFERENCIA </td>
  </tr>
  <?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td><?php echo $cnkardex->Fields('nombre'); ?></td>
    <td align="right"><?php echo $cndebio->Fields('tdebio');?>d.</td>
    <td align="right"><?php echo $cnkardex->Fields('trabajo');?>d.</td>
    <td align="right"><?php $difer = $cnkardex->Fields('trabajo')-$cndebio->Fields('tdebio');
							if ($difer<0){
		echo $difer.'d.';
		}else{echo "-";}?></td>
  </tr>
  <?php
    $cnkardex->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$cnkardex->Close();
?>