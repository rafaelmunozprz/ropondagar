<div class="modal fade" id="modal_modificar_producto" tabindex="-1" role="dialog" aria-labelledby="modal_modificar_producto_label" aria-hidden="true" style="z-index: 100001;">
    <div class="modal-dialog modal-lg modal_modificar_productos" role="document">
        <div class="modal-content cuerpo">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal_modificar_producto_label">Modificación de precios</h5>
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form_carrito">
                <form id="modificar_producto" method="post">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="codigo" class="mb-0">Código</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">N.</span>
                                    </div>
                                    <input type="text" class="form-control" id="codigo" placeholder="Código" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cantidad" class="mb-0">Cantidad</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">N.</span>
                                    </div>
                                    <input type="number" class="form-control" id="cantidad" placeholder="Cantidad" step="0.001" autocomplete="off">
                                    <input type="hidden" class="form-control hidden" id="id_producto" data-tipo="materia_prima" hidden autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="precio_compra" class="mb-0">Precio de compra</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" max="99999" class="form-control" id="precio_compra" placeholder="Precio de compra" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="precio_mayoreo" class="mb-0">Precio Mayoreo</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" step="0.01" max="99999" id="precio_mayoreo" placeholder="Precio Mayoreo" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="precio_menudeo" class="mb-0">Precio Menudeo</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" step="0.01" max="99999" id="precio_menudeo" placeholder="Precio Menudeo" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-block "> Guardar cambios</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger py-1 px-2 " id="eliminar_producto"><i class="fas fa-trash mr-3"></i>ELIMINAR</button>
                <button type="button" class="btn btn-warning py-1 px-2" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>