/**
 * @param {Number} id_grupo_trabajo identificador único del grupo en base de datos
 */
function eliminar(id_grupo_trabajo) {
    let GRUPOS = new Grupos()
    Swal.fire({
        title: '¿Eliminar?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            GRUPOS.eliminar_grupo(id_grupo_trabajo)
        }
    })

}