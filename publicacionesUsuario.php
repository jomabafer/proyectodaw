<div id='marcoPrueba'></div>
<?php
header('Content-type: text/html; charset=utf-8');
require("database.php");
require("usuario.php");
require("foto.php");
$consulta = new database;
$idUsuario = $_POST["usuarioVisitado"];

$sql = 'select * from  usuario  where idUsuario ='.$idUsuario;
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$registroUsuario = $resultadobusqueda->fetch();
		if ($registroUsuario != null){
			$usuario = new usuario($registroUsuario[0], $registroUsuario[1], $registroUsuario[2], $registroUsuario[3], $registroUsuario[4], $registroUsuario[5], $registroUsuario[6], $registroUsuario[7], $registroUsuario[8]);
			$nombre = $usuario->getNombre()." ".$usuario->getApellidos();
			$rutaFotoPerfil = $usuario->getRutaFoto();
			/*while ($registroAmistad != null) {
				$amistad = new usuario($registroAmistad[2], $registroAmistad[3], $registroAmistad[4], $registroAmistad[5], $registroAmistad[6], $registroAmistad[7], $registroAmistad[8]);
				$amistades[]= $amistad;
				//echo $publicacion[9]. " ".$publicacion[10]. " ha escrito: <br/>".$publicacion[2]. "<br/> el día: ".$publicacion[1].'<br/>';				
				$registroAmistad = $resultadobusqueda->fetch();
				
			}*/
			
			/*echo "Nombre: ".$usuario->getNombre()." ".$usuario->getApellidos().".<br/>";
			echo "Fecha de nacimiento: ".$usuario->getFnacimiento().".<br/>";
			echo "Correo electrónico: ".$usuario->getCorreoE().".<br/>";
			echo "Población: ".$usuario->getPoblacion().".<br/>";*/
			
			//$jsonUsuario = json_encode($usuario);
			/*echo $jsonUsuario;*/
			//echo count($amistades);
			//echo "Lista de publicaciones:<br/>";
			$sql = 'select * from foto where idAutor='.$idUsuario." order by fFoto desc";
			$resultadobusqueda = $consulta->conn->query($sql);
			$registroFoto = $resultadobusqueda->fetch();
			if($registroFoto!=null){
				while($registroFoto!=null){
					$foto = new foto($registroFoto[0],$registroFoto[1],$registroFoto[4],$registroFoto[3],$registroFoto[2],$registroFoto[5]);
									//($idFoto, $fecha, $permiso, $idAutor, $rutaFoto, $texto)
					/*echo "Lo que devuelve la base de datos:";
					echo "<br/>";
					echo $registroFoto[0]; //id
					echo "<br/>";
					echo $registroFoto[1]; //fecha
					echo "<br/>";
					echo $registroFoto[2]; //ruta
					echo "<br/>";
					echo $registroFoto[3]; //autor
					echo "<br/>";
					echo $registroFoto[4]; //permiso
					echo "<br/>";
					echo $registroFoto[5]; //texto
					echo "<br/>";
					echo "Fin de los datos de la publicación";
					echo "<br/>";
					*/
					$listaFotos[] = $foto;
					$registroFoto = $resultadobusqueda->fetch();
				}
				/*for($i=0; $i<count($listaPublicaciones); $i++){
					echo "<a href='detallesPublicacion.php?idPublicacion=".$listaPublicaciones[$i]->getIdPublicacion()."'>".$listaPublicaciones[$i]->getFecha().":</a> ".$listaPublicaciones[$i]->getContenido()."<br/>";
				}*/
				/*$usuarioYpublicaciones = array($usuario, $listaPublicaciones);
				$jsonUsuario = json_encode($usuarioYpublicaciones);
				echo $jsonUsuario;*/
			}else{
				$listaFotos = "Parece que este perfil aún no ha publicado nada.";
			}
			
			/*$usuarioYpublicaciones = array($usuario, $listaPublicaciones);
			$jsonUsuario = json_encode($usuarioYpublicaciones);
			echo $jsonUsuario;*/
			try{
				$hayFotos = false;
				/*for($i=0; $i<sizeof($listaPublicaciones); $i++){
					if($listaPublicaciones[$i]->getFecha()!=null){
						$hayPublicaciones = true;
					}
				}*/
				if($listaFotos != "Parece que este perfil aún no ha publicado nada."){
					$hayFotos = true;
				}
				
				if($hayFotos==true){

					for($i=0; $i<sizeof($listaFotos); $i++){
						$foto = $listaFotos[$i];
						//echo $foto->getRutaFoto().".<br/> El día <a id=".$foto->getIdFoto()." href='detallesPublicacion.php?idPublicacion=".$foto->getIdFoto()."' onclick = 'return nuevaPestanha(this.href)'>".$foto->getFecha()."</a>.<br/>";
						$rutaImagen = $foto->getRutaFoto();
						$texto = $foto->getTexto();
						$fecha = $foto->getFecha();
						$idFoto = $foto->getIdFoto();
						?>
						<!--Código pegado-->
						<div class="product-feed-tab current" id="feed-dd">
							<div class="posts-section">
												<div class="post-bar">
													<div class="post_topbar">
														
														<div class="usy-dt">
															<img src="<?php echo $rutaFotoPerfil; ?>" width='60' height='60' alt="">
															<div class="usy-name">
																<h3><?php echo $nombre;?></h3>
																<span><img src="imagenes/iconos/clock.png" alt=""> <a id="<?php echo $idFoto; ?>" href='detallesFoto.php?idFoto=<?php echo $idFoto; ?>' onclick = 'return modal(this.href)'><?php echo $fecha; ?></a></span>
															</div>
														</div>
														<div class="ed-opts">
															<a href="#" title="" class="ed-opts-open"><i class="la la-ellipsis-v"></i></a>
															<ul class="ed-options">
																<li><a title="" id="editar<?php echo $idFoto; ?>" onclick=cargarFormularioEdicion(<?php echo $idFoto; ?>) class="btn btn-link">Editar</a></li>
																<li><a title="" id="borrar<?php echo $idFoto; ?>" onclick="borrar(<?php echo $idFoto; ?>)" class="btn btn-link">Borrar</a></li>
															</ul>
														</div>
													
													</div>
													<div id="foto<?php echo $idFoto; ?>">
														<div id="edicion<?php echo $idFoto; ?>" <!--class="ocultable"-- >
															<!--<form id="formulario" method='POST'>
																<label for='cambiarFoto'>Modificar publicación:</label>
																<input id="cambiarFoto" name="subirFoto" type="file" accept=".png, .jpg, .jpeg"/><br/>
																<textarea rows="10" cols="40" id="modificarTexto" name="modificarTexto"></textarea> <br/>
																<a id='botonModificar' class='btn btn-primary'>Modificar</a>
																<a id='botonCancelar' class='btn btn-primary'>Cancelar</a>
															</form>-->
														</div>
														<div id="ocultable<?php echo $idFoto; ?>" class="job_descp">
															<?php
															if($texto != ""){
																echo "<p>".$texto."</p>"; 
															}
															if($rutaImagen !=""){
																$rutaImagen = "imagenes/".$foto->getIdAutor()."/".$rutaImagen;
																try{
																	$imagen = getimagesize("../".$rutaImagen);    //Sacamos la información
																	$ancho = $imagen[0]; //Ancho de la imagen
																	$alto = $imagen[1];	//Alto de la imagen
																	if($ancho>500 or $alto>500){
																		if($alto>$ancho){
																			$proporcion = $alto/500;
																			$ancho = $ancho/$proporcion;
																			$alto = 500;
																		}else{
																			$proporcion = $ancho/500;
																			$alto = $alto/$proporcion;
																			$ancho = 500;
																		}
																		/*echo "<a href='$rutaImagen' target='_blank'><img src='$rutaImagen' width=$ancho height=$alto></a>";
																		echo "<br/>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.";*/
																		?>
																		<figure>
																			<div class='row'>
																				<a href='<?php echo $rutaImagen; ?>' target='_blank'>
																					<img src="<?php echo $rutaImagen; ?>" width="<?php echo $ancho ?>" height="<?php echo $alto ?>">
																				</a>
																			</div>
																			<div class='row'>
																				<figcaption>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.</figcaption>
																			</div>
																		</figure>
																		<?php
																	}else{
																		echo "<img src='../".$rutaImagen."'>";
																	}
																}catch(Exception $e){
																	echo "Ha habido una excepción: ".$e;
																}
															}

															?>
															<!--<p>FUCK Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam luctus hendrerit metus, ut ullamcorper quam finibus at. Etiam id magna sit amet... <a href="#" title="">view more</a></p>-->
															
														</div>
													</div>
													<!--<div id="comentarios<?php echo $idFoto;?>"></div>-->
													<div id="numeroMeGustas<?php echo $idFoto;?>"></div>
													<div id="comentarios<?php echo $idFoto;?>"></div>
													<div class="job-status-bar">
														<ul class="like-com">
															<!--<li>
																<a href="#"><i class="la la-heart"></i> Like</a>
																<img src="images/liked-img.png" alt="">
																<span>25</span>
															</li> 
															<li><a href="#" title="" onclick='prueba("HOLA")' class="com"><img src="images/com.png" alt=""> Comment 15</a></li>-->
															<!--<li><a id="" title="" class="com" onclick='$("#marcoComentarios<?php echo $idFoto;?>").load("detallesFoto.php?idFoto=<?php echo $idFoto;?>&detalles=true")'>Pincha para ver detalles</a></li>
															<li><a id="" title="" class="com" onclick='$("#marcoComentarios<?php echo $idFoto;?>").load("detallesFoto.php?idFoto=<?php echo $idFoto;?>&detalles=true")'>Pincha para ver detalles</a></li>-->
															<li><a id="detallesFoto<?php echo $idFoto;?>" title="" class="com" onclick='cargarDetallesMarco(<?php echo $idFoto;?>)'>Pincha para cargar detalles.</a></li>

														</ul>
														<!--<a><i class="la la-eye"></i>Views 50</a>-->
													</div>
												</div>
											</div>
										</div>
										<!--posts-section end-->
						</div>
						<!--Código pegado-->
						<?php
						/*if($texto != ""){
							echo $texto."<br/>"; 
						}*/
						/*if($rutaImagen !=""){
							$rutaImagen = "imagenes/".$foto->getIdAutor()."/".$rutaImagen;
							try{
								$imagen = getimagesize($rutaImagen);    //Sacamos la información
								$ancho = $imagen[0]; //Ancho de la imagen
								$alto = $imagen[1];	//Alto de la imagen
								if($ancho>500 or $alto>500){
									if($alto>$ancho){
										$proporcion = $alto/500;
										$ancho = $ancho/$proporcion;
										$alto = 500;
									}else{
										$proporcion = $ancho/500;
										$alto = $alto/$proporcion;
										$ancho = 500;
									}
									echo "<a href='$rutaImagen' target='_blank'><img src='$rutaImagen' width=$ancho height=$alto></a>";
									echo "<br/>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.";
								}else{
									echo "<img src='".$rutaImagen."'>";
								}
							}catch(Exception $e){
								echo "Ha habido una excepción: ".$e;
							}
						}*/
						//echo "<br/>El día <a id=".$foto->getIdFoto()." href='detallesPublicacion.php?idPublicacion=".$foto->getIdFoto()."' onclick = 'return modal(this.href)'>". $foto->getFecha()."</a>.<br/>";
						
					}
				}else{
				?>	
					<div class="product-feed-tab current" id="feed-dd">
							<div class="posts-section">
												<div class="post-bar">
													
													
													<div class="job_descp">
														<h3>
															<?php echo $listaFotos; ?>
														</h3>
													</div>
													
												</div>
											</div>
										</div>
										<!--posts-section end-->
						</div>

					</div>
					<?php
					
				}
			}catch(Exception $e){
?>
				<div class="product-feed-tab current" id="feed-dd">
						<div class="posts-section">
											<div class="post-bar">
												
												
												<div class="job_descp">
													<h3>
														<?php echo "Ha habido un error: ".$e; ?>
													</h3>
												</div>
												
											</div>
										</div>
									</div>
									<!--posts-section end-->
					</div>

				</div>
<?php
				

				
			}
			
		}else{

			?>
			<div class="product-feed-tab current" id="feed-dd">
					<div class="posts-section">
										<div class="post-bar">
											
											
											<div class="job_descp">
												<h3>
													<?php echo "Ha habido un problema al acceder a este perfil."; ?>
												</h3>
											</div>
											
										</div>
									</div>
								</div>
								<!--posts-section end-->
				</div>

			</div>
<?php

			
		}
	}
}catch(Exception $e){

	?>
	<div class="product-feed-tab current" id="feed-dd">
			<div class="posts-section">
					<div class="post-bar">
						
						
						<div class="job_descp">
							<h3>
								<?php 
									echo $e->getMessage();
									echo "Ha habido un error en la base de datos.";
								?>
							</h3>
						</div>
						
					</div>
				</div>
			</div>
						<!--posts-section end-->
		</div>

	</div>
<?php
	
		die();
	}
		
?>
