/**
 * @param {Number} id_categoria identificador único de la categoría que será usado
 * @param {URL} card_categoria_imagen dirección de la imagen correspondiente de la categoria
 */
function editar_categoria(id_categoria, card_categoria_imagen) {
    let MODAL = $("#modal_editar_categoria");
    let categoria_content = $("#categoria_form_cont");
    $("#form_search_materiaprima").find("[name=buscador]").val("");
    $("#editar_categoria").find("img").attr("src", `${RUTA}galeria/sistema/default/default_modelo.png`);

    $("#contenedor_categoria").html("");

    $.ajax({
        type: "POST",
        url: RUTA + "back/categorias",
        data: "opcion=mostrar&id_categoria=" + id_categoria,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            // button.removeAttr("disabled").removeClass("disabled").html(text);
        },
        success: function (data) {
            if (data.response == "success") {
                MODAL.modal('show');
                const MP = new Categorias();
                /**
                 * Titulo con contenido de la modelo prima y button para poder modificar
                 */
                $(".modificar_categoria_views").off().on('click', function () {
                    let evento = $(this);
                    categoria_content.find(".cuerpo_categoria").toggle('show');
                });

                let form = $("#editar_categoria");
                let categoria = data.data[0];
                form.find(`#input`).replaceWith('<input type="file" class="sr-only" id="input" name="image" accept="image/*">');
                let is_file = (categoria.galeria && categoria.galeria[0].is_file ? true : false);
                let imagen = (is_file ? categoria.galeria[0].imagen : "galeria/sistema/default/default_modelo.png");
                $("#editar_categoria").find("img").attr("src", `${RUTA + imagen}`).attr("data-id-image", (is_file ? categoria.galeria[0].id_galeria_modelo : "")); //Vista del producto modificada y atributo por si hay que replazar imagen

                form.find("[name=nombre]").val(categoria.nombre);
                form.find("[name=estado]").val(categoria.estado);
                form.find("[name=tipo]").val(categoria.tipo);


                $("#categoria_form_cont").find(".cuerpo_categoria").show(); //Devuelve a la pantalla principal
                editar(id_categoria, categoria, MODAL);
            }
        }
    });

    /**
     * 
     * @param {Number} id_categoria identificador único de la categoria que sera editada
     * @param {String} categoria nombre de la categoría que sera editada
     * @param {HTMLElement} MODAL informacion del elemento HTML MODAL
     */
    function editar(id_categoria, categoria, MODAL) {
        $("#editar_categoria").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nombre = form.find("[name=nombre]");
            let estado = form.find("[name=estado]");


            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

            if (nombre.val() == '' || nombre.val().length < 3 || !((EXPRESION.num_sup_text).test(nombre.val()))) {
                error_cont++;
                nombre.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };

            if (estado.val() == '' || estado.val().length < 2 || !((EXPRESION.num_text).test(estado.val()))) {
                error_cont++;
                estado.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El estado no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (error_cont === 0) {

                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/categorias",
                    data: `opcion=modificar&id_categoria=${id_categoria}&${formulario}`,
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
                                title: 'Actualización exitosa',
                                icon: 'success',
                                html: `<p>${data.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '¡Continuar!',
                            });
                            /**Limpieza de los campos */
                            $("#form_search_categorias").find('[name="buscador_categorias"]').val("");
                            $("#categorias_form_cont").find(".cuerpo_categoria").show()
                            traer_categorias();

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