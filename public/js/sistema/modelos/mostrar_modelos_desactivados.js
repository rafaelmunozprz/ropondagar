/**
 * 
 * @param {Number} pagina 
 * @param {String} buscar 
 * @param {JSON} historial 
 */
function traer_modelos_desactivados(pagina = 1, buscar = "", historial = false) {
    let button = $("#paginacion_desactivados")
    let contenedor_modelos_desactivados = $("#contenedor_modelos_desactivados")
    let borrar_ac = $("#borrar_busqueda")
    borrar_ac.parent().show()
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`)
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=mostrar_desactivados&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
            button.parent().hide()
        },
        success: function (response) {
            if (response.response === 'success') {
                const MODELOS = new Modelos()
                const respuesta = response.data

                button.parent().show()

                if (pagina <= 1) contenedor_modelos_desactivados.html(MODELOS.mostrar_modelos_desactivados(respuesta))
                else contenedor_modelos_desactivados.append(MODELOS.mostrar_modelos_desactivados(respuesta))

                let paginar = true
                let pg = response.pagination
                let limite = (pg.page * pg.limit)
                if (limite >= pg.total) paginar = false

                if (!paginar) button.parent().hide()

                $(".modelo_desactivado").off().on('click', function (e) {
                    e.preventDefault()
                    let modelo = $(this)
                    let id_modelo = modelo.attr('data-idmodelo')
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡Esta acción reactivara este modelo!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Si, reactivar modelo!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: RUTA + "back/modelos",
                                data: `opcion=reactivar_modelo&id_modelo=${id_modelo}`,
                                dataType: "JSON",
                                error: function (xhr, status) {
                                    console.log(xhr.responseText)
                                },
                                success: function (response) {
                                    if (response.response === 'success') {
                                        Swal.fire(
                                            '¡Activado!',
                                            'El modelo está activado, este se mostrará en la pestaña Modelos',
                                            'success'
                                        )
                                        traer_modelos()
                                        traer_modelos_desactivados()
                                    } else {
                                        Swal.fire(
                                            '¡Error!',
                                            'El modelo no se ha podido activar',
                                            'error'
                                        )
                                    }
                                }
                            });

                        }
                    })
                })

                button.off().on('click', function () {
                    let button = $(this);
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                    button.off();
                    setTimeout(() => {
                        traer_modelos_desactivados(pagina + 1, buscar);
                    }, 500);
                });
            } else {
                button.parent().hide();
                if (pagina == 1) contenedor_modelos_desactivados.html(`
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontraron resultados de tu búsqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que no haya modelos desactivados</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
            }
        }
    });
}