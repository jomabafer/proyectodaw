<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
require("clases/publicacion.php");
//require("usarProcedimiento.php");
$idUsuario = $_POST["idUsuario"];
$consulta = new database;
//$procedimiento = new usarProcedimiento;
//$procedimiento->abrirProcedimiento("procedimientoPublicacion.txt");
//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
//$sql = 'select * from publicacion inner join publicacionAutor on publicacion.idPublicacion=publicacionAutor.idPublicacion inner join amistad on amistad.idAmigoAsociado=publicacionautor.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion';
//$publicaciones = array();
$publicacionesYautores = array();
$sql = 'select * from publicacion inner join amistad on amistad.idAmigoAsociado=publicacion.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion desc';
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$publicacion = $resultadobusqueda->fetch();
		
		if ($publicacion != null){
			while ($publicacion != null) {
				$registroPublicacion = new publicacion($publicacion[0],$publicacion[1], $publicacion[4], $publicacion[5], $publicacion[2]);
				$autorPublicacion = new usuario($publicacion[7], $publicacion[8], $publicacion[9], $publicacion[10], $publicacion[11], $publicacion[12], $publicacion[13],$publicacion[14], $publicacion[15]);
				$publicacionYautor = array($registroPublicacion, $autorPublicacion);
				$publicacionesYautores[]= $publicacionYautor;
				//echo $publicacion[9]. " ".$publicacion[10]. " ha escrito: <br/>".$publicacion[2]. "<br/> el día: ".$publicacion[1].'<br/>';				
				$publicacion = $resultadobusqueda->fetch();
				
			}
			
			$jsonPublicacionesYautores = json_encode($publicacionesYautores);
			echo $jsonPublicacionesYautores;
			
		}else{
			echo "Parece ser que todavía no hay publicaciones";
		}
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
?>