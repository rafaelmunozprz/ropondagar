$(document).ready(function () {
    let id_proveedor = $("#id_proveedor").val();

    /**
     * El filtro avanzado es para reutilizar codigo solo aplicando los filtros correspondientes en donde se usen estos archivos
     * @Perfil del proveedor
     * @todas las notas del proveedor
     */
    let filtro_avanzado = ""; // Este agregara más opcines de filtrado
    filtro_avanzado = (id_proveedor != '' ? `&id_proveedor=${id_proveedor}` : ""); //Si se te ocurre algo concatenalo aquí

    estadisticas(filtro_avanzado);
});
function estadisticas(filtro = "") {
    let contenedor = $("#contenedor_estadisticas");
    $.ajax({
        type: "POST",
        url: RUTA + "back/proveedores/nota",
        data: "opcion=estadisticas&" + filtro,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
        },
        success: function (data) {
            console.log(data);
            let FUNC = new Funciones();

            let body = "";
            let est = data.data;
            body += `<div class="col px-1" style="min-width:200px; max-width:200px;">${cuerpo_estadistica(est.notas[0].notas, "Notas generadas")}</div>`;
            body += `<div class="col px-1" style="min-width:200px; max-width:200px;">${cuerpo_estadistica(est.pagos_nota[0].pagos, "Total de pagos")}</div>`;
            body += `<div class="col px-1" style="min-width:250px; max-width:280px;">${cuerpo_estadistica("$ " + FUNC.number_format(est.notas[0].total_costo, 2), "Total de ingreso de notas")}</div>`;
            body += `<div class="col px-1" style="min-width:250px; max-width:280px;">${cuerpo_estadistica("$ " + FUNC.number_format(est.notas[0].total_pagado, 2), "Total pagado de las notas")}</div>`;
            body += `<div class="col px-1" style="min-width:250px; max-width:280px;">${cuerpo_estadistica("$ " + FUNC.number_format((parseFloat(est.notas[0].total_costo) - parseFloat(est.notas[0].total_pagado)), 2), "Falta de pago", false)}</div>`;
            contenedor.css("min-width", "1200px");

            contenedor.html(body);


        }
    });
    function cuerpo_estadistica(valor, tipo, positivo = true) {

        return `<div class="card mb-2">
                    <div class="card-body p-3 text-center">
                        <div class="text-right ">
                            ${positivo ? `<i class="fa fa-chevron-up text-success"></i>` : `<i class="fas fa-arrow-down text-warning"></i>`}
                        </div>
                        <div class="h1 m-0">${valor}</div>
                        <div class="text-muted mb-3">${tipo}</div>
                    </div>
                </div>`;
    }
}