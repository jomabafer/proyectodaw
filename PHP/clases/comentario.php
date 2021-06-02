<?php
class comentario{
	/*Debido a que a la hora de usar JSON para pasar objetos de esta clase al código Javascript el método 
	que convierte un objeto a JSON no puede acceder a los atributos privados, he tenido que hacerlos públicos
	pese a que no me gusta nada y le quita el sentido de existir a los métodos get y set de cada atributo.*/
	//Voy a considerar la posibilidad de incluir también su Id aunque lo ponga en null cuando vaya a registrar
	//usuario en la base de datos.
	public $idComentario;
	public $idPublicacion;
	/*private*/ public $textoComentario;
	/*private*/ public $fechaComentario;
	
	
	/*Dependiendo de la situación, instancio objetos de esta clase de diferentes maneras, así que he creado*
	un constructor sobrecargado*/
	function __construct(){
		$parametros = func_get_args();
		$num_parametros = func_num_args();
		$funcion_constructor ='__construct'.$num_parametros;
		if (method_exists($this,$funcion_constructor)){
			call_user_func_array(array($this,$funcion_constructor),$parametros);
		}
	}
	
	public function __construct1($vectorDatos){
		$this->idComentario = $vectorDatos[0];
		$this->idPublicacion = $vectorDatos[1];
		$this->textoComentario = $vectorDatos[2];
		$this->fechaComentario = $vectorDatos[3];
	}
	
	public function __construct4($idComentario, $idPublicacion, $textoComentario, $fechaComentario){
		$this->idComentario = $idComentario;
		$this->idPublicacion = $idPublicacion;
		$this->textoComentario = $textoComentario;
		$this->fechaComentario = $fechaComentario;
	}
	
	public function getIdPublicacion(){
		return $this->idPublicacion;
	}
	
	public function setIdUsuario($idPublicacion){
		$this->idPublicacion = $idPublicacion;
	}
	
	public function getTextoComentario(){
		return $this->textoComentario;
	}
	
	public function setTextoComentario($textoComentario){
		$this->textoComentario = $textoComentario;
	}
	
	public function getFechaComentario(){
		return $this->fechaComentario;
	}
	
	public function setFechaComentario($fechaComentario){
		$this->fechaComentario = $fechaComentario;
	}
	
}
?>