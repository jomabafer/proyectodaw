<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuarioConectado = $_POST['conectado'];
	$idPosibleAmistad = $_POST['solicitante'];
	$consulta = new database;
	$sql = "INSERT INTO `amistad` (`idAmigo`, `idAmigoAsociado`) VALUES (".$usuarioConectado.",".$idPosibleAmistad.")";
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
		
			$sql = "INSERT INTO `amistad` (`idAmigo`, `idAmigoAsociado`) VALUES (".$idPosibleAmistad.",".$usuarioConectado.")";
			try{
				$consultaEjecutada = $consulta->conn->query($sql);
				if($consultaEjecutada){
					$sql = "DELETE FROM `peticionamistad` WHERE `idPide`=".$idPosibleAmistad." AND idPedido=".$usuarioConectado."";
					//echo $sql;
					try{
						$consultaEjecutada = $consulta->conn->query($sql);
						if($consultaEjecutada){
							echo "Confirmación de amistad completada.";
							
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
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>