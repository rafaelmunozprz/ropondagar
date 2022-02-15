$(document).ready(function () {
    let id_nota = $("#id_nota").val();

    traer_nota(id_nota).then(() => {
        $("#enviar_todo_stock").on('click', function (e) {
            Swal.fire({
                title: '¿Guardar toda la nota?',
                html: "¿Continuar y agregar todos los datos de la nota al stock?" +
                    `<br><b>¡OJO!: </b>Aún tienes que guardar manual mente a almacen la ubicación de los productos`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar y guardar',
                cancelButtonText: 'No'
            }).then((result) => {
                console.log(result);
                if (result.value) {
                    let form = `opcion=registrar_stock&id_nota=${id_nota}`;
                    enviar_materia_prima(form)
                        .then((data) => {
                            if (data.status) {
                                toastr['success'](data.text);
                                traer_nota(id_nota);
                            } else {
                                toastr['warning'](data.text);
                            }
                        });
                }
            });
        });
    });
});



async function traer_nota(id_nota) {
    let form = new FormData();
    form.append("opcion", 'mostrar_nota');
    form.append("id_nota", id_nota);

    const response = await
        enviar_datos(form).then((response) => {
            console.log(response);
            if (response.response == 'success') {
                let cuerpo_invoice = $("#cuerpo_invoice");
                let INV = new Invoice();
                cuerpo_invoice.html(INV.body(response.data));
                nota_funciones(id_nota);
                return (response = true);
            } else {
                toastr['error'](response.text);
                return (response = true);
            }
        }).catch((err) => {
            toastr['error']("Error de respuesta del servidor");
            return (response = false);
        });

    return response;
}
async function enviar_datos(formulario) {
    const response = await
        fetch(RUTA + 'back/proveedores/nota', {
            method: 'POST',
            body: formulario,
        }).then(function (response) {
            return response.json();
        }).then(function (data) {
            return data;
        }).catch(function (err) {
            console.error('ERROR', err);
            return { "error": "Error interno del servidor" };
        });
    return response;
}

function nota_funciones(id_nota) {
    $("#mostrar_pagos").on('click', function () {
        $(".pagos_nota").toggle("show");
    });
    $(".mostrar_opciones").on('click', function () {
        $(this).parent().find(".body_opciones").toggle("show");
    });

    load_barcode();

    $(".guardar_stock").on('click', function (e) {
        let button = $(this);
        let content = button.parent();
        let tipo = content.attr("data-tipo");
        let id_materia = content.attr("data-id_producto");

        Swal.fire({
            title: '¿Guardar solo este producto?',
            html: "¿Continuar y agregar los datos de la nota al stock?" +
                `<br><b>¡OJO!: </b>Aún tienes que guardar manualmente en almacen la ubicación del producto`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Continuar y guardar',
            cancelButtonText: 'No'
        }).then((result) => {
            console.log(result);
            if (result.value) {
                let form = `opcion=registrar_stock&id_nota=${id_nota}&id_materia=${id_materia}&tipo=${tipo}&solo_uno=1`;
                enviar_materia_prima(form)
                    .then((data) => {
                        if (data.status) {
                            toastr['success'](data.text);
                            traer_nota(id_nota);
                        } else {
                            toastr['warning'](data.text);
                        }
                    });
            }
        });
    });
    $(".guardar_almacen").on('click', function (e) {
        let button = $(this);
        let content = button.parent();
        let tipo = content.attr("data-tipo");
        let id_materia = content.attr("data-id_producto");

        console.log(tipo, id_materia);
    });

    $(".eliminar_pago").click(function (e) {
        e.preventDefault();
        let button = $(this);
        let content = button.parent().parent().parent(); //Contenedor del pago
        let id_pago = button.parent().data('pago');

        Swal.fire({
            icon: 'warning',
            title: 'Eliminar pago',
            html: `Al eliminar un pago se va a generar una notificación en el sistema y se actualizará el estado de la nota.<br>
                    Por favor escribe \"<b>eliminar</b>\" para borrar el pago de la nota`,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Look up',
            showLoaderOnConfirm: true,
        }).then((result) => {

            if (result.value === 'eliminar') {
                /**Enviar petición */

                let formulario = new FormData();
                formulario.append('opcion', 'eliminar_pago');
                formulario.append('id_nota', id_nota);
                formulario.append('id_pago', id_pago);

                content.toggle("slide");
                enviar_datos(formulario).then((response) => {
                    if (response.response == 'success') {
                        toastr['success'](response.text)
                        setTimeout(() => {
                            traer_nota(id_nota).then((res) => {
                                $(".pagos_nota").show();
                            });
                        }, 500);

                    } else {
                        content.toggle("slide");
                        toastr['error'](response.text)
                    }

                }).catch(function (err) {
                    console.error('ERROR', err);
                });
                /**Enviar petición */
            } else if (result.value && result.value != '') {
                toastr['error']("<b> \"eliminar\"</b> no se escribio correctamente");
            }
        })

    });
}
async function load_barcode() {
    let imagen = ".barcode";
    let code = await JsBarcode(imagen).init();
    //tiene que terminar antes de poder hacer el recorrido de lo contrario la funcion no sirve de nada
    //La funcion no devuelve la imagen así que tiene que terminar su proceso

    $(imagen).each(function (index, element) {
        // Se recorren todas las imagenes y se agrega el botón de descarga
        let img = $(element).attr('src');
        let title = $(element).attr('title');
        $(element).parent().append(`<a class="btn btn-primary py-1 px-2" href="${img}" download="${title}"> <i class="fas fa-save"></i> Descargar</a>`);
    });
}

async function enviar_materia_prima(form) {
    const response =
        $.ajax({
            url: (RUTA + "back/stock/materiaprima"),
            type: "POST",
            dataType: "json",
            data: form,
            success: function (data) {
                return data;
            },
            error: function (xhr, status) {
                console.log(xhr.responseText);
                toastr['error']("Error del servidor, consulta al programador");
                return false
            }
        });
    return response;
}

