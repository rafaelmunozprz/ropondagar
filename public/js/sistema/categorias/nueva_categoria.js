$(document).ready(function () {
    $("#nueva_categoria").on('click', function () {
        let MODAL = $("#modal_new_categoria");
        MODAL.modal("show");

        $("#form_nueva_categoria").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nombre_categoria = form.find("[name=nombre_categoria]");
            let estado_categoria = form.find("[name=estado_categoria]");
            let tipo_categoria = form.find("[name=tipo]");

            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

            if (nombre_categoria.val() == '' || nombre_categoria.val().length < 2 || !((EXPRESION.num_sup_text).test(nombre_categoria.val()))) {
                error_cont++;
                nombre_categoria.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (estado_categoria.val() == '' || estado_categoria.val().length < 3 || !((EXPRESION.sup_text).test(estado_categoria.val()))) {
                error_cont++;
                estado_categoria.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El estado no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (error_cont === 0) {
                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/categorias",
                    data: `opcion=crear_categoria&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        //button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (data) {
                        button.removeClass('disabled').removeAttr('disabled').html(text);

                        if (data.response == "success") {
                            MODAL.modal("hide");

                            Swal.fire({
                                title: 'Registro con exito',
                                icon: 'success',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            /**Limpieza de los campos */
                            traer_categorias()
                            nombre_categoria.val("");
                            estado_categoria.val("activo");
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
            } else {}
        });
    });
});