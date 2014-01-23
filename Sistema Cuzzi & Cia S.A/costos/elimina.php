<?php
//Connection statement
require_once('../Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('../includes/functions.inc.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
if (isset($_GET['tabla'])) {
  $tabla = $_GET['tabla'];
}
if (isset($_GET['idtabla'])) {
  $idtabla = $_GET['idtabla'];
}
if (isset($_GET['goto'])) {
  $goto = $_GET['goto'];
}
  $eliminaSQL = sprintf("DELETE FROM $tabla WHERE $idtabla=$id");
  $Result1 = $cnx_cuzzicia->Execute($eliminaSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = "$goto";

  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);

//PHP ADODB document - made with PHAkt 3.7.1
?>