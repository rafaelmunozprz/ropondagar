'use strict'
$(document).ready(function () {
    $("#nuevo_burro").on('click', function () {

        $("#form_nuevo_burro").submit(function (e) {
            e.preventDefault();
            let MODAL_NUEVO_BURRO = $("#modal_nuevo_burro")
            MODAL_NUEVO_BURRO.modal('show')
            let form_NUEVO_BURRO = $(this)
            let button_GUARDAR_BURRO = form_NUEVO_BURRO.find("[name=buttonGuardarNuevoBurro]")
            let text = button_GUARDAR_BURRO.text()
            let formulario_NUEVO_BURRO = form_NUEVO_BURRO.serialize()
            let niveles_NUEVO_BURRO = form_NUEVO_BURRO.find("[name=niveles_NUEVO_BURRO]")
            let secciones_NUEVO_BURRO = form_NUEVO_BURRO.find("[name=secciones_NUEVO_BURRO]")
            let error_cont = 0
            $(".has-error").removeClass("has-error")
            $(".ntf_form").remove()
            const FUNC = new Funciones()
            const EXPRESION = FUNC.EXPRESION()
            if (niveles_NUEVO_BURRO.val() == '' || !((EXPRESION.number).test(niveles_NUEVO_BURRO.val()))) {
                error_cont++;
                niveles_NUEVO_BURRO.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };
            if (secciones_NUEVO_BURRO.val() == '' || !((EXPRESION.number).test(secciones_NUEVO_BURRO.val()))) {
                error_cont++;
                secciones_NUEVO_BURRO.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };
            if (error_cont === 0) {
                button_GUARDAR_BURRO.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/burros",
                    data: `opcion=crear_burro&${formulario_NUEVO_BURRO}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button_GUARDAR_BURRO.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (data) {
                        button_GUARDAR_BURRO.removeClass('disabled').removeAttr('disabled').html(text);
                        if (data.response == "success") {
                            Swal.fire({
                                title: 'Burro creado',
                                icon: 'warning',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                        } else {
                            MODAL_NUEVO_BURRO.modal("hide");
                            Swal.fire({
                                title: 'Burro no creado',
                                icon: 'warning',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            setTimeout(() => {
                                MODAL_NUEVO_BURRO.modal("show");
                            }, 2000);
                        }
                    }
                });
            }


            /* let form_NUEVO_BURRO = $(this)
            let button_GUARDAR_BURRO = form_NUEVO_BURRO.find("[name=buttonGuardarNuevoBurro]")
            let text = button_GUARDAR_BURRO.text()
            let formulario_NUEVO_BURRO = form_NUEVO_BURRO.serialize()
            let niveles_NUEVO_BURRO = form_NUEVO_BURRO.find("[name=niveles_NUEVO_BURRO]")
            let secciones_NUEVO_BURRO = form_NUEVO_BURRO.find("[name=secciones_NUEVO_BURRO]")
            let error_cont = 0
            $(".has-error").removeClass("has-error")
            $(".ntf_form").remove()
            const FUNC = new Funciones()
            const EXPRESION = FUNC.EXPRESION()
            if (niveles_NUEVO_BURRO.val() == '' || !((EXPRESION.number).test(niveles_NUEVO_BURRO.val()))) {
                error_cont++;
                niveles_NUEVO_BURRO.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };
            if (secciones_NUEVO_BURRO.val() == '' || !((EXPRESION.number).test(secciones_NUEVO_BURRO.val()))) {
                error_cont++;
                secciones_NUEVO_BURRO.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };
            if (error_cont === 0) {
                button_GUARDAR_BURRO.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/burros",
                    data: `opcion=crear_burro&${formulario_NUEVO_BURRO}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button_GUARDAR_BURRO.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (data) {
                        button_GUARDAR_BURRO.removeClass('disabled').removeAttr('disabled').html(text);
                        if (data.response == "success") {
                            Swal.fire({
                                title: 'Burro creado',
                                icon: 'warning',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                        } else {
                            MODAL_NUEVO_BURRO.modal("hide");
                            Swal.fire({
                                title: 'Burro no creado',
                                icon: 'warning',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            setTimeout(() => {
                                MODAL_NUEVO_BURRO.modal("show");
                            }, 2000);
                        }
                    }
                });
            } */
        });
    })
});