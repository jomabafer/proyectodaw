<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
//require("clases/publicacion.php");
require("clases/foto.php");

$idFoto = $_POST["idFoto"];
$consulta = new database;
$sql = 'select * from  foto inner join usuario on foto.idAutor=usuario.idusuario where foto.idFoto ='.$idFoto;
//echo $sql."<br/>";
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
		$foto = $resultadobusqueda->fetch();
		
		if ($foto != null){
			
				
			$registroFoto = new foto($foto[0],$foto[1], $foto[4], $foto[3], $foto[2], $foto[5]);
			//echo $foto[0]; echo $foto[1]; echo $foto[2]; echo $foto[3]; echo $foto[4]; echo $foto[5];
			$autorFoto = new usuario($foto[6], $foto[7], $foto[8], $foto[9], $foto[10], $foto[11], $foto[12],$foto[13], $foto[14]);
				
			
			
			
			//$publicacionRescatada = new foto($dato[0]->idFoto, $dato[0]->fecha, $dato[0]->permiso, $dato[0]->permiso, $dato[0]->contenido);		
			
			//$autor = new usuario($dato[1]->idUsuario,$dato[1]->nombre, $dato[1]->apellidos, $dato[1]->correoE, $dato[1]->fnacimiento, $dato[1]->poblacion, $dato[1]->tipo, $dato[1]->privacidad, $dato[1]->rutaFoto);
			
			$nombreAutor = $autorFoto->getNombre()." ".$autorFoto->getApellidos();
			$rutaFotoPerfil = $autorFoto->getRutaFoto();
			$horaFoto = $registroFoto->getFecha();
			//echo "<a id=amistad".$autor->getIdUsuario()."  href='detallesUsuario.php?idUsuario=".$autor->getIdUsuario()."' onclick = 'return modal(this.href)'>".$autor->getNombre()." ".$autor->getApellidos()."</a> ha publicado: <br/>";
			$texto = $registroFoto->getTexto();
			$rutaImagen = $registroFoto->getRutaFoto();
				

			$mostrar ='';
			/*$mostrar = '<div class="post-bar">
			<div class="post_topbar">
				<div class="usy-dt">
					<img src="'. $rutaFotoPerfil.'" width="60" height="60" alt="">
					<div class="usy-name">
						<b style=·font-size: 25px; font-weight: bold;"><a id=amistad'.$autorFoto->getIdUsuario()."  href='detallesUsuario.php?idUsuario=".$autorFoto->getIdUsuario()."' onclick = 'return modal(this.href)'>".$nombreAutor."</a></b> ha publicado: <br/>
						<span><img src='imagenes/iconos/clock.png alt=''><a id=".$registroFoto->getIdFoto()." href='detallesFoto.php?idFoto=".$registroFoto->getIdFoto()." onclick = 'return modal(this.href)'>".$horaFoto."</a></span>
						
					</div>
				</div>
			</div>
			<div class='job_descp'>
				<p>";*/
				
			if($texto != ""){
				$mostrar =$mostrar."<p>".$texto."</p><br/>"; 
			}
			if($rutaImagen !=""){
				$rutaImagen = "imagenes/".$autorFoto->getIdUsuario()."/".$rutaImagen;
				//echo "rutaImagen:".$rutaImagen;
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
						$mostrar =$mostrar."<p><a href='$rutaImagen' target='_blank'><img src='$rutaImagen' width=$ancho height=$alto style='float=right;'></a><br/></p>";
						
						
						$mostrar =$mostrar."<p>La imagen ha sido reducida. Pincha para abrirla en una pestaña nueva a tamaño real.</p>";
					
					}else{
						$mostrar =$mostrar."<img src='".$rutaImagen."'>";
					}
				}catch(Exception $e){
					echo "Ha habido una excepción: ".$e;
				}
			}
		
				/*$mostrar = $mostrar."</p>
			</div>
			<div class='job-status-bar'>
				<ul class='like-com'>
					<li>
						<a href='#'><i class='la la-heart'></i> Like</a>
						<img src='imagenes/iconos/liked-img.png' alt=''>
						<span>25</span>
					</li> 
					<li><a href='#' title='' class='com' onclick='alert()'><img src='imagenes/iconos/com.png' alt=''> Commentarios 15</a></li>
				</ul>
				<a><i class='la la-eye'></i>Views 50</a>
				</div>
			</div>";*/
			
			$vectorInformacion = array($mostrar, $idFoto);
			$vectorJson = json_encode($vectorInformacion);
			echo $vectorJson;
			
			//echo $idFoto;
		
			
		}else{
			echo "Error al mostrar los datos";
		}
	}


}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
}

?>
