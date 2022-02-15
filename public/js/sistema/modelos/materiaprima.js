$(document).ready(function () {
    $("#form_search_materiaprima").find("[name=buscador]").val("");
    $("#contenedor_materia").html("");
    $("#form_search_materiaprima").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_model = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_materias(1, search_model, false, $("#modal_editar_modelo"));
        }, 500);
    });
});

function remove_materiaprima() {
    $(".remove_materiaprima").off().click(function (e) {
        e.preventDefault();
        let id_materia_prima = $(this).parent().parent().attr('data-id_materia_prima');
        const mat = new Materias();
        const STORE = new Materia_store();
        let materia_body = $("#body_materiaprima_table");
        STORE.remove_materia_modelo(id_materia_prima);

        let materiales = STORE.get_materia_modelo(); //Busca en el storage lo restante
        if (!materiales) materiales = []; //Manda un arreglo para que el foreach haga lo suyito
        materia_body.html(mat.table_materias(materiales));
        remove_materiaprima();
    });
}

function traer_materias(pagina = 1, buscar = "", materias_json = false, modal) {
    let contenedor = $("#contenedor_materia");
    let button = $("#paginacion_materia");
    let borrar_ac = $("#borrar_busqueda_materiaprima");
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
                        traer_materias(pagina + 1, buscar, materias_json, modal);
                    }, 500);
                });

                $(".agregar_materia_prima").on('click', function () {
                    let materia_prima = $(this);
                    modal.modal('hide');
                    Swal.fire({
                        title: 'Cantidad',
                        input: 'text',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Agregar',
                        showLoaderOnConfirm: true,
                    }).then((result) => {
                        modal.modal('show');
                        if (result.value) {
                            let materia_id = (materia_prima.attr("materia-id"));
                            let material = {
                                cantidad: result.value,
                                id_materia_prima: materia_id,
                                materia_prima: ""
                            };
                            const mat = new Materias();
                            let materia_body = $("#body_materiaprima_table");

                            for (const materia_j of materias_json) {
                                if (materia_j.id_materia_prima == materia_id) material.materia_prima = materia_j;
                            }
                            const STORE = new Materia_store();

                            STORE.remove_materia_modelo(materia_id);
                            let materiales = STORE.get_materia_modelo();

                            if (!materiales) materiales = [material];
                            else materiales.push(material);
                            STORE.set_materia_modelo(JSON.stringify(materiales));

                            materia_body.html(mat.table_materias(materiales));
                            remove_materiaprima()
                        }
                    });
                });
            } else {
                button.parent().hide();
                if (pagina == 1) {
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
        }
    });
}

class Materias {
    cuerpo_materia(materia) {
        return `
            <div class="card p-1 mb-2">
                <div class="card-body c-pointer  p-1 agregar_materia_prima" materia-id="${materia.id_materia_prima}">
                    <div class="d-flex ">
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
    cuerpo_materia_min(materia) {
        return `
            <div class="d-flex ">
                <div class="flex-1 ml-3 pt-1">
                    <span class="text-uppercase fw-bold mb-1">Materia: <span class="text-muted ">${materia.nombre} </span> <b class="ml-3">categoria</b>: ${materia.categoria}</span>
                    <p class="my-0 py-0 lh-1">Código:<span class="text-muted">  ${materia.codigo}</span></p>
                    <p class="my-0 py-0 lh-1">Medida por materia:<span class="text-muted"> ${materia.medida} ${materia.unidad_medida}</span></p>
                    <p class="my-0 py-0 lh-1">Color:<span class="text-muted"> ${materia.color}</span></p>
                </div>
            </div>`;
    }
    mostrar_materias(materias) {
        let cuerpo = '';
        for (const materia of materias) {
            cuerpo += `<div class=" col-12 px-1">${this.cuerpo_materia(materia)}</div>`;
        }
        return cuerpo;
    }
    table_materias(materias) {
        let cuerpo = '';
        for (const materia of materias) {
            cuerpo += `
                <tr data-id_materia_prima="${materia.id_materia_prima}">
                    <td class="no_p"> <a class="btn btn-icon btn-info text-white btn-round btn-xs py-1">${materia.cantidad}</a></td>
                    <td class="no_p text-justify">${this.cuerpo_materia_min(materia.materia_prima)} </td>
                    <td class="no_p"> <a class="btn btn-icon btn-warning btn-round btn-xs py-1 remove_materiaprima"><i class="fas fa-trash"></i></a></td>
                </tr>`;
        }
        return cuerpo;
    }

}