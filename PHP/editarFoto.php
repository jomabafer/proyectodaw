<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	require("clases/usuario.php");
	require("clases/foto.php");
	$idFoto = $_POST["idPublicacion"];
	$consulta = new database;
	$sql = 'select * from  foto where idFoto ='.$idFoto;
	$foto;
	try{
		$resultadobusqueda = $consulta->conn->query($sql);
		if($resultadobusqueda){
				
				
			$registroFoto = $resultadobusqueda->fetch();
			if ($registroFoto != null){
				
				$foto = new foto($registroFoto[0], $registroFoto[1], $registroFoto[4], $registroFoto[3], $registroFoto[2], $registroFoto[5]);
			}
		}
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}

	if($foto->getRutaFoto()!=""){
		//$codigoImagen = "<img src='imagenes/".$foto->getIdAutor()."/".$foto->getRutaFoto()."'/><br/>";
		$botonEliminarImagen = "<a id='botonEliminar' class='btn btn-primary'>Eliminar foto</a>";
		$rutaImagen = "imagenes/".$foto->getIdAutor()."/".$foto->getRutaFoto();
		$tamanyoImagen = getimagesize($rutaImagen);    //Sacamos la información
		$ancho = $tamanyoImagen[0]; //Ancho de la imagen
		$alto = $tamanyoImagen[1];	//Alto de la imagen
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
			$codigoImagen = "<p><a href='$rutaImagen' target='_blank'><img id='imagenEditar' src='$rutaImagen' width=$ancho height=$alto style='float=right;'></a><br/></p>";
		}else{
			$codigoImagen = "<img id='imagenEditar' src='".$rutaImagen."'/><br/>";
		}
	}else{
		$codigoImagen = "";
		$botonEliminarImagen="";
	}

$formulario = "<div id='divFoto".$foto->getidFoto()."'>".$codigoImagen."</div>
<form id='formulario' method='POST'>
<input type='hidden' id='idFoto' value='". $foto->getidFoto()."'/>
<input type='hidden' id='idAutorFoto' value='". $foto->getIdAutor()."'/>
<input type='hidden' id='cambiarImagen' value='No'/>
<label for='cambiarFoto'>Modificar publicación:</label>
<input id='cambiarFoto' name='subirFoto' type='file' accept='.png, .jpg, .jpeg' style='visibility: hidden;'/>"
.$botonEliminarImagen."<br/>
<textarea rows='10' cols='40' id='modificarTexto' name='modificarTexto'>". $foto->getTexto()."</textarea> <br/>
<a id='botonModificar'  class='btn btn-primary'>Modificar</a>
<a id='botonCancelar' onclick='recargarFoto(\"".$foto->getidFoto()."\")' class='btn btn-primary'>Cancelar</a>

</form>
<br/>";

$vectorInformacion = array($formulario, $idFoto);
$vectorJson = json_encode($vectorInformacion);
echo $vectorJson;
?>

