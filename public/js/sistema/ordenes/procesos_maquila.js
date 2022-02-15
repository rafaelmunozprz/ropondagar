/**
 * 
 * @param {String} uuid cambia el estado de la orden a un estado '1_inicio_preparacion'
 */
function iniciar_proceso_maquila(uuid) {
    Swal.fire({
        title: `¿Iniciar orden #${uuid}?`,
        text: `¡Una vez iniciada la orden, solo un super administrador puede cancelar la orden`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, iniciar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: RUTA + "back/orden",
                data: `opcion=iniciar_proceso_maquila&uuid=${uuid}`,
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText)
                    console.log(status)
                },
                success: function (response) {
                    if (response.response == 'success') {
                        mostrar_ordenes_espera()
                        mostrar_ordenes_produccion()
                        Swal.fire(
                            `¡Orden #${uuid} iniciada!`,
                            '¡El grupo de preparación de material podrá ver este cambio!',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            `¡Opsss...!`,
                            '¡Algo ha salido mal, no hemos podido iniciar la orden!',
                            'success'
                        )
                    }
                }
            });
        }
    })
}

/**
 * 
 * @param {String} uuid identificador de la orden que será mostrada
 */
function mostrar_historial_movimientos(uuid){
    console.log(uuid)
    MODAL_HISTORIAL_MOVIMIENTOS.modal('show')
    //CONTENEDOR_HISTORIAS_MOVIMIENTOS.html(ORDENES.cuerpo_historial_movimientos(response.data))
}