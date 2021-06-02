<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	$usuarioConectado = $_POST['usuarioConectado'];
	$idPosibleAmistad = $_POST['idPosibleAmistad'];
	//echo "usuarioConectado: ".$usuarioConectado;
	$consulta = new database;
	$situacionAmistad="";
	$sql = 'select * from peticionamistad where idPide='.  $usuarioConectado .' and idPedido = '.$idPosibleAmistad;
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
			$idUsuarioPide = $peticionamistad[0];
			$idUsuarioPedido = $peticionamistad[1];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if(($idUsuarioPide!=null)&($idUsuarioPedido!=null)){
				$situacionAmistad = "Solicitud de amistad enviada";
				//echo $situacionAmistad;
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}
	
	
	$sql = 'select * from peticionamistad where idPide='.$idPosibleAmistad.' and idPedido = '.$usuarioConectado;
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
			$idUsuarioPide = $peticionamistad[1];
			$idUsuarioPedido = $peticionamistad[0];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if(($idUsuarioPide!=null)&($idUsuarioPedido!=null)){
				$situacionAmistad = "Confirmar solicitud de amistad.";
				//echo $situacionAmistad;
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}
	
	
	$sql = 'select * from amistad where idAmigo='.  $usuarioConectado .' and idAmigoAsociado = '.$idPosibleAmistad;
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
			$idUsuarioPide = $peticionamistad[0];
			$idUsuarioPedido = $peticionamistad[1];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if(($idUsuarioPide!=null)&($idUsuarioPedido!=null)){
				$situacionAmistad = "Amistad confirmada.";
				//echo $situacionAmistad;
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}
	
	$sql = 'select * from bloqueoUsuarios where idBloqueado='.  $usuarioConectado .' and idBloquea = '.$idPosibleAmistad;
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
			$idUsuarioPide = $peticionamistad[0];
			$idUsuarioPedido = $peticionamistad[1];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if(($idUsuarioPide!=null)&($idUsuarioPedido!=null)){
				$situacionAmistad = "No puedes acceder a este perfil porque te ha bloqueado.";
				//echo $situacionAmistad;
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}
	
	$sql = 'select * from bloqueoUsuarios where idBloqueado='.$idPosibleAmistad.' and idBloquea = '.$usuarioConectado;
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
			$idUsuarioPide = $peticionamistad[0];
			$idUsuarioPedido = $peticionamistad[1];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if(($idUsuarioPide!=null)&($idUsuarioPedido!=null)){
				$situacionAmistad = "Has bloqueado a esta persona.";
				
			}
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	echo $situacionAmistad;
?>
