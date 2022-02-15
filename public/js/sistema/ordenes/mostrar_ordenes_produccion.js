$(document).ready(function () {
    mostrar_ordenes_produccion()
    $("#form_ordenes_produccion").off().submit(function (e) {
        e.preventDefault()
        let form = $(this)
        let buscador_ordenes_produccion = form.find("[name=buscador_ordenes_produccion]").val()
        setTimeout(() => {
            mostrar_ordenes_produccion(1, buscador_ordenes_produccion)
        }, 500)
    })
});

/**
 * 
 * @param {Number} pagina número de pagina de 9 ordenes que serán mostradas
 * @param {String} buscar numero de orden que será mostrada
 * @param {Object} ordenes_json objeto de los productos extraidos despues de la primera búsqueda
 */
function mostrar_ordenes_produccion(pagina = 1, buscar = "", ordenes_json = false) {
    let button = $("#paginacion_produccion")
    let contenedor = $("#contenedor_ordenes_produccion")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    button.html(`Mostras más <i class="fas fa-arrow-circle-down mx-2"></i>`)
    $.ajax({
        type: "POST",
        url: RUTA + "back/orden",
        data: `opcion=mostrar_ordenes_produccion&pagina=${pagina}&buscar=${buscar}`,
        dataType: 'JSON',
        error: function (xhr, status) {
            console.log(xhr.responseText)
            button.parent().hide()
        },
        success: function (response) {
            if (response.response == 'success') {
                let ORDEN = new Ordenes()
                let respuesta = response.data

                button.parent().show()

                if (pagina <= 1) contenedor.html(ORDEN.cuerpo_mostrar_ordenes_produccion(respuesta))
                else contenedor.append(ORDEN.cuerpo_mostrar_ordenes_produccion(respuesta))

                /** Validación de más paginacion*/
                let paginar = true
                let pg = response.pagination
                let limite = (pg.page * pg.limit)
                if (limite >= pg.total) paginar = false

                if (!paginar) button.parent().hide();

                button.off().on('click', function (e) {
                    e.preventDefault()
                    let button = $(this)
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                    button.off();
                    setTimeout(() => {
                        mostrar_ordenes_produccion(pagina + 1, buscar);
                    }, 500);
                })

                $(".ver_orden_espera").off().on('click', function (e) {
                    e.preventDefault()
                    let uuid = $(this)
                    ver_orden_espera(uuid.attr('ver_orden_espera'))
                })

                $(".siguiente_estado").off().on('click', function (e) {
                    e.preventDefault()
                    let values = $(this), uuid = values.attr('uuid'), siguiente_estado = values.attr('siguiente_estado')
                    avanzar_estado(uuid, siguiente_estado)
                })
            } else {
                button.parent().hide();
                if (pagina == 1) contenedor.html(`
                    <tr>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                        <td class="bg-warning">Sin resultados</td>
                    </tr>`);
            }
        }
    });
}

/**
 * 
 * @param {String} uuid 
 * @param {String} siguiente_estado 
 */
function avanzar_estado(uuid, siguiente_estado) {
    Swal.fire({
        title: '¿Quieres avanzar?',
        text: `¡Estas indicando que el proceso de la orden #${uuid} está cambiando de estado!
        ¡Esta acción no puede deshacerse!`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, seguir proceso!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: RUTA + "back/orden",
                data: `opcion=avanzar_estado&uuid=${uuid}&siguiente_estado=${siguiente_estado}`,
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText)
                    console.log(status)
                },
                success: function (response) {
                    if (response.response === 'success') {
                        console.log(response.text)
                        Swal.fire(
                            'Orden actualizada!',
                            `Hemos actualizado la orden #${uuid}.`,
                            'success'
                        )
                        mostrar_ordenes_produccion()
                    } else {
                        Swal.fire(
                            '¡Error!',
                            `No hemos podido actualizar el estado de la orden #${uuid}.`,
                            'error'
                        )
                    }
                }
            });
        }
    })
}