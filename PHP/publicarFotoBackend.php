<?php
	require("clases/database.php");
	require("clases/usuario.php");
	require("clases/foto.php");
	//require("usarProcedimiento.php");
	header('Content-type: text/html; charset=utf-8');
	
	//echo "Datos recibidos: ".$_POST["datosFoto"]."<br/>";
	$fecha = json_decode(stripslashes($_POST["datosFoto"]))->fecha;
	$permiso = json_decode(stripslashes($_POST["datosFoto"]))->permiso;
	$rutaFoto = json_decode(stripslashes($_POST["datosFoto"]))->rutaFoto;
	$texto = json_decode(stripslashes($_POST["datosFoto"]))->texto;
	$idUsuario = $_POST["idUsuario"];
	//echo "<br/>"."idUsuario: ".$idUsuario."<br/>";
	//echo $_POST['textoPublicacion'];
	//echo "Permiso: ".$permiso.". Contenido: ".$contenido.". idUsuario: ".$idUsuario;
	//echo "Ruta de la foto: ".$rutaFoto;
	$nuevaFoto = new foto(0, $fecha, $permiso, $idUsuario, $rutaFoto, $texto);
	//$procedimiento = new usarProcedimiento;
	$consulta = new database;
	$almacenamientoPublicacion = false;
	try{
		$sql = 'insert into foto (`fFoto`, `rutaFoto`, `idAutor`, `permiso`, `contenido`) VALUES ("'.$nuevaFoto->getFecha().'","'.$nuevaFoto->getRutaFoto().'", '.$nuevaFoto->getIdAutor().', "'.$nuevaFoto->getPermiso().'","'.$nuevaFoto->getTexto().'");';
		//echo '</br>'.$nuevaPublicacion->getIdAutor();
		//echo '</br>'.$sql.'</br>';
		//echo "¿Definido?". !empty($_FILES["file"]);
		$creacionProcedimiento = $consulta->conn->query($sql);
		if($creacionProcedimiento){
			if(!empty($nuevaFoto->getTexto())){
				//echo $nuevaFoto->getTexto()."<br/>"; Se va a mostrar una alerta, así que no es necesario mostrar el texto.
			}
			if(!empty($_FILES["file"])){
				if (($_FILES["file"]["type"] == "image/pjpeg")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/png")
				|| ($_FILES["file"]["type"] == "image/gif")) {
				$carpetaAutor = "../imagenes/".$nuevaFoto->getIdAutor();
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
				
			}
			echo "Publicación realizada con éxito";
		}
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos (al publicar).";
		die();
	}
	
	
	echo '<br/>
<a id="volver" onclick=window.location.href="index.php" class="btn btn-primary">Volver</a>';

?>
