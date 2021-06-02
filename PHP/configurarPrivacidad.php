<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
$idUsuario = $_POST["usuario"];
$privacidad = $_POST["privacidad"];
$consulta = new database;
$sql = "UPDATE `usuario` SET `privacidad`='".$privacidad."' WHERE `idUsuario`=".$idUsuario;
try{
	$resultadoPrivacidad = $consulta->conn->query($sql);
	if ($resultadoPrivacidad){
		echo "Privacidad cambiada";
	}		
}catch(Exception $e){
	echo $e->getMessage();
	echo "Ha habido un error en la base de datos.";
	die();
}

?>