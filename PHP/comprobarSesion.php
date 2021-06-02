<?php
session_start(); //Se inicia sesión PHP, que no es la misma que la de la aplicación.

if(!empty($_SESSION['usuario'])&!empty($_SESSION['clave'])){ //Se comprueba si se han introducido las credenciales
	$sesionIniciada=true; 
	$infoSesion[]=$sesionIniciada;
	$infoSesion[]=$_SESSION['usuario'];
	$infoSesion[]=$_SESSION['clave'];
	/*En caso afirmativo se indica que la sesión está iniciada fijando la variable sesionIniciada a true
	y además se rescatan la variables que se han introducido al iniciar sesión, todo ello guardado en un
	vector*/
	
}else{
	
	$sesionIniciada=false;
	$infoSesion[]=$sesionIniciada;
	/*En caso contrario se fija la variable sesionIniciada a false y se almacena en el mismo vector*/
}
$jsonInformacion = json_encode($infoSesion); //Esta información la recibe AJAX en formato JSON
echo $jsonInformacion; //Se imprime el JSON creado para que Javascript pueda procesarlo despuéss.
?>