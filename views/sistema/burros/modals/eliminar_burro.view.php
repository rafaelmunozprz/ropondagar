<div class="modal fade" id="modal_eliminar_burro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_eliminar_burro_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_eliminar_burro_Label">Eliminar burro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_eliminar_burro">
                <div class="modal-body">
                    Eliminar burro
                    <div class="row">
                        <div class="input-group mb-3 ml-2 mr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="label-fila"> Código burro</span>
                            </div>
                            <input type="number" class="form-control" id="codigo_modificar_burro" name="codigo_modificar_burro" placeholder="Filas" aria-label="Filas" aria-describedby="label-fila" min="1" step="1" value="1">
                        </div>
                    </div>
                    <div id="container-filas-columnas" class="p-1 text-center">
                        <div class="row bg-danger p-2 mb-1 text-white">No puedes eliminar un burro con artículos</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="buttonGuardar" class="btn btn-danger">Eliminar Burro</button>
                </div>
            </form>
        </div>
    </div>
</div>