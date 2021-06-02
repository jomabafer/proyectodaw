<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuarioConectado = $_POST['conectado'];
	$usuarioBloquear = $_POST['usuarioBloquear'];
	$consulta = new database;
	$sql = "insert into `bloqueoUsuarios` (`idBloquea`, `idBloqueado`) values (".$usuarioConectado.", ".$usuarioBloquear.")";
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			
			echo "Has bloqueado a esta persona.";
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>