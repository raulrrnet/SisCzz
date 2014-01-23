<?
//incluímos la clase ajax
require ('../xajax/xajax.inc.php');

//instanciamos el objeto de la clase xajax
$xajax = new xajax(); 

function procesar_formulario($form_entrada){
	
	//Connection statement
require_once('Connections/cnx_cuzzicia.php');

	  $insertSQL = "insert into pruebas (text) values ('" . $form_entrada["nombre"] . "')";

	if ($cnx_cuzzicia->Execute($insertSQL)){
      $salida = "Insertado correctamente";
   }else{
      $salida = "No se ha insertado. Este es el error: " . die($cnx_cuzzicia->ErrorMsg());
   }


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
<form method="post" name="formulario" id="formulario">
Nombre de país: 
<input type="text" name="nombre">
<br>
<input type="button" value="Enviar" onclick="xajax_procesar_formulario(xajax.getFormValues('formulario'))">
</form>
</div>

</body>
</html>