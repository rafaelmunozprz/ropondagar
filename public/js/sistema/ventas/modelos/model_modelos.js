class Modelos {
    cuerpo_modelo(modelo) {
        let imagen = (modelo.galeria && modelo.galeria[0].is_file ? modelo.galeria[0].imagen : "galeria/sistema/default/default_modelo.png");
        let total = (modelo.cantidad - modelo.vendido);
        const FUNC = new Funciones(); // @/js/models/funciones.js

        return `
        <div class="card mb-2">
            <div class="card-body py-0 c-pointer" data-idmodelo="${modelo.id_modelo}" data-tipo="modelo">
                <div class="row align-items-center">
                    <div class="col pl-0">
                        <a ><img src="${RUTA + imagen}" alt="" class="w-100"></a>
                    </div>
                    <div class="col-9">
                        <span class="text-uppercase fw-bold mb-1">Modelo: <span class="text-muted ">${modelo.nombre} </span> </span>
                        <p class="my-0 py-0 lh-1">Código:<span class="text-muted">  ${modelo.codigo}</span></p>
                        <p class="my-0 py-0 lh-1">Color:<span class="text-muted"> ${modelo.color}</span></p>
                        <p class="my-0 py-0 lh-1">Disponibles:<b class="text-success"> ${total}</b></p>
                        <div class="row">
                            <div class="col-6 text-center">
                                <b>Menudeo</b><br>
                                <span> $ ${FUNC.number_format(modelo.precio_menudeo, 2)}</span>
                            </div>
                            <div class="col-6 text-center">
                                <b>Mayoreo</b><br>
                                <span> $ ${FUNC.number_format(modelo.precio_mayoreo, 2)}</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>`;
    }
    mostrar_modelos(modelos) {
        let cuerpo = '';
        for (const modelo of modelos) {
            cuerpo += `<div class="col-lg-4 col-sm-6 col-12 modelo_stock px-1" data-idmodelo="${modelo.id_modelo}">${this.cuerpo_modelo(modelo)}</div>`;
        }
        return cuerpo;
    }

}