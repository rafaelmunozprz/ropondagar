$(document).ready(function () {
    let id_nota = $("#id_nota").val();
    let folio = $("#folio").val();
    traer_nota(id_nota).then(function () {
        let enviar = true;
        $("#facturar").click(function (e) {
            e.preventDefault();
            let button = $(this);
            let completos = true;
            let datos_fiscales = [];
            $(".fiscal_data").each(function (index, element) {
                let valor_fiscal = $(element).find(".codigo_fiscal").val();
                let tipo = $(element).data("tipo");
                let id_p = $(element).data("id");
                console.log(tipo, id_p);
                if (valor_fiscal == '') { completos = false; }
                datos_fiscales.push({ id: id_p, tipo: tipo, codigo_fiscal: valor_fiscal });
            });

            if (!completos) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: `Es necesario completar correctamente todos los códigos fiscales de la nota`,
                })
            } else {
                let text = `<i class="fas fa-paper-plane fa-sm pr-2"></i> FACTURAR`;
                let loading = `<div class="spinner-border" role="status"><span class="visually-hidden"></span></div> Enviando..`;
                button.html(loading).addClass("disabled").attr("disabled", "disabled");
                if (enviar) {
                    enviar = false;
                    $.ajax({
                        type: "POST",
                        url: RUTA + `back/timbrado/venta/${folio}`,
                        data: `opcion=facturar&folio=${folio}&id_nota=${id_nota}&datos_fiscales=${JSON.stringify(datos_fiscales)}`,
                        dataType: "JSON",
                        error: function (xhr, status) {
                            console.log(xhr.responseText);
                            button.html(text).removeClass("disabled").removeAttr("disabled", "disabled");
                        },
                        success: function (data) {
                            if (data.status) {
                                //Solamente vuelve a enviar la peticion para descomprimir todo esta programado en la ruta, no necesitas evaluar respuesta
                                $.ajax({ type: "POST", url: RUTA + `back/timbrado/unzip/${folio}`, });
                                /** */

                                setTimeout(() => {
                                    let modal = $("#modal_dowload_cfdi");
                                    let archivos = data.data.documentos;
                                    // console.log(archivos);
                                    modal.modal("show");
                                    modal.find("#descargar_zip").attr('href', RUTA + archivos.zip);
                                    modal.find("#descargar_pdf").attr('href', RUTA + archivos.pdf);
                                    modal.find("#descargar_xml").attr('href', RUTA + archivos.xml);

                                    enviar = true;
                                    button.html(text).removeClass("disabled").removeAttr("disabled", "disabled");
                                }, 1000);
                            } else {
                                toastr['error'](data.text);
                                enviar = true;
                                button.html(text).removeClass("disabled").removeAttr("disabled", "disabled");
                            }
                        }
                    });
                } else {
                    toastr['warning']('Por favor permite que el proceso finalice');
                }
            }
        });
        $(".codigo_fiscal").change(function (e) {
            e.preventDefault();
            console.log($(this).val());
        });
    });
});




async function traer_nota(id_nota) {
    let form = new FormData();
    form.append("opcion", 'mostrar_nota');
    form.append("id_nota", id_nota);
    form.append("traer_store", 'true');

    const response = await
        enviar_datos(form).then((response) => {
            if (response.response == 'success') {
                let cuerpo_invoice = $("#cuerpo_invoice");
                let INV = new Invoice();
                cuerpo_invoice.html(INV.body(response.data));
                if (response.data.nota.estado != 'pagado') {
                    toastr['error']("No es posible facturar una nota que no esta pagada en su totalidad");
                }
                return (response = true);
            } else {
                toastr['error'](response.text);
                return (response = true);
            }
        }).catch((err) => {
            console.log(err)
            toastr['error']("Error de respuesta del servidor");
            return (false);
        });

    return response;
}
async function enviar_datos(formulario) {
    const response = await
        fetch(RUTA + 'back/cliente/nota_venta', {
            method: 'POST',
            body: formulario,
        }).then(function (response) {
            return response.json();
        }).then(function (data) {
            return data;
        }).catch(function (err) {
            console.error('ERROR', err);
            return { "error": "Error interno del servidor" };
        });
    return response;
}