
var sesionIniciada=false; //Se declara esta variable para comprobar la sesión.
var usuarioIntroducido;
var claveIntroducida;
console.log("¿Se ha iniciado sesión? " + sesionIniciada);
addEventListener('load',inicializarEventos,false); //Al cargar la página se llama a la función inicializarEventos.

function inicializarEventos(){

	comprobarsesion(); //Lo primero que se hace al cargar la página es comprobar si se ha iniciado sesión.
	console.log("Se ha comprobado el incio de sesión. ¿Se ha iniciado sesión? " + sesionIniciada);
	if(sesionIniciada==true){
		iniciarSesion("PHP/conexion.php");
	}else{
		cargarFormulario("PHP/formulario.php");
	}
	
	
	
}

var conexionDatos;  //Para el estado de la conexión con AJAX se declara de forma global esta variable.

function comprobarsesion(){
	//¿Hago un condicional para llamar previamente a localstorage?
	console.log("¿Usuario?"+localStorage.getItem('usuario'));
	console.log("¿Contraseña?"+localStorage.getItem('clave'));
	if((localStorage.getItem('usuario')!=null)&(localStorage.getItem('clave')!=null)){
		usuarioIntroducido = localStorage.getItem('usuario');
		claveIntroducida = localStorage.getItem('clave');
		sesionIniciada = true;
	}else{
	$.ajax({
    async: false, //Se hace de forma síncrona para que le ejecución de otras funciones no interfiera
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "comprobarSesion.php", //Archivo que contiene el código necesario para comprobar la sesión.
    beforeSend: inicioEnvio,
    success: recibirDatosSesion,
    timeout: 4000,
    error: problemas
  });
  }
}


function recibirDatosSesion(datos){
	console.log("Entró para comprobar los datos del inicio de ssesión inicio sesión.");
	
	
	
	var datosSesionJson = datos;
	var vectorSesion = JSON.parse(datosSesionJson); //El JSON recibido se convierte en un vector.
	sesionIniciada = vectorSesion[0]; //La sesión se almacena en una variable particular
	console.log("Resultado de la sesión: "+vectorSesion);
	console.log("Tamaño del vector creado: " + vectorSesion.length)
	
	if(sesionIniciada){ //Si la sesión está iniciada, las credenciales se guardan en las variables globales declaradas al principio.
		usuarioIntroducido = vectorSesion[1];
		claveIntroducida = vectorSesion[2];
		console.log("Usuario introducido: "+ usuarioIntroducido);
		console.log("Clave introducida: "+ claveIntroducida);
	}
	
}


function cargarFormulario(url){ //En esta función la página que se desea cargar se introduce por parámetro.
	$.ajax({
    async: false,
    type: "GET",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: url, //URL del documento que se cargará
    beforeSend: inicioEnvio,
    success: leerHtml, //La función que se ejecutará tras una ejecución exitosa de la función.
    timeout: 4000,
    error: problemas
  });
	
}

function leerHtml(datos){
	var panelPrincipal = $("#panel"); 
	panelPrincipal.html(datos);	//En el div con id = "panel" se imprime la página que se desea cargar
	console.log(sesionIniciada);
}


function cargar(div, desde){
	$(div).load(desde);
}

function borrarHtml(div){
	//$(div).html("<a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar Foto</a>");
	$(div).html("&nbsp;");
}


function iniciarSesion(url){ 
	//alert(url);
	/*if((localStorage.getItem('usuario')!=null)&(localStorage.getItem('clave')!=null)){
		usuarioIntroducido = localStorage.getItem('usuario');
		claveIntroducida = localStorage.getItem('clave');
	}*/
	console.log("Ha entrado en la función para conectar.");
	if ((usuarioIntroducido==null)& (claveIntroducida==null)){
		usuarioIntroducido = document.getElementById("usuario").value;//En vez de ser declaradas, se comprobará si son nulas y si lo son
		claveIntroducida = document.getElementById("clave").value;//se sigue haciendo esto, pero si no lo son, se omiten estos pasos.
	}
	
	$.ajax({  //Llamada mediante AJAX a la página que se pasa por parámetro con las credenciales como parte de los datos que recibe la página llamada.
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: url,
    data: 'usuario='+usuarioIntroducido+'&clave='+claveIntroducida,
    beforeSend: inicioEnvio,
    success: validarDatos,
    timeout: 4000,
    error: problemas
  });
	
}




function validarDatos(data){
	var panelPrincipal = document.getElementById("panel"); //Div donde se mostrarán los datos recibidos.
	var miPerfil = $("#miPerfil"); //Enlace para ver tu propio muro y configurar tu privacidad
			

	try{
		$("#marcoOpciones").load("PHP/barraSuperior.php"); //Se carga un html que nos permitirá ejecutar ciertas opciones cuando estemos conectados.
		console.log("Sin parsear: "+data);
		var vector = JSON.parse(data); //Se decodifican los datos recibidos mediante JSON.
		var sesion = vector[0];
		console.log("Vector sesión"+sesion);
		localStorage.setItem('usuario', sesion[0]);
		localStorage.setItem('clave', sesion[1]);
		console.log("Sesión: "+sesion);
		var datos = vector[1];
		console.log("Id del usuario que se ha conectado: "+datos.idUsuario);
		console.log("Tipo de usuario: "+datos.tipo);
		console.log("Privacidad: "+datos.privacidad);
		var usuarioConectado = new usuario(datos.idUsuario, datos.nombre, datos.apellidos, datos.correoE, datos.fnacimiento, datos.poblacion, datos.tipo, datos.privacidad, datos.rutaFoto); //Se crea un objeto de tipo usuario con los datos recibidos.
		//panelPrincipal.innerHTML = "<br/> Hola "+ usuarioConectado.getNombre();
		//panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<img src='"+usuarioConectado.getRutaFoto()+"' width='200' height='170'alt='"+usuarioConectado.getNombre()+ " "+ usuarioConectado.getApellidos()+"' >"+" <br/>";
        //listarAmistades(datos.idUsuario);
        //$("#amistades").load("detallesPerfil.php");
		obtenerDetalles(usuarioConectado.getRutaFoto(),usuarioConectado.getNombre());
		cargarSolicitudesAmistad(usuarioConectado.getIdUsuario());
        var panelUsuario = document.getElementById("usr-pic");
        panelUsuario.innerHTML = "<img src='"+usuarioConectado.getRutaFoto()+"'alt='"+usuarioConectado.getNombre()+ " "+ usuarioConectado.getApellidos()+"' >"; 
/*Por ahora no funciona, ya que el div que se usa para este código aún no se ha mostrado. Quizás sea
necesario invocar el método que llama al fichero listarAmistades (Posiblemente renombrado como detallesPerfil o algo así) y después ejecutar este código*/

		console.log(panelPrincipal.innerHTML);
		//El que vale
		//panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<div id='divAnyadir'><!--<a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar foto</a>--> &nbsp;</div>"; //Se añade un botón para desplegar mediante el método cargar un pequeño formulario que permite crear una publicación
		//var ocultarFormularioPublicar = "<a id='botonAnyadir' onclick=borrarHtml('#divAnyadir') class='btn btn-primary'>Ocultar</a>";
		//var divModificable = "aquiBoton";
		//var cambioBoton = [ocultarFormularioPublicar, divModificable];
		//$("#aquiBoton").html("<a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar foto</a>");
		cargar("#formularioPublicaciones","PHP/publicarFoto.php");
		cargar("#aquiBoton", "PHP/botonPublicar.php");
		$("#formularioPublicaciones").hide();
		
		//panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<div id='divAnyadir' class='col-md-2'><a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar foto</a></div>"; //Se añade un botón para desplegar mediante el método cargar un pequeño formulario que permite crear una publicación
		console.log(panelPrincipal.innerHTML);
		//document.getElementById("divAnyadir").innerHTML="<a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar foto</a>";
		//panelPrincipal.innerHTML = '<div class="Post col-sm-6"><div class="row Botones"><div class="col-sm-2"><button type="button" class="btn btn-primary">Primary</button></div><div class="col-sm-4"><button type="button" class="btn btn-primary">Botón secundario</button></div></div></div>';
		panelPrincipal.innerHTML = /*panelPrincipal.innerHTML + */"&nbsp;<input id='idUsuario' type='hidden' value='"+usuarioConectado.getIdUsuario()+"'>"; //Se imprime de forma oculta el idUsuario para futuras necesidades de captura de dicha información
		//$("#divAnyadir").html("<a id='botonAnyadir' onclick=cargar('#divAnyadir','PHP/publicarFoto.php') class='btn btn-primary'>Publicar foto</a>");
		if(datos.tipo == "admin"){ //Se muestran opciones de administración si el usuario conectado es de tipo admin.
			//panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<div id='administracion' class='col-md-2'></div>";
			cargar('#administracion','PHP/opcionesAdministracion.php');
			listarUsuarios(); 
			$("#opcionesOcultables").hide();
		}
		console.log(panelPrincipal.innerHTML);
		//var panelUsuario = document.getElementById("usr-pic");
        //panelUsuario.innerHTML = "<img src='"+usuarioConectado.getRutaFoto()+"'alt='"+usuarioConectado.getNombre()+ " "+ usuarioConectado.getApellidos()+"' >"; 
		//$("#marcoOpciones").load("barraSuperior.php"); //Se carga un html que nos permitirá ejecutar ciertas opciones cuando estemos conectados.
		var direccionPerfil = "detallesUsuario.php?idUsuario="+usuarioConectado.getIdUsuario(); 
		console.log("dirección de perfil: "+ direccionPerfil);
		//listarPublicaciones(datos.idUsuario);
		listarFotos(datos.idUsuario);
		$("#miPerfil").attr('href', direccionPerfil);
		//alert("Direción del perfil: "+$("#miPerfil").attr('href'));
		contarAmistades(datos.idUsuario);
		listarAmistades(datos.idUsuario); //Se hace un listado de toda la información que se muestra en la pantalla principal de la red social.
		//listarNotificaciones(datos.idUsuario);
	}catch(err){
		console.log("Ha habido una excepción: "+err);
		panelPrincipal.innerHTML = data; //Si se produce un error con los datos recibidos se ejecuta esta excepción. Se usa cuando no se introducen los datos correctos al conectarse.
	}
	
	console.log("Respuesta del PHP: "+data);
}

function obtenerDetalles(rutaFoto, nombre){
	$.ajax({  //Llamada mediante AJAX a la página que se pasa por parámetro con las credenciales como parte de los datos que recibe la página llamada.
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/detallesPerfil.php",
		data: 'foto='+rutaFoto+"&nombre="+nombre,
		beforeSend: inicioEnvio,
		success: mostrarDetalles,
		timeout: 4000,
		error: problemas
	});
}
function mostrarDetalles(data){
	var panelUsuario = document.getElementById("detalles");
	panelUsuario.innerHTML = data;
}
function registrar(url){ 
	
	var todo = document.getElementById("formulario"); //Se guardan todos los datos del formulario en un vector. 
	console.log("Datos introducidos en el formulario: "+todo+". Longitud: "+ todo.length);
	var vectorDatos = new Array(todo.length);
	//for(i=0; i<todo.length-1; i++){
	for(i=0; i<todo.length; i++){		
		vectorDatos[i]=todo[i].value; //Se comprueba que los datos tengan el formato correcto y estos proceden del valor en el vector anteriormente obtenido.
		console.log("Dato capturado: "+i+": "+ vectorDatos[i]);
	}
	var usuarioCreado = new usuario(0, vectorDatos[0], vectorDatos[1], vectorDatos[2], vectorDatos[3], vectorDatos[4], vectorDatos[5], "publico", "defecto"); //Se crea un usuario con los datos obtenidos a través del formulario aunque su id es 0 y su privacidad es "público"
	console.log("Ha entrado en la función para conectar.");
	
	console.log("URL de procesamiento: "+url);
	
	console.log('todo='+todo[todo.length]);
	
	console.log('url='+url);
	//var datosValidos=!compruebaNombre(usuarioCreado.getNombre())&!compruebaNombre(usuarioCreado.getApellidos());
	console.log("¿Nombre válido?"+compruebaNombre(usuarioCreado.getNombre()));
	console.log("¿Apellidos válidos?"+compruebaNombre(usuarioCreado.getNombre()));
	console.log("¿Apellidos válidos?"+compruebaNombre(usuarioCreado.getNombre()));
	var datosValidos;
	if(compruebaNombre(usuarioCreado.getNombre())&compruebaNombre(usuarioCreado.getNombre())){
		datosValidos = true;
	}else{
		datosValidos = false;
		console.log("Datos no válidos;")
		alert("Datos no válidos.");
	}
	//Hay que comprobar que las contraseñas coinciden
	var vectorCredenciales; 
	var clavesCoinciden;
	if(vectorDatos[7]==vectorDatos[8]){
		clavesCoinciden=true;
		vectorCredenciales =[vectorDatos[6], vectorDatos[7], vectorDatos[8]];
	}else{
		clavesCoinciden=false;
		alert("Las claves no coinciden");
	}
	if(datosValidos&clavesCoinciden){
		conexionDatos=new XMLHttpRequest();  
		conexionDatos.onreadystatechange = efectuarRegistro; //Cuando el PHP procese los datos de forma correcta, se ejecuta la función efectuarRegistro
		conexionDatos.open("POST",url, true);
		conexionDatos.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		console.log(JSON.stringify(vectorDatos));
		console.log(JSON.stringify(usuarioCreado));
		conexionDatos.send('usuario='+JSON.stringify(usuarioCreado)+'&credenciales='+JSON.stringify(vectorCredenciales));
		//Se llama mediante AJAX a la url y se le pasan los datos obtenidos mediante GET
	}		
	
}

	
function efectuarRegistro(){
	
	var panelPrincipal = document.getElementById("panel");
	if(conexionDatos.readyState == 4)
	{		
		panelPrincipal.innerHTML = conexionDatos.responseText; 
		
	} 
	else 
	{
		panelPrincipal.innerHTML =  'Cargando...';
	}
	console.log("Respuesta del PHP: "+conexionDatos.responseText);
	//Se muestra por pantalla y consola lo que se recibe del PHP al que se ha llamado antes
}



function listarPublicaciones(idUsuario){/*Recibe el identificador de un usuario para 
pasárselo por post a la página que llama.*/
alert(usuarioIntroducido);
	console.log("Id del usuario que quiere ver sus publicaciones: "+idUsuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/listarPublicaciones.php",
    data: 'idUsuario='+idUsuario,
    beforeSend: inicioEnvio,
    success: mostrarPublicaciones,
    timeout: 4000,
    error: problemas
  });
  return false;
}

function mostrarPublicaciones(datos){
	var panelPrincipal = document.getElementById("publicaciones"); /*Se captura este div
	para imprimir los resultados del procesamiento de los datos recibidos.*/
	console.log("JSON de los datos recibidos (publicaciones y autor): "+datos);
	try{
		panelPrincipal.innerHTML = panelPrincipal.innerHTML + "Publicaciones de tus contactos <br/>";
		var publicacionesYautores = JSON.parse(datos); //Se decodifica el JSON recibido.
		console.log("Publicaciones y autores (parseado) : " + publicacionesYautores + ". Longitud: " + publicacionesYautores.length);
		console.log("Primera publicacion y autor sin parsear: "+publicacionesYautores[2][0].fecha);
		for(i=0; i<publicacionesYautores.length; i++){
			/*Primero se crean objetos de tipo usuario y publicación a partir de la matriz que se ha
			obtenido al decodificar el JSON recibido*/
			var dato = publicacionesYautores[i];
			console.log("Publicación " + i + ":Fecha: "+dato[0].fecha+". Permiso:"+ dato[0].permiso +" Contenido: "+dato[0].contenido);
			var publicacionRescatada = new publicacion(dato[0].idPublicacion, dato[0].fecha,  dato[0].permiso, dato[0].permiso, dato[0].contenido);
			console.log("Autor " + i + ":Nombre: "+dato[1].nombre+". Apellidos:"+ dato[1].apellidos +". Correo electrónico: "+dato[1].correoE+". Fecha de nacimiento: "+dato[1].fnacimiento+". Población: "+dato[1].poblacion);
			var autor = new usuario(dato[1].idUsuario,dato[1].nombre, dato[1].apellidos, dato[1].correoE, dato[1].fNacimiento, dato[1].poblacion, dato[1].tipo, dato[1].privacidad, dato[1].rutaFoto);
			panelPrincipal.innerHTML = panelPrincipal.innerHTML +"<a id=amistad"+autor.getIdUsuario()+"  href='detallesUsuario.php?idUsuario="+autor.getIdUsuario()+"' onclick = 'return modal(this.href)'>"+ autor.getNombre() + " " + autor.getApellidos() + "</a> ha escrito: <br/>" + publicacionRescatada.getContenido() + ".<br/> El día <a id="+publicacionRescatada.getIdPublicacion()+" href='detallesPublicacion.php?idPublicacion="+publicacionRescatada.getIdPublicacion()+"' onclick = 'return modal(this.href)'>"+ publicacionRescatada.getFecha()+"</a>.<br/>";
			console.log("Fecha de la publicación:" +publicacionRescatada.getFecha());
			/*En el div que antes se capturó se imprimen las publicaciones y sus respectivos autores con
			enlaces que llaman a código para abrir una modal para ver los detalles ya sea del usuario o de 
			la publicación.*/
		}
		
	}catch(err){
		console.log("Ha habido una excepción: "+err);
		
		panelPrincipal.innerHTML = panelPrincipal.innerHTML + datos;
		/*Si no se recibe una publicación, se muestra un mensaje. Como el decodificar dicho mensaje
		como si fuera un JSON causa una excepción. se muestra capturando la excepción.*/
	}

}


function publicar(){
	
	var todo = document.getElementById("formulario");
	var idUsuario = document.getElementById("idUsuario").value;
	console.log("Datos introducidos en el formulario: "+todo+". Longitud: "+ todo.length);
	console.log("Id usuario:"+idUsuario);
	var vectorDatos = new Array(todo.length);
	for(i=0; i<todo.length; i++){
		vectorDatos[i]=todo[i].value;
		console.log("Dato capturado: "+i+": "+ vectorDatos[i]);
	}
	var fecha = new Date();
	console.log("La fecha actual es: "+fecha);
	var contenido = todo[0].value;
	
	var permiso = "todo";
	var mes = fecha.getMonth()+1;
	
	var fechaFormateada = fecha.getFullYear()+"-"+mes+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	console.log("Fecha: "+fechaFormateada +". Contenido: "+ contenido);
	var nueva = new publicacion(0, fechaFormateada, idUsuario, "todo",  contenido); //Para evitar problemas de mantenimiento se ha optado por no modificar la clase y publicar fijando el permiso.
	
	
	console.log("Publicación: "+nueva);
	
	console.log("JSON enviado: "+JSON.stringify(nueva));
	conexionDatos=new XMLHttpRequest();  
	conexionDatos.onreadystatechange = enviarPublicacion;
	conexionDatos.open("POST","PHP/nuevaPublicacionBackend.php", true);
	conexionDatos.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	console.log(JSON.stringify(nueva));

	
	conexionDatos.send('todo='+JSON.stringify(nueva)+'&idUsuario='+idUsuario);
	
	
	
	
	/*Si es texto/
	$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "listarPublicaciones.php",
		data: 'idUsuario='+idUsuario,
		beforeSend: inicioEnvio,
		success: mostrarPublicaciones,
		timeout: 4000,
		error: problemas
	});
	*/
	
}

function listarFotos(idUsuario){/*Recibe el identificador de un usuario para 
pasárselo por post a la página que llama.*/
	console.log("Id del usuario que quiere ver sus publicaciones: "+idUsuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/listarFotos.php",
    data: 'idUsuario='+idUsuario,
    beforeSend: inicioEnvio,
    success: mostrarFotos,
    timeout: 4000,
    error: problemas
  });
  return false;
}

function mostrarFotos(datos){
	var panelPrincipal = document.getElementById("publicaciones"); /*Se captura este div
	para imprimir los resultados del procesamiento de los datos recibidos.*/
	console.log("JSON de los datos recibidos (publicaciones y autor): "+datos);
	/*try{
		panelPrincipal.innerHTML = panelPrincipal.innerHTML + "Publicaciones de tus contactos <br/>";
		var publicacionesYautores = JSON.parse(datos); //Se decodifica el JSON recibido.
		console.log("Publicaciones y autores (parseado) : " + publicacionesYautores + ". Longitud: " + publicacionesYautores.length);
		console.log("Primera publicacion y autor sin parsear: "+publicacionesYautores[2][0].fecha);
		for(i=0; i<publicacionesYautores.length; i++){
			
			var dato = publicacionesYautores[i];
			console.log("Publicación " + i + ":Fecha: "+dato[0].fecha+". Permiso:"+ dato[0].permiso +" Contenido: "+dato[0].contenido);
			var publicacionRescatada = new publicacion(dato[0].idPublicacion, dato[0].fecha,  dato[0].permiso, dato[0].permiso, dato[0].contenido);
			console.log("Autor " + i + ":Nombre: "+dato[1].nombre+". Apellidos:"+ dato[1].apellidos +". Correo electrónico: "+dato[1].correoE+". Fecha de nacimiento: "+dato[1].fnacimiento+". Población: "+dato[1].poblacion);
			var autor = new usuario(dato[1].idUsuario,dato[1].nombre, dato[1].apellidos, dato[1].correoE, dato[1].fNacimiento, dato[1].poblacion, dato[1].tipo, dato[1].privacidad, dato[1].rutaFoto);
			panelPrincipal.innerHTML = panelPrincipal.innerHTML +"<a id=amistad"+autor.getIdUsuario()+"  href='detallesUsuario.php?idUsuario="+autor.getIdUsuario()+"' onclick = 'return modal(this.href)'>"+ autor.getNombre() + " " + autor.getApellidos() + "</a> ha escrito: <br/>" + publicacionRescatada.getContenido() + ".<br/> El día <a id="+publicacionRescatada.getIdPublicacion()+" href='detallesPublicacion.php?idPublicacion="+publicacionRescatada.getIdPublicacion()+"' onclick = 'return modal(this.href)'>"+ publicacionRescatada.getFecha()+"</a>.<br/>";
			console.log("Fecha de la publicación:" +publicacionRescatada.getFecha());
			
		}
		
	}catch(err){
		console.log("Ha habido una excepción: "+err);
		
		panelPrincipal.innerHTML = panelPrincipal.innerHTML + datos;
		
	}*/
	panelPrincipal.innerHTML = panelPrincipal.innerHTML + datos;

}


function publicarFoto(){
	
	var idUsuario = document.getElementById("idUsuario").value;
	var hayAlgo = false;
	var textoPublicacion = "";
	var rutaFoto = ""
	if(document.getElementById("nuevaPublicacion").value){
		hayAlgo = true;
		textoPublicacion = document.getElementById("nuevaPublicacion").value;
	}
	//alert("idUsuario: "+idUsuario);
	var fecha = new Date();
	var mes = fecha.getMonth()+1;
	var fechaFormateada = fecha.getFullYear()+"-"+mes+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	var formData = new FormData();
	var imagenSubir;
	if($('#subirFoto')[0].files[0]){
		imagenSubir = $('#subirFoto')[0].files[0];
		console.log("IMAGEN: "+imagenSubir);
		console.log("Nombre de la imagen subida:"+imagenSubir.name);
		//alert("publicada");
		hayAlgo = true;
		//rutaFoto = fecha.getFullYear()+""+mes+""+fecha.getDate()+""+fecha.getHours()+""+fecha.getMinutes()+""+fecha.getSeconds()+"-"+subirFoto.files[0].name;
		rutaFoto = fecha.getFullYear()+""+mes+""+fecha.getDate()+""+fecha.getHours()+""+fecha.getMinutes()+""+fecha.getSeconds()+"-"+$('#subirFoto')[0].files[0].name;
	}
	if(hayAlgo){
	var nuevaFoto = new foto(0, fechaFormateada, idUsuario, "todo",  rutaFoto, textoPublicacion);
	var datosFoto = JSON.stringify(nuevaFoto);
	//alert(datosFoto);
	console.log("Fecha: "+fechaFormateada +". ruta: "+ rutaFoto)
	//alert("RUTA FOTO: "+rutaFoto);
	formData.append('file',imagenSubir);
	formData.append('datosFoto', datosFoto);
	formData.append('idUsuario', idUsuario);
	formData.append('textoPublicacion', textoPublicacion);
	$.ajax({
		url: 'PHP/publicarFotoBackend.php',
		type: 'post',
		data: formData,
		contentType: false,
		processData: false,
		success: enviarFoto		/*enviarPublicacion*//* function(response) {
			if (response != 0) {
				$(".card-img-top").attr("src", response);
			} else {
				alert('Formato de imagen incorrecto.');
			}
		}*/
	});
	}else{
		alert("Debes incluir al menos texto o subir una imagen");
	}	

	/**/
}

function enviarFoto(datos){
	var panelPrincipal = document.getElementById("panel");
	panelPrincipal.innerHTML = datos;
	//alert(datos);
}

function enviarPublicacion(){
	
	var panelPrincipal = document.getElementById("panel");
	if(conexionDatos.readyState == 4)
	{		
		panelPrincipal.innerHTML =  conexionDatos.responseText;
	} 
	else 
	{
		panelPrincipal.innerHTML =  'Cargando...';
	}
	console.log("Respuesta del PHP: "+conexionDatos.responseText);
}

function contarAmistades(idUsuario){ //La estructura de este método es muy similar a la del método listarPublicaciones.
	console.log("Id del usuario que quiere contar sus amistades: "+idUsuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/contarAmistades.php",
    data: 'idUsuario='+idUsuario,
    beforeSend: inicioEnvio,
    success: mostrarNumeroAmistades,
    timeout: 4000,
    error: problemas
  });
  return false;
}

function mostrarNumeroAmistades(datos){
	//alert(datos);
	var divAmistades = document.getElementById("amistades");
	console.log("Se va a mostrar el número de personas agregadas");
	//divAmistades = divAmistades.innerHTML + datos;
	try{
		divAmistades.innerHTML = divAmistades.innerHTML + datos;
	}catch(err){
		console.log("Ha habido una excepción: "+err);
	}
}



function listarAmistades(idUsuario){ //La estructura de este método es muy similar a la del método listarPublicaciones.
	console.log("Id del usuario que quiere ver sus amistades: "+idUsuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/listarAmistades.php",
    data: 'idUsuario='+idUsuario,
    beforeSend: inicioEnvio,
    success: mostrarAmistades,
    timeout: 4000,
    error: problemas
  });
  return false;
}

function mostrarAmistades(datos){ //La estructura de este método es muy similar a la del método mostrarPublicaciones.
	//var panelPrincipal = document.getElementById("amistades");
	//console.log("Qué hay dentro del panel principal: "+panelPrincipal.innerHTML)
	//panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<div id='amistades'></div>";
	var divAmistades = document.getElementById("amistades");
	//console.log("Qué hay dentro del nuevo div: "+divAmistades.innerHTML);
	console.log("JSON de los datos recibidos (amistades): "+datos);

	console.log("Ha entrado en el estado 4");
	try{
		divAmistades.innerHTML = divAmistades.innerHTML + "Lista de amigas y amigos:<br/>";
		divAmistades.innerHTML = divAmistades.innerHTML + datos;
	}catch(err){
		console.log("Ha habido una excepción: "+err);
	}
}





/*El código de abajo corresponde a pruebas simples para hacer implementaciones posteriores más complejas*/
function busqueda(){
	var nombre=$("#nombre").attr("value");
	var correo=$("#correo").attr("value");
	var poblacion=$("#poblacion").attr("value");
	
}
/*
function modal(direccion){
	
	var panelPrincipal = document.getElementById("panel");
	panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<div class='modal' id='modal'></div>";
	$('#modal').append('<div class="modalContenedora" id="contenidoModal">');
	$('#contenidoModal').append('<span id="cierraModal" class="close">&times;</span>');
	$('#contenidoModal').append( "<a id='enlaceVentanaNueva' href="+direccion+" onclick='return nuevaVentana();'>Abrir en una nueva ventana</a>")
	//Se crean los divs necesarios para que sea posible una modal. Además, se crea un enlace
	//que al pulsar sobre él se invocará un método una nueva ventana de la dirección que se
	//guarda en href.
	conexionDatos=new XMLHttpRequest();  
	conexionDatos.onreadystatechange = mostrarModal;
	conexionDatos.open("GET",direccion, true);
	conexionDatos.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	conexionDatos.send();
	
	return false;
}


function mostrarModal(){
	console.log("Qué hay dentro de la modal: "+ $('#contenidoModal').html());
	console.log("JSON de los datos recibidos (amistades): "+conexionDatos.responseText);
	if(conexionDatos.readyState == 4){
		try{
			var modal = document.getElementById("modal");
			modal.style.display = "block";
			var cierraModal = document.getElementById("cierraModal");
			cierraModal.addEventListener("click", cerrarModal, false);
			$('#contenidoModal').append(conexionDatos.responseText);
		//Se capturan el div necesario para llamar al método que cierra una modal
		//al hacer clic sobre él y para imprimir la información rescatada
		}catch(err){
			console.log("Ha habido una excepción");
			console.error(err);
			$('#modal').append("Error");
		}
	}
}

function cerrarModal(){
	var modal = document.getElementById("modal");
	modal.style.display = "none";
	modal.innerHTML = "";
}

function nuevaVentana(){
	var x = $("#enlaceVentanaNueva").attr("href"); //No puedo poner un argumento a la funcióín desde el ancla
	
	window.open(x); 
	return false;
}*/

function listarNotificaciones(usuario){
	listarPeticionesAmistad(usuario);
	listarMeGusta(usuario);
}

function listarPeticionesAmistad(usuario){
	/*Se lee el usuario y se buscan todas las peticiones que tengan
	como idPedido el que se recibe por parámetro*/
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/recibirPeticiones.php",
	data: "usuario=" + usuario,
    beforeSend: inicioEnvio,
    success: recibirPeticiones,
    timeout: 4000,
    error: problemas
  });
}

function recibirPeticiones(datosPeticiones){
	console.log("Solicitudes de amistad no leídas"+datosPeticiones);
	if(datosPeticiones!="	"){
		//$("#peticiones").append("<li>Solicitudes de amistad:</li>");
		$("#peticiones").append("<li>"+datosPeticiones+"</li>");
	}
}

function listarComentarios(usuario){
	$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/notificacionesComentarios.php",
		data: "usuario=" + usuario,
		beforeSend: inicioEnvio,
		success: recibirComentarios,
		timeout: 4000,
		error: problemas
	});
	/*Se lee el usuario y se listan los comentarios no leídos.
	Tras leer los comentarios recientes, estos se eliminan como tales de su tabla correspondiente.*/
}

function recibirComentarios(datosComentarios){
	console.log("Comentarios sin leer "+datosComentarios);
	if(datosComentarios!=""){
		$("#peticiones").append("<li>Comentarios de tus publicaciones:</li>");
		$("#peticiones").append("<li>"+datosComentarios+"</li>");
	}
}

function listarMeGusta(usuario){
	$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/notificacionMeGusta.php",
		data: "usuario=" + usuario,
		beforeSend: inicioEnvio,
		success: recibirMeGustas,
		timeout: 4000,
		error: problemas
	});
	/*Se lee el usuario y se listan los me gusta recientes.
	Tras leer los me gusta recientes, estos se eliminan como tales de su tabla correspondiente.*/
}

function recibirMeGustas(datosMeGusta){
	console.log("Me gustas no leídos"+datosMeGusta);
	if(datosMeGusta!=""){
		$("#meGusta").append("<li>Publicaciones que le gustan a tus contactos:</li>");
		$("#meGusta").append("<li>"+datosMeGusta+"<li>");
	}
}

function listarUsuarios(){
	/*Se hace una llamada mediante AJAX para obtener de la base de datos los usuarios,
	ejecutando una consulta a través de PHP pasando mediante post las credenciales introducidas
	para luego invocar la función mostrar usuarios y que procese lo que devuelve la página*/
	console.log("Se va a cargar la lista completa de usuarias y usuarios de esta red social");
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/listaUsuarias.php",
    beforeSend: inicioEnvio,
    success: mostrarUsuarios,
    timeout: 4000,
    error: problemas
  });
}

function mostrarUsuarios(datos){
	console.log("JSON de todos los usuarios"+datos);
	var divUsuarios = $("#listaUsuarios");
	console.log("divUsuarios: "+divUsuarios);
	console.log(datos);
	divUsuarios.html("Lista de usuarios:"+ datos);
	//var vectorUsuarios = JSON.parse(datos); Al haberse cambiado la forma de mostrarse los datos, ya no hace falta parsear nada.
	//console.log("Primer usuario:"+ vectorUsuarios[0].nombre);
	/*Captura el div donde se mostrarán los usuarios, decodifica el JSON recibido y 
	procede a mostrar la información recibida.*/
	/*try{
		var vectorUsuarios = JSON.parse(datos);
		divUsuarios.append("<table>");
		for(i=0; i<vectorUsuarios.length; i++){
			divUsuarios.append("<tr>");
			var dato = vectorUsuarios[i];
			console.log(dato);
			console.log("usuario " + i + ": Nombre: "+dato.nombre+". Apellidos:"+ dato.apellidos +". Correo electrónico: "+dato.correoE+". Fecha de nacimiento: "+dato.fnacimiento+". Población: "+dato.poblacion);
			var usuarioRescatado = new usuario(dato.idUsuario,dato.nombre, dato.apellidos, dato.correoE, dato.fNacimiento, dato.poblacion, dato.tipo, dato.privacidad, dato.rutaFoto);
			//Se crea un div con un enlace que mediante la captura del evento onclick abrirá una modal con el enlace
			//del perfil del usuario.
			divUsuarios.append("<td><a href='detallesUsuario.php?idUsuario="+usuarioRescatado.getIdUsuario()+"' onclick = 'return modal(this.href)'>"+ usuarioRescatado.getNombre() + " " + usuarioRescatado.getApellidos() + "</a></td>");
			//Si el usuario no es admin (con id=3) se mostrarán opciones para modificar los privilegios del usuario o borrarlo.
			Esas tareas se harán también mediante la captura del evento onclick para llamar a las funciones pertinentes.
			if(usuarioRescatado.getIdUsuario()!=3){
				//divUsuarios.append("<button onclick='cambiarTipoUsuario("+usuarioRescatado.getIdUsuario()+")'>Convertir en administrador</button>");
				if(usuarioRescatado.getTipo()=="normal"){
					divUsuarios.append("<td><button onclick='cambiarTipoUsuario("+usuarioRescatado.getIdUsuario()+")' class='btn btn-primary'>Convertir en administrador</button></td>");
				}else{
					divUsuarios.append("<td><button onclick='cambiarTipoUsuario("+usuarioRescatado.getIdUsuario()+")' class='btn btn-primary'>Eliminar privilegios</button></td>");
				}
				divUsuarios.append("<td><button onclick='eliminarUsuario("+usuarioRescatado.getIdUsuario()+")' class='btn btn-primary'>Eliminar usuario</button></td>");
			}
//			divUsuarios.append("<br/>");
			divUsuarios.append("</tr>");
		}
		divUsuarios.append("</table>");
	}catch(err){
		console.log("Ha habido una excepción");
		//divUsuarios.html("Error al cargar las opciones de administración.");
	}*/
	
	
}

function cambiarTipoUsuario(idUsuario){
	console.log("Se van a modificar los privilegios sel usuario "+idUsuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/cambiarUsuario.php",
    data: 'idUsuario='+idUsuario,
    beforeSend: inicioEnvio,
    success: resultadoCambio,
    timeout: 4000,
    error: problemas
  });
	
}

function resultadoCambio(datosCambio){
	console.log(datosCambio);
	alert(datosCambio);
	listarUsuarios();
}

function eliminarUsuario(idUsuario){ /*Funcionamiento muy similar a la función
que modifica los privilegios de un usuario, así como su función asociada.*/
	console.log("Se van a modificar los privilegios sel usuario "+idUsuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/eliminarUsuario.php",
    data: 'idUsuario='+idUsuario,
    beforeSend: inicioEnvio,
    success: resultadoBorrado,
    timeout: 4000,
    error: problemas
  });
	
}

function resultadoBorrado(datosCambio){
	console.log(datosCambio);
	alert(datosCambio);
	listarUsuarios();
}

function  compruebaNombre(entrada){
	var formatoNombre = /[A-Z][a-z]{2,14}/;
	//var formatoNombre =/^[0-9]{3}$/;
	console.log(entrada.value);
	if(formatoNombre.test(entrada)){
		console.log("Formato correcto");
		//return entrada;
		return true;
	}else{
		alert("Formato de nombre incorrecto");
		console.log("Formato de nombre incorrecto");
		entrada.style.backgroundColor='yellow';
		return false;
	}
}

function  compruebaCorreo(entrada){
	var formatoCorreo = /[a-z]{2,14}@[a-z]{2,14}\.[a-z]{2,6}/;
	//var formatoNombre =/^[0-9]{3}$/;
	console.log(entrada);
	if(formatoCorreo.test(entrada)){
		console.log("Formato correcto");
		//return entrada;
		return true;
	}else{
		alert("Correo no válido.");
		console.log("Correo no válido.");
		entrada.style.backgroundColor='yellow';
		return false;
	}
}



function administrar(){
	//$("#opcionesOcultables").toggle(function(){$("#botonAdmin").html("Ocultar")}, function(){$("#botonAdmin").html("Mostrar opciones")});
	$("#opcionesOcultables").toggle(function(){ //En función de lo que muestre el botón se mostrarán o no las opciones de administrador.
		if($("#botonAdmin").html()=="Ocultar"){
			console.log("Texto mostrado"+$("#botonAdmin").html());
			$("#botonAdmin").html("Mostrar opciones de administración");
		}else{
			console.log("Texto mostrado"+$("#botonAdmin").html());
			$("#botonAdmin").html("Ocultar");
		}
	});
	//$("#botonAdmin").html("Ocultar");
}

function alternar(divOcultable, botonModificable, primerTexto, segundoTexto){
	//$("#opcionesOcultables").toggle(function(){$("#botonAdmin").html("Ocultar")}, function(){$("#botonAdmin").html("Mostrar opciones")});
	$(divOcultable).toggle(function(){ //En función de lo que muestre el botón se mostrarán o no las opciones de administrador.
		if($(botonModificable).html()==primerTexto){
			console.log("Texto mostrado"+$("#botonAdmin").html());
			$(botonModificable).html(segundoTexto);
		}else{
			console.log("Texto mostrado"+$("#botonAdmin").html());
			$(botonModificable).html(primerTexto);
		}
	});
	//$("#botonAdmin").html("Ocultar");
}


function problemas(){
	console.log("Ha habido un problema");
}

function inicioEnvio(){
	console.log("Procesando datos de AJAX");
}
