<?php

	header('Content-type: text/html; charset=utf-8');
	require("database.php");
	require("usuario.php");
	require("foto.php");
	$idFoto = $_POST["idPublicacion"];
	$texto = $_POST["palabra"];
	$consulta = new database;
	$sql = 'update foto where set contenido = "'.$texto.'" idFoto ='.$idFoto;
	echo $sql;
	$foto;
	/*try{
		$resultadobusqueda = $consulta->conn->query($sql);
		if($resultadobusqueda){
				
				
			$registroFoto = $resultadobusqueda->fetch();
			if ($registroFoto != null){
				
				$foto = new foto($registroFoto[0], $registroFoto[1], $registroFoto[4], $registroFoto[3], $registroFoto[2], $registroFoto[5]);
			}
		}
	}catch(Exception $e){
		echo $e->getMessage();
		echo "Ha habido un error en la base de datos.";
		die();
	}*/
?>

<!--<div id="prueba">Hola</div>-->
--<form id="formulario" method='POST'>
	<input type='hidden' id="idFoto" value="<?php echo $foto->getidFoto();?>"/>
	<label for='cambiarFoto'>Modificar publicación:</label>
	<input id="cambiarFoto" name="subirFoto" type="file" accept=".png, .jpg, .jpeg"/><br/>
	<textarea rows="10" cols="40" id="modificarTexto" name="modificarTexto"><?php echo $foto->getTexto(); ?></textarea> <br/>
	<a id='botonModificar' class='btn btn-primary'>Modificar</a>
	<a id='botonCancelar' onclick='alert("Así no")' class='btn btn-primary'>Cancelar</a>
	
</form>
<br/>


<!--<button onclick=prueba("Probando")>Botón de prueba</button>
<button id="botonprueba" type="button" onclick=alert("Probando")>Otro botón de prueba</button>-->

<!--<script src="ajax1.js"></script>-->
