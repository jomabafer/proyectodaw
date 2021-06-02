<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	//require("usarProcedimiento.php");
	$usuario = $_POST['usuario'];
	$foto = $_POST['publicacion'];
	$comentario = $_POST['comentario'];
	$fhComentario = $_POST['fhComentario'];
	$consulta = new database;
	

	$sql =		"insert into comentarioFoto (`idUsuario`, `idFoto`, `fHcomentario`, `contenido`) VALUES(".$usuario.",".$foto.",'".$fhComentario."','".$comentario."')";
	//echo $sql;
	$consulta = new database;
	try{
		$resultadoMeGusta = $consulta->conn->query($sql);
		if($resultadoMeGusta){
			echo "Publicación comentada.";
			
		}else{
			echo "Error.";
		}
					
				/*}else{
					echo "Error.";
				}*/
		}catch(Exception $error){
					echo $error;
		}
	
		
	

	
?>
