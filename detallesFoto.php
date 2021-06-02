<html>
<?php
	session_start();
	header('Content-type: text/html; charset=utf-8');
	require("PHP/database.php");
	require("PHP/clases/usuario.php");
	require("PHP/clases/foto.php");
	$idFoto = $_GET["idFoto"];
	$soloDetalles = false;
	if(isset($_GET["detalles"])){
		$soloDetalles = $_GET["detalles"];
		
	}
	
?>
<head>

	<script src="jquery-3.4.1.js" defer></script>
	<script src="publicacion.js" defer></script>
	<script src="foto.js" defer></script>
	<script src="JS/clases/usuario.js" defer></script>
	<script src="JS/codigoCompartido.js" defer></script>
	<script src="JS/detalles.js" defer></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/estilo.css">
<!--De la plantilla-->

<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome-font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick-theme.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/responsive.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

<!--/De la plantilla-->
</head>
<?php
	//}
?>
<body>
	<div id="panel"></div>
    <div id="marcoOpciones"></div>
	<div id="irInicio"></div>
	<div class="wrapper">
		<section class="forum-page">
			<div class="container">
				<div class="forum-questions-sec">
					<div class="row">
						<div class="col-lg-9">
							<div class="forum-post-view">
							<div class="usr-question">
					
					<!--Desde aquí--<div class="usr_quest">
						<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
						<span><i class="fa fa-clock-o"></i>3 min ago</span>
						<ul class="react-links">
							<li><a href="#" title=""><i class="fa fa-heart"></i> Vote 150</a></li>

						</ul>--Hasta aquí habría que moverlo a la zona donde se rescatan los datos de la publicación-->
						<!--<div >
							<p>	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at libero elit. Mauris ultrices sed lorem nec efficitur. Donec sit amet facilisis lorem, quis facilisis tellus. Nullam mollis dignissim nisi sit amet tempor. Nullam sollicitudin neque a felis commodo gravida at sed nunc. In justo nunc, sagittis sed venenatis at, dictum vel erat. Curabitur at quam ipsum. Quisque eget nibh aliquet, imperdiet diam pharetra, dapibus lacus. Sed tincidunt sapien in dui imperdiet eleifend. Ut ut sagittis purus, non tristique elit. Quisque tincidunt metus eget ligula sodales luctus. Donec convallis ex at dui convallis malesuada. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut pretium euismod mollis. Pellentesque convallis gravida ante eu pretium. Integer rutrum mi nec purus tincidunt, nec rhoncus mauris porttitor. Donec id tellus at leo gravida egestas. Suspendisse consequat mi vel euismod efficitur. Donec sed elementum libero.</p>
							<p> Etiam rutrum ut urna eu tempus. Curabitur suscipit quis lorem vel dictum. Aliquam erat volutpat. Pellentesque volutpat viverra pulvinar. Mauris ac sapien ac metus tincidunt volutpat eu eu purus. Suspendisse pharetra quis quam id auctor. Pellentesque feugiat venenatis urna, vitae suscipit enim volutpat vitae. Nunc egestas tortor est, at sodales ligula auctor efficitur.</p>
						</div>-->
							
			<?php
			//require("usarProcedimiento.php");
			$consulta = new database;
			//$procedimiento = new usarProcedimiento;
			//$procedimiento->abrirProcedimiento("procedimientoPublicacion.txt");
			//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
			//$sql = 'select * from publicacion inner join publicacionAutor on publicacion.idPublicacion=publicacionAutor.idPublicacion inner join amistad on amistad.idAmigoAsociado=publicacionautor.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion';
			$sql = 'select * from  foto inner join usuario on foto.idAutor=usuario.idusuario where foto.idFoto ='.$idFoto;
			try{
				$resultadobusqueda = $consulta->conn->query($sql);
				if($resultadobusqueda){
						
						
					$registroFoto = $resultadobusqueda->fetch();
					if ($registroFoto != null){
						
						$foto = new foto($registroFoto[0], $registroFoto[1], $registroFoto[4], $registroFoto[3], $registroFoto[2], $registroFoto[5]);
						$autorFoto = new usuario($registroFoto[6], $registroFoto[7], $registroFoto[8], $registroFoto[9], $registroFoto[10], $registroFoto[11], $registroFoto[12], $registroFoto[13], $registroFoto[14]);
			//($idUsuario, $nombre, $apellidos, $correoE, $fnacimiento, $poblacion, $tipo, $privacidad, $rutaFoto)
						/*while ($registroAmistad != null) {
							$amistad = new usuario($registroAmistad[2], $registroAmistad[3], $registroAmistad[4], $registroAmistad[5], $registroAmistad[6], $registroAmistad[7], $registroAmistad[8]);
							$amistades[]= $amistad;
							//echo $publicacion[9]. " ".$publicacion[10]. " ha escrito: <br/>".$publicacion[2]. "<br/> el día: ".$publicacion[1].'<br/>';				
							$registroAmistad = $resultadobusqueda->fetch();
							
						}*/
						?>
						<div class="usr_quest">
						<!--<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>-->
						<!--<span><i class="fa fa-clock-o"></i>3 min ago</span>
						<ul class="react-links">
							<li><a href="#" title=""><i class="fa fa-heart"></i> Vote 150</a></li>

						</ul>-->

						<?php
						$rutaFotoPerfil = $autorFoto->getRutaFoto();
						$nombreAutor = $autorFoto->getNombre()." ".$autorFoto->getApellidos();
						$idAutor = $autorFoto->getIdUsuario();
						$horaFoto =  $foto->getFecha();
						if(!$soloDetalles){
						?>
						<!--If viaDirecta inicio-->
						<!--<div class="comment-list">
							<div class="bg-img">
								<img src="<?php echo $rutaFotoPerfil; ?>" width="60" height="60" alt="">
							</div>
							<div class='comment'>
								<b style='font-size: 25px; font-weight: bold;'><a   href='detallesUsuario.php?idUsuario=<?php echo $idAutor;?>' ><?php echo $nombreAutor?></b> </a>ha publicado:<br/>
								<span><img src='imagenes/iconos/clock.png' alt=''>"<?php echo $horaFoto; ?></span>
							</div>
						</div>-->
						<!--<div class="post-bar">-->
							<input type='hidden' id='tipoDetalles' value='detallesPublicacion' />
							<div class="post_topbar">
								<div class="usy-dt">
									<img src="<?php echo $rutaFotoPerfil?>" width="60" height="60" alt="">
									<div class="usy-name">
									<b style='font-size: 25px; font-weight: bold;'><a   href='detallesUsuario.php?idUsuario=<?php echo $idAutor;?>' ><?php echo $nombreAutor?></b> </a>ha publicado:<br/>
									<span><img src='imagenes/iconos/clock.png' alt=''>"<?php echo $horaFoto; ?></span>
										
									</div>
								</div>
							</div>
							<div class="job_descp">
								<?php
								$rutaFoto = $foto->getRutaFoto();
								$texto = $foto->getTexto();
								if($texto !=""){
									echo "<p>".$texto."</p></br>";
								}
								if($rutaFoto !=""){
									$rutaFoto = "imagenes/".$idAutor."/".$rutaFoto;
									//echo "<img src='".$rutaFoto."'/></br>";
									$imagen = getimagesize($rutaFoto);    //Sacamos la información
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
										}?>
										<figure>
											<div class='row'>
												<a href='<?php echo $rutaFoto; ?>' target='_blank'>
													<img src="<?php echo $rutaFoto; ?>" width="<?php echo $ancho ?>" height="<?php echo $alto ?>">
												</a>
											</div>
											<div class='row'>
												<figcaption>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.</figcaption>
											</div>
										</figure>
										<?php
										//echo "<a href='$rutaFoto' target='_blank'><img src='$rutaFoto' width=$ancho height=$alto></a>";
										//echo "<br/>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.";
									}else{
										echo "<img src='".$rutaFoto."'>";
									}
								}
								echo "<br/>";
							}
							?>
							<!--</div>-->
						<?php
							//If viaDirecta fin
							/*$jsonPublicacion = json_encode($publicacion);
							echo $jsonPublicacion;*/
							//echo count($amistades);
							
							
							//session_start();
							//$infoSesion[];
							
							?>
							<input type='hidden' id='tipoDetalles' value='detallesPublicacion' />
							<input type='hidden' id='idPublicacion' value='<?php echo $idFoto;?>' />
							<div id="numeroMeGustas<?php echo $idFoto;?>"></div>
							<!--<div id="comentarios"></div>-->
							<?php
							if(!empty($_SESSION['usuario'])&!empty($_SESSION['clave'])){ //Para poder compartir un enlace de una publicación sin que haya problemas.
								echo "<input id=credencialUsuario type='hidden' value='".$_SESSION['usuario']."'/>";
								echo "<input id=credencialClave type='hidden' value='".$_SESSION['clave']."'/>";
								$usuario=$_SESSION['usuario'];
								$clave=$_SESSION['clave'];
								$idFoto = $foto->getIdFoto();
								$sql = "select * from credencialesusuario where identificador = '".$usuario."'";
								$resultadobusqueda = $consulta->conn->query($sql);
								if ($resultadobusqueda){
									$credencialUsuario = $resultadobusqueda->fetch();
									$idUsuario = $credencialUsuario[0];
								}
								
								/*Comentarios y me gusta*/
								//header('Location: conexion.php');
								/*En vez de un header, quizás debería incrustar Javascript para llamar al método iniciarSesion, modificado para
								también recibir credenciales además de la URL*/
								//echo"<script> alert('Has abierto una publicación.');</script>";
								//echo $idUsuario;
								//echo "<a id='meGustaPublicacion' href='http://google.com'>Me gusta.</a>"
								?>
								<input type='hidden' id='comprueboMeGustaUsuario' value='<?php echo $idUsuario;?>' />
								<input type='hidden' id='idUsuarioConectado' value='<?php echo $idUsuario;?>' />
								<!--<br/>Esto sólo debe salir si te has conectado.-->
								<a id="meGustaPublicacion" href='#'>Me gusta.</a>
								<!--<br/><a href='#' onclick='alert("<?php echo $usuario ?>")'>Me gusta.</a>-->
								<!--<form id="formularioComentario">
									<textarea id="comentario">Escribe un comentario</textarea>
									<input type="submit" value="Comentar"/> 
								</form>-->
								<?php
							}else{
							?>	
							<input type='hidden' name='idUsuarioConectado' id='comprueboMeGustaUsuario' value=0 /><!--Así evito problemas con el undefined-->
							<input type='hidden' id='idUsuarioConectado' value=0 />
						</div>
						<?php
						}
					}else{
						echo "Ha habido un problema al acceder al contenido de esta publicación.";
					}
				}
			}catch(Exception $e){
					echo $e->getMessage();
					echo "Ha habido un error en la base de datos.";
					die();
				}
			?>


	

		
			
				
					
						
		
				<!--<div class="usr-question">
					<div class="usr_img">
						<img src="http://via.placeholder.com/60x60" alt="">
					</div>
					<div class="usr_quest">
						<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
						<span><i class="fa fa-clock-o"></i>3 min ago</span>
						<ul class="react-links">
							<li><a href="#" title=""><i class="fa fa-heart"></i> Vote 150</a></li>

						</ul>
						<div >
							<p>	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at libero elit. Mauris ultrices sed lorem nec efficitur. Donec sit amet facilisis lorem, quis facilisis tellus. Nullam mollis dignissim nisi sit amet tempor. Nullam sollicitudin neque a felis commodo gravida at sed nunc. In justo nunc, sagittis sed venenatis at, dictum vel erat. Curabitur at quam ipsum. Quisque eget nibh aliquet, imperdiet diam pharetra, dapibus lacus. Sed tincidunt sapien in dui imperdiet eleifend. Ut ut sagittis purus, non tristique elit. Quisque tincidunt metus eget ligula sodales luctus. Donec convallis ex at dui convallis malesuada. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut pretium euismod mollis. Pellentesque convallis gravida ante eu pretium. Integer rutrum mi nec purus tincidunt, nec rhoncus mauris porttitor. Donec id tellus at leo gravida egestas. Suspendisse consequat mi vel euismod efficitur. Donec sed elementum libero.</p>
							<p> Etiam rutrum ut urna eu tempus. Curabitur suscipit quis lorem vel dictum. Aliquam erat volutpat. Pellentesque volutpat viverra pulvinar. Mauris ac sapien ac metus tincidunt volutpat eu eu purus. Suspendisse pharetra quis quam id auctor. Pellentesque feugiat venenatis urna, vitae suscipit enim volutpat vitae. Nunc egestas tortor est, at sodales ligula auctor efficitur.</p>
						</div>	-->

					<div class="comment-section">
						<div class="comment-sec">

							<div id="comentarios<?php echo $idFoto; ?>"></div>
							<div id="errorCargaComentarios"></div>


						</div>
					</div>

					
	</div>
	</div>
</div>
<?php
						if(!empty($_SESSION['usuario'])&!empty($_SESSION['clave'])){?>
							<div class="post-comment-box">
								<div class="user-poster">
									<!--<div class="usr-post-img">
										<img src="http://via.placeholder.com/40x40" alt="">
									</div>-->
									<div class="post_comment_sec">
										<form id="formularioComentario">
											<textarea id="comentario" placeholder="Escribe un comentario"></textarea>
											<button type="submit"> Comentar </button>
										</form>
									</div>
								</div>
							</div>
					<?php 
						}
					?>
						</div>
						
					</div>
				</div>
			</div>
		</section>

	</div>



</body>
</html>
