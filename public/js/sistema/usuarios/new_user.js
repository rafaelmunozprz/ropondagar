$(document).ready(function() {
    // setTimeout(() => { $("#nuevo_registro").click(); }, 10);


    $("#nuevo_registro").on('click', function() {
        let MODAL = $("#modal_new_user");
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

        $("#registrar_usuario").off().submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');

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
            // if (user_email.val() == '' || user_email.val().length < 5) {
            //     error_cont++;
            //     user_email.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">Recuerda utilizar un formato de correo electronico correcto. Ej:tucorreo@correo.com.</small>`);
            // };
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
                    data: `opcion=registrar_usuario&${formulario}&direccion=${JSON.stringify(direccion)}`,
                    dataType: "JSON",
                    error: function(xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html('Completar registro de usuario');
                    },
                    success: function(data) {
                        button.removeClass('disabled').removeAttr('disabled').html('Completar registro de usuario');

                        if (data.response == "success") {
                            MODAL.modal("hide");

                            Swal.fire({
                                title: 'Registro con exito',
                                icon: 'success',
                                html: `<p>${data.text}<br><b>Contraseña temporal:${data.data.password}</b><br>
                                        Recuerda que el administrador debe de activar el usuario antes de poder ser utilizado</p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            /**Limpieza de los campos */
                            user_nickname.val("");
                            user_name.val("");
                            user_lastname.val("");
                            user_tel.val(""); //user_email.val("");
                            cont_dir.find("#direccion").val("");
                            cont_dir.find("#numero_externo").val("");
                            cont_dir.find("#numero_interno").val("");
                            cont_dir.find("#colonia").val("");
                            cont_dir.find("#codigo_postal").val("");
                            cont_dir.find("#ciudad").val("");
                            cont_dir.find("#estado").val("");
                            traer_usuarios();
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
});