'use strict'
$(document).ready(function () {
    $("#nuevo_anaquel").on('click', function () {
        let MODAL = $("#modal_nuevo_anaquel");
        MODAL.modal("show");
        $("#form_nuevo_anaquel").off().submit(function (e) {

            e.preventDefault()
            let form = $(this)
            let button = form.find("[name=buttonGuardar]")
            let text = button.text()
            let formulario = form.serialize()
            let filas_anaquel = form.find("[name=filas_anaquel]")
            let columnas_anaquel = form.find("[name=columnas_anaquel]")
            let error_cont = 0
            $(".has-error").removeClass("has-error")
            $(".ntf_form").remove()
            const FUNC = new Funciones()
            const EXPRESION = FUNC.EXPRESION()
            if (filas_anaquel.val() == '' || !((EXPRESION.number).test(filas_anaquel.val()))) {
                error_cont++;
                filas_anaquel.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };
            if (columnas_anaquel.val() == '' || !((EXPRESION.number).test(columnas_anaquel.val()))) {
                error_cont++;
                columnas_anaquel.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };
            if (error_cont === 0) {
                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/anaqueles",
                    data: `opcion=crear_anaquel&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (data) {
                        button.removeClass('disabled').removeAttr('disabled').html(text);

                        if (data.response == "success") {
                            MODAL.modal("hide");
                            Swal.fire({
                                title: 'Anaquel creado',
                                icon: 'warning',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            /**Limpieza de los campos */
                            filas_anaquel.val("1");
                            columnas_anaquel.val("1");
                            let contenedor_filas = document.getElementById("container-filas-columnas");
                            contenedor_filas.innerHTML = "";
                            traer_anaqueles();
                        } else {
                            MODAL.modal("hide");
                            $.notify({
                                icon: 'fas fa-exclamation-circle',
                                title: 'Error al registrar',
                                message: data.text,
                            }, {
                                type: "danger",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                time: 1500,
                            });
                            setTimeout(() => {
                                MODAL.modal("show");
                            }, 2000);
                        }
                    }
                });
            }
        })
    })


})