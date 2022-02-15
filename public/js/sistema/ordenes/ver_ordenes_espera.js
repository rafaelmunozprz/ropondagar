/**
 * 
 * @param {String} uuid codigo identificador de los productos dentro de una orden
 */
function ver_orden_espera(uuid) {
    MODAL_VER_ORDEN_ESPERA.modal('show')
    cargar_detalle_orden(uuid)
}

/**
 * 
 * @param {String} uuid codigo identificador de los productos dentro de una orden
 */
function cargar_detalle_orden(uuid) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/orden",
        data: `opcion=cargar_detalle_orden&uuid=${uuid}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            console.log(status)
        },
        success: function (response) {
            if (response.response == 'success') {
                CONTENEDOR_DATOS_ORDEN_ESPERA.html(ORDENES.cuerpo_articulos_orden_espera(response.data))
                $(".ver_historial_movimientos").off().on("click", function (e) {
                    MODAL_VER_ORDEN_ESPERA.modal("hide")
                    mostrar_historial_movimientos(uuid)
                })
            } else {
                Swal.fire(
                    `Error`,
                    '¡No hemos podido cargar los detalles de la orden',
                    'error'
                )
            }
        }
    });
}