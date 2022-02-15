/**
 * 
 * @param {Number} id_grupo_trabajo identificador del grupo en la base de datos
 */
function editar(id_grupo_trabajo){
    let GRUPOS = new Grupos()
    GRUPOS.cargar_grupo(id_grupo_trabajo)

    $("#form_editar_grupo").submit(function(e){
        e.preventDefault()
        let form = $(this)
        let button = form.find("[name=guardar_nuevo_grupo]")
        let text = button.text()

        let editar_nombre_grupo = $("#editar_nombre_grupo")
        let editar_estado_grupo = $("#editar_estado_grupo")

        let error_cont = 0
        $(".has-error").removeClass("has-error");
        $(".ntf_form").remove();

        const FUNC = new Funciones()
        const EXPRESION = FUNC.EXPRESION()

        if (editar_nombre_grupo.val() == '' || editar_nombre_grupo.val().length < 5 || !((EXPRESION.num_sup_text).test(editar_nombre_grupo.val()))) {
            error_cont++;
            editar_nombre_grupo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        };
        if (editar_estado_grupo.val() == '' || editar_estado_grupo.val().length < 3 || !((EXPRESION.sup_text).test(editar_estado_grupo.val()))) {
            error_cont++;
            editar_estado_grupo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El estado no puede estar vacio o ser menor a 5 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        };
        if(error_cont === 0){
            button.addClass('disabled').attr('disabled', 'disabled').html('Enviando... <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span>');
            let GRUPOS = new Grupos()
            GRUPOS.editar_grupo(id_grupo_trabajo, editar_nombre_grupo.val(), editar_estado_grupo.val())
        }
    })
}