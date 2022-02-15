/**
 * 
 * @param {Number} id_grupo_trabajo identificador unico del grupo en la base de datos
 */
function opciones(id_grupo_trabajo) {
    let MODAL_OPCIONES = $("#modal_opciones_grupo_trabajo")
    MODAL_OPCIONES.modal("show")

    $("#editar_grupo_trbajo").off().on('click', function (e) {
        MODAL_OPCIONES.modal("hide")
        let MODAL_EDITAR_GRUPO = $("#modal_editar_grupo_trabajo")
        MODAL_EDITAR_GRUPO.modal("show")
        editar(id_grupo_trabajo)
    })

    $("#determinar_encargado").off().on('click', function (e) {
        MODAL_OPCIONES.modal("hide")
        //determinar_encargado(id_grupo_trabajo)        
    })

    $("#agregar_personal_grupo_trabajo").off().on('click', function (e) {
        MODAL_OPCIONES.modal("hide")
        let MODAL_AGREGAR_PERSONAL = $("#modal_agregar_personal_grupo_trabajo")
        mostrar_personal_agregar(id_grupo_trabajo)
        MODAL_AGREGAR_PERSONAL.modal("show")
    })

    $("#eliminar_personal_grupo_trabajo").off().on('click', function (e) {
        MODAL_OPCIONES.modal("hide")
        let MODAL_ELIMINAR_PERSONAL = $("#modal_eliminar_personal_grupo_trabajo")
        MODAL_ELIMINAR_PERSONAL.modal("show")
    })

    $("#eliminar_grupo_trabajo").off().on('click', function (e) {
        MODAL_OPCIONES.modal("hide")
        eliminar(id_grupo_trabajo)
    })

}