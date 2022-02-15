$('#agregar_materia').off().on('click', function () {
    MODAL_EDITAR_BURRO.modal("hide");
    const BURRO = new Burro();
    BURRO.agregar_materia(codigo_anaquel)
})