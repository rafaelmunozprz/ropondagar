$(document).ready(function () {
    traer_anaqueles();
    $("#form_search_anaqueles").off().submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let search_anaqueles = form.find("[name=buscador_anaqueles]").val();
        setTimeout(() => {
            traer_anaqueles(1, search_anaqueles);
        }, 500);
    });
});

function traer_anaqueles(pagina = 1, buscar = "") {
    let button = $("#paginacion");
    let contenedor = $("#contenedor_anaqueles");
    let borrar_ac = $("#borrar_busqueda");
    borrar_ac.parent().show();
    button.html(`Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i>`)
    $.ajax({
        type: "POST",
        url: RUTA + "back/anaqueles",
        data: `opcion=mostrar_anaqueles&pagina=${pagina}&buscar=${buscar}`,
        dataType: "JSON",
        error: function (xhr, status) {
            console.log(xhr.responseText);
            button.parent().hide();
        },
        success: function (response) {
            if (response.response == "success") {
                const Anaquel = new Anaqueles();
                const respuesta = response.data;
                button.parent().show();
                if (pagina <= 1) {
                    contenedor.html(Anaquel.mostrar_anaqueles(respuesta));
                } else {
                    contenedor.append(Anaquel.mostrar_anaqueles(respuesta));
                }

                let paginar = true;
                let pg = response.pagination;
                let limite = (pg.page * pg.limit);
                if (limite <= 1) {
                    paginar = false
                }
                if (!paginar) {
                    button.parent().hide();
                }
                button.off().on('click', function () {
                    let button = $(this);
                    button.html(`Cargando... <div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div>`)
                    button.off();
                    setTimeout(() => {
                        traer_anaqueles(pagina + 1, buscar)
                    }, 500);
                });
                $(".modificar_anaquel").off().on('click', function () {
                    let anaquel_sel = $(this);
                    editar_anaquel(anaquel_sel.attr("data-codigoanaquel"));
                });
            } else {
                button.parent().hide();
                if (pagina == 1) contenedor.html(`
                    <div class="col-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-7 col-stats text-center">
                                        <div class="numbers">
                                            <p class="card-category">No se encontraron resultados de tu búsqueda</p>
                                            <h4 class="card-title">Continua intentando, es probable que el anaquel que estas buscando no exista</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
            }
            borrar_ac.off().on('click', function (){
                borrar_ac.parent().hide();
                button.parent().hide();
                contenedor.html("")
            });
        }
    });
}

class Anaqueles {
    cuerpo_anaquel(anaquel) {
        return `
            <div class="card mb-2 p2 align-items-stretch">
                <div class="card-body py-0 c-pointer modificar_anaquel" data-codigoanaquel="${anaquel.codigo_anaquel}">
                    <div class="row align-items-center">
                        <div class="col pl-0">
                        <a ><img src="${RUTA}/public/galeria/anaqueles/vista/storage.png" alt="" class="w-100"></a>
                        </div>
                        <div class="col-9">
                            <span class="text-uppercase fw-bold mb-1">Anaquel: <br><span>${anaquel.codigo_anaquel}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        `
    }
    mostrar_anaqueles(anaqueles) {
        let cuerpo = "";
        for (const anaquel of anaqueles) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 anaquel px-1" data-codigoanaquel="${anaquel.codigo_anaquel}">${this.cuerpo_anaquel(anaquel)}</div>`;
        }
        return cuerpo;
    }
}