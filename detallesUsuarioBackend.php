<html>
<head>
	<script src="JS/jquery-3.4.1.js" defer></script>
	<script src="JS/clases/publicacion.js" defer></script>
	<script src="JS/clases/foto.js" defer></script>
	<script src="JS/clases/usuario.js" defer></script>
	<script src="JS/detalles.js" defer></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
	<link rel="stylesheet" href="css/estilo.css">
	<style>
	
		div.fileinputs {
			position: relative;
		}

		div.fakefile {
			position: absolute;
			top: 0px;
			left: 0px;
			z-index: 1;
		}

		input.file {
			position: relative;
			text-align: right;
			-moz-opacity:0 ;
			/*filter:alpha(opacity: 0);*/
			opacity: 0;
			z-index: 2;
		}

	</style>
</head>
<body>
<input type='hidden' id='tipoDetalles' value='detallesUsuario' />

<?php
header('Content-type: text/html; charset=utf-8');
require("database.php");
require("usuario.php");
require("publicacion.php");
//require("usarProcedimiento.php");
$idUsuario = $_GET["idUsuario"];
$consulta = new database;
$autorizacionVer = true;
$autorizacionPublicaciones = true;
//echo $autorizacionVer;

session_start();
?>
<input id="usuarioVisitado" type="hidden" value=<?php echo $idUsuario; ?> />
<?php
//$procedimiento = new usarProcedimiento;
//$procedimiento->abrirProcedimiento("procedimientoPublicacion.txt");
//$sql = 'select * from publicacion where idPublicacion in (select idPublicacion from publicacionAutor where idAutor in (select idAmigoAsociado from amistad where idAmigo = '.$idUsuario.')) order by fpublicacion';
//$sql = 'select * from publicacion inner join publicacionAutor on publicacion.idPublicacion=publicacionAutor.idPublicacion inner join amistad on amistad.idAmigoAsociado=publicacionautor.idAutor inner join usuario on usuario.idUsuario = amistad.idAmigoAsociado where idAmigo='.$idUsuario.' order by fpublicacion';
if(!empty($_SESSION['usuario'])&!empty($_SESSION['clave'])){
	$usuario=$_SESSION['usuario'];
	$clave=$_SESSION['clave'];
	$sql = "select * from credencialesusuario where identificador = '".$usuario."'";
	$resultadobusqueda = $consulta->conn->query($sql);
	if ($resultadobusqueda){
		$credencialUsuario = $resultadobusqueda->fetch();
		$usuarioConectado = $credencialUsuario[0];
		?>
		<input id="usuarioConectado" type="hidden" value=<?php echo $usuarioConectado; ?> />
		<?php
		if($usuarioConectado==$idUsuario){
			?>
			<form id="confPrivacidad">
				<select id="privacidadUsuario">
					<option id="amigos" value="amigos">Sólo mis amistades pueden ver mis publicaciones</option>
					<option id="publico" value="publico" >Todo el mundo puede ver mis publicaciones</option>
				</select>
				<br/>
				<input type="submit" value="Modificar" >
			</form>
			<!--<input type=file value="Cambiar foto de perfil"></input>-->
			<div class="fileinputs">
				<input  id="archivo" type="file" class="file" onchange="escribirTexto()"/>
				<div class="fakefile" id="fakefile">
					<!-- <input type="hidden"/>
					<img src="button_select.gif" /> -->
					Cambiar imagen de perfil <div id="archivoSeleccionado"></div>
				</div>
				
			</div>
			<?php
	}else{
		?>
		<div id="divAmistad">
			<a id="peticionAmistad" href="#" >Pedir amistad</a>
			<br/>
			<a id="cancelarAmistad" href="#"></a>
		</div>
		<br/>
		<?php
		$sql = "SELECT * FROM bloqueousuarios where idBloqueado=".$usuarioConectado." and idBloquea=".$idUsuario;
		try{
		$resultadobusqueda = $consulta->conn->query($sql);
			if ($resultadobusqueda){
				$registroBloqueo = $resultadobusqueda->fetch();
				if ($registroBloqueo != null){
					$autorizacionVer = false;
					$autorizacionPublicaciones = false;
					//echo $autorizacionVer;
				}else{
					$sql = "select privacidad from usuario where idusuario =".$idUsuario;
					//echo $sql;
					try{
						$resultadoPrivacidad = $consulta->conn->query($sql);
						if ($resultadoPrivacidad){
							$registroPrivacidad = $resultadoPrivacidad->fetch();
							$privacidadUsuario = $registroPrivacidad[0];
							if ($privacidadUsuario == "amigos"){
							
								$sql = "select * from amistad where idAmigo=".$usuarioConectado." and idAmigoAsociado=".$idUsuario;
								//echo $sql;
								$comprobacionAmistad = $consulta->conn->query($sql);
								$registroAmistad = $comprobacionAmistad->fetch();
								if($registroAmistad[0]==null){
									$autorizacionPublicaciones = false;
								}
							}
						}
							
					}catch(Exception $e){
						echo $e->getMessage();
						echo "Ha habido un error en la base de datos.";
						die();
					}
				}
			}
		}catch(Exception $e){
			echo $e->getMessage();
			echo "Ha habido un error en la base de datos.";
			die();
		}
	}
}
	
}

if($autorizacionVer==true){
?>
	<div id="datosPersonales"></div>
<?php
}

//echo $autorizacionVer;
if($autorizacionPublicaciones==true){
?>	<div id="listaPublicaciones"></div>
	<?php
	/*$sql = 'select * from  usuario  where idUsuario ='.$idUsuario;
	try{
		$resultadobusqueda = $consulta->conn->query($sql);
		if($resultadobusqueda){
				
				
			$registroUsuario = $resultadobusqueda->fetch();
			if ($registroUsuario != null){
				$usuario = new usuario($registroUsuario[0], $registroUsuario[1], $registroUsuario[2], $registroUsuario[3], $registroUsuario[4], $registroUsuario[5], $registroUsuario[6]);
				
				
				echo "Nombre: ".$usuario->getNombre()." ".$usuario->getApellidos().".<br/>";
				echo "Fecha de nacimiento: ".$usuario->getFnacimiento().".<br/>";
				echo "Correo electrónico: ".$usuario->getCorreoE().".<br/>";
				echo "Población: ".$usuario->getPoblacion().".<br/>";
				
				
				echo "Lista de publicaciones:<br/>";
				$sql = 'select * from publicacion where idAutor='.$idUsuario." order by fPublicacion";
				$resultadobusqueda = $consulta->conn->query($sql);
				$registroPublicacion = $resultadobusqueda->fetch();
				if($registroPublicacion!=null){
					while($registroPublicacion!=null){
						$publicacion = new publicacion($registroPublicacion[0],$registroPublicacion[1],$registroPublicacion[4],$registroPublicacion[3],$registroPublicacion[2]);
						$listaPublicaciones[] = $publicacion;
						$registroPublicacion = $resultadobusqueda->fetch();
					}
					for($i=0; $i<count($listaPublicaciones); $i++){
						echo "<a href='detallesPublicacion.php?idPublicacion=".$listaPublicaciones[$i]->getIdPublicacion()."'>".$listaPublicaciones[$i]->getFecha().":</a> ".$listaPublicaciones[$i]->getContenido()."<br/>";
					}
				}
				
				
				
			}else{
				echo "Ha habido un problema al acceder a este perfil.";
			}
		}
	}catch(Exception $e){
			echo $e->getMessage();
			echo "Ha habido un error en la base de datos.";
			die();
		}*/
}
?>
</body>
</html>
