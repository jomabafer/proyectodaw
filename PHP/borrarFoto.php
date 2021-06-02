<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/foto.php");
$idPublicacion = $_POST["idPublicacion"];
$consulta = new database;
/*Antes de eliminar el registro de la base de datos hace falta obtener le ruta en esa base de datos*/
$sql = 'select * from foto where idFoto ='.$idPublicacion;
//echo $sql;
try{
	$resultadoFoto = $consulta->conn->query($sql)->fetch();
	$fotoEliminar = new foto($resultadoFoto[0],$resultadoFoto[1], $resultadoFoto[4], $resultadoFoto[3], $resultadoFoto[2], $resultadoFoto[5]);
	$rutaEliminar = "imagenes/".$fotoEliminar->getIdAutor()."/".$fotoEliminar->getRutaFoto();
	//echo $rutaEliminar;
}catch(Exception $e){
	echo $e->getMessage();
	echo "Ha habido un error en la base de datos.";
	die();
}

$sql = 'delete from foto where idFoto ='.$idPublicacion;
//echo $sql;
try{
	/*Un objeto de tipo database ejecuta un método para ejecutar una consulta SQL que obtiene las
	amistades del usuario que se recibe mediante post*/
	$resultadoBorrado = $consulta->conn->query($sql);
	if($resultadoBorrado){
		//echo $rutaEliminar;
		if (file_exists($rutaEliminar)) {
			$files = glob($rutaEliminar); //obtenemos todos los nombres de los ficheros

			foreach($files as $file){
				if(is_file($file))
				unlink($file); //elimino el fichero
			}
			//rmdir($carpetaFotoPerfil);
		}	
		echo "Publicación borrada";
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
}
?>
