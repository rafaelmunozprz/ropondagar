$(document).ready(function () {
    traer_nota();
});

function traer_nota() {
    const temp_note = new Storage('venta_notas');
    const constr_nota = new ModelNota();
    const FUNC = new Funciones(); // @/js/models/funciones.js

    let nota = temp_note.mostrar_nota();


    const container = $("#contenedor_nota");
    let nota_body = constr_nota.invoice(nota);
    container.html(nota_body);

    let totales = constr_nota.totales(nota);

    let total_c = $("#total_nota");
    total_c.find(".cantidad").html(totales.productos);
    total_c.find(".total").html(FUNC.number_format((totales.iva ? totales.iva : totales.total), 2));

    edicion_nota();

}




function edicion_nota() {
    const note = new Storage('venta_notas');

    $(".eliminar_elemento").on('click', function (e) {
        e.preventDefault();
        let button = $(this);
        let id = button.parent().parent().data('id');
        let tipo = button.parent().parent().data('tipo');
        note.borrar_elemento(id, tipo);
        toastr['success']("Se elimino el elemento correctamente");
        traer_nota();
    });

    $(".editar_elemento").change(function (e) {
        e.preventDefault();
        let button = $(this);
        let content = button.parent().parent();
        let id = content.data('id');
        let tipo = content.data('tipo');

        let cantidad = content.find(".cantidad").val();
        let costo = content.find(".costo").val();

        let nota = note.mostrar_nota();
        let producto = false;

        for (const prod of nota.productos)
            if (prod.id == id && prod.tipo == tipo) producto = prod;

        if (producto) {
            producto.precio_venta = costo;
            producto.cantidad = cantidad;
            let response = note.actualizar_producto(producto);
            if (response.status) {
                toastr["success"]("Productos actualizados");
            } else {
                toastr['error'](response.text)
            }
            traer_nota();
        } else {
            toastr["error"]("No fue posible actualizar los datos");
        }

    });

    //@js/sistema/ventas/nota/descuentos.js
    $(".descuento_accion").on("click", function (e) {
        e.preventDefault();
        const modal = $("#modal_descuento");
        modal.modal("show");
    });
    $("#agregar_iva").on('change', function () {
        let check = $(this);
        let nota = note.mostrar_nota();
        if (check.is(":checked")) nota.iva = true;
        else nota.iva = false;
        note.guardar_nota(JSON.stringify(nota)); //Guardamos el cambio
        traer_nota();
    });
    $("#config_cliente").on('click', function (e) {
        let modal = $("#modal_config_cliente");
        modal.modal('show');
    });
    $("#limpiar_cliente").on('click', function (e) {
        let nota = note.mostrar_nota();
        nota.usuario.id = false;
        nota.usuario.data = false;
        nota.usuario.tipo = false;
        note.guardar_nota(JSON.stringify(nota));
        traer_nota();
    })

    $("#limpiar_nota_venta").click(function (e) {
        e.preventDefault();
        note.borrar_nota();
        traer_nota();
    });

}