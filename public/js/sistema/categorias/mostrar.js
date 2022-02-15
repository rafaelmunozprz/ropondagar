$(document).ready(function () {
    traer_categorias();
    $("#form_search_modelos").off().submit(function (e) {
        e.preventDefault();
        console.log('aqui')
        let form = $(this);
        let search_categorias = form.find("[name=buscador_categorias]").val();
        setTimeout(() => {
            traer_categorias(1, search_categorias);
        }, 500);
    });
});

/**
 * 
 * @param {Number} id_categoria identificador de la categoria que será eliminada
 */
function eliminar_categoria(id_categoria) {
    Swal.fire({
        title: '¿Estás seguro de eliminar está categoría?',
        text: "Está acción no puede se puede deshacer",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar categoría!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: RUTA + "back/categorias",
                data: `opcion=eliminar_categoria&idcategoria=${id_categoria}`,
                dataType: "JSON",
                error: function (xhr, status) {
                    console.log(xhr.responseText)
                },
                success: function (response) {
                    if (response.response == "success") {
                        traer_categorias()
                        Swal.fire(
                            '¡Categoría eliminada!',
                            'Tu categoría ha sido eliminada',
                            'success'
                        )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Algo salió mal, intenta nuevamente!',
                        })
                    }
                }
            });
        }
    })
}

/**
 * 
 * @param {Number} id_categoria identificador de la categoria de los articulos que serán mostrados
 */
function mostrar_articulos_categorias(id_categoria) {
    let CATEGORIAS = new Categorias()
    const CATEGORIA = id_categoria
    let MODAL_MOSTRAR_ARTICULOS = $('#modal_mostrar_productos')
    MODAL_MOSTRAR_ARTICULOS.modal('show')
    $.ajax({
        type: "POST",
        url: RUTA + "back/categorias",
        data: `opcion=cargar_articulos_categoria&id_categoria=${CATEGORIA}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response == 'success') {
                let respuesta = response.data['articulos']
                let CONTENEDOR_LISTA_ARTICULOS_CATEGORIAS = $("#contenedor_mostrar_articulo_categorias")
                CONTENEDOR_LISTA_ARTICULOS_CATEGORIAS.html(CATEGORIAS.mostrar_articulos_categorias(respuesta))
            } else {
                let CONTENEDOR_LISTA_ARTICULOS_CATEGORIAS = $("#contenedor_mostrar_articulo_categorias")
                let array_vacio = []
                CONTENEDOR_LISTA_ARTICULOS_CATEGORIAS.html(CATEGORIAS.mostrar_articulos_categorias(array_vacio))
            }
        }
    });
}

/**
 * 
 * @param {Number} id_categoria identificador de la categoria seleccionada 
 */
function elegir_accion_categorias(id_categoria) {

    const CATEGORIA = id_categoria
    let MODAL_OPCIONES = $('#modal_opciones_categoria')
    MODAL_OPCIONES.modal('show')

    $(".mostrar_productos_categoria_opciones").off().on('click', function () {
        MODAL_OPCIONES.modal("hide")
        mostrar_articulos_categorias(CATEGORIA)
    })

    $(".modificar_categoria_opciones").off().on('click', function () {
        MODAL_OPCIONES.modal("hide")
        editar_categoria(CATEGORIA)
    })

    $(".eliminar_categoria_opciones").off().on('click', function () {
        MODAL_OPCIONES.modal("hide")
        eliminar_categoria(CATEGORIA)
    })
}

/**
 * 
 * @param {Number} pagina pagina para mostrar las primeras 9 categorias PAGINACION
 * @param {String} buscar cadena LIKE que permite filtrar las categorias
 * @param {Boolean} categorias_json creacion de categorias en objeto JSON (LOCAL.STORAGE)
 */
function traer_categorias(pagina = 1, buscar = "", categorias_json = false) {
    let button = $("#paginacion");
    let contenedor = $("#contenedor_categorias");
    let borrar_ac = $("#borrar_busqueda");
    borrar_ac.parent().show();
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`);
    $.ajax({
        type: "POST",
        url: RUTA + "back/categorias",
        data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            button.parent().hide();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '¡Algo ha salido mal!',
                footer: '<a href>Error interno del sistema</a>'
            })
        },
        success: function (response) {
            if (response.response == 'success') {
                const client = new Categorias();
                const respuesta = response.data;

                button.parent().show();

                if (pagina <= 1) contenedor.html(client.mostrar_categorias(respuesta));
                else contenedor.append(client.mostrar_categorias(respuesta));
                /** Validación de más paginacion */

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
                        traer_categorias(pagina + 1, buscar);
                    }, 500);
                });

                $(".modificar_categoria").off().on('click', function () {
                    let categoria_sel = $(this);
                    elegir_accion_categorias(categoria_sel.attr("data-idcategoria"))
                });
            } else {
                button.parent().hide();
                if (pagina == 1) contenedor.html(`
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontrarón resultados de tu busqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que la categoria que estas buscando no exista</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
            }
            /* borrar_ac.off().on('click', function () {
                borrar_ac.parent().hide();
                button.parent().hide();
                contenedor.html("");
            }); */
        }
    });
}


class Categorias {
    /**
     * 
     * @param {Object} categoria 
     * @returns {HTMLElement}
     */
    cuerpo_categoria(categoria) {
        let imagen = (categoria.galeria && categoria.galeria[0].is_file ? categoria.galeria[0].imagen : "galeria/sistema/default/default_categoria.png");
        return `
        <div class="card mb-2 p-2  align-items-stretch ${categoria.tipo === 'maquila' ? 'bg-secondary text-white' : 'bg-warning text-dark'}">
            <div class="card-body py-0 c-pointer modificar_categoria " data-idcategoria="${categoria.id_categoria}">
                <div class="row align-items-center">
                    <div class="col  bg-light rounded">
                    </div>
                    <div class="col-9">
                        <span class="text-uppercase fw-bold mb-1">Categoria: <br><span>${categoria.nombre} </span> </span>
                        <p class="my-0 py-0 lh-1">Identificador: <span>${categoria.id_categoria}</span></p>
                    </div>
                </div>
            </div>
        </div>`;
    }

    /**
     * 
     * @param {JSON} categorias 
     * @returns {HTMLElement}
     */
    mostrar_categorias(categorias) {
        let cuerpo = '';
        for (const categoria of categorias) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 categoriaprima px-1" data-idcategoria="${categoria.id_categoria}">${this.cuerpo_categoria(categoria)}</div>`;
        }
        return cuerpo;
    }


    /**
     * @param {Array} articulo
     * @returns {HTMLElement}
     */
    cuerpo_articulos_categoria(articulo) {
        //console.log(articulo)
        return `
        <div class="card p-1 mb-2">
            <div class="card-body c-pointer p-1">
                <div class="d-flex ">
                    <div class="avatar" materiaprima-id="${articulo.id_materia_prima}">
                        <span class="avatar-title rounded-circle border border-dark bg-dark">${articulo.nombre}</span>
                    </div>
                    <div class="flex-1 ml-3 pt-1">
                        <span class="text-uppercase fw-bold mb-1">Materia: <span class="text-muted ">${articulo.nombre} </span> <b class="ml-3">categoria</b>: ${articulo.nombre}</span>
                        <p class="my-0 py-0 lh-1">Código:<span class="text-muted">  ${articulo.codigo}</span></p>
                        <p class="my-0 py-0 lh-1">Medida por articulo:<span class="text-muted"> ${articulo.medida} ${articulo.unidad_medida}</span></p>
                        <p class="my-0 py-0 lh-1">Color:<span class="text-muted"> ${articulo.color}</span></p>
                    </div>
                </div>
            </div>
        </div>`
    }

    /**
     * 
     * @param {Object} articulos Objeto que contiene las categorias
     * @returns {HTMLElement} retorna el mensaje en HTML para las categorias
     */
    mostrar_articulos_categorias(articulos) {
        let cuerpo = '';
        if (articulos.length > 0) {
            for (const articulo of articulos) {
                cuerpo += `<div class="col-12 materiaprima px-1" data-materiaprima="${articulo.id_materia_prima}">${this.cuerpo_articulos_categoria(articulo)}</div>`;
            }
        } else {
            cuerpo += `
            <div class="col-12">
                <div class="card card-stats card-warning card-round">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-7 col-stats text-center">
                                <div class="numbers">
                                    <p class="card-category">No se encontraron artículos con esta categoría</p>
                                    <h4 class="card-title">Continua intentando, es probable que ningún artículo de materia prima haya sido relacionado con esta categoria</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
            /* }   */

        }
        return cuerpo;
    }
}