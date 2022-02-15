$("#eliminar_burro").off().on('click', function () {
    MODAL_EDITAR_BURRO.modal("hide");
    let BURRO = new Burro()
    BURRO.eliminar_anaquel(codigo_anaquel)
})