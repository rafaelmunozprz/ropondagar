/**
 * 
 * @param {String} codigo_anaquel Parametro recibido al contendor en donde son mostrados
 * todos los anaqueles dados de alta ANA-'codido del anaquel'
 */
function editar_anaquel(codigo_anaquel) {

    let MODAL = $("#modal_editar_anaquel");
    let titulo_anaquel = $("#anaquel-editar");
    titulo_anaquel.html(codigo_anaquel);
    MODAL.modal("show");

    $('#agregar_materia').off().on('click', function () {
        MODAL.modal("hide");
        const GRID = new GridAnaquel();
        GRID.agregar_materia(codigo_anaquel)
    })

    $("#redimensionar_anaquel").off().on('click', function () {
        MODAL.modal("hide");
        let REDIMENSIONAR = new GridAnaquel()
        REDIMENSIONAR.redimensionar_anaquel(codigo_anaquel, '#modal_editar_anaquel')
    })

    $("#eliminar_anaquel").off().on('click', function () {
        MODAL.modal("hide");
        let ELIMINAR = new GridAnaquel()
        ELIMINAR.eliminar_anaquel(codigo_anaquel)
    })


}

class GridAnaquel {
    eliminar_anaquel(codigo_anaquel) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este anaquel?',
            text: "Está acción no puede se puede deshacer",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar anaquel!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let MODAL_OPCIONES = $("#modal_editar_anaquel");
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/anaqueles",
                    data: `opcion=eliminar_anaquel&codigo_anaquel=${codigo_anaquel}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `¡Algo ha salido mal!`,
                            text: `${xhr.responseText}`,
                        })
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Excelente',
                                text: '¡Se ha eliminado el anaquel exitosamente!',
                            })
                            traer_anaqueles()
                            MODAL_OPCIONES.modal('hide')
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo ha salido mal!',
                                text: `No podemos eliminar un anaquel con material dentro`,
                            })
                        }
                    }
                });
            }
        })

    }
    redimensionar_anaquel(codigo_anaquel, atras) {

        let MODAL_REDIMENSIONAR_ANAQUEL = $("#modal_redimensionar_anaquel")
        MODAL_REDIMENSIONAR_ANAQUEL.modal("show")

        $("#buttonAtrasRA").on('click', function () {
            MODAL_REDIMENSIONAR_ANAQUEL.modal("hide")
        })

        Swal.fire('Está acción no se puede deshacer, realiza la operación con autorización')

        let filas = 0
        let columnas = 0

        $.ajax({
            type: "POST",
            url: RUTA + "back/anaqueles",
            data: `opcion=cargar_dimensiones&codigo_anaquel=${codigo_anaquel}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
            },
            success: function (response) {
                let tamano = response.data.dimensiones.tamano
                tamano = tamano.split(',')
                filas = tamano[0]
                columnas = tamano[1]
                $("#redimensionar_filas_anaquel").val(filas)
                $("#redimensionar_columnas_anaquel").val(columnas)
            }
        });

        $("#form_redimensionar_anaquel").off().submit(function (evt) {
            evt.preventDefault()
            let form = $(this)
            let button = form.find("[name=buttonGuardar]")
            let text = button.text()
            let formulario = form.serialize()
            let redimensionar_columnas_anaquel = form.find("[name=redimensionar_columnas_anaquel]")
            let redimensionar_filas_anaquel = form.find("[name=redimensionar_filas_anaquel]")
            let error_cont = 0
            $(".has-error").removeClass("has-error")
            $(".ntf_form").remove()
            const FUNC = new Funciones()
            const EXPRESION = FUNC.EXPRESION()
            if (redimensionar_filas_anaquel.val() == '' || redimensionar_filas_anaquel.val() < filas) {
                error_cont++;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Las filas no pueden ser menores a ${filas}`,
                })
                $("#redimensionar_filas_anaquel").val(filas)
            };
            if (redimensionar_columnas_anaquel.val() == '' || redimensionar_columnas_anaquel.val() < columnas) {
                error_cont++;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Las columnas no pueden ser menores a ${columnas}`,
                })
                $("#redimensionar_columnas_anaquel").val(columnas)
            };
            if (error_cont === 0) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/anaqueles",
                    data: `opcion=redimensionar_anaquel&${formulario}&codigo_anaquel=${codigo_anaquel}`,
                    dataType: "JSON",
                    error: function (xhr, status) {
                        console.log(xhr.responseText)
                    },
                    success: function (response) {
                        if (response.response == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Cambio realizado!',
                                text: `${response.text}`,
                            })
                        } else if (response.response == 'igual') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: `${response.text}`,
                            })
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: `Algo ha salido mal, no hemos podido actualizar el anaquel ${codigo_anaquel}`,
                            })
                        }
                    }
                });
            }
        })

    }
    /**
     * 
     * @param {String} posicion_anaquel F#C#-codigo, identidicador del apartado exacto que mostrara su contenido
     */
    mostrar_articulo_grid(posicion_anaquel) {
        let anaquel = posicion_anaquel.split('-')
        let contenedor = $("#contenedor_lista")
        $.ajax({
            type: "POST",
            url: RUTA + "back/anaqueles",
            data: `opcion=mostrar_materia&posicion=${posicion_anaquel}&codigo_anaquel=${anaquel[1]}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
            },
            success: function (response) {
                if (response.response != "warning") {
                    const respuesta = JSON.parse(response.data.posicion_anaquel[0].anaquel);
                    const ANAQUEL = new GridAnaquel()
                    let nombre_espacio = ""
                    for (const espacio of respuesta) {
                        if (espacio.id_anaquel == posicion_anaquel) {
                            contenedor.html(ANAQUEL.mostrar_lista(espacio))
                            nombre_espacio = espacio.id_anaquel
                        }
                    }
                    $("#form_insterar_materia_espacio").off().submit(function (e) {
                        e.preventDefault()
                        let form = $(this)
                        let button = form.find("[name=buttonGuardarArticulo]")
                        let text = button.text()
                        let formulario = form.serialize()
                        let contenedor_codigo_materia = form.find("[name=contenedor_codigo_materia]")
                        let contenedor_agregar_cantidad = form.find("[name=contenedor_agregar_cantidad]")
                        let error_cont = 0
                        $(".has-error").removeClass("has-error")
                        $(".ntf_form").remove()
                        const FUNC = new Funciones()
                        const EXPRESION = FUNC.EXPRESION()
                        if (contenedor_codigo_materia.val() == '') {
                            error_cont++;
                            contenedor_codigo_materia.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El código no puede ser menor a 5 carácteres</small>`);
                        };
                        if (contenedor_agregar_cantidad.val() == '' || contenedor_agregar_cantidad.val() < 1) {
                            error_cont++;
                            contenedor_agregar_cantidad.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La cantidad no puede ser menor a 1</small>`);
                        };
                        if (error_cont === 0) {
                            button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                            $.ajax({
                                type: "POST",
                                url: RUTA + "back/anaqueles",
                                data: `opcion=agregar_materia&nombre_espacio=${nombre_espacio}&${formulario}`,
                                dataType: "JSON",
                                error: function (xhr, status) {
                                    console.log(xhr.responseText)
                                    button.removeClass('disabled').removeAttr('disabled').html(text);
                                },
                                success: function (data) {
                                    button.removeClass('disabled').removeAttr('disabled').html(text);

                                    if (data.response == "success") {
                                        ANAQUEL.mostrar_articulo_grid(nombre_espacio)
                                        Swal.fire({
                                            title: 'Material agregado',
                                            icon: 'success',
                                            html: `<p>${data.text}<br></p>`,
                                            showCloseButton: true,
                                            showCancelButton: false,
                                            focusConfirm: false,
                                            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                                        });
                                        /**Limpieza de los campos */
                                    } else {
                                        Swal.fire({
                                            title: 'Material no agregado',
                                            icon: 'warning',
                                            html: `<p>${data.text}<br></p>`,
                                            showCloseButton: true,
                                            showCancelButton: false,
                                            focusConfirm: false,
                                            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Continuar!',
                                        });
                                    }
                                }
                            });
                        } else { }
                    })
                    let atras = document.getElementById('atras-lista-materia')
                    atras.classList.add("data-atrasLM")
                    atras.setAttribute('data-atrasLM', anaquel[1])
                    let MODAL_BUSCAR = $("#modal_lista_materia")
                    MODAL_BUSCAR.modal("show");

                    $(".data-atrasLM").off().on('click', function () {
                        let data_atrasLM = $(this);
                        editar_anaquel(data_atrasLM.attr("data-atrasLM"))
                        let modal_buscar_contenedor = $("#modal_buscar_contenedor")
                        MODAL_BUSCAR.modal("hide")
                        modal_buscar_contenedor.modal('show')
                    })
                } else {
                    $.notify({
                        icon: 'fas fa-exclamation-circle',
                        title: 'Campo no encontrado',
                        message: response.text,
                    }, {
                        type: "danger",
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        time: 1500,
                    });
                }
            }
        });

    }

    /**
     * 
     * @param {String} codigo Es el código correspondiente al anaquel
     * que es extraido del titulo_anaquel
     */
    agregar_materia(codigo) {
        let contenedor = $("#contenedor_grid");
        let cod = codigo
        $.ajax({
            type: "POST",
            url: RUTA + "back/anaqueles",
            data: `opcion=mostrar_grid&codigo=${cod}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
            },
            success: function (response) {
                const ANAQUEL = new GridAnaquel()
                const respuesta = response.data.grid_anaquel;
                let atras = document.getElementById('atras-insertar-materia')
                atras.classList.add('data-atrasIM')
                atras.setAttribute('data-atrasIM', cod)
                contenedor.html(ANAQUEL.mostrar_grid(respuesta))
                let MODAL2 = $("#modal_buscar_contenedor")
                MODAL2.modal("show");

                $("#form_buscar_contenedor").off().submit((evt) => {
                    evt.preventDefault()
                    let form = $(this)
                    let fc_anaquel = $("#fc-anaquel").val()
                    let error_cont = 0
                    $(".has-error").removeClass("has-error")
                    $(".ntf_form").remove()
                    const FUNC = new Funciones()
                    ANAQUEL.mostrar_articulo_grid(fc_anaquel)
                    MODAL2.modal("hide")
                })
                $(".data-atrasIM").off().on('click', function () {
                    let data_atrasIM = $(this);
                    editar_anaquel(data_atrasIM.attr("data-atrasIM"))
                    MODAL2.modal("hide")
                })
                $(".fc-anaquel").off().on('click', function () {
                    let fc_anaquel = $(this);
                    ANAQUEL.mostrar_articulo_grid(fc_anaquel.attr("data-fc"))
                    MODAL2.modal("hide")
                })

            }
        });
    }

    /**
     * 
     * @param {Object} producto información independiente de cada artículo en un espacio de almacenamiento
     */
    cuerpo_lista(producto) {
        return `
                        <td>${producto.codigo}</td>
                        <td>${producto.cantidad_disponible}</td>
                        <td>${producto.id_nota}</td>
        `
    }

    /**
     * 
     * @param {Array} productos Arreglo de todos los productos que se encuentran en un contenedor
     */
    mostrar_lista(productos) {
        let articulos = productos.productos

        if (articulos.length > 0) {
            let cuerpo = ""
            cuerpo += ` <div class="table-responsive">
                            <table class="table table-striped ">
                                <thead>
                                    <th>Código</th>
                                    <th>Stock Disponible</th>
                                    <th>ID Nota</th>
                                </thead>
                                <tbody>`
            for (const producto of articulos) {
                cuerpo += `          <tr>`
                cuerpo += this.cuerpo_lista(producto)
                cuerpo += `          </tr>`
            }
            cuerpo += `         </tbody>
                            </table>
                        </div>`
            return cuerpo
        } else {
            let cuerpo = ""
            cuerpo += `
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontraron resultados de tu búsqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que el este espacio de anaquel aún no tenga artículos en él</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            `
            return cuerpo
        }

    }

    /**
     * 
     * @param {Number} fila fila correspondiente al espacio de anaquel
     * @param {Number} columna columna correspondiente al espacio de anaquel
     * @param {String} id  codigo correspondiente al anaquel
     * @returns String que contiene un DIV con la fila y columna correspondiente al tamaño del anaquel
     */
    cuerpo_grid(fila, columna, id, cantidad) {
        let fc = id.split('-')
        return `
            <div class="p-2 ${(cantidad.length > 0) ? `bg-success` : `bg-info`} text-white rounded fc-anaquel" ${(cantidad.length > 0) ? `data-toggle="tooltip" data-placement="top" title="Contenedor ocupado"` : `data-toggle="tooltip" data-placement="top" title="Contenedor vacío"`} style="cursor: pointer;" data-fc="F${fila + 1}C${columna + 1}-${fc[1]}">F${fila + 1}C${columna + 1}</div>
        `;
    }

    /**
     * 
     * @param {Object} anaqueles objeto que contiene toda la informacion del anaquel
     * @returns vista que será mostrado en el MODAL2 = $("#modal_buscar_contenedor")
     */
    mostrar_grid(anaqueles) {
        let anaquel_arreglo = JSON.parse(anaqueles[0].anaquel)
        let tamano = anaqueles[0].tamano
        let dimesiones = tamano.split(',')
        let cuerpo = ""
        let contador = 0
        cuerpo += ` <div class="table-responsive">
                        <table class="table">                            
                            <tbody>`
        for (let fila = 0; fila < dimesiones[0]; fila++) {
            cuerpo += `         <tr>`;
            for (let columna = 0; columna < dimesiones[1]; columna++) {
                cuerpo += `
                                    <td>
                                        ${this.cuerpo_grid(fila, columna, anaquel_arreglo[contador].id_anaquel, anaquel_arreglo[contador].productos)}
                                    </td>`;
                contador++
            }
            cuerpo += `         </tr>`;
        }
        cuerpo += `          </tbody>
                        </table>
                    </div>`
        return cuerpo;
    }
}