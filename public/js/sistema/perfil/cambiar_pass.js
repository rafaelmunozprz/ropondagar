$(document).ready(function() {
    $(".show_direccion").on('click', function(e) {
        e.preventDefault();
        let contenedor = $(".direccion_cont");
        contenedor.find(".title").toggle('show');
        contenedor.find(".content").toggle('show');
    });
    $("#show_change_pass").click(function(e) {
        e.preventDefault();
        let contenedor = $(".password_cont");
        contenedor.find(".form_pass").toggle('show');
        contenedor.find(".button_pass").toggle('show');
    });

    $("#cambiar_password").submit(function(e) {
        e.preventDefault();
        let content = $(this);
        let form = content.serialize();
        let password = content.find("#password"),
            new_password = content.find("#new_password"),
            r_new_password = content.find("#r_new_password");

        let error_cont = 0;
        $(".has-error").removeClass("has-error");
        $(".ntf_form").remove();
        const min_length = 8;
        if (password.val().length < min_length) {
            error_cont++;
            password.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La contraseña no puede estar vacio o ser menor a 8 caracteres recuerda que solo debes de utilizar letras de la A-Z y nùmeros de 0-9</small>`);
        } else if (new_password.val().length < min_length || r_new_password.val().length < min_length) {
            error_cont++;
            new_password.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La contraseña no puede estar vacio o ser menor a 8 caracteres recuerda que solo debes de utilizar letras de la A-Z y nùmeros de 0-9</small>`);
            r_new_password.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La contraseña no puede estar vacio o ser menor a 8 caracteres recuerda que solo debes de utilizar letras de la A-Z y nùmeros de 0-9</small>`);
        } else if (new_password.val() != r_new_password.val()) {
            error_cont++;
            new_password.parent().addClass("has-error").append(`<small class="text-warning ntf_form" class="form-text text-muted">Las contraseñas no coinciden</small>`);
            r_new_password.parent().addClass("has-error").append(`<small class="text-warning ntf_form" class="form-text text-muted">Las contraseñas no coinciden</small>`);
        } else if (password.val() == new_password.val()) {
            error_cont++;
            password.parent().addClass("has-error").append(`<small class="text-warning ntf_form" class="form-text text-muted">Las contraseñas no deben de ser iguales</small>`);
            new_password.parent().addClass("has-error").append(`<small class="text-warning ntf_form" class="form-text text-muted">Las contraseñas no deben de ser iguales</small>`);
        }


        if (error_cont === 0) {
            $.ajax({
                type: "POST",
                url: RUTA + "back/usuarios",
                data: `opcion=cambiar_password&${form}`,
                dataType: "JSON",
                error: function(xhr, status) {
                    console.log(xhr.responseText);
                },
                success: function(data) {
                    if (data.response == "success") {
                        $.notify({
                            icon: 'fas fa-exclamation-circle',
                            title: 'Contraseña actualizada',
                            message: data.text,
                        }, {
                            type: "success",
                            placement: { from: "top", align: "right" },
                            time: 2000,
                        });
                        $(".has-error").removeClass("has-error");
                        $(".ntf_form").remove();
                        password.val("");
                        new_password.val("");
                        r_new_password.val("");

                        $(".password_cont").find(".form_pass").toggle('show');
                        $(".password_cont").find(".button_pass").toggle('show');

                    } else {
                        password.parent().addClass("has-error").append(`<small class="text-warning ntf_form" class="form-text text-muted">${data.text}</small>`);
                        $.notify({
                            icon: 'fas fa-exclamation-circle',
                            title: 'Error al actualizar',
                            message: data.text,
                        }, {
                            type: "warning",
                            placement: { from: "top", align: "right" },
                            time: 1500,
                        });
                    }

                }
            });
        } else {
            $.notify({
                icon: 'fas fa-exclamation-circle',
                title: 'Error al actualizar',
                message: "Completa correctamente los datos",
            }, {
                type: "danger",
                placement: { from: "top", align: "right" },
                time: 1500,
            });
        }
    });
});