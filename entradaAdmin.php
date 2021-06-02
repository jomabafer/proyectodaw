<!--<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">

	<head>
		<title>Acceso</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>-->
		<?php
			echo "ZONA DE ADMINISTRACIÓN. <br/>";
			require("database.php");
			header('Content-type: text/html; charset=utf-8');
			if (!empty($_POST['clave'])& !empty($_POST['usuario'])){
				/*Se comprueba que los dos campos están rellenos. He usado
				!empty() en vez de isset ya que con isset() si no introducía nada,
				seguía dando un resultado verdadero.*/
				/*<borrar o comentar después>*/
				//echo "usuario: ". $_POST['usuario'];
				//echo "clave: ". $_POST['clave'];
				/*</borrar o comentar después>*/
				$consulta = new database;
				$sql = 'select * from credenciales where identificador = "'.  $_POST['usuario'] .'"';
				$resultadobusqueda = $consulta->conn->query($sql);
				if ($resultadobusqueda){
					$existeUsuario = $resultadobusqueda->fetch();
					if($existeUsuario){
						$sql = 'select idusuario from credencialesusuario where identificador="'.  $_POST['usuario'] .'"';
						$resultadobusqueda = $consulta->conn->query($sql);
						if ($resultadobusqueda){
							$idUsuario = $resultadobusqueda->fetch();
							//echo $idUsuario[0];
							$sql = 'select tipo from usuario where idusuario='.  $idUsuario[0];
							$resultadobusqueda = $consulta->conn->query($sql);
							$tipo = $resultadobusqueda->fetch();
							//echo $tipo[0];
							if($tipo[0]=='admin'){
								$sql = 'select * from credenciales where identificador = "'.  $_POST['usuario'] .'" and clave = "'. $_POST['clave'].'"';
								$resultadobusqueda = $consulta->conn->query($sql);
								if ($resultadobusqueda){
									$usuario = $resultadobusqueda->fetch();
									if ($usuario != null) {
										//Se muestra un mensaje de éxito si las credenciales son correctas.
										echo "Conexión correcta";
									}else{
										echo "Datos incorrectos. <br/>";
										echo '<a href="entradaAdmin.html">Volver</a>';
									}
								}else{
									/*Se muestra un mensaje de error si las credenciales no son correctas
									y se da la opción de volver al formulario*/
									//echo "Datos incorrectos. <br/>";
									echo "Error";
									echo '<a href="formulario.html">Volver</a>';
								}
							}else{
								echo "No sé cómo has llegado hasta aquí, pero aquí sólo puedes acceder si eres administrador.<br/>";
								echo '<a href="index.html">Volver</a>';
							}							
						}

					}else {
						echo "No existe ningún usuario con ese nombre.<br/>";
						echo '<a href="index.html">Volver</a>';
					}
				}else {
					echo "Error";
					echo '<a href="index.html">Volver</a>';
				}
			}else{
				/*Se muestra un mensaje de error si falta algún campo y se da la
				opción de volver al formulario*/
				echo "Debes reellenar todos los campos.<br/>";
				echo '<a href="formulario.html">Volver</a>';
			}
			
		?>
	<!--</body>
</html>-->