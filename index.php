	<?php
	session_start();
	?>
	<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
		<head>
			<title>Red social IES La Puebla</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" href="css/estilo.css"> <!--Hoja de estilo de código propio-->
			<link rel="stylesheet" href="css/bootstrap.min.css"> <!--Hoja de estilo descargada para configurar el aspecto visual-->
			<script src="JS/codigoCompartido.js" defer></script>
			<script src="jquery-3.4.1.js" defer></script><!--Jquery para programar con mayor facilidad-->
			<script src="foto.js" defer></script>
			<script src="publicacion.js" defer></script><!--Clases de las que se hará uso-->
			<script src="JS/clases/usuario.js" defer></script>
			<script src="JS/detalles.js" defer></script>
			<script src="JS/ajax1.js"  defer></script> <!--Código que gobernará la aplicación-->
			<!--Hojas de estilo de la plantilla-->
			<link rel="stylesheet" type="text/css" href="css/animate.css">
			<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="css/line-awesome.css">
			<link rel="stylesheet" type="text/css" href="css/line-awesome-font-awesome.min.css">
			<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
			<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css">
			<link rel="stylesheet" type="text/css" href="lib/slick/slick.css">
			<link rel="stylesheet" type="text/css" href="lib/slick/slick-theme.css">
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/responsive.css">
			<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

			<!--/Hojas de estilo de la plantilla-->
			
		</head>
		<body>
			<div id="sesion"></div>
			<!--<div id="infoAdicional" class="navbar navbar-expand-lg navbar-light bg-primary">-->
			<div id="infoAdicional">
				<div id="marcoOpciones"></div>
				<!--<div id="zonaNotificaciones">
					<nav class="nav">
						<ul id="peticiones">
						</ul>
						<ul id="meGusta">
						</ul>
					</nav>
				</div>-->
			</div>
			
			
			<div class='container'>
				<div id="panel">
					<div id='divAnyadir'>&nbsp;</div>
				</div>
				<div class="row Noticias">
					<div class="Post col-md-11">
						
						<div class="row Botones">
							<div id='formularioPublicaciones'></div>
							<div class="row">
								<div class="col-md-3" id="aquiBoton">
									<!--<button type="button" class="btn btn-primary">Primary</button>-->
									<!--<a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar foto</a>-->
								</div>
								<div class="col-md-8" id='administracion'>
									<!--<button type="button" class="btn btn-primary">Botón secundario</button>-->
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="row">	
					<div id="publicaciones" class="col-md-8"></div>			
					<div id="detalles" class="col-md-offset-10 col-md-4"></div>
				</div>
			
				<!--<div class="row">
					<div id="abcde" class="col-md-2"><a  class='btn btn-primary'>Publicar</a></div>
					<div id="fghij" class="col-md-2"><a class='btn btn-primary'>Mostrar opciones de administración</a></div>
				</div>
				<div class="row">
					<div class="col-md-1">HOOOOOOOOOOOOLAAAAAAAAAA</div>
				</div>-->
			</div>
		</body>

	</html>
