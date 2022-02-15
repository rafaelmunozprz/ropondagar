<div class="modal fade" id="vista_agregar_stock_modelo_viejo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 px-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="font-weight-bold">Agregar stock</h3>
                <form method="POST" id="agregar_stock_ll">
                    <div class="row">
                        <div class="col-12 text-justify text-md-left px-0">
                            <div class="form-group mb-0 py-0">
                                <label for="nombre" class="mb-0">Cantidad</label>
                                <input type="number" min="1" step="1" class="form-control" name="nuevo_stock" placeholder="Stock" required>
                            </div>
                            <div class="row justify-content-end p-3">
                                <div class="px-2">
                                    <button type="submit" class="btn btn-primary px-5 py-1">Agregar stock</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>