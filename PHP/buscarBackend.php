<?php
/*<!-- Creo que esto va a ser un cuadro que ocultable que mostrará los resultados
select * from usuario where concat (nombre, " ", apellidos) like "%ad%" and concat(nombre, " ", apellidos) like "%min%";
select * from usuario where correoE = "admin@admin.admin";
select * from usuario where poblacion = "adra"-->*/
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
//require("publicacion.php");
//require("usarProcedimiento.php");
//echo "Hola<br/>";
$nombre;
$apellidos;
$correoE;
$poblacion;
if($_POST["nombre"]!=""){
	$nombre = $_POST["nombre"];
	//echo "Nombre: ". $nombre.'<br/>';
}
if($_POST["apellidos"]!=""){
	$apellidos = $_POST["apellidos"];
	//echo "Apellidos: ".$apellidos.'<br/>';
}
if($_POST["correoE"]!=""){
	$correoE = $_POST["correoE"];
	//echo "Correo electrónico: ".$correoE.'<br/>';
}
if($_POST["poblacion"]!=""){
	$poblacion = $_POST["poblacion"];
	//echo "Población: ".$poblacion.'<br/>';
}
//echo "Ha entrado".'<br/>';
$consulta = new database;
//$procedimiento = new usarProcedimiento;
//$procedimiento->abrirProcedimiento("procedimientoPublicacion.txt");
//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
//$sql = 'select * from publicacion inner join publicacionAutor on publicacion.idPublicacion=publicacionAutor.idPublicacion inner join amistad on amistad.idAmigoAsociado=publicacionautor.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion';
$concretarBusqueda = false;
if(isset($nombre)){
	$sql='select * from usuario where concat (nombre, " ", apellidos) like "%'.$nombre.'%"';
	$concretarBusqueda = true;
}
if(isset($apellidos)){
	$sql = $sql. ' and concat(nombre, " ", apellidos) like "%'.$apellidos.'%"';
}
if (isset($poblacion)){
	if ($concretarBusqueda){
		$sql = $sql. ' and poblacion="'.$poblacion.'"';
	}else{
		$sql = 'select * from usuario where poblacion="'.$poblacion.'"';
	}
}

if(isset($correoE)){
	$sql = 'select * from usuario where correoE="'.$correoE.'"';
}

if(!isset($nombre)&!isset($apellidos)&!isset($correoE)&!isset($poblacion)){
	$sql="";
}
//echo $sql.'<br/>';
//$sql = 'select * from usuario where concat (nombre, " ", apellidos) like'.$nombre.'and concat(nombre, " ", apellidos) like '.$segundoDato.' and correoE="'.$correoE.'" and poblacion="'.$poblacion.'"';
$usuariosBusqueda = array();
if($sql!=""){
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$registroUsuarios = $resultadobusqueda->fetch();
		
		if ($registroUsuarios != null){
			while ($registroUsuarios != null) {
				//echo "Número de personas encontradas:".sizeof($registroUsuarios);
				/*echo "Nº identificación".$registroUsuarios[0];
				echo '<br/>';
				echo "Nombre: ".$registroUsuarios[1];
				echo '<br/>';
				echo "Apellidos: ".$registroUsuarios[2];
				echo '<br/>';
				echo "Correo electrónico: ".$registroUsuarios[3];
				echo '<br/>';
				echo "Fecha de nacimiento: ".$registroUsuarios[4];
				echo '<br/>';
				echo "Población: ".$registroUsuarios[5];
				echo '<br/>';
				echo "Tipo: ".$registroUsuarios[6];
				echo '<br/>';
				echo "Privacidad: ".$registroUsuarios[7];
				echo '<br/>';
				echo "<img src='".$registroUsuarios[8]."'/>";
				echo '<br/>';*/
				/*for($i=0; $i=sizeof($registroUsuarios); $i++){
					echo $registroUsuarios[i];
					echo '<br/>';
				}*/
				$amistad = new usuario($registroUsuarios[0], $registroUsuarios[1], $registroUsuarios[2], $registroUsuarios[3], $registroUsuarios[4], $registroUsuarios[5], $registroUsuarios[6], $registroUsuarios[7],$registroUsuarios[8]);
				$usuarios[]= $amistad;
				/*echo "Nombre del objeto creado: ". $amistad->getNombre();
				echo '<br/>';*/
				//echo $publicacion[9]. " ".$publicacion[10]. " ha escrito: <br/>".$publicacion[2]. "<br/> el día: ".$publicacion[1].'<br/>';				
				$registroUsuarios = $resultadobusqueda->fetch();
				
			}
			
			$jsonUsuarios = json_encode($usuarios);
			//echo $jsonUsuarios;
			//echo count($amistades);

			for($i=0; $i<sizeof($usuarios); $i++){
				$dato = $usuarios[$i];
				//$amistadRescatada = new usuario(dato.idUsuario,dato.nombre, dato.apellidos, dato.correoE, dato.fNacimiento, dato.poblacion, dato.tipo);
				echo "<a href='detallesUsuario.php?idUsuario=".$dato->getIdUsuario()."'>".$dato->getNombre()." ".$dato->getApellidos()."</a><br/>";
			}
			
		}else{
			echo "Parece ser que no hay nadie con esos datos.";
		}
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
}else{
	echo "Debes rellenar algún campo";
}
?>