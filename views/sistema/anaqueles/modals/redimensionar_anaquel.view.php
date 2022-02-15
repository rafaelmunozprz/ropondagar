<div class="modal fade" id="modal_redimensionar_anaquel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_redimensionar_anaquel_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_redimensionar_anaquel_Label">Especificaciones para nuevo anaquel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_redimensionar_anaquel">
                <div class="modal-body">
                    Redimensionar el anaquel
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text ml-2" id="label-fila"> Filas</span>
                            </div>
                            <input type="number" class="form-control" id="redimensionar_filas_anaquel" name="redimensionar_filas_anaquel" placeholder="Filas" aria-label="Filas" aria-describedby="label-fila" min="1" max="10"  step="1" autocomplete="off">
                            <input type="number" class="form-control" id="redimensionar_columnas_anaquel" name="redimensionar_columnas_anaquel" placeholder="Columnas" aria-label="Columnas" aria-describedby="label-columnas" min="1" max="20"  step="1" autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text mr-2" id="label-columnas">Columnas</span>
                            </div>
                        </div>
                    </div>
                    <div id="container-filas-columnas" class="p-1">
                        <div class="row bg-warning p-2 mb-1">El tamaño del anaquel no puede ser menor al original</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="buttonGuardar" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>