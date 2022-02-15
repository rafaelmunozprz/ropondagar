$(document).ready(function () {
    $("#nueva_materia_prima").on('click', function () {
        let MODAL = $("#modal_new_materia");
        MODAL.modal("show");

        const CAT = new Categorias();
        let categorias = $("#nueva_materia").find("[name=id_categoria]").parent();
        CAT.categorias(categorias);


        $("#nueva_materia").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nombre = form.find("[name=nombre]");
            let color_nuevo = document.getElementsByName("color_nuevo")
            for (let index = 0; index < color_nuevo.length; index++) {
                if (color_nuevo[index].checked == true)
                    color_nuevo = color_nuevo[index].value
            }
            let medida = form.find("[name=medida]");
            let categorias = form.find("[name=id_categoria]");
            let unidad_medida = form.find("[name=unidad_medida]");
            let codigo_fiscal = form.find("[name=codigo_fiscal]");
            let porcentaje_ganancia = form.find("[name=porcentaje_ganancia]");
            let codigo = form.find("[name=codigo]");
            let fecha = new Date()
            let codigo_nuevo = "P"
            codigo_nuevo += nombre.val()[0]
            codigo_nuevo += codigo.val()
            codigo_nuevo += color_nuevo[0]
            codigo_nuevo += fecha.getDate()
            if (fecha.getMonth() < 10) {
                codigo_nuevo += '0' + (fecha.getMonth() + 1)
            } else {
                codigo_nuevo += (fecha.getMonth() + 1)
            }
            codigo_nuevo += fecha.getFullYear()
            codigo_nuevo = codigo_nuevo.toUpperCase()

            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();



            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

            if (nombre.val() == '' || nombre.val().length < 3 || !((EXPRESION.num_sup_text).test(nombre.val()))) {
                error_cont++;
                nombre.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            /* if (color.val() == '' || color.val().length < 3 || !((EXPRESION.sup_text).test(color.val()))) {
                error_cont++;
                color.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El color no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            }; */
            if (medida.val() == '' || !((EXPRESION.number).test(medida.val()))) {
                error_cont++;
                medida.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La medida no puede estar vacia, ingresa un valor numérico</small>`);
            };
            if (codigo.val() == '' || codigo.val().length < 3 || !((EXPRESION.num_sup_text).test(codigo.val()))) {
                error_cont++;
                codigo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El código no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y números de 0-9.</small>`);
            };
            if (porcentaje_ganancia.val() == '' || !((EXPRESION.number).test(porcentaje_ganancia.val()))) {
                error_cont++;
                porcentaje_ganancia.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El porcentaje debe ser representado solo por nùmeros de 0-9.</small>`);
            };

            if (error_cont === 0) {

                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/materiaprima",
                    data: `opcion=crear_materia&${formulario}&codigo_nuevo=${codigo_nuevo}`,
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
                            medida.val("");
                            codigo.val("");
                            codigo_fiscal.val("");
                            porcentaje_ganancia.val("");
                            traer_materias();
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