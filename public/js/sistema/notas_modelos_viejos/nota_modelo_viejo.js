class Nota_Modelo_viejo {

    traer_nota_modelos_viejos(pagina = 1, buscar = "", notas_modelos_viejos_json = false) {
        let button = $("#paginacion")
        let contenedor = $("#contenedor_notas_modelos_viejos")
        let borrar_ac = $("#borrar_busqueda")
        borrar_ac.parent().show();
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`)
        $.ajax({
            type: "POST",
            url: RUTA + "back/notas_modelos_viejos",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                button.parent().hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    const nota_modelo_viejo = new Nota_Modelo_viejo()
                    const respuesta = response.data;
                    button.parent().show();
                    if (!notas_modelos_viejos_json) notas_modelos_viejos_json = respuesta
                    else for (const modelo of respuesta) { notas_modelos_viejos_json.push(modelo) }


                    if (pagina <= 1) contenedor.html(nota_modelo_viejo.nota_modelos_viejos(respuesta));
                    else contenedor.append(nota_modelo_viejo.nota_modelos_viejos(respuesta));

                    let paginar = true;
                    let pg = response.pagination; //Paginacion
                    let limite = (pg.page * pg.limit);
                    if (limite >= pg.total) paginar = false;

                    if (!paginar) button.parent().hide();

                    button.off().on('click', function () {
                        let button = $(this);
                        button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                        button.off();
                        setTimeout(() => {
                            let TRAER_MODELOS = new Nota_Modelo_viejo()
                            TRAER_MODELOS.traer_nota_modelos_viejos(pagina + 1, buscar, notas_modelos_viejos_json);
                        }, 500);
                    });

                    /* $(".modificar_modelo_viejo").off().on('click', function () {
                        let modelo_viejo = $(this);
                        let OPCIONES = new ModelosViejos()
                        OPCIONES.modificar_modelo_viejo(modelo_viejo.attr("model-id"))
                        let OPCIONES = new ModelosViejos()
                        OPCIONES.opciones_modelos_viejos(modelo_viejo.attr("model-id"))
                    }); */
                } else {
                    button.parent().hide();
                    if (pagina == 1) contenedor.html(`
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
    cuerpo_lista_productos(articulo) {
        let cuerpo = ``, total = 0, subtotal = 0
        for (const item of articulo) {
            subtotal = 0
            cuerpo+=`
            <tr class="no_p">
                <td class="no_p">${item.cantidad}</td>
                <td class="no_p">${item.modelo}</td>
                <td class="no_p">$ ${item.precio_menudeo}</td>
            </tr>`
            subtotal += (item.cantidad*item.precio_menudeo)
            total += (parseInt(subtotal))
        }
        return [cuerpo, total]
    }
    cuerpo_modelos_viejos(nota_modelo_viejo) {
        const NOTA = new Nota_Modelo_viejo()
        let cliente = JSON.parse(nota_modelo_viejo.cliente);
        let productos = JSON.parse(nota_modelo_viejo.articulos);
        console.log(productos)
        const FUNC = new Funciones();
        let fecha = FUNC.fechaFormato(nota_modelo_viejo.fecha_registro)
        let dia = fecha[0], mes = FUNC.MESES(fecha[1])
        let cuerpo_lista_productos = NOTA.cuerpo_lista_productos(productos);
        let cuerpo = `
        <div class="card mb-1 c-pointer model_id_nota_modelo_viejo" model_id_nota_modelo_viejo=${nota_modelo_viejo.id_venta_modelo_viejo}>
            <div class="card-body p-1 ">
                <div class="d-flex ">
                    <div class="avatar avatar-offline">
                        <span class="avatar-title rounded-circle border border-white bg-default">+</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <h6 class="text-uppercase fw-bold my-0 py-0 lh-2 mb-1 text-danger">FOLIO: ${nota_modelo_viejo.id_venta_modelo_viejo}</h6>
                        <h6 class="text-uppercase fw-bold my-0 py-0 lh-2">Cliente: <span class="text-muted">${cliente.razon_social}</span></h6>
                        <p class="my-0 py-0 lh-1"><b>FECHA:</b><span class="text-muted"> ${dia} de ${mes}, ${fecha[2]} </span> <b>TOTAL: $ </b><span class="text-muted"> ${cuerpo_lista_productos[1]}</span></p>
                        <p class="my-0 py-0 lh-1"></span></p>
                        <p class="my-0 py-0 lh-1"></p>
                        <table class="table">
                            <tbody>
                                <tr class="no_p">
                                    <td class="no_p">Cantidad</td>
                                    <td class="no_p">Modelo</td>
                                    <td class="no_p">Precio</td>
                                </tr>
                                ${cuerpo_lista_productos[0]}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>`;
        return cuerpo;
    }
    nota_modelos_viejos(modelos_viejos) {
        //console.log(modelos_viejos)
        let cuerpo = '';
        for (const modelo of modelos_viejos) {
            cuerpo += `<div class="col-md-6 col-12">${this.cuerpo_modelos_viejos(modelo)}</div>`;
        }
        return cuerpo;
    }
}