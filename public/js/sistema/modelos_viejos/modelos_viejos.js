class ModelosViejos {


    opciones_modelos_viejos(id_modelo_viejo) {
        let MODAL_OPCIONES = $("#modal_opciones_categoria")
        MODAL_OPCIONES.modal('show')

        $("#anadir_stock_viejo_ll").off().on('click', function () {
            MODAL_OPCIONES.modal('hide')
            let OPCIONES = new ModelosViejos()
            OPCIONES.anadir_stock(id_modelo_viejo)
        })

        $("#disminuir_stock_modelo_ll").off().on('click', function () {
            MODAL_OPCIONES.modal('hide')
            let OPCIONES = new ModelosViejos()
            OPCIONES.disminuir_stock(id_modelo_viejo)
        })


        $("#modificar_modelo_viejo_ll").off().on('click', function () {
            MODAL_OPCIONES.modal('hide')
            let OPCIONES = new ModelosViejos()
            OPCIONES.modificar_modelo_viejo(id_modelo_viejo)
        })

        $("#eliminar_modelo_viejo_ll").off().on('click', function () {
            MODAL_OPCIONES.modal('hide')
            let OPCIONES = new ModelosViejos()
            OPCIONES.eliminar_modelo_viejo(id_modelo_viejo)
        })

    }

    disminuir_stock(id_modelo_viejo) {
        let MODAL_STOCK = $("#vista_disminuir_stock_modelo_viejo")
        MODAL_STOCK.modal('show')
        $("#disminuir_stock_ll").off().submit(function (e) {
            e.preventDefault()
            let form = $(this)
            let button = form.find('button')
            let text = button.text()

            let formulario = form.serialize()
            let disminuir_stock = form.find("[name=disminuir_stock]");

            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();



            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION();

            if (disminuir_stock.val() == '' || disminuir_stock.val().length < 1 || !((EXPRESION.number).test(disminuir_stock.val()))) {
                error_cont++;
                disminuir_stock.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El stock no puede estar vacio o ser menor a 1</small>`);
            };

            if (error_cont === 0) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos_viejos",
                    data: `opcion=disminuir_stock&id_modelo_viejo=${id_modelo_viejo}&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            let TRAER_MODELOS = new ModelosViejos()
                            TRAER_MODELOS.traer_modelos_viejos()
                            MODAL_STOCK.modal('hide')
                            disminuir_stock.val(0)
                            Swal.fire(
                                '¡Elimnado!',
                                'El stock ha sido actualizado',
                                'success'
                            )
                        } else {
                            disminuir_stock.val(0)
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.text,
                            })
                        }
                    }
                });
            }
        })
    }

    eliminar_modelo_viejo(id_modelo_viejo) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este modelo?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar modelo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos_viejos",
                    data: `opcion=eliminar_modelo&id_modelo_viejo=${id_modelo_viejo}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo ha salido mal!',
                        })
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            let TRAER_MODELOS = new ModelosViejos()
                            TRAER_MODELOS.traer_modelos_viejos()
                            Swal.fire(
                                '¡Eliminado!',
                                'Tu modelo ha sido eliminado',
                                'success'
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.text,
                            })
                        }
                    }
                });
            }
        })
    }

    anadir_stock(id_modelo_viejo) {
        let MODAL_STOCK = $("#vista_agregar_stock_modelo_viejo")
        MODAL_STOCK.modal('show')
        $("#agregar_stock_ll").off().submit(function (e) {
            e.preventDefault()
            let form = $(this)
            let button = form.find('button')
            let text = button.text()

            let formulario = form.serialize()
            let nuevo_stock = form.find("[name=nuevo_stock]");

            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();



            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION();

            if (nuevo_stock.val() == '' || nuevo_stock.val().length < 1 || !((EXPRESION.number).test(nuevo_stock.val()))) {
                error_cont++;
                nuevo_stock.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El stock no puede estar vacio o ser menor a 1</small>`);
            };

            if (error_cont === 0) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos_viejos",
                    data: `opcion=agregar_stock&id_modelo_viejo=${id_modelo_viejo}&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            let TRAER_MODELOS = new ModelosViejos()
                            TRAER_MODELOS.traer_modelos_viejos()
                            MODAL_STOCK.modal('hide')
                            nuevo_stock.val(0)
                            Swal.fire(
                                '¡Agregado!',
                                'El stock ha sido actualizado',
                                'success'
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.text,
                            })
                        }
                    }
                });
            }
        })
    }

    nuevo_modelos() {
        let MODAL_NUEVO = $("#vista_nuevo_modelo_viejo")
        MODAL_NUEVO.modal('show')
        $("#nuevo_modelo_viejo_ll").off().submit(function (e) {
            e.preventDefault()

            let form = $(this);
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nombre = form.find("[name=modificar_nombre]");
            let talla = form.find("[name=modificar_talla]");
            let tipo = form.find("[name=modificar_tipo]");
            let color = form.find("[name=modificar_color]");
            let sexo = form.find("[name=modificar_sexo]");
            let precio_menudeo = form.find("[name=modificar_precio_menudeo]");
            let precio_mayoreo = form.find("[name=modificar_precio_mayoreo]");
            let codigo = form.find("[name=modificar_codigo]").val();


            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();



            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema


            if (error_cont === 0) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos_viejos",
                    data: `opcion=nuevo&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (response) {
                        button.removeClass('disabled').removeAttr('disabled').html(text);

                        if (response.response == "success") {
                            let MODAL = $("#vista_nuevo_modelo_viejo");
                            MODAL.modal("hide");
                            Swal.fire({
                                title: 'Registro con creado con éxito',
                                icon: 'success',
                                html: `<p>${response.text}<br></p>`,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                            });
                            let MODELOS = new ModelosViejos()
                            MODELOS.traer_modelos_viejos();
                        } else {
                            MODAL_NUEVO.modal("hide");
                            $.notify({
                                icon: 'fas fa-exclamation-circle',
                                title: 'Error al actualizar',
                                message: response.text,
                            }, {
                                type: "danger",
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                time: 1500,
                            });
                            setTimeout(() => {
                                MODAL_NUEVO.modal("show");
                            }, 2000);
                        }
                    }
                });
            } else { }
        })
    }

    editar_modelo_viejo(id_modelo_viejo) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/modelos_viejos",
            data: `opcion=mostrar&id_modelo_viejo=${id_modelo_viejo}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
            },
            success: function (response) {
                const FUNC = new Funciones()
                let form = $("#modificar_modelo_viejo");
                let modelo_viejo = response.data[0];

                form.find("[name=modificar_nombre]").val(modelo_viejo.nombre);
                form.find("[name=modificar_talla]").val(modelo_viejo.talla);
                $("#select_coloredit").html(`
                    <label class="form-label">Color</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item" style="background-color: #ffcbdb;">
                            <input type="radio" name="modificar_color" value="rosa" class="selectgroup-input" ${(modelo_viejo.color) === 'rosa' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Rosa</span>
                        </label>
                        <label class="selectgroup-item" style="background-color: #dd969c;">
                            <input type="radio" name="modificar_color" value="palo_de_rosa" class="selectgroup-input" ${(modelo_viejo.color) === 'palo_de_rosa' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Palo de Rosa</span>
                        </label>
                        <label class="selectgroup-item" style="background-color: #d29bfd;">
                            <input type="radio" name="modificar_color" value="morado" class="selectgroup-input" ${(modelo_viejo.color) === 'morado' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Morado</span>
                        </label>
                        <label class="selectgroup-item" style="background-color: #e1edf0;">
                            <input type="radio" name="modificar_color" value="blanco" class="selectgroup-input" ${(modelo_viejo.color) === 'blanco' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Blanco</span>
                        </label>
                        <label class="selectgroup-item text-dark" style="background-color: #c3b091;">
                            <input type="radio" name="modificar_color" value="kaki" class="selectgroup-input" ${(modelo_viejo.color) === 'kaki' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Kaki</span>
                        </label>
                        <label class="selectgroup-item" style="background-color: #eae6ca;">
                            <input type="radio" name="modificar_color" value="perla" class="selectgroup-input" ${(modelo_viejo.color) === 'perla' ? 'checked' : ""}>
                            <span class="selectgroup-button" style="color: black;">Perla</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_color" value="N/A" class="selectgroup-input" ${(modelo_viejo.color) === 'N/A' ? 'checked' : ""}>
                            <span class="selectgroup-button">N/A</span>
                        </label>
                    </div>`);
                $("#select_tipoedit").html(`
                <label class="form-label mb-0">Tipo</label>
                <div class="selectgroup px-3">
                    <div class="row">
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="normal" class="selectgroup-input" ${modelo_viejo.tipo == 'normal' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Normal</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="estola" class="selectgroup-input" ${modelo_viejo.tipo == 'estola' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Estola</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="nicker" class="selectgroup-input" ${modelo_viejo.tipo == 'nicker' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Nicker</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="desmontable" class="selectgroup-input" ${modelo_viejo.tipo == 'desmontable' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Desmontable</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="tirantes" class="selectgroup-input" ${modelo_viejo.tipo == 'tir' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Tirantes</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="bombacho" class="selectgroup-input" ${modelo_viejo.tipo == 'bombacho' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Bombacho</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="corto" class="selectgroup-input" ${modelo_viejo.tipo == 'corto' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Corto</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="largo" class="selectgroup-input" ${modelo_viejo.tipo == 'largo' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Largo</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="vestido" class="selectgroup-input" ${modelo_viejo.tipo == 'vestido' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Vestido</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="short" class="selectgroup-input" ${modelo_viejo.tipo == 'short' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Short</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="Bata" class="selectgroup-input" ${modelo_viejo.tipo == 'bata' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Bata</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_tipo" value="na" class="selectgroup-input" ${modelo_viejo.tipo == 'N/A' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">N/A</span>
                        </label>
                    </div>
                </div>`);
                $("#select_editsexo").html(`
                    <label class="form-label mb-0">Sexo</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_sexo" value="m" class="selectgroup-input" ${modelo_viejo.sexo === 'm' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Masculino</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_sexo" value="f" class="selectgroup-input" ${modelo_viejo.sexo === 'f' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">Femenino</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="modificar_sexo" value="N/A" class="selectgroup-input" ${modelo_viejo.sexo == 'N/A' ? 'checked=""' : ""}>
                            <span class="selectgroup-button">N/A</span>
                        </label>
                    </div>
                `);

                form.find("[name=modificar_precio_menudeo]").val(FUNC.number_format(modelo_viejo.precio_menudeo, 2));
                form.find("[name=modificar_precio_mayoreo]").val(FUNC.number_format(modelo_viejo.precio_mayoreo, 2));
                form.find("[name=modificar_stock]").val(modelo_viejo.stock);
                form.find("[name=modificar_codigo]").val(modelo_viejo.modelo);

                $("#modificar_modelo_viejo").off().submit(function (e) {
                    e.preventDefault()
                    let form = $(this);
                    let button = form.find('button');
                    let text = button.text();

                    let formulario = form.serialize();
                    let nombre = form.find("[name=modificar_nombre]");
                    let talla = form.find("[name=modificar_talla]");
                    let tipo = form.find("[name=modificar_tipo]");
                    let color = form.find("[name=modificar_color]");
                    let sexo = form.find("[name=modificar_sexo]");
                    let precio_menudeo = form.find("[name=modificar_precio_menudeo]");
                    let precio_mayoreo = form.find("[name=modificar_precio_mayoreo]");
                    let codigo = form.find("[name=modificar_codigo]").val();


                    let error_cont = 0;
                    $(".has-error").removeClass("has-error");
                    $(".ntf_form").remove();



                    const FUNC = new Funciones();
                    const EXPRESION = FUNC.EXPRESION(); //Expresiones de validación para el sistema

                    /* if (nombre.val() == '' || nombre.val().length < 3 || !((EXPRESION.num_sup_text).test(nombre.val()))) {
                        error_cont++;
                        nombre.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
                    }; */

                    if (error_cont === 0) {

                        button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                        $.ajax({
                            type: "POST",
                            url: RUTA + "back/modelos_viejos",
                            data: `opcion=actualizar_modelo&${formulario}&id_modelo_viejo=${codigo}`,
                            dataType: "JSON",
                            error: function (xhr, status) {
                                button.removeClass('disabled').removeAttr('disabled').html(text);
                                console.log(xhr.responseText)
                            },
                            success: function (response) {
                                button.removeClass('disabled').removeAttr('disabled').html(text);

                                if (response.response == "success") {
                                    let MODAL = $("#modal_modificar_modelo_viejo");
                                    MODAL.modal("hide");
                                    Swal.fire({
                                        title: 'Registro con actualizado con éxito',
                                        icon: 'success',
                                        html: `<p>${response.text}<br></p>`,
                                        showCloseButton: true,
                                        showCancelButton: false,
                                        focusConfirm: false,
                                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                                    });
                                    let MODELOS = new ModelosViejos()
                                    MODELOS.traer_modelos_viejos();
                                } else {
                                    let MODAL = $("#modal_modificar_modelo_viejo")
                                    MODAL.modal("hide");
                                    $.notify({
                                        icon: 'fas fa-exclamation-circle',
                                        title: 'Error al actualizar',
                                        message: response.text,
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
                })
            }
        });
    }



    modificar_modelo_viejo(id_modelo_viejo) {
        let MODAL_MODIFICAR = $("#modal_modificar_modelo_viejo")
        MODAL_MODIFICAR.modal('show')
        let MODIFICAR = new ModelosViejos()
        MODIFICAR.editar_modelo_viejo(id_modelo_viejo)
    }

    traer_modelos_viejos(pagina = 1, buscar = "", modelos_viejos_json = false) {
        let button = $("#paginacion")
        let contenedor = $("#contenedor_modelos_viejos")
        let borrar_ac = $("#borrar_busqueda")
        borrar_ac.parent().show()
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`)
        $.ajax({
            type: "POST",
            url: RUTA + "back/modelos_viejos",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                button.parent().hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    const modelo_viejo = new ModelosViejos()
                    const respuesta = response.data;

                    button.parent().show();
                    if (!modelos_viejos_json) modelos_viejos_json = respuesta
                    else for (const modelo of respuesta) { modelos_viejos_json.push(modelo) }


                    if (pagina <= 1) contenedor.html(modelo_viejo.modelos_viejos(respuesta));
                    else contenedor.append(modelo_viejo.modelos_viejos(respuesta));

                    let paginar = true;
                    let pg = response.pagination; //Paginacion
                    let limite = (pg.page * pg.limit);
                    if (limite >= pg.total) paginar = false;

                    if (!paginar) button.parent().hide();

                    button.off().on('click', function () {
                        let button = $(this);
                        button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                        button.off();
                        setTimeout(() => {
                            let TRAER_MODELOS = new ModelosViejos()
                            TRAER_MODELOS.traer_modelos_viejos(pagina + 1, buscar, modelos_viejos_json);
                        }, 500);
                    });

                    $(".modificar_modelo_viejo").off().on('click', function () {
                        let modelo_viejo = $(this);
                        /* let OPCIONES = new ModelosViejos()
                        OPCIONES.modificar_modelo_viejo(modelo_viejo.attr("model-id")) */
                        let OPCIONES = new ModelosViejos()
                        OPCIONES.opciones_modelos_viejos(modelo_viejo.attr("model-id"))
                    });
                } else {
                    button.parent().hide();
                    if (pagina == 1) contenedor.html(`
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontrarón resultados de tu búsqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que el modelo que estás buscando no exista</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
                }
                borrar_ac.off().on('click', function () {
                    borrar_ac.parent().hide();
                    button.parent().hide();
                    contenedor.html("");
                });
            }
        });
    }
    cuerpo_modelos_viejos(modelo_viejo) {
        const FUNC = new Funciones();
        let style = FUNC.setColor(modelo_viejo.color)
        let styleStock = FUNC.setAlarmStock(modelo_viejo.stock)
        return `
        <div class="card mb-1 c-pointer modificar_modelo_viejo" ${style} model-id=${modelo_viejo.id_modelo_viejo}>
            <div class="card-body p-1 ">
                <div class="d-flex ">
                    <div class="avatar avatar-offline">
                        <span class="avatar-title rounded-circle border border-white bg-default">+</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold my-0 py-0 lh-2">Nombre: <span class="text-muted">${modelo_viejo.nombre}</span></h6>
                        <p class="my-0 py-0 lh-1"><b>COLOR:</b><span class="text-muted"> ${modelo_viejo.color}, </span> <b>TALLA:</b><span class="text-muted"> ${modelo_viejo.talla}</span> <b>TIPO:</b><span class="text-muted"> ${modelo_viejo.tipo}</span> <b ${styleStock}>STOCK:</b><span ${styleStock}> ${modelo_viejo.stock}</span></p>
                        <p class="my-0 py-0 lh-1"></span></p>
                        <p class="my-0 py-0 lh-1"></p>
                        <table class="table">
                            <tbody>
                                <tr class="no_p">
                                    <td class="no_p">Menudeo</td>
                                    <td class="no_p">Mayoreo</td>
                                </tr>
                                <tr class="no_p">
                                    <td class="no_p">$ ${FUNC.number_format(modelo_viejo.precio_menudeo, 2)}</td>
                                    <td class="no_p">$ ${FUNC.number_format(modelo_viejo.precio_mayoreo, 2)}</td>
                                </tr>
                                <tr class="no_p">
                                    <td class="no_p">$ ${FUNC.number_format(modelo_viejo.precio_menudeo_iva, 2)} IVA</td>
                                    <td class="no_p">$ ${FUNC.number_format(modelo_viejo.precio_mayoreo_iva, 2)} IVA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>`;
    }
    modelos_viejos(modelos_viejos) {
        let cuerpo = '';
        for (const modelo of modelos_viejos) {
            cuerpo += `<div class="col-md-6 col-12">${this.cuerpo_modelos_viejos(modelo)}</div>`;
        }
        return cuerpo;
    }
}