$(document).ready(function() {
    const id_cliente = $("#id_cliente").val();
    $(".show_direccion").on('click', function(e) {
        e.preventDefault();
        let contenedor = $(".direccion_cont");
        contenedor.find(".title").toggle('show');
        contenedor.find(".content").toggle('show');
    });
    $("#mostrar_cambios_cliente").on('click', function(e) {
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
            $("#cont_form_cliente").toggle('show');
            dir = (!dir ? true : false);
        });
        $("#modificar_cliente").off().submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario            = form.serialize();
            let cliente_razon_social  = form.find("#razon_social");
            let cliente_rfc           = form.find("#rfc");
            let cliente_telefono      = form.find("#telefono");
            let cliente_correo        = form.find("#correo");


            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            if (cliente_razon_social.val() == '' || cliente_razon_social.val().length < 5) {
                error_cont++;
                cliente_razon_social.parent().addClass("has-error").parent().append(`<small class="text-danger ntf_form" class="form-text text-muted">El cliente no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (cliente_rfc.val() == '' || cliente_rfc.val().length < 5) {
                error_cont++;
                cliente_rfc.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El RFC no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes de utilizar letras de la A-Z y números del 0-9.</small>`);
            };
            if (cliente_telefono.val() == '' || cliente_telefono.val().length < 5) {
                error_cont++;
                cliente_telefono.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El teléfono no puede estar vacio o ser menores a 5 caracteres recuerda que solo debes de utilizar números de 0-9..</small>`);
            };
            if (cliente_correo.val() == '' || cliente_correo.val().length < 5) {
                error_cont++;
                cliente_correo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El correo no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes números de  0-9, letras de a-z "@ . " ej.: "clientemail@ropondagar.com." </small>`);
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
                    url: RUTA + "back/cliente",
                    data: `opcion=modificar_cliente&id_cliente=${id_cliente}&${formulario}&direccion=${JSON.stringify(direccion)}`,
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

                            let tipo_cliente = "";
                            let tipo_persona = "";
                            $(".tipo_cliente").each(function(index, element) {
                                let check = $(element);
                                if (check.is(":checked")) tipo_user = check.val();
                            });
                            $(".tipo_persona").each(function(index, element) {
                                let check = $(element);
                                if (check.is(":checked")) tipo_user = check.val();
                            });
                            let perfil = $("#perfil_principal");
                            let dir_content = $("#contenedor_direccion")
                            perfil.find(".name").html(cliente_razon_social.val());
                            perfil.find(".job").html(tipo_cliente);
                            perfil.find(".contact").html(tipo_persona);
                            perfil.find(".tel").html(`<a href="tel:${user_tel.val()}">${user_tel.val()}</a>`);
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
            url: RUTA + "back/cliente",
            data: `opcion=modificar_cliente&id_cliente=${id_cliente}&estado=${(estado == 'activo' ? "inactivo" : "activo")}`,
            dataType: "JSON",
            error: function(xhr,status) {
                console.log(xhr.responseText);
                button.removeAttr("disabled").removeClass("disabled").html(text);
            },
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
    });
});