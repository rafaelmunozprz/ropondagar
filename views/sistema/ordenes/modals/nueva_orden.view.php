<div class="modal fade" id="modal_nueva_orden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 px-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="font-weight-bold">Nueva Orden</h3>
                <div class="row">
                    <div class="col">
                        <form id="form_modelos" method="POST">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                    <input type="text" class="form-control" name="buscador_modelos" placeholder="Buscar todos los modelos" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" id="contenedor_modelos">
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Cantidad</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="datos_orden"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="limpiar_orden" class="btn btn-warning p-1">Limpiar Orden</button>
                <button type="button" class="btn btn-primary p-1" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardar_orden" class="btn btn-secondary p-1">Guardar Orden</button>
            </div>
        </div>
    </div>
</div>