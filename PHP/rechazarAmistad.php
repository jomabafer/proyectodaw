<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuarioConectado = $_POST['conectado'];
	$idPosibleAmistad = $_POST['solicitante'];
	$consulta = new database;
	$sql = "DELETE FROM `peticionamistad` WHERE `idPide`=".$idPosibleAmistad." AND idPedido=".$usuarioConectado."";
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
		
			echo "Solicitud de amistad rechazada.";
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>