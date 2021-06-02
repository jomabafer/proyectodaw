<?php
	require("clases/database.php");
	require("clases/usuario.php");
	header('Content-type: text/html; charset=utf-8');
		
	session_start();
	if(empty($_SESSION["usuario"])&empty($_SESSION["clave"])){ //Acciones si no se han introducido todos los campos
		$usuario=$_POST["usuario"]; 
		$clave=$_POST["clave"];
		if (!empty($clave)& !empty($usuario)){		
			$_SESSION['usuario']=$usuario;
			$_SESSION['clave']=$clave;
								
		}else{
			/*Se muestra un mensaje de error si falta algún campo y se da la
			opción de volver al formulario*/
			echo "Debes reellenar todos los campos.<br/>";
			//echo '<a id="registro" onclick=cargarFormulario("formulario.php") class="btn btn-primary">Volver</a>';
			echo '<a id="registro" href="cerrarSesion.php" class="btn btn-primary">Volver</a>';
		}
	}
	if(!empty($_SESSION["usuario"])&!empty($_SESSION["clave"])){ //Si se han introducido todos los campos.
		$sesion = array($_SESSION["usuario"], $_SESSION["clave"]);
		$consulta = new database;
			$sql = 'select * from credenciales where identificador = "'.  $_SESSION["usuario"] .'"'; //Comprobación de la existencia de credenciales con ese usuario
			
		try{
			$resultadobusqueda = $consulta->conn->query($sql);
			
			if ($resultadobusqueda){
				$existeUsuario = $resultadobusqueda->fetch();
				if($existeUsuario){ //Acciones que se toman si hay un usuario con el identificador introducido

					$sql = 'select * from credenciales where identificador = "'.  $_SESSION["usuario"] .'" and clave = "'. $_SESSION["clave"].'"'; //Se comprueba que la clave corresponde al usuario introducido.
					try{
						$resultadobusqueda = $consulta->conn->query($sql);
						if ($resultadobusqueda){ //Si la clave es correcta.
							$usuarioEncontrado = $resultadobusqueda->fetch();
							if ($usuarioEncontrado != null) {
								//Se muestra un mensaje de éxito si las credenciales son correctas.								
								
								$sql = 'select idusuario from credencialesusuario where identificador="'.  $usuarioEncontrado[0] .'"'; //Se busca el idusuario al que corresponden esas credenciales.
								
								$resultadobusqueda = $consulta->conn->query($sql);
								if ($resultadobusqueda){
									$credencialUsuario = $resultadobusqueda->fetch();
									$idUsuario = $credencialUsuario[0];
									//echo "Id usuario: ".$idUsuario."<br/>";
									$sql = 'select * from usuario where idusuario="'.  $idUsuario .'"'; //Con el idUsuario que se ha obtenido antes se rescatan los datos del usuario que se conecta.
									$resultadobusqueda = $consulta->conn->query($sql);
									try{
										if($resultadobusqueda){
											$datosUsuario = $resultadobusqueda->fetch();
											/*echo "Id usuario: ".$datosUsuario[0]."<br/>";
											echo "Nombre del usuario: ".$datosUsuario[1]."<br/>";
											echo "Apellidos: ".$datosUsuario[2]."<br/>";
											echo "Correo: ".$datosUsuario[3]."<br/>";
											echo "Fecha de nacimiento: ".$datosUsuario[4]."<br/>";
											echo "Población: ".$datosUsuario[5]."<br/>";
											echo "Tipo: ".$datosUsuario[6]."<br/>";
											echo "Privacidad: ".$datosUsuario[7]."<br/>";
											echo "Ruta: ".$datosUsuario[8]."<br/>";*/
											$nuevousuario = new usuario($datosUsuario[0],$datosUsuario[1], $datosUsuario[2], $datosUsuario[3], $datosUsuario[4], $datosUsuario[5], $datosUsuario[6], $datosUsuario[7], $datosUsuario[8]);
											$usuarioYsesion = array($sesion,$nuevousuario);
											$usuarioYsesionJson = json_encode($usuarioYsesion);
											$usuarioJson = json_encode($nuevousuario); 
											//echo $usuarioJson; //Esto es lo que se va a pasar al método de AJAX, para mostrar los datos que interesen del usuario y con el Id se rescatarán las publicaciones llamando a un método creado para ello.
											echo $usuarioYsesionJson;
										}
									}catch(Exception $error){
										echo $error;
									}
								}	
							}else{
								echo "Datos incorrectos. <br/>";
								echo '<a id="registro" href="cerrarSesion.php" class="btn btn-primary">Volver</a>';

							}
						}else{
							/*Se muestra un mensaje de error si las credenciales no son correctas
							y se da la opción de volver al formulario*/
							
							echo "Error";
							
							echo '<a id="registro" href="cerrarSesion.php" class="btn btn-primary">Volver</a>';
						}
					}catch(Exception $error){
						echo $error;
					}
				}else { //Si no existe un usuario con la credencial introducida.
					echo "No existe ningún usuario con ese nombre.<br/>";
					echo '<a id="registro" href="cerrarSesion.php" class="btn btn-primary">Volver</a>';
					
				}
				
			}else { //Si no se ejecuta la consulta de forma correcta.
				echo "Error";
				echo '<a id="registro" href="cerrarSesion.php" class="btn btn-primary">Volver</a>';
			}

		}catch(Exception $error){
			echo $error;
		}
	}
?>