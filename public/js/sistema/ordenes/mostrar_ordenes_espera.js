$("#ordenes_espera-tab").off().on("click", function (e) {
    mostrar_ordenes_espera()
})

/**
 * Muestra todas las ordenes que tengan un estado="0_espera"
 */
function mostrar_ordenes_espera() {
    $.ajax({
        type: "POST",
        url: RUTA + "back/orden",
        data: `opcion=mostrar_ordenes_espera`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            console.log(status)
        },
        success: function (response) {
            if (response.response == 'success') {
                CONTENEDOR_ORDENES_ESPERA.html(ORDENES.cuerpo_lista_ordenes_espera(response.data))
                /**
                 * Llamado a la funcion eliminar orden de la base de datos
                 */
                $(".eliminar_orden_espera").off().on("click", function (e) {
                    e.preventDefault()
                    let uuid = $(this)
                    uuid = uuid.attr("eliminar_orden_espera")
                    eliminar_ordenes_espera(uuid)
                })

                /**
                 * Llamado al inicio de una orden (esta no podrá ser eliminada)
                 */
                $(".iniciar_orden_espera").off().on("click", function (e) {
                    let uuid = $(this)
                    uuid = uuid.attr("iniciar_orden_espera")
                    iniciar_proceso_maquila(uuid)
                })

                /**
                 * Llamado a la base de datos para mostrar los articulo de una orden
                 */
                $(".ver_orden_espera").off().on("click", function (e) {
                    let uuid = $(this)
                    uuid = uuid.attr("ver_orden_espera")
                    ver_orden_espera(uuid)
                })
            } else {
                let cuerpo = `
                    <tr>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                    </tr>`
                CONTENEDOR_ORDENES_ESPERA.html(cuerpo)
            }
        }
    })
}