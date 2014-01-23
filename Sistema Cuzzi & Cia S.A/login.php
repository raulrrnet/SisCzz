<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//Aditional Functions
require_once('includes/functions.inc.php');
if (isset($_GET['usu'])) {
$usu = $_GET['usu'];
}
// begin Recordset
$query_usuarios = "SELECT * FROM usuarios WHERE usuario='$usu' ORDER BY usuario ASC";
$usuarios = $cnx_cuzzicia->SelectLimit($query_usuarios) or die($cnx_cuzzicia->ErrorMsg());
$totalRows_usuarios = $usuarios->RecordCount();
// end Recordset
if($usu=='usuariop'){
    $ira = "loginp.php";
} elseif ($usu == 'usuariog') {
    $ira = "loging.php";
} elseif ($usu == 'usuarioc') {
    $ira = "loginc.php";
} elseif ($usu == 'usuariof') {
    $ira = "loginf.php";
} elseif ($usu == 'logistica') {
    $ira = "loginl.php";
}
// build the form action
$editFormAction = $_SERVER['PHP_SELF'] . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] : "");

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmlogin")) {
$idusu = $_POST['usuario'];
$passbd = $usuarios->Fields('password');
$pass = $_POST['pass'];
$passn2 = $_POST['passn2'];
if($passbd==$pass){
  $updateSQL = sprintf("UPDATE usuarios SET password='$passn2' WHERE idusuario=$idusu");

  $Result1 = $cnx_cuzzicia->Execute($updateSQL) or die($cnx_cuzzicia->ErrorMsg());
  $updateGoTo = $ira;
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?msg=PASSWORD CAMBIADO CORRECTAMENTE&";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  KT_redir($updateGoTo);
}else{echo "PASSWORD INCORRECTO";}
}
//PHP ADODB document - made with PHAkt 3.7.1
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script language="javascript">
<!--
function Validar(){
ps1 = document.form1.passn1.value;
ps2 = document.form1.passn2.value;
if(ps1==ps2){
    return true
    }else{
	alert("clave nueva no coincide");
	return false
	}
}
//-->
</script>
</head>

<body>
<table align="center" cellpadding="10" cellspacing="5" class="KT_tngtable">
<tr class="KT_buttons">
  <td>CAMBIO USUARIO Y PASSWORD PARA ACCESO AL  SISTEMA</td>
</tr>

<tr>
<td align="center"><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="return Validar();">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Cambio de Clave:</td>
    </tr>
    <tr>
      <td class="KT_th">Usuario:</td>
      <td><label>
        <select name="usuario" size="1" id="usuario" onChange="MM_jumpMenu('parent',this,0)">
          <?php
  while(!$usuarios->EOF){
?>
          <option value="<?php echo $usuarios->Fields('idusuario')?>"><?php echo $usuarios->Fields('usuario')?></option>
          <?php
    $usuarios->MoveNext();
  }
  $usuarios->MoveFirst();
?>
              </select>
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Clave:</td>
      <td><label>
        <input name="pass" type="password" id="pass">
      </label></td>
    </tr>
    <tr>
      <td colspan="2" class="KT_th"><hr></td>
      </tr>
    <tr>
      <td class="KT_th">Clave Nueva:</td>
      <td><label>
        <input name="passn1" type="password" id="passn1">
      </label></td>
    </tr>
    
    <tr>
      <td class="KT_th">Repetir Clave:</td>
      <td><label>
        <input name="passn2" type="password" id="passn2">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="login" id="login" value="Cambiar" />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frmlogin">
</form></td>
</tr>
</table>
</body>
</html>
<?php
$usuarios->Close();
?>