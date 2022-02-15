$("#ordenes_finalizadas-tab").off().on("click", function (e) {
    e.preventDefault()
    mostrar_ordenes_finalizadas()
    $("#form_ordenes_finalizadas").off().submit(function (e) {
        e.preventDefault()
        let formulario_busqueda = $(this)
        let busqueda = formulario_busqueda.find("[name=buscador_ordenes_finalizadas]").val()
        setTimeout(function () {
            mostrar_ordenes_finalizadas(1, busqueda)
        }, 500)
    })
})

/**
 * 
 * @param {Number} pagina 
 * @param {String} buscar 
 * @param {JSON} ordenes_finalizadas_json 
 */
function mostrar_ordenes_finalizadas(pagina = 1, buscar = "", ordenes_finalizadas_json = false) {
    let button = $("#paginacion_finalizadas"),
        contenedor = $("#contenedor_ordenes_finalizadas"),
        borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    button.html(`Mostras más <i class="fas fa-arrow-circle-down mx-2"></i>`)
    $.ajax({
        type: "POST",
        url: RUTA + "back/orden",
        data: `opcion=mostrar_ordenes_finalizadas&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            console.log(status)
        },
        success: function (response) {
            if (response.response == 'success') {
                let ORDEN = new Ordenes()
                let respuesta = response.data
                button.parent().show()
                if (pagina <= 1) contenedor.html(ORDEN.cuerpo_mostrar_ordenes_finalizadas(respuesta))
                else contenedor.append(ORDEN.cuerpo_mostrar_ordenes_finalizadas(respuesta))

                /** Validación de más paginacion*/
                let paginar = true
                let pg = response.pagination
                let limite = (pg.page * pg.limit)
                if (limite >= pg.total) paginar = false

                if (!paginar) button.parent().hide()

                button.off().on('click', function (e) {
                    e.preventDefault()
                    let button = $(this)
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                    button.off();
                    setTimeout(() => {
                        mostrar_ordenes_finalizadas(pagina + 1, buscar)
                    }, 500);
                })

                $(".ver_orden_finalizada").off().on('click', function (e) {
                    e.preventDefault()
                    let uuid = $(this)
                    ver_orden_espera(uuid.attr('ver_orden_finalizada'))
                })
                

            } else {
                button.parent().hide();
                if (pagina == 1) contenedor.html(`
                <tr>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                </tr>`)
            }
        }
    });
}