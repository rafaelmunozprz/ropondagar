$(document).ready(function () {
    let GRUPOS = new Grupos()
    GRUPOS.mostrar_grupos();
    $("#form_search_grupos").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_grupos = form.find("[name=buscador_grupos]").val();
        setTimeout(() => {
            GRUPOS.mostrar_grupos(1, search_grupos);
        }, 500);
    });
});