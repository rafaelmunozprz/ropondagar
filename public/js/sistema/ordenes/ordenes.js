/**
 * @class clase que contiene los modelos para contendores dinámicos dentro de las ordenes
 */
class Ordenes {

    /**
     * 
     * @param {Object} ordenes objeto con todas las ordenes con estado 17_finalizado
     * @returns {HTMLElement} elemnto de la lista de las ordenes finalizadas <tr></tr>
     */
    cuerpo_mostrar_ordenes_finalizadas(ordenes) {
        let cuerpo = ''
        const FUNC = new Funciones()
        for (const orden of ordenes) {
            let fecha = FUNC.fechaFormato(orden.fecha)
            cuerpo += `
                <tr>
                    <td><span class="badge badge-danger">Finalizado</span></td>
                    <td>#${orden.uuid}</td>
                    <td>${fecha[0]} de ${FUNC.MESES(fecha[1])}, ${fecha[2]} a las ${FUNC.HORA(orden.fecha.split(" ")[1])}</td>
                    <td>
                        <button class="btn btn-warning ver_orden_finalizada" ver_orden_finalizada="${orden.uuid}">Ver Orden</button>
                    </td>
                </tr>
            `
        }

        return cuerpo
    }

    /**
     * 
     * @param {String} estado 
     */
    cuerpo_grupo(orden) {
        let button = '', grupo = ''
        switch (orden.estado) {
            case '1_inicio_preparacion':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="2_fin_preparacion" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Preparación</button>`
                grupo = 'Preparción material'
                break
            case '2_fin_preparacion':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="3_inicio_corte" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Preparación</button>`
                grupo = 'Preparción material'
                break
            case '3_inicio_corte':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="4_fin_corte" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Corte</button>`
                grupo = 'Corte'
                break
            case '4_fin_corte':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="5_inicio_prebordado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Corte</button>`
                grupo = 'Corte'
                break
            case '5_inicio_prebordado':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="6_fin_prebordado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Prebordado</button>`
                grupo = 'Bordado'
                break
            case '6_fin_prebordado':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="7_inicio_bordado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Prebordado</button>`
                grupo = 'Bordado'
                break
            case '7_inicio_bordado':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="8_fin_bordado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Bordado</button>`
                grupo = 'Bordado'
                break
            case '8_fin_bordado':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="9_inicio_maquila" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Bordado</button>`
                grupo = 'Bordado'
                break
            case '9_inicio_maquila':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="10_fin_maquila" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Maquila</button>`
                grupo = 'Maquila'
                break
            case '10_fin_maquila':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="11_inicio_ojal_y_boton" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Maquila</button>`
                grupo = 'Maquilla'
                break
            case '11_inicio_ojal_y_boton':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="12_fin_ojal_y_boton" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Ojal</button>`
                grupo = 'Ojal y botón'
                break
            case '12_fin_ojal_y_boton':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="13_inicio_deshebre" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Ojal</button>`
                grupo = 'Ojal y botón'
                break
            case '13_inicio_deshebre':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="14_fin_deshebre" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Deshebre</button>`
                grupo = 'Deshebre'
                break
            case '14_fin_deshebre':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="15_inicio_planchado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Deshebre</button>`
                grupo = 'Deshebre'
                break
            case '15_inicio_planchado':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="16_fin_planchado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar Planchado</button>`
                grupo = 'Planchado'
                break
            case '16_fin_planchado':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="17_inicio_terminado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar Planchado</button>`
                grupo = 'Planchado'
                break
            case '17_inicio_terminado':
                button = `<button class="btn btn-success siguiente_estado" siguiente_estado="18_fin_terminado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Iniciar terminado</button>`
                grupo = 'Terminado'
                break
            case '18_fin_terminado':
                button = `<button class="btn btn-danger siguiente_estado" siguiente_estado="19_finalizado" uuid="${orden.uuid}" estado_proceso="${orden.estado}">Terminar</button>`
                grupo = 'Terminado'
                break
        }
        return { button: button, grupo: grupo }
    }

    /**
     * 
     * @param {JSON} ordenes 
     */
    cuerpo_mostrar_ordenes_produccion(ordenes) {
        let cuerpo = ''
        const FUNC = new Funciones()
        if (ordenes.lenth === 1) console.log('aqui')
        for (const orden of ordenes) {
            let { button, grupo } = this.cuerpo_grupo(orden)
            let fecha = FUNC.fechaFormato(orden.fecha)
            let progreso = FUNC.progreso(orden.estado.split('_')[0])
            let estilo = FUNC.estiloProgressBar(progreso)
            cuerpo += `
                <tr>
                    <td>${grupo}</td>
                    <td>${orden.uuid}</td>
                    <td>${fecha[0]} de ${FUNC.MESES(fecha[1])}, ${fecha[2]}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar ${estilo}" style="width:${progreso}%" role="progressbar"></div>
                        </div>
                    </td>
                    <td class="text-center ver_orden_espera" ver_orden_espera="${orden.uuid}"><button class="btn btn-warning">Ver Orden</button></td>
                    <td class="text-center">${button}</td>
                </tr>
            `
        }
        return cuerpo
    }
    /**
     * 
     * @param {Object} articulos objeto que contiene la lista de articulos de una orden en espera
     * @returns {HTMLElement} porción de la tabla HTML de los articulos en una orden en espera
     */
    cuerpo_articulos_orden_espera(articulos) {
        let cuerpo = ''
        for (const articulo of articulos) {
            cuerpo += `
                <tr>
                    <td>${articulo.codigo}</td>
                    <td>${articulo.cantidad}</td>
                </tr>
            `
        }
        return cuerpo
    }

    /**
     * 
     * @param {*} modelo modelo que es mostrado para su asignación a la lista de una nueva orden de producción
     * @returns {HTMLElement} porción del contenedor que muestra los detalles de un artículo de los articulos en una orden en espera
     */
    cuerpo_modelo_lista(modelo) {
        let cuerpo = ''
        cuerpo += `
        <div class="col-12 anadir_modelo px-1 p-2" data-idmodelo="${modelo.id_modelo}">
            <div class="card mb-1 c-pointer" model-id=${modelo.id_modelo}>
                <div class="card-body p-1 ">
                    <div class="d-flex ">
                        <div class="avatar avatar-offline">
                            <span class="avatar-title rounded-circle border border-white bg-default">+</span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold my-0 py-0 lh-2">Nombre: <span class="text-muted">${(modelo.nombre).toUpperCase()}</span></h6>
                            <p class="my-0 py-0 lh-1"><b>COLOR:</b><span class="text-muted"> ${(modelo.color.toUpperCase())} </span> <b>TALLA:</b><span class="text-muted"> ${(modelo.talla.toUpperCase())}</span> <b>TIPO:</b><span class="text-muted"> ${(modelo.tipo.toUpperCase())}</span></p>                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
        return cuerpo
    }

    /**
     * 
     * @returns {HTMLElement} respuesta HTML en caso de no haber alguna coincidencia con algún modelo buscado
     */
    cuerpo_modelos_lista_error() {
        return `
        <div class="col-12">
            <div class="card card-stats card-warning card-round">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-7 col-stats text-center">
                            <div class="numbers">
                                <p class="card-category">No se encontrarón resultados de tu búsqueda</p>
                                <h4 class="card-title">Continua intentando, es probable que el modelo que estás buscando no exista</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    }

    /**
     * 
     * @param {Object} orden_espera Objeto que contiene los detalles de un orden en espera
     * @returns {HTMLElement} porción de la tabla HTML las ordenes en espera
     */
    cuerpo_lista_ordenes_espera(orden_espera) {
        let FUNC = new Funciones();
        let cuerpo = ''
        if (orden_espera.length === 0) {
            cuerpo = `
                <tr>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                    <td class="bg-warning">Sin resultados</td>
                </tr>
            `
        } else {
            for (const articulo of orden_espera) {
                let fecha = FUNC.fechaFormato(articulo.fecha)
                cuerpo += `
                    <tr>
                        <td>Corte</td>
                        <td># ${articulo.uuid}</td>
                        <td>${fecha[0]} de ${FUNC.MESES(fecha[1])}, ${fecha[2]} a las ${FUNC.HORA(articulo.fecha.split(" ")[1])}</td>
                        <td class="text-center ver_orden_espera" ver_orden_espera="${articulo.uuid}"><button class="btn btn-warning">Ver Orden</button></td>
                        <td class="text-center iniciar_orden_espera" iniciar_orden_espera="${articulo.uuid}"><button class="btn btn-primary">Iniciar</button></td>
                        <td class="text-danger text-center eliminar_orden_espera" eliminar_orden_espera="${articulo.uuid}"><i class="fas fa-trash-alt"></i></td>
                    </tr>
                `
            }
        }
        return cuerpo;
    }
}