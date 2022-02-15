$(document).ready(function () {
    /**
     * En este evento se puede ocultar la creación de notas
     */
    $(".evento_producto").click(function (e) {
        e.preventDefault();
        let button = $(this);
        let contenedor = $("#formulario_productos");
        contenedor.find(".contenedor_form").toggle('show');
        contenedor.find(".contenedor_titulos").children('h2').toggle('show');
        contenedor.find(".contenedor_titulos").children('a').toggle('show');
    });



    const MODEL = new Modelos();
    const STORE = new Storage();

    let lista = (STORE.mostrar_lista());
    let modelos = (lista ? lista : []);

    let cliente_datos = "";
    if (lista) MODEL.mostrar_contenido($("#tabla_nota"), modelos);
    cliente_datos = STORE.mostrar_cliente();
    MODEL.cliente_body($("#config_nota_cliente"), cliente_datos);

    $("#form_new_producto").on('submit', function (e) {
        e.preventDefault();

        lista = (STORE.mostrar_lista());
        modelos = (lista ? lista : []);
        let formulario = $(this);

        let cantidad = formulario.find('[name="cantidad"]').val();
        let modelo = formulario.find('[name="modelo"]').val();
        let precio = formulario.find('[name="precio"]').val();
        /**Limpieza de errores */
        formulario.find(".cont_cantidad").removeClass("has-error");
        formulario.find(".cont_modelo").removeClass("has-error");
        formulario.find(".cont_precio").removeClass("has-error");

        /**validacion de errores */
        let error_cont = 0;
        if (cantidad == "" || cantidad.length <= 0 || cantidad <= 0) formulario.find(".cont_cantidad").addClass("has-error"), error_cont++;
        if (modelo == "" || modelo.length <= 0) formulario.find(".cont_modelo").addClass("has-error"), error_cont++;
        if (precio == "" || precio.length <= 0) formulario.find(".cont_precio").addClass("has-error"), error_cont++;



        if (error_cont === 0) {
            /**
             * REGISTRO DE NOTA Y PROCESO DE LLENADO DE DATOS
             */

            var formData = new FormData(document.getElementById("form_new_producto"));

            let datos = "";
            let color = "";
            for (var pair of formData.entries()) {
                if (pair[0] == 'color') {
                    color += (color != '' ? "|" : "") + pair[1];
                } else {
                    datos += (datos == "" ? "" : ",") + `"${pair[0]}": "${pair[1]}"`;
                }
            }
            datos += (datos == "" ? "" : ",") + `"color": "${color}"`;


            modelos.push(JSON.parse(`{${datos}}`));
            STORE.enviar_lista(JSON.stringify(modelos));
            /**
             * CARGA DE TABLA Y METODO DE ELIMINACION
             */
            MODEL.mostrar_contenido($("#tabla_nota"), modelos);
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
            formulario.find('[name="cantidad"]').val("");
            formulario.find('[name="modelo"]').val("");
            formulario.find('[name="precio"]').val("");
        } else {
            $.notify({
                icon: 'fas fa-exclamation-circle',
                title: 'Completa los datos',
                message: `No puedes dejar campos en blanco, completa las celdas marcadas en rojo para poder hacer el registro.`,
            }, {
                type: 'warning',
                placement: {
                    from: "top",
                    align: "right"
                },
                time: 1500,
            });
        }
    });
    
    $("#print_PDF").on('click', function (e) {
        Swal.fire({
            title: '¿Todo luce bien?',
            text: "La nota de venta no se puede modificar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, vender!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                e.preventDefault();
                let lista = (STORE.mostrar_lista());
                let modelos = (lista ? lista : []);
                let descuento = STORE.mostrar_descuento();
                cliente_datos = STORE.mostrar_cliente();
                if (lista != "") {
                    var modal = $("#modal_notificacion");
                    modal.find(".titulo_modal").hide();
                    modal.find(".titulo_modal").hide();
                    modal.find(".modal-footer").hide();
                    modal.modal('show');
                    modal.find(".cuerpo_modal").html(`<div class="row"><div class="col-12"><div class="loader_spin"></div></div><div class="col text-center text-spinner">Generando <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div> </div></div>`).addClass("loader_maximus");
                    setTimeout(() => {
                        modal.find(".titulo_modal").show();
                        modal.find(".titulo_modal").children('h5').html("Nota finalizada");
                        modal.find(".modal-footer").show();
                        modal.find(".cuerpo_modal").html(``).removeClass("loader_maximus");
                        modal.modal('show');
                        modal.find(".cuerpo_modal").html(`
                                    <div class="row">
                                        <div class="col-12 text-center"><h2>Nota creada de manera correcta</h2></div>
                                        <div class="col">
                                            <div class="success-checkmark">
                                                <div class="check-icon">
                                                    <span class="icon-line line-tip"></span>
                                                    <span class="icon-line line-long"></span>
                                                    <div class="icon-circle"></div>
                                                    <div class="icon-fix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center"><p>Puedes continuar con la impresión</p></div>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-md-6 col-6 my-2"><a class="btn btn-info btn-border btn-round  btn-block print_venta" data-tipo="facturaticket"> <span class="btn-label"> <i class="fa fa-print"></i></span>Print Ticket</a></div>-->
                                        <div class="col-md-6 col-6 my-2"><a class="btn btn-primary btn-border btn-round  btn-block print_venta" data-tipo="facturapdf"> <span class="btn-label"> <i class="fas fa-file-pdf"></i></span>Print PDF</a></div>
                                        <div class="col-md-6 col-6 my-2">
                                            <a class="btn btn-primary btn-border btn-round  btn-block" id="enviar_zebra" data-tipo="facturazpl" href="${RUTA}public/documentos/zebra/ticket.zpl" download="ticket.zpl"> <span class="btn-label"> <i class="fas fa-file-pdf"></i></span>Print Zebra</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col my-2"><a id="send_mail" class="btn btn-dark btn-border btn-round  btn-block text-dark" > <span class="btn-label"> <i class="fas fa-paper-plane mx-3"></i></span>Enviar correo con el ticket</a></div>
                                    </div>`);
                        const VENDER = new Venta()
                        VENDER.vender((JSON.stringify(cliente_datos)), JSON.stringify(modelos), JSON.stringify(descuento))

                        const ZEBRA = new SendZebra();
                        ZEBRA.guardar_archivo((JSON.stringify(cliente_datos)), JSON.stringify(modelos), JSON.stringify(descuento));
                        const PDF = new SendMailPDF();
                        PDF.guardar_pdf((JSON.stringify(cliente_datos)), JSON.stringify(modelos), JSON.stringify(descuento));
                        $(".print_venta").on('click', function () {
                            let print = $(this);
                            $("#send_new_PDF").remove();
                            $("#form_new_producto").append(`
                        <form id="send_new_PDF" class="d-none" action="${RUTA}sistema/notas/${print.attr("data-tipo")}" method="POST" enctype="multipart/form-data">
                            <input type="text" name="datos" value='${JSON.stringify(modelos)}'>
                            <input type="text" name="descuento" value='${JSON.stringify(descuento)}'>
                            <input type="text" name="cliente" value='${cliente_datos != "" ? JSON.stringify(cliente_datos) : ""}'>
                            <button type="submit"class="enviar_form"></button>
                        </form>`);
                            $("#send_new_PDF").find("button").click();
                        });
                        $("#send_mail").on('click', function () {
                            let button = $(this);
                            const EMAIL = new SendMail();
                            button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                            let cliente = JSON.stringify(cliente_datos);
                            let mod = JSON.stringify(modelos);
                            let des = JSON.stringify(descuento);
                            const ZEBRA = new SendZebra();
                            ZEBRA.guardar_archivo((JSON.stringify(cliente_datos)), JSON.stringify(modelos), JSON.stringify(descuento), button);
                            EMAIL.enviar_correo(cliente, mod, des, button);
                        });
                    }, 2000);


                } else {
                    $.notify({
                        icon: 'fas fa-exclamation-circle',
                        title: 'No puedes continuar ya que no tienes datos correctos en tus notas',
                        message: `Completa la nota antes de continuar.`,
                    }, {
                        type: 'warning',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        time: 1500,
                    });
                }
            }
        })



    });

    $("#calculo_descuento").submit(function (e) {
        e.preventDefault();
    });
    $("#guardar_descuento").on('click', function () {
        let cont_form = $("#calculo_descuento");
        cont_form.off();
        let variables = cont_form.serialize().split("&");
        let resp = {
            tipo: "cantidad",
            cantidad: 0
        };
        for (const i in variables) {
            let new_var = variables[i];
            new_var = new_var.split("=");
            if (new_var[0] == 'tipodescuento') resp.tipo = new_var[1];
            else if (new_var[0] == 'cantidad') resp.cantidad = (new_var[1] ? new_var[1] : 0);
        }
        STORE.aplicar_descueto(JSON.stringify(resp));
        MODEL.mostrar_contenido($("#tabla_nota"), STORE.mostrar_lista());
        $("#modal_descuento").modal('hide');
    });
    $("#clear_nota_venta").on('click', function () {
        STORE.borrar_cliente();
        STORE.borrar_lista();
        STORE.borrar_descuento();
        MODEL.cliente_body($("#config_nota_cliente"));
        lista = (STORE.mostrar_lista());

        if (lista) MODEL.mostrar_contenido($("#tabla_nota"), lista);
        else $("#tabla_nota").html("");
        let total = $("#total_nota");
        total.find(".cantidad").html(0);
        total.find(".total").html(" $ 0 MXN");
    });


});

class Modelos {
    total_productos = {
        productos: 0,
        total: 0
    };

    mostrar_contenido(contenedor, contenido) {
        const FUNC = new Funciones();

        contenedor.html(this.tabla(contenido));
        let total = $("#total_nota");
        total.find(".cantidad").html(this.total_productos.productos);
        total.find(".total").html(" $ " + FUNC.number_format(this.total_productos.total, 2) + " MXN");
        this.quitar_elemento(contenedor);
        this.agregar_descuento();
    }
    filas(datos) {
        const FUNC = new Funciones();
        const STOR = new Storage();
        let fila_cont = '';
        let total_suma = 0;
        let subtotal = 0;
        let total_prod = 0;
        let descuento = STOR.mostrar_descuento();
        for (const i in datos) {
            let fila = datos[i];
            total_suma += (parseFloat(fila.precio) * parseInt(fila.cantidad));
            total_prod += parseInt(fila.cantidad);
            fila_cont +=
                `<tr data-row=${parseInt(i) + 1}>
                    <td class="no_p">${fila.cantidad}</td>
                    <td class="no_p">${fila.modelo}</td>
                    <td class="no_p">${fila.color}</td>
                    <td class="no_p">${fila.talla}</td>
                    <td class="no_p">${fila.tipo}</td>
                    <td class="no_p" style="min-width:75px;">$ ${FUNC.number_format(fila.precio, 2)}</td>
                    <td class="no_p"><a href="#" class="eliminar_elemento"><i class="fas fa-trash-alt text-danger "></i></a></td>
                </tr>`;
        }
        if (descuento && descuento['tipo'] == 'moneda') descuento = parseFloat(descuento.cantidad);
        else if (descuento && descuento['tipo'] == 'porcentaje') descuento = total_suma * ((parseFloat(descuento.cantidad) / 100));
        else descuento = 0;

        subtotal = total_suma; // SUBTOTAL
        total_suma = subtotal - descuento; //TOTAL FINAL


        this.total_productos.productos = total_prod;
        this.total_productos.total = total_suma;

        fila_cont +=
            `<tr>
                <td colspan="7"></td>
            </tr>
            <tr class="no_p">
                <td class="no_p" colspan="3">${total_prod} productos</td>
                <td class="no_p">SUB TOTAL:</td>
                <td class="no_p" colspan="2">$ ${FUNC.number_format(subtotal, 2)}</td>
                <td class="no_p"></td>
            </tr>
            <tr class="no_p">
                <td class="no_p" colspan="3"></td>
                <td class="no_p">DESCUENTO:</td>
                <td class="no_p descuento accion" colspan="2">- $ ${FUNC.number_format(descuento, 2)}</td>
                <td class="no_p descuento accion"><span class="text-info"><i class="fas fa-cash-register fa-lg"></i></span></td>
            </tr>
            <tr class="no_p">
                <td class="no_p" colspan="3"></td>
                <td class="no_p">TOTAL:</td>
                <td class="no_p" colspan="2">$ ${FUNC.number_format(total_suma, 2)}</td>
                <td class="no_p"></td>
            </tr>`;
        return fila_cont;
    }
    tabla(datos) {
        return `
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="no_p"><i class="fab fa-product-hunt"></i></th>
                        <th class="no_p"><i class="fas fa-barcode"></i></th>
                        <th class="no_p"><i class="fas fa-fill-drip"></i></th>
                        <th class="no_p"><i class="fas fa-ruler"></i></th>
                        <th class="no_p"><i class="fas fa-stroopwafel"></i></th>
                        <th class="no_p"><i class="fas fa-hand-holding-usd"></i></th>
                        <th class="no_p"><i class="fas fa-hand-sparkles "></i></th>
                    </tr>
                </thead>
                <tbody>
                    ${this.filas(datos)}
                </tbody>
            </table>`;
    }
    quitar_elemento(tabla = false) {
        $(".eliminar_elemento").on('click', function (e) {
            e.preventDefault();
            let button = $(this);
            let fila = button.parent().parent().attr('data-row');
            const STORE = new Storage();
            const MODEL = new Modelos();
            STORE.borrar_elemento(STORE.mostrar_lista(), parseInt(fila));
            MODEL.mostrar_contenido(tabla, STORE.mostrar_lista());
        });
    }
    agregar_descuento() {
        $(".descuento.accion").on('click', function () {
            $("#modal_descuento").modal('show');
        });
    }
    cliente_body(contenedor, cliente = false) {
        let CONF = new Funciones();

        var f = new Date();
        let letter = "R";
        if (cliente && cliente['razon_social']) letter = cliente['razon_social'][0].toUpperCase();
        if (!cliente) cliente = {
            'numero': "1",
            'razon_social': "Sin nombre de cliente",
            'direccion': [{
                direccion: "Sin dirección",
                numero_externo: '',
                numero_interno: "N/A",
                colonia: "",
                ciudad: "Sin ciudad",
                estado: ""
            }],
            'correo': "email@email.com",
            'fecha': f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate(),
        };
        // console.log(cliente);
        let date = cliente['fecha'].split("-");

        let dir = (cliente.direccion) ? cliente.direccion[0] : false;

        contenedor.html(`
            <div class="text-right">
                <div class="">
                    <small class="text-muted">${date[2]} de ${(CONF.MESES(parseInt(date[1])).toLowerCase())} de ${date[0]}</small>
                </div>
            </div>
            <div class="d-flex">
                <div class="avatar avatar-online">
                    <span class="avatar-title rounded-circle border border-white bg-info">${letter}</span>
                </div>
                <div class="flex-1 ml-3 pt-1">
                    <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${cliente['razon_social']}</span></h6>
                    <p class="my-0 py-0">Dirección:<span class="text-muted"> ${dir ? dir.direccion : ""} ${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}</span></p>
                    <p class="my-0 py-0">Tipo de cliente: <span class="text-muted">${cliente.tipo_cliente}</span></p>
                    <p class="my-0 py-0">Correo:<span class="text-muted"> ${cliente['correo']}</span></p>
                </div>
            </div>`);
    }
}

class Storage {
    mostrar_lista() {
        let datos = false;
        let lista;
        if (lista = localStorage.getItem('compras')) {
            datos = JSON.parse(lista);
        }

        return datos;
    }
    enviar_lista(lista) {
        localStorage.setItem('compras', lista);
    }
    borrar_elemento(lista, fila) {
        if (lista) {
            let new_list = [];
            for (const j in lista) {
                if (j != (fila - 1)) new_list.push(lista[j]);
            }
            this.enviar_lista(JSON.stringify(new_list));
        }
    }
    borrar_lista() {
        localStorage.removeItem('compras');
    }
    agregar_modelos(modelo) {
        let lista = this.mostrar_lista();
        if (lista) {
            let new_list = [];
            // console.log(modelo);
            // console.log("HERE");
            let agregado = false;
            for (let modelo_f of lista) {
                if ((modelo_f.id_modelo_viejo == modelo.id_modelo_viejo) && !agregado) {
                    agregado = true;
                    modelo_f['cantidad'] = parseInt(modelo_f['cantidad']) + parseInt(modelo['cantidad']);
                    modelo_f['precio'] = modelo['precio'];
                }
                new_list.push(modelo_f);
            }
            if (!agregado) new_list.push(modelo); // Si no encontro nada loa grega a los productos
            // console.log(new_list);
            this.enviar_lista(JSON.stringify(new_list));
        } else {
            this.enviar_lista(JSON.stringify([modelo]));
        }
    }
    //Cliente
    mostrar_cliente() {
        /**
         * Busca el cliente, si existe lo devuelve
         */
        let datos = false;
        let lista;
        if (lista = localStorage.getItem('cliente_venta')) {
            datos = JSON.parse(lista);
        }

        return datos;
    }
    guardar_cliente(cliente) {
        //Recibe un json en string
        localStorage.setItem('cliente_venta', cliente);
    }
    borrar_cliente() {
        localStorage.removeItem('cliente_venta');
    }
    aplicar_descueto(descuento) {
        // debe de llegar STRING 
        /**
         * {
         *     tipo:"total"|"porcentaje"
         *     cantidad:float
         * }
         */
        localStorage.setItem('descuento_venta', descuento);
    }
    borrar_descuento() {
        localStorage.removeItem('descuento_venta');
    }
    mostrar_descuento() {
        let datos = false;
        let lista;
        if (lista = (localStorage.getItem('descuento_venta'))) {
            datos = JSON.parse(lista);
        }

        return datos;
    }
}