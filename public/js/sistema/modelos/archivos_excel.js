$("#excel_hoy").off().on('click', function (e) {
    e.preventDefault()
    let form = $("#form_historial_hoy")
    let codigo = form.find("[name=buscador]").val()
    crear_excel_hoy(codigo)
})

$("#excel_ayer").off().on('click', function (e) {
    e.preventDefault()
    let form = $("#form_historial_ayer")
    let codigo = form.find("[name=buscador]").val()
    crear_excel_ayer(codigo)
})

$("#excel_siete_dias").off().on('click', function (e) {
    e.preventDefault()
    let form = $("#form_historial_siete_dias")
    let codigo = form.find("[name=buscador]").val()
    crear_excel_siete_dias(codigo)
})

$("#excel_treinta_dias").off().on('click', function (e) {
    e.preventDefault()
    let form = $("#form_historial_treinta_dias")
    let codigo = form.find("[name=buscador]").val()
    crear_excel_treinta_dias(codigo)
})

$("#excel_siempre").off().on('click', function (e) {
    e.preventDefault()
    let form = $("#form_historial_siempre")
    let codigo = form.find("[name=buscador]").val()
    crear_excel_siempre(codigo)
})

/**
 * 
 * @param {String} codigo identificador único del codigo, la respuesta invluye todas las coincidencias 
 */
function crear_excel_hoy(codigo) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=excel_hoy&buscar=${codigo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                Swal.fire(
                    '¡Excelente!',
                    '¡Descarga Exitosa!',
                    'success'
                )
                if (codigo != '') {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte por codigo= ${codigo}.xls`);
                    $a[0].click();
                    $a.remove();
                } else {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte.xls`);
                    $a[0].click();
                    $a.remove();
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡No hemos encontrado ninguna coincidencia!',
                })
            }
        }
    });
}

/**
 * 
 * @param {String} codigo identificador único del codigo, la respuesta invluye todas las coincidencias 
 */
function crear_excel_ayer(codigo) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=excel_ayer&buscar=${codigo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                Swal.fire(
                    '¡Excelente!',
                    '¡Descarga Exitosa!',
                    'success'
                )
                if (codigo != '') {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte dia anterior por codigo= ${codigo}.xls`);
                    $a[0].click();
                    $a.remove();
                } else {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte dia anterior.xls`);
                    $a[0].click();
                    $a.remove();
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡No hemos encontrado ninguna coincidencia!',
                })
            }
        }
    });
}

/**
 * 
 * @param {String} codigo identificador único del codigo, la respuesta invluye todas las coincidencias 
 */
function crear_excel_siete_dias(codigo) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=excel_siete_dias&buscar=${codigo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                Swal.fire(
                    '¡Excelente!',
                    '¡Descarga Exitosa!',
                    'success'
                )
                if (codigo != '') {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte semanal por codigo= ${codigo}.xls`);
                    $a[0].click();
                    $a.remove();
                } else {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte semanal.xls`);
                    $a[0].click();
                    $a.remove();
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡No hemos encontrado ninguna coincidencia!',
                })
            }
        }
    });
}

/**
 * 
 * @param {String} codigo identificador único del codigo, la respuesta invluye todas las coincidencias 
 */
function crear_excel_treinta_dias(codigo) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=excel_treinta_dias&buscar=${codigo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                Swal.fire(
                    '¡Excelente!',
                    '¡Descarga Exitosa!',
                    'success'
                )
                if (codigo != '') {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte mensual por codigo= ${codigo}.xls`);
                    $a[0].click();
                    $a.remove();
                } else {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte mensual.xls`);
                    $a[0].click();
                    $a.remove();
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡No hemos encontrado ninguna coincidencia!',
                })
            }
        }
    });
}

/**
 * 
 * @param {String} codigo identificador único del codigo, la respuesta invluye todas las coincidencias 
 */
function crear_excel_siempre(codigo) {
    $.ajax({
        type: "POST",
        url: RUTA + "back/modelos",
        data: `opcion=excel_siempre&buscar=${codigo}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText)
        },
        success: function (response) {
            if (response.response === 'success') {
                Swal.fire(
                    '¡Excelente!',
                    '¡Descarga Exitosa!',
                    'success'
                )
                if (codigo != '') {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte global por codigo= ${codigo}.xls`);
                    $a[0].click();
                    $a.remove();
                } else {
                    let $a = $("<a>");
                    $a.attr("href", response.file);
                    $("body").append($a);
                    $a.attr("download", `Reporte global.xls`);
                    $a[0].click();
                    $a.remove();
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡No hemos encontrado ninguna coincidencia!',
                })
            }
        }
    });
}
