function ajustar_precio(id_modelo) {
    let MODAL_AJUSTAR = $("#modal_ajustar_precio")
    MODAL_AJUSTAR.modal('show')
    let PRECIOS = new Modelos()
    PRECIOS.cargar_precios_viejos(id_modelo)

    $("#form_ajustar_precio").off().submit(function (e) {
        e.preventDefault()
        console.log('aqui')
        let form = $(this)
        let button = form.find('button')
        let text = button.text()

        let formulario = form.serialize()
        let inversion = form.find("[name=inversion]")
        let precio_mayoreo = form.find("[name=precio_mayoreo]")
        let precio_menudeo = form.find("[name=precio_menudeo]")

        let error_cont = 0;
        $(".has-error").removeClass("has-error");
        $(".ntf_form").remove();
        const FUNC = new Funciones();
        const EXPRESION = FUNC.EXPRESION()

        if (inversion.val() == '' || inversion.val() < 0) {
            error_cont++;
            inversion.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La inversión no puede estar vacía o ser menor a 0</small>`);
        };
        if (precio_mayoreo.val() == '' || precio_mayoreo.val() < 0) {
            error_cont++;
            precio_mayoreo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">EL precio de mayoreo no puede estar vacío o ser menor a 0</small>`);
        };
        if (precio_menudeo.val() == '' || precio_menudeo.val() < 0) {
            error_cont++;
            precio_menudeo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El precio de menudeo no puede estar vacío o ser menor a 0</small>`);
        };
        if (error_cont === 0) {
            button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
            $.ajax({
                type: "POST",
                url: RUTA + "back/modelos",
                data: `opcion=ajuste&${formulario}&id_modelo=${id_modelo}`,
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText)
                    button.removeClass('disabled').removeAttr('disabled').html(text);
                },
                success: function (data) {
                    button.removeClass('disabled').removeAttr('disabled').html(text);

                    if (data.response == "success") {
                        MODAL_AJUSTAR.modal('hide')
                        Swal.fire({
                            title: 'Ajuste exitoso',
                            icon: 'success',
                            html: `<p>${data.text}<br></p>`,
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                        });
                        /**Limpieza de los campos */
                        inversion.val(0)
                        precio_mayoreo.val(0)
                        precio_menudeo.val(0)
                        traer_modelos();
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
}