class ModelNota {
    invoice(nota) {
        const CONF = new Funciones(); // @/js/models/funciones.js
        var f = new Date();
        let cliente = nota.usuario;
        let fecha = nota.fecha;
        let productos = nota.productos;
        fecha = fecha ? fecha : f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate();
        let date = fecha.split('-');

        let body = `
        <div class="col">
            <div class="text-right">
                <div class="">
                    <small class="text-muted">${date[2]} de ${(CONF.MESES(parseInt(date[1])).toLowerCase())} de ${date[0]}</small>
                </div>
            </div>
            ${this.cliente(cliente)}
        </div>
        <div class="col-12 table-responsive">${this.tabla(productos)}</div>
        <div class="col-12">${this.totales_view(this.totales(nota))}</div>
        `;
        return body;
    }
    cliente(cliente) {
        cliente = cliente.data ? cliente.data : false;
        let dir = (cliente ? cliente.direccion[0] : false);
        let razon_social = cliente ? cliente.razon_social : "";
        let correo = cliente ? cliente.correo : "";
        let telefono = cliente ? cliente.telefono : "";
        let direccion = cliente ? `${dir ? dir.direccion : ""} ${dir ? dir.numero_externo : ""} ,${dir ? dir.ciudad : ""}, ${dir ? dir.estado : ""}` : "";
        return `
            <div class="d-flex" style="cursor: pointer;" id="config_cliente">
                <div class="avatar avatar-online">
                    <span class="avatar-title rounded-circle border border-white bg-info">${razon_social == undefined ? razon_social.split("")[0] : "R"}</span>
                </div>
                <div class="flex-1 ml-3 pt-1">
                    <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">${razon_social}</span></h6>
                    <p class="my-0 py-0">Dirección:<span class="text-muted"> ${direccion}</span></p>
                    <p class="my-0 py-0">Correo:<span class="text-muted"> ${correo}</span></p>
                    <p class="my-0 py-0">Tel:<span class="text-muted"> ${telefono}</span></p>
                </div>
            </div>`;
    }
    filas(productos) {
        const FUNC = new Funciones(); // @/js/models/funciones.js
        let fila_cont = '';
        for (const producto of productos) {
            let subtotal = (parseFloat(producto.precio_venta) * parseInt(producto.cantidad));

            fila_cont +=
                `<tr class="form_editable" data-id="${producto.id}" data-tipo="${producto.tipo}">
                    <td class="no_p" style="min-width:50px;"><input type="number" class="editar_elemento cantidad" value="${producto.cantidad}"></td>
                    <td class="no_p text-justify" style="min-width:220px;">${producto.nombre}</td>
                    <td class="no_p" style="min-width:90px;"><input type="number" class="editar_elemento costo" value="${parseFloat(producto.precio_venta).toFixed(2)}"></td>
                    <td class="no_p" style="min-width:90px;"> $ ${FUNC.number_format(subtotal, 2)}</td>
                    <td class="no_p"><a href="#" class="eliminar_elemento"><i class="fas fa-trash-alt text-danger "></i></a></td>
                </tr>`;
        }
        return fila_cont;
    }
    tabla(datos) {
        return `
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="no_p">#</th>
                        <th class="no_p"><i class="fab fa-product-hunt"></i></th>
                        <th class="no_p">Precio</th>
                        <th class="no_p">Subtotal</th>
                        <th class="no_p"><i class="fas fa-hand-sparkles"></i></th>
                    </tr>
                </thead>
                <tbody>
                    ${this.filas(datos)}
                </tbody>
            </table>`;
    }
    totales(nota) {
        let respuesta = {
            total: 0,
            subtotal: 0,
            productos: 0,
            iva: 0
        };

        let total_suma = 0;
        let total_prod = 0;
        let descuento = nota.descuentos;

        for (const producto of nota.productos) {
            total_suma += (parseFloat(producto.precio_venta) * parseInt(producto.cantidad));
            total_prod += parseInt(producto.cantidad);
        }
        if (descuento && descuento['tipo'] == 'moneda') descuento = parseFloat(descuento.cantidad);
        else if (descuento && descuento['tipo'] == 'porcentaje') descuento = total_suma * ((parseFloat(descuento.cantidad) / 100));
        else descuento = 0;

        respuesta.subtotal = total_suma; // SUBTOTAL
        respuesta.total = respuesta.subtotal - descuento; //TOTAL FINAL

        respuesta.productos = total_prod;
        respuesta.descuento = descuento;
        respuesta.iva = (nota.iva ? respuesta.total * 1.16 : false);

        return respuesta;
    }
    totales_view(total) {
        const FUNC = new Funciones(); // @/js/models/funciones.js
        let fila_cont =
            `<tr>
                <td colspan="7"></td>
            </tr>
            <td class="no_p text-right" colspan="7">
                <div class="form-check py-1 text-right">
                    <label class="form-check-label my-0">
                        <input class="form-check-input" type="checkbox" id="agregar_iva" ${total.iva ? 'checked=""' : ""}>
                        <span class="form-check-sign">Agregar al total el IVA</span>
                    </label>
                </div>
            </td>
            <tr class="no_p">
                <td class="no_p" colspan="3">${total.productos} productos</td>
                <td class="no_p">SUB TOTAL:</td>
                <td class="no_p" colspan="2">$ ${FUNC.number_format(total.subtotal, 2)}</td>
                <td class="no_p"></td>
            </tr>
            <tr class="no_p">
                <td class="no_p" colspan="3"></td>
                <td class="no_p">DESCUENTO:</td>
                <td class="no_p descuento accion descuento_accion" colspan="2">- $ ${FUNC.number_format(total.descuento, 2)}</td>
                <td class="no_p descuento accion descuento_accion"><span class="text-info"><i class="fas fa-cash-register fa-lg"></i></span></td>
            </tr>
            <tr class="no_p">
                <td class="no_p" colspan="3"></td>
                <td class="no_p">TOTAL:</td>
                <td class="no_p" colspan="2">$ ${FUNC.number_format(total.total, 2)}</td>
                <td class="no_p"></td>
            </tr>
            ${total.iva ? `
            <tr class="no_p">
                <td class="no_p" colspan="3"></td>
                <td class="no_p">TOTAL + IVA:</td>
                <td class="no_p" colspan="2">$ ${FUNC.number_format(total.iva, 2)}</td>
                <td class="no_p"></td>
            </tr>`: ""}`;

        return `
            <table class="table">
                ${fila_cont}
            </table>`;
    }
}