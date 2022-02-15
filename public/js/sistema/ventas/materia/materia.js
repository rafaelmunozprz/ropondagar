
$(document).ready(function () {
    /**
     * @ js/sistema/materiaprima/model_materia.js
     * este archivo contiene la clase de la vista de la materia prima
     * class Materias
     */

    let btn_search = '<i class="fas fa-search"></i>';
    let btn_qrcode = '<i class="fas fa-qrcode"></i>';

    let advance_active = false;
    eventos_busqueda(advance_active);

    $("#search_advance_mp").on('click', function () {
        let button = $(this);
        if (!advance_active) {
            button.html(btn_search).removeClass('btn-dark').addClass('btn-default').addClass('btn-border');
            advance_active = true;
        } else {
            button.html(btn_qrcode).removeClass('btn-default').removeClass('btn-border').addClass('btn-dark');
            advance_active = false;
        }
        eventos_busqueda(advance_active);
    });

    function eventos_busqueda(advance_busqueda) {
        $("#form_search_materiaprima").submit(function (e) { e.preventDefault(); });
        $("#form_search_materiaprima").find("[name=buscador]").off();
        if (advance_busqueda) {

            $("#form_search_materiaprima").submit(function (e) {
                e.preventDefault();
                let consulta = $("#form_search_materiaprima").find("[name=buscador]").val();
                // if (!advance_active) consulta = `&codigo=${consulta}`;
                mostrar_materia(1, consulta);
            });//Evita un recargo por submit

        } else {

            $("#form_search_materiaprima").find("[name=buscador]").keyup(function (event) {
                var regex = new RegExp("^[a-zA-Z0-9 ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key) && event.which != 13) {
                    event.preventDefault();
                    return false;
                }
                console.log(key);
                let consulta = $(this).val();
                consulta = `&codigo=${consulta}`;
                mostrar_materia(1, consulta);
            });

        }
    }

    // $("#form_search_materiaprima").submit(function (e) {
    //     e.preventDefault();
    //     let consulta = $("#form_search_materiaprima").find("[name=buscador]").val();
    //     if (!advance_active) consulta = `&codigo=${consulta}`;
    //     mostrar_materia(1, consulta);
    // });//Evita un recargo por submit

    /** Funcion para busqueda con tiempo de espera de 1 seg */
    // $("#form_search_materiaprima").find("[name=buscador]").keyup((e) => {
    //     let consulta = $(this).val();
    //     console.log(1);
    //     // mostrar_materia(1, consulta);
    // });
    // function delay(fn, ms) { let timer = 0; return function (...args) { clearTimeout(timer); timer = setTimeout(fn.bind(this, ...args), ms || 0); } };
    /** */


    // mostrar_materia();

    /**Funcionalidad en la funcion jeje |_o_o_| */
    function mostrar_materia(pagina = 1, buscar = "", materias_json = false) {
        trear_materia_prima(pagina, buscar).
            then((response) => {
                let button = $("#paginacion");
                let contenedor = $("#contenedor_materias");
                let borrar_ac = $("#borrar_busqueda");
                borrar_ac.parent().show();
                button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);

                if (response.response == 'success') {
                    const client = new Materias();
                    const respuesta = response.data; //Datos que llegan desde la API

                    button.parent().show();
                    if (!materias_json) materias_json = respuesta;
                    else
                        for (const mod_i of respuesta) {
                            materias_json.push(mod_i);
                        };

                    if (pagina <= 1) contenedor.html(client.mostrar_materias(respuesta));
                    else contenedor.append(client.mostrar_materias(respuesta));
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
                            mostrar_materia(pagina + 1, buscar, materias_json);
                        }, 500);
                    });

                    $(".materiaprima").off().on('click', function () {
                        let materia_sel = $(this);

                        let id_model = (materia_sel.attr("data-idmateria"));
                        let new_materia = false; //Aquí se guarda el materia nuevo que se va a añadir

                        for (const model_search of materias_json) {
                            if (model_search.id_materia_prima == id_model) {
                                new_materia = {
                                    "id": model_search.id_materia_prima,
                                    "tipo": "materia_prima",
                                    "nombre": model_search.nombre + ", " + model_search.medida + " " + model_search.unidad_medida + ", " + model_search.color,
                                    "precio_venta": false,
                                    "precio_menudeo": model_search.precio_menudeo,
                                    "precio_mayoreo": model_search.precio_mayoreo,
                                    "codigo": model_search.codigo,
                                    "cantidad": 1,
                                    "data": model_search
                                };
                            }
                        }
                        /**Si encontro la materia almacenar */
                        if (new_materia) {
                            const STORE = new Storage('venta_notas');
                            const MODEL = new Materias();
                            let response = STORE.agregar_productos(new_materia, 'materia_prima'); //Agrega el nuevo materia con la cantidad especifica

                            if (response.status) {
                                $.notify({
                                    icon: 'fas fa-exclamation-circle', title: `Se agrego ${new_materia.cantidad} ${new_materia.nombre}`, message: `Continua agregando más productos a la nota.`,
                                }, {
                                    type: 'success', placement: { from: "top", align: "right" }, delay: 50,
                                });
                            } else {
                                toastr['error'](response.text)
                            }

                            traer_nota();
                            // MODEL.proveedor_body($("#config_nota_proveedor"), nota.usuario.data); //Muestra los datos
                            // MODEL.mostrar_contenido($("#tabla_nota"), nota);
                        }
                    });
                    // Si el resultado == 1 agregará el articulo seleccionado
                    if (materias_json.length == 1 && !advance_active && (buscar != '' && buscar != '&codigo=')) {
                        $($(".materiaprima")[0]).click();
                        $("#form_search_materiaprima").find("[name=buscador]").val("");
                        $(".venta-h").hide();//muestra el contenido de resultado de busquedas
                    }

                } else {
                    button.parent().hide();
                    if (pagina == 1) {
                        toastr['error'](response.text)
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
                borrar_ac.off().on('click', function () {
                    borrar_ac.parent().hide();
                    button.parent().hide();
                    contenedor.html("");
                });
            });
    }
});




async function trear_materia_prima(pagina, buscar) {
    const datos = await $.ajax({
        type: "POST",
        url: RUTA + "back/materiaprima",
        data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}&stock=true`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            return false;
        },
        success: function (response) {
            return response;
        }
    });
    return datos
}