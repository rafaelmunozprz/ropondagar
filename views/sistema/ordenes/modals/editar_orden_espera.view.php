<div class="modal fade" id="modal_editar_nueva_orden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 px-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="font-weight-bold">Editar Orden Espera</h3>

                <div class="row" id="contenedor_modelos_espera">
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="datos_orden_espera"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning p-1 ver_historial_movimientos" historial_movimientos="">Historial Movimientos</button>
                <button type="button" class="btn btn-primary p-1" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>