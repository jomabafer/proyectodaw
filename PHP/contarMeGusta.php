<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	//$usuario = $_POST['usuario'];
	$idFoto = $_POST['idFoto'];
	$consulta = new database;
	$sql = 'select count(*) from megustaFoto where idFoto = '.$idFoto;
	
	try{
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$numero = $consultaEjecutada->fetch();
			$codigoMeGusta = "<i class='la la-heart'/>".$numero[0];
			$MegustaYnFoto = array($codigoMeGusta, $idFoto);
			$jsonMegustaYnFoto = json_encode($MegustaYnFoto);
			echo $jsonMegustaYnFoto;
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}

	
?>
