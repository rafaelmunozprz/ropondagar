class Grupos {

    /**
     * 
     * @param {Array.<string>} usuarios lista de usuarios que pertenecen a el grupo seleccionado
     * @returns {HTMLElement} objeto HTMLElement con la lista de usuarios pertenecientes al grupo
     */
    cuerpo_mostrar_usuarios_encargados(usuarios) {
        let cuerpo = ``
        for (const usuario of usuarios) {
            cuerpo += `
                <tr>
                    <td>${usuario.nombre.toUpperCase()} ${usuario.apellidos.toUpperCase()}</td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="radio" value="${usuario.id_grupo_usuario}" name="id_encargado" class="custom-control-input" id="id_encargado_${usuario.id_grupo_usuario}">
                            <label class="custom-control-label" for="id_encargado_${usuario.id_grupo_usuario}"> Encargado</label>
                        </div>
                    </td>
                </tr>
            `
        }
        return cuerpo
    }

    /**
     * 
     * @param {Number} id_grupo_trabajo identificador unico del grupo para poder sacarlo de la base de datos
     */
    eliminar_grupo(id_grupo_trabajo) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/usuarios",
            data: `opcion=eliminar_grupo&id_grupo_trabajo=${id_grupo_trabajo}`,
            dataType: "JSON",
            error: function (xhr, status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Estado ${status}`
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    let GRUPOS = new Grupos()
                    GRUPOS.mostrar_grupos()
                    Swal.fire(
                        '¡Grupo eliminado!',
                        response.text,
                        'success'
                    )
                } else {
                    Swal.fire(
                        '¡Error!',
                        response.text,
                        'error'
                    )
                }
            }
        });
    }

    /**
     * 
     * @param {Number} id_grupo_trabajo carga los datos actuales de un grupo para poder ser modificados
     */
    cargar_grupo(id_grupo_trabajo) {
        let editar_nombre_grupo = $("#editar_nombre_grupo")
        let editar_estado_grupo = $("#editar_estado_grupo")
        $.ajax({
            type: "POST",
            url: RUTA + "back/grupos",
            data: `opcion=cargar_grupo&id_grupo_trabajo=${id_grupo_trabajo}`,
            dataType: "JSON",
            error: function (xhr, status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Estado ${status}`
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    editar_nombre_grupo.val(response.data[0].nombre_grupo)
                    editar_estado_grupo.val(response.data[0].estado)
                } else {
                    let MODAL_EDITAR_GRUPO = $("#modal_editar_grupo_trabajo")
                    MODAL_EDITAR_GRUPO.modal("hide")
                    Swal.fire(
                        '¡Error!',
                        response.text,
                        'error'
                    )
                }
            }
        });
    }

    /**
     * 
     * @param {String} nombre nombre del nuevo grupo de trabajo
     * @param {String} tipo_grupo tipo grupo del grupo que puede ser activo o inactivo
     */
    nuevo_grupo(nombre, tipo_grupo) {
        let MODAL_NUEVO_GRUPO = $("#modal_nuevo_grupo");
        let nombre_nuevo_grupo = $("#nombre_nuevo_grupo")
        let grupo = $("#tipo_grupo")
        $.ajax({
            type: "POST",
            url: RUTA + "back/grupos",
            data: `opcion=nuevo_grupo&nombre=${nombre}&tipo_grupo=${tipo_grupo}`,
            dataType: "JSON",
            error: function (xhr, status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Estado ${status}`
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    Swal.fire(
                        '¡Grupo creado!',
                        response.text,
                        'success'
                    )
                    nombre_nuevo_grupo.val('')
                    grupo.val('preparacion')
                    MODAL_NUEVO_GRUPO.modal("hide")
                } else {
                    MODAL_NUEVO_GRUPO.modal("hide")
                    nombre_nuevo_grupo.val('')
                    tipo_grupo.val('preparacion')
                    Swal.fire(
                        '¡Error!',
                        response.text,
                        'error'
                    )
                }
            }
        });
    }

    /**
     * 
     * @param {Number} id_grupo_trabajo identificador único del grupo
     * @param {String} nombre_grupo nombre del grupo que se ha solicitado con la consulta
     * @param {String} estado_grupo estado con el cual se indica si el grupo es activo o inactivo
     */
    editar_grupo(id_grupo_trabajo, nombre_grupo, estado_grupo) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/grupos",
            data: `opcion=editar&id_grupo_trabajo=${id_grupo_trabajo}&nombre_grupo=${nombre_grupo}&estado=${estado_grupo}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Estado ${status}`
                })
            },
            success: function (response) {
                let GRUPOS = new Grupos()
                let editar_nombre_grupo = $("#editar_nombre_grupo")
                let editar_estado_grupo = $("#editar_estado_grupo")
                let MODAL_EDITAR_GRUPO = $("#modal_editar_grupo_trabajo")
                MODAL_EDITAR_GRUPO.modal("hide")
                if (response.response == 'success') {
                    Swal.fire(
                        '¡Grupo creado!',
                        response.text,
                        'success'
                    )
                    MODAL_EDITAR_GRUPO.modal("hide")
                    GRUPOS.mostrar_grupos()
                    editar_nombre_grupo.val('')
                    editar_estado_grupo.val('activo')
                } else {
                    MODAL_EDITAR_GRUPO.modal("hide")
                    editar_nombre_grupo.val('')
                    editar_estado_grupo.val('activo')
                    Swal.fire(
                        '¡Error!',
                        response.text,
                        'error'
                    )
                }
            }
        });
    }

    /**
     * 
     * @param {Array.<string>} users lista de usuarios que serán agregados al gripo
     * @param {Number} id_grupo_trabajo identificador correspondiente al grupo
     */
    agregar_personal(users, id_grupo_trabajo) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/grupos",
            data: `opcion=agregar_personal&id_grupo_trabajo=${id_grupo_trabajo}&users=${JSON.stringify(users)}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
            },
            success: function (response) {
                if (response.response === 'success') {
                    console.log(response)
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: `${response.text}`,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Algo ha salido mal!',
                        footer: `${response.text}`
                    })
                }
            }
        });
    }

    eliminar_personal() {
        $.ajax({
            type: "POST",
            url: RUTA + "back/grupos",
            data: `opcion=`,
            dataType: "JSON",
            error: function (xhr, status) {

            },
            success: function (response) {

            }
        });
    }

    /**
     * 
     * @param {Number} pagina pagina que indica el numero de veces que se han solicitado los productos
     * @param {String} buscar contiene el nombre del grupo
     * @param {JSON} grupos_json objeto de cada uno de los elementos que se tienen con la consulta
     */
    mostrar_grupos(pagina = 1, buscar = "", grupos_json = false) {
        let button = $("#paginacion")
        let contenedor = $("#contenedor_grupos")
        let borrar_ac = $("#borrar_busqueda")
        borrar_ac.parent().show()
        button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`)
        $.ajax({
            type: "POST",
            url: RUTA + "back/grupos",
            data: `opcion=mostrar&pagina=${pagina}&buscar=${buscar}`,
            dataType: "JSON",
            error: function (xhr, status) {
                button.parent().hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo ha salido mal!',
                    text: `Estado: ${status}`
                })
            },
            success: function (response) {
                if (response.response == 'success') {
                    const GRUPOS = new Grupos()
                    const respuesta = response.data

                    button.parent().show()
                    if (!grupos_json) grupos_json = respuesta
                    else for (const grupo of respuesta) { grupos_json.push(grupo) }

                    if (pagina <= 1) contenedor.html(GRUPOS.grupos(respuesta));
                    else contenedor.append(GRUPOS.grupos(respuesta));

                    let paginar = true;
                    let pg = response.pagination; //Paginacion
                    let limite = (pg.page * pg.limit);
                    if (limite >= pg.total) paginar = false;
                    if (!paginar) button.parent().hide();

                    button.off().on('click', function () {
                        let button = $(this)
                        button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`);
                        button.off()
                        setTimeout(() => {
                            GRUPOS.mostrar_grupos(pagina + 1, buscar, grupos_json)
                        }, 500)
                    })
                    $(".data_id_grupo").off().on('click', function () {
                        let grupo_trabajo = $(this);
                        opciones(grupo_trabajo.attr("data_id_grupo"))
                    });
                } else {
                    button.parent().hide()
                    if ((pagina == 1)) contenedor.html(`
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontrarón resultados de tu búsqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que el grupo que estás buscando no exista</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`)
                }
                borrar_ac.off().on('click', function () {
                    borrar_ac.parent().hide();
                    button.parent().hide();
                    contenedor.html("");
                });
            }
        });
    }

    /**
     * 
     * @param {JSON} grupo objeto que contiene el grupo individual con estado activo e inactivo
     * @returns {HTMLElement} HTMLElement con el grupo individual que será dibujado
     */
    cuerpo_grupo(grupo) {
        let imagen = "galeria/sistema/default/teamwork.png";
        let cuerpo = `
        <div class="card mb-2 p-2">
            <div class="card-body py-0 c-pointer data_id_grupo" data_id_grupo="${grupo.id_grupo_trabajo}">
                <div class="row align-items-center">
                <div class="col pl-0">
                    <a ><img src="${RUTA + imagen}" alt="" class="w-100"></a>
                </div>
                    <div class="col-9">
                        <span class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted ">${grupo.nombre_grupo} </span> </span>
                        <p class="my-0 py-0 lh-1">Código:<span class="text-muted">  ${grupo.id_grupo_trabajo}</span></p>
                        <p class="my-0 py-0 lh-1">Estado:<span class="text-muted"> ${grupo.estado}</span></p>
                    </div>
                </div>
            </div>
        </div>`
        return cuerpo
    }

    /**
     * 
     * @param {Array.<string>} grupos objeto que tiene los grupos con estado activo e inactivo
     * @returns {HTMLElement} objeto HTMLElement con la información de los grupos de trabajo que será dibujada
     */
    grupos(grupos) {
        let cuerpo = ``
        for (const grupo of grupos) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 px-1" data_id_grupo="${grupo.id_grupo_trabajo}">${this.cuerpo_grupo(grupo)}</div>`;
        }
        return cuerpo
    }

    /**
     * 
     * @param {JSON} usuario elemento individual de un usuario de personal
     * @returns {HTMLElement} objeto HTMLElement que se contendrá la información de un solo usuario
     */
    cuerpo_lista_usuarios(usuario) {
        let cuerpo = ``
        cuerpo += `
            <td>${(usuario.nombre.toUpperCase())} ${(usuario.apellidos.toUpperCase())}</td>
            <td>
                <div class="custom-control custom-switch">
                    <input type="checkbox" value="${usuario.id_usuario}" name="user_id" class="custom-control-input" id="user_id_${usuario.id_usuario}">
                    <label class="custom-control-label" for="user_id_${usuario.id_usuario}"> Estado</label>
                </div>
            </td>`;
        return cuerpo
    }

    /**
     * 
     * @param {Array.<string>} usuarios arreglo de usuarios que serán mostrados como disponibles en la selelección de personal
     * @returns {HTMLElement} objeto html que dibujará la lista de personal
     */
    lista_usuarios(usuarios) {
        let cuerpo = ``
        for (const usuario of usuarios) {
            cuerpo += `<tr>${this.cuerpo_lista_usuarios(usuario)}</tr>`;
        }
        return cuerpo
    }
}