//import{prueba} from "./cargaDetalles.js";
//¿Pruebo a comprobar la sesión desde el archivo compartido?
//Así podré cargar la barra superior sólo si estoy conectado
var credencialUsuario = document.getElementById("credencialUsuario");
var credencialClave = document.getElementById("credencialClave");
//var idUsuario;
//idUsuario = document.getElementById("idUsuarioConectado").value;
if((credencialUsuario!=null)&(credencialClave!=null)){
	var idUsuario;
	idUsuario = document.getElementById("idUsuarioConectado").value;
	//alert();
	//$("#marcoOpciones").load("barraSuperior.php"); //Se carga un html que nos permitirá ejecutar ciertas opciones cuando estemos conectados.
	//Tengo que añadir código que modifique los enlaces.
	//Mi perfil posiblemente lo voy a hacer modificando el atributo href y poniendo el id de usuario.
	//Busca personas va a usar el mismo código que la página principal pero dicho código se va a almacenar
	//en la carpeta código compartido. 
	//console.log("marcoOpciones:"+document.getElementById("marcoOpciones").innerHTML);
	//var enlacePerfil = document.getElementById("chiquito");
	//var enlacePerfil = $("#miPerfil");
	//alert(enlacePerfil.getAttribute('href'));
	//alert(enlacePerfil.value);
	//enlacePerfil.setAttribute('href', 'index.php');
	//alert(enlacePerfil.getAttribute('href'));
	$.ajax({
		async: true,
		type: "GET",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/barraSuperior.php",
		beforeSend: cargando,
		success: mostrarBarraSuperior,
		timeout: 4000,
		error: problemas
	  });
}else{
	if($("#irInicio")!=null){
		$("#irInicio").html("<a href='index.php'>Iniciar sesión</a>");
	}
}

function mostrarBarraSuperior(datos){
	console.log("HTML de la barra superior:" + datos);
	$("#marcoOpciones").html(datos);
	var enlacePerfil = document.getElementById("miPerfil");
	console.log(enlacePerfil.href);
	console.log("idUsuario: "+idUsuario);
	enlacePerfil.href = "detallesUsuario.php?idUsuario="+idUsuario;
	cargarSolicitudesAmistad(idUsuario);
}

var tipoDetalles = $("#tipoDetalles").val();
console.log("Tipo de detalles="+tipoDetalles);
if(tipoDetalles=="detallesPublicacion"){ /*Dependiendo de si visitamos un perfil o
una publicación, las acciones que se tomen serán diferentes.*/
	var idPublicacion = $("#idPublicacion").val();
	console.log(idPublicacion);
	//idPublicacion.onload = cargarComentarios();
	cargarComentarios(idPublicacion);
	//var numeroMeGustas = $("#numeroMeGustas"); No parece que sea
	//console.log(numeroMeGustas); necesario capturarlo aquí.
	//numeroMeGustas.onload = cargarMeGustas();
	cargarMeGustas(idPublicacion);
	var comprueboMeGustaUsuario = $("#comprueboMeGustaUsuario");
	console.log(comprueboMeGustaUsuario.val());
	if(comprueboMeGustaUsuario.val()!=0){
		//comprueboMeGustaUsuario.onload = comprobarMeGusta();
		comprobarMeGusta(idUsuario, idPublicacion);
		const formularioComentario = document.getElementById('formularioComentario');
		formularioComentario.addEventListener('submit', comentar);
	}
}


if(tipoDetalles=="detallesUsuario"){ /*Acciones que se ejecutan si visitamos un perfil:
Se comprueba la relación de amistad,
se cargan las publicaciones
y si visitas tu propio perfil, también configuras la privacidad de tu muro.*/
	var peticionAmistad = $("#peticionAmistad");
	peticionAmistad.onload = comprobarAmistad();
	var listaPublicaciones = $("#listaPublicaciones");
	listaPublicaciones.onload = cargarPublicacionesUsuario();
	const confPrivacidad = document.getElementById('confPrivacidad');
	console.log("confPrivacidad="+confPrivacidad);
	if(confPrivacidad!=null){
		comprobarPrivacidad();
		confPrivacidad.addEventListener('submit', configurarPrivacidad)
	}
	var archivo = document.getElementById('archivo');
	if(archivo!=null){
		archivo.addEventListener('change', function(){
			if(archivo.files[0].name){
				//alert("¿Quieres cambiar la foto de perfil?");
				//Aquí el código que permita que se vea el botón 
				$("#cambioDeFoto").html("<a href='#' id='cambiarFoto' onclick='cambiarFoto()' class='btn btn-info'>Cambiar imagen de perfil</a>")
			}
		});
	}
	//desplegarDetalles("");
}

function cargarPublicacionesUsuario(){
	console.log("Vamos a cargar las publicaciones de este usuario");
	var usuarioVisitado = $("#usuarioVisitado").val(); //Se obtiene el identificador del usuario
	console.log("Usuario: "+ usuarioVisitado);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/publicacionesUsuario.php", //Se llama a una página PHP que devuelva las publicaciones
    data: "usuarioVisitado=" + usuarioVisitado,
    beforeSend: cargando, 
    success: resultadoPublicaciones, //Lo que devuelve la página se procesa con el método resultado publicación
    timeout: 4000,
    error: problemas
  });	
}


function resultadoPublicaciones(datos){ /*Funciona de manera similar al método que mostraba
las publicaciones en el archivo ajax1.js*/
		console.log("JSON recibido: "+ datos);
		var listaPublicaciones = $("#listaPublicaciones");
		var datosPersonales = $("#datosPersonales");
		try{
		//var publicacionesYusuario = JSON.parse(datos);
		//console.log("Publicaciones y autores (parseado) : " + publicacionesYusuario + ". Longitud: " + publicacionesYusuario.length);
		/*console.log("Nombre del usuario: "+publicacionesYusuario[0].nombre);
		datosPersonales.append("<img src='"+publicacionesYusuario[0].rutaFoto+"' width='200' height='170' alt='"+publicacionesYusuario[0].nombre + " "+ publicacionesYusuario[0].apellidos+"'>");
		datosPersonales.append("<br/>");
		datosPersonales.append("Nombre: "+publicacionesYusuario[0].nombre + " "+ publicacionesYusuario[0].apellidos);
		datosPersonales.append("<br/>");
		datosPersonales.append("Correo electrónico: "+publicacionesYusuario[0].correoE);
		datosPersonales.append("<br/>");
		datosPersonales.append("Fecha de nacimiento: "+publicacionesYusuario[0].fnacimiento);
		datosPersonales.append("<br/>");
		datosPersonales.append("Población: "+publicacionesYusuario[0].poblacion);*/
		
		/*var publicaciones = publicacionesYusuario[1];
		console.log("Fecha de la primera publicación: "+publicaciones[0].fecha);
		console.log("Cantidad de publicaciones: "+publicaciones.length);
		var hayPublicaciones = false;
		for(i=0; i<publicaciones.length; i++){
			if(publicaciones[i].fecha!=null){
				hayPublicaciones = true;
			}
		}
		if(hayPublicaciones==true){
			var dato;
			for(i=0; i<publicaciones.length; i++){
					dato = publicaciones[i];
					console.log("Publicación " + i + ":Fecha: "+dato.fecha+". Permiso:"+ dato.permiso +"Contenido: "+dato.contenido);
					var publicacionRescatada = new publicacion(dato.idPublicacion, dato.fecha, dato.idPublicacion, dato.permiso, dato.contenido);
					listaPublicaciones.append(publicacionRescatada.getContenido() + ".<br/> El día <a id="+publicacionRescatada.getIdPublicacion()+" href='detallesPublicacion.php?idPublicacion="+publicacionRescatada.getIdPublicacion()+"' onclick = 'return nuevaPestanha(this.href)'>"+ publicacionRescatada.getFecha()+"</a>.<br/>");
					console.log("Fecha de la publicación:" +publicacionRescatada.getFecha());
				}
		}else{*/
			listaPublicaciones.append(datos);
			
		//}
		
	}catch(err){
		console.log("Ha habido una excepción: "+err);
		//panelPrincipal.innerHTML = panelPrincipal.innerHTML + "Parece ser que no hay ninguna publicación";
		//listaPublicaciones.html(datos);
	}

	$(".ed-opts-open").on("click", function(){
        $(this).next(".ed-options").toggleClass("active");
		return false;
    });
}


function cargarComentarios(idPublicacion){ //Funciona de manera similar al método que carga las publicaciones.
	console.log("Vamos a cargar los comentarios de esta publicación");
	//var idPublicacion = $("#idPublicacion").val();
	console.log("Publicación: "+ idPublicacion);
	//alert(idPublicacion);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/cargarComentarios.php",
    data: "publicacion=" + idPublicacion,
    beforeSend: cargando,
    success: resultadoComentarios,
    timeout: 4000,
    error: problemas
  });	
}

function resultadoComentarios(datosComentarios){

	console.log("JSON de los datos recibidos (comentarios y nº de publicacion): "+datosComentarios);
	//var divComentarios = $("#comentarios");
	//var divComentarios = $("#comentariosX");
	//divComentarios.text(datosComentarios);

	
	try{
		var informacionRecibida = JSON.parse(datosComentarios);
		console.log("Comentarios e ID : " + informacionRecibida[0] + ". Longitud: " + informacionRecibida[0].length);
		var htmlComentarios = informacionRecibida[0];
		console.log("HTML de los comentarios: "+ htmlComentarios);
		var idPublicacion = informacionRecibida[1];
		var divComentarios = $("#comentarios"+idPublicacion);
		console.log("Nombre del div: "+divComentarios);
		console.log("ID de la publicación: "+idPublicacion);
		//console.log("Primer comentario y autor sin parsear: "+publicacionesYautores[2][0].fecha);
		/*for(i=0; i<comentariosYautores.length; i++){
			
			var dato = comentariosYautores[i];
			console.log("Autor " + i + ":Nombre: "+dato[0].nombre+". Apellidos:"+ dato[0].apellidos +". Correo electrónico: "+dato[0].correoE+". Fecha de nacimiento: "+dato[0].fnacimiento+". Población: "+dato[0].poblacion);
			var autor = new usuario(dato[0].idUsuario,dato[0].nombre, dato[0].apellidos, dato[0].correoE, dato[0].fNacimiento, dato[0].poblacion, dato[0].tipo, dato[0].privacidad, dato[0].rutaFoto);
			console.log("Comentario " + i + ". ID comentario: " + dato[1].idComentario + ". Fecha: "+dato[1].fechaComentario+". ID publicación:"+ dato[1].idPublicacion +". Texto: "+dato[1].textoComentario);
			var comentarioRescatado = new comentario(dato[1].idComentario, dato[1].idPublicacion, dato[1].fechaComentario, dato[1].textoComentario);
			divComentarios.append(comentarioRescatado.getFecha() + ":<a href='detallesUsuario.php?idUsuario="+autor.getIdUsuario()+"'>" +autor.getNombre()+" "+autor.getApellidos()+"</a> ha escrito:");
			divComentarios.append("<br/>");
			divComentarios.append(comentarioRescatado.getTextoComentario());
			divComentarios.append("<br/>");
			
		
		}*/
		divComentarios.html(htmlComentarios);
	}catch(err){
		console.log("Ha habido una excepción: "+err);	
		$("#errorCargaComentarios").text(datosComentarios);
	}
	
}



function cargarMeGustas(idFoto){
	/*Llama de manera similar a otros métodos a una página en PHP para que cuente*
	el número de personas que han dado me gusta a esta publicación.*/
	//var idFoto = $("#idPublicacion").val();
	console.log("Publicación: "+ idFoto);
	console.log("Vamos a ver cuánta gente le ha dado me gusta a esta publicación");
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/contarMeGusta.php",
    data: "idFoto=" + idFoto,
    beforeSend: cargando,
    success: resultadoConteo,
    timeout: 4000,
    error: problemas
  });
}


function resultadoConteo(datosConteo){
	//Imprime en pantalla lo que la página PHP devuelve.
	console.log("JSON recibido con los datos del conteo: "+datosConteo);
	var vectorDatos = JSON.parse(datosConteo);
	var codigoMeGusta = vectorDatos[0];
	var idFoto = vectorDatos[1];
	var numeroMeGustas = $("#numeroMeGustas"+idFoto);
	numeroMeGustas.html(codigoMeGusta);
}


function comprobarMeGusta(idUsuario, idPublicacion){
	console.log("Usuario:"+idUsuario);
	console.log("idPublicacion:"+idPublicacion);
	//Otro método más que hace uso de AJAX.
	console.log("Vamos a comprobar si te gusta esta publicación");
	var user = document.getElementById("comprueboMeGustaUsuario");
	//var idUsuario = user.value;
	var idUsuario = $("#comprueboMeGustaUsuario").val();
	var publicacion = document.getElementById("idPublicacion");
	//var idPublicacion = publicacion.value;
	var idPublicacion = $("#idPublicacion").val();
	console.log("Usuario: " + idUsuario);
	console.log("Publicación: "+ idPublicacion);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/comprobarMeGusta.php",
    data: "usuario=" + idUsuario + "&publicacion=" + idPublicacion,
    beforeSend: cargando,
    success: consultaMeGusta,
    timeout: 4000,
    error: problemas
  });
}

function consultaMeGusta(datos){
	console.log("La comprobación devuelve algún resultado");
	console.log(datos);
	var x = document.getElementById("meGustaPublicacion");
	if(datos == true){
		/*Se diferencia de otros métodos en la escucha de eventos, ya que
		en función de si nos gusta o no la publicación la respuesta al poner
		el cursor sobre el enlace y el texto del mismo serán diferentes.*/
		console.log("Te gusta esta publicación");
		$("#meGustaPublicacion").text("Te gusta esta publicación");
		//var x = document.getElementById("meGustaPublicacion");
		x.addEventListener("mouseover", function(){
			$("#meGustaPublicacion").text("Si pulsas de nuevo, ya no te gustará");
			
		});
		//x.addEventListener("click", noMeGusta);
		x.addEventListener("mouseout", function(){$("#meGustaPublicacion").text("Te gusta esta publicación");});
		x.removeEventListener("click", meGusta);
		x.addEventListener("click", noMeGusta);
	}else{
		console.log("No te gusta esta publicación");
		x.addEventListener("mouseover", function(){
			$("#meGustaPublicacion").text("Si pulsas, indicarás que te gusta esta publicación.");
			
		});
		//x.addEventListener("click", noMeGusta);
		x.addEventListener("mouseout", function(){$("#meGustaPublicacion").text("Me gusta");});
		x.removeEventListener("click", noMeGusta);
		x.addEventListener("click", meGusta);
	}
}



function meGusta(usuario, publicacion){ //Llamada a AJAX similar a la de otros métodos.
	var usuario = document.getElementById("comprueboMeGustaUsuario").value;
	var publicacion = document.getElementById("idPublicacion").value;
	console.log(usuario+", le has dado me gusta a "+publicacion);
	$.ajax({
	async: false,
	type: "POST",
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url: "PHP/meGustaPublicacion.php",
	data: "usuario=" + usuario + "&publicacion=" + publicacion,
	beforeSend: cargando,
	success: gustaBD,
	timeout: 4000,
	error: problemas
  });
  return false;

}

function gustaBD(datos){
	console.log(datos);
	if(datos=="Te gusta esta publicación"){
		//$("#meGustaPublicacion").text("Te gusta esta publicación");
		console.log("Operación me gusta satisfactoria");
	}else{
		alert("Ha habido un error (al gustar)");
	}
	/*Tras hacer click en me gusta se comprueba si te gusta la publicación
	y se vuelve a comprobar a cuántas personas en total les gusta esta publicación*/
	var idPublicacion = $("#idPublicacion").val();
	console.log("Publicación: "+idPublicacion+". Usuario: "+idUsuario+". Me gusta");
	comprobarMeGusta(idPublicacion,idUsuario);
	cargarMeGustas(idPublicacion);
	console.log("Se acaba de comprobar si te gusta o no");
}

function noMeGusta(){ //Proceso prácticamente igual al anterior.
	console.log("Estás intentando darle a no me gusta");
	var usuario = document.getElementById("comprueboMeGustaUsuario").value;
	var publicacion = document.getElementById("idPublicacion").value;
	console.log(usuario+", ya no te gusta "+publicacion);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/yaNoMeGustaPublicacion.php",
    data: "usuario=" + usuario + "&publicacion=" + publicacion,
    beforeSend: cargando,
    success: noGustaBD,
    timeout: 4000,
    error: problemas
  });
  return false;
  
}

function noGustaBD(datos){
	console.log(datos);
	if(datos=="Ya no te gusta esta publicación"){
		console.log("Operación ya no me gusta satisfactoria");
	}else{
		alert("Ha habido un error (al disgustar)");
	}
	var idPublicacion = $("#idPublicacion").val();
	console.log("Publicación: "+idPublicacion+". Usuario: "+idUsuario+". No me gusta");
	comprobarMeGusta(idPublicacion,idUsuario);
	cargarMeGustas(idPublicacion);
	$("#meGustaPublicacion").text("Me gusta");
	console.log("Se acaba de comprobar si te gusta o no");
}



function comentar(event){ //Funciona de manera similar al proceso de publicar de ajax1.js.
	console.log("Vamos a comentar una publicación.");
	var usuario = document.getElementById("comprueboMeGustaUsuario").value;
	var publicacion = document.getElementById("idPublicacion").value;
	var comentario = document.getElementById("comentario").value;
	//Únicamente se capturan los datos de otra forma, uno por uno en este caso y no en un vector.
	var fecha = new Date();
	var mesAnho = fecha.getMonth() + 1;
	var fechaFormateada = fecha.getFullYear()+"-"+mesAnho+"-"+fecha.getDate();
	var horaFormateada = fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	var fhComentario = fechaFormateada + " " + horaFormateada;
	console.log("El/la usuari@ con id="+usuario+" va a comentar la publicación con id="+publicacion+" con el comentario "+comentario+" el día " + fechaFormateada + " a la hora " + horaFormateada);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/comentarPublicacion.php",
    data: "usuario=" + usuario + "&publicacion=" + publicacion + "&comentario=" + comentario + "&fhComentario=" + fhComentario,
    beforeSend: cargando,
    success: resultadoComentar,
    timeout: 4000,
    error: problemas
  });
	event.preventDefault();
}

function resultadoComentar(datos){
	/*Se alerta informando del resultado del proceso.*/
	console.log(datos);
	if(datos){
		alert(datos)
	}else{
		alert("Error");
	}
	//Se vuelven a cargar los comentarios para actualizarlos.
	$("#comentarios").text("");
	var publicacion = document.getElementById("idPublicacion").value;
	cargarComentarios(publicacion);
	console.log("Comentarios actualizados.");
}

/*Todos los métodos que hay desde aquí abajo hasta que se indique nuevamente consistirán
en rescatar datos ocultos en la página web y que corresponden a los identificadores de 
la persona conectada y al de la persona visitada para modificar la notificación de amistad.
La relación de amistad se modificará mediante una petición AJAX a una página en PHP cuyo código
modificará las relaciones de amistad mediante cambios en el registro de una base de datos haciendo
las pertinentes consultas en SQL. Tras la ejecución o ejecuciones de consultas necesarias se informará
del resultado a partir de lo que devuelve la página y después se comprobará de nuevo la relación de
amistad entre los dos usuarios.*/

function pedirAmistad(){
	var pide = document.getElementById("usuarioConectado").value;
	var pedido = document.getElementById("usuarioVisitado").value;
	console.log(pide+" va a pedir amistad a  "+pedido);
	$.ajax({
	async: true,
	type: "POST",
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url: "PHP/pedirAmistad.php",
	data: "pide=" + pide + "&pedido=" + pedido,
	beforeSend: cargando,
	success: resultadoPeticion,
	timeout: 4000,
	error: problemas
  });
  return false;
}

function resultadoPeticion(datosPeticion){
	console.log(datosPeticion);
	if(datosPeticion=="Solicitud de amistad enviada."){
		console.log(datosPeticion);
		alert(datosPeticion);
		$("#peticionAmistad").text(datosPeticion);
		document.getElementById("cancelarAmistad").removeAttribute('class');
	}else{
		alert("Ha habido un error (al pedir la solicitud de amistad)");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar si la relación de amistad");
}

function retirarSolicitud(){
	console.log("vas a retirar tu solicitud de amistad");
	var retira = document.getElementById("usuarioConectado").value;
	var retirado = document.getElementById("usuarioVisitado").value;
	console.log(retira+" va a pedir amistad a  "+retirado);
	$.ajax({
	async: false,
	type: "POST",
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url: "PHP/retirarSolicitudAmistad.php",
	data: "retira=" + retira + "&retirado=" + retirado,
	beforeSend: cargando,
	success: resultadoRetirada,
	timeout: 4000,
	error: problemas
  });
  return false;
}

function resultadoRetirada(datosRetirada){
	console.log(datosRetirada);
	if(datosRetirada=="Solicitud de amistad retirada."){
		alert(datosRetirada);
		document.getElementById("cancelarAmistad").setAttribute('class','hre');
	}else{
		alert("Ha habido un error al retirar la solicitud de amistad. Inténtelo de nuevo.");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar si la relación de amistad");
	$("#peticionAmistad").text("Pedir amistad");
	
}

function confirmarAmistad(){/*No está hecho o terminado*/
	console.log("vas a retirar tu solicitud de amistad");
	var conectado = document.getElementById("usuarioConectado").value;
	var solicitante = document.getElementById("usuarioVisitado").value;
	console.log(conectado+" va a pedir confirmar su amistad a  "+solicitante);
	$.ajax({
	async: false,
	type: "POST",
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url: "PHP/confirmarAmistad.php",
	data: "conectado=" + conectado + "&solicitante=" + solicitante,
	beforeSend: cargando,
	success: confirmarBD,
	timeout: 4000,
	error: problemas
  });
  return false;
}

function confirmarBD(datosConfirmacion){
	console.log(datosConfirmacion);
	if(datosConfirmacion=="Confirmación de amistad completada."){
		//$("#meGustaPublicacion").text("Te gusta esta publicación");

		alert("Ahora sois amigxs");
	}else{
		alert("Ha habido un error (al aceptar la amistad)");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar la relación de amistad");
	//$("#peticionAmistad").text("Amigxs");
	//$("#cancelarAmistad").text("");
}

function rechazarAmistad(){
	console.log("vas a rechazar la amistad de esta persona");
	var conectado = document.getElementById("usuarioConectado").value;
	var solicitante = document.getElementById("usuarioVisitado").value;
	console.log(conectado+" va a pedir confirmar su amistad a  "+solicitante);
	$.ajax({
	async: false,
	type: "POST",
	dataType: "html",
	contentType: "application/x-www-form-urlencoded",
	url: "PHP/rechazarAmistad.php",
	data: "conectado=" + conectado + "&solicitante=" + solicitante,
	beforeSend: cargando,
	success: confirmarRechazo,
	timeout: 4000,
	error: problemas
  });
  return false;
	
}

function confirmarRechazo(datos){
	console.log(datos);
	if(datos=="Solicitud de amistad rechazada."){
		//$("#meGustaPublicacion").text("Te gusta esta publicación");

		alert(datos);
	}else{
		alert("Ha habido un error (al rechazar la solicitud de amistad)");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar la relación de amistad");
	//$("#peticionAmistad").text("Amigxs");
	$("#cancelarAmistad").text("");
}

function retirarAmistad(){
	var opcion = confirm("¿Quieres eliminar a esta persona de tu lista de amigxs?");
    if (opcion == true) {
        console.log("vas a rechazar la amistad de esta persona");
		var conectado = document.getElementById("usuarioConectado").value;
		var amigoBorrar = document.getElementById("usuarioVisitado").value;
		console.log(conectado+" va a pedir confirmar su amistad a  "+amigoBorrar);
		$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/retirarAmistad.php",
		data: "conectado=" + conectado + "&amigoBorrar=" + amigoBorrar,
		beforeSend: cargando,
		success: confirmarBorrado,
		timeout: 4000,
		error: problemas
	  });
	  return false;
	} 
}

function confirmarBorrado(datos){
	console.log(datos);
	if(datos=="Se ha borrado de tu lista de amigas y amigos."){
		

		alert(datos);
	}else{
		alert("Ha habido un error (al eliminar a esta persona).");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar la relación de amistad");
	$("#cancelarAmistad").text("");
	
}

function bloquearUsuario(){
	
	var opcion = confirm("¿Quieres bloquear a esta persona?");
	console.log("¿Confirma el bloqueo? "+opcion);
    if (opcion == true) {
        console.log("vas a bloquear a esta persona");
		var conectado = document.getElementById("usuarioConectado").value;
		var usuarioBloquear = document.getElementById("usuarioVisitado").value;
		console.log(conectado+" va a bloquear a  "+usuarioBloquear);
		$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/bloquearUsuario.php",
		data: "conectado=" + conectado + "&usuarioBloquear=" + usuarioBloquear,
		beforeSend: cargando,
		success: confirmarBloqueo,
		timeout: 4000,
		error: problemas
	  });
	  return false;
	}
	
}

function confirmarBloqueo(datosBloqueo){
	console.log(datosBloqueo);
	if(datosBloqueo=="Has bloqueado a esta persona."){
		alert(datosBloqueo);
	}else{
		alert("Ha habido un error (al bloquear a esta persona).");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar la relación de amistad");
	//$("#peticionAmistad").text("Amigxs");
	$("#cancelarAmistad").text("");
}


function desbloquearUsuario(){
	console.log("Vas a desbloquear a esta persona");
	var opcion = confirm("¿Quieres desbloquear a esta persona?");
    if (opcion == true) {
        console.log("Confirmas que vas a rechazar la amistad de esta persona");
		var conectado = document.getElementById("usuarioConectado").value;
		var usuarioDesbloquear = document.getElementById("usuarioVisitado").value;
		console.log(conectado+" va a pedir confirmar su amistad a  "+usuarioDesbloquear);
		$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/desbloquearUsuario.php",
		data: "conectado=" + conectado + "&usuarioDesbloquear=" + usuarioDesbloquear,
		beforeSend: cargando,
		success: confirmarDesbloqueo,
		timeout: 4000,
		error: problemas
	  });
	  return false;
	}
}

function confirmarDesbloqueo(datosBloqueo){
	//alert(datosBloqueo);
	console.log(datosBloqueo);
	if(datosBloqueo=="Has desbloqueado a esta persona."){
		alert(datosBloqueo);
	}else{
		alert("Ha habido un error (al desbloquear a esta persona).");
	}
	comprobarAmistad();
	console.log("Se acaba de comprobar la relación de amistad");
	//$("#peticionAmistad").text("Amigxs");
	//$("#cancelarAmistad").text("");
	document.getElementById("cancelarAmistad").setAttribute('class','hre');
}

/*Todas las funciones anteriores consistían en peticiones AJAX para modificar la
relación de amistad entre dos usuarios y sus funciones asociadas a la hora de
procesar los datos que devuelve la página en PHP*/

/*Este método comprueba la relación de amistad que tiene un usuario al visitar
un perfil diferente.*/
function comprobarAmistad(){
	//alert();
	var x = document.getElementById("peticionAmistad");
	var y = document.getElementById("cancelarAmistad");
	var z = document.getElementById("divAmistad");
	console.log("x.peticionAmistad: "+x);
	console.log("y.cancelarAmistad: "+y);
	console.log("z.divAmistad: "+z);
	//Se captura el enlace que corresponda
	//alert(x);
	if(x!=null){
		//alert("Ha entrado");
		//Se eliminan todos los eventos previos
		x.removeEventListener("click", pedirAmistad);
		x.removeEventListener("click", retirarSolicitud);
		x.removeEventListener("click", confirmarAmistad);
		x.removeEventListener("click", retirarAmistad);
		x.removeEventListener("click", retirarSolicitud);
		y.removeEventListener("click", bloquearUsuario);
		y.removeEventListener("click", rechazarAmistad);
		y.addEventListener("mouseover", function(){
			console.log("Elimino todos los eventos que pueda haber al pasar el ratón encima");
		});
		y.addEventListener("mouseout", function(){
			console.log("Elimino todos los eventos que pueda haber al soltar el ratón");
		});
		console.log("Vamos a comprobar vuestra amistad");
		var idUsuario = $("#usuarioConectado").val();
		var idPosibleAmistad = $("#usuarioVisitado").val();
		console.log("Usuario conectado: " + idUsuario);
		console.log("Posible amistad: "+ idPosibleAmistad);
		//Petición AJAX a una página en PHP para comprobar la amistad entre los dos usuarios.
		//alert("Vamos a hacer la petición AJAX");
		$.ajax({
			async: true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url: "PHP/comprobarAmistad.php",
			data: "usuarioConectado=" + idUsuario + "&idPosibleAmistad=" + idPosibleAmistad,
			beforeSend: cargando,
			success: consultaAmistad,
			timeout: 4000,
			error: problemas
		});
	}
}

function mostrarOpcionesConfirmacion(datos){
	$("#peticionAmistad").html(datos);
}

function consultaAmistad(datos){
	//alert(datos);
	/*Este método en función de lo que se reciba desde la página en PHP que
	llama a la base de datos para comprobar la relación de amistad entre los
	dos usuarios, escuchará diferentes eventos y cancelará el resto para que al 
	hacer clic sobre uno de los dos enlaces se ejecute la acción que corresponde
	a la hora de modificar la relación de amistad.*/
	console.log("La comprobación devuelve algún resultado");
	console.log(datos);
	var x = document.getElementById("peticionAmistad");
	var y = document.getElementById("divAmistad");
	var z = document.getElementById("cancelarAmistad");
	switch(datos){
		case "Solicitud de amistad enviada":
			
			$("#peticionAmistad").text(datos);
			document.getElementById("cancelarAmistad").removeAttribute('class');
			//var x = document.getElementById("meGustaPublicacion");
			//x.addEventListener("mouseover", function(){
			y.addEventListener("mouseover", function(){				
				$("#peticionAmistad").text("Si pulsas de nuevo, cancelarás la petición de amistad.");
			});
			
			//x.addEventListener("click", noMeGusta);
			console.log("Vamos a eliminar eventos que no proceden");
			x.removeEventListener("click", pedirAmistad);
			x.removeEventListener("click", confirmarAmistad);
			x.removeEventListener("click", retirarAmistad);
			z.removeEventListener("click", bloquearUsuario);
			z.removeEventListener("click", rechazarAmistad);
			console.log("Se han eliminado los eventos que no proceden");
			//alert(datos);
			//x.addEventListener("mouseout", function(){
			y.addEventListener("mouseout", function(){
				$("#peticionAmistad").text(datos);
				//alert("FFFFF");
			});
			
			
			x.addEventListener("click", retirarSolicitud);
			//alert("¿Todavía no lo ha quitado? No, aún no.");
			break;
		
		case "Confirmar solicitud de amistad.":
			//alert();
			$("#peticionAmistad").text(datos);
			console.log("¿Qué es x?(Antes) "+x);
			
			console.log("Vamos a eliminar eventos que no proceden");
			x.removeEventListener("click", pedirAmistad);
			x.removeEventListener("click", retirarSolicitud);
			x.removeEventListener("click", retirarAmistad);
			x.removeEventListener("click", retirarSolicitud);
			z.removeEventListener("click", bloquearUsuario);
			console.log("Se han eliminado los eventos que no proceden");
			$("#cancelarAmistad").text("Eliminar solicitud de amistad.");
			y.addEventListener("mouseover", function(){
				//x="#";
				//$("#divAmistad").html('<a href="#" id="peticionAmistad">Confirmar solicitud de amistad</a><br/> <a href="#" id="cancelarSolicitud">Eliminar solicitud de amistad</a>');
				//02-04-2021-23:09-$("#peticionAmistad").text("Aceptar solicitud de amistad.");
				//02-04-2021-23:09-$("#cancelarAmistad").text("Rechazar amistad.");/*Temporalmente comentado*/
				//$("#cancelarAmistad").class()
				//$("#cancelarAmistad").html('<a href="#" id="cancelarSolicitud">Eliminar solicitud de amistad</a>')
				
				x = document.getElementById("peticionAmistad");
				
				x.addEventListener("click", confirmarAmistad);
				
				
				z.addEventListener("click", rechazarAmistad);
			
				
			});
			
			/*02-04-2021-23:09-y.addEventListener("mouseout", function(){
				$("#cancelarAmistad").text("Eliminar solicitud de amistad.");
				$("#peticionAmistad").text(datos);
				
			});*/
			
			
			break;
		
		case "Amistad confirmada.":
			console.log("Sois amigxs");
			$("#peticionAmistad").text("Amigxs");
			document.getElementById("cancelarAmistad").removeAttribute('class');
			console.log("Vamos a eliminar eventos que no proceden");
			x.removeEventListener("click", pedirAmistad);
			x.removeEventListener("click", retirarSolicitud);
			x.removeEventListener("click", confirmarAmistad);
			x.removeEventListener("click", retirarAmistad);
			x.removeEventListener("click", retirarSolicitud);
			z.removeEventListener("click", bloquearUsuario);
			z.removeEventListener("click", rechazarAmistad);
			console.log("Se han eliminado los eventos que no proceden");
			//var x = document.getElementById("meGustaPublicacion");
			x.addEventListener("mouseover", function(){
				$("#peticionAmistad").text("Borrar como amigx");
				console.log("Vamos a eliminar el evento que pide amistad");
				x.removeEventListener("click", pedirAmistad);
				console.log("Se ha eliminado el evento que pide amistad");
				x.addEventListener("click", retirarAmistad);
				
			});
			x.addEventListener("mouseout", function(){$("#peticionAmistad").text("Amigxs");});
			
			break;
		
		case "No puedes acceder a este perfil porque te ha bloqueado.":
			alert(datos);
			console.log("Vamos a eliminar eventos que no proceden");
			x.removeEventListener("click", pedirAmistad);
			x.removeEventListener("click", retirarSolicitud);
			x.removeEventListener("click", confirmarAmistad);
			x.removeEventListener("click", retirarAmistad);
			x.removeEventListener("click", retirarSolicitud);
			z.removeEventListener("click", bloquearUsuario);
			z.removeEventListener("click", rechazarAmistad);
			console.log("Se han eliminado los eventos que no proceden");
			console.log("Te ha bloqueado");
			var marco = '<div class="product-feed-tab current" id="feed-dd"><div class="posts-section"><div class="post-bar"><div class="job_descp"><h3>'+datos+'</h3></div></div></div></div></div></div>';
			//$("#peticionAmistad").text(datos);
			$("#peticionAmistad").html(marco);
			break;
		
		case "Has bloqueado a esta persona.":
			console.log(datos);
			console.log("Vamos a eliminar eventos que no proceden");
			x.removeEventListener("click", pedirAmistad);
			x.removeEventListener("click", retirarSolicitud);
			x.removeEventListener("click", confirmarAmistad);
			x.removeEventListener("click", retirarAmistad);
			x.removeEventListener("click", retirarSolicitud);
			z.removeEventListener("click", rechazarAmistad);
			console.log("Se han eliminado los eventos que no proceden");
			console.log("Has bloqueado a esta persona");
			document.getElementById("cancelarAmistad").removeAttribute('class');
			x.addEventListener("click", desbloquearUsuario);
			$("#peticionAmistad").text(datos); //Pongo esto al final y así si bloqueas tú, es lo que se muestra.
			y.addEventListener("mouseover", function(){
				$("#peticionAmistad").text("Desbloquear");
			});
			y.addEventListener("mouseout", function(){
				$("#peticionAmistad").text("Has bloqueado a esta persona.");
			});
			break;
		
		default:
			//alert();
			console.log("Vamos a eliminar eventos que no proceden");
			x.removeEventListener("click", retirarSolicitud);
			x.removeEventListener("click", confirmarAmistad);
			x.removeEventListener("click", retirarAmistad);
			x.removeEventListener("click", retirarSolicitud);
			z.removeEventListener("click", bloquearUsuario);
			z.removeEventListener("click", rechazarAmistad);
			console.log("Se han eliminado los eventos que no proceden");
			$("#peticionAmistad").text("Pedir amistad");
			$("#cancelarAmistad").text("Bloquear usuario");
			console.log("Has retirado la solicitud de amistad.");
			y.addEventListener("mouseover", function(){
				$("#peticionAmistad").text("Si pulsas, pedirás amistad a esta persona.");
				$("#cancelarAmistad").text("Si pulsas, esta persona no podrá enviarte solicitud de amistad");
				console.log("Está en el default");
				
			});
			//x.addEventListener("click", noMeGusta);
			y.addEventListener("mouseout", function(){
				$("#peticionAmistad").text("Pedir amistad");
				$("#cancelarAmistad").text("Bloquear usuario");
			});
			x.addEventListener("click", pedirAmistad);
			//var z = document.getElementById("cancelarAmistad");
			z.addEventListener("click", bloquearUsuario);
			//break;		
	}
	
	/*if usuario bloqueado{
		todo en blanco;
		Este usuario te ha bloqueado;
	}*/
}


function configurarPrivacidad(event){
	console.log("Vamos a configurar tu privacidad.");
	var usuario = $("#usuarioConectado").val();//Se capturan el identificador de usuario y la configuración de privacidad deseada.
	var privacidad = $("#privacidadUsuario").val();
	console.log("El/la usuari@ con id="+usuario+" se dispone a configurar su privacidad como " + privacidad);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/configurarPrivacidad.php", //Se mandan por post como argumento a la página PHP indicada
    data: "usuario=" + usuario + "&privacidad=" + privacidad,
    beforeSend: cargando,
    success: resultadoConfigurar, //Después se ejecuta esta función para procesar los datos recibidos.
    timeout: 4000,
    error: problemas
  });
  event.preventDefault();
}

function resultadoConfigurar(datosConfiguracion){
	//Se informa de lo que devuelve la página tras procesar los datos enviados y se vuelve a comprobar la privacidad del usuario para que se muestre actualizada.
	alert(datosConfiguracion);
	comprobarPrivacidad();
}

//Se hace una petición AJAX con el usuario capturado de un input oculto
//y después se llama a una función que procese los datos devueltos por la página.
function comprobarPrivacidad(){
	var usuario = $("#usuarioConectado").val();
	console.log("Se va a comprobar la privacidad del usuario "+usuario);
	$.ajax({
    async: false,
    type: "POST",
    dataType: "html",
    contentType: "application/x-www-form-urlencoded",
    url: "PHP/comprobarPrivacidad.php",
    data: "usuario=" + usuario,
    beforeSend: cargando,
    success: resultadoPrivacidad,
    timeout: 4000,
    error: problemas
  });
}

//En función de lo que devuelva la página se cambia la privacidad en el desplegable.
function resultadoPrivacidad(datosPrivacidad){
	console.log(datosPrivacidad);
	if(document.getElementById("amigos").value == datosPrivacidad){
		document.getElementById("amigos").selected = true;
	}else{
		document.getElementById("publico").selected = true;
	}
}

//Función que se ejecuta en cargo de que la ejecución no sea exitosa.
function problemas(){
	console.log("Ha habido un problema");
}


//Función que se ejecuta en cargo de que la ejecución no sea exitosa.
function cargando(){
	console.log("Procesando datos de AJAX");
}

function cambiarFoto(){
	//alert();
	var archivo = document.getElementById("archivo");  
	//alert(archivo.files[0].name);
	//var archivoSeleccionado = document.getElementById("archivoSeleccionado");  
	//alert(archivo.value);
	/*archivoSeleccionado.innerHTML = archivo.files[0].name;
	alert(archivo.files[0].name);*/



	var idUsuario = document.getElementById("usuarioConectado").value;
	//alert("Nombre del archivo: " +archivo.files[0].name+ ". Nº de usuario: " +idUsuario);
	var hayAlgo = false;
	//var textoPublicacion = "";
	var nombreArchivoFoto = ""
	
	//alert("idUsuario: "+idUsuario);
	//var fecha = new Date();
	//var mes = fecha.getMonth()+1;
	//var fechaFormateada = fecha.getFullYear()+"-"+mes+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	var formData = new FormData();
	var imagenSubir;
	if(archivo.files[0]){
	//if(archivo.files[0].name){
		imagenSubir = $('#archivo')[0].files[0];
		hayAlgo = true;
		nombreArchivoFoto = archivo.files[0].name;
		//alert("Nombre del archivo: " +archivo.files[0].name+ ". Nº de usuario: " +idUsuario);
		console.log("Nombre del archivo: " +archivo.files[0].name+ ". Nº de usuario: " +idUsuario);
		//alert("Ruta de la foto: "+nombreArchivoFoto);
		console.log("Ruta de la foto: "+nombreArchivoFoto);
	}
	if(hayAlgo){
		console.log("Hay una foto para subirse.");
		formData.append('file',imagenSubir);
		formData.append('nombreArchivoFoto', nombreArchivoFoto);
		formData.append('idUsuario', idUsuario);
		//alert();
		$.ajax({
			url: 'PHP/CambiarFotoPerfil.php',
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: cargando,
			success: enviarFoto,		/*enviarPublicacion*//* function(response) {
				if (response != 0) {
					$(".card-img-top").attr("src", response);
				} else {
					alert('Formato de imagen incorrecto.');
				}
			}*/
			error: problemas 
		});
	}else{
		alert("Debes incluir al menos texto o subir una imagen");
	}
}

function enviarFoto(datos){
	//var panelPrincipal = document.getElementById("panel");
	//panelPrincipal.innerHTML = datos;
	//alert(datos);
	console.log(datos);
	location.reload();
}

function cargarFormularioEdicion(id){
	console.log("Vamos a editar la foto/publicación con id "+id);
	$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/editarFoto.php", //Se llama a una página PHP que devuelva las publicaciones
		data: "idPublicacion=" + id,
		beforeSend: cargando, 
		success: mostrarFormularioEdicion, //Lo que devuelve la página se procesa con el método resultado publicación
		timeout: 4000,
		error: problemas
	});
}

function mostrarFormularioEdicio1n(datos){
	console.log("Datos recibidos: "+datos);
	var vectorInformacion = JSON.parse(datos);
	console.log("Vector parseado: "+vectorInformacion);
	var formulario = vectorInformacion[0];
	let idPublicacion = vectorInformacion[1];
	$("#ocultable"+idPublicacion).html(formulario);
	//document.getElementById("cambiarFoto").style.visibility='hidden';
	var botonEliminarFoto = document.getElementById("botonEliminar");
	console.log("¿Hay botón de eliminar? "+botonEliminarFoto);
	//botonEliminarFoto.addEventListener('click', quitarFoto(idPublicacion));
	var modificarFoto = false;
	if(botonEliminarFoto){
		botonEliminarFoto.onclick=function(){
			//alert(idPublicacion);
			document.getElementById("cambiarFoto").style.visibility='visible';
			var idDivFoto = "divFoto"+idPublicacion;
			console.log(idDivFoto);
			var divFoto = document.getElementById(idDivFoto);
			var fotoAntigua = document.getElementById("imagenEditar").getAttribute("src");
			console.log("Ruta en disco de la foto antigua: "+fotoAntigua);
			divFoto.innerHTML="<input type='hidden' id='fotoAntigua' value='"+fotoAntigua+"'/>";
			var inputModificar = document.getElementById("cambiarImagen");
			inputModificar.value="Sí";
			//modificarFoto = true;
		};
	}else{
		document.getElementById("cambiarFoto").style.visibility='visible';
		
	}
	var botonModificar = document.getElementById("botonModificar");
	botonModificar.onclick = editar;
	//alert($('#modificarTexto').value);
	//var botonModificar = document.getElementById("botonModificar");
	//var botonModificar = document.querySelector('#botonModificar');
	/*botonModificar.addEventListener('click', function saludo(){
		var palabra = document.getElementById("modificarTexto").value;
		var idFoto = document.getElementById("idFoto").value;
		//console.log(palabra);
		alert("Texto: "+palabra+" ID: "+idFoto);
		$.ajax({
			async: false,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url: "editarFotoBackend.php", //Se llama a una página PHP que devuelva las publicaciones
			data: "idPublicacion=" + idFoto,
			//beforeSend: cargando, 
			beforeSend: function(){
				alert(idFoto);
			},
			succes: editado,
			//success: function(){
			//	alert();
			//}, //Lo que devuelve la página se procesa con el método resultado publicación
			timeout: 4000,
			//error: problemas
			error: function(){
				alert("error");
			}
		});
	});*/
}


function mostrarFormularioEdicion(datos){
	console.log("Datos recibidos: "+datos);
	var vectorInformacion = JSON.parse(datos);
	console.log("Vector parseado: "+vectorInformacion);
	var formulario = vectorInformacion[0];
	let idPublicacion = vectorInformacion[1];
	$("#ocultable"+idPublicacion).html(formulario);
	//document.getElementById("cambiarFoto").style.visibility='hidden';
	var botonEliminarFoto = document.getElementById("botonEliminar");
	console.log("¿Hay botón de eliminar? "+botonEliminarFoto);
	//botonEliminarFoto.addEventListener('click', quitarFoto(idPublicacion));
	var modificarFoto = false;
	var inputModificar = document.getElementById("cambiarImagen");
	if(botonEliminarFoto){
		botonEliminarFoto.onclick=function(){
			//alert(idPublicacion);
			document.getElementById("cambiarFoto").style.visibility='visible';
			var idDivFoto = "divFoto"+idPublicacion;
			console.log(idDivFoto);
			var divFoto = document.getElementById(idDivFoto);
			var fotoAntigua = document.getElementById("imagenEditar").getAttribute("src");
			console.log("Ruta en disco de la foto antigua: "+fotoAntigua);
			divFoto.innerHTML="<input type='hidden' id='fotoAntigua' value='"+fotoAntigua+"'/>";
			var inputModificar = document.getElementById("cambiarImagen");
			inputModificar.value="Sí";
			//modificarFoto = true;
		};
	}else{
		document.getElementById("cambiarFoto").style.visibility='visible';
		document.getElementById("cambiarFoto").onchange=function(){
			/*var idDivFoto = "divFoto"+idPublicacion;
			var divFoto = document.getElementById(idDivFoto);
			divFoto.innerHTML="<input type='hidden' id='fotoAntigua' value='"+fotoAntigua+"'/>";*/
			var inputModificar = document.getElementById("cambiarImagen");
			inputModificar.value="Sí";
		}
	}
	var botonModificar = document.getElementById("botonModificar");
	botonModificar.onclick = editar;
	//alert($('#modificarTexto').value);
	//var botonModificar = document.getElementById("botonModificar");
	//var botonModificar = document.querySelector('#botonModificar');
	/*botonModificar.addEventListener('click', function saludo(){
		var palabra = document.getElementById("modificarTexto").value;
		var idFoto = document.getElementById("idFoto").value;
		//console.log(palabra);
		alert("Texto: "+palabra+" ID: "+idFoto);
		$.ajax({
			async: false,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url: "editarFotoBackend.php", //Se llama a una página PHP que devuelva las publicaciones
			data: "idPublicacion=" + idFoto,
			//beforeSend: cargando, 
			beforeSend: function(){
				alert(idFoto);
			},
			succes: editado,
			//success: function(){
			//	alert();
			//}, //Lo que devuelve la página se procesa con el método resultado publicación
			timeout: 4000,
			//error: problemas
			error: function(){
				alert("error");
			}
		});
	});*/
}




function editar(){
	var inputModificar = document.getElementById("cambiarImagen");
	var idAutorFoto = document.getElementById("idAutorFoto").value;
	console.log("Estamos dentro de la función editar y se va a editar la publicación nº:"+inputModificar.value);
	console.log("Autor de la foto (ID):"+idAutorFoto);
	var idFoto = document.getElementById("idFoto").value;
	console.log("Ahora sí se va a editar la foto con ID: "+ idFoto);
	var palabra = document.getElementById("modificarTexto").value;
	if(inputModificar.value=="No"){
		$.ajax({
			async: false,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url: "PHP/editarFotoBackend.php", //Se llama a una página PHP que devuelva las publicaciones
			//url: "pruebaActualizar.php",
			data: "idPublicacion=" + idFoto+"&texto="+palabra,
			beforeSend: cargando, 
			success: resultadoEdicion, //Lo que devuelve la página se procesa con el método resultado publicación
			timeout: 4000,
			error: problemas
		});
	}else{
		var hayAlgo = false;
		//var textoPublicacion = "";
		var rutaFoto = ""
		if(palabra){
			hayAlgo = true;
			textoPublicacion = palabra;
		}else{
			textoPublicacion = "";
		}
		
		var fecha = new Date();
		var mes = fecha.getMonth()+1;
		var fechaFormateada = fecha.getFullYear()+"-"+mes+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
		var formData = new FormData();
		var imagenSubir;
		if($('#cambiarFoto')[0].files[0]){
			imagenSubir = $('#cambiarFoto')[0].files[0];
			console.log("IMAGEN: "+imagenSubir);
			//alert(imagenSubir.name);
			hayAlgo = true;
			//rutaFoto = fecha.getFullYear()+""+mes+""+fecha.getDate()+""+fecha.getHours()+""+fecha.getMinutes()+""+fecha.getSeconds()+"-"+cambiarFotocambiarFoto.files[0].name;
			rutaFoto = fecha.getFullYear()+""+mes+""+fecha.getDate()+""+fecha.getHours()+""+fecha.getMinutes()+""+fecha.getSeconds()+"-"+$('#cambiarFoto')[0].files[0].name;
		}
		if(hayAlgo){
			var rutaAntigua;
			if(document.getElementById("fotoAntigua")){
			rutaAntigua = document.getElementById("fotoAntigua").value;
			}
			console.log("Se ha leído la ruta antigua de la foto:"+rutaAntigua);
			var nuevaFoto = new foto(idFoto, fechaFormateada, idAutorFoto, "todo",  rutaFoto, textoPublicacion);
			var datosFoto = JSON.stringify(nuevaFoto);
			//alert(datosFoto);
			console.log("Fecha: "+fechaFormateada +". ruta: "+ rutaFoto)
			//alert("RUTA FOTO: "+rutaFoto);
			formData.append('file',imagenSubir);
			formData.append('datosFoto', datosFoto);
			formData.append('rutaAntigua', rutaAntigua);
			formData.append('textoPublicacion', textoPublicacion);
			$.ajax({
				url: 'PHP/editarFotoBackend.php',
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: resultadoEdicion
			});
		}else{
			alert("Debes incluir al menos texto o subir una imagen");
		}	

	}
}

function resultadoEdicion(datos){
	console.log(datos);
	try{
		alert(datos);
	}catch(error){
		alert(datos);
	}
	location.reload();
	//alert();
}

function borrar(idPublicacion){
	console.log("Vamos a borrar la foto/publicación con id "+idPublicacion);
	$.ajax({
		async: false,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/borrarFoto.php", //Se llama a una página PHP que devuelva las publicaciones
		data: "idPublicacion=" + idPublicacion,
		beforeSend: cargando, 
		success: procesarBorrado, //Lo que devuelve la página se procesa con el método resultado publicación
		timeout: 4000,
		error: problemas
	});
	
}

function procesarBorrado(datos){
	console.log(datos);
	alert(datos);
	location.reload();
}

function recargarFoto(idFoto){
	console.log("Recargar la foto/publicacion "+idFoto);
	$.ajax({
		async: true,
		type: "POST",
		dataType: "html",
		contentType: "application/x-www-form-urlencoded",
		url: "PHP/recargarFoto.php", //Se llama a una página PHP que devuelva las publicaciones
		data: "idFoto=" + idFoto,
		beforeSend: cargando, 
		success: mostrarDeNuevo, //Lo que devuelve la página se procesa con el método resultado publicación
		timeout: 4000,
		error: problemas
	});
}

function mostrarDeNuevo(datos){
	console.log("Datos recibidos: "+datos);
	var vectorInformacion = JSON.parse(datos);
	console.log("Vector parseado: "+vectorInformacion);
	var formulario = vectorInformacion[0];
	let idPublicacion = vectorInformacion[1];
	$("#ocultable"+idPublicacion).html(formulario);
	//$("#ocultable112").html(datos);
	//document.getElementById("cambiarFoto").style.visibility='hidden';
	var botonEliminarFoto = document.getElementById("botonEliminar");
	console.log("¿Hay botón de eliminar? "+botonEliminarFoto);
	//botonEliminarFoto.addEventListener('click', quitarFoto(idPublicacion));
	var modificarFoto = false;
	if(botonEliminarFoto){
		botonEliminarFoto.onclick=function(){
			//alert(idPublicacion);
			document.getElementById("cambiarFoto").style.visibility='visible';
			var idDivFoto = "divFoto"+idPublicacion;
			console.log(idDivFoto);
			var divFoto = document.getElementById(idDivFoto);
			var fotoAntigua = document.getElementById("imagenEditar").getAttribute("src");
			console.log("Ruta en disco de la foto antigua: "+fotoAntigua);
			divFoto.innerHTML="<input type='hidden' id='fotoAntigua' value='"+fotoAntigua+"'/>";
			var inputModificar = document.getElementById("cambiarImagen");
			inputModificar.value="Sí";
			//modificarFoto = true;
		};
	}else{
		document.getElementById("cambiarFoto").style.visibility='visible';
	}
	var botonModificar = document.getElementById("botonModificar");
	botonModificar.onclick = editar;

}

function cargarDetallesMarco(idFoto){
	//console.log("Pinchar: "+$("#foto"+idFoto).text());
	if($("#detallesFoto"+idFoto).text()=="Pincha para cargar detalles."){
		cargarComentarios(idFoto);
		cargarMeGustas(idFoto);
		$("#detallesFoto"+idFoto).text("Pincha de nuevo para ocultar los detalles. Si deseas interactuar con la publicación, ábrela en una nueva pestaña haciendo clic en el enlace de la fecha y la hora.");
		//$("#detallesFoto"+idFoto).click(ocultarDetalles());
		//¿Y si aquí hago que se borre todo?
	}else{
		$("#detallesFoto"+idFoto).text("Pincha para cargar detalles.");
		/*alert($("#detallesFoto"+idFoto).attr("onclick"));
		$("#detallesFoto"+idFoto).removeAttr("onclick");
		alert($("#detallesFoto"+idFoto).attr("onclick"));
		$("#detallesFoto"+idFoto).attr("onclick", ocultarDetalles());*/
		//¿Y si meto los métodos de carga aquí?
		$("#numeroMeGustas"+idFoto).html("");
		$('#comentarios'+idFoto).html("");

	}
	//alert($("#detallesFoto"+idFoto).text());
	/*$("#detallesFoto"+idFoto).toggle(function(){ //En función de lo que muestre el botón se mostrarán o no las opciones de administrador.
		if($("#detallesFoto"+idFoto).text()=="Pincha para cargar detalles"){
			//console.log("Texto mostrado"+$("#botonAdmin").html());
			alert("WTF");
			$("#detallesFoto"+idFoto).text("Pincha de nuevo para ocultar los detalles");
		}else{
			//console.log("Texto mostrado"+$("#botonAdmin").html());
			$("#detallesFoto"+idFoto).text("Pincha para cargar detalles");
		}
	});*/
}

/*function ocultarDetalles(){
	alert();
}*/