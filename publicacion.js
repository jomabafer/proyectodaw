class publicacion{
    constructor(idPublicacion, fecha, autor, permiso, contenido){
		//Voy a considerar la posibilidad de incluir también su Id y el Id de su autor
        this.idPublicacion = idPublicacion;
		this.fecha = fecha;
        this.autor = autor;
        this.permiso = permiso;
        this.contenido = contenido;
    }

	getIdPublicacion(){
        return this.idPublicacion;
    }

    setIdPublicacion(idPublicacion){
        this.idPublicacion=idPublicacion;
    }
	
    getFecha(){
        return this.fecha;
    }

    setFecha(fecha){
        this.fecha=fecha;
    }

    getAutor(){
        return this.autor;
    }

    setAutor(autor){
        this.autor=autor;
    }

    getPermiso(){
        return this.permiso;
    }

    setPermiso(permiso){
        this.permiso=permiso;
    }
	
	getContenido(){
        return this.contenido;
    }

    setContenido(contenido){
        this.contenido=contenido;
    }
	
}