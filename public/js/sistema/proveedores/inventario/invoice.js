class Invoice {
    body(nota) {
        let FUNC = new Funciones();
        let proveedor = nota.proveedor;
        let productos = nota.nota.productos;
        let pagos = nota.pagos;
        let dir = proveedor.direccion;
        let productos_b = "";
        let total = 0;
        for (const producto of productos) {
            total += parseFloat(producto.precio_compra) * parseInt(producto.cantidad);
            productos_b += `    <div class="col-md-6 px-sm-1 px-0">${this.producto_body(producto)}</div>`;
        }
        // total = ((total - parseFloat(nota.nota.descuento)) * 1.16).toFixed(2);
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
                                    <h4> Proveedor.</h4>
                                    <address>
                                        <strong>${proveedor.razon_social}</strong><br>
                                        <strong>RFC: ${proveedor.rfc}</strong><br>

                                        ${dir.direccion ? `Dir.${dir.direccion}` : ""}
                                        ${dir.colonia ? `, Col. ${dir.colonia}` : ""}
                                        ${dir.ciudad ? `, Ciudad ${dir.ciudad} <br>` : ""} 
                                        ${dir.cp ? `, CP. ${dir.cp} ` : ""}
                                        ${dir.estado ? `estado ${dir.estado}` : ""}
                                        ${dir.numero_externo ? `No. Ext. ${dir.numero_externo}` : ""}
                                        ${dir.numero_interno ? `No. Int. ${dir.numero_interno}` : ""}
                                        Correo: ${proveedor.correo}<br>
                                        Tel: ${proveedor.telefono}<br>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <b>Nota # <span class="text-danger">${FUNC.rellenarCero(nota.nota.id_nota_proveedor, 6)}</span></b><br>
                                    <br>
                                    <b>Fecha de pago:</b> ${nota.nota.estado == 'pagado' ? nota.nota.fecha_pago_total.split(" ")[0] : "Aún no"}<br>
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
                                                <th class="no_p">Total: <br>${nota.nota.iva == 'si' ? `<b> IVA + 16%</b>` : ""}</th>
                                                <td class="no_p">$ ${FUNC.number_format(nota.nota.total_costo, 2)} </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                ${this.pagos_body(nota.nota, pagos)}
            </div>

            `;
    }
    producto_body(producto) {
        let FUNC = new Funciones();
        return `
            <div class="card mb-2">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="avatar ">
                            <span class="avatar-title rounded-circle bg-primary "><i class="fab fa-product-hunt"></i></span>
                        </div>
                        <div class="flex-1 ml-3 pt-1 text-justify">
                            <a class="font-weight-bold">${producto.nombre}</a>
                            <p class="my-0 py-0 lh-1">Cantidad:<span class=""> ${producto.cantidad}</span></p>
                            <p class="my-0 py-0 lh-1">Código:<span class=""> ${producto.codigo}</span></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th class="no_p">Compra</th>
                                <th class="no_p">Mayoreo</th>
                                <th class="no_p">Menudeo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="no_p"> $ ${FUNC.number_format(producto.precio_compra, 2)}</td>
                                <td class="no_p"> $ ${FUNC.number_format(producto.precio_menudeo, 2)}</td>
                                <td class="no_p"> $ ${FUNC.number_format(producto.precio_mayoreo, 2)}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-muted py-2 text-right px-1" data-id_producto="${producto.id}" data-tipo="${producto.tipo}">
                    <a class="btn bg-primary text-white mx-3 py-1 show_text guardar_almacen" title="Ubicar en almacen">
                        <span class="text-hiden "> Asignar en Almacen</span>
                        <i class="fas fa-archive"></i>
                    </a>
                    ${((producto.id_stock > 0) && producto.data_stock) ? `
                    <a class="btn bg-success text-white mx-3 py-1 show_text" title="Agregar al stock">
                        <span class="text-hiden "> En stock</span>
                        <i class="fas fa-layer-group"></i>
                    </a>` : `
                    <a class="btn bg-primary text-white mx-3 py-1 show_text guardar_stock" title="Agregar al stock">
                        <span class="text-hiden "> Agregar a stock</span>
                        <i class="fas fa-layer-group"></i>
                    </a>
                    `}
                </div>
                ${producto.data_stock ? this.content_qr(producto.data_stock) : ""}
            </div>`;
    }
    pagos_body(nota, pagos) {
        let FUNC = new Funciones();
        let pagada = (nota.estado == 'pagado' ? true : false);
        let porcentaje = ((parseFloat(nota.total_pagado) * 100) / parseFloat(nota.total_costo)).toFixed(2);
        let restante = parseFloat(nota.total_costo);

        let pagos_c = '';
        let total_pagado = 0;
        if (pagos) {
            for (const pago of pagos) {
                total_pagado += parseFloat(pago.cantidad);
                pagos_c += `    <div class="col-md-12 px-sm-1 px-0">${this.card_pago(pago)}</div>`;
            }
        }

        let pagos_card = `
            <div class="col-12 px-sm-1 px-0">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5><b>Total de pagos</b></h5>
                                <p class="text-muted">${pagada ? "La nota esta finalizada" : "Aún no se finaliza la nota"}</p>
                            </div>
                            <div>
                            <h3 class="text-right mb-0 text-${pagada ? "success" : "warning"} fw-bold">$ ${FUNC.number_format(nota.total_costo, 2)}</h3>
                                ${!pagada ? `
                                <small class="text-muted"> Total pagado: ${FUNC.number_format(total_pagado, 2)}</small><br class="mb-0">
                                <small class="text-muted"> Total faltante: ${FUNC.number_format((restante - total_pagado), 2)}</small>` : ""}
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-${pagada ? "success" : "warning"}" style="width:${porcentaje}%" role="progressbar" aria-valuenow="${porcentaje}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p class="text-muted mb-0">Pagado</p>
                            <p class="text-muted mb-0">${porcentaje}%</p>
                        </div>
                    </div>
                    ${pagos ? `
                    <div class="card-footer pb-2 pt-1"> 
                        <a id="mostrar_pagos"><i class="fas fa-eye"></i> Mostrar pagos</a>
                    </div>`: ""}
                </div>
            </div>`;
        return (pagos_card + pagos_c);
    }
    card_pago(pago) {
        let FUNC = new Funciones();

        let fecha = pago.fecha_pago.split(" ");
        let hora = fecha[1].split(":");
        return `
            <div class="card mb-1 pagos_nota" style="display:none">
                <div class="card-body py-1">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Tipo: <b>${pago.tipo_pago.toUpperCase()}</b></h5>
                            <p class="text-muted mb-0">${fecha[0]}  ${hora[0]}:${hora[1]}</p>
                        </div>
                        <h3 class="text-success">$ ${FUNC.number_format(pago.cantidad, 2)}</h3>
                        ${(pago.comentario != '' ? `<p>${pago.comentario}</p>` : "")}
                    </div>
                </div>
                <div class="card-footer text-right py-1" data-pago="${pago.id_pago_nota_proveedor}" data-id_nota=${pago.id_nota_proveedor}>
                    <a class="text-danger eliminar_pago"><i class="fas fa-trash-alt fa-lg"></i></a>
                </div>
            </div>`;
    }
    content_qr(stock) {
        return `
            <div class="card-footer text-muted py-2 text-right" data-id_producto="${stock.codigo_materia}" data-tipo="${stock.codigo_materia}">
                <div>
                    <a class="btn bg-dark text-white py-0 mostrar_opciones" title="Ubicar en almacen">
                        <i class="fas fa-barcode fa-2x"></i>
                    </a>
                    <div class="body_opciones" style="display:none;">
                        <img class="barcode" jsbarcode-value="${stock.codigo_materia}" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold" style="width:100%;" title="${stock.codigo_materia}"/>
                    </div>
                </div>
            </div>`;
    }
}