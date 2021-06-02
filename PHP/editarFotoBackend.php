<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	require("clases/usuario.php");
	require("clases/foto.php");
	if(isset($_POST["idPublicacion"])){
		$idFoto = $_POST["idPublicacion"];
		$texto = $_POST["texto"];
	}else{
		//$fecha = json_decode(stripslashes($_POST["datosFoto"]))->fecha;
		//$permiso = json_decode(stripslashes($_POST["datosFoto"]))->permiso;
		//echo $_POST["datosFoto"];
		$rutaFoto = json_decode(stripslashes($_POST["datosFoto"]))->rutaFoto;
		$rutaAntigua = $_POST["rutaAntigua"];
		//echo $rutaAntigua; //Hay que quitarle la barra final
		$texto = json_decode(stripslashes($_POST["datosFoto"]))->texto;
		$idFoto = json_decode(stripslashes($_POST["datosFoto"]))->idFoto;
		$idAutor = json_decode(stripslashes($_POST["datosFoto"]))->autor;
		$rutaUsuario = "imagenes/".$idAutor;
		$fecha = json_decode(stripslashes($_POST["datosFoto"]))->fecha;
		$permiso = json_decode(stripslashes($_POST["datosFoto"]))->permiso;
		$nuevaFoto = new foto($idFoto, $fecha, $permiso, $idAutor, $rutaFoto, $texto);

	}
	$consulta = new database;
	//$sql = 'select * from  foto where idFoto ='.$idFoto;

	/*Se debe comprobar si hay una foto cargada para borrarla en su caso */
	if(isset($rutaFoto)){
		$sql = 'update foto set contenido = "'.$texto.'", rutaFoto = "'.$rutaFoto.'" where idFoto ='.$idFoto;
		$cambiarArchivo = true;
	}else{
		$sql = 'update foto set contenido = "'.$texto.'" where idFoto ='.$idFoto;
		$cambiarArchivo = false;
	}
	//echo $sql;
	$foto;
	try{
		$resultadoActualizacion = $consulta->conn->query($sql);
		if($resultadoActualizacion){
			if($cambiarArchivo){
				//Aquí borro o cambio el archivo
				/*$pos = strpos($rutaAntigua, "/");
				$archivoAntiguo = substr($rutaAntigua, $pos);
				echo $archivoAntiguo;*/
				
				if(file_exists($rutaAntigua)) {
					$files = glob($rutaAntigua); //obtenemos todos los nombres de los ficheros
					//echo $files;
					foreach($files as $file){
						if(is_file($file)){
							unlink($file); //elimino el fichero
						}
					}
					//rmdir($carpetaFotoPerfil);
				}
				if(!empty($_FILES["file"])){
					//echo "Se va a actualizar el archivo.";
					if (($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/gif")) {
					$carpetaAutor = "imagenes/".$nuevaFoto->getIdAutor();
					if (!file_exists($carpetaAutor)) {
						mkdir($carpetaAutor, 0777, true);
					}
						$_FILES['file']['name'] = $nuevaFoto->getRutaFoto();
						$rutaFichero = $carpetaAutor."/".$_FILES['file']['name'];
						if (move_uploaded_file($_FILES["file"]["tmp_name"], $rutaFichero)) {
							//more code here...
								//echo $carpetaAutor."/".$_FILES['file']['name'];
						} else {
							echo 0;
						}
					
					} else {
						echo 0;
					}
					/*$imagen = getimagesize($rutaFichero);    //Sacamos la información
					$ancho = $imagen[0];              //Ancho
					$alto = $imagen[1];               //Alto
					if($ancho > 500){
						$reduccion = (1 - ($ancho - 500)/$ancho)*100;
						echo "Reducción: $reduccion <br/>";
						echo "<img src='".$rutaFichero."' widht='$reduccion%' height='$reduccion%' ><br/> (Formato reducido para poder verse en pantalla)";
					}else{
						if($alto > 500){
							$reduccion = (1 - ($alto - 500)/$alto)*100;
							echo "Reducción: $reduccion <br/>";
							echo "<img src='".$rutaFichero."' widht='$reduccion%' height='$reduccion%' ><br/> (Formato reducido para poder verse en pantalla)";
						}else{
							echo "<img src='".$rutaFichero."'><br/>";
						}
						
					}*/
					
					
					//echo "Ancho: $ancho <br/>";
					//echo "Alto: $alto <br/>";
					
				}else{
					//Debo eliminar el archivo.
				}
			}

			echo "Publicación actualizada";
			//echo "Ha entrado en el primer if.";
			/*$registroFoto = $resultadobusqueda->fetch();*/ /*¿Por qué tengo que ejecutar esto para que no dé error?*/
			/*if ($registroFoto != null){
				echo "Ha entrado en el segundo if.";
				$foto = new foto($registroFoto[0], $registroFoto[1], $registroFoto[4], $registroFoto[3], $registroFoto[2], $registroFoto[5]);
			}*/
		}
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
?>

