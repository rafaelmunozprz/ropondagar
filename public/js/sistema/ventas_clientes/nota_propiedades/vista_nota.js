$(document).ready(function () {
    let id_nota = $("#id_nota").val();

    traer_nota(id_nota);
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
            console.log(err)
            toastr['error']("Error de respuesta del servidor");
            return (false);
        });

    return response;
}
async function enviar_datos(formulario) {
    const response = await
        fetch(RUTA + 'back/cliente/nota_venta', {
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
                    console.log(response);
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

