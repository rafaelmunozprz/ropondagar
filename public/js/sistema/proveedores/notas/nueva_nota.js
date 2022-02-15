$(document).ready(function () {


    const MODEL = new Materias();
    const STOR = new Storage('venta_proveedor');
    console.log(STOR.total_nota());

    let nota = STOR.mostrar_nota();
    MODEL.proveedor_body($("#config_nota_proveedor"), nota.usuario.data); //Muestra los datos
    MODEL.mostrar_contenido($("#tabla_nota"), nota);

    $("#clear_nota_venta").on('click', function () {
        STOR.borrar_nota();
        let nota = STOR.mostrar_nota();
        MODEL.proveedor_body($("#config_nota_proveedor"), nota.usuario.data); //Muestra los datos
        MODEL.mostrar_contenido($("#tabla_nota"), nota);
    });


});



class Materias {
    total_productos = {
        productos: 0,
        total: 0
    };

    mostrar_contenido(contenedor, nota) {
        // console.log(nota);
        const FUNC = new Funciones();
        contenedor.html(this.tabla(nota));
        let total = $("#total_nota");
        total.find(".cantidad").html(this.total_productos.productos);
        total.find(".total").html(" $ " + FUNC.number_format(this.total_productos.total, 2) + " MXN");
        this.acciones_nota(contenedor);
    }
    tabla(nota) {
        return `
            <table class="table ">
                <thead class="thead-light">
                    <tr>
                        <th class="no_p" scope="col"><i class="fab fa-product-hunt"></i></th>
                        <th class="no_p" scope="col" style="min-width:110px;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    ${this.filas(nota)}
                </tbody>
            </table>`;
    }
    filas(nota) {
        const FUNC = new Funciones();

        let fila_cont = '';
        let total_suma = 0;
        let subtotal = 0;
        let total_prod = 0;
        let descuento = nota.descuentos;

        for (const i in nota.productos) {
            let producto = nota.productos[i];
            let total = parseFloat(producto.precio_compra) * parseFloat(producto.cantidad);
            total_suma += (total ? total : 0);
            total_prod += parseFloat(producto.cantidad);

            let conf = (producto.tipo == 'materia_prima' ?
                { "color": "bg-primary", "icon": '<i class="fab fa-product-hunt"></i>' } :
                { "color": "bg-info", "icon": '<i class="fas fa-registered"></i>' });
            fila_cont +=
                `<tr>
                    <td class="no_p">
                        <div class="row justify-content-end" data-id_producto="${producto.id}" data-tipo="${producto.tipo}">
                            <div class="col-lg-6 col-md-12 text-justify pl-md-4 pl-1 py-3">
                                <div class="d-flex">
                                    <div class="avatar" >
                                        <span class="avatar-title rounded-circle border ${conf.color}">${conf.icon}</span>
                                    </div>
                                    <div class="flex-1 ml-3 pt-1">
                                        <a class="font-weight-bold text-primary">${producto.nombre}</a>
                                        <p class="my-0 py-0 lh-1">Cantidad:<span class="text-muted">  ${producto.cantidad}</span></p>
                                        <p class="my-0 py-0 lh-1">Código:<span class="text-muted"> ${producto.codigo}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 modificar_show" style="cursor:pointer;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="no_p">Compra</th>
                                            <th class="no_p">Mayoreo</th>
                                            <th class="no_p">Menudeo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="no_p">$ ${FUNC.number_format(producto.precio_compra, 2)}</td>
                                            <td class="no_p">$ ${FUNC.number_format(producto.precio_mayoreo, 2)}</td>
                                            <td class="no_p">$ ${FUNC.number_format(producto.precio_menudeo, 2)}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 text-right accion_edicion my-md-2 my-3" style="display:none" >
                                <a class="btn btn-warning btn-sm editar_producto"><i class="fas fa-edit"></i> modificar</a>
                                <a class="btn btn-danger btn-sm text-white ml-4 eliminar_producto"><i class="fas fa-trash"></i> eliminar</a>
                            </div>
                        </div>
                    </td>
                    <td class="no_p">$ ${FUNC.number_format(total, 2)}</td>
                </tr>`;
            /**Salto de producto con fila en blanco */
            fila_cont +=
                `<tr data-id_producto="${producto.id}" data-tipo="${producto.tipo}"">
                    <td class="p-0 bg-dark" colspan="2" style="padding: 0 !important; height: 8px;"></td>
                </tr>`;
        }

        if (descuento && descuento['tipo'] == 'moneda') descuento = parseFloat(descuento.cantidad);
        else if (descuento && descuento['tipo'] == 'porcentaje') descuento = total_suma * ((parseFloat(descuento.cantidad) / 100));
        else descuento = 0;

        subtotal = total_suma; // SUBTOTAL
        total_suma = ((subtotal - descuento) * (nota.iva ? 1.16 : 1)); //TOTAL FINAL


        this.total_productos.productos = total_prod;
        this.total_productos.total = total_suma;

        fila_cont +=
            `<tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="row">
                        <div class="col">
                            <table class="table">
                                <tbody>
                                    <tr class="no_p">
                                        <td class="no_p" colspan="3"></td>
                                        <td class="no_p text-right" colspan="3">
                                            <div class="form-check py-1">
                                                <label class="form-check-label my-0">
                                                    <input class="form-check-input" type="checkbox" id="agregar_iva" ${nota.iva ? "checked" : ""}>
                                                    <span class="form-check-sign">Agregar al total el IVA</span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="no_p"></td>
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            `;
        return fila_cont;
    }
    acciones_nota(tabla = false, storage_name = "venta_proveedor") {
        let STORE = new Storage(storage_name);
        let MODELS = new Materias();
        $(".descuento.accion").on('click', function () {
            $("#modal_descuento").modal('show');
        });
        $(".modificar_show").on('click', function (e) {
            // $(this).parent().find(".accion_edicion").toggle("show");
            e.preventDefault();
            let button = $(this);
            let id_producto = button.parent().attr("data-id_producto");
            let tipo = button.parent().attr("data-tipo");

            let producto = STORE.mostrar_producto(id_producto, tipo);

            let formulario = $("#modificar_producto");
            let modal = $("#modal_modificar_producto");
            let cantidad = formulario.find("#cantidad"),
                codigo = formulario.find("#codigo"),
                producto_id = formulario.find("#id_producto"),
                precio_compra = formulario.find("#precio_compra"),
                precio_mayoreo = formulario.find("#precio_mayoreo"),
                precio_menudeo = formulario.find("#precio_menudeo");

            modal.modal("show"); //Mostramos el moda

            //Modificamos los datos del formulario para despues actualizar

            codigo.val(producto.codigo);
            cantidad.val(producto.cantidad);
            producto_id.val(producto.id);
            producto_id.attr("tipo", producto.tipo);
            precio_compra.val(producto.precio_compra ? producto.precio_compra : "");
            precio_mayoreo.val(producto.precio_mayoreo ? producto.precio_mayoreo : "");
            precio_menudeo.val(producto.precio_menudeo ? producto.precio_menudeo : "");



            formulario.off().submit(function (e) {
                e.preventDefault();

                producto.codigo = (codigo.val());
                producto.cantidad = parseFloat(cantidad.val());
                producto.precio_compra = parseFloat(precio_compra.val());
                producto.precio_mayoreo = parseFloat(precio_mayoreo.val());
                producto.precio_menudeo = parseFloat(precio_menudeo.val());

                let nota = STORE.actualizar_producto(producto);
                MODELS.mostrar_contenido($("#tabla_nota"), nota);
                modal.modal("hide"); //Ocultamos el modal al finalizar el moda
            });

            $("#eliminar_producto").off().on('click', function (e) {
                e.preventDefault();
                STORE.borrar_elemento(id_producto, tipo);
                let nota = STORE.mostrar_nota();
                MODELS.mostrar_contenido($("#tabla_nota"), nota);
                modal.modal("hide"); //Ocultamos el modal al finalizar el moda
            });
        });
        $("#agregar_iva").on('change', function () {
            let check = $(this);
            let nota = STORE.mostrar_nota();
            if (check.is(":checked")) nota.iva = true;
            else nota.iva = false;
            STORE.guardar_nota(JSON.stringify(nota)); //Guardamos el cambio
            MODELS.mostrar_contenido($("#tabla_nota"), nota);
        });
    }
    proveedor_body(contenedor, proveedor = false) {
        let CONF = new Funciones();

        var f = new Date();
        let letter = "R";
        if (proveedor && proveedor['razon_social']) letter = proveedor['razon_social'][0].toUpperCase();
        if (!proveedor) proveedor = {
            'numero': "1",
            'razon_social': "Sin nombre de proveedor",
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
        // console.log(proveedor);
        let date = proveedor['fecha'].split("-");

        let dir = (proveedor.direccion) ? proveedor.direccion[0] : false;

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
                    <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${proveedor['razon_social']}</span></h6>
                    <p class="my-0 py-0">Dirección:<span class="text-muted"> ${dir ? dir.direccion : ""} ${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}</span></p>
                    <p class="my-0 py-0">Correo:<span class="text-muted"> ${proveedor['correo']}</span></p>
                </div>
            </div>`);
    }
}

class Storage {
    constructor(storage_name) {
        this.storage_name = storage_name;
        this.template_note = {
            "usuario": {
                "id": false,
                "tipo": false, //empleado,proveedor,cliente
                "data": false, //Todos los datos del cliente
            },
            "productos": [
                // {
                //     "id": 1,
                //     "tipo": "materia_prima",
                //     "cantidad": 1,
                //     "data": {datos},
                // }
            ],
            "descuentos": {
                "tipo": "moneda",
                "cantidad": 0
            },
            "fecha": false,
            "iva": false
        };
    }

    mostrar_nota() {
        let datos = false;
        let lista;
        if (lista = localStorage.getItem(this.storage_name)) {
            datos = JSON.parse(lista);
        } else {
            datos = this.template_note;
        }
        return datos;
    }
    total_nota() {
        let nota = this.mostrar_nota();
        let resultado = { "total": 0, "iva": false, "subtotal": 0, "descuento": 0 };
        for (const producto of nota.productos) {
            resultado.subtotal = parseFloat(resultado.subtotal) + (parseFloat(producto.precio_compra) * producto.cantidad); //suma el precio
        }

        let descuento = nota.descuentos.tipo == 'moneda' ? nota.descuentos.cantidad : ((nota.descuentos.cantidad * resultado.subtotal) / 100); //calculamos el descuento, convertimos el porcentaje a moneda
        resultado.descuento = parseFloat(descuento);
        resultado.iva = nota.iva; //Indica si ya viene la nota con iva o no

        resultado.total = (resultado.subtotal - resultado.descuento);
        resultado.total = (resultado.total * (nota.iva ? 1.16 : 1));

        return resultado;
    }
    mostrar_producto(id_producto, tipo) {
        let nota = this.mostrar_nota();
        for (const producto of nota.productos) // recorre todos los productos
            if (producto.id == id_producto && producto.tipo == tipo) return producto; // solo guarda los productos que no sean el seleccionado
    }
    guardar_nota(lista) {
        // la lista deve de llegar como JSON en formato text
        localStorage.setItem(this.storage_name, lista);
    }
    agregar_productos(new_producto) {
        let nota = this.mostrar_nota();
        // console.log(nota);
        let productos = nota.productos;
        let encontrado = false;
        for (const i_prod in productos) {
            let producto = productos[i_prod]; // Se separa el producto para acceder a el

            if (producto.id == new_producto.id && producto.tipo == new_producto.tipo) { // Evaluamos que sea el correcto
                encontrado = true; // Se encontró coincidencia

                producto.cantidad = (parseFloat(producto.cantidad) + parseFloat(new_producto.cantidad)); //suma las cantidades en caso de que hallá más
                producto.data = new_producto.data; // Reescribe la data del nuevo producto

                productos[i_prod] = producto;
            }
        }
        if (!encontrado) productos.push(new_producto); //agrega el nuevo producto en caso de que no este en la nota
        nota.productos = productos;

        this.guardar_nota(JSON.stringify(nota)); // Se guarda la nota completa despues de editar lo que se necesita


    }
    borrar_elemento(id, tipo) {
        let nota = this.mostrar_nota();
        let productos = [];
        for (const producto of nota.productos) // recorre todos los productos
            if (producto.id != id || producto.tipo != tipo) productos.push(producto); // solo guarda los productos que no sean el seleccionado

        nota.productos = productos; // Actualiza la lista
        this.guardar_nota(JSON.stringify(nota));
        return nota;
    }
    actualizar_producto(producto) {
        let nota = this.mostrar_nota();
        let productos = [];
        for (const prod of nota.productos) // recorre todos los productos
            if (prod.id == producto.id && prod.tipo == producto.tipo) productos.push(producto); // solo guarda los productos que no sean el seleccionado
            else productos.push(prod); //Guarda los que no se modifican

        nota.productos = productos; // Actualiza la lista
        this.guardar_nota(JSON.stringify(nota));
        return nota;
    }
    borrar_nota() {
        localStorage.removeItem(this.storage_name);
    }
}