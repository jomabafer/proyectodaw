class foto{
    constructor(idFoto, fecha, autor, permiso, rutaFoto, texto){
		//Voy a considerar la posibilidad de incluir también su Id y el Id de su autor
        this.idFoto = idFoto;
		this.fecha = fecha;
        this.autor = autor;
        this.permiso = permiso;
        this.rutaFoto = rutaFoto;
		this.texto = texto;
    }

	getIdFoto(){
        return this.idFoto;
    }

    setIdFoto(idFoto){
        this.idFoto=idFoto;
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
	
	getRutaFoto(){
        return this.rutaFoto;
    }

    setRutaFoto(rutaFoto){
        this.rutaFoto=rutaFoto;
    }
	
	getTexto(){
        return this.texto;
    }

    setTexto(texto){
		this.texto = texto;
    }
	
}