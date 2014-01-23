<?php
//Connection statement
require_once('Connections/cnx_cuzzicia.php');

//Aditional Functions
require_once('includes/functions.inc.php');

// *** Start the session
session_start();
// *** Validate request to log in to this site.
$KT_LoginAction = $_SERVER["REQUEST_URI"];
if (isset($_POST["user"])) {
  $KT_valUsername = $_POST['user'];
  $KT_fldUserAuthorization = "";
  $KT_redirectLoginSuccess = "interfaces/logistica/";
  $KT_redirectLoginFailed = "loginfailed.php";
  $KT_rsUser_Source = "SELECT usuario, password, cargo ";
  if ($KT_fldUserAuthorization != "") $KT_rsUser_Source .= "," . $KT_fldUserAuthorization;
  $KT_rsUser_Source .= " FROM usuarios WHERE usuario=" . GetSQLValueString($KT_valUsername, "text") . " AND password=" . GetSQLValueString($_POST['pass'], "text"). " AND (cargo='logistica' OR cargo='admin' OR cargo='gerencia')";
  $KT_rsUser=$cnx_cuzzicia->Execute($KT_rsUser_Source) or DIE($cnx_cuzzicia->ErrorMsg());
  if (!$KT_rsUser->EOF) {
    // username and password match - this is a valid user
    $KT_Username=$KT_valUsername;
		
    KT_session_register("KT_Username");
    if ($KT_fldUserAuthorization != "") {
      $KT_userAuth=$KT_rsUser->Fields($KT_fldUserAuthorization);
    } else {
      $KT_userAuth="";
    }
		
    KT_session_register("KT_userAuth");
    if (isset($_GET['accessdenied']) && true) {
      $KT_redirectLoginSuccess = $_GET['accessdenied'];
    }
    $KT_rsUser->Close();
		
    KT_session_register("kt_login_failed");
    $kt_login_failed = false;
    // Add code here if you want to do something if login succeded

KT_redir($KT_redirectLoginSuccess);
  }
  $KT_rsUser->Close();
  $kt_login_failed = true;
  
  KT_session_register("kt_login_failed");
  // Add code here if you want to do something if login fails

KT_redir($KT_redirectLoginFailed);
}

//PHP ADODB document - made with PHAkt 3.7.1
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<table align="center" cellpadding="10" cellspacing="5" class="KT_tngtable">
<tr class="KT_buttons">
  <td>VALIDE SU USUARIO Y PASSWORD PARA ACCCEDER AL  SISTEMA</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center"><form ACTION="<?php echo $KT_LoginAction?>" method="POST" name="frmlogin" id="form1">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td colspan="2" class="KT_th">Iniciar Sesion</td>
    </tr>
    <tr>
      <td class="KT_th">Username:</td>
      <td><label>
        <input name="user" type="text" id="user">
      </label></td>
    </tr>
    <tr>
      <td class="KT_th">Password</td>
      <td><label>
        <input name="pass" type="password" id="pass">
      </label></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="login" id="login" value="Iniciar" />      </td>
    </tr>
  </table>
  <a href="login.php?usu=logistica">Cambiar Password</a>
</form></td>
</tr>
</table>
</body>
</html>