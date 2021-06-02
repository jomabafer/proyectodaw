<?php
	header('Content-type: text/html; charset=utf-8');
	require("database.php");
	$usuario = $_POST['usuario'];
	$publicacion = $_POST['publicacion'];
	$consulta = new database;
	$sql = 'select idusuario from credencialesusuario where identificador='.  $usuario .'';
	echo $sql;
	echo "<br/>";
	try{
		$idUsuarioEncontrado = $consulta->conn->query($sql);
		if($idUsuarioEncontrado){
			$credencialUsuario = $idUsuarioEncontrado->fetch();
			$idUsuario = $credencialUsuario;
			$sql= "DELETE FROM `megustapublicacion` WHERE `idUsuario`='".$idUsuario."' and`idPublicacion`='".$publicacion."'";
			//$sql ="INSERT INTO `megustapublicacion` (`idUsuario`, `idPublicacion`) VALUES (".$idUsuario.",".$publicacion.")";
			echo $sql;
			echo "<br/>";
			$resultadoMeGusta = $consulta->conn->query($sql);
			if($resultadoMeGusta){
				echo "Ya no te gusta esta publicación";
			}else{
				echo "Error.";
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>