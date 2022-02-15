$(document).ready(function () {
    $("#form_search_almacen").submit(function (e) {
        e.preventDefault();
        // let form = $(this);
        // let search_model = form.find("[name=buscador]").val();
        // setTimeout(() => {
        //     traer_materias(1, search_model);
        // }, 500);
    });


    $("#form_search_almacen").find("[name=buscador]").keyup(delay(function (e) {
        let consulta = $(this).val();
        traer_materias(1, consulta);
    }, 1000));

    function delay(fn, ms) {
        let timer = 0
        return function (...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }


    function traer_materias(pagina = 1, buscar = "", materias_json = false) {
        let button = $("#paginacion a");
        let contenedor = $("#contenedor_materias");
        let borrar_ac = $("#borrar_busqueda");
        borrar_ac.parent().show();
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);

        let button_search = $("#form_search_almacen").find("button");
        button_search.html('<div class="spinner-border" role="status"><span class="sr-only"> </span></div > ');
        $.ajax({
            type: "POST",
            url: RUTA + "back/materiaprima",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                button.parent().hide();
            },
            success: function (response) {
                if (response.response == 'success') {
                    const model = new MateriasConstr();
                    const respuesta = response.data; //Datos que llegan desde la API

                    button.parent().show();
                    if (!materias_json) materias_json = respuesta;
                    else
                        for (const mod_i of respuesta) {
                            materias_json.push(mod_i);
                        };

                    if (pagina <= 1) contenedor.html(model.mostrar_materias(respuesta));
                    else contenedor.append(model.mostrar_materias(respuesta));

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
                            traer_materias(pagina + 1, buscar, materias_json);
                        }, 500);
                    });
                    if (response.data.length == 1) {
                        const STORE = new Storage('venta_proveedor');
                        const MODEL = new Materias();
                        let modelo_codigo = response.data[0]; // Cuando solo existe un resultado

                        let new_materia = {
                            "id": modelo_codigo.id_materia_prima,
                            "tipo": "materia_prima",
                            "nombre": modelo_codigo.nombre + ", " + modelo_codigo.medida + " " + modelo_codigo.unidad_medida + ", " + modelo_codigo.color,
                            "precio_compra": false,
                            "precio_menudeo": false,
                            "precio_mayoreo": false,
                            "codigo": "",
                            "cantidad": 1,
                            "data": modelo_codigo
                        };

                        $.notify({
                            icon: 'fas fa-exclamation-circle',
                            title: `Se agrego 1 ${new_materia.nombre}`,
                            message: `Continua agregando más productos a la nota.`,
                        }, {
                            type: 'success', placement: { from: "top", align: "right" }, time: 500,
                        });

                        STORE.agregar_productos(new_materia, 'materia_prima'); //Agrega el nuevo materia con la cantidad especifica

                        let nota = STORE.mostrar_nota();

                        MODEL.proveedor_body($("#config_nota_proveedor"), nota.usuario.data); //Muestra los datos
                        MODEL.mostrar_contenido($("#tabla_nota"), nota);

                        $("#form_search_almacen").find("[name=buscador]").val("");
                    }


                    $(".agregar_materia").on('click', function (e) {
                        e.preventDefault();
                        let materia = $(this);
                        let id_model = (materia.attr('materia-id'));

                        let new_materia = false; //Aquí se guarda el materia nuevo que se va a añadir
                        for (const model_search of materias_json) {
                            if (model_search.id_materia_prima == id_model) {
                                new_materia = {
                                    "id": model_search.id_materia_prima,
                                    "tipo": "materia_prima",
                                    "nombre": model_search.nombre + ", " + model_search.medida + " " + model_search.unidad_medida + ", " + model_search.color,
                                    "precio_compra": false,
                                    "precio_menudeo": false,
                                    "precio_mayoreo": false,
                                    "codigo": "",
                                    "cantidad": 1,
                                    "data": model_search
                                };
                            }
                        }
                        if (new_materia) {
                            const STORE = new Storage('venta_proveedor');
                            const MODEL = new Materias();
                            STORE.agregar_productos(new_materia, 'materia_prima'); //Agrega el nuevo materia con la cantidad especifica

                            let nota = STORE.mostrar_nota();
                            $.notify({
                                icon: 'fas fa-exclamation-circle', title: `Se agrego ${new_materia.cantidad} ${new_materia.nombre}`, message: `Continua agregando más productos a la nota.`,
                            }, {
                                type: 'success', placement: { from: "top", align: "right" }, time: 300,
                            });

                            MODEL.proveedor_body($("#config_nota_proveedor"), nota.usuario.data); //Muestra los datos
                            MODEL.mostrar_contenido($("#tabla_nota"), nota);
                        }

                    })

                } else {
                    button.parent().hide();
                    if (pagina == 1) contenedor.html(`<div class="col-12"><div class="card card-stats card-warning card-round"><div class="card-body"><div class="row justify-content-center"><div class="col-7 col-stats text-center"><div class="numbers"><p class="card-category">No se encontrarón resultados de tu busqueda</p><h4 class="card-title">Continua intentando, es probable que el materia que estas buscando no exista</h4></div></div></div></div></div></div>`);

                }
                button_search.html('<i class="fas fa-qrcode"></i>');

                borrar_ac.off().on('click', function () {
                    borrar_ac.parent().hide();
                    button.parent().hide();
                    contenedor.html("");
                })
            }
        });
    }
});
class MateriasConstr {
    cuerpo_materia(materia) {
        return `
            <div class="card p-1 mb-2">
                <div class="card-body c-pointer  p-1">
                    <div class="d-flex agregar_materia" materia-id="${materia.id_materia_prima}">
                        <div class="avatar" >
                            <span class="avatar-title rounded-circle border border-dark bg-dark">${materia.nombre[0]}</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <span class="text-uppercase fw-bold mb-1">Materia: <span class="text-muted ">${materia.nombre} </span> <b class="ml-3">categoria</b>: ${materia.categoria}</span>
                            <p class="my-0 py-0 lh-1">Código:<span class="text-muted">  ${materia.codigo}</span></p>
                            <p class="my-0 py-0 lh-1">Medida por materia:<span class="text-muted"> ${materia.medida} ${materia.unidad_medida}</span></p>
                            <p class="my-0 py-0 lh-1">Color:<span class="text-muted"> ${materia.color}</span></p>
                        </div>
                    </div>
                </div>
            </div>`;
    }
    mostrar_materias(materias) {
        let cuerpo = '';
        for (const materia of materias) {
            cuerpo += `<div class="col-md-6 col-12">${this.cuerpo_materia(materia)}</div>`;
        }
        return cuerpo;
    }
}