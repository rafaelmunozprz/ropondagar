$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    $(".show_direccion").on('click', function(e) {
        e.preventDefault();
        let contenedor = $(".direccion_cont");
        contenedor.find(".title").toggle('show');
        contenedor.find(".content").toggle('show');
    });
    $(".show_password").on('click', function(e) {
        e.preventDefault();
        let contenedor = $(".password_cont");
        contenedor.find(".title").toggle('show');
        contenedor.find(".content").toggle('show');
    });

    // $("#modal_edit_user").modal('show');

    $("#mostrar_cambios_usuario").on('click', function(e) {
        e.preventDefault();
        let MODAL = $("#modal_edit_user");
        MODAL.modal("show");

        let dir = false;
        $(".add_direccion").off().click(function(e) {
            e.preventDefault();
            let button = $(this);
            let contenedor = $("#registro_direccion");
            contenedor.find(".direccion_cont").toggle('show');
            contenedor.find(".contenedor_titulos").children('h2').toggle('show');
            contenedor.find(".contenedor_titulos").children('.add_direccion').toggle('show');
            $("#cont_form_user").toggle('show');
            dir = (!dir ? true : false);
        });
        $("#modificar_usuario").off().submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let user_nickname = form.find("#user_nickname");
            let user_name = form.find("#user_name");
            let user_lastname = form.find("#user_lastname");
            let user_tel = form.find("#user_tel");


            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            if (user_nickname.val() == '' || user_nickname.val().length < 5) {
                error_cont++;
                user_nickname.parent().addClass("has-error").parent().append(`<small class="text-danger ntf_form" class="form-text text-muted">El usuario no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes de utilizar letras de la A-Z y nùmeros de 0-9</small>`);
            };
            if (user_name.val() == '' || user_name.val().length < 5) {
                error_cont++;
                user_name.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (user_lastname.val() == '' || user_lastname.val().length < 5) {
                error_cont++;
                user_lastname.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">Los apellidos no pueden estar vacios o ser menores a 5 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ..</small>`);
            };
            if (user_tel.val() == '' || user_tel.val().length < 5) {
                error_cont++;
                user_tel.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El número de telefono no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes números de  0-9 y "- +" </small>`);
            };
            let cont_dir = $("#registro_direccion");
            let direccion = [{
                "direccion": cont_dir.find("#direccion").val(),
                "numero_externo": cont_dir.find("#numero_externo").val(),
                "numero_interno": cont_dir.find("#numero_interno").val(),
                "colonia": cont_dir.find("#colonia").val(),
                "cp": cont_dir.find("#codigo_postal").val(),
                "ciudad": cont_dir.find("#ciudad").val(),
                "estado": cont_dir.find("#estado").val(),
            }];
            if (error_cont === 0) {

                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/usuarios",
                    data: `opcion=actualizar_usuario&id_usuario=${id_usuario}&${formulario}&direccion=${JSON.stringify(direccion)}`,
                    dataType: "JSON",
                    error: function(xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function(data) {
                        button.removeClass('disabled').removeAttr('disabled').html(text);

                        if (data.response == "success") {
                            MODAL.modal("hide");

                            Swal.fire({
                                title: 'Registro con exito',
                                icon: 'success',
                                html: `<p>${data.text}</p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });

                            let tipo_user = "";
                            $(".tipo_user").each(function(index, element) {
                                let check = $(element);
                                if (check.is(":checked")) tipo_user = check.val();
                            });
                            let perfil = $("#perfil_principal");
                            let dir_content = $("#contenedor_direccion")
                            perfil.find(".name").html(user_name.val() + " " + user_lastname.val());
                            perfil.find(".job").html(tipo_user);
                            perfil.find(".contact").html(`<a href="tel:${user_tel.val()}">${user_tel.val()}</a>`);
                            dir_content.html(`
                                <p class="my-0 py-0"> ${direccion[0].estado}</p>
                                <p class="my-0 py-0"> ${direccion[0].ciudad} ${direccion[0].cp}</p>
                                <span>  ${direccion[0].colonia}, </span>
                                <span>  ${direccion[0].direccion} #</span>
                                <a class="ml-2">Int: ${direccion[0].numero_interno}</a>
                                <a class="ml-2">Ext: ${direccion[0].numero_externo}</a>
                            `);
                            /**Limpieza de los campos */
                        } else {
                            MODAL.modal("hide");
                            $.notify({ icon: 'fas fa-exclamation-circle', title: 'Error al registrar', message: data.text, }, { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
                        }
                    }
                });
            } else {
                if (dir) $("#registro_direccion").find(".contenedor_titulos").children('.add_direccion').click();
            }
        });

    });

    $("#update_user").on('click', function() {
        let button = $(this);
        let active = '<i class="fas fa-toggle-on text-success fa-2x"></i>',
            inactive = '<i class="fas fa-toggle-off text-warning fa-2x"></i>',
            text = button.html();
        let estado = button.attr('data-status');

        button.addClass('disabled').attr('disabled', 'disabled').html('<div class="spinner-border" role="status"><span class="visually-hidden"></span>');
        $.ajax({
            type: "POST",
            url: RUTA + "back/usuarios",
            data: `opcion=actualizar_usuario&id_usuario=${id_usuario}&estado=${(estado == 'activo' ? "inactivo" : "activo")}`,
            dataType: "JSON",
            success: function(data) {
                button.removeAttr("disabled").removeClass("disabled").html(text);
                if (data.response == 'success') {
                    button.html((data.data.estado == 'activo' ? active : inactive)).attr('data-status', data.data.estado);
                    button.parent().parent().children(".number").text(data.data.estado)
                    $.notify({ icon: 'fas fa-exclamation-circle', title: 'actualizado', message: data.text, }, { type: "success", placement: { from: "top", align: "right" }, time: 1500, });

                } else {
                    $.notify({ icon: 'fas fa-exclamation-circle', title: 'Error al registrar', message: data.text, }, { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
                }
            }
        });
    })
    $("#reset_password").on('click', function() {
        let button = $(this);
        let text = button.html();
        let estado = button.attr('data-status');

        button.addClass('disabled').attr('disabled', 'disabled').html('<div class="spinner-border" role="status"><span class="visually-hidden"></span>');
        $.ajax({
            type: "POST",
            url: RUTA + "back/usuarios",
            data: `opcion=reiniciar_password&id_usuario=${id_usuario}`,
            dataType: "JSON",
            success: function(data) {
                button.removeAttr("disabled").removeClass("disabled").html(text);
                if (data.response == 'success') {
                    Swal.fire({
                        title: 'Actualizaciòn',
                        icon: 'success',
                        html: `<p>${data.text}<br><b>Contraseña temporal:${data.data.password}</b><br>
                                Recuerda el usuario debe de estar activo antes de poder ser utilizado</p>`,
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                    });
                } else {
                    $.notify({ icon: 'fas fa-exclamation-circle', title: 'Error al registrar', message: data.text, }, { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
                }
            }
        });
    })
});