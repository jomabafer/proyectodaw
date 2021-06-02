<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
//require("publicacion.php");
require("clases/foto.php");
//require("usarProcedimiento.php");
$idUsuario = $_POST["idUsuario"];
$consulta = new database;
//$procedimiento = new usarProcedimiento;
//$procedimiento->abrirProcedimiento("procedimientoPublicacion.txt");
//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
//$sql = 'select * from publicacion inner join publicacionAutor on publicacion.idPublicacion=publicacionAutor.idPublicacion inner join amistad on amistad.idAmigoAsociado=publicacionautor.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion';
//$publicaciones = array();
$publicacionesYautores = array();
//$sql = 'select * from foto inner join amistad on amistad.idAmigoAsociado=foto.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fFoto desc';
$sql = "select foto.idFoto, fFoto as fecha, foto.permiso, foto.idAutor, foto.rutaFoto, foto.contenido, foto.idAutor, usuario.nombre, usuario.apellidos, usuario.correoE, usuario.fnacimiento, usuario.poblacion, usuario.tipo, usuario.privacidad, usuario.rutaFoto  from foto inner join amistad on amistad.idAmigoAsociado=foto.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo= $idUsuario order by fFoto desc";
//echo $sql."<br/>";
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$foto = $resultadobusqueda->fetch();
		
		if ($foto != null){
			while ($foto != null) {
				/*echo $foto[0];
				echo "<br/>";
				echo $foto[1]; 
				echo "<br/>";
				echo $foto[2];
				echo "<br/>";
				echo $foto[3];
				echo "<br/>";
				echo $foto[4];
				echo "<br/>";
				echo $foto[5];
				echo "<br/>";*/
				$registroFoto = new foto($foto[0],$foto[1], $foto[2], $foto[3], $foto[4], $foto[5]);
				$autorFoto = new usuario($foto[6], $foto[7], $foto[8], $foto[9], $foto[10], $foto[11], $foto[12],$foto[13], $foto[14]);
				$fotoYautor = array($registroFoto, $autorFoto);
				$fotosYautores[]= $fotoYautor;
				//echo $publicacion[9]. " ".$publicacion[10]. " ha escrito: <br/>".$publicacion[2]. "<br/> el día: ".$publicacion[1].'<br/>';				
				$foto = $resultadobusqueda->fetch();
				
			}
			
			/*$jsonPublicacionesYautores = json_encode($publicacionesYautores);
			echo $jsonPublicacionesYautores;*/
			for($i=0;$i<sizeof($fotosYautores);$i++){
				/*Primero se crean objetos de tipo usuario y publicación a partir de la matriz que se ha
				obtenido al decodificar el JSON recibido*/
				$dato = $fotosYautores[$i];
				//$publicacionRescatada = new foto($dato[0]->idFoto, $dato[0]->fecha, $dato[0]->permiso, $dato[0]->permiso, $dato[0]->contenido);		
				$fotoRescatada = $dato[0];
				//$autor = new usuario($dato[1]->idUsuario,$dato[1]->nombre, $dato[1]->apellidos, $dato[1]->correoE, $dato[1]->fnacimiento, $dato[1]->poblacion, $dato[1]->tipo, $dato[1]->privacidad, $dato[1]->rutaFoto);
				$autor = $dato[1];
				$nombreAutor = $autorFoto->getNombre()." ".$autorFoto->getApellidos();
				$rutaFotoPerfil = $autorFoto->getRutaFoto();
				$horaFoto = $fotoRescatada->getFecha();
				//echo "<a id=amistad".$autor->getIdUsuario()."  href='detallesUsuario.php?idUsuario=".$autor->getIdUsuario()."' onclick = 'return modal(this.href)'>".$autor->getNombre()." ".$autor->getApellidos()."</a> ha publicado: <br/>";
				$texto = $fotoRescatada->getTexto();
				$rutaImagen = $fotoRescatada->getRutaFoto();
				/*if($texto != ""){
					echo $texto."<br/>"; 
				}
				$rutaImagen = $fotoRescatada->getRutaFoto();
				if($rutaImagen !=""){
					$rutaImagen = "imagenes/".$autor->getIdUsuario()."/".$rutaImagen;
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
				}
				echo "<br/>El día <a id=".$fotoRescatada->getIdFoto()." href='detallesFoto.php?idFoto=".$fotoRescatada->getIdFoto()."' onclick = 'return modal(this.href)'>". $fotoRescatada->getFecha()."</a>.<br/>";*/
				/*En el div que antes se capturó se imprimen las publicaciones y sus respectivos autores con
				enlaces que llaman a código para abrir una modal para ver los detalles ya sea del usuario o de 
				la publicación.*/

			?>	
			<div class="post-bar">
				<input type='hidden' id='tipoDetalles' value='detallesPublicacion' />
				<div class="post_topbar">
					<div class="usy-dt">
						<img src="<?php echo $rutaFotoPerfil?>" width="60" height="60" alt="">
						<div class="usy-name">
							<b style='font-size: 25px; font-weight: bold;'><?php echo "<a id=amistad".$autor->getIdUsuario()."  href='detallesUsuario.php?idUsuario=".$autor->getIdUsuario()."' onclick = 'return modal(this.href)'>".$nombreAutor."</a></b> ha publicado: <br/>";?>
							<span><img src="imagenes/iconos/clock.png" alt=""><!--<?php echo $horaFoto ?>--><a id=" <?php echo $fotoRescatada->getIdFoto();?>" href='detallesFoto.php?idFoto=<?php echo $fotoRescatada->getIdFoto();?>' onclick = 'return modal(this.href)'><?php echo $horaFoto;?></a></span>
							
						</div>
					</div>
				</div>
				<div class="job_descp">
					<p><!--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam luctus hendrerit metus, ut ullamcorper quam finibus at. Etiam id magna sit amet... <a href="#" title="">view more</a>-->
					<?php
					if($texto != ""){
						echo "<p>".$texto."</p><br/>"; 
					}
					if($rutaImagen !=""){
						$rutaImagen = "imagenes/".$autor->getIdUsuario()."/".$rutaImagen;
						//echo $rutaImagen;
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
								//echo "<div class='row'><p><a href='$rutaImagen' target='_blank'><figure><img src='$rutaImagen' width=$ancho height=$alto style='float=right;'></a><br/></p></div>";
								?>
								<!--<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>-->
								<!--<p>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.</p>-->
								<figure>
									<div class='row'>
										<a href='<?php echo "../".$rutaImagen; ?>' target='_blank'>
											<img src="<?php echo $rutaImagen; ?>" width="<?php echo $ancho ?>" height="<?php echo $alto ?>">
										</a>
									</div>
									<div class='row'>
										<figcaption>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.</figcaption>
									</div>
								</figure>
								<!--<div class='row'>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.</div>-->
							<?php
							}else{
								echo "<img src='".$rutaImagen."'>";
							}
						}catch(Exception $e){
							echo "Ha habido una excepción: ".$e;
						}
					}
					?>
					</p>
				</div>
				<div id="numeroMeGustas<?php echo $fotoRescatada->getIdFoto();?>"></div>
				<div id="comentarios<?php echo $fotoRescatada->getIdFoto() ?>"></div>
				<div id="errorCargaComentarios"></div>
				<div class="job-status-bar">
					<ul class="like-com">
						<!--<li>
							<a href="#"><i class="la la-heart"></i> 25</a>-->
							<!--Dudo que lo vaya a usar <img src="imagenes/iconos/liked-img.png" alt="">-->
							<!--Dudo que lo vaya a usar<span>25</span>-->
						<!--</li> -->
						<!--<li><a id="meGustaPublicacion" href='#'>Me gusta.</a></li>-->
						<!--<li><a href="#" title="" class="com" onclick='$("#pruebaDetalles<?php echo $fotoRescatada->getIdFoto();?>").load("detallesFoto.php?idFoto=<?php echo $fotoRescatada->getIdFoto();?>")'><img src="imagenes/iconos/com.png" alt="">15</a></li>-->
						<!--<li><a id="" title="" class="com" onclick='$("#marcoDetalles<?php echo $fotoRescatada->getIdFoto();?>").load("detallesFoto.php?idFoto=<?php echo $fotoRescatada->getIdFoto();?>&detalles=true")'>Pincha para ver detalles</a></li>-->
						<li><a id="detallesFoto<?php echo $fotoRescatada->getIdFoto();?>" title="" class="com" onclick='cargarDetallesMarco(<?php echo $fotoRescatada->getIdFoto();?>)'>Pincha para cargar detalles.</a></li>
						<!--<li><a href="#" title="" class="com" onclick='cargarComentarios()'><img src="imagenes/iconos/com.png" alt="">15</a></li>-->
					</ul>
					<!--<a><i class="la la-eye"></i>Views 50</a>-->
				</div>
			</div>
			<?php
			}
			
		}else{
			echo "Parece ser que todavía no hay publicaciones";
		}
	}

?>
										
<?php
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
?>
