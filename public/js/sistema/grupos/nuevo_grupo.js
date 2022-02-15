$("#nuevo_grupo").click(function (e) {
    e.preventDefault();
    let MODAL_NUEVO_GRUPO = $("#modal_nuevo_grupo");
    MODAL_NUEVO_GRUPO.modal("show")

    $("#form_nuevo_grupo").off().submit(function (e) {
        e.preventDefault();
        let form = $(this)
        let button = form.find("[name=guardar_nuevo_grupo]")

        let nombre_nuevo_grupo = $("#nombre_nuevo_grupo")
        let tipo_grupo = $("#grupo")

        let error_cont = 0
        $(".has-error").removeClass("has-error");
        $(".ntf_form").remove();

        const FUNC = new Funciones()
        const EXPRESION = FUNC.EXPRESION()

        if (nombre_nuevo_grupo.val() == '' || nombre_nuevo_grupo.val().length < 5 || !((EXPRESION.num_sup_text).test(nombre_nuevo_grupo.val()))) {
            error_cont++;
            nombre_nuevo_grupo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El nombre no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        };
        if (tipo_grupo.val() == '' || tipo_grupo.val().length < 5 || !((EXPRESION.num_sup_text).test(tipo_grupo.val()))) {
            error_cont++;
            tipo_grupo.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El grupo no puede estar vacio o ser menor a 3 caracteres recuerda que solo debes de utilizar letras de la A-Z y áéíóúüÁÉÍÓÚÜ.</small>`);
        };
        if(error_cont === 0){
            let GRUPOS = new Grupos()
            GRUPOS.nuevo_grupo(nombre_nuevo_grupo.val(), tipo_grupo.val())
        }
    });

});