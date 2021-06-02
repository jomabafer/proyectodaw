<?php
header('Content-type: text/html; charset=utf-8');
require("clases/database.php");
require("clases/usuario.php");
$consulta = new database;
$amistades = array();
$sql = "select *  from usuario";
try{
	$resultadobusqueda = $consulta->conn->query($sql);
	if($resultadobusqueda){
			
			
		$registroUsuario = $resultadobusqueda->fetch();
		
		if ($registroUsuario != null){
			while ($registroUsuario != null) {
				$usuario = new usuario($registroUsuario[0], $registroUsuario[1], $registroUsuario[2], $registroUsuario[3], $registroUsuario[4], $registroUsuario[5], $registroUsuario[6], $registroUsuario[7], $registroUsuario[8]);
				$usuarios[]= $usuario;
				$registroUsuario = $resultadobusqueda->fetch();
				
			}
			
			//$jsonUsuarios = json_encode($usuarios); //Estas líneas se usaban para enviar
			//echo $jsonUsuarios; //el conjunto de usuarias y usuarios a Javascript.
			//echo count($amistades); Esto sólo se usó para probar algo.
			//echo "<a href='http://google.com'>GOOGLE</a>";
			echo "<table cellspacing='10'>";
			for($i=0;$i<sizeof($usuarios);$i++){
				//echo "<a href='http://google.com'>GOOGLE</a>";
				$usuarioRescatado = $usuarios[$i];
				echo "<tr>";
				/*Se crea un div con un enlace que mediante la captura del evento onclick abrirá una modal con el enlace
				del perfil del usuario*/
				echo "<td> <a href='detallesUsuario.php?idUsuario=".$usuarioRescatado->getIdUsuario()."' onclick = 'return modal(this.href)'>". $usuarioRescatado->getNombre()." ".$usuarioRescatado->getApellidos()."</a> </td>";
				/*Si el usuario no es admin (con id=3) se mostrarán opciones para modificar los privilegios del usuario o borrarlo.
				Esas tareas se harán también mediante la captura del evento onclick para llamar a las funciones pertinentes.*/
				if($usuarioRescatado->getIdUsuario()!=3){
					//divUsuarios.append("<button onclick='cambiarTipoUsuario("+usuarioRescatado.getIdUsuario()+")'>Convertir en administrador</button>");
					if($usuarioRescatado->getTipo()=="normal"){
						echo "<td> <button onclick='cambiarTipoUsuario(".$usuarioRescatado->getIdUsuario().")' class='btn btn-primary botonLista'>Dar privilegios</button> </td>";
					}else{
						echo "<td> <button onclick='cambiarTipoUsuario(".$usuarioRescatado->getIdUsuario().")' class='btn btn-primary botonLista'>Quitar privilegios</button> </td>";
					}
					echo "<td> <button onclick='eliminarUsuario(".$usuarioRescatado->getIdUsuario().")' class='btn btn-primary'>Eliminar usuario</button> </td>";
				}
				echo "</tr>";
			}
			echo "</table>";
				
		}else{
			echo "Parece ser que aún no has agregado a nadie.";
		}
	}
}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}
?>