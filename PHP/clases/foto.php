<?php
class foto{
	//Voy a considerar la posibilidad de incluir también su Id, aunque sea con un null cuando se instancie un objeto de esta clase para publicar.
	public $idFoto;
	/*private*/ public $fecha;
	/*private*/ public $permiso;
	/*private*/ public $idAutor; //No sé si incluir el autor de la publicación como uno de sus atributos.
	/*private*/ public $rutaFoto;
	/*private*/ public $texto;
	/*
	public function __construct($vectorDatos){
		$this->nombre = $vectorDatos[0];
		$this->apellidos = $vectorDatos[1];
		$this->correoE = $vectorDatos[2];
		$this->fnacimiento = $vectorDatos[3];
		$this->poblacion = $vectorDatos[4];
	}
	*/
	
	public function __construct($idFoto, $fecha, $permiso, $idAutor, $rutaFoto, $texto){
		$this->idFoto = $idFoto;
		$this->fecha = $fecha;
		$this->permiso = $permiso;
		$this->idAutor = $idAutor;
		$this->rutaFoto = $rutaFoto;
		$this->texto = $texto;
	}
	
	public function getidFoto(){
		return $this->idFoto;
	}
	
	public function setidFoto($idFoto){
		$this->idFoto = $idFoto;
	}
	
	public function getFecha(){
		return $this->fecha;
	}
	
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
	
	public function getPermiso(){
		return $this->permiso;
	}
	
	public function setPermiso($permiso){
		$this->permiso = $permiso;
	}
	
	public function getIdAutor(){
		return $this->idAutor;
	}
	
	public function setIdAutor($idAutor){
		$this->idAutor = $idAutor;
	}
	
	public function getRutaFoto(){
		return $this->rutaFoto;
	}
	
	public function setRutaFoto($rutaFoto){
		$this->rutaFoto = $rutaFoto;
	}
	public function getTexto(){
		return $this->texto;
	}
	
	public function setTexto($texto){
		$this->texto = $texto;
	}
}
?>