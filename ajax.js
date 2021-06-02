
addEventListener('load',inicializarEventos,false);
//var url = document.getElementById("redireccion").value; //No hay más remedio que captar este valor fuera de funciones ya que al aparecer html desde javascript, se pierde tras esa carga.
function inicializarEventos(){
	alert("Bienvenido a la red social del IES La Puebla. Introduce tus credenciales"); //Luego lo quitaré.
	var panelPrincipal = document.getElementById("panel"); //Le voy a poner de nombre panelPrincipal. Antes se llamaba formularioFaltas.
	console.log("Ha leído el panel.");
	var url = document.getElementById("redireccion").value;
	console.log("url: "+url);
	cargarForumlario(/*panelPrincipal*/);
	//console.log("Se va a leer el botón");
	//var botonEnviar = document.getElementById("enviarDatos");
	//console.log("Se ha leído el botón");
	//botonEnviar.addEventListener('click',conectar,false);
	
}
var conexionDatos;

function cargarForumlario(/*panelPrincipal*/){
	console.log("Vamos a cargar el formulario");
	conexionDatos = new XMLHttpRequest(); 
	conexionDatos.open("GET","formulario.html", true);
	conexionDatos.onreadystatechange = leerHtml;
	console.log("Ha intentado leer el formulario");
	conexionDatos.send();
	console.log("Ha intentado enviar el formulario");
	//var botonEnviar = document.getElementById("enviarDatos");
	//console.log(botonEnviar);
	//botonEnviar.addEventListener('click',conectar,false);
}

function leerHtml(){
	
	var panelPrincipal = document.getElementById("panel");
	
	if(conexionDatos.readyState == 4)
	{	
		panelPrincipal.innerHTML = conexionDatos.responseText;
		var botonEnviar = document.getElementById("enviarDatos");
		//No tengo más remedio que caputrar el botón aquí y escuchar el evento aquí.
		botonEnviar.addEventListener('click',conectar,false);
	} 
	else 
	{
		panelPrincipal.innerHTML = 'Cargando...';
	}
	console.log("Respuesta del PHP: "+conexionDatos.responseText);
}

function conectar(e){ //¿Seguro que es necesario el evento e? Debo consultar la documentación.
	e.preventDefault();
	console.log("Ha entrado en la función para conectar.");
	var usuario = document.getElementById("usuario").value;
	var clave = document.getElementById("clave").value;
	var url = document.getElementById("redireccion").value;
	console.log("URL de procesamiento: "+url);
	console.log('usuario='+usuario);
	console.log('clave='+clave);
	console.log('url='+url);
	conexionDatos=new XMLHttpRequest();  
	conexionDatos.onreadystatechange = validarDatos;
	conexionDatos.open("POST",url, true);
	conexionDatos.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	conexionDatos.send('usuario='+usuario+'&clave='+clave);	
}

	

function validarDatos(){
	
	var panelPrincipal = document.getElementById("panel");
	if(conexionDatos.readyState == 4)
	{		
		panelPrincipal.innerHTML = conexionDatos.responseText;
	} 
	else 
	{
		panelPrincipal.innerHTML = 'Cargando...';
	}
	console.log("Respuesta del PHP: "+conexionDatos.responseText);
}

