<?php
/*	header('Content-type: text/html; charset=utf-8');
	require("database.php");
	//$usuario = $_POST['usuario'];
	$publicacion = $_POST['publicacion'];
	$consulta = new database;
	$sql = 'select * from comentariopublicación where idPublicacion = '.$publicacion;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$usuario = $consultaEjecutada->fetch();
			$idUsuario = $usuario[0];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if($idUsuario!=null){
				echo true;
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

*/	
?>

<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
require("clases/foto.php");
require("clases/comentario.php");
//require("usarProcedimiento.php");
//$idUsuario = $_POST["usuario"];
$foto = $_POST['publicacion'];
$consulta = new database;
//$procedimiento = new usarProcedimiento;
//$procedimiento->abrirProcedimiento("procedimientoPublicacion.txt");
//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
//$sql = 'select * from publicacion inner join publicacionAutor on publicacion.idPublicacion=publicacionAutor.idPublicacion inner join amistad on amistad.idAmigoAsociado=publicacionautor.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion';
//$publicaciones = array();
$sql = 'select count(*) from comentarioFoto inner join usuario on usuario.idUsuario = comentarioFoto.idUsuario where idFoto = '.$foto.' order by fhcomentario';

$mostrar="";
try{
	$hayComentarios = $consulta->conn->query($sql);
	if($hayComentarios){
		
		$numeroComentarios = $hayComentarios->fetch();
		$mostrar = $mostrar. "<img src='imagenes/iconos/com.png' alt='Hay ".$numeroComentarios[0]." comentarios.'><h3>".$numeroComentarios[0]."</h3>";
		
		
	}else{
		echo "Error";
	}

}catch(Exception $e){
	echo $e->getMessage();
	echo "No se han podido contar los comentarios.";
	die();
}
$publicacionesYautores = array();
$sql = 'select * from comentarioFoto inner join usuario on usuario.idUsuario = comentarioFoto.idUsuario where idFoto = '.$foto.' order by fhcomentario';
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$registroComentario = $resultadobusqueda->fetch();
		
		if ($registroComentario != null){
			while ($registroComentario != null) {
				$comentario = new comentario($registroComentario[0], $registroComentario[2], $registroComentario[4], $registroComentario[3]);				
				$autorComentario = new usuario($registroComentario[5], $registroComentario[6], $registroComentario[7], $registroComentario[8], $registroComentario[9], $registroComentario[10], $registroComentario[11], $registroComentario[12],$registroComentario[13]);
				$usuarioYcomentario = array($autorComentario, $comentario);
				$fotosYcomentarios[]= $usuarioYcomentario;
				//echo $publicacion[9]. " ".$publicacion[10]. " ha escrito: <br/>".$publicacion[2]. "<br/> el día: ".$publicacion[1].'<br/>';				
				$registroComentario = $resultadobusqueda->fetch();
				
			}
			$mostrar = $mostrar. "<ul>";
			/*$jsonFotosYcomentarios = json_encode($fotosYcomentarios);
			echo $jsonFotosYcomentarios;*/
            /**/
            for($i=0; $i<sizeof($fotosYcomentarios); $i++){
			    $dato = $fotosYcomentarios[$i];
                $autor = $dato[0];
			    //$autor = new usuario($dato[0].idUsuario,dato[0].nombre, dato[0].apellidos, dato[0].correoE, dato[0].fNacimiento, dato[0].poblacion, dato[0].tipo, dato[0].privacidad, dato[0].rutaFoto);
			    //$comentarioRescatado = new comentario(dato[1].idComentario, dato[1].idPublicacion, dato[1].fechaComentario, dato[1].textoComentario);
               $comentarioRescatado = $dato[1];
			   $mostrar = $mostrar."<li>
						<div class='comment-list'>
							<div class='bg-img'>
								<img src='".$autor->getRutaFoto()."' width=40 height=40 alt=''>
							</div>
				   			<div class='comment'>";
			    //echo $comentarioRescatado->getFechaComentario(). ": <a href='detallesUsuario.php?idUsuario=".$autor->getIdUsuario()."'>" .$autor->getNombre()." ".$autor->getApellidos()."</a> ha escrito:";
				$mostrar = $mostrar.  "<b><a style = 'color:black;' href='detallesUsuario.php?idUsuario=".$autor->getIdUsuario()."'>".$autor->getNombre()." ".$autor->getApellidos()."</a></b> ha escrito:";
				$mostrar = $mostrar. "<br/>";
				$mostrar = $mostrar. "<span><img src='imagenes/iconos/clock.png' alt=''>". $comentarioRescatado->getFechaComentario()."</span>";
                $texto = $comentarioRescatado->getTextoComentario();
                //echo "<br/>";
                $mostrar = $mostrar. "<p>".$texto."</p>"; 
				$mostrar = $mostrar.	 "</div>
					</div>
				</li>";
                
    		}
			$mostrar = $mostrar. "</ul>";
			$vectorDatos = array($mostrar, $foto);
			//echo $mostrar;
			//echo $vectorDatos[0];
			//echo $vectorDatos[1];
			$jsonVectorDatos = json_encode($vectorDatos);
			echo $jsonVectorDatos;
            
			
		}/*else{
			echo "Parece ser que todavía no hay comentarios.";
		}*/
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
?>
