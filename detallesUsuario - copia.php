<html>
<head>
	<script src="jquery-3.4.1.js" defer></script>
	<script src="publicacion.js" defer></script>
	<script src="foto.js" defer></script>
	<script src="usuario.js" defer></script>
	<script src="codigoCompartido.js" defer></script>
	<script src="detalles.js" defer></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
<!--De la plantilla-->

<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome.css">
<link rel="stylesheet" type="text/css" href="css/line-awesome-font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick.css">
<link rel="stylesheet" type="text/css" href="lib/slick/slick-theme.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="css/responsive.css">


<!--/De la plantilla-->
<!--	<style>
	
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

	</style>-->
</head>
<body>
<div id="panel"></div>
<div id="marcoOpciones"></div>
<div id="irInicio"></div>
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
	echo "<input id=credencialUsuario type='hidden' value='".$_SESSION['usuario']."'/>";
	echo "<input id=credencialClave type='hidden' value='".$_SESSION['clave']."'/>";
	$usuario=$_SESSION['usuario'];
	$clave=$_SESSION['clave'];
	$sql = "select * from credencialesusuario where identificador = '".$usuario."'";
	$resultadobusqueda = $consulta->conn->query($sql);
	if ($resultadobusqueda){
		$credencialUsuario = $resultadobusqueda->fetch();
		$usuarioConectado = $credencialUsuario[0];
		?>
		<input id="usuarioConectado" type="hidden" value=<?php echo $usuarioConectado; ?> />
		<input type='hidden' id='idUsuarioConectado' value='<?php echo $idUsuario;?>' />
		<?php
		if($usuarioConectado==$idUsuario){
			
			$opcionesUsuario='
			<!--<input type=file value="Cambiar foto de perfil"></input>-->
			<div class="fileinputs">
				<input  id="archivo" type="file"/>
				<div class="fakefile" id="fakefile">
					<!-- <input type="hidden"/>
					<img src="button_select.gif" /> -->
					<div id="cambioDeFoto"></div>
					<div id="archivoSeleccionado" hidden></div>
				</div>
				<form id="confPrivacidad">
				<select id="privacidadUsuario">
					<option id="amigos" value="amigos">Sólo mis amistades pueden ver mis publicaciones</option>
					<option id="publico" value="publico" >Todo el mundo puede ver mis publicaciones</option>
				</select>
				<br/>
				<input type="submit" value="Modificar" >
			</form>
				
			</div>';
			$etiquetasPrevias = "<label for='archivo'>
			<span data-tooltip='Pincha para cambiar la foto de perfil'>";
			$etiquetasFinales="</span>
			</label>";
			
		}else{
			?>
			<!--<div id="divAmistad">
				<a id="peticionAmistad" href="#" >Pedir amistad</a>
				<br/>
				<a id="cancelarAmistad" href="#"></a>
			</div>-->
			<br/>
			<?php
			$sql = "SELECT * FROM bloqueoUsuarios where idBloqueado=".$usuarioConectado." and idBloquea=".$idUsuario;
			try{
			$resultadobusqueda = $consulta->conn->query($sql);
				if ($resultadobusqueda){
					$registroBloqueo = $resultadobusqueda->fetch();
					if ($registroBloqueo != null){
						$autorizacionVer = false;
						echo "<div id='divAmistad'>						
								<div id='peticionAmistad' </div>
								<div id='cancelarAmistad'></div>
							</div>";
						$autorizacionPublicaciones = false;
						//echo $autorizacionVer;
					}else{
						$opcionesUsuario='<div id="divAmistad">
						<ul class="flw-hr">
							<!--<li><a href="#" title="" class="flww"><i class="la la-plus"></i> Pedir amistad</a></li>-->
							<li><a id="peticionAmistad" href="#" class="flww">Pedir amistad</a></li>
							<li><a id="cancelarAmistad" href="#" class="hre"></a></li>
							<!--<li><a href="#" title="" class="hre">Hire</a></li>-->
						</ul>
					</div>';
					$etiquetasPrevias = "";
				$etiquetasFinales="";
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
	
}else{
	$etiquetasPrevias = "";
	$etiquetasFinales="";
	$opcionesUsuario='';
	echo "<input type='hidden' id='idUsuarioConectado' value=0 />";
}

if($autorizacionVer==true){
?>
	<div id="datosPersonales">
	<?php
		$sql = 'select * from  usuario  where idUsuario ='.$idUsuario;
		try{
			$resultadobusqueda = $consulta->conn->query($sql);
			if($resultadobusqueda){
					
					
				$registroUsuario = $resultadobusqueda->fetch();
				if ($registroUsuario != null){
					$usuario = new usuario($registroUsuario[0], $registroUsuario[1], $registroUsuario[2], $registroUsuario[3], $registroUsuario[4], $registroUsuario[5], $registroUsuario[6], $registroUsuario[7], $registroUsuario[8]);
					$rutaFoto = $usuario->getRutaFoto();
					$nombreApellidos = $usuario->getNombre() ." ". $usuario->getApellidos();
					$correoElectronico = $usuario->getCorreoE();
					$fechaNacimiento = $usuario->getFnacimiento();
					$población = $usuario->getPoblacion();

					/*echo "<img src='".$usuario->getRutaFoto()."' width='200' height='170' alt='".$usuario->getNombre(). " ".$usuario->getApellidos()."'>";
					echo "<br/>";
					echo "Nombre: ".$usuario->getNombre() ." ". $usuario->getApellidos();
					echo "<br/>";
					echo "Correo electrónico: ".$usuario->getCorreoE();
					echo "<br/>";
					echo "Fecha de nacimiento: ".$usuario->getFnacimiento();
					echo "<br/>";
					echo "Población: ".$usuario->getPoblacion();*/
					?>
				

	<div class="main-section">
		<div class="container">
		<div class="main-section-data">
		<div class="row">
		<div class="col-lg-3">
		<div class="main-left-sidebar">
		<div class="user_profile">
		<div class="username-dt">
		<!--inicio etiquetas
		<label for="archivo">
		<span data-tooltip="Pincha para cambiar la foto de perfil">
		/inicio etiquetas-->
		<?php echo $etiquetasPrevias ?>
		<!--<div class="user-pro-img">-->
		<div  class="usr-pic">
			<img src=<?php echo $rutaFoto; ?> alt="" >
		</div><!--user-pro-img end-->
		<!--fin etiquetas--
		</span>
		</label>
		!--/fin etiquetas-->
		<?php echo $etiquetasFinales ?>
		</div>
		<div class="user_pro_status">
		<!--<ul class="flw-hr">
		<li><a href="#" title="" class="flww"><i class="la la-plus"></i> Follow</a></li>
		<li><a href="#" title="" class="hre">Hire</a></li>
		</ul>-->
		<br><br><br><br><br>
		<ul class="flw-status">
		<!--<li>
			<span>Following</span>
			<b>34</b>
		</li>
		<li>
			<span>Followers</span>
			<b>155</b>
		</li>-->
		<li>
		<b><?php echo $nombreApellidos; ?></b>
		</li>
		<li>
		Correo electrónico: <b><?php echo $correoElectronico ?></b>
		</li>
		<li>
		Fecha de nacimiento: <b><?php echo $fechaNacimiento ?></b>
		</li>
		<li>
		Población: <b><?php echo $población ?></b>
		</li>
		</ul>
		</div><!--user_pro_status end-->
		<?php echo $opcionesUsuario; ?>

		<!--<ul class="social_links">
		<li><a href="#" title=""><i class="la la-globe"></i> Pedir amistad</a></li>
		<div id="divAmistad">
		<a id="peticionAmistad" href="#" >Pedir amistad</a>
		<br/>
		<a id="cancelarAmistad" href="#"></a>
		</div>-->
		<!--<li><a href="#" title=""><i class="fa fa-facebook-square"></i> Http://www.facebook.com/john...</a></li>
		<li><a href="#" title=""><i class="fa fa-twitter"></i> Http://www.Twitter.com/john...</a></li>
		<li><a href="#" title=""><i class="fa fa-google-plus-square"></i> Http://www.googleplus.com/john...</a></li>
		<li><a href="#" title=""><i class="fa fa-behance-square"></i> Http://www.behance.com/john...</a></li>
		<li><a href="#" title=""><i class="fa fa-pinterest"></i> Http://www.pinterest.com/john...</a></li>
		<li><a href="#" title=""><i class="fa fa-instagram"></i> Http://www.instagram.com/john...</a></li>
		<li><a href="#" title=""><i class="fa fa-youtube"></i> Http://www.youtube.com/john...</a></li>-->
		<!--</ul>-->
		</div><!--user_profile end-->
		<!--<div class="suggestions full-width">
		<div class="sd-title">
		<h3>Suggestions</h3>
		<i class="la la-ellipsis-v"></i>
		</div>--sd-title end--
		<div class="suggestions-list">
		<div class="suggestion-usd">
		<img src="http://via.placeholder.com/35x35" alt="">
		<div class="sgt-text">
			<h4>Jessica William</h4>
			<span>Graphic Designer</span>
		</div>
		<span><i class="la la-plus"></i></span>
		</div>
		<div class="suggestion-usd">
		<img src="http://via.placeholder.com/35x35" alt="">
		<div class="sgt-text">
			<h4>John Doe</h4>
			<span>PHP Developer</span>
		</div>
		<span><i class="la la-plus"></i></span>
		</div>
		<div class="suggestion-usd">
		<img src="http://via.placeholder.com/35x35" alt="">
		<div class="sgt-text">
			<h4>Poonam</h4>
			<span>Wordpress Developer</span>
		</div>
		<span><i class="la la-plus"></i></span>
		</div>
		<div class="suggestion-usd">
		<img src="http://via.placeholder.com/35x35" alt="">
		<div class="sgt-text">
			<h4>Bill Gates</h4>
			<span>C & C++ Developer</span>
		</div>
		<span><i class="la la-plus"></i></span>
		</div>
		<div class="suggestion-usd">
		<img src="http://via.placeholder.com/35x35" alt="">
		<div class="sgt-text">
			<h4>Jessica William</h4>
			<span>Graphic Designer</span>
		</div>
		<span><i class="la la-plus"></i></span>
		</div>
		<div class="suggestion-usd">
		<img src="http://via.placeholder.com/35x35" alt="">
		<div class="sgt-text">
			<h4>John Doe</h4>
			<span>PHP Developer</span>
		</div>
		<span><i class="la la-plus"></i></span>
		</div>
		<div class="view-more">
		<a href="#" title="">View More</a>
		</div>
		</div>--suggestions-list end--
		</div>--suggestions end-->
		</div><!--main-left-sidebar end-->
		</div>
		</div>

		</div>
		</div><!-- main-section-data end-->

		<div class="col-lg-6">
		<div class="main-ws-sec">
		<div class="user-tab-sec">
		<h3><?php echo $nombreApellidos; ?></h3>
		</div><!--user-tab-sec end-->
		</div><!--main-ws-sec end-->
		</div>
		</div> 

	</div>



					<?php

				}
			}
		}catch(Exception $excepcion){
			echo "No se pueden mostrar los datos de esta usuaria o usuario";
		}
	?>				
	<!--</div>-->
<?php
}

//echo $autorizacionVer;
if($autorizacionPublicaciones==true){
?>	<div id="listaPublicaciones"></div>
	<?php
}
?>

</body>
</html>
