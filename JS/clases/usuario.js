class usuario{
    constructor(idUsuario, nombre, apellidos, correoE, fnacimiento, poblacion, tipo, privacidad, rutaFoto){
		//Voy a considerar la posibilidad de incluir también su Id
        this.idUsuario = idUsuario;
		this.nombre = nombre;
        this.apellidos = apellidos;
        this.correoE = correoE;
        this.fnacimiento = fnacimiento;
		this.poblacion = poblacion;
		this.tipo = tipo;
		this.privacidad = privacidad;
		this.rutaFoto = rutaFoto;
    }

	getIdUsuario(){
        return this.idUsuario;
    }

    setUsuario(idUsuario){
        this.idUsuario=idUsuario;
    }
	
    getNombre(){
        return this.nombre;
    }

    setNombre(nombre){
        this.nombre=nombre;
    }

    getApellidos(){
        return this.apellidos;
    }

    setApellidos(apellidos){
        this.apellidos=apellidos;
    }

    getCorreoE(){
        return this.CorreoE;
    }

    setCorreoE(CorreoE){
        this.CorreoE=CorreoE;
    }
	
	getFnacimiento(){
        return this.fnacimiento;
    }

    setFnacimiento(fnacimiento){
        this.fnacimiento=fnacimiento;
    }
	
	getPoblacion(){
        return this.poblacion;
    }

    setPoblacion(poblacion){
        this.poblacion=poblacion;
    }
	
	getTipo(){
        return this.tipo;
    }

    setPoblacion(tipo){
        this.tipo=tipo;
    }
	
	getPrivacidad(){
        return this.privacidad;
    }

    setPrivacidad(privacidad){
        this.privacidad=privacidad;
    }
	
	getRutaFoto(){
        return this.rutaFoto;
    }

    setRutaFoto(rutaFoto){
        this.rutaFoto = rutaFoto;
    }
	
}