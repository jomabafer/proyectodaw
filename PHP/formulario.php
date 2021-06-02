<?php
/*if(isset($_SESSION)){
	echo "Hay sesión.<br/>";
session_start();
	
	header('Location: conexion.php');
	
}*/
session_start();
if(!empty($_SESSION['usuario'])&!empty($_SESSION['clave'])){
	header('Location: conexion.php'); //Si se ha iniciado sesión se redirige a la página conexion.php
	
}
?>

				
	<form id="formulario" method='POST'>
		
		<span><label for='usuario'>Nombre de usuario:</label>
		<input id="usuario" name='usuario' type='text'/></span> <br/>
		<span><label for='clave'>Contraseña:</label> 
		<input id="clave" name='clave' type='password'/></span> <br/>
		
		<button  onclick=iniciarSesion("PHP/conexion.php") class="btn btn-primary">Enviar</button>
		
	</form>
	<div class="dropdown-divider"></div>
	<a id="registro" onclick=cargarFormulario("PHP/registro.php") type="button" class="btn btn-primary">¿No tienes cuenta? Regístrate.</a>
	<!--<a id="registro" onclick=modal("PHP/registro.php") type="button" class="btn btn-primary">¿No tienes cuenta? Regístrate.</a>-->

				
				