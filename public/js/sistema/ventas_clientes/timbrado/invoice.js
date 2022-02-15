class Invoice {
    body(nota) {
        let FUNC = new Funciones();
        let cliente = nota.cliente;
        let productos = nota.nota.productos;
        let pagos = nota.pagos;
        let dir = cliente.direccion;
        let productos_b = "";
        let total = 0;
        for (const producto of productos) {
            total += parseFloat(producto.precio_venta) * parseInt(producto.cantidad);
            productos_b += `    <div class="col-md-12 px-sm-1 px-0">${this.producto_body(producto)}</div>`;
        }
        return `
            <div class="row invoice-info">
                <div class="col-12 px-sm-1 px-0">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> Ropón Dagar.
                                        <small class="float-right">Fecha: ${nota.nota.fecha.split(" ")[0]}</small>
                                    </h4>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>Ropón Dagar.</strong><br>
                                        Prolongación Macias #212, C.P. 47140<br>
                                        <b>Col. </b>Sagrada Familia<br>
                                        <b>RFC: </b>AOGA730511IC3<br>
                                        <b>TEL: </b>347 106 4585 <br>
                                        <b>CEL: </b>347 108 0422
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <h4> Cliente.</h4>
                                    <address>
                                        <strong>${cliente.razon_social}</strong><br>
                                        <strong>RFC: ${cliente.rfc}</strong><br>

                                        ${dir.direccion ? `Dir.${dir.direccion}` : ""}
                                        ${dir.colonia ? `, Col. ${dir.colonia}` : ""}
                                        ${dir.ciudad ? `, Ciudad ${dir.ciudad} <br>` : ""} 
                                        ${dir.cp ? `, CP. ${dir.cp} ` : ""}
                                        ${dir.estado ? `estado ${dir.estado}` : ""}
                                        ${dir.numero_externo ? `No. Ext. ${dir.numero_externo}` : ""}
                                        ${dir.numero_interno ? `No. Int. ${dir.numero_interno}` : ""}
                                        Correo: ${cliente.correo}<br>
                                        Tel: ${cliente.telefono}<br>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <b>Nota # <span class="text-danger">${FUNC.rellenarCero(nota.nota.id_nota_cliente, 6)}</span></b><br>
                                    <br>
                                    <b>Fecha de pago:</b> ${true ? nota.nota.fecha_pago_total.split(" ")[0] : "Aún no"}<br>
                                    <b class="${nota.nota.estado == 'pagado' ? "text-success" : "text-warning"}">${nota.nota.estado.toUpperCase()}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"> ${productos_b} </div>
            <div class="row justify-content-end">
                <div class="col-md-6 px-sm-1 px-0">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p class="lead text-dark">TOTAL DE LA NOTA</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th class="no_p">Total</th>
                                                <td class="no_p">$ ${FUNC.number_format(total, 2)}</td>
                                            </tr>
                                            <tr>
                                                <th class="no_p">Descuento</th>
                                                <td class="no_p">$ ${FUNC.number_format(nota.nota.descuento, 2)}</td>
                                            </tr>
                                            <tr>
                                                <th class="no_p">Total + IVA: </th>
                                                <td class="no_p">$ ${FUNC.number_format((total * 1.16), 2)} </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    }
    producto_body(producto) {
        let FUNC = new Funciones();
        return `
            <div class="card mb-2">
                <div class="card-header p-1">                
                    <div class="row fiscal_data" data-tipo="${producto.tipo}" data-id="${producto.id}">
                        <div class="col-sm-6 pt-1 text-justify">
                            <a class="font-weight-bold">${producto.nombre}</a>
                            <p class="my-0 py-0 lh-1 form_editable">Código Fiscal:<span class=""> <input type="text" class="editar_elemento cantidad codigo_fiscal " value="${producto.codigo_fiscal}666" required></span></p>
                            <p class="my-0 py-0 lh-1">Cantidad:<span class=""> ${producto.cantidad}</span></p>
                        </div>
                        <div class="col-sm-6 pt-1 text-justify">
                            <a class="font-weight-bold">Costo</a>
                            <p class="my-0 py-0 lh-1">Cantidad:<span class=""> $ ${FUNC.number_format(producto.precio_venta, 2)}</span></p>
                            <p class="my-0 py-0 lh-1">Subtotal: $ ${FUNC.number_format((producto.precio_venta * producto.cantidad), 2)}</p>
                            <p class="my-0 py-0 lh-1"><b>Subtotal + IVA : $ ${FUNC.number_format(((producto.precio_venta * producto.cantidad) * 1.16), 2)}</b></p>
                        </div>
                    </div>
                </div>
            </div>`;
    }
}