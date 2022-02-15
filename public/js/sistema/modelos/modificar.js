function editar_modelo(id_modelo, card_model_imagen) {
    let MODAL = $("#modal_editar_modelo");
    let modelo_content = $("#modelo_form_cont");
    $("#form_search_materiaprima").find("[name=buscador]").val("");
    $("#editar_modelo").find("img").attr("src", `${RUTA}galeria/sistema/default/default_modelo.png`);

    $("#contenedor_materia").html("");
    $(".has-error").removeClass("has-error");
    $(".ntf_form").remove();

    $("#btn_eliminar_modelo").off().on('click', function () {
        eliminar_modelo(id_modelo)
    })

    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: "opcion=mostrar&id_modelo=" + id_modelo,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            // button.removeAttr("disabled").removeClass("disabled").html(text);
        },
        success: function (data) {
            if (data.response == "success") {
                MODAL.modal('show');
                const MP = new Modelos();
                /**
                 * Titulo con contenido de la modelo prima y button para poder modificar
                 */
                $(".modificar_modelo_views").off().on('click', function () {
                    let evento = $(this);
                    modelo_content.find(".cuerpo_modelo").toggle('show');
                    modelo_content.find(".modelo_materiaprima").toggle('show');
                });

                let form = $("#editar_modelo");
                let modelo = data.data[0];
                form.find(`#input`).replaceWith('<input type="file" class="sr-only" id="input" name="image" accept="image/*">'); //Vacia el input
                let is_file = (modelo.galeria && modelo.galeria[0].is_file ? true : false);
                let imagen = (is_file ? modelo.galeria[0].imagen : "galeria/sistema/default/default_modelo.png");
                $("#editar_modelo").find("img").attr("src", `${RUTA + imagen}`).attr("data-id-image", (is_file ? modelo.galeria[0].id_galeria_modelo : "")); //Vista del producto modificada y atributo por si hay que replazar imagen

                form.find("[name=nombre]").val(modelo.nombre);
                form.find("[name=talla]").val(modelo.talla);
                form.find("[name=codigo_fiscal]").val(modelo.codigo_fiscal);
                form.find("[name=codigo]").val(modelo.codigo);
                form.find("[name=codigo_completo]").val(modelo.codigo_completo);

                $.each(form.find("[name=color]"), function (i, elemento) {
                    if ($(elemento).attr("value") == modelo.color) $(elemento).parent().click();
                });
                $.each(form.find("[name=tipo]"), function (i, elemento) {
                    if ($(elemento).attr("value") == modelo.tipo) $(elemento).parent().click();
                });
                $.each(form.find("[name=sexo]"), function (i, elemento) {
                    if ($(elemento).attr("value") == modelo.sexo) $(elemento).parent().click();
                });
                const STORE = new Materia_store(); //Llama la clase que almacena los elementos osea materiaprima, para ser modificada en caso de que se requiera
                STORE.clean(); //Limpia el localstorage para almacenar el nuevo modelo
                let materia_body = $("#body_materiaprima_table");
                materia_body.html("");
                if (modelo.materia_prima) {
                    const mat = new Materias();
                    STORE.set_materia_modelo(JSON.stringify(modelo.materia_prima));
                    materia_body.html(mat.table_materias(modelo.materia_prima));
                }
                $("#modelo_form_cont").find(".cuerpo_modelo").show(); //Devuelve a la pantalla principal
                $("#modelo_form_cont").find(".modelo_materiaprima").hide(); // oculta la pantalla secundaria 
                editar(id_modelo, modelo, MODAL); //llama la funcion editar se separo para poder trabajarla por separado pero igual puede funcionar en código spaguetty
                remove_materiaprima(); //Lo mismo aquí

                /**MODIFICAR IMAGEN */
                modificar_imagen(modelo, MODAL, card_model_imagen); //modificar_imagen.js

            }
        }
    });

    function eliminar_modelo(id_modelo) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este modelo?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos",
                    data: `opcion=eliminar_modelo&id_modelo=${id_modelo}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `¡Algo ha salido mal!`,
                            text: `${xhr.responseText}`,
                        })
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            Swal.fire(
                                '¡Modelo eliminado!',
                                `${response.text}`,
                                'success'
                            )
                            traer_modelos()
                            traer_modelos_desactivados()
                        } else {
                            Swal.fire(
                                '¡Algo salió mal!',
                                `${response.text}`,
                                'error'
                            )
                        }
                    }
                });

            }
        })
    }

    function editar(id_modelo, modelo, MODAL) {
        $("#editar_modelo").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);

            let formulario = form.serialize();
            let nombre = form.find("[name=nombre]");
            let color = form.find("[name=color]");
            let talla = form.find("[name=talla]");
            let tipo = form.find("[name=tipo]");
            let porcentaje_ganancia = form.find("[name=porcentaje_ganancia]");
            let codigo_fiscal = form.find("[name=codigo_fiscal]");
            let codigo = form.find("[name=codigo]");
            let codigo_completo = form.find("[name=codigo_completo]");


            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

            if (nombre.val() == '' || nombre.val().length < 3 || !((EXPRESION.num_sup_text).test(nombre.val()))) {
                error_cont++;
                nombre.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };

            // if (talla.val() == '' || talla.val().length < 2 || !((EXPRESION.num_text).test(talla.val()))) {
            //     error_cont++;
            //     talla.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La talla no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            // };
            /*  if (color.val() == '' || !((EXPRESION.num_text).test(color.val()))) {
                 error_cont++;
                 color.parent().parent().parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El color no puede estar vacio.</small>`);
             };
             if (tipo.val() == '' || !((EXPRESION.num_text).test(tipo.val()))) {
                 error_cont++;
                 tipo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El tipo no puede estar vacio</small>`);
             }; */
            if (codigo.val() == '' || codigo.val().length < 2 || !((EXPRESION.num_text).test(codigo.val()))) {
                error_cont++;
                codigo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El código no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y números de 0-9.</small>`);
            };
            if ((codigo_completo.val() != '' && codigo_completo.val().length < 4) || !((EXPRESION.num_sup_text).test(codigo_completo.val()))) {
                error_cont++;
                codigo_completo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">Si ingresas un código completo asegurate de que sea mayor a 4 caracteres recuerda que solo debes de utilizar letras de la A-Z y números de 0-9.</small>`);
            };
            // materiales = JSON.stringify(materiales);
            if (error_cont === 0) {
                const STORE = new Materia_store();
                let materiales = STORE.before_send(); //Busca en el storage lo restante ya hecho texto plano

                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos",
                    data: `opcion=modificar_modelo&id_modelo=${id_modelo}&materia_prima=${materiales}&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                    },
                    success: function (data) {
                        if (data.response == "success") {
                            MODAL.modal("hide");

                            Swal.fire({
                                title: 'Actualización exitosa',
                                icon: 'success',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '¡Continuar!',
                            });
                            /**Limpieza de los campos */
                            $("#form_search_modelos").find('[name="buscador"]').val("");
                            $("#modelo_form_cont").find(".cuerpo_modelo").show()
                            $("#modelo_form_cont").find(".modelo_materiaprima").hide();
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
            } else { }


        });
    }
}

class Materia_store {
    store = {
        'store_materiales': 'materiales_modelo',
    };
    set_materia_modelo(materiales) {
        localStorage.setItem(this.store.store_materiales, materiales);
    }
    get_materia_modelo() {
        let materiales = JSON.parse(localStorage.getItem(this.store.store_materiales));
        return materiales;
    }
    remove_materia_modelo(id_materia_prima) {
        let materiales = this.get_materia_modelo();
        if (materiales) {
            let new_mat = [];
            for (const material of materiales) {
                if (material.id_materia_prima == id_materia_prima); //console.log(material);
                else new_mat.push(material);
            }
            this.set_materia_modelo(JSON.stringify(new_mat)); //Limpia y almacena los datos en el localstorage para los cambios
        } else this.clean();
    }
    clean() {
        localStorage.removeItem(this.store.store_materiales)
    }
    before_send() {
        let materiales = this.get_materia_modelo();

        let new_mat = '';
        if (materiales) {
            new_mat = [];
            for (const material of materiales) {
                new_mat.push({
                    cantidad: material.cantidad,
                    id_materia_prima: material.id_materia_prima,
                });
            }
            new_mat = JSON.stringify(new_mat);
        }
        return new_mat;

    }

}