function editar_burro(codigo_burro){
    let MODAL_EDITAR_BURRO = $("#modal_editar_burro")
    let titulo_burro = $("#burro-editar")
    titulo_burro.html(codigo_burro)
    MODAL_EDITAR_BURRO.modal("show")    

    $("#redimensionar_burro").off().on('click', function () {
        MODAL_EDITAR_BURRO.modal("hide");
        let BURRO = new Burro()
        BURRO.redimensionar_anaquel(codigo_anaquel, '#modal_editar_anaquel')
    })    
}


class Burro {
    /**
     * 
     * @param {String} codigo_burro codigo único creado para el burro que sirve como identificador
     */
    eliminar_burro(codigo_burro) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este burro?',
            text: "Está acción no puede se puede deshacer",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar burro!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let MODAL_OPCIONES_BURRO = $("#modal_opciones_burro")
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/burros",
                    data: `opcion=eliminar_burro&codigo_burro=${codigo_burro}`,
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
                                text: '¡Se ha eliminado el burro exitosamente!',
                            })
                            traer_anaqueles()
                            MODAL_OPCIONES_BURRO.modal('hide')
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Algo ha salido mal!',
                                text: `No podemos eliminar un burro con material dentro`,
                            })
                        }
                    }
                });
            }
        })
    }
    /**
     * 
     * @param {String} codigo_anaquel 
     * @param {Number} atras 
     */
    redimensionar_burro(codigo_burro, atras) {
        let MODAL_REDIMESIONAR_BURRO = $("#modal_redimensionar_burro")
        MODAL_REDIMESIONAR_BURRO.modal("show")

        Swal.fire('Está acción no se puede deshacer, realiza la operación con autorización')

        let secciones = 0, niveles = 0

        $.ajax({
            type: "POST",
            url: RUTA + "back/burros",
            data: `opcion=cargar_dimensiones&codigo_burro=${codigo_burro}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
            },
            success: function (response) {
                let tamano = response.data.dimensiones.tamano
                tamano = tamano.split(',')
                niveles = tamano[0]
                secciones = tamano[1]
                $("#redimensionar_niveles_burro").val(niveles)
                $("#redimensionar_secciones_burro").val(secciones)
            }
        });

        $("#form_redimensionar_burro").off().submit((evt) => {
            evt.preventDefault()
            let form_redimesionar_burro = $(this)
            let button_form_redimensionar_burro = form.find("[name=button_form_redimensionar_burro]")
            let text_form_redimensionar_burro = button_form_redimensionar_burro.text()
            let formulario_form_redimesionar_burro = form_redimesionar_burro.serialize()
            let redimensionar_secciones_burro = form_redimesionar_burro.find("[name=redimensionar_secciones_burro]")
            let redimensionar_niveles_burro = form_redimesionar_burro.find("[name=redimensionar_niveles_burro]")
            let error_cont = 0
            $(".has-error").removeClass("has-error")
            $(".ntf_form").remove()
            const FUNC = new Funciones()
            const EXPRESION = FUNC.EXPRESION()
            if (redimensionar_secciones_burro.val() == '' || redimensionar_secciones_burro.val() < secciones) {
                error_cont++;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Las secciones no pueden ser menores a ${secciones}`,
                })
                $("#redimensionar_secciones_burro").val(secciones)
            };
            if (redimensionar_niveles_burro.val() == '' || redimensionar_niveles_burro.val() < niveles) {
                error_cont++;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Los niveles no pueden ser menores a ${niveles}`,
                })
                $("#redimensionar_niveles_burro").val(niveles)
            };
            if (error_cont === 0) {
                $.ajax({
                    type: "POST",
                    url: RUTA + "back/burros",
                    data: `opcion=redimensionar_burro&${formulario_form_redimesionar_burro}&codigo_burro=${codigo_burro}`,
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
                                text: `Algo ha salido mal, no hemos podido redimensionar el burro ${codigo_burro}`,
                            })
                        }
                    }
                });
            }
        })
    }
    /**
     * 
     * @param {String} posicion_burro 
     */
    mostrar_articulos(posicion_burro) {
        let burro = posicion_burro.split('-')
        let contenedor = $("#contenedor_lista_burro")
        $.ajax({
            type: "POST",
            url: RUTA + "back/burros",
            data: `opcion=mostrar_materia&posicion=${posicion_burro}&codigo_burro=${burro[1]}`,
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
                    const RESPUESTA = JSON.parse(response.data.posicion_burro[0].burro)
                    const BURRO = new Burro()
                    let nombre_espacio = ""
                    for (const espacio of RESPUESTA) {
                        if (espacio.id_burro == posicion_burro) {
                            contenedor.html(BURRO.mostrar_lista_productos(espacio))
                            nombre_espacio = espacio.id_burro
                        }
                    }
                    $("#form_insertar_materia_burro").off().submit(evt => {
                        evt.preventDefault()
                        let form_insertar_materia_burro = $(this)
                        let button_form_insertar_materia_burro = form_insertar_materia_burro.find("[name=button_form_insertar_materia_burro]")
                        let text_form_insertar_materia_burro = button_form_insertar_materia_burro.text()
                        let formulario_form_insertar_materia_burro = form_insertar_materia_burro.serialize()
                        let insetar_codigo_materia = form_insertar_materia_burro.find("[name=insetar_codigo_materia]")
                        let insertar_cantidad_materia = form_insertar_materia_burro.find("[name=insertar_cantidad_materia]")
                        $(".has-error").removeClass("has-error")
                        $(".ntf_form").remove()
                        const FUNC = new Funciones()
                        const EXPRESION = FUNC.EXPRESION()
                        if (insetar_codigo_materia.val() == '') {
                            error_cont++;
                            insetar_codigo_materia.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El código no puede ser menor a 5 carácteres</small>`);
                        };
                        if (insertar_cantidad_materia.val() == '' || insertar_cantidad_materia.val() < 1) {
                            error_cont++;
                            insertar_cantidad_materia.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">La cantidad no puede ser menor a 1</small>`);
                        };
                        if (error_cont === 0) {
                            button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
                            $.ajax({
                                type: "POST",
                                url: RUTA + "back/burros",
                                data: `opcion=agregar_materia&nombre_espacio=${nombre_espacio}&${formulario}`,
                                dataType: "JSON",
                                error: function (xhr, status) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: `¡Algo ha salido mal!`,
                                        text: `${xhr.responseText}`,
                                    })
                                    button.removeClass('disabled').removeAttr('disabled').html(text_form_insertar_materia_burro);
                                },
                                success: function (response) {
                                    button.removeClass('disabled').removeAttr('disabled').html(text_form_insertar_materia_burro);
                                    if (data.response == "success") {
                                        BURRO.mostrar_articulos(nombre_espacio)
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
                        }
                    })
                }
            }
        });
    }
    /**
     * 
     * @param {String} codigo 
     */
    agregar_materia(codigo) {
        let contenedor_grid_burro = $("#contenedor_grid_burro")
        let cod = codigo
        $.ajax({
            type: "POST",
            url: RUTA + "back/burros",
            data: `opcion=mostrar_grid_burro&codigo=${cod}`,
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
                const BURRO = new Burro()
                const RESPUESTA = response.data.grid_burro
                contenedor_grid_burro.html(BURRO.mostrar_grid(RESPUESTA))
            }
        });
    }
    /**
     * 
     * @param {Array} producto 
     */
    cuerpo_lista_productos(producto) {
        return `
            <td>${producto.codigo}</td>
            <td>${producto.cantidad_disponible}</td>
            <td>${producto.id_nota}</td>
        `
    }
    /**
     * 
     * @param {Object} productos 
     */
    mostrar_lista_productos(productos) {
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
                                            <h4 class="card-title">Continua intentando, es probable que el este espacio de burro aún no tenga artículos en él</h4>
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
     * @param {Number} seccion 
     * @param {Number} nivel 
     * @param {String} id 
     * @param {Number} cantidad 
     */
    cuerpo_grid(seccion, nivel, id, cantidad) {
        let fc = id.split('-')
        return `
            <div class="p-2 ${(cantidad.length > 0) ? `bg-success` : `bg-info`} text-white rounded fc-anaquel" ${(cantidad.length > 0) ? `data-toggle="tooltip" data-placement="top" title="Contenedor ocupado"` : `data-toggle="tooltip" data-placement="top" title="Contenedor vacío"`} style="cursor: pointer;" data-nc="N${nivel + 1}S${seccion + 1}-${fc[1]}">N${nivel + 1}S${seccion + 1}</div>
        `;
    }
    /**
     * 
     * @param {Object} burros 
     */
    mostrar_grid(burros) {
        let burro_arreglo = JSON.parse(burros[0].anaquel)
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
                                        ${this.cuerpo_grid(fila, columna, burro_arreglo[contador].id_anaquel, burro_arreglo[contador].productos)}
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