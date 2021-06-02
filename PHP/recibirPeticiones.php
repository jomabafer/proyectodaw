<?php
	header('Content-type: text/html; charset=utf-8');
	require("clases/database.php");
	require("clases/usuario.php");
	$usuario = $_POST['usuario'];
	$consulta = new database;
	$sql = 'select * from peticionamistad inner join usuario on peticionamistad.idpide=usuario.idusuario where idPedido = '.$usuario;
	//$amistadesEncontradas;
	try{
		/*Se ejecuta una consulta SQL a la tablas peticiónamistad y usuario cuyas claves coincidan con el 
		parámetro pasado mediante post*/
		$consultaEjecutada = $consulta->conn->query($sql);
		if($consultaEjecutada){
			$peticionamistad = $consultaEjecutada->fetch();
				
			if ($peticionamistad != null){
				while ($peticionamistad != null) {
					
					$usuarioEncontrado = new usuario($peticionamistad[2], $peticionamistad[3], $peticionamistad[4], $peticionamistad[5], $peticionamistad[6], $peticionamistad[7], $peticionamistad[8],$peticionamistad[9], $peticionamistad[10]);
					$amistadesEncontradas[] = $usuarioEncontrado;
					$peticionamistad = $consultaEjecutada->fetch();
					
				}
				
				/*Una vez ejecutada de forma correcta la consulta se rescatan los usuarios que contiene y se
				empaquetan en un vector para ser mostrados en un enlave que llama a un método que abre a una
				modal*/
				
				echo "<li>Solicitudes de amistad:</li>";
				for($i=0;$i<sizeof($amistadesEncontradas); $i++){
					$nuevoAmigo = $amistadesEncontradas[$i];
					echo $nuevoAmigo->getApellidos();
					echo "<a href='detallesUsuario.php?idUsuario=".$amistadesEncontradas[$i]->getIdUsuario()."' onclick = 'return modal(this.href)'>".$amistadesEncontradas[$i]->getNombre()." ".$amistadesEncontradas[$i]->getApellidos().":</a> quiere ser tu amigx.<br/>";
					
				}
				
			}
			
			
		}else{
			echo "Error.";
		}
	}catch(Exception $error){
			echo $error;
	}
	
?>	