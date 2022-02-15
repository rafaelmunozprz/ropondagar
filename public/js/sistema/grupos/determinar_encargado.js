function determinar_encargado(id_grupo_trabajo) {  
    let MODAL_DETERMINAR_ENCARGADO = $("#modal_determinar_encargado")  
    $.ajax({
        type: "POST",
        url: RUTA + "back/grupos",
        data: `opcion=determinar_encargado&id_grupo_trabajo=${id_grupo_trabajo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                //MODAL_DETERMINAR_ENCARGADO.modal("show")
                let GRUPOS = new Grupos()
                let usuarios = response.data
                let contenedor_usuarios = $('#contenedor_usuarios_encargados')
                contenedor_usuarios.html(GRUPOS.cuerpo_mostrar_usuarios_encargados(usuarios))
            } else {         
                //MODAL_DETERMINAR_ENCARGADO.modal("hide")       
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `${response.text}`,
                })
                
            }
        }
    });
}
