$(document).ready(function () {
    $("#calculo_descuento").submit(function (e) { e.preventDefault(); });

    $("#guardar_descuento").on('click', function () {
        let cont_form = $("#calculo_descuento");
        let variables = cont_form.serialize().split("&");
        let resp = {
            tipo: "cantidad",
            cantidad: 0
        };
        for (const i in variables) {
            let new_var = variables[i];
            new_var = new_var.split("=");
            if (new_var[0] == 'tipodescuento') resp.tipo = new_var[1];
            else if (new_var[0] == 'cantidad') resp.cantidad = (new_var[1] ? new_var[1] : 0);
        }
        const STOR = new Storage('venta_notas');
        let nota = STOR.mostrar_nota();
        nota.descuentos = resp;
        STOR.guardar_nota(JSON.stringify(nota));
        traer_nota();
        $("#modal_descuento").modal('hide');
    });

});