$(document).ready(function(){
    const TRAER_MODELO = new ModelosViejos()
    TRAER_MODELO.traer_modelos_viejos();
    $("#form_search_modelo_viejo").off().submit(e=>{
        e.preventDefault();
        let form_search_modelo_viejo = $(this)
        let search_modelo_viejo = form_search_modelo_viejo.find("[name=buscador_modelo_viejo]").val()
        setTimeout(() => {
            TRAER_MODELO.traer_modelos_viejos(1, search_modelo_viejo)
        }, 500);
    })
})