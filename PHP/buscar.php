<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
	<head>
        <title>B&uacutesqueda </title>
		
		<!--<script src="ajax1.js"></script>-->
		<script src="jquery-3.4.1.js"></script>
		<script src="../JS/clases/usuario.js"></script>
    </head>
	
	<script>
		function ocultar(){
			console.log("Has cambiado el criterio de búsqueda. Ahora el correo electrónico está seleccionado: "+$("input[name='campoBusqueda']")[0].checked);
			if($("input[name='campoBusqueda']")[0].checked){
				console.log("Vas a buscar en función del correo nombre y de su localidad");
				$("input[name='checkNombreYPoblacion']").show();
				$("#nombre").show();
				$("#poblacion").show();
				$("#correoE").hide();
			}else{
				console.log("Vas a buscar en función de su correo electrónico");
				$("input[name='checkNombreYPoblacion']").hide();
				$("#nombre").hide();
				$("#poblacion").hide();
				$("#correoE").show();
			}
		}
		
		function buscarUsuario() {
			var nombre;
			var apellidos;
			var poblacion;
			var correoE;
			console.log("¿Nombre seleccionado? "+$("input[name='checkNombreYPoblacion']")[0].checked);
			if($("input[name='campoBusqueda']")[0].checked){
				console.log("Vas a buscar en función del nombre y de la localidad");
				if($("input[name='checkNombreYPoblacion']")[0].checked){
					console.log("Vas a buscar en función del nombre");
					nombre = $("#nombre").val();
					var indiceEspacio =  nombre.indexOf(" ");
					if (indiceEspacio!=-1){
						apellidos = nombre.substring(indiceEspacio+1);
						nombre = nombre.substring(0,indiceEspacio);
					}else{
						apellidos = "";
					}
				}else{
					nombre = "";
					apellidos = "";
				}
				if($("input[name='checkNombreYPoblacion']")[1].checked){
					console.log("Vas a buscar en función de la localidad");
					poblacion = $("#poblacion").val();
				}else{
					poblacion = "";
				}
			}else{
				nombre = "";
				apellidos = "";
				poblacion = "";
			}
			if($("input[name='campoBusqueda']")[1].checked){
				console.log("Vas a buscar en función correo electrónico");
				correoE = $("#correoE").val();
			}else{
				correoE = "";
			}
			console.log("los datos introducidos son: " + nombre + ", "+ poblacion + " y " +correoE);
			
			$.ajax({
				async: true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url: "PHP/buscarBackend.php",
				data: "nombre=" + nombre +"&apellidos="+ apellidos + "&correoE=" + correoE + "&poblacion=" + poblacion,
				beforeSend: comienzaBusqueda,
				success: terminaBusqueda,
				timeout: 4000,
				error: problemasBusqueda
			});
			return false;
		}

		function comienzaBusqueda() {
		  /*let x = $("#marcoBusqueda");
		  x.append('<img src="imagenes/cargando.gif">');*/
		  console.log("Buscando");
		}

		/*function terminaBusqueda(datos) {
		  $("#marcoBusqueda").html(datos);
		  
		}*/
		
		function terminaBusqueda(datos){
			var marcoBusqueda = $("#marcoBusqueda");
			//var marcoBusqueda = document.getElementById("marcoBusqueda");
			//marcoBusqueda.append("Resultado de la búsqueda:<br/>");
			//marcoBusqueda.append(datos);
			console.log("JSON recibido:"+datos);
			try{
				console.log("Vamos a convertir lo recibido en un vector");
				//var encontrado = JSON.parse(datos);
				//console.log("Amistades sin parsear: "+encontrado);
				//console.log("Primera amistad sin parsear: "+encontrado[0].nombre);
				//marcoBusqueda.innerHTML="Resultado de la búsqueda:<br/>" ;
				/*for(i=0; i<encontrado.length; i++){
					var dato = encontrado[i];
					console.log(dato);
					console.log("amistad " + i + ": Nombre: "+dato.nombre+". Apellidos:"+ dato.apellidos +". Correo electrónico: "+dato.correoE+". Fecha de nacimiento: "+dato.fnacimiento+". Población: "+dato.poblacion);
					var amistadRescatada = new usuario(dato.idUsuario,dato.nombre, dato.apellidos, dato.correoE, dato.fNacimiento, dato.poblacion, dato.tipo);
					marcoBusqueda.innerHTML= marcoBusqueda.innerHTML+"<a href='detallesUsuario.php?idUsuario="+amistadRescatada.getIdUsuario()+"'>"+ amistadRescatada.getNombre() + " " + amistadRescatada.getApellidos() + "</a><br/>";
					
				}*/
				marcoBusqueda.html(datos);
			}catch(err){
				console.log("Ha habido una excepción: "+err);
				marcoBusqueda.html("Ha habido una excepción: <br/>"+err+"<br/>"+datos);
			}
				
		}

		function problemasBusqueda() {
		  /*$("#marcoBusqueda").text('Problemas en el servidor.');*/
		}

		function algo(){
			
			var nombre = $("#nombre").val();
			var poblacion = $("#poblacion").val();
			var correoE = $("#correoE").val();
			console.log("los datos introducidos son: " + nombre + ", apellidos: "+ apellidos+ ", "+ poblacion + " y " +correoE);
			return false;
		}
		
	</script>
    <body>
		<div id="marcoBusqueda">
			<!--<form onsubmit="buscarUsuario()">-->
			<form>
			<!--<form >-->
				<!--<input name="campoBusqueda" type="radio" value="nombrePoblacion" onchange="$("input[name='checkNombreYPoblacion']").toggle()">-->
				<input name="campoBusqueda" type="radio" value="nombrePoblacion" onclick="ocultar()" checked>
					Buscar por nombre y población:<br/> <!--Estaría bien poder hacer desaparecer sus opciones si esto no se elige-->
					<input name="checkNombreYPoblacion" type="checkbox"/>
					<input id="nombre" type="text" placeholder="Nombre y apellidos"/><br/>
					<input name="checkNombreYPoblacion" type="checkbox"/>
					<input id="poblacion" type="text" placeholder="Población"/><br/>
				</input>
				<input name="campoBusqueda" type="radio" onclick="ocultar()" value="Correo"/>
					Buscar por correo electrónico:<br/>
					<input id="correoE" type="text" placeholder="Correo electrónico"/><br/>
				</input>
				<br/><input type="submit" value="Buscar" onclick="return buscarUsuario()"/>
			</form>
		</div>
    </body>
</html>

<!-- Creo que esto va a ser un cuadro que ocultable que mostrará los resultados
select * from usuario where concat (nombre, " ", apellidos) like "%ad%" and concat(nombre, " ", apellidos) like "%min%";
select * from usuario where correoE = "admin@admin.admin";
select * from usuario where poblacion = "adra"-->