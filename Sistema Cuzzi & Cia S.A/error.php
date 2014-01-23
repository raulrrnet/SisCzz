<?php
if (isset($_GET['idmovi'])) {
  $idmovi = $_GET['idmovi'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.Estilo1 {font-size: x-large}
.Estilo2 {font-size: x-large; color: #FF6600; }
.Estilo3 {color: #FF3300}
-->
</style>
</head>

<body>
<p class="Estilo2 Estilo3">No se puedo realizar la operacion: <?php echo $idmovi; ?></p>
<p class="Estilo1">	- Salida mayor a los ingresos de material.</p>
<iframe  name="idiframe" id="idiframe" width="100%" height="150" frameborder="0" src="menug.php"></iframe>
</body>
</html>
