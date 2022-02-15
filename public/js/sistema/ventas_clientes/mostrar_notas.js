$(document).ready(function () {
    let estado = "";
    let filter = false; //Si esta activo, se ejecutara el filtro avanzado
    let id_cliente = $("#id_cliente").val();
    let filtro_avanzado = ""; // Este agregara más opcines de filtrado

    filtro_avanzado = (id_cliente != '' ? `&id_cliente=${id_cliente}` : ""); //Si se te ocurre algo concatenalo aquí

    $("#filtro_avanzado").on('click', function (e) {
        let button = $(this);
        button.toggle("down");
        $("#filter_content").toggle("down");
        filter = true;
    });
    $("#filter_cancel").on('click', function (e) {
        $("#filtro_avanzado").toggle("down");
        $("#filter_content").toggle("down");
        filter = false;
    });

    $(".check_estado").change(function (e) {
        e.preventDefault();
        let button = $(this); // Boton de estado
        let valor = button.val(); // Valor
        estado = `&estado=${valor}`; //Guardar filtro
        let padre = button.parent().parent();
        padre.removeClass('selectgroup-warning');
        padre.removeClass('selectgroup-success');

        //toogle representador
        let defaul_ = '<icontro class="fas fa-toggle-on"></i>';
        let success = '<i class="fas fa-toggle-on text-success"></i>';
        let warning = '<i class="fas fa-toggle-off text-warning"></i>';

        let icon_filter = $("#icon_filter");

        if (valor == 'pagado') {
            icon_filter.html(success);
            padre.addClass('selectgroup-success');
        }
        else {
            icon_filter.html(warning);
            padre.addClass('selectgroup-warning');
        }

    });

    $("#form_search_notas_p").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let qr_icon = '<i class="fas fa-qrcode"></i>';
        let loading = '<div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>';

        let search_model = form.find("[name=buscador]").val();

        let fecha_inicio = $("#fecha_inicio");
        let fecha_limite = $("#fecha_limite");

        let filtro = (fecha_inicio.val() ? `&fecha_inicio=${fecha_inicio.val()}` : "");
        filtro += (fecha_limite.val() ? `&fecha_limite=${fecha_limite.val()}` : "");
        filtro += estado; //Variable global esta en la linea 2 y hace funcion en la linea 16 a la 42
        filtro += filtro_avanzado; //Variable global esta en la linea 2 y hace funcion en la linea 16 a la 42

        search_model += (filter ? filtro : "");
        form.find(".qrcodecont").html(loading);
        setTimeout(() => {
            mostrar_notas(1, search_model);
            form.find(".qrcodecont").html(qr_icon);
        }, 500);
    });


    mostrar_notas(1, filtro_avanzado);

});
function mostrar_notas(pagina = 1, buscar = "", client = false, estado = false, nota_clientes = false) {
    let button = $("#paginacion_p").find('.notas_clientes');
    let contenedor = $("#contenedor_notas");
    let borrar_ac = $("#borrar_busqueda");
    let loading = `<span class="loading_control">Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></div>`;
    borrar_ac.parent().show();
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
    if (pagina <= 1) contenedor.html(loading);

    $.ajax({
        type: "POST",
        url: RUTA + "back/cliente/nota_venta",
        data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            $(".loading_control").remove();
            console.log(xhr.responseText);
            button.parent().hide();
            toastr['error']("Ocurrio un error al realizar la consulta");
        },
        success: function (response) {
            console.log(response);
            if (response.response == 'success') {
                const NOTE = new Notas_cont();
                const respuesta = response.data; //Datos que llegan desde la API

                button.parent().show();
                if (!nota_clientes) nota_clientes = respuesta;
                else
                    for (const mod_i of respuesta) {
                        nota_clientes.push(mod_i);
                    };

                if (pagina <= 1) contenedor.html(NOTE.mostrar_notas(respuesta));
                else contenedor.append(NOTE.mostrar_notas(respuesta));
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
                    button.html(loading);
                    button.off();
                    setTimeout(() => {
                        mostrar_notas(pagina + 1, buscar, client, estado, nota_clientes);
                    }, 500);
                });

                $(".accion_nota").off().on('click', function () {
                    let button_pago = $(this);
                    let accion = button_pago.attr('data-accion');
                    let id_nota = button_pago.parent().attr('data-id_nota');
                    let nota_p = false;

                    for (const nota of nota_clientes) {
                        if (nota.id_nota_cliente == id_nota) {
                            nota_p = nota;
                            break;
                        }
                    }
                    let FUNC = new Funciones();
                    if (accion == 'pago_nota') {
                        let modal = $("#modal_pagos");
                        modal.modal({ backdrop: 'static', keyboard: false });
                        modal.modal("show");
                        modal.find(".total_a_pagar").html(" $" + FUNC.number_format(nota_p.total_costo, 2));
                        modal.find(".total_a_pagar").append(`<br> Falta a pagar: ${(" $" + (FUNC.number_format((parseFloat(nota_p.total_costo) - parseFloat(nota_p.total_pagado)), 2)))}`);

                        $("#realizar_pago_nota").attr('id_nota', id_nota);

                    } else if (accion == 'impresion') {
                        let modal = $("#modal_impresion");
                        modal.attr('id_nota', id_nota);
                        modal.find(".impresion-contenido").html(`
                                <div class="row">
                                    <div class="col-12 my-3">
                                        <a target="_blank" href="${RUTA}sistema/ventas/pdf/facturapdf/${id_nota}" class="btn btn-primary btn-border btn-round  btn-block"> <span class="btn-label"> <i class="fas fa-file-pdf"></i></span>Print PDF</a>
                                    </div>
                                    <div class="col-12 my-3">
                                        <a target="_blank" href="${RUTA}sistema/ventas/pdf/ticketzpl/${id_nota}" class="btn btn-primary btn-border btn-round  btn-block" data-tipo="facturazpl"> <i class="fas fa-file-pdf ml-3"></i> Print Zebra</a>
                                    </div>
                                </div>`);

                        modal.modal({ backdrop: 'static', keyboard: false });
                        modal.modal("show");

                    } else if (accion == 'mas_opciones') {
                        let modal = $("#modal_opciones");
                        modal.attr('id_nota', id_nota);
                        modal.find(".opciones-contenido").html(`
                            <div class="row">

                                <div class="col-12 my-3">
                                    <a href="${RUTA}sistema/ventas/notas/${id_nota}">
                                    <div class="card card-dark bg-secondary-gradient c-pointer">
                                        <div class="card-body bubble-shadow">
                                            <h1>ADMINISTRAR</h1>
                                            <small>Configuraciones:</small><br>
                                            <h5 class="op mb-0">Actualizar inventario</h5>
                                            <h5 class="op my-0">Ordenar inventarios</h5>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-12 my-3">
                                    <a href="${RUTA}sistema/ventas/facturacion/${nota_p.id_nota_cliente}/${nota_p.uuid}" class="btn btn-dark btn-border btn-round  btn-block text-dark" > <i class="fas fa-clipboard-list mx-3"></i>Facturación</a>
                                </div>
                                <div class="col-12 my-3" data-id_nota="${id_nota}"> 
                                    <a id="send_mail" class="btn btn-dark btn-border btn-round  btn-block text-dark" > <i class="fas fa-paper-plane mx-3"></i>Enviar correo con el ticket</a>
                                </div>
                                <div class="col-12 my-3" data-id_nota="${id_nota}">
                                    <a id="delete_nota" class="btn btn-danger btn-border btn-round  btn-block text-dark" > <i class="fas fa-trash mx-3"></i>Eliminar nota</a>
                                </div>
                            </div>`);

                        modal.modal({ backdrop: 'static', keyboard: false });
                        modal.modal("show");
                        acciones_nota_view(modal, buscar);

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
function acciones_nota_view(modal, buscar) {
    $("#send_mail").on('click', function () {
        let button = $(this);
        let text = '<i class="fas fa-paper-plane mx-3"></i>Enviar correo con el ticket';
        let loading = 'Enviando ... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div> ';

        button.html(loading).attr("disabled", "disabled").addClass('disabled');

        setTimeout(() => {
            $.ajax({
                type: "POST",
                url: RUTA + "back/cliente/nota_venta/correo",
                data: "opcion=enviar_email&id_nota=" + button.parent().attr("data-id_nota"),
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText);
                    button.html(text).removeAttr("disabled").removeClass('disabled');
                    modal.modal("hide");
                    toastr['error']("Por el momento no es posible seguir enviando correos");
                },
                success: function (response) {
                    if (response.status) {
                        toastr['success'](response.text);
                    } else {
                        toastr['error'](response.text);
                    }
                    button.html(text).removeAttr("disabled").removeClass('disabled');
                    modal.modal("hide");
                }
            });
        }, 500);
    })
    $("#delete_nota").on('click', function () {
        let button = $(this);
        let text = '<i class="fas fa-paper-plane mx-3"></i>Enviar correo con el ticket';
        let loading = 'Enviando ... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div> ';
        button.html(loading).attr("disabled", "disabled").addClass('disabled');
        modal.modal('hide');
        Swal.fire({
            title: '¿Realmente deseas eliminar esta nota?',
            html: `Para poder eliminar la nota es necesario ser administrador <br> a continuación escribe <b>'eliminar'</b> y tu nota será eliminada <br>
                <sub>No podrás eliminar notas que ya se hayan vendido su materia prima, y toda su materia prima que se haya agregado al inventario será eliminada</sub>`,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            showLoaderOnConfirm: true,
            preConfirm: (response) => { return response; },
        }).then((result) => {
            if (result.value === 'eliminar') {
                setTimeout(() => {
                    $.ajax({
                        type: "POST",
                        url: RUTA + "back/cliente/nota_venta",
                        data: "opcion=cancelar_nota&id_nota=" + button.parent().attr("data-id_nota"),
                        dataType: "JSON",
                        error: function (xhr, status) {
                            console.log(xhr.responseText);
                            button.html(text).removeAttr("disabled").removeClass('disabled');
                            modal.modal("hide");
                            toastr['error']("Por el momento no es posible eliminar registros");
                        },
                        success: function (response) {
                            if (response.status) {
                                toastr['success'](response.text);
                                mostrar_notas(1, buscar);
                                estadisticas(buscar);
                            } else {
                                toastr['error'](response.text);
                            }
                            button.html(text).removeAttr("disabled").removeClass('disabled');
                            modal.modal("hide");
                        }
                    });
                }, 500);
            } else if (result.value && result.value !== 'eliminar') {
                toastr['error']('Es necesario escribir correctamente "eliminar" ');
            }
        });

    })
}

