$(document).ready(function(){
    const TRAER_NOTAS_MODELOS_VIEJOS = new Nota_Modelo_viejo()
    TRAER_NOTAS_MODELOS_VIEJOS.traer_nota_modelos_viejos();
    $("#form_search_nota_modelo_viejo").off().submit(e=>{
        e.preventDefault();
        let form_search_nota_modelo_viejo = $(this)
        let buscador_nota_modelo_viejo = form_search_nota_modelo_viejo.find("[name=buscador_nota_modelo_viejo]").val()
        setTimeout(() => {
            TRAER_NOTAS_MODELOS_VIEJOS.traer_nota_modelos_viejos(1, buscador_nota_modelo_viejo)
        }, 500);
    })
})