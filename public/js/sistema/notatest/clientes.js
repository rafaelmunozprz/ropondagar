$(document).ready(function () {

    $("#config_nota_cliente").on('click', function () {
        $(".show_form_cliente").off().click(function (e) {
            e.preventDefault();
            let contenedor = $("#formulario_clientes");
            contenedor.find(".contenedor_form").toggle('show');
            contenedor.find(".contenedor_titulos").children('h2').toggle('show');
            contenedor.find(".contenedor_titulos").children('a').toggle('show');
        });

        const MODEL = new Modelos();
        const STORE = new Storage();


        let modal = $("#modal_config_cliente");
        let form = $("#form_config_cliente");
        modal.modal('show');
        let cliente_datos = false;
        if (cliente_datos = STORE.mostrar_cliente()) {
            let dir = (cliente_datos.direccion) ? cliente_datos.direccion[0] : false;
            form.find('[name="fecha"]').val(cliente_datos['fecha']);
            form.find('[name="nombre"]').val(cliente_datos['razon_social']);
            form.find('[name="direccion"]').val((dir ? dir.direccion : ""));
            form.find('[name="ciudad"]').val((dir ? dir.ciudad : ""));
            $("#numero").val(cliente_datos['numero']);
            form.find('[name="correo"]').val(cliente_datos['correo']);
        }
        $("#guardar_cliente").off().on('click', function () {

            form = $("#form_config_cliente");
            let fecha = form.find('[name="fecha"]').val();
            let nombre = form.find('[name="nombre"]').val();
            let direccion = form.find('[name="direccion"]').val();
            let ciudad = form.find('[name="ciudad"]').val();
            let numero = $("#numero").val();
            let correo = form.find('[name="correo"]').val();

            var date = $("#fecha_actual").val();
            let date_new = (fecha != "" ? fecha : date);
            cliente_datos = STORE.mostrar_cliente();//Buscar denuevo
            if (cliente_datos) {
                cliente_datos['id_cliente'] = false;
                cliente_datos['numero'] = numero;
                cliente_datos['razon_social'] = nombre;
                cliente_datos['direccion'] = [
                    {
                        'direccion': direccion,
                        'numero_externo': cliente_datos.direccion[0]['numero_externo'],
                        'numero_interno': cliente_datos.direccion[0]['numero_interno'],
                        'colonia': cliente_datos.direccion[0]['colonia'],
                        'ciudad': ciudad,
                        'estado': cliente_datos.direccion[0]['estado'],
                    }];
                cliente_datos['correo'] = correo;
                cliente_datos['fecha'] = date_new;
            } else {
                cliente_datos = {
                    'id_cliente': false,
                    'numero': numero,
                    'razon_social': nombre,
                    'direccion': [{
                        direccion: direccion,
                        numero_externo: '',
                        numero_interno: "",
                        cp: "",
                        colonia: "",
                        ciudad: ciudad,
                        estado: ""
                    }],
                    'correo': correo,
                    'fecha': date_new,
                    'tipo_cliente': 'publico',
                };
            }
            STORE.guardar_cliente(JSON.stringify(cliente_datos));//Guarda el cliente en temporal

            MODEL.cliente_body($("#config_nota_cliente"), cliente_datos);//Muestra los datos

            modal.modal('hide');
        });
        $("#limpiar_cliente").off().on('click', function () {
            let form = $("#form_config_cliente");
            form.find('[name="fecha"]').val("");
            form.find('[name="nombre"]').val("");
            form.find('[name="direccion"]').val("");
            form.find('[name="ciudad"]').val("");
            form.find('[name="correo"]').val("");
            STORE.borrar_cliente();
            MODEL.cliente_body($("#config_nota_cliente"));
        });
        $("#form_search_clientes").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let search_model = form.find("[name=buscador]").val();
            setTimeout(() => {
                traer_clientes(1, search_model);
            }, 500);
        });
    });

    // traer_clientes();
    function traer_clientes(pagina = 1, buscar = "", clientes_json = false) {
        let button = $("#paginacion .cliente");
        let contenedor = $("#contenedor_clientes");
        let borrar_ac = $("#borrar_busqueda");
        borrar_ac.parent().show();
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

                            traer_clientes(pagina + 1, buscar, clientes_json);
                        }, 500);
                    });

                    $(".select_cliente").on('click', function (e) {
                        e.preventDefault();
                        let cliente = $(this);
                        let id_cliente = (cliente.attr('cliente-id'));
                        const MODEL = new Modelos();
                        const STORE = new Storage();

                        let new_cliente = false;
                        var date = $("#fecha_actual").val();
                        // let date_new = (fecha != "" ? fecha : date);

                        for (const model_search of clientes_json) {
                            if (model_search.id_cliente == id_cliente) {
                                new_cliente = model_search; new_cliente;
                                new_cliente['fecha'] = date;
                                new_cliente['numero'] = $("#numero").val();
                                // new_cliente['precio'] = menudeo ? model_search['precio_menudeo_iva'] : model_search['precio_mayoreo_iva'];
                            }
                        }
                        if (new_cliente) {
                            STORE.guardar_cliente(JSON.stringify(new_cliente));//Guarda el cliente en temporal

                            MODEL.cliente_body($("#config_nota_cliente"), new_cliente);//Muestra los datos
                            $("#modal_config_cliente").modal('hide');

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
                    })

                } else {
                    button.parent().hide();
                    if (pagina == 1) contenedor.html(`<div class="col-12"><div class="card card-stats card-warning card-round"><div class="card-body"><div class="row justify-content-center"><div class="col-7 col-stats text-center"><div class="numbers"><p class="card-category">No se encontrarón resultados de tu busqueda</p><h4 class="card-title">Continua intentando, es probable que el cliente que estas buscando no exista</h4></div></div></div></div></div></div>`);

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


class Clientes {
    cuerpo_cliente(cliente) {
        let dir = (cliente.direccion) ? cliente.direccion[0] : false;
        return `<div class="card p-1">
            <div class="card-body c-pointer select_cliente p-1" cliente-id=${cliente.id_cliente}>
                <div class="d-flex ">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-info">R</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${cliente.razon_social}</span></h6>
                        <p class="my-0 py-0 lh-1">Dirección:<span class="text-muted"> ${dir ? dir.direccion : ""} #${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}</span></p>
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

