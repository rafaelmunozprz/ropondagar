$(document).ready(function () {
    $("#cerrarSesion").on('click', function (e) {
        e.preventDefault();
        let button = $(this).find('button');
        button.html(`<div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div>Saliendo ... `);
        button.attr('disabled', 'disabled');
        button.addClass('disabled');
        var formulario = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: RUTA + 'back/login',
            data: 'opcion=cerrarSesion',
            dataType: 'json',
            error: function (xhr, status) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Por el momento no es posible acceder',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    button.html("Cerrar Sesión");
                    button.removeAttr('disabled');
                    button.removeClass('disabled');
                }, 1000);
            },
            success: function (data) {
                if (data.response == 'exito') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data.text,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setInterval(() => { location.reload() }, 1500);
                } else {
                    Swal.fire(
                        'Alerta!',
                        data.text,
                        'error'
                    );
                }
                setTimeout(() => {
                    button.html("Cerrar Sesión");
                    button.removeAttr('disabled');
                    button.removeClass('disabled');
                }, 1000);
                // grecaptcha.reset();

            }
        });
    });
});