class SendMail {
    enviar_correo(cliente, nota, descuento, button) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/email/notatest",
            data: `opcion=enviar_nota_correo&cliente=${cliente}&datos=${nota}&descuento=${descuento}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                button.removeClass('disabled').removeAttr('disabled').html('<i class="fas fa-paper-plane mx-3"></i></span>Enviar correo con el ticket');
                $.notify(
                    { icon: 'fas fa-exclamation-circle', title: 'Error al enviar el correo', message: "Error interno del servidor", },
                    { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
                // $("#modal_notificacion").modal('hide');
            },
            success: function (response) {
                button.removeClass('disabled').removeAttr('disabled').html('<i class="fas fa-paper-plane mx-3"></i></span>Enviar correo con el ticket');
                if (response.response == 'success') {
                    $.notify(
                        { icon: 'fas fa-check-circle', title: "Correo enviado", message: response.text, },
                        { type: 'success', placement: { from: "top", align: "right" }, time: 1500, });
                } else {
                    $.notify(
                        { icon: 'fas fa-exclamation-circle', title: 'Error al enviar el correo', message: response.text, },
                        { type: "warning", placement: { from: "top", align: "right" }, time: 1500, });
                }
                // $("#modal_notificacion").modal('hide');
            }
        });
    }
}
class SendMailPDF {
    guardar_pdf(cliente, nota, descuento) {
        $.ajax({
            type: "POST",
            url: RUTA + "sistema/notas/pdfmail",
            data: `opcion=enviar_pdf&cliente=${cliente}&datos=${nota}&descuento=${descuento}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                $.notify(
                    { icon: 'fas fa-exclamation-circle', title: 'Error crear el ticket', message: "Error interno del servidor", },
                    { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
            },
            success: function (response) {
                if (response.response == 'success') {
                    $.notify(
                        { icon: 'fas fa-check-circle', title: "Ticket generado", message: response.text, },
                        { type: 'success', placement: { from: "top", align: "right" }, time: 1500, });
                } else {
                    $.notify(
                        { icon: 'fas fa-exclamation-circle', title: 'Error generar ticket', message: response.text, },
                        { type: "warning", placement: { from: "top", align: "right" }, time: 1500, });
                }
                // $("#modal_notificacion").modal('hide');
            }
        });
    }
}

class Venta {
    vender(cliente, nota, descuento) {
        $.ajax({
            type: "POST",
            url: RUTA + "sistema/notas/vender",
            data: `opcion=vender&cliente=${cliente}&datos=${nota}&descuento=${descuento}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                $.notify(
                    { icon: 'fas fa-exclamation-circle', title: 'Error crear el ticket', message: "Error interno del servidor", },
                    { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
            },
            success: function (response) {
                if (response.response == 'success') {
                    $.notify(
                        { icon: 'fas fa-check-circle', title: "Venta registrada con éxito", message: response.text, },
                        { type: 'success', placement: { from: "top", align: "right" }, time: 1500, });
                } else if(response.response == 'warning'){
                    $.notify(
                        { icon: 'fas fa-exclamation-circle', title: 'Error al registrar la venta', message: response.text, },
                        { type: "warning", placement: { from: "top", align: "right" }, time: 1500, });
                }
            }
        })
    }
}
class SendZebra {
    guardar_archivo(cliente, nota, descuento) {
        $.ajax({
            type: "POST",
            url: RUTA + "sistema/notas/facturazpl",
            data: `opcion=enviar_nota_correo&cliente=${cliente}&datos=${nota}&descuento=${descuento}`,
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText);
                $.notify(
                    { icon: 'fas fa-exclamation-circle', title: 'Error crear el ticket', message: "Error interno del servidor", },
                    { type: "danger", placement: { from: "top", align: "right" }, time: 1500, });
            },
            success: function (response) {
                if (response.response == 'success') {
                    $.notify(
                        { icon: 'fas fa-check-circle', title: "Ticket generado", message: response.text, },
                        { type: 'success', placement: { from: "top", align: "right" }, time: 1500, });
                } else {
                    $.notify(
                        { icon: 'fas fa-exclamation-circle', title: 'Error generar ticket', message: response.text, },
                        { type: "warning", placement: { from: "top", align: "right" }, time: 1500, });
                }
                // $("#modal_notificacion").modal('hide');
            }
        });
    }
}