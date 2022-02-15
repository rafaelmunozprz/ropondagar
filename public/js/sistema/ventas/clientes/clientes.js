$(document).ready(function () {
    traer_clientes();
    $("#form_search_clientes").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_model = form.find("[name=buscador]").val();
        setTimeout(() => {
            traer_clientes(1, search_model);
        }, 500);
    });
    function traer_clientes(pagina = 1, buscar = "", clientes_json = false) {
        let button = $("#paginacion_cliente");
        let contenedor = $("#contenedor_clientes");
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
        $.ajax({
            type: "POST",
            url: RUTA + "back/cliente",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                button.parent().hide();
            },
            success: function (response) {
                if (response.response == 'success') {
                    const client = new Clientes();
                    const respuesta = response.data;//Datos que llegan desde la API

                    button.parent().show();
                    if (!clientes_json) clientes_json = respuesta;
                    else for (const mod_i of respuesta) { clientes_json.push(mod_i); };

                    if (pagina <= 1) contenedor.html(client.mostrar_clientes(respuesta));
                    else contenedor.append(client.mostrar_clientes(respuesta));
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
                            traer_clientes(pagina + 1, buscar, clientes_json);
                        }, 500);
                    });
                    $(".select_cliente").click(function (e) {
                        e.preventDefault();
                        let id_cliente = $(this).attr("cliente-id");
                        let cliente_b = false;
                        for (const cliente of clientes_json) {
                            if (cliente.id_cliente == id_cliente) cliente_b = cliente;
                        }
                        if (cliente_b) {
                            const STOR = new Storage('venta_notas');
                            let nota = STOR.mostrar_nota();
                            nota.usuario.id = cliente_b.id_cliente;
                            nota.usuario.data = cliente_b;
                            nota.usuario.tipo = "cliente";
                            STOR.guardar_nota(JSON.stringify(nota));
                            traer_nota();
                            $("#modal_config_cliente").modal('hide');

                            toastr["success"]("El cliente fue actualizado de forma correcta")
                        } else {
                            toastr["error"]("Fue imposible actualizar el cliente")
                        }

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
                                                <h4 class="card-title">Continua intentando, es probable que el cliente que estas buscando no exista</h4>
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


class Clientes {
    cuerpo_cliente(cliente) {
        let dir = (cliente.direccion) ? cliente.direccion[0] : false;
        return `<div class="card p-1 mb-2">
            <div class="card-body c-pointer p-1 select_cliente" cliente-id="${cliente.id_cliente}" >
                <div class="d-flex ">
                    <div class="avatar avatar-${cliente.estado == 'activo' ? "online" : 'offline'}">
                        <span class="avatar-title rounded-circle border border-white bg-primary">${cliente.razon_social[0]}</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${cliente.razon_social}</span></h6>
                        <p class="my-0 py-0 lh-1">Dirección:<span class="text-muted"> ${dir ? dir.direccion : ""} #${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}</span></p>
                        <p class="my-0 py-0 lh-1">Tipo de Persona:<span class="text-muted"> ${cliente.tipo_persona}</span></p>
                        <p class="my-0 py-0 lh-1">Tipo de Cliente:<span class="text-muted"> ${cliente.tipo_cliente}</span></p>
                        <p class="my-0 py-0 lh-1">RFC:<span class="text-muted"> ${cliente.rfc}</span></p>
                        <p class="my-0 py-0 lh-1">Télefono:<span class="text-muted"> ${cliente.telefono}</span></p>
                        <p class="my-0 py-0 lh-1">Correo:<span class="text-muted"> ${cliente.correo}</span></p>
                    </div>
                </div>
            </div>
        </div>`;
    }
    mostrar_clientes(clientes) {
        let cuerpo = '';
        for (const cliente of clientes) {
            cuerpo += `<div class="col-12">${this.cuerpo_cliente(cliente)}</div>`;
        }
        return cuerpo;
    }
}

