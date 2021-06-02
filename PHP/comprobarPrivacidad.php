<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
$idUsuario = $_POST["usuario"];
$consulta = new database;
$sql = "select privacidad from usuario where `idUsuario`=".$idUsuario;
try{
	$resultadoPrivacidad = $consulta->conn->query($sql);
	if ($resultadoPrivacidad){
		$registroPrivacidad = $resultadoPrivacidad->fetch();
		$privacidad = $registroPrivacidad[0];
		echo $privacidad;
	}		
}catch(Exception $e){
	echo $e->getMessage();
	echo "Ha habido un error en la base de datos.";
	die();
}
