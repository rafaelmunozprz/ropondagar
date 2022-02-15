function disminuir(id_modelo) {
    let MODAL_DISMINUIR_STOCK = $("#modal_disminuir_stock")
    MODAL_DISMINUIR_STOCK.modal('show')

    $("#form_disminuir_stock").off().submit(function (e) {
        e.preventDefault();
        let form = $(this)
        let button = form.find('button');
        let text = button.text();

        let formulario = form.serialize();
        let disminuir_stock = form.find("[name=disminuir_stock]");
        let error_cont = 0;
        $(".has-error").removeClass("has-error");
        $(".ntf_form").remove();

        const FUNC = new Funciones();
        const EXPRESION = FUNC.EXPRESION();
        if (disminuir_stock.val() == '' || disminuir_stock.val().length < 0) {
            error_cont++;
            disminuir_stock.parent().addClass("has-error").append(`<small class="text-danger ntf_form" class="form-text text-muted">El stock no puede estar vacio o ser menor a 0</small>`);
        };
        if (error_cont === 0) {
            let DISMINUIR = new Modelos()
            DISMINUIR.desminuir_stock(id_modelo, disminuir_stock.val())
        }
    })
}