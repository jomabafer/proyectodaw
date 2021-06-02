<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
$consulta = new database;
$idUsuario = $_POST["idUsuario"];
$sql = "DELETE FROM `usuario` WHERE `idUsuario`=".$idUsuario;
//echo $sql;
try{
	$resultadoEliminacion = $consulta->conn->query($sql);
	if($resultadoEliminacion){
		echo "Se ha eliminado correctamente";
		
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
		
?>