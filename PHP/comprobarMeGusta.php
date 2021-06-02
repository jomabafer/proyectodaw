<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuario = $_POST['usuario'];
	$publicacion = $_POST['publicacion'];
	$consulta = new database;
	$sql = 'select * from megustaFoto where idUsuario='.  $usuario .' and idFoto = '.$publicacion;
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

	
?>
