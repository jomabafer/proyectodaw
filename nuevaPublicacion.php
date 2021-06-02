<html>

		<head>
			<title>Tarea 6</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
		<body>
				<form id="formulario" method='POST' enctype="multipart/form-data">
					
					<label for='nuevaPublicacion'>Nueva publicación:</label> 
					<textarea rows="10" cols="40" name="nuevaPublicacion"></textarea> <br/>
					
					
					
						<!--<input id="subirFoto" />-->
					
					<!--<select id="permiso" name="permiso">

						<option value="todo">Todo el mundo</option>

						<option value="amistades">Sólo amistades</option>

						<option value="yo">Sólo yo</option>

					</select>-->
					<!--<button  onclick=publicar()>Publicar</button>-->
					<a id='botonPublicar' onclick=publicar() class='btn btn-primary'>Publicar</a>
					<a id='botonAnyadir' onclick=borrarHtml('#divAnyadir') class='btn btn-primary'>Ocultar</a>
					<!--<a id='botonAnyadir' onclick=cargar('#divAnyadir', "botonNuevaPublicacion.php") class='btn btn-primary'>Ocultar</a>-->
				</form>
				<br/>
				
				
				<!--<button onclick=prueba("Probando")>Botón de prueba</button>
				<button id="botonprueba" type="button" onclick=alert("Probando")>Otro botón de prueba</button>-->
			
			<!--<script src="ajax1.js"></script>-->
		</body>
</html>
