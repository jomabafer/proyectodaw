addEventListener('load',inicializarEventos,false);
function inicializarEventos(){
	//llamaCancelar();
	console.log("Hola");
}

function llamaCancelar(){
	var info=document.getElementById("prueba");
	info.addEventListener('click',cancelar,false);
}
function cancelar(e){
	e.preventDefault();
	console.log(e.target.getAttribute('href'));
	alert(e.target.getAttribute('href'));
}

