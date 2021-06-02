<?php
	require("clases/database.php");
	require("clases/usuario.php");
	//require("publicacion.php");
	require("clases/foto.php");
	//require("usarProcedimiento.php");
	header('Content-type: text/html; charset=utf-8');
	/*echo "JSON RECIBIDO: ".$_POST["todo"];*/
	
	$fecha = json_decode(stripslashes($_POST["todo"]))->fecha;
	$permiso = json_decode(stripslashes($_POST["todo"]))->permiso;
	$idUsuario = $_POST["idUsuario"];

	$contenido = json_decode(stripslashes($_POST["todo"]))->contenido;
	/*echo "Contenido: ".$contenido;*/
	$nuevaPublicacion = new publicacion(0, $fecha, $permiso, $idUsuario, $contenido);

	//echo "Permiso: ".$permiso.". Contenido: ".$contenido.". idUsuario: ".$idUsuario;
	
	
	//$procedimiento = new usarProcedimiento;
	$consulta = new database;
	$almacenamientoPublicacion = false;
	try{
		$sql="";
		$sql = 'INSERT INTO PUBLICACION (`fPublicacion`, `contenido`, `idAutor`, `permiso`) VALUES ("'.$nuevaPublicacion->getFecha().'","'.$nuevaPublicacion->getContenido().'", '.$nuevaPublicacion->getIdAutor().', "'.$nuevaPublicacion->getPermiso().'")';
		
		
		//echo '</br>'.$nuevaPublicacion->getIdAutor();
		//echo '</br>'.$sql.'</br>';
		$creacionProcedimiento = $consulta->conn->query($sql);
		if($creacionProcedimiento){
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
