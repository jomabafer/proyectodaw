		<?php
			require("database.php");
			require("usuario.php");
			header('Content-type: text/html; charset=utf-8');
			/*for($i=0; $i<sizeof(json_decode(stripslashes($_POST["todo"])))-1; $i++){ 
				echo json_decode(stripslashes($_POST["todo"]))[$i]."</br>";
			}*/
			/* Lo voy a hacer con un método específico, así que este bloque de código
			que es para un método general, ya no sirve
			$datosUsuario = json_decode(stripslashes($_POST["todo"]));
			$usuario=$datosUsuario[0];
			$clave=$datosUsuario[1];
			*/
			if(!isset($_SESSION)){ 
				echo "Sesión no iniciada <br/>";
				
			}else{
			/*echo "Sesion usuario". $_SESSION["usuario"];
            session_start();
			echo "Sesion usuario". $_SESSION["usuario"];
			echo 'Sesion clave'.$_SESSION["clave"];
            if(($_SESSION["usuario"]==null||$_SESSION["usuario"]=='')&($_SESSION["clave"]==null||$_SESSION["clave"]=='')){*/
				echo "Ha entrado donde no hay sesion";
				$usuario=$_POST["usuario"]; //Aquí hay que usar variables de sesión.
				$clave=$_POST["clave"];
				if (empty($clave)& empty($usuario)){
					/*Se muestra un mensaje de error si falta algún campo y se da la
					opción de volver al formulario*/
					echo "Debes reellenar todos los campos.<br/>";
					//echo '<a href="formulario.php">Volver</a>';
					echo '<a id="registro" onclick=cargarFormulario("formulario.php") class="btn btn-primary">Volver</a>';
				}else{
					session_start();
					$_SESSION["usuario"]=$usuario;
					$_SESSION["clave"]=$clave;
				}
				echo $_SESSION["usuario"];
			}if(!($_SESSION["usuario"]==null||$_SESSION["usuario"]=='')&($_SESSION["clave"]==null||$_SESSION["clave"]=='')){
				//echo "hola<br/>"; 
				/*Se comprueba que los dos campos están rellenos. He usado
				!empty() en vez de isset ya que con isset() si no introducía nada,
				seguía dando un resultado verdadero.*/
				/*<borrar o comentar después>*/
				//echo "usuario: ". $usuario."</br>";
				//echo "clave: ". $clave."</br>";
				/*</borrar o comentar después>*/
				$usuario=$_SESSION["usuario"];
				$clave=$_SESSION["clave"];
				//echo $usuario." ".$clave."<br/>";
				/*¿Me dijo que simplificara esto? Si es así, ¿cómo compruebo que existe el usuario?*/
				$consulta = new database;
				$sql = 'select * from credenciales where identificador = "'.  $usuario .'"';
				$resultadobusqueda = $consulta->conn->query($sql);
				//echo $sql;
				if ($resultadobusqueda){
					$existeUsuario = $resultadobusqueda->fetch();
					if($existeUsuario){
						$sql = 'select * from credenciales where identificador = "'.  $usuario .'" and clave = "'. $clave.'"';
						$resultadobusqueda = $consulta->conn->query($sql);
						if ($resultadobusqueda){
							$usuarioEncontrado = $resultadobusqueda->fetch();
							if ($usuarioEncontrado != null) {
								//Se muestra un mensaje de éxito si las credenciales son correctas.
								//echo "Conexión correcta. <br/>"; /*Esto está temporalmente comentado. Aquí -o mandándolo al javascript- sería bueno* saludar con el nombre*/
								/*echo "<div id='divAnyadir'>
										<a id='botonAnyadir' onclick=cargar('#divAnyadir','nuevaPublicacion.php') class='btn btn-primary'>Nueva Publicación</a>
									</div>"; Esto está temporalmente comentado*/
								
								/*¿Llamo a otro php para rescatar las publicaciones?
								Para rescatar las publicaciones hay que:
									-Buscar amistades  del presente usuario a través de la tabla correspondiente.
									-Una vez conocidos los idUsuario de las diferentes amistades, buscar publicaciones
									de cada usuario a través de la tabla correspondiente. ¿Cómo ordeno TODAS las 
									publicaciones según la hora y fecha de publicación? ¿Order by date? Para esto
									será necesario que el idUsuario se encuentre de entre los idUsuario correspondientes a
									la tabla de amistades.
									Puedo usar objetos tanto en php como en javascript para rescatar la publicación de la base
									de datos, enviarla al navegador y mostrarla.
									*/
								
								
								
								$sql = 'select idusuario from credencialesusuario where identificador="'.  $usuarioEncontrado[0] .'"'; //Antes de pasar los datos mediante JSON convertido a vector no era necesario usar ningún índice, ¿por qué?
								//echo $sql;
								$resultadobusqueda = $consulta->conn->query($sql);
								if ($resultadobusqueda){
									$credencialUsuario = $resultadobusqueda->fetch();
									$idUsuario = $credencialUsuario[0];
									/*$sql = 'select idAmigoAsociado from amistad where idAmigo = '.$idUsuario;
									$resultadobusqueda = $consulta->conn->query($sql);
									if($resultadobusqueda){
										for($i=0;i<$resultadobusqueda.size();i++){
											$amigoAsociado = $resultadobusqueda->fetch();
											$idAmigoAsociado = $amigoAsociado[0];
										}
									}*/
									$sql = 'select * from usuario where idusuario="'.  $idUsuario .'"';
									$resultadobusqueda = $consulta->conn->query($sql);
									if($resultadobusqueda){
										$datosUsuario = $resultadobusqueda->fetch();
										//echo "Datos rescatados: ". $datosUsuario[0].", ". $datosUsuario[1].", ". $datosUsuario[2].", ". $datosUsuario[3].", ". $datosUsuario[4].", ". $datosUsuario[5].", ". $datosUsuario[6]."<br/>";
										$nuevousuario = new usuario($datosUsuario[0],$datosUsuario[1], $datosUsuario[2], $datosUsuario[3], $datosUsuario[4], $datosUsuario[5], $datosUsuario[6]);
										//echo "id del usuario recién creado". $idUsuarioCreado = $nuevousuario->getIdUsuario();
										$nombreUsuarioCreado = $nuevousuario->getNombre();
										$apellidosUsuarioCreado = $nuevousuario->getApellidos();
										$correoUsuarioCreado = $nuevousuario->getCorreoE();
										$fNacimientoUsuarioCreado = $nuevousuario->getFNacimiento();
										$poblacionUsuarioCreado = $nuevousuario->getPoblacion();
										$tipoUsuarioCreado = $nuevousuario->getTipo();
										//echo "Usuario creado :". $nombreUsuarioCreado." ".$apellidosUsuarioCreado." ".$correoUsuarioCreado." ".$fNacimientoUsuarioCreado." ".$poblacionUsuarioCreado. " ".$tipoUsuarioCreado."<br/>";
										//$vectorUsuario = array("objetoUsuario" =>$nuevousuario, "idUsuario" => $idUsuario);
										//$usuarioJson = json_encode($vectorUsuario);
										$usuarioJson = json_encode($nuevousuario); 
										echo $usuarioJson; //Esto es lo que se va a pasar al método de AJAX, para mostrar los datos que interesen del usuario y con el Id se rescatarán las publicaciones llamando a un método creado para ello.
										//echo "Usuario".$nuevousuario."<br/>"; No se puede.
										//echo "Usuario JSON: ".sizeof(json_encode($nuevousuario))."<br/>";
										//var_dump($usuarioJson);
										//echo "Vector sacado de la base de datos: ".$datosUsuario."<br/>"; //Tontería porque es un vector y sólo pone Array
										//echo "Vector sacado de la base de datos en formato JSON: ".json_encode($datosUsuario).", tamaño ".sizeof(json_encode($datosUsuario))."<br/>";
									}
									//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
									$sql = 'select * from publicacion where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.') order by fpublicacion';
									$resultadobusqueda = $consulta->conn->query($sql);
									if($resultadobusqueda){
											
											
											$publicacion = $resultadobusqueda->fetch();
											
											if ($publicacion != null){
												while ($publicacion != null) {
													//echo "Fecha de publicación: ".$publicacion[1].'<br/>'; Esto está temporalmente comentado
													//echo $publicacion[2].'<br/>'; Esto está temporalmente comentado
													$publicacion = $resultadobusqueda->fetch();
												}
											}
										
									}
									$sql = 'select tipo from usuario where idusuario='.  $idUsuario[0];
									$resultadobusqueda = $consulta->conn->query($sql);
									if($resultadobusqueda){
										$tipo = $resultadobusqueda->fetch();
								//echo $tipo[0];
										if($tipo[0]=='admin'){
											//echo "Opciones de administración"; Esto está temporalmente comentado
										}
									}
								}	
							}else{
								echo "Datos incorrectos. <br/>";
								//echo '<a href="formulario.php">Volver</a>';
								echo '<a id="registro" onclick=cargarFormulario("formulario.php") class="btn btn-primary">Volver</a>';

							}
						}else{
							/*Se muestra un mensaje de error si las credenciales no son correctas
							y se da la opción de volver al formulario*/
							//echo "Datos incorrectos. <br/>";
							echo "Error";
							//echo '<a href="formulario.php">Volver</a>';
							echo '<a id="registro" onclick=cargarFormulario("formulario.php") class="btn btn-primary">Volver</a>';
						}
					}else {
						echo "No existe ningún usuario con ese nombre (".$usuario.").<br/>";
						//echo '<a href="formulario.php">Volver</a>';
						echo '<a id="registro" onclick=cargarFormulario("formulario.php") class="btn btn-primary">Volver</a>';
					}
				}else {
					echo "Error";
					//echo '<a href="formulario.php">Volver</a>';
					echo '<a id="registro" onclick=cargarFormulario("formulario.php") class="btn btn-primary">Volver</a>';
				}
			}
			
		?>
