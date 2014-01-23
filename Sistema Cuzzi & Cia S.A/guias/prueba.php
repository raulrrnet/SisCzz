<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

 $pgsql_conn = pg_connect("host=192.168.1.55 port=5432 dbname=cuzzi user=postgres password=cd231285");
 $results = pg_query($pgsql_conn, "SELECT 5+5,* FROM clientes ORDER BY cliente");
 $totalCols_ord = pg_num_fields($results);

// begin Recordset
$query_clientes = "SELECT 5+5,* FROM clientes ORDER BY cliente";
$clientes = $cnx_cuzzicia->SelectLimit($query_clientes) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_clientes = $clientes->RecordCount();
// end Recordset
?>
<?php //PHP ADODB document - made with PHAkt 3.7.1?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table border="1">
<tr>
<?php
  $i = pg_num_fields($results);
  for ($j = 0; $j < $i; $j++) {
	echo "<td>";
      echo pg_field_name($results, $j);
	echo "</td>";
  }
?>
</tr>
<?php
$tuple = 0;
 while ($tuple<=$totalRows_clientes) {
        echo "Nombre= ".pg_fetch_array($results,$tuple)." - ";
      $tuple++;
    }
while ($reg = pg_fetch_array($results, null, PGSQL_NUM)) {
echo "<tr>";
    for($y=0;$y<$totalCols_ord;$y++){
	echo  "<td>";
	echo $reg[$y];
	echo  "</td>";
	}
	for($i = 0;$i<$totalCols_ord;$i++) {
	$var[$i][] = $reg[$i];
	}
echo "</tr>";
}
?>

</table>
</body>
</html>
<?php
$clientes->Close();
?>
