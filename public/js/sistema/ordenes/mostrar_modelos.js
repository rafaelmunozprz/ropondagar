

function mostrar_modelos_nueva_orden(codigo) {
    let contenedor = $("#contenedor_modelos")
    let ORDENES = new Ordenes()
    $.ajax({
        type: "POST",
        url: RUTA + "back/orden",
        data: `opcion=mostrar_modelo&codigo=${codigo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            console.log(status)
        },
        success: function (response) {
            if (response.response == 'success') {
                contenedor.html(ORDENES.cuerpo_modelo_lista(response.data))
                $(".anadir_modelo").off().on("click", function (e) {
                    let id_modelo = $(this)
                    agregar_lista(id_modelo.attr('data-idmodelo'), response.data.codigo, response.data)
                })
            } else {
                contenedor.html(ORDENES.cuerpo_modelos_lista_error())
            }
        }
    })
}

function agregar_lista(id_modelo, codigo) {
    MODAL_NUEVA_ORDEN.modal('hide')
    Swal.fire({
        title: 'Cantidad',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Agregar',
        showLoaderOnConfirm: true,
        preConfirm: (response) => { return response; },
    }).then((result) => {
        if (!isNaN(result.value)) {
            ORDENES_STORAGE.guardar_en_lista(id_modelo, codigo, result.value)
            mostrar_articulos()
            MODAL_NUEVA_ORDEN.modal('show')
        } else {
            MODAL_NUEVA_ORDEN.modal('show')
            toastr['error']('Solo puedes agregar carácteres del 0-9');
        }
    });
}

