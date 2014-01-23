<?php
// Array definitions
  $tNG_login_config = array();
  $tNG_login_config_session = array();
  $tNG_login_config_redirect_success  = array();
  $tNG_login_config_redirect_failed  = array();
  $tNG_login_config_redirect_success = array();
  $tNG_login_config_redirect_failed = array();

// Start Variable definitions
  $tNG_debug_mode = "DEVELOPMENT";
  $tNG_debug_log_type = "";
  $tNG_debug_email_to = "you@yoursite.com";
  $tNG_debug_email_subject = "[BUG] The site went down";
  $tNG_debug_email_from = "webserver@yoursite.com";
  $tNG_email_host = "localhost";
  $tNG_email_user = "";
  $tNG_email_port = "25";
  $tNG_email_password = "";
  $tNG_email_defaultFrom = "nobody@nobody.com";
  $tNG_login_config["connection"] = "cnx_cuzzicia";
  $tNG_login_config["table"] = "usuarios";
  $tNG_login_config["pk_field"] = "idusuario";
  $tNG_login_config["pk_type"] = "NUMERIC_TYPE";
  $tNG_login_config["email_field"] = "";
  $tNG_login_config["user_field"] = "usuario";
  $tNG_login_config["password_field"] = "password";
  $tNG_login_config["level_field"] = "";
  $tNG_login_config["level_type"] = "STRING_TYPE";
  $tNG_login_config["randomkey_field"] = "";
  $tNG_login_config["activation_field"] = "";
  $tNG_login_config["password_encrypt"] = "false";
  $tNG_login_config["autologin_expires"] = "30";
  $tNG_login_config["redirect_failed"] = "loginfailed.php";
  $tNG_login_config["redirect_success"] = "interfaces/gerencia/index.php";
  $tNG_login_config["login_page"] = "login.php";
  $tNG_login_config_session["kt_login_id"] = "idusuario";
  $tNG_login_config_session["kt_login_user"] = "usuario";
  $tNG_login_config_session["kt_password"] = "password";
// End Variable definitions
?>