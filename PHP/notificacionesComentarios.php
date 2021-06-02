<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	require("clases/usuario.php");
	require("clases/publicacion.php");
	//$publicacion = $_POST['publicacion'];
	$usuario = $_POST['usuario'];
	//echo $usuario;
	$consulta = new database;
	$sql = 'SELECT * FROM redsocial.notificacioncomentario inner join usuario on usuario.idUsuario = notificacioncomentario.idUsuario inner join comentariopublicación on comentariopublicación.idPublicacion = notificacioncomentario.idPublicacion inner join publicacion on publicacion.idPublicacion = notificacioncomentario.idPublicacion where publicacion.idAutor='.$usuario;
	
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			//echo "La consulta se ha ejecutado";
			$registroComentando = $consultaEjecutada->fetch();
				
			if ($registroComentando != null){
				echo "Se han encontrado notificaciones de comentarios: <br/>";
				while ($registroComentando != null) {
					$personaComenta = new usuario($registroComentando[2], $registroComentando[3], $registroComentando[4], $registroComentando[5], $registroComentando[6], $registroComentando[7], $registroComentando[8], $registroComentando[9]);
					//$publicacionComentada = new publicacion($registroComentando[2],$registroComentando[3],$registroComentando[4],$registroComentando[5],$registroComentando[6]);
					$publicacionComentada = $registroComentando[1];
					$personasComentan[]= $personaComenta;
					$publicacionesComentadas[] = $publicacionComentada;
					$registroComentando = $consultaEjecutada->fetch();
					
				}
				
				/*$jsonAmistades = json_encode($amistades);
				echo $jsonAmistades; No lo voy a mostrar por JS de momento.*/
				//echo count($amistades);
				
				for($i=0;$i<count($personasComentan); $i++){
					echo "<a href='detallesUsuario.php?idUsuario=".$personasComentan[$i]->getIdUsuario()."' onclick = 'return nuevaPestanha(this.href)'>".$personasComentan[$i]->getNombre()." ".$personasComentan[$i]->getApellidos().":</a> Le gusta tu <a href='detallesPublicacion.php?idPublicacion=".$publicacionesComentadas[$i]."' onclick = 'return nuevaPestanha(this.href)'>publicación.</a><br/>";
				}
				
			}
			
			//Temporalmente comentado $sql ="DELETE FROM `notificacionMeGusta` WHERE  `idPublicacion` in (select `idPublicacion` from publicacion where `idAutor` = ".$usuario.")";
			try{
				//Temporalmente comentado $BorradoNotificacion = $consulta->conn->query($sql);
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
					/*Temporalmente comentado if($BorradoNotificacion){
						//echo "Te gusta esta publicación";
						//Escribir me gusta reciente en la tabla asociada correspondiente
						
					}else{
						echo "Error.";
					}*/
					
				/*}else{
					echo "Error.";
				}*/
			}catch(Exception $error){
					echo $error;
			}

			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}