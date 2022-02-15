$(document).ready(function () {
    $("#contacto_index").on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let button = form.find('button');
        let text = button.text();
        let formulario = form.serialize();
        let nombre_contacto = form.find("[name=nombre_contacto]");
        let correo_contacto = form.find("[name=correo_contacto]");
        let telefono_contacto = form.find("[name=telefono_contacto]");
        let error_cont = 0;
        $(".has-error").removeClass("has-error");
        $(".ntf_form").remove();
        if (nombre_contacto.val() == "" || nombre_contacto.val().length < 10) {
            error_cont++;
            nombre_contacto.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre de contacto no puede estar vacio o ser menor a 10 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        }
        if (correo_contacto.val() == '' || correo_contacto.val().length < 3) {
            error_cont++;
            correo_contacto.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El correo de contacto no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        };
        if (telefono_contacto.val() == '' || telefono_contacto.val().length < 9) {
            error_cont++;
            telefono_contacto.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El número de teléfono de contacto no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        };
        if (error_cont === 0) {
            button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
            //console.log(formulario)
            //console.log(RUTA + "back/index/contacto",);
            $.ajax({
                type: "POST",
                url: RUTA + "back/index/contacto",
                data: `opcion=index_mail&${formulario}`,
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText)
                    button.removeClass('disabled').removeAttr('disabled').html(text);
                    nombre_contacto.val("");
                    telefono_contacto.val("");
                    correo_contacto.val("");
                    /**Agrega una alerta de error para el usuario */
                },
                success: function (data) {
                    button.removeClass('disabled').removeAttr('disabled').html(text);
                    if (data.response == "success") {
                        Swal.fire({
                            title: 'Email enviado con éxito',
                            icon: 'success',
                            html: `<p>${data.text}<br></p>`,
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                        });
                        /**Limpieza de los campos */
                        nombre_contacto.val("");
                        telefono_contacto.val("");
                        correo_contacto.val("");
                    } else {
                        $.notify({
                            icon: 'fas fa-exclamation-circle',
                            title: 'Error al enviar correo',
                            message: data.text,
                        }, {
                            type: "danger",
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            time: 1500,
                        });
                    }
                }
            });
        } else {

        }
    });
});