<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
$retira = $_POST["retira"];
$retirado = $_POST["retirado"];
$consulta = new database;
//echo "El usuario ".$pide." pide amistad al usuario ".$pedido;
$sql ="DELETE FROM `peticionamistad` WHERE `idPide`=".$retira." and`idPedido`=".$retirado.";";
	try{
		$resultadoPeticion = $consulta->conn->query($sql);
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
			if($resultadoPeticion){
				echo "Solicitud de amistad retirada.";
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