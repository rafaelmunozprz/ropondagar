<div class="modal fade" data-backdrop="static" id="modal_lista_materia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_insertar_materia_Label">Lista de productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form_insterar_materia_espacio">
                <div class="modal-body">
                    Agregar materia al anaquel
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text ml-2" id="label-fila">Código </span>
                            </div>
                            <input type="text" class="form-control" id="contenedor_codigo_materia" name="contenedor_codigo_materia" placeholder="Código de barras" autocomplete="off"> 
                            <input type="number" class="form-control" id="contenedor_agregar_cantidad" name="contenedor_agregar_cantidad" placeholder="Cantidad" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text mr-2" id="label-fila"> Cantidad</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Cerrar</button>
                    <button type="submit" name="buttonGuardarArticulo" class="btn btn-primary"><i class="fas fa-file-download"></i> Guardar Producto</button>
                </div>
            </form>
            <div id="contenedor_lista" class="modal-body">Lista de productos</div>
            <div class="modal-footer">
                <button type="button" id="atras-lista-materia" class="btn btn-danger ml-1"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atras</button>
            </div>
        </div>
    </div>
</div>