
$(document).ready(function () {
    /**
     * @ js/sistema/materiaprima/model_materia.js
     * este archivo contiene la clase de la vista de la materia prima
     * class Materias
     */
    // const load = "";
    // const text = "";
    // var button = $("#form_search_almacen").find('button');
    $(".hide_cont_nota").on('click', function () {
        $(".venta-h").hide();//Oculta el contenido de resultado de busquedas
    });


    let btn_search = '<i class="fas fa-search"></i>';
    let btn_qrcode = '<i class="fas fa-qrcode"></i>';
    let advance_active = false;
    $("#search_advance").on('click', function () {
        let button = $(this);
        if (!advance_active) {
            button.html(btn_search).removeClass('btn-dark').addClass('btn-default').addClass('btn-border');
            advance_active = true;
        } else {
            button.html(btn_qrcode).removeClass('btn-default').removeClass('btn-border').addClass('btn-dark');
            advance_active = false;
        }
    });

    $("#form_search_almacen").submit(function (e) {
        e.preventDefault();
        let consulta = $("#form_search_almacen").find("[name=buscador]").val();
        if (!advance_active) consulta = `&codigo=${consulta}`;
        mostrar_modelos(1, consulta);
    });//Evita un recargo por submit

    /**Funcionalidad en la funcion jeje |_o_o_| */
    function mostrar_modelos(pagina = 1, buscar = "", modelos_json = false) {
        traer_modelos_stock(pagina, buscar).
            then((response) => {
                let button = $("#paginacion_inv");
                let contenedor = $("#contenedor_inventario");
                button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);

                if (response.response == 'success') {
                    const modelos = new Modelos();
                    const respuesta = response.data; //Datos que llegan desde la API

                    button.parent().show();
                    if (!modelos_json) modelos_json = respuesta;
                    else
                        for (const mod_i of respuesta) {
                            modelos_json.push(mod_i);
                        };

                    if (pagina <= 1) contenedor.html(modelos.mostrar_modelos(respuesta));
                    else contenedor.append(modelos.mostrar_modelos(respuesta));
                    /** Validación de más paginacion */
                    let paginar = true;
                    let pg = response.pagination; //Paginacion
                    let limite = (pg.page * pg.limit);
                    if (limite > pg.total) paginar = false;

                    if (!paginar) button.parent().hide();


                    $(".venta-h").show();//muestra el contenido de resultado de busquedas

                    button.off().on('click', function () {
                        let button = $(this);
                        button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                        button.off();
                        setTimeout(() => {
                            mostrar_modelos(pagina + 1, buscar, modelos_json);
                        }, 500);
                    });

                    $(".modelo_stock").off().on('click', function () {
                        let materia_sel = $(this);
                        let id_model = (materia_sel.attr("data-idmodelo"));
                        // editar_materia_prima(materia_sel.attr("data-idmateria"));
                        let new_model = false; //Aquí se guarda el materia nuevo que se va a añadir

                        for (const model_search of modelos_json) {
                            if (model_search.id_modelo == id_model) {
                                // console.log(model_search);
                                new_model = {
                                    "id": model_search.id_modelo,
                                    "tipo": "modelo",
                                    "nombre": model_search.codigo_completo + ", " +
                                        (model_search.color != 'N/A' && model_search.color != '' ? model_search.color : "") + " " +
                                        (model_search.sexo != 'N/A' && model_search.sexo != '' ? model_search.sexo : "") + ", " +
                                        (model_search.talla != 'N/A' && model_search.talla != '' ? model_search.talla : "") + ", " +
                                        (model_search.tipo != 'N/A' && model_search.tipo != '' ? model_search.tipo : ""),
                                    "precio_venta": false,
                                    "precio_menudeo": model_search.precio_menudeo,
                                    "precio_mayoreo": model_search.precio_mayoreo,
                                    "codigo": model_search.codigo,
                                    "cantidad": 1,
                                    "data": model_search
                                };
                            }
                        }
                        if (new_model) {
                            const STORE = new Storage('venta_notas');
                            let response = STORE.agregar_productos(new_model, 'modelo');
                            if (response.status) { //Agrega el nuevo materia con la cantidad especifica
                                $.notify({
                                    icon: 'fas fa-exclamation-circle', title: `Se agrego ${new_model.cantidad} ${new_model.nombre}`, message: `Continua agregando más productos a la nota.`,
                                }, {
                                    type: 'success', placement: { from: "top", align: "right" }, delay: 50,
                                });
                            } else {
                                toastr['error'](response.text)
                            }

                            if (modelos_json.length == 1 && !advance_active && (buscar != '' && buscar != '&codigo=')) {
                                $(".venta-h").hide();//muestra el contenido de resultado de busquedas
                            }
                            
                            traer_nota();
                        }
                    });

                    if (modelos_json.length == 1 && !advance_active && (buscar != '' && buscar != '&codigo=')) {
                        $($(".modelo_stock")[0]).click();
                        $("#form_search_almacen").find("[name=buscador]").val("");
                        $(".venta-h").hide();//oculta el contenido de resultado de busquedas
                    }


                } else {
                    $("#form_search_almacen").find("[name=buscador]").val("");
                    button.parent().hide();
                    if (pagina == 1) {
                        toastr['error'](response.text);
                        contenedor.html(`
                            <div class="col-12">
                                <div class="card card-stats card-warning card-round">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-7 col-stats text-center">
                                                <div class="numbers">
                                                    <p class="card-category">No se encontrarón resultados de tu busqueda</p>
                                                    <h4 class="card-title">Continua intentando, es probable que el materia que estas buscando no exista</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
                    }
                }
            });
    }
});


traer_modelos_stock();

async function traer_modelos_stock(pagina, buscar) {
    const datos = await $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}&stock=true`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            return false;
        },
        success: function (response) {
            // console.log(response);
            return response;
        }
    });
    return datos
}