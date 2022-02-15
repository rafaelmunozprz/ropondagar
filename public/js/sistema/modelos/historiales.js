/**
 * 
 * @param {String} buscar codigo que será buscado entre las actualizaciones, el orden mostrará siempre el último producto ingresado 
 * @param {JSON} historial objeto que contiene todos los resultados de la respuesta 
 */
function traer_historial_hoy(buscar = "", historial = false) {
    let contenedor_hoy = $("#contenedor_hoy")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=traer_historial_hoy&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                let MODELOS = new Modelos()
                let respuesta = response.data
                contenedor_hoy.html(MODELOS.mostrar_historial(respuesta))
            } else {
                contenedor_hoy.html(`
                    <tr>
                        <td>Sin resultados</td>
                        <td>Sin resultados</td>
                        <td>Sin resultados</td>
                        <td>Sin resultados</td>
                    </tr>    
                `)
            }
        }
    });
}

/**
 * 
 * @param {String} buscar codigo que será buscado entre las actualizaciones, el orden mostrará siempre el último producto ingresado 
 * @param {JSON} historial objeto que contiene todos los resultados de la respuesta 
 */
function traer_historial_ayer(buscar = "", historial = false) {
    let contenedor_ayer = $("#contenedor_ayer")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=traer_historial_ayer&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                let MODELOS = new Modelos()
                let respuesta = response.data
                contenedor_ayer.html(MODELOS.mostrar_historial(respuesta))
            } else {
                contenedor_ayer.html(`
                <tr>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                </tr>    
            `)
            }
        }
    });
}

/**
 * 
 * @param {String} buscar codigo que será buscado entre las actualizaciones, el orden mostrará siempre el último producto ingresado 
 * @param {JSON} historial objeto que contiene todos los resultados de la respuesta 
 */
function traer_historial_siete_dias(buscar = "", historial = false) {
    let contenedor_siete_dias = $("#contenedor_siete_dias")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=traer_historial_siete_dias&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                let MODELOS = new Modelos()
                let respuesta = response.data
                contenedor_siete_dias.html(MODELOS.mostrar_historial(respuesta))
            } else {
                contenedor_siete_dias.html(`
                <tr>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                </tr>    
            `)
            }
        }
    });
}

/**
 * 
 * @param {String} buscar codigo que será buscado entre las actualizaciones, el orden mostrará siempre el último producto ingresado 
 * @param {JSON} historial objeto que contiene todos los resultados de la respuesta 
 */
function traer_historial_treinta_dias(buscar = "", historial = false) {
    let contenedor_treinta_dias = $("#contenedor_treinta_dias")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=traer_historial_treinta_dias&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                let MODELOS = new Modelos()
                let respuesta = response.data
                contenedor_treinta_dias.html(MODELOS.mostrar_historial(respuesta))
            } else {
                contenedor_treinta_dias.html(`
                <tr>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                    <td>Sin resultados</td>
                </tr>    
            `)
            }
        }
    });
}

/**
 * 
 * @param {Number} pagina número de pagina en la cual se encutra la paginacion
 * @param {String} buscar codigo que será buscado entre las actualizaciones, el orden mostrará siempre el último producto ingresado 
 * @param {JSON} historial objeto que contiene todos los resultados de la respuesta 
 */
function traer_historial_siempre(pagina = 1, buscar = "", historial = false) {
    let button = $("#paginacion_siempre")
    let contenedor_siempre = $("#contenedor_siempre")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`)
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=traer_historial_siempre&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            button.parent().hide()
        },
        success: function (response) {
            if (response.response === 'success') {
                const MODELOS = new Modelos()
                const respuesta = response.data

                button.parent().show()

                if (pagina <= 1) contenedor_siempre.html(MODELOS.mostrar_historial(respuesta))
                else contenedor_siempre.append(MODELOS.mostrar_historial(respuesta))

                let paginar = true
                let pg = response.pagination
                let limite = (pg.page * pg.limit)
                if (limite >= pg.total) paginar = false

                if (!paginar) button.parent().hide()

                button.off().on('click', function () {
                    let button = $(this);
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                    button.off();
                    setTimeout(() => {
                        traer_historial_siempre(pagina + 1, buscar);
                    }, 500);
                });
            } else {
                button.parent().hide();
                if (pagina == 1) contenedor_siempre.html(`
                    <tr>
                        <td>Sin resultados</td>
                        <td>Sin resultados</td>
                        <td>Sin resultados</td>
                        <td>Sin resultados</td>
                    </tr>    
                `);
            }
        }
    });
}

/**
 * 
 * @param {Number} pagina número de pagina en la cual se encutra la paginacion
 * @param {String} buscar codigo que será buscado entre las actualizaciones, el orden mostrará siempre el último producto ingresado 
 * @param {JSON} historial objeto que contiene todos los resultados de la respuesta 
 */
function traer_historial_personalizado(pagina = 1, buscar = "", historial = false) {

}