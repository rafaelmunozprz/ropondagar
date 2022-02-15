$(document).ready(function () {
    $("#form_search_usuarios").submit(function (e) {
        e.preventDefault();
        let search_model = $(this).find("[name=search]").val();
        setTimeout(() => {
            traer_usuarios(1, search_model);
        }, 500);
    });
    traer_usuarios();


});
function traer_usuarios(pagina = 1, buscar = "") {
    let contenedor = $("#contenedor_usuarios");
    let button = $("#paginacion a");

    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`).parent().show();

    $.ajax({
        type: "POST",
        url: RUTA + "back/usuarios",
        data: `opcion=mostrar_usuarios&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) { console.log(xhr.responseText); },
        success: function (data) {
            console.log(data);
            if (data.response == 'success') {
                let cuerpo = "";
                const USERS = new Usuarios();
                const datos = data.data;

                if (pagina <= 1) contenedor.html(USERS.mostrar_usuarios(datos));
                else contenedor.append(USERS.mostrar_usuarios(datos));
                /**
                 * Validación de más paginacion
                 */
                let paginar = true;
                let pg = data.pagination; //Paginacion
                let limite = (pg.page * pg.limit);
                if (limite > pg.total) paginar = false;

                if (!paginar) button.parent().hide();

                button.off().on('click', function () {
                    let button = $(this);
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                    button.off();
                    setTimeout(() => {
                        traer_usuarios(pagina + 1, buscar);
                    }, 500);
                });
                $(".toggle_user").off().on('click', function () { $(this).children('.toggle_data').toggle('top'); });

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
                                            <h4 class="card-title">Continua intentando, es probable que el usuario que estas buscando no exista</h4>
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

class Usuarios {
    mostrar_usuarios(usuarios) {
        let cuerpo = "";
        for (const usuario of usuarios) {
            cuerpo += `<div class="col-xl-4 col-lg-6  col-md-6 col-12 mx-auto toggle_user my-2">${this.cuerpo_usuario(usuario)}</div>`;
        }
        return cuerpo;
    }
    cuerpo_usuario(usuario) {
        let cuerpo = "";
        let direccion = "";
        cuerpo = `
            <div class="toggle_card">
                <div class="list-group list-group-flush z-depth-1 rounded">
                    <div class="list-group-item card_encabezado">
                        <img src="${RUTA}${usuario.imagen}" class="rounded-circle z-depth-0 w-25 h-25" alt="Ropon dagar Avatar's">
                        <div class="d-flex flex-column pl-3 w-md-75 w-100">
                            <p class="font-weight-normal mb-0">${usuario.nombre} ${usuario.apellidos}</p>
                            <p class="small mb-0"><b class="mr-4">Cargo: ${usuario.cargo}</b> Nickname: ${usuario.nombre_usuario}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="toggle_data off">
                <a href="${RUTA}sistema/usuarios/${usuario.id_usuario}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">CUENTA</a>
                <a href="${RUTA}sistema/usuarios/${usuario.id_usuario}/tareas" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">TAREAS
                    <span class="badge badge-warning badge-pill">0</span>
                </a>
                <a href="${RUTA}sistema/usuarios/${usuario.id_usuario}/trabajos" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">TAREAS FINALIZADAS
                    <span class="badge badge-success badge-pill">0</span>
                </a>
                <a href="${RUTA}sistema/usuarios/${usuario.id_usuario}/groups" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">GRUPOS ASIGNADOS
                    <span class="badge badge-danger badge-pill">0</span>
                </a>
            </div>`;
        return cuerpo;
    }
}