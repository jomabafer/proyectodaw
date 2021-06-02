<?php
	require("database.php");
	require("usuario.php");
	require("foto.php");
	require("usarProcedimiento.php");
	header('Content-type: text/html; charset=utf-8');
	$rutaFoto = $_POST["rutaFoto"];
	echo "Ruta foto: ".$_POST["rutaFoto"]."<br/>";
	/*$fecha = json_decode(stripslashes($_POST["datosFoto"]))->fecha;
	$permiso = json_decode(stripslashes($_POST["datosFoto"]))->permiso;
	$rutaFoto = json_decode(stripslashes($_POST["datosFoto"]))->rutaFoto;
	$texto = json_decode(stripslashes($_POST["datosFoto"]))->texto;*/
	$idUsuario = $_POST["idUsuario"];
	//echo "<br/>"."idUsuario: ".$idUsuario."<br/>";
	//echo $_POST['textoPublicacion'];
	//echo "Permiso: ".$permiso.". Contenido: ".$contenido.". idUsuario: ".$idUsuario;
	//echo "Ruta de la foto: ".$rutaFoto;
	//$nuevaFoto = new foto(0, $fecha, $permiso, $idUsuario, $rutaFoto, $texto);
	$procedimiento = new usarProcedimiento;
	$consulta = new database;
	$almacenamientoPublicacion = false;
	try{
		$sql = 'update usuario set rutaFoto="'.$rutaFoto.'" where idUsuario='.$idUsuario;
		//echo '</br>'.$nuevaPublicacion->getIdAutor();
		echo '</br>'.$sql.'</br>';
		//echo "¿Definido?". !empty($_FILES["file"]);
		$creacionProcedimiento = $consulta->conn->query($sql);
		if($creacionProcedimiento){
			if(!empty($nuevaFoto->getTexto())){
				echo $nuevaFoto->getTexto();
			}
			if(!empty($_FILES["file"])){
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
				
				
			}
			echo "Publicación realizada con éxito";
		}
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos (al publicar).";
		die();
	}
	
	
	
?>
<br/>
<!--<a id="volver" onclick=cargar("#panel","conexion.php") class="btn btn-primary">Volver</a>-->
<a id="volver" onclick=window.location.href="index.php" class="btn btn-primary">Volver</a>
