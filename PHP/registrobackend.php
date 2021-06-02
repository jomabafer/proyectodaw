<?php
	require("clases/database.php");
	require("clases/usuario.php");
	header('Content-type: text/html; charset=utf-8');
	
	$credenciales = json_decode(stripslashes($_POST["credenciales"])); //Se decodifican los dos JSON recibidos.
	$usuarioCreado = json_decode(stripslashes($_POST["usuario"]));
	//echo $usuarioCreado->nombre."<br/>";
	//echo $usuarioCreado->rutaFoto."<br/>";
	
	$nuevoUsuario = new usuario(0, $usuarioCreado->nombre, $usuarioCreado->apellidos, $usuarioCreado->correoE, $usuarioCreado->fnacimiento, $usuarioCreado->poblacion, $usuarioCreado->tipo, $usuarioCreado->privacidad, "imagenes/fotosDePerfil/".$usuarioCreado->rutaFoto.".png");
	//Con los valores recibidos de usuarioCreado se crea un objeto de tipo usuario. Antes en privacidad ponía "publico" y en rutaFoto no había nada.
	
	
	
	$consulta = new database; //Se instancia un objeto de tipo database para ejecutar consultas en MySQL
	$creacionUsuario = false; //Se desea comprobar si se ha registrado un usuario correctamente, por eso se usa esta variable.
	
	try{
		$sql = 'INSERT INTO usuario (`nombre`, `apellidos`, `correoE`, `fnacimiento`, `poblacion`, `tipo`, `privacidad`, `rutafoto`) VALUES ("'.$nuevoUsuario->getNombre().'","'.$nuevoUsuario->getApellidos().'","'.$nuevoUsuario->getCorreoE().'","'.$nuevoUsuario->getFnacimiento().'","'.$nuevoUsuario->getPoblacion().'", "normal", "publico", "'.$nuevoUsuario->getRutaFoto().'" )';
		
		$creacionUsuario = $consulta->conn->query($sql);
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos (usuario).";
		?>
		<a id="registro" onclick=cargarFormulario("PHP/formulario.php") class="btn btn-primary">Volver</a>
		<?php
		die();
	} //En este bloque de código se ejecuta el código SQL para crear un nuevo registro en la tabla usuario. 
	
	$identificador = $credenciales[0];
	$clave1 = $credenciales[1]; //las credenciales se obtienen a través del otro vector.
	$clave2 = $credenciales[2];
	
	
	$creacionCredenciales = false; //También se comprueba que se creen las credenciales.
	if($clave1 == $clave2){ //Se comprueba que ambas credenciales sean iguales porque de lo contrario no se puede crear la cuenta.
		try{
			$sql = 'INSERT INTO CREDENCIALES (`identificador`, `clave`) VALUES ("'.$identificador.'","'.$clave1.'")';
			
			$creacionCredenciales = $consulta->conn->query($sql); //Debo manejar las excepciones aquí
			
		}catch(Exception $e){
			echo $e->getMessage();
			echo "Ha habido un error en la base de datos (credenciales). Probablemente hayas introducido una credencial en uso.";
			?>
			<a id="registro" onclick=cargarFormulario("PHP/formulario.php") class="btn btn-primary">Volver</a>
			<?php
			die();
		} //En este bloque de código se ejecuta el código SQL necesario para introducir un nuevo registro en la tabla credenciales.
	}else{
		echo "Las claves introducidas no coinciden </br>";
	}
	/*Se busca idUsuario por el correo electrónico ya que es único.*/
	$sql = 'select idusuario from usuario where correoE="'.  $nuevoUsuario->getCorreoE() .'"';
	
	$resultadobusqueda = $consulta->conn->query($sql);
	if ($resultadobusqueda){
		$idUsuario = $resultadobusqueda->fetch();
		
		
	}else{
		echo "Error seleccionando el id entre los usuarios por el correo.";
	}
	
	$relacion = false;
	try{
		$sql = 'INSERT INTO CREDENCIALESUSUARIO (`idUsuario`, `identificador`) VALUES ("'.$idUsuario[0].'","'.$identificador.'")';
		
		$relacion = $consulta->conn->query($sql);
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos (credencialesusuario)";
		?>
		<a id="registro" onclick=cargarFormulario("PHP/formulario.php") class="btn btn-primary">Volver</a>
		<?php
		die();
	} //En este bloque de código se introduce un registro en la tabla que relaciona un usuario con sus credenciales y si la ejecución ha funcionado se pone a true una variable informativa.
	
	if ($creacionUsuario && $creacionCredenciales && $relacion){ //Debo poner & doble para evitar que me notifique la imposibilidad de convertir un PDOStatement a entero.
		echo "Cuenta creada con éxito.";
	}else{
		echo "Ha habido un error.";
	} //Si las 3 variables de comprobación son correctas se informa del resultado exitoso en la creación de usuario y en caso contrario se informa de error.
	
	
?>
<br/>
<a id="registro" onclick=cargarFormulario("PHP/formulario.php") class="btn btn-primary">Volver</a>
<!--Para volver a la página principal se dispone de un botón que nos carga el formulario de inicio de sesión-->