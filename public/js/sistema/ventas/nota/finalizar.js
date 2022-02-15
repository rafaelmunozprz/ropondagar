$(document).ready(function () {
    $("#total_nota").on('click', function (e) {
        e.preventDefault();
        const STORE = new Storage('venta_notas');
        let nota = (STORE.mostrar_nota());
        if (nota && nota.productos.length > 0) {
            Swal.fire({
                title: 'Finalizar nota',
                html:
                    '¿Realmente estas seguro de que sedeas continuar?, ¡La nota se guardará y no podrás modificar los productos agregados!<br>' +
                    `<b>Solamente podrás registrar una nueva nota una vez generada la actual</b>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'GENERAR NOTA'
            }).then((result) => {
                if (result.value == true) {
                    let form = new FormData();
                    form.append('opcion', "crear_nota");
                    form.append('nota', JSON.stringify(nota));
                    $.ajax({
                        type: "POST",
                        url: RUTA + "back/cliente/nota_venta",
                        data: form,
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data.response == 'success') {
                                $("#form_search_materiaprima").submit();
                                $("#form_search_almacen").submit();
                                continuar_nota(nota, data.data.id_nota);
                            } else {
                                $.notify({
                                    icon: 'fas fa-exclamation-circle',
                                    title: data.text,
                                    message: `Completa la nota antes de continuar.`,
                                }, {
                                    type: 'warning', placement: { from: "top", align: "right" }, time: 1500,
                                });
                            }
                        },
                        error: function (xhr, status) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        } else {
            $.notify({
                icon: 'fas fa-exclamation-circle',
                title: 'Es necesario tener almenos un producto en tu nota',
                message: `Completa la nota antes de continuar.`,
            }, {
                type: 'warning',
                placement: {
                    from: "top",
                    align: "right"
                },
                time: 1500,
            });
        }


    });

    function continuar_nota(nota, id_nota, pagada = false) {
        let STORE = new Storage('venta_notas');
        const FUNC = new Funciones();

        if (nota && nota.productos.length > 0) {
            var modal = $("#modal_notificacion");
            modal.modal({ backdrop: 'static', keyboard: false }); //inhabilita que el modal se cierre

            modal.find(".titulo_modal").hide();
            modal.find(".titulo_modal").hide();
            modal.find(".modal-footer").hide();
            modal.modal('show');
            modal.find(".cuerpo_modal").html(`<div class="row"><div class="col-12"><div class="loader_spin"></div></div><div class="col text-center text-spinner">Generando <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div> </div></div>`).addClass("loader_maximus");
            setTimeout(() => {
                modal.find(".titulo_modal").show();
                modal.find(".titulo_modal").children('h5').html("Nota finalizada");
                modal.find(".modal-footer").show();
                modal.find(".cuerpo_modal").html(``).removeClass("loader_maximus");
                modal.modal('show');
                modal.find(".cuerpo_modal").html(`
                                    <div class="row">
                                        <div class="col-12 text-center"><h2>Nota creada de manera correcta</h2></div>
                                        <div class="col">
                                            <div class="success-checkmark">
                                                <div class="check-icon">
                                                    <span class="icon-line line-tip"></span>
                                                    <span class="icon-line line-long"></span>
                                                    <div class="icon-circle"></div>
                                                    <div class="icon-fix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center"><p>Puedes continuar con la impresión</p></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-6 my-2">
                                            <a target="_blank" href="${RUTA}sistema/ventas/pdf/facturapdf/${id_nota}" class="btn btn-primary btn-border btn-round  btn-block"> <span class="btn-label"> <i class="fas fa-file-pdf"></i></span>Print PDF</a>
                                        </div>
                                        <div class="col-md-6 col-6 my-2">
                                            <a target="_blank" href="${RUTA}sistema/ventas/pdf/ticketzpl/${id_nota}" class="btn btn-primary btn-border btn-round  btn-block" data-tipo="facturazpl"> <i class="fas fa-file-pdf ml-3"></i> Print Zebra</a>
                                        </div>
                                        <div class="col-md-12 my-3">
                                            <a class="btn btn-success btn-border btn-round  btn-block" id="pagar_total"> <i class="fas fa-money-bill-wave-alt mr-3"></i> PAGAR EL TOTAL</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col my-3"><a id="send_mail" class="btn btn-dark btn-border btn-round  btn-block text-dark" > <i class="fas fa-paper-plane mx-3"></i>Enviar correo con el ticket</a></div>
                                    </div>`);
                $("#pagar_total").on('click', function () {
                    let totales = STORE.total_nota(); //Devuelve un array solo con los todales de la nota
                    let modal_pagos = $("#modal_pagos");
                    modal_pagos.modal({ backdrop: 'static', keyboard: false });
                    modal.modal('hide');
                    modal_pagos.modal('show');
                    $("#modal_pago_volver").off().on('click', function () {
                        modal_pagos.modal("hide");
                        modal.modal("show");
                    });

                    // console.log(totales);

                    modal_pagos.find(".total_a_pagar").html(FUNC.number_format(totales.total, 2)); //Agrega la cantidad de pago total

                    let $pago = 'efectivo'; //Tipo de pago por defecto

                    $(".continuar_pago").on('click', function () {
                        let button_pago = $(this);
                        $pago = button_pago.attr('data-tipo_pago');
                        $(".continuar_pago").removeClass("bg-dark").removeClass('text-white');
                        button_pago.addClass("bg-dark").addClass('text-white');
                    });

                    $("#realizar_pago_nota").off().on('click', function () {
                        let button = $(this);
                        let text = 'Realizar pago';
                        modal_pagos.modal('hide');
                        let total_pago = $("#cantidad_pago_total");
                        if (parseFloat(total_pago) <= 0) {
                            $.notify({
                                icon: 'fas fa-exclamation-circle',
                                title: "No puedes realizar un pago con montos en $0.00 MXN",
                                message: ``,
                            }, {
                                type: 'error', placement: { from: "top", align: "right" }, time: 1500,
                            });
                            total_pago.val(0);
                            setTimeout(() => {
                                modal.modal('show');
                            }, 2200);
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
                                        url: RUTA + "back/cliente/nota_venta",
                                        data: `opcion=agregar_pago_nota&id_nota=${id_nota}&tipo_pago=${$pago}&pago=${total_pago.val()}&finalizar=true`,
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
                                                setTimeout(() => {
                                                    modal.modal('show');
                                                }, 2200);
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
                });
                $("#send_mail").on('click', function () {
                    let button = $(this);
                    let text = '<i class="fas fa-paper-plane mx-3"></i>Enviar correo con el ticket';
                    button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                    $.ajax({
                        type: "POST",
                        url: RUTA + "back/cliente/nota_venta/correo",
                        data: `opcion=enviar_email&id_nota=${id_nota}`,
                        dataType: "JSON",
                        error: function (xhr, status) {
                            console.log(xhr.responseText);
                            toastr['error']('Error de respuesta del servidor');
                            button.removeClass('disabled').removeAttr('disabled').html(text);
                        },
                        success: function (data) {
                            button.removeClass('disabled').removeAttr('disabled').html(text);
                            modal.modal('hide');
                            $.notify({
                                icon: 'fas fa-check-circle',
                                title: data.text,
                                message: ``,
                            }, {
                                type: 'success', placement: { from: "top", align: "right" }, time: 1500,
                            });
                            setTimeout(() => {
                                modal.modal('show');
                            }, 1500);
                        }
                    });
                });
                $("#enviar_zebra").on('click', function () {
                    let button = $(this);
                    // const ZEBRA = new SendZebra();
                });
                $("#modal_notificacion_exit").off().on('click', function () {
                    modal.modal('hide');
                    Swal.fire({
                        title: '¿Estas seguro?',
                        html: "Para volver a ver datos de esta nota deveras ir a la sección de notas de proveedor" +
                            `<br><b>La nota ha sido creada, por favor limpia la nota actual para evitar duplicidad</b>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, salir'
                    }).then((result) => {
                        if (result.value != true) {
                            modal.modal("show");
                            const note = new Storage('venta_notas');
                            note.borrar();
                            traer_nota();
                        }

                    });
                });
            }, 2000);

        }
    }
});