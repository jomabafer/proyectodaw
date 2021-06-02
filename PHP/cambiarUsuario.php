<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
$consulta = new database;
$idUsuario = $_POST["idUsuario"];

$sql = 'select tipo from  usuario  where idUsuario ='.$idUsuario;
//echo $sql;
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$registroUsuario = $resultadobusqueda->fetch();
		if ($registroUsuario != null){
			$tipo = $registroUsuario[0];
			if($tipo =="normal"){
				$sql = "UPDATE `usuario` SET `tipo`='admin' WHERE `idUsuario`=".$idUsuario;

			}else{
				$sql = "UPDATE `usuario` SET `tipo`='normal' WHERE `idUsuario`=".$idUsuario;
			}
			try{
				$resultadoCambio = $consulta->conn->query($sql);
				if ($resultadoCambio){
					echo "Cambio de privilegios realizado";
				}		
			}catch(Exception $e){
				echo $e->getMessage();
				echo "Ha habido un error en la base de datos.";
				die();
			}
			
			
		}else{
			echo "Ha habido un error al conocer los privilegios.";
		}
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
		
?>