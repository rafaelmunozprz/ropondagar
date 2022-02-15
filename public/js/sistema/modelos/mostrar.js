$(document).ready(function () {
    traer_modelos();
    $("#form_search_modelos").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_model = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_modelos(1, search_model);
        }, 500);
    });

    traer_historial_hoy()
    $("#form_historial_hoy").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let buscador_hoy = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_historial_hoy(buscador_hoy);
        }, 500);
    })

    traer_historial_ayer()
    $("#form_historial_ayer").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let buscador_ayer = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_historial_ayer(buscador_ayer);
        }, 500);
    })

    traer_historial_siete_dias()
    $("#form_historial_siete_dias").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let buscador_siete = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_historial_siete_dias(buscador_siete);
        }, 500);
    })

    traer_historial_treinta_dias()
    $("#form_historial_treinta_dias").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let buscador_treinta = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_historial_treinta_dias(buscador_treinta);
        }, 500);
    })

    traer_historial_siempre()
    $("#form_historial_siempre").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let buscador_siempre = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_historial_siempre(1, buscador_siempre);
        }, 500);
    })

    traer_historial_personalizado()
    $("#form_historial_personalizado").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let buscado_personalizado = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_historial_personalizado(1, buscado_personalizado);
        }, 500);
    })

    traer_modelos_desactivados()
    $("#form_search_modelos_desactivados").off().submit(function (e) {
        e.preventDefault()
        let form = $(this);
        let modelo_desactivado = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_modelos_desactivados(1, modelo_desactivado);
        }, 500);
    })
});

function traer_modelos(pagina = 1, buscar = "", modelos_json = false) {
    let button = $("#paginacion");
    let contenedor = $("#contenedor_modelos");
    let borrar_ac = $("#borrar_busqueda");
    borrar_ac.parent().show();
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            button.parent().hide();
        },
        success: function (response) {
            if (response.response == 'success') {

                const client = new Modelos();
                const respuesta = response.data; //Datos que llegan desde la API

                button.parent().show();

                if (pagina <= 1) contenedor.html(client.mostrar_modelos(respuesta));
                else contenedor.append(client.mostrar_modelos(respuesta));
                /** Validación de más paginacion */
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
                        traer_modelos(pagina + 1, buscar);
                    }, 500);
                });

                $(".modificar_modelo").off().on('click', function () {
                    let modelo_sel = $(this);
                    let OPCIONES = new Modelos();
                    OPCIONES.opciones_modelos(modelo_sel.attr("data-idmodelo"), modelo_sel.find("img"))
                    //editar_modelo(modelo_sel.attr("data-idmodelo"), modelo_sel.find("img"));

                })
            } else {
                button.parent().hide();
                if (pagina == 1) contenedor.html(`
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontrarón resultados de tu busqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que el modelo que estas buscando no exista</h4>
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


class Modelos {

    /**
     * 
     * @param {Array.<string>} movimientos lista elementos coincidentes con la busqueda y el filtro de tiempo
     * @returns {HTMLElement} objeto html con el contenido de todo el hisorial
     */
    mostrar_historial(movimientos) {
        let FUNC = new Funciones()

        let cuerpo = ''
        for (const movimiento of movimientos) {
            let tipo = movimiento.tipo_movimiento
            let clase = '', kind = '', i = ''
            switch (tipo) {
                case 'aumento_maquila':
                    clase = 'class="badge badge-pill badge-success"'
                    kind = 'Ingreso'
                    i = '<i class="fas fa-arrow-circle-up"></i>'
                    break
                case 'reduccion_maquila':
                    clase = 'class="badge badge-pill badge-warning"'
                    kind = 'Salida'
                    i = '<i class="fas fa-arrow-circle-down"></i>'
                    break
                case 'venta':
                    clase = 'class="badge badge-pill badge-danger"'
                    kind = 'Venta'
                    i = '<i class="fas fa-arrow-circle-down"></i>'
                    break
            }
            let fecha = FUNC.fechaFormato(movimiento.fecha)
            cuerpo += `
                <tr>
                    <td><span ${clase} > ${kind} ${i}</span></td>
                    <td>${movimiento.codigo.toUpperCase()}</td>
                    <td>${FUNC.MESES(fecha[1])} ${fecha[0]}, de ${fecha[2]}</td>
                    <td>${movimiento.cantidad}</td>
                </tr>`
        }
        return cuerpo
    }

    cargar_precios_viejos(id_modelo) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/modelos",
            data: `opcion=cargar_precios_viejos&id_modelo=${id_modelo}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.text,
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    let inversion = $("#inversion")
                    let precio_mayoreo = $("#precio_mayoreo")
                    let precio_menudeo = $("#precio_menudeo")

                    inversion.val(response.data.costo)
                    precio_menudeo.val(response.data.precio_menudeo)
                    precio_mayoreo.val(response.data.precio_mayoreo)
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.text,
                    })
                }
            }
        });
    }

    desminuir_stock(id_modelo, stock) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/modelos",
            data: `opcion=disminiur_stock&id_modelo=${id_modelo}&stock=${stock}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
            },
            success: function (response) {
                if (response.response == 'success') {
                    let MODAL_DISMINUIR_STOCK = $("#modal_disminuir_stock")
                    MODAL_DISMINUIR_STOCK.modal('hide')
                    traer_modelos()
                    traer_historial_hoy()
                    let nuevo_stock = $("#disminuir_stock_LL").val(0)
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

    anadir_stock(id_modelo) {

        $("#agregar_stock").off().submit(function (e) {
            e.preventDefault();
            let form = $(this)
            let button = form.find('button');
            let text = button.text();

            let formulario = form.serialize();
            let nuevo_stock = form.find("[name=nuevo_stock]");
            let error_cont = 0;
            $(".has-error").removeClass("has-error");
            $(".ntf_form").remove();

            const FUNC = new Funciones();
            const EXPRESION = FUNC.EXPRESION();
            if (nuevo_stock.val() == '' || nuevo_stock.val().length < 0) {
                error_cont++;
                nuevo_stock.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El stock no puede estar vacio o ser menor a 0</small>`);
            };
            if (error_cont === 0) {
                button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/modelos",
                    data: `opcion=agregar_stock&id_modelo=${id_modelo}&${formulario}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                        button.removeClass('disabled').removeAttr('disabled').html(text);
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            button.removeClass('disabled').removeAttr('disabled').html(text);
                            let MODAL_ANADIR_STOCK = $("#modal_agregar_stock_modelo")
                            MODAL_ANADIR_STOCK.modal('hide')
                            traer_modelos()
                            traer_historial_hoy()
                            nuevo_stock.val(0)
                            Swal.fire(
                                '¡Agregado!',
                                'El stock ha sido actualizado',
                                'success'
                            )
                            /**
                             * aqui
                             */
                            let ITEMS = localStorage.getItem('venta_notas')
                            ITEMS = JSON.parse(ITEMS)
                            ITEMS = ITEMS.productos
                            let index = ITEMS.findIndex(i => i.id == id_modelo)
                            if (index !== -1) {
                                ITEMS.splice(index, 1)
                                let ITEM = JSON.parse(localStorage.getItem('venta_notas'))
                                ITEM.productos = ITEMS
                                localStorage.removeItem('venta_notas')
                                localStorage.setItem('venta_notas', JSON.stringify(ITEM))
                            }
                        } else {
                            button.removeClass('disabled').removeAttr('disabled').html(text);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.text,
                            })
                        }
                    }
                });
            }
        });
    }

    opciones_modelos(id_modelo, img) {
        let MODAL_OPCIONES = $("#modal_opciones_modelos")
        MODAL_OPCIONES.modal("show")

        $("#anadir_stock_modelo").off().on('click', function (e) {
            MODAL_OPCIONES.modal("hide")
            let MODAL_ANADIR_STOCK = $("#modal_agregar_stock_modelo")
            MODAL_ANADIR_STOCK.modal('show')
            let ANADIR = new Modelos()
            ANADIR.anadir_stock(id_modelo)
        })

        $("#disminuir_stock").off().on('click', function (e) {
            MODAL_OPCIONES.modal("hide")
            disminuir(id_modelo)
        })

        $("#modificar_modelo_viejo").off().on('click', function (e) {
            MODAL_OPCIONES.modal("hide")
            editar_modelo(id_modelo, img)
        })

        $("#ajustar_precio_modelo").off().on('click', function (e) {
            MODAL_OPCIONES.modal("hide")
            ajustar_precio(id_modelo)
        })

        /* $("#anadir_stock_modelo").off().on('click', function (e) {
            MODAL_OPCIONES.modal("hide")
            let MODAL_ANADIR_STOCK = $("#modal_agregar_stock_modelo")
            MODAL_ANADIR_STOCK.modal('show')
            let ANADIR = new Modelos()
            ANADIR.anadir_stock(id_modelo)
        }) */
    }

    cuerpo_modelo(modelo) {
        let COLOR = new Funciones()
        let style = COLOR.setColor(modelo.color)
        let imagen = (modelo.galeria && modelo.galeria[0].is_file ? modelo.galeria[0].imagen : "galeria/sistema/default/default_modelo.png");
        let styleStock = COLOR.setAlarmStock(modelo.cantidad - modelo.cantidad_vendida)
        return `
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
        </div>`;
    }
    mostrar_modelos(modelos) {
        let cuerpo = '';
        for (const modelo of modelos) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 modificar_modelo px-1" data-idmodelo="${modelo.id_modelo}">${this.cuerpo_modelo(modelo)}</div>`;
        }
        return cuerpo;
    }

    /**
     * 
     * @param {Array.<string>} modelo 
     * @returns {HTMLElement}
     */
    cuerpo_modelo_desactivado(modelo) {
        let COLOR = new Funciones()
        let style = COLOR.setColor(modelo.color)
        let imagen = (modelo.galeria && modelo.galeria[0].is_file ? modelo.galeria[0].imagen : "galeria/sistema/default/default_modelo.png");
        let styleStock = COLOR.setAlarmStock(modelo.cantidad - modelo.cantidad_vendida)
        return `
        <div class="card mb-1 c-pointer" ${style} model-id=${modelo.id_modelo}>
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
        </div>`;
    }

    /**
     * 
     * @param {JSON} modelos 
     * @returns {HTMLElement}
     */
    mostrar_modelos_desactivados(modelos) {
        let cuerpo = '';
        for (const modelo of modelos) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 m-4 modelo_desactivado px-1" data-idmodelo="${modelo.id_modelo}">${this.cuerpo_modelo_desactivado(modelo)}</div>`;
        }
        return cuerpo;
    }
}