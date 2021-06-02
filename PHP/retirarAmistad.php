<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuarioConectado = $_POST['conectado'];
	$amigoBorrar = $_POST['amigoBorrar'];
	$consulta = new database;
	$sql = "DELETE FROM `amistad` WHERE `idAmigoAsociado`=".$amigoBorrar." AND idAmigo=".$usuarioConectado."";
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			
			$sql = "DELETE FROM `amistad` WHERE `idAmigo`=".$amigoBorrar." AND idAmigoAsociado=".$usuarioConectado."";
			try{
				$consultaEjecutada = $consulta->conn->query($sql);
				if($consultaEjecutada){
				
					echo "Se ha borrado de tu lista de amigas y amigos.";
					
				}else{
					echo "Error.";
				}
			}catch(Exception $error){
					echo $error;
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>