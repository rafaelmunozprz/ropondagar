$(document).ready(function () {
    let value_search = "";
    $("#form_search_almacen").keyup(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_model = form.find("[name=buscador]").val();
        traer_modelos(1, search_model);
    });
    // $("#form_search_almacen").find("[name=buscador]").keyup(delay(function (e) {
    //     console.log('Leer');
    //     let consulta = $(this).val();
    //     traer_modelos(1, consulta);
    // }, 1000));

    function delay(callback, ms) {
        var timer = 0;
        return function () {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    function traer_modelos(pagina = 1, buscar = "", modelos_json = false) {
        let button = $("#paginacion a");
        let contenedor = $("#contenedor_modelos");
        let borrar_ac = $("#borrar_busqueda");
        borrar_ac.parent().show();
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
        $.ajax({
            type: "POST",
            url: RUTA + "back/modelos/viejos",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                button.parent().hide();
            },
            success: function (response) {
                if (response.response == 'success') {
                    const model = new ModelosConstr();
                    const respuesta = response.data; //Datos que llegan desde la API

                    button.parent().show();
                    if (!modelos_json) modelos_json = respuesta;
                    else
                        for (const mod_i of respuesta) {
                            modelos_json.push(mod_i);
                        };

                    if (pagina <= 1) contenedor.html(model.mostrar_modelos(respuesta));
                    else contenedor.append(model.mostrar_modelos(respuesta));
                    /**
                     * Validación de más paginacion
                     */
                    let paginar = true;
                    let pg = response.pagination; //Paginacion
                    let limite = (pg.page * pg.limit);
                    if (limite > pg.total) paginar = false;

                    if (!paginar) button.parent().hide();

                    button.off().on('click', function () {
                        let button = $(this);
                        button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                        button.off();
                        setTimeout(() => {
                            traer_modelos(pagina + 1, buscar, modelos_json);
                        }, 500);
                    });
                    // añadir cuando se encuentra solo un resultado
                    if (response.data.length == 1) {
                        const STORE = new Storage();
                        const MODEL = new Modelos();

                        let cliente = STORE.mostrar_cliente();

                        let new_model = response.data[0];
                        let menudeo = true;

                        if (cliente) menudeo = cliente.tipo_cliente && cliente.tipo_cliente == 'mayorista' ? false : true;
                        new_model['cantidad'] = 1;
                        new_model['precio'] = menudeo ? new_model['precio_menudeo_iva'] : new_model['precio_mayoreo_iva'];
                        $.notify({
                            icon: 'fas fa-exclamation-circle',
                            title: `Se agrego 1 ${new_model.nombre}`,
                            message: `Continua agregando más productos a la nota.`,
                        }, {
                            type: 'success',
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            time: 500,
                        });
                        STORE.agregar_modelos(new_model);
                        const new_modelos_search = STORE.mostrar_lista();
                        MODEL.mostrar_contenido($("#tabla_nota"), new_modelos_search);
                        $("#form_search_almacen").find("[name=buscador]").val("");
                    }


                    $(".select_model").on('click', function (e) {
                        e.preventDefault();
                        let modelo = $(this);
                        let id_model = (modelo.attr('model-id'));
                        Swal.fire({
                            title: 'Cantidad',
                            input: 'number',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Agregar',
                            showLoaderOnConfirm: true,
                        }).then((result) => {
                            if (result.value) {
                                const MODEL = new Modelos();
                                const STORE = new Storage();

                                let new_model = false; //Aquí se guarda el modelo nuevo que se va a añadir

                                let menudeo = true;
                                let cliente = STORE.mostrar_cliente();

                                if (cliente) {
                                    menudeo = cliente.tipo_cliente && cliente.tipo_cliente == 'mayorista' ? false : true;
                                }



                                for (const model_search of modelos_json) {
                                    if (model_search.id_modelo_viejo == id_model) {
                                        new_model = model_search;
                                        new_model;
                                        new_model['cantidad'] = result.value;
                                        new_model['precio'] = menudeo ? model_search['precio_menudeo_iva'] : model_search['precio_mayoreo_iva'];
                                    }
                                }
                                if (new_model) {
                                    // let lista = (STORE.mostrar_lista());
                                    // let modelos = (lista ? lista : []);
                                    // modelos.push(new_model);
                                    STORE.agregar_modelos(new_model); //Agrega el nuevo modelo con la cantidad especifica

                                    const new_modelos_search = STORE.mostrar_lista();
                                    // STORE.enviar_lista(JSON.stringify(modelos));
                                    /**
                                     * CARGA DE TABLA Y METODO DE ELIMINACION
                                     */
                                    MODEL.mostrar_contenido($("#tabla_nota"), new_modelos_search);
                                    $.notify({
                                        icon: 'fas fa-exclamation-circle',
                                        title: 'Los datos se agregaron correctamente',
                                        message: `Continuar.`,
                                    }, {
                                        type: 'success',
                                        placement: {
                                            from: "top",
                                            align: "right"
                                        },
                                        time: 500,
                                    });
                                }

                            };
                        })
                    })

                } else {
                    button.parent().hide();
                    if (pagina == 1) contenedor.html(`<div class="col-12"><div class="card card-stats card-warning card-round"><div class="card-body"><div class="row justify-content-center"><div class="col-7 col-stats text-center"><div class="numbers"><p class="card-category">No se encontrarón resultados de tu busqueda</p><h4 class="card-title">Continua intentando, es probable que el modelo que estas buscando no exista</h4></div></div></div></div></div></div>`);

                }
                borrar_ac.off().on('click', function () {
                    borrar_ac.parent().hide();
                    button.parent().hide();
                    contenedor.html("");
                })
            }
        });
    }
});
class ModelosConstr {
    cuerpo_modelo(modelo) {
        const FUNC = new Funciones();

        return `<div class="card mb-1 c-pointer select_model" model-id=${modelo.id_modelo_viejo}>
            <div class="card-body p-1 ">
                <div class="d-flex ">
                    <div class="avatar avatar-offline">
                        <span class="avatar-title rounded-circle border border-white bg-default">+</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold my-0 py-0 lh-2">Nombre: <span class="text-muted">${modelo.nombre}</span></h6>
                        <p class="my-0 py-0 lh-1"><b>COLOR:</b><span class="text-muted"> ${modelo.color}, </span> <b>TALLA:</b><span class="text-muted"> ${modelo.talla}</span> <b>TIPO:</b><span class="text-muted"> ${modelo.tipo} <b>STOCK:</b><span class="text-muted"> ${modelo.stock} </span></p>
                        <p class="my-0 py-0 lh-1"></span></p>
                        <p class="my-0 py-0 lh-1"></p>
                        <table class="table table-light">
                            <tbody>
                                <tr class="no_p">
                                    <td class="no_p">Menudeo</td>
                                    <td class="no_p">Mayoreo</td>
                                </tr>
                                <tr class="no_p">
                                    <td class="no_p">$ ${FUNC.number_format(modelo.precio_menudeo, 2)}</td>
                                    <td class="no_p">$ ${FUNC.number_format(modelo.precio_mayoreo, 2)}</td>
                                </tr>
                                <tr class="no_p">
                                    <td class="no_p">$ ${FUNC.number_format(modelo.precio_menudeo_iva, 2)} IVA</td>
                                    <td class="no_p">$ ${FUNC.number_format(modelo.precio_mayoreo_iva, 2)} IVA</td>
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
            cuerpo += `<div class="col-md-6 col-12">${this.cuerpo_modelo(modelo)}</div>`;
        }
        return cuerpo;
    }
}