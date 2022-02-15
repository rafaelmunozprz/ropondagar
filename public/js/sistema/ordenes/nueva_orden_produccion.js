let MODAL_NUEVA_ORDEN = $("#modal_nueva_orden")
let MODAL_VER_ORDEN_ESPERA = $("#modal_editar_nueva_orden")
let MODAL_HISTORIAL_MOVIMIENTOS = $("#modal_historial_cambios")
let CONTENEDOR_MODELOS = $("#contenedor_modelos")
let CONTENEDOR_ORDEN = $("#datos_orden")
let CONTENEDOR_ORDENES_ESPERA = $("#contenedor_ordenes_espera")
let CONTENEDOR_DATOS_ORDEN_ESPERA = $("#datos_orden_espera")
let ORDENES = new Ordenes()
let ORDENES_STORAGE = new OrdenesStorage()
const ID_USUARIO = $("#id_usuario")

$('#nueva_orden_produccion').off().on('click', function (e) {
    mostrar_articulos()
    MODAL_NUEVA_ORDEN.modal('show')
    $("#form_modelos").off().submit(function (e) {
        e.preventDefault()
        let form = $(this)
        let codigo = form.find("[name=buscador_modelos]")

        let error_cont = 0
        $(".has-error").removeClass("has-error")
        $(".ntf_form").remove()

        const FUNC = new Funciones()
        const EXPRESION = FUNC.EXPRESION()

        if (codigo.val() == '' || codigo.val().length < 2 || !((EXPRESION.text).test(codigo.val()))) {
            error_cont++;
            codigo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El código no puede estar vacío o ser menor a 3 caracteres, recuerda que solo debes de utilizar letras de la A-Z y números del 0-9.</small>`);
        }
        if (error_cont === 0) {
            mostrar_modelos_nueva_orden(codigo.val())
        }
    })
})

$("#guardar_orden").off().on("click", function (e) {
    e.preventDefault()
    let orden = ORDENES_STORAGE.cargar_orden()
    if (orden.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '¡No podemos crear órdenes sin artículos!',
        })
    } else {
        crear_orden_nueva(orden)
    }
})

/**
 * 
 * @param {Object} orden catálogo de productos que serán agregados en la base de datos
 */
function crear_orden_nueva(orden) {
    orden = JSON.stringify(orden)
    $.ajax({
        type: "POST",
        url: RUTA + "back/orden",
        data: `opcion=crear_orden_nueva&orden=${orden}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            console.log(status)
        },
        success: function (response) {
            if (response.response == 'success') {
                MODAL_NUEVA_ORDEN.modal('hide')
                ORDENES_STORAGE.limpiar_orden_nueva()
                mostrar_ordenes_espera()
                Swal.fire({
                    icon: 'success',
                    title: '¡Orden generada!',
                    text: '¡Orden generada exitosamente!',
                })
            } else {                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡No podemos crear órdenes sin artículos!',
                })
            }
        }
    });
}