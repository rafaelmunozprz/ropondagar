$(document).ready(function () {
    traer_proveedores();
    $("#form_search_proveedores").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_model = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_proveedores(1, search_model);
        }, 500);
    });
    function traer_proveedores(pagina = 1, buscar = "", proveedores_json = false) {
        let button = $("#paginacion");
        let contenedor = $("#contenedor_proveedores");
        let borrar_ac = $("#borrar_busqueda");
        borrar_ac.parent().show();
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
        $.ajax({
            type: "POST",
            url: RUTA + "back/proveedores",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                button.parent().hide();
            },
            success: function (response) {
                if (response.response == 'success') {
                    const client = new Proveedores();
                    const respuesta = response.data;//Datos que llegan desde la API

                    button.parent().show();
                    if (!proveedores_json) proveedores_json = respuesta;
                    else for (const mod_i of respuesta) { proveedores_json.push(mod_i); };

                    if (pagina <= 1) contenedor.html(client.mostrar_proveedores(respuesta));
                    else contenedor.append(client.mostrar_proveedores(respuesta));
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
                            traer_proveedores(pagina + 1, buscar, proveedores_json);
                        }, 500);
                    });
                    $(".select_proveedor").click(function (e) {
                        e.preventDefault();
                        let proveedor = $(this).attr("proveedor-id");
                        // window.open(RUTA+"sistema/proveedores/"+proveedor);
                        window.location.href = RUTA + "sistema/proveedores/" + proveedor; //Will take you to Google.
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
                                                <h4 class="card-title">Continua intentando, es probable que el proveedor que estas buscando no exista</h4>
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
                })
            }
        });
    }
});


class Proveedores {
    cuerpo_proveedor(proveedor) {
        let dir = (proveedor.direccion) ? proveedor.direccion[0] : false;
        return `<div class="card p-1 mb-2">
            <div class="card-body c-pointer  p-1" >
                <div class="d-flex ">
                    <div class="avatar avatar-online select_proveedor" proveedor-id="${proveedor.id_proveedor}">
                        <span class="avatar-title rounded-circle border border-white bg-primary">${proveedor.razon_social[0]}</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${proveedor.razon_social}</span></h6>
                        <p class="my-0 py-0 lh-1">Dirección:<span class="text-muted"> ${dir ? dir.direccion : ""} #${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}</span></p>
                        <p class="my-0 py-0 lh-1">Tipo de Persona:<span class="text-muted"> ${proveedor.tipo_persona}</span></p>
                        <p class="my-0 py-0 lh-1">RFC:<span class="text-muted"> ${proveedor.rfc}</span></p>
                        <p class="my-0 py-0 lh-1">Télefono:<span class="text-muted"> ${proveedor.telefono}</span></p>
                        <p class="my-0 py-0 lh-1">Correo:<span class="text-muted"> ${proveedor.correo}</span></p>
                    </div>
                </div>
            </div>
        </div>`;
    }
    mostrar_proveedores(proveedores) {
        let cuerpo = '';
        for (const proveedor of proveedores) {
            cuerpo += `<div class="col-12">${this.cuerpo_proveedor(proveedor)}</div>`;
        }
        return cuerpo;
    }
}

