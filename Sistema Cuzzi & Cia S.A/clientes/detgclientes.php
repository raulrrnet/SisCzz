<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');
$grupo = '';
if (isset($_GET['grupo'])) {
  $grupo = $_GET['grupo'];
}
// begin Recordset
$idgclien = '1';
if (isset($_GET['idgclien'])) {
  $idgclien = $_GET['idgclien'];
}
$query_detgclientes = "SELECT * FROM clientes WHERE idgcliente = $idgclien ORDER BY cliente";
$detgclientes = $cnx_cuzzicia->SelectLimit($query_detgclientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_detgclientes = $detgclientes->RecordCount();
// end Recordset

//PHP ADODB document - made with PHAkt 3.7.1
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
  <tr>
    <td colspan="2" class="MXW_ICT_visual_alert_div">Grupo <?php echo $grupo;?></td>
  </tr>
  <tr>
    <td class="nav_cal">CLIENTES:</td>
    <td class="nav_cal">&nbsp;</td>
  </tr>
  <?php
  while (!$detgclientes->EOF) { 
?>
    <tr>
      
      <td>:<?php echo $detgclientes->Fields('cliente'); ?></td>
      <td><a href="../clientes/asignaclien.php?idclien=<?php echo $detgclientes->Fields('idcliente');?>&idgclien=<?php echo $idgclien;?>">Cambiar</a></td>
    </tr>
    <?php
    $detgclientes->MoveNext(); 
  }
?>
  
  <tr class="KT_buttons">
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$detgclientes->Close();
?>
