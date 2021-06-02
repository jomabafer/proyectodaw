<?php
class usuario{
	/*Debido a que a la hora de usar JSON para pasar objetos de esta clase al código Javascript el método 
	que convierte un objeto a JSON no puede acceder a los atributos privados, he tenido que hacerlos públicos
	pese a que no me gusta nada y le quita el sentido de existir a los métodos get y set de cada atributo.*/
	//Voy a considerar la posibilidad de incluir también su Id aunque lo ponga en null cuando vaya a registrar
	//usuario en la base de datos.
	public $idUsuario;
	/*private*/ public $nombre;
	/*private*/ public $apellidos;
	/*private*/ public $correoE;
	/*private*/ public $fnacimiento;
	/*private*/ public $poblacion;
	/*private*/ public $tipo;
	public $privacidad;
	public $rutaFoto;
	
	
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
		$this->idUsuario = $vectorDatos[0];
		$this->nombre = $vectorDatos[1];
		$this->apellidos = $vectorDatos[2];
		$this->correoE = $vectorDatos[3];
		$this->fnacimiento = $vectorDatos[4];
		$this->poblacion = $vectorDatos[5];
		$this->tipo = $vectorDatos[6];
		$this->privacidad = $vectorDatos[7];
		$this->rutaFoto = $vectorDatos[8];
	}
	
	public function __construct9($idUsuario, $nombre, $apellidos, $correoE, $fnacimiento, $poblacion, $tipo, $privacidad, $rutaFoto){
		//public function __construct($idUsuario, $nombre, $apellidos, $correoE, $fnacimiento, $poblacion, $tipo){
		$this->idUsuario = $idUsuario;
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->correoE = $correoE;
		$this->fnacimiento = $fnacimiento;
		$this->poblacion = $poblacion;
		$this->tipo = $tipo;
		$this->privacidad = $privacidad;
		$this->rutaFoto = $rutaFoto;
	}
	
	public function getIdUsuario(){
		return $this->idUsuario;
	}
	
	public function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getApellidos(){
		return $this->apellidos;
	}
	
	public function setApellidos($apellidos){
		$this->apellidos = $apellidos;
	}
	
	public function getCorreoE(){
		return $this->correoE;
	}
	
	public function setCorreoE($correoE){
		$this->apellidos = $correoE;
	}
	
	public function getFnacimiento(){
		return $this->fnacimiento;
	}
	
	public function setFnacimiento($fnacimiento){
		$this->fnacimiento = $fnacimiento;
	}
	
	public function getPoblacion(){
		return $this->poblacion;
	}
	
	public function setPoblacion($poblacion){
		$this->poblacion = $poblacion;
	}
	
	public function getTipo(){
		return $this->tipo;
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function getPrivacidad(){
		return $this->privacidad;
	}
	
	public function setPrivacidad($privacidad){
		$this->privacidad = $privacidad;
	}
	
	public function getRutaFoto(){
		return $this->rutaFoto;
	}
	
	public function setRutaFoto(){
		$this->rutaFoto = $rutaFoto;
	}
}
?>