<?php
class usarProcedimiento{
	
	function abrirProcedimiento($nombreArchivo){
	  $archivo = fopen($nombreArchivo, "r") or
		die("No se pudo abrir el archivo");
		$texto="";
	  while (!feof($archivo)) {
		$linea = fgets($archivo);
		$nuevaLinea = nl2br($linea);
		$texto = $texto. $nuevaLinea;
	  }
	  fclose($archivo);
	  return $texto;
	}
}
?>