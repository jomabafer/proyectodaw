<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuarioConectado = $_POST['conectado'];
	$usuarioDesbloquear = $_POST['usuarioDesbloquear'];
	$consulta = new database;
	//$sql = "delete from `redsocial`.`bloqueoUsuarios` where (`idBloquea`='".$usuarioConectado."') and (`idBloqueado`='".$usuarioDesbloquear."');";
	$sql = 'delete from `redSocial`.`bloqueoUsuarios` WHERE (`idBloquea` = '.$usuarioConectado.') and (`idBloqueado` = '.$usuarioDesbloquear.')';
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			
			echo "Has desbloqueado a esta persona.";
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>