$(document).ready(function () {

    $("#config_nota_proveedor").on('click', function () {
        $(".show_form_proveedor").off().click(function (e) {
            e.preventDefault();
            let contenedor = $("#formulario_proveedores");
            contenedor.find(".contenedor_form").toggle('show');
            contenedor.find(".contenedor_titulos").children('h2').toggle('show');
            contenedor.find(".contenedor_titulos").children('a').toggle('show');
        });

        const MODEL = new Materias();
        const STORE = new Storage('venta_proveedor');


        let modal = $("#modal_config_proveedor");

        modal.modal('show');

        $("#limpiar_proveedor").off().on('click', function () {
            let form = $("#form_config_proveedor");
            form.find('[name="fecha"]').val("");
            form.find('[name="nombre"]').val("");
            form.find('[name="direccion"]').val("");
            form.find('[name="ciudad"]').val("");
            form.find('[name="correo"]').val("");

            let nota = STORE.mostrar_nota();
            nota.usuario = {
                "id": false,
                "tipo": false, //empleado,proveedor,cliente
                "data": false, //Todos los datos del cliente
            };
            STORE.guardar_nota(JSON.stringify(nota));
            MODEL.proveedor_body($("#config_nota_proveedor"));
        });
        $("#form_search_proveedores").off().submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let search_model = form.find("[name=buscador]").val();
            setTimeout(() => {
                traer_proveedores(1, search_model);
            }, 500);
        });
    });

    // traer_proveedores();
    function traer_proveedores(pagina = 1, buscar = "", proveedores_json = false) {
        let button = $("#paginacion .proveedor");
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
                    const respuesta = response.data; //Datos que llegan desde la API

                    button.parent().show();
                    if (!proveedores_json) proveedores_json = respuesta;
                    else
                        for (const mod_i of respuesta) {
                            proveedores_json.push(mod_i);
                        };

                    if (pagina <= 1) contenedor.html(client.mostrar_proveedores(respuesta));
                    else contenedor.append(client.mostrar_proveedores(respuesta));
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

                            traer_proveedores(pagina + 1, buscar, proveedores_json);
                        }, 500);
                    });

                    $(".select_proveedor").on('click', function (e) {
                        e.preventDefault();
                        let proveedor = $(this);
                        let id_proveedor = (proveedor.attr('proveedor-id'));
                        const MODEL = new Materias();
                        const STORE = new Storage('venta_proveedor'); //Siempre tiene que recibir el storage almacenado

                        let new_proveedor = false;
                        var date = $("#fecha_actual").val();
                        // let date_new = (fecha != "" ? fecha : date);

                        for (const model_search of proveedores_json) {
                            if (model_search.id_proveedor == id_proveedor) {
                                new_proveedor = model_search;
                                new_proveedor;
                                new_proveedor['fecha'] = date;
                                new_proveedor['numero'] = $("#numero").val();
                            }
                        }
                        if (new_proveedor) {
                            let nota = STORE.mostrar_nota(); //Llama la guardada en el storage
                            /**Actualizar el json del proveedor */
                            nota.usuario.data = new_proveedor;
                            nota.usuario.id = new_proveedor.id_proveedor;
                            nota.usuario.tipo = 'proveedor';
                            nota.fecha = date;

                            STORE.guardar_nota(JSON.stringify(nota)); //Guarda el proveedor en temporal

                            MODEL.proveedor_body($("#config_nota_proveedor"), new_proveedor); //Muestra los datos
                            $("#modal_config_proveedor").modal('hide');

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
                    if (pagina == 1) contenedor.html(`<div class="col-12"><div class="card card-stats card-warning card-round"><div class="card-body"><div class="row justify-content-center"><div class="col-7 col-stats text-center"><div class="numbers"><p class="card-category">No se encontrarón resultados de tu busqueda</p><h4 class="card-title">Continua intentando, es probable que el proveedor que estas buscando no exista</h4></div></div></div></div></div></div>`);

                }
                borrar_ac.off().on('click', function () {
                    borrar_ac.parent().hide();
                    button.parent().hide();
                    contenedor.html("");
                });
            }
        });
    }
});


class Proveedores {
    cuerpo_proveedor(proveedor) {
        let dir = (proveedor.direccion) ? proveedor.direccion[0] : false;
        return `<div class="card p-1">
            <div class="card-body c-pointer select_proveedor p-1" proveedor-id=${proveedor.id_proveedor}>
                <div class="d-flex ">
                    <div class="avatar">
                        <span class="avatar-title rounded-circle border border-white bg-primary">${(proveedor.razon_social)[0]}</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${proveedor.razon_social}</span></h6>
                        <p class="my-0 py-0 lh-1">Dirección:<span class="text-muted"> ${dir ? dir.direccion : ""} #${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}</span></p>
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