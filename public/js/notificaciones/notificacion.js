class Notificaciones {

    mostrar_notificacion() {

    }
}
let container = $("#notificaciones_body");
$.ajax({
    type: "POST",
    url: RUTA + "back/notificacion",
    data: "opcion=mostrar_notificaciones",
    dataType: "JSON",
    error: function (xhr, status) { console.log(xhr.responseText); },
    success: function (data) {
        let body = "";
        if (data.status) {
            let notificacion_str = "";
            for (const notificacion of data.data) {
                notificacion_str += cuerpo_notificacion(notificacion);
            }
            body = `
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification">${data.data.length}</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" id="notifDropdown_label" aria-labelledby="notifDropdown" style="width:350px !important; max-width:400px !important;">
                    <li>
                        <div class="dropdown-title">Tienes ${data.data.length} notificaciones</div>
                    </li>
                    <li style="max-height:350px; overflow:auto; width:350 !important; max-width:400px !important;">
                        ${notificacion_str}
                    </li>                    
                    <li id="ntf_show_more">
                        <a class="see-all" href="javascript:void(0);" >Mostrar más <i class="fa fa-angle-right fa-rotate-90"></i> </a>
                    </li>
                </ul>`;
            container.html(body);

            $(".vista_notificacion").on('click', function () {
                let ntf = $(this);
                $.ajax({
                    type: "POST", url: RUTA + "back/notificacion",
                    data: `opcion=actualizar&id_ntf=${ntf.data("id_ntf")}`,
                    dataType: "JSON",
                    error: function (xhr, status) {/**console.log(xhr.responseText); */ },
                    success: function (response) {/** console.log(response);*/ }
                });
            });
        }
    }
});


function cuerpo_notificacion(notificacion) {
    let body = `
            <div class="notif-scroll scrollbar-outer" style="background-color:#c3b09120;!important">
                <div class="notif-center vista_notificacion" data-id_ntf="${notificacion.id_notificacion}">
                    <a href="${(notificacion.config.link) ? (RUTA + notificacion.config.link) : "#"}">
                        <div class="notif-icon ${notificacion.config.bg_color} text-white px-3"> <i class="${notificacion.config.icon}"></i> </div>
                        <div class="notif-content">
                            <span class="block">
                                ${notificacion.titulo}
                            </span>
                            <span class="block">
                                ${notificacion.cuerpo}
                            </span>
                            <span class="time">hace time</span>
                        </div>
                    </a>
                </div>
            </div>
        `;
    return body;
}
