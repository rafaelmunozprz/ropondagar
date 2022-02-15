class Notas_cont {
    mostrar_notas(notas) {
        let cuerpo = "";
        for (const nota of notas) {
            cuerpo += `<div class="col-12 px-md-3 px-1">${this.cuerpo_nota(nota)}</div>`;
        }
        return cuerpo;
    }
    cuerpo_nota(nota) {
        const FUNC = new Funciones();
        const cliente = nota.cliente;
        let total_costo = parseFloat(nota.total_costo)
        let total_pagado = parseFloat(nota.total_pagado);
        return `
            <div class="card p-0 mt-0 mb-1">
                <div class="card-body my-0 py-2 px-0" data-id_nota="${nota.id_nota_cliente}">
                    <div class="d-flex hoverable px-3">
                        <div class="avatar avatar-online">
                            <span class="avatar-title rounded-circle border border-white bg-info">${(cliente.razon_social[0]).toUpperCase()}</span>
                        </div >
                        <div class="flex-1 ml-3 pt-1 ">
                            <h6 class="text-uppercase fw-bold mb-1">
                                <a href="${RUTA + "sistema/clientes/" + cliente.id_cliente}"> ${(cliente.razon_social).toUpperCase()}</a> 
                                <span class="${nota.estado == 'pagado' ? "text-success" : "text-warning"} pl-3">${nota.estado}</span>
                            </h6>
                            <p class="mb-0"><span class="text-success pl-3">$ ${FUNC.number_format(total_costo, 2)}</span></p>
                            <span class="text-muted">Total: $ ${FUNC.number_format(total_costo, 2)} ${total_pagado >= total_costo ? `, Restante: $ 0.00` : `Restante: $${FUNC.number_format((total_costo - total_pagado), 2)}`}</span>
                            <p class="mb-0">${nota.pagos ? nota.pagos.length + " pagos totales" : "No se encontrarón pagos"}</p>
                        </div>
                        <div class="float-right pt-1">
                            <span class="mr-3 h5"><b>No.</b> </span><b class="text-danger">${FUNC.rellenarCero(nota.id_nota_cliente, 7)}</b><br>
                            <small class="text-muted">${nota.fecha.split(" ")[0]}</small>
                        </div>
                    </div >
                    <a href="#" class="btn btn-outline-dark fw-bold my-sm-3 my-1 py-1 px-3 accion_nota" data-accion="pago_nota">Agregar pago</a>
                    <a href="#" class="btn btn-outline-dark fw-bold my-sm-3 my-1 py-1 px-3 accion_nota" data-accion="impresion">Imprimir nota</a>
                    <a href="#" class="btn btn-outline-dark fw-bold my-sm-3 my-1 py-1 px-3 accion_nota" data-accion="mas_opciones">Más opciones</a>
                    <div class="separator-dashed"></div>
                </div>
            </div> `;
    }
}