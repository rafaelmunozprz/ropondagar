<div class="modal fade" id="modal_nuevo_burro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_nuevo_burro_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_nuevo_burro_Label">Especificaciones para nuevo burro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_nuevo_burro">
                <div class="modal-body">
                    Dimensiones del nuevo anaquel
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text ml-2" id="label-nivel">Niveles</span>
                            </div>
                            <input type="number" class="form-control" id="niveles_NUEVO_BURRO" name="niveles_NUEVO_BURRO" placeholder="Niveles" aria-label="Niveles" aria-describedby="label-nivel" min="1" step="1" value="1">
                            <input type="number" class="form-control" id="secciones_NUEVO_BURRO" name="secciones_NUEVO_BURRO" placeholder="Secciones" aria-label="Secciones" aria-describedby="label-secciones" min="1" step="1" value="1">
                            <div class="input-group-append">
                                <span class="input-group-text mr-2" id="label-secciones"> Secciones</span>
                            </div>
                        </div>
                    </div>
                    <div id="contenedor_GRID_NUEVO_BURRO" class="p-1">
                        <div class="row bg-warning p-2 mb-1">Define las dimesiones del burro</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                    <button type="submit" name="buttonGuardar" class="btn btn-primary"><i class="fas fa-save"></i> Crear Burro</button>
                </div>
            </form>
        </div>
    </div>
</div>