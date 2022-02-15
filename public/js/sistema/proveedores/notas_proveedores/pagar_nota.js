$(document).ready(function () {
    let $pago = "efectivo";
    let modal_pagos = $("#modal_pagos");


    $(".continuar_pago").on('click', function () {
        let button_pago = $(this);
        $pago = button_pago.attr('data-tipo_pago');
        $(".continuar_pago").removeClass("bg-dark").removeClass('text-white');
        button_pago.addClass("bg-dark").addClass('text-white');
    });

    $("#realizar_pago_nota").off().on('click', function () {
        let button = $(this);
        let text = 'Realizar pago';
        let total_pago = $("#cantidad_pago_total");
        let id_nota = button.attr('id_nota');

        modal_pagos.modal('hide');
        if (parseFloat(total_pago) <= 0) {
            $.notify({
                icon: 'fas fa-exclamation-circle',
                title: "No puedes realizar un pago con montos en $0.00 MXN",
                message: ``,
            }, {
                type: 'error', placement: { from: "top", align: "right" }, time: 1500,
            });
            total_pago.val(0);

        } else {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "Solamente un administrador podrá eliminar el pago",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si pagar total'
            }).then((result) => {
                if (result.value == true) {
                    button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                    $.ajax({
                        type: "POST",
                        url: RUTA + "back/proveedores/nota",
                        data: `opcion=agregar_pago_nota&id_nota=${id_nota}&tipo_pago=${$pago}&pago=${total_pago.val()}`,
                        dataType: "JSON",
                        error: function (xhr, status) {
                            console.log(xhr.responseText);
                            toastr['error']('Error de respuesta del servidor');
                            button.removeClass('disabled').removeAttr('disabled').html(text);
                            setTimeout(() => {
                                modal_pagos.modal('show');
                            }, 2200);
                        },
                        success: function (data) {
                            button.removeClass('disabled').removeAttr('disabled').html(text);
                            if (data.response == 'success') {
                                $.notify({
                                    icon: 'fas fa-check-circle',
                                    title: data.text,
                                    message: ``,
                                }, {
                                    type: 'success', placement: { from: "top", align: "right" }, time: 1500,
                                });
                                total_pago.val(0);
                                pregunta_traer_mas_notas();
                            } else {
                                $.notify({
                                    icon: 'fas fa-exclamation-circle', title: data.text, message: ``,
                                }, {
                                    type: 'warning', placement: { from: "top", align: "right" }, time: 1500,
                                });
                                setTimeout(() => {
                                    modal_pagos.modal('show');
                                }, 2200);
                            }


                        }
                    });
                } else {
                    modal_pagos.modal('show');
                }
            });
        }
    });


    function pregunta_traer_mas_notas() {
        Swal.fire({
            title: 'Te gustaría actualizar las notas',
            html: "Si continuar podrás observar los cambios de las notas" +
                `<br><b>Las notas se mostrarán desde la página 1</b>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No, continuar así'
        }).then((result) => {
            if (result.value == true) {
                /**
                 * Es necesario hacer este paso, este campo o los que 
                 * valides solo existiran en las vistas donde los necesites aplicar
                 *  */

                let id_proveedor = $("#id_proveedor").val();
                let filtro_avanzado = ""; // Este agregara más opcines de filtrado

                filtro_avanzado = (id_proveedor != '' ? `&id_proveedor=${id_proveedor}` : ""); //Si se te ocurre algo concatenalo aquí
                mostrar_notas(1, filtro_avanzado, false, false, false);
                estadisticas(filtro_avanzado);
            } else {
                modal_pagos.modal('show');
            }
        });
    }
});