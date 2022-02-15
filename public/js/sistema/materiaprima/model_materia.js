class Materias {

    /**
     * 
     * @param {Array.<string>} materia lista de caracteristicas de dicha materia prima
     * @returns {HTMLElement} retorna un elemento HTMLElement con la información de dicha materia prima
     */
    cuerpo_materia(materia) {
        let total = (materia.cantidad - materia.vendido);
        let color = ''
        switch (materia.color) {
            case 'blanco':
                color = `style="background-color: #e1edf0; color: black;"`
                break;
            case 'kaki':
                color = `style="background-color: #c3b091; color: black;"`
                break;
            case 'perla':
                color = `style="background-color: #eae6ca; color: black;"`
                break;
            default:
                color = `style="background-color: white; color: black;"`
                break;
        }
        return `
            <div class="card p-1 mb-2" ${color}>
                <div class="card-body c-pointer  p-1">
                    <div class="d-flex ">
                        <div class="avatar" materia-id="${materia.id_materia_prima}">
                            <span class="avatar-title rounded-circle border border-dark bg-dark" >${materia.nombre[0]}</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <span class="text-uppercase fw-bold mb-1">Materia: <span class="text-muted ">${materia.nombre} </span> <br><b>categoria</b>: ${materia.categoria}</span>
                            <p class="my-0 py-0 lh-1">Código:<span class="text-muted">  ${materia.codigo}</span></p>
                            <p class="my-0 py-0 lh-1">Medida por materia:<span class="text-muted"> ${materia.medida} ${materia.unidad_medida}</span></p>
                            <p class="my-0 py-0 lh-1">Color:<span class="text-muted"> ${materia.color}</span></p>
                            <p class="my-0 py-0 lh-1">${total >= 1 ? `<b>Disponibles:</b> <span class="text-success"> ${total}</span>` : `<b class="text-danger">Sin Stock</b>`}</p>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    /**
     * 
     * @param {JSON} materias objeto con todas las materias primas diponibles
     * @returns {HTMLElement} conjunto de materias disponibles en formato HTMLElement
     */
    mostrar_materias(materias) {
        let cuerpo = '';
        for (const materia of materias) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 materiaprima px-1" data-idmateria="${materia.id_materia_prima}">${this.cuerpo_materia(materia)}</div>`;
        }
        return cuerpo;
    }

    /**
     * 
     * @param {JSON} materias objeto con toda la informacion del STOCK de la materia prima
     * @returns {HTMLElement} objeto DIV que contiene todo el stock de un articulo en particular
     */
    mostrar_stock(materias) {
        let cuerpo = '';
        for (const materia of materias) {
            cuerpo += this.cuerpo_stock(materia);
        }
        cuerpo = `<div class="col-12 px-1 text-justify table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <td class="no_p">Codigo</td>
                                    <td class="no_p">Restante</td>
                                    <td class="no_p">Datos</td>
                                </tr>
                            </thead>
                            <tbody>
                                ${cuerpo}
                            </tbody>
                        </table>
                    </div>`;
        return cuerpo;
    }

    /**
     * 
     * @param {JSON} materia objeto con toda la informacion del STOCK de la materia prima
     * @returns {HTMLElement} objeto DIV que contiene todo el stock de un articulo en particular
     */
    cuerpo_stock(materia) {
        const func = new Funciones();
        let total = (materia.cantidad - materia.vendido);
        return `
            <tr>
                <td class="no_p">
                    ${materia.codigo}<br>
                    <img class="barcode" jsbarcode-value="${materia.codigo}" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold" style="width:100%; max-width:270px;" title="${materia.codigo}"/><br>
                </td>
                <td class="no_p">${total}</td>
                <td class="no_p" style="min-width:190px;">
                    <table class="table">
                        <tr>
                            <td class="no_p" style="width:80px;">Compra</td>
                            <td class="no_p">$ ${func.number_format(materia.precio_menudeo, 2)}</td>
                        </tr>
                        <tr>
                            <td class="no_p" style="width:80px;">Menudeo</td>
                            <td class="no_p">$ ${func.number_format(materia.precio_menudeo, 2)}</td>
                        </tr>
                        <tr>
                            <td class="no_p" style="width:80px;">Mayoreo</td>
                            <td class="no_p">$ ${func.number_format(materia.precio_menudeo, 2)}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="no_p bg-dark" colspan="3"></td>
            </tr>
            
            `;
    }
}