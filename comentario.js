class comentario{
    constructor(idComentario,idPublicacion, fecha, textoComentario){
		//Voy a considerar la posibilidad de incluir también su Id y el Id de su autor
        this.idComentario = idComentario;
		this.idPublicacion = idPublicacion;
        this.textoComentario = textoComentario;
		this.fecha = fecha;
    }

	getIdComentario(){
        return this.idComentario;
    }

    setIdComentario(idComentario){
        this.idComentario=idComentario;
    }

	getIdPublicacion(){
        return this.idPublicacion;
    }

    setIdPublicacion(idPublicacion){
        this.idPublicacion=idPublicacion;
    }
	
	getTextoComentario(){
        return this.textoComentario;
    }

    setTextoComentario(textoComentario){
        this.textoComentario=textoComentario;
    }
	
    getFecha(){
        return this.fecha;
    }

    setFecha(fecha){
        this.fecha=fecha;
    }

	
}