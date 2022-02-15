/**
 * 
 * @param {Number} id_materia identificador unico de la materia prima en base de datos
 * 
 */
function editar_materia_prima(id_materia) {
    let MODAL = $("#modal_editar_materia");
    let materia_content = $("#materiaprima_form_cont");

    $.ajax({
        type: "POST",
        url: RUTA + "back/materiaprima",
        data: "opcion=mostrar&id_materia=" + id_materia,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            // button.removeAttr("disabled").removeClass("disabled").html(text);
        },
        success: function (data) {
            if (data.response == "success") {
                MODAL.modal('show');
                const MP = new Materias();
                /**
                 * Titulo con contenido de la materia prima y button para poder modificar
                 */
                let cont_title = materia_content.find(".cuerpo_materiaprima");

                let materiaprima = data.data[0];
                cont_title.html(`<div class="col-12 text-justify">${MP.cuerpo_materia(materiaprima)}</div>`);
                cont_title.append(`
                    <div class="col-12 text-justify">
                        <a class="btn bg-dark text-white py-0 mostrar_opciones" title="Ubicar en almacen">
                            <i class="fas fa-barcode fa-2x"></i>
                        </a>
                        <div class="body_opciones" style="width:100%; display:none;">
                            <img class="barcode" 
                                jsbarcode-value="${materiaprima.codigo}" 
                                jsbarcode-height="50" 
                                jsbarcode-textmargin="0" 
                                jsbarcode-fontoptions="bold" 
                                style="width:100%; max-width:270px;" 
                                title="${materiaprima.codigo}"/><br>   
                        </div>
                    </div>`);

                cont_title.append(`<div class="col-12 text-right"><a href="#" class="h4 text-info modificar_materia_prima"> <u> <i class="fas fa-tools mr-2"></i> Modificar materia prima</u></a></div>`);
                $(".mostrar_opciones").on('click', function () {
                    $(this).parent().find(".body_opciones").toggle("show");
                });
                $(".modificar_materia_prima").off().on('click', function () {
                    let evento = $(this);
                    materia_content.find(".cuerpo_materiaprima").toggle('show');
                    materia_content.find(".configurar_materiaprima").toggle('show');
                });
                let form = $("#editar_materia");


                form.find("[name=codigo_fiscal]").val(materiaprima.codigo_fiscal);
                form.find("[name=nombre]").val(materiaprima.nombre);
                form.find("[name=color]").val(materiaprima.color);
                $("#select_coloredit").html(`
                    <label class="form-label">Color</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item" style="background-color: #e1edf0;">
                            <input type="radio" name="color" value="blanco" class="selectgroup-input" ${(materiaprima.color) === 'blanco' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Blanco</span>
                        </label>
                        <label class="selectgroup-item text-dark" style="background-color: #c3b091;">
                            <input type="radio" name="color" value="kaki" class="selectgroup-input" ${(materiaprima.color) === 'kaki' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Kaki</span>
                        </label>
                        <label class="selectgroup-item" style="background-color: #eae6ca;">
                            <input type="radio" name="color" value="perla" class="selectgroup-input" ${(materiaprima.color) === 'perla' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Perla</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="color" value="N/A" class="selectgroup-input" ${(materiaprima.color) === 'N/A' ? 'checked' : ""}>
                            <span class="selectgroup-button">N/A</span>
                        </label>
                    </div>`);
                form.find("[name=medida]").val(materiaprima.medida);
                form.find("[name=unidad_medida]").val(materiaprima.unidad_medida);
                form.find("[name=porcentaje_ganancia]").val(materiaprima.porcentaje_ganancia);
                form.find("[name=codigo]").val(materiaprima.codigo);
                $("#select_umedida").html(`
                    <label class="form-label">Unidad de medida</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="unidad_medida" value="m" class="selectgroup-input" ${materiaprima.unidad_medida == 'm' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">m</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="unidad_medida" value="cm" class="selectgroup-input" ${materiaprima.unidad_medida == 'cm' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">cm</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="unidad_medida" value="mm" class="selectgroup-input" ${materiaprima.unidad_medida == 'mm' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">mm</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="unidad_medida" value="pieza" class="selectgroup-input"  ${materiaprima.unidad_medida == 'pieza' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">pieza</span>
                        </label>
                    </div>`);

                /**Control stock */
                $("#container_stock").html("");

                if (materiaprima.stock) $("#container_stock").html(MP.mostrar_stock(materiaprima.stock));

                load_barcode();

                /**Control stock */


                const CAT = new Categorias(); //Llamado a las categorias
                CAT.categorias((form.find("[name=id_categoria]").parent()), (materiaprima.id_categoria)); // Impresión de categorias

                editar(id_materia, materiaprima, MODAL);

            }
        }
    });

    /**
     * 
     * @param {Number} id_materia identificador único de un tipo de materia prima en base de datos
     * @param {JSON} materiaprima objeto que contiene la información de dicha materia prima desde la base de datos
     * @param {HTMLElement} MODAL Información del MODAL editar materia prima
     */
    function editar(id_materia, materiaprima, MODAL) {
        $("#editar_materia").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nombre = form.find("[name=nombre]");
            let color = form.find("[name=color]");
            let medida = form.find("[name=medida]");
            let categorias = form.find("[name=id_categoria]");
            let unidad_medida = form.find("[name=unidad_medida]");
            let codigo_fiscal = form.find("[name=codigo_fiscal]");
            let porcentaje_ganancia = form.find("[name=porcentaje_ganancia]");
            let codigo = form.find("[name=codigo]");

            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

            if (nombre.val() == '' || nombre.val().length < 3 || !((EXPRESION.num_sup_text).test(nombre.val()))) {
                error_cont++;
                nombre.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (color.val() == '' || color.val().length < 3 || !((EXPRESION.sup_text).test(color.val()))) {
                error_cont++;
                color.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El color no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
            };
            if (medida.val() == '' || !((EXPRESION.number).test(medida.val()))) {
                error_cont++;
                medida.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La medida no puede estar vacia, ingresa un valor numérico</small>`);
            };
            if (codigo.val() == '' || codigo.val().length < 3 || !((EXPRESION.num_text).test(codigo.val()))) {
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
                    data: `opcion=modificar_materia&id_materia=${id_materia}&${formulario}`,
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
                                confirmButtonText: '¡Continuar!',
                            });
                            /**Limpieza de los campos */
                            nombre.val("");
                            color.val("");
                            medida.val("");
                            codigo.val("");
                            porcentaje_ganancia.val("");
                            $("#form_search_materias").find('[name="buscador"]').val("");
                            $("#form_search_materias").submit();
                            $("#materiaprima_form_cont").find(".cuerpo_materiaprima").show();
                            $("#materiaprima_form_cont").find(".configurar_materiaprima").hide();
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
    }

    async function load_barcode() {
        let imagen = ".barcode";
        let code = await JsBarcode(imagen).init();
        //tiene que terminar antes de poder hacer el recorrido de lo contrario la funcion no sirve de nada
        //La funcion no devuelve la imagen así que tiene que terminar su proceso

        $(imagen).each(function (index, element) {
            // Se recorren todas las imagenes y se agrega el botón de descarga
            let img = $(element).attr('src');
            let title = $(element).attr('title');
            $(element).parent().append(`<a class="btn btn-primary py-1 px-2" href="${img}" download="${title}"> <i class="fas fa-save"></i> Descargar</a>`);
        });
    }
}