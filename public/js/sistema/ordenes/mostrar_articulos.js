/**
 * Muestra los articulos de una orden nueva desde localstorage
 */
function mostrar_articulos() {
    let orden = ORDENES_STORAGE.cargar_orden()
    let cuerpo = ""
    if (orden.length < 1) {
        cuerpo += `
                <tr>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning text-center">Sin resultados</td>
                </tr>
            `
    } else {
        for (const articulo of orden) {
            cuerpo += `
                <tr>
                    <td>${articulo.codigo}</td>
                    <td>${articulo.cantidad}</td>
                    <td class="text-danger text-center eliminar_articulo_lista" eliminar_articulo_lista="${articulo.codigo}"><i class="fas fa-trash-alt"></i></td>
                </tr>
            `
        }
    }
    CONTENEDOR_ORDEN.html(cuerpo)

    $(".eliminar_articulo_lista").off().on("click", function (e) {
        e.preventDefault()
        let id_modelo = $(this)
        id_modelo = id_modelo.attr("eliminar_articulo_lista")
        eliminar_articulo_lista(id_modelo)
        mostrar_articulos()
    })
}

/**
 * 
 * @param {String} id_modelo modelo que será eliminado de la lista en localstorage
 */
function eliminar_articulo_lista(id_modelo) {
    ORDENES_STORAGE.eliminar_articulo(id_modelo)
}