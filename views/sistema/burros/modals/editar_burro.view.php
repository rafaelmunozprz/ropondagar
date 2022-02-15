<div class="modal fade" id="modal_modificar_burro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_modificar_burro_Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_modificar_anaquel_Label">Especificaciones para modificar burro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_modificar_burro">
                <div class="modal-body">
                    Modificiar burro
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text ml-2" id="label-seccion"> Secciones</span>
                            </div>
                            <input type="number" class="form-control mr-2" id="seccion_modificar_burro" name="seccion_burro" placeholder="Secciones" aria-label="Secciones" aria-describedby="label-seccion" min="1" step="1" value="1">
                        </div>
                    </div>
                    <div id="container-filas-columnas" class="p-1 text-center">
                        <div class="row bg-danger p-2 mb-1 text-white">El tamaño del burro no puede ser menor al anterior</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="buttonGuardar" class="btn btn-warning">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>