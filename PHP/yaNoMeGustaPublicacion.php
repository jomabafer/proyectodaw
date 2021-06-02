<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuario = $_POST['usuario'];
	$publicacion = $_POST['publicacion'];
	$consulta = new database;
	$sql= "DELETE FROM `megustaFoto` WHERE `idUsuario`='".$usuario."' and`idFoto`='".$publicacion."'";
	/*echo $sql;
	echo "<br/>";*/
	try{
		
		$resultadoMeGusta = $consulta->conn->query($sql);
		if($resultadoMeGusta){
			echo "Ya no te gusta esta publicación";
		}else{
			echo "Error.";
		}
		
		$sql= "DELETE FROM `notificacionMeGusta` WHERE `idUsuario`='".$usuario."' and`idFoto`='".$publicacion."'";
		/*echo $sql;
		echo "<br/>";*/
		try{
			
			$resultadoMeGusta = $consulta->conn->query($sql);
			if($resultadoMeGusta){
				//echo "Ya no te gusta esta publicación";
			}else{
				echo "Error.";
			}
			
			
		}catch(Exception $error){
				echo $error;
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>
