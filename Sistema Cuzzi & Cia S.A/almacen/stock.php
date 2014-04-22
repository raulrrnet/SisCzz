<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('../includes/functions.inc.php');

// begin Recordset
$query_almacen = "select idorden,sum(packs),undpack from detingreal where idorden=37196 group by idorden,undpack";
$almacen = $cnx_cuzzicia->SelectLimit($query_almacen) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_almacen = $almacen->RecordCount();
// end Recordset
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<table width="200" border="0">
  <tr>
    <td>Orden</td>
    <td>Cajas</td>
    <td>Und./Caja</td>
    <td>Cantidad</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  $i=0;
  while (!$almacen->EOF) { 
  $val = 'text$i';
  ?>
<form id="<?php echo 'form'.$i;?>" name="<?php echo 'form'.$i;?>" method="post" action="">
    <tr>
      <td><?php echo $almacen->Fields('idorden'); ?></td>
      <td><?php echo $almacen->Fields('sum'); ?></td>
      <td><?php echo $almacen->Fields('undpack'); ?></td>
      <td>
          <input type=text name="<?php echo 'text'.$i;?>">      </td>
      <td>
        <input type="submit" name="<?php echo 'btn'.$i;?>" value="Enviar">
      </td>
    </tr>
</form>
    <?php
	$i++;
    $almacen->MoveNext(); 
  }
?>
</table>
</body>
</html>
<?php
$almacen->Close();
?>
