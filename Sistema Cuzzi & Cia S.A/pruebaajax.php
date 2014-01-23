<?
//Connection statement
require_once('Connections/cnx_cuzzicia.php');
//incluímos la clase ajax
require ('../xajax/xajax.inc.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax(); 

function procesar_formulario($form_entrada){
   $salida = "Gracias por enviarnos tus datos. Hemos procesado esto:<p>";
   $salida .= "Nombre: " . $form_entrada["nombre"];
   $salida .= "<br>Apellidos: " . $form_entrada["apellidos"];
   
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje","innerHTML",$salida);
   
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}
//registramos la función creada anteriormente al objeto xajax
$xajax->registerFunction("procesar_formulario");

//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();
?>
<html>
<head>
   <title>Enviar y procesar un formulario con Ajax y PHP</title>
   <?
   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
   $xajax->printJavascript("../xajax/");
   ?>
</head>

<body>
<h1>Recibir y procesar formulario con Ajax y PHP</h1>
<div id="mensaje">
<form id="formulario">
Nombre: <input type="text" name="nombre">
<br>
Apellidos: <input type="text" name="apellidos">
<br>
<input type="button" value="Enviar" onclick="xajax_procesar_formulario(xajax.getFormValues('formulario'))">
</form>
</div>

</body>
</html> 