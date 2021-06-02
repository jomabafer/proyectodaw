<script src="PHP/clases/usuario.js" defer></script>
REGISTRO<br/>

<form id="formulario" method='POST'> 
	<label for='nombre'>Nombre:</label>
	<input id="nombre" name='usuario' type='text'/> <br/>
	<label for='apellidos'>Apellidos:</label>
	<input id="apellidos" name='apellidos' type='text'/> <br/>
	<label for='correo'>Correo electrónico:</label>
	<input id="correo" name="correo" type="email"/><br/>
	<label for='fnacimiento'>Fecha de nacimiento:</label>
	<input id='fnacimiento' type='date'/><br/>
	<label for='poblacion'>Población</label>
	<input id="poblacion" name='poblacion' type='text'/> <br/>
	<input id="tipo" name='tipo' type='hidden' value="normal"/> <br/>
	<label for='usuario'>Nombre de usuario</label>
	<input id="usuario" name='usuario' type='text'/> <br/>
	<label for='clave'>Contraseña:</label> 
	<input id="clave" name='clave' type='password'/> <br/>
	<label for='clavebis'>Repite tu contraseña:</label> 
	<input id="clavebis" name='clavebis' type='password'/> <br/>
	
	
	<!--Con este botón debo cargar la página de la conexión mediante Ajax-->
</form>
<div class="dropdown-divider"></div>
<div class="row">
	<div class="col-md-2">
		<a  onclick=registrar("PHP/registrobackend.php") class="btn btn-primary">Enviar</a>
	</div>
	<div class="col-md-2">	
		<a id="registro" onclick=cargarFormulario("PHP/formulario.php") class="btn btn-primary">Volver</a>
	</div>
</div>
<script src="ajax1.js"></script>
