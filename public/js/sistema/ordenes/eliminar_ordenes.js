/**
 * 
 * @param {String} uuid identificador del número de orden, este ID eliminará tanto los articulos de la orden como la orden
 */
function eliminar_ordenes_espera(uuid) {
    Swal.fire({
        title: '¿Eliminar orden?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: RUTA + "back/orden",
                data: `opcion=eliminar_ordenes_espera&uuid=${uuid}`,
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText)
                    console.log(status)
                },
                success: function (response) {
                    if (response.response == 'success') {
                        mostrar_ordenes_espera()
                        Swal.fire({
                            icon: 'success',
                            title: '¡Orden eliminada!',
                            text: '¡Orden eliminada exitosamente!',
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `¡No hemos eliminar la orden #${uuid}!`,
                        })
                    }
                }
            })
        }
    })

}