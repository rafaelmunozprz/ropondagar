<div class="modal fade" data-backdrop="static" id="modal_buscar_contenedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_insertar_materia_Label">Lista de productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_buscar_contenedor">
                <div class="modal-body">
                    Agregar materia al anaquel
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text ml-2" id="label-fila"> Espacio Anaquel</span>
                            </div>
                            <input type="text" class="form-control mr-2" id="fc-anaquel" name="fc-anaquel" placeholder="F#C#-Contenedor" aria-label="F#C#-Contenedor" aria-describedby="label-contenedor" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="buttonMostrarContenido" class="btn btn-primary">Mostrar contenido</button>
                </div>
            </form>
            <div class="modal-body">
                <div id="contenedor_grid" class="p-1" style="max-height: 40vh; overflow: scroll;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="atras-insertar-materia" class="btn btn-danger ml-1"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atras</button>
            </div>
        </div>
    </div>
</div>