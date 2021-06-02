<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
//require("publicacion.php");
//require("usarProcedimiento.php");
$idUsuario = $_POST["idUsuario"];
$consulta = new database;
$amistades = array();
$sql = 'select * from amistad inner join usuario on amistad.idAmigoasociado = usuario.idUsuario where amistad.idAmigo ='.$idUsuario.' order by apellidos';
try{
	/*Un objeto de tipo database ejecuta un método para ejecutar una consulta SQL que obtiene las
	amistades del usuario que se recibe mediante post*/
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$registroAmistad = $resultadobusqueda->fetch();
		
		if ($registroAmistad != null){
			while ($registroAmistad != null) {
				$amistad = new usuario($registroAmistad[2], $registroAmistad[3], $registroAmistad[4], $registroAmistad[5], $registroAmistad[6], $registroAmistad[7], $registroAmistad[8], $registroAmistad[9], $registroAmistad[10]);
				$amistades[]= $amistad;
				$registroAmistad = $resultadobusqueda->fetch();
				
			}
			
			
			for($i=0;$i<sizeof($amistades); $i++){
				//$dato = amistades[i];
				$amistadRescatada = $amistades[$i];
				//var $amistadRescatada = new usuario(dato.idUsuario,dato.nombre, dato.apellidos, dato.correoE, dato.fNacimiento, dato.poblacion, dato.tipo, dato.privacidad, dato.rutaFoto);
				echo "<a href='detallesUsuario.php?idUsuario=".$amistadRescatada->getIdUsuario()."' onclick = 'return modal(this.href)'>".$amistadRescatada->getNombre()." ".$amistadRescatada->getApellidos()."</a><br/>";
				
			}
			
		}else{//Mensaje que se mostrará si no se obtiene ninguna amistad.
			echo "Parece ser que aún no has agregado a nadie.";
		}
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
}
?>
