$(document).ready(function () {
    traer_materias();
    $("#form_search_materias").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_model = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_materias(1, search_model);
        }, 500);
    });
});

/**
 * 
 * @param {Number} pagina numero de la pagina usada para paginación 
 * @param {String} buscar nombre de la materia buscada
 * @param {JSON} materias_json objeto con toda la búsqueda de materia prima
 */
function traer_materias(pagina = 1, buscar = "", materias_json = false) {
    let button = $("#paginacion");
    let contenedor = $("#contenedor_materias");
    let borrar_ac = $("#borrar_busqueda");
    borrar_ac.parent().show();
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
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

                button.off().on('click', function () {
                    let button = $(this);
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                    button.off();
                    setTimeout(() => {
                        traer_materias(pagina + 1, buscar, materias_json);
                    }, 500);
                });

                $(".materiaprima").off().on('click', function () {
                    let materia_sel = $(this);
                    editar_materia_prima(materia_sel.attr("data-idmateria"));
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
                                            <p class="card-category">No se encontrarón resultados de tu busqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que el materia que estas buscando no exista</h4>
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