<script language="JavaScript"> 
function redimensiona() 
{ 
resizeTo(400,400) 
iz=(screen.width-document.body.clientWidth) / 2;
de=(screen.height-document.body.clientHeight) / 2;
moveTo(iz,de);
} 
window.onload=redimensiona 
window.onresize=redimensiona 
</script>
<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

$fecha = '2001/01/01';
if (isset($_POST['fecha'])) {
  $fecha = $_POST['fecha'];
}
// begin Recordset
$query_cnkardex = sprintf("select idoperario,nombre from operario where estado='A'
and idoperario <> all (SELECT idoperario FROM v_informes WHERE fecha='$fecha') order by nombre");
$cnkardex = $cnx_cuzzicia->SelectLimit($query_cnkardex) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_cnkardex = $cnkardex->RecordCount();
// end Recordset
?>
<html>
<head>
</head>
<body>
<table width="50%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><h3><font color="#990000">Operarios Faltantes dia <?php echo $fecha;?></font></h3></td>
  </tr>
<?php
  while (!$cnkardex->EOF) { 
?>
  <tr>
    <td height="24"><?php echo $cnkardex->Fields('nombre'); ?>    </td>
  </tr>
<?php
  $cnkardex->MoveNext(); 
 }
?>
</table>
</body>
</html>
