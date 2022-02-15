$(document).ready(function () {
    $("#nuevo_producto").on('click', function () {
        let MODAL = $("#vista_producto_nuevo");
        MODAL.modal("show");

        $("#nueva_modelo").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nombre = form.find("[name=nombre]");
            let color = form.find("[name=color]");
            let talla = form.find("[name=talla]");
            let tipo = form.find("[name=tipo]");
            let codigo_fiscal = form.find("[name=codigo_fiscal]");
            let porcentaje_ganancia = form.find("[name=porcentaje_ganancia]");
            let codigo = form.find("[name=codigo]");
            let nuevo_color = ''
            for (let i = 0; i < color.length; i++) {
                if (color[i].checked) {
                    color = color[i].value
                    nuevo_color = color.toUpperCase()
                }
            }
            let fecha = new Date()
            let dia = fecha.getDate()
            let mes = fecha.getMonth()
            if (mes < 10) {
                mes = '0' + mes
            }
            let year = fecha.getFullYear()
            let fechaCompleta = dia + mes + year

            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

            if (nombre.val() == '' || nombre.val().length < 3 || !((EXPRESION.num_sup_text).test(nombre.val()))) {
                error_cont++;
                nombre.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (codigo.val() == '' || codigo.val().length < 2 || !((EXPRESION.num_text).test(codigo.val()))) {
                error_cont++;
                codigo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El código no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y números de 0-9.</small>`);
            };
            if (error_cont === 0) {

                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos",
                    data: `opcion=crear_modelo&${formulario}&color_nuevo=${nuevo_color}&fecha_completa=${fechaCompleta}`,
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
                                title: 'Registro con exito',
                                icon: 'success',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            /**Limpieza de los campos */
                            nombre.val("");
                            codigo.val("");
                            porcentaje_ganancia.val("");
                            traer_modelos();
                        } else if (data.response === "encontrado") {
                            MODAL.modal("hide");
                            let modelo = data.data
                            let COLOR = new Funciones()
                            let style = COLOR.setColor(modelo.color)
                            let styleStock = COLOR.setAlarmStock(modelo.cantidad - modelo.cantidad_vendida)
                            Swal.fire({
                                title: '¡Modelo Repetido!',
                                icon: 'error',
                                html: `
                                    <div class="col-12 modificar_modelo px-1" data-idmodelo="${modelo.id_modelo}">
                                        <div class="card mb-1 c-pointer modificar_modelo" ${style} model-id=${modelo.id_modelo}>
                                            <div class="card-body p-1 ">
                                                <div class="d-flex ">
                                                    <div class="avatar avatar-offline">
                                                        <span class="avatar-title rounded-circle border border-white bg-default">+</span>
                                                    </div>
                                                    <div class="flex-1 ml-3 pt-1">
                                                        <h6 class="text-uppercase fw-bold my-0 py-0 lh-2">Nombre: <span class="text-muted">${modelo.nombre}</span></h6>
                                                        <p class="my-0 py-0 lh-1"><b>COLOR:</b><span class="text-muted"> ${modelo.color}, </span> <b>TALLA:</b><span class="text-muted"> ${modelo.talla}</span> <b>TIPO:</b><span class="text-muted"> ${modelo.tipo}</span> <b ${styleStock}>STOCK:</b><span ${styleStock}> ${modelo.cantidad - modelo.cantidad_vendida}</span></p>
                                                        <p class="my-0 py-0 lh-1"></span></p>
                                                        <p class="my-0 py-0 lh-1"></p>
                                                        <table class="table">
                                                            <tbody>
                                                                <tr class="no_p">
                                                                    <td class="no_p">Menudeo</td>
                                                                    <td class="no_p">Mayoreo</td>
                                                                </tr>
                                                                <tr class="no_p">
                                                                    <td class="no_p">$ ${COLOR.number_format(modelo.precio_menudeo, 2)}</td>
                                                                    <td class="no_p">$ ${COLOR.number_format(modelo.precio_mayoreo, 2)}</td>
                                                                </tr>
                                                                <tr class="no_p">
                                                                    <td class="no_p">$ ${COLOR.number_format((modelo.precio_menudeo * 1.16), 2)} IVA</td>
                                                                    <td class="no_p">$ ${COLOR.number_format((modelo.precio_mayoreo * 1.16), 2)} IVA</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
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
            } else { }


        });
    });
});