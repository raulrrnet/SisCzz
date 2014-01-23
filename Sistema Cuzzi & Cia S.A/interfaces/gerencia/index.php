<?php
//Aditional Functions
require_once('../../includes/functions.inc.php');

// *** Restrict Access To Page: Grant or deny access to this page
$KT_authorizedUsers=" ";
$KT_authFailedURL="../../accesdene.php";
$KT_grantAccess=0;
@session_start();
if (isset($_SESSION["KT_Username"])) {
  if (true || !(isset($_SESSION["KT_userAuth"])) || $_SESSION["KT_userAuth"]=="" || KT_strpos($KT_authorizedUsers, $_SESSION["KT_userAuth"])) {
    $KT_grantAccess = 1;
  }
}
if (!$KT_grantAccess) {
  $KT_qsChar = "?";
  if (strpos($KT_authFailedURL, "?")) $KT_qsChar = "&";
  $KT_referrer = $_SERVER["REQUEST_URI"];
  $KT_authFailedURL = $KT_authFailedURL . $KT_qsChar . "accessdenied=" . urlencode($KT_referrer);
  KT_redir($KT_authFailedURL);
}

//PHP ADODB document - made with PHAkt 3.7.1
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema Cuzzi - Modulo Gerencia</title>
</head>

<frameset rows="99,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="cabece.html" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frameset rows="*" cols="180,*" framespacing="0" frameborder="no" border="0">
    <frame src="menus.html" name="leftFrame" scrolling="No" noresize="noresize" id="leftFrame" title="leftFrame" />
    <frame src="conte.html" name="mainFrame" id="mainFrame" title="mainFrame" />
  </frameset>
</frameset>
<noframes><body>
</body>
</noframes>
</html>