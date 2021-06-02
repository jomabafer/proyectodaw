<?php
	require("clases/database.php");
	require("clases/usuario.php");
	require("clases/foto.php");
	//require("usarProcedimiento.php");
	header('Content-type: text/html; charset=utf-8');
	$nombreArchivoFoto = $_POST["nombreArchivoFoto"];
	echo "nombreArchivoFoto: ".$_POST["nombreArchivoFoto"]."<br/>";
	/*$fecha = json_decode(stripslashes($_POST["datosFoto"]))->fecha;
	$permiso = json_decode(stripslashes($_POST["datosFoto"]))->permiso;
	$rutaFoto = json_decode(stripslashes($_POST["datosFoto"]))->rutaFoto;
	$texto = json_decode(stripslashes($_POST["datosFoto"]))->texto;*/
	$idUsuario = $_POST["idUsuario"];
	echo "<br/>"."idUsuario: ".$idUsuario."<br/>";
	//echo $_POST['textoPublicacion'];
	//echo "Permiso: ".$permiso.". Contenido: ".$contenido.". idUsuario: ".$idUsuario;
	//echo "Ruta de la foto: ".$rutaFoto;
	//$nuevaFoto = new foto(0, $fecha, $permiso, $idUsuario, $rutaFoto, $texto);
	//$procedimiento = new usarProcedimiento;
	$consulta = new database;
	$almacenamientoPublicacion = false;
	$carpetaAutor = "imagenes/".$idUsuario;
	echo "carpetaAutor:" .$carpetaAutor.'</br>';
	$carpetaFotoPerfil = $carpetaAutor."/fotoPerfil";
	echo "carpetaFotoPerfil:".$carpetaFotoPerfil.'</br>';
	$rutaFoto = $carpetaFotoPerfil."/".$nombreArchivoFoto;
	try{
		$sql = 'update usuario set rutaFoto="'.$rutaFoto.'" where idUsuario='.$idUsuario;
		//echo '</br>'.$nuevaPublicacion->getIdAutor();
		echo '</br>'.$sql.'</br>';
		//echo "¿Definido?". !empty($_FILES["file"]);
		$creacionProcedimiento = $consulta->conn->query($sql);
		if($creacionProcedimiento){
			
			if(!empty($_FILES["file"])){
				if (($_FILES["file"]["type"] == "image/pjpeg")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/png")
				|| ($_FILES["file"]["type"] == "image/gif")) {
				if (!file_exists($carpetaAutor)) {
					mkdir($carpetaAutor, 0777, true);
				}
				if (file_exists($carpetaFotoPerfil)) {
					$files = glob($carpetaFotoPerfil.'/*'); //obtenemos todos los nombres de los ficheros

					foreach($files as $file){
						if(is_file($file))
						unlink($file); //elimino el fichero
					}
					//rmdir($carpetaFotoPerfil);
				}
				if (!file_exists($carpetaFotoPerfil)) {
					mkdir($carpetaFotoPerfil, 0777, true);
				}
					$_FILES['file']['name'] = $rutaFoto;
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $rutaFoto)) {
						//more code here...
							echo $carpetaAutor."/".$_FILES['file']['name'];
					} else {
						echo 0;
					}
				} else {
					echo 0;
				}
				
				
			}
			echo "Foto cambiada con éxito";
		}
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error.";
		die();
	}
	
	
	
?>
<br/>
<!--<a id="volver" onclick=cargar("#panel","conexion.php") class="btn btn-primary">Volver</a>-->
<!--<a id="volver" onclick=window.location.href="index.php" class="btn btn-primary">Volver</a>-->
