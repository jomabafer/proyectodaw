<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	require("clases/usuario.php");
	$usuarioConectado = $_POST['usuarioConectado'];
	//echo "usuarioConectado: ".$usuarioConectado;
	$consulta = new database;
	$situacionAmistad="";
	//$sql = 'select * from peticionamistad where idPedido = '.$usuarioConectado;
	$sql = 'select * from redsocial.usuario where idusuario in (select idPide from redsocial.peticionamistad where idPedido = '.$usuarioConectado.')';
	//echo $sql;
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
			/*$idUsuarioPide = $peticionamistad[0];
			$idUsuarioPedido = $peticionamistad[1];
			//echo "El idUsuario es: ". $idUsuario."<br/>";
			if(($idUsuarioPide!=null)&($idUsuarioPedido!=null)){
				$situacionAmistad = "Solicitud de amistad enviada";
				//echo $situacionAmistad;
			}*/
			

			if ($peticionamistad != null){
				while ($peticionamistad != null) {
					$peticion = new usuario($peticionamistad[0], $peticionamistad[1] ,$peticionamistad[2], $peticionamistad[3], $peticionamistad[4], $peticionamistad[5], $peticionamistad[6], $peticionamistad[7], $peticionamistad[8]);
					$peticiones[]= $peticion;
					$peticionamistad = $consultaEjecutada->fetch();
					
				}
				
				
				for($i=0;$i<sizeof($peticiones); $i++){
					//$dato = amistades[i];
					$peticionRescatada = $peticiones[$i];
					//var $amistadRescatada = new usuario(dato.idUsuario,dato.nombre, dato.apellidos, dato.correoE, dato.fNacimiento, dato.poblacion, dato.tipo, dato.privacidad, dato.rutaFoto);
					echo "<li><a class='dropdown-item' href='detallesUsuario.php?idUsuario=".$peticionRescatada->getIdUsuario()."' onclick = 'return modal(this.href)'>".$peticionRescatada->getNombre()." ".$peticionRescatada->getApellidos()." te ha enviado una solicitud de amistad</a></li>";
					
				}
				
			}else{//Mensaje que se mostrará si no se obtiene ninguna amistad.
				echo "<li><a class='dropdown-item' href='#'>Por ahora no hay nada</a></li>";
			}


		}else{
			echo "Error.";
		}
	}catch(Exception $error){
		echo $error;
	}
	
	//echo $situacionAmistad;
?>
