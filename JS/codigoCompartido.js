function comprobarsesion(){
	//¿Hago un condicional para llamar previamente a localstorage?*/
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
    url: "PHP/comprobarSesion.php", //Archivo que contiene el código necesario para comprobar la sesión.
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

function cerrarSesion(){
    localStorage.clear();
    //alert(localStorage.getItem('clave'));
}

function desplegarDetalles(texto){
    alert(texto);
}


function modal(direccion){
	
	var panelPrincipal = document.getElementById("panel");
	panelPrincipal.innerHTML = panelPrincipal.innerHTML + "<div class='modal' id='modal'></div>";
	$('#modal').append('<div class="modalContenedora" id="contenidoModal">');
	$('#contenidoModal').append('<span id="cierraModal" class="close">&times;</span>');
	$('#contenidoModal').append( "<a id='enlaceVentanaNueva' href="+direccion+" onclick='return nuevaVentana();'>Abrir en una nueva ventana</a>")
	/*Se crean los divs necesarios para que sea posible una modal. Además, se crea un enlace
	que al pulsar sobre él se invocará un método una nueva ventana de la dirección que se
	guarda en href.*/
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
		/*Se capturan el div necesario para llamar al método que cierra una modal
		al hacer clic sobre él y para imprimir la información rescatada*/
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
}

function prueba(texto){
	alert(texto);
}

/*var script = document.createElement("solicitudesAmistad");
script.addEventListener("load",cargarSolicitudesAmistad("Prueba"));*/

function cargarSolicitudesAmistad(idUsuario){
	console.log("idUsuario:"+idUsuario);
	console.log("HTML del desplegable:"+$("#solicitudesAmistad").html());
	$.ajax({
		async: true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/cargarPeticionesAmistad.php",
		data: "usuarioConectado=" + idUsuario,
		beforeSend: cargando,
		success: mostrarSolicitudesAmistad,
		timeout: 4000,
		error: problemas
	});
}

function mostrarSolicitudesAmistad(datos){
	//alert(datos);
	$("#listaSolicitudes").html(datos);
}

function problemas(){
	console.log("Ha habido un problema");
}