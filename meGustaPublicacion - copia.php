<?php
	header('Content-type: text/html; charset=utf-8');
	require("database.php");
	$usuario = $_POST['usuario'];
	$publicacion = $_POST['publicacion'];
	$consulta = new database;
	//$sql = 'select idusuario from credencialesusuario where identificador="'.  $usuario .'"';
	$sql ="INSERT INTO `megustapublicacion` (`idUsuario`, `idPublicacion`) VALUES ('".$usuario."','".$publicacion."')";
	try{
		$resultadoMeGusta = $consulta->conn->query($sql);
		//$resultadoMeGusta = $consulta->conn->query($sql);
		/*if($idUsuarioEncontrado){
			$credencialUsuario = $idUsuarioEncontrado->fetch();
			$idUsuario = $credencialUsuario[0];
			echo "idUsuario=".$idUsuario;
			echo "<br/>";
			$sql ="INSERT INTO `megustapublicacion` (`idUsuario`, `idPublicacion`) VALUES (".$usuario.",".$publicacion.")";
			echo $sql;
			echo "<br/>";
			$resultadoMeGusta = $consulta->conn->query($sql);*/
			if($resultadoMeGusta){
				echo "Te gusta esta publicación";
				/*Escribir me gusta reciente en la tabla asociada correspondiente*/
				
			}else{
				echo "Error.";
			}
			
		/*}else{
			echo "Error.";
		}*/
		
		$sql ="INSERT INTO `notificacionMeGusta` (`idUsuario`, `idPublicacion`) VALUES (".$usuario.",".$publicacion.")";
		try{
			$resultadoMeGusta = $consulta->conn->query($sql);
			//$resultadoMeGusta = $consulta->conn->query($sql);
			/*if($idUsuarioEncontrado){
				$credencialUsuario = $idUsuarioEncontrado->fetch();
				$idUsuario = $credencialUsuario[0];
				echo "idUsuario=".$idUsuario;
				echo "<br/>";
				$sql ="INSERT INTO `megustapublicacion` (`idUsuario`, `idPublicacion`) VALUES (".$usuario.",".$publicacion.")";
				echo $sql;
				echo "<br/>";
				$resultadoMeGusta = $consulta->conn->query($sql);*/
				if($resultadoMeGusta){
					//echo "Te gusta esta publicación";
					/*Escribir me gusta reciente en la tabla asociada correspondiente*/
					
				}else{
					echo "Error.";
				}
				
			/*}else{
				echo "Error.";
			}*/
		}catch(Exception $error){
				echo $error;
		}
		
	}catch(Exception $error){
			echo $error;
	}
	
	

	
?>