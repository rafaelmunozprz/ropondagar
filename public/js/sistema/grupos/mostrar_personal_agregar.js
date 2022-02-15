/**
 * 
 * @param {Number} id_grupo_trabajo identificador unico del grupo en la base de datos
 */
function mostrar_personal_agregar(id_grupo_trabajo) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/grupos",
        data: `opcion=mostrar_personal_agregar`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '¡Algo ha salido mal!',
            })
        },
        success: function (response) {
            if (response.response == 'success') {
                let contenedor = $("#contenedor_usuarios_agregar")
                let USUARIOS = new Grupos()
                contenedor.html(USUARIOS.lista_usuarios(response.data))
                $("#form_agregar_personal").submit(function (e) {
                    e.preventDefault();
                    let form = $(this)
                    let users_id = form.find("[name=user_id]")
                    let users = []
                    for (const user of users_id) {
                        if (user.checked) users.push({ user_id: user.value })
                    }
                    if (users.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡No podemos guardar grupos de trabajo sin personal!',
                        })
                    } else {
                        agregar(users, id_grupo_trabajo)
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.text,
                })
            }
        }
    });
}