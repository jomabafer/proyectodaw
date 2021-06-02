<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
//require("publicacion.php");
//require("usarProcedimiento.php");
$idUsuario = $_POST["idUsuario"];
$consulta = new database;
//$amistades = array();
$sql = 'select count(*) from amistad inner join usuario on amistad.idAmigoasociado = usuario.idUsuario where amistad.idAmigo ='.$idUsuario.' order by apellidos';
try{
	/*Un objeto de tipo database ejecuta un método para ejecutar una consulta SQL que obtiene las
	amistades del usuario que se recibe mediante post*/
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$numeroAmistades = $resultadobusqueda->fetch();
		
		if ($numeroAmistades != null){
			$numero = $numeroAmistades[0];
			if($numero!=0){
				echo "Tienes ". $numero ." personas agregadas.</br>";
			}else{
				echo "";
			}
			
			
		}else{//Mensaje que se mostrará si no se obtiene ninguna amistad.
			echo "Error.";
		}
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
}
?>
