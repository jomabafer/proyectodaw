<?php
class publicacion{
	//Voy a considerar la posibilidad de incluir también su Id, aunque sea con un null cuando se instancie un objeto de esta clase para publicar.
	public $idPublicacion;
	/*private*/ public $fecha;
	/*private*/ public $permiso;
	/*private*/ public $idAutor; //No sé si incluir el autor de la publicación como uno de sus atributos.
	/*private*/ public $contenido;
	/*
	public function __construct($vectorDatos){
		$this->nombre = $vectorDatos[0];
		$this->apellidos = $vectorDatos[1];
		$this->correoE = $vectorDatos[2];
		$this->fnacimiento = $vectorDatos[3];
		$this->poblacion = $vectorDatos[4];
	}
	*/
	
	public function __construct($idPublicacion, $fecha, $permiso, $idAutor, $contenido){
		$this->idPublicacion = $idPublicacion;
		$this->fecha = $fecha;
		$this->permiso = $permiso;
		$this->idAutor = $idAutor;
		$this->contenido = $contenido;
	}
	
	public function getIdPublicacion(){
		return $this->idPublicacion;
	}
	
	public function setIdPublicacion($idPublicacion){
		$this->idPublicacion = $idPublicacion;
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
	
	public function getContenido(){
		return $this->contenido;
	}
	
	public function setContenido($contenido){
		$this->contenido = $contenido;
	}
}
?>