<div class="modal fade" id="modal_ajustar_precio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 px-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="font-weight-bold">Ajustar precio</h3>
                <form method="POST" id="form_ajustar_precio">
                    <div class="row">
                        <div class="col-12 text-justify text-md-left px-0">
                            <div class="form-group mb-0 py-0">
                                <label for="inversion" class="mb-0">Inversión</label>
                                <input type="number" min="0" step="0.01"  class="form-control" name="inversion" id="inversion" placeholder="Inversión" required>
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="precio_mayoreo" class="mb-0">Precio Mayoreo</label>
                                <input type="number" min="0" step="0.01" class="form-control" name="precio_mayoreo" id="precio_mayoreo" placeholder="Precio Mayoreo" required>
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="precio_menudeo" class="mb-0">Precio Menudeo</label>
                                <input type="number" min="0" step="0.01" class="form-control" name="precio_menudeo" id="precio_menudeo" placeholder="Precio Menudeo" required>
                            </div>
                            <div class="row justify-content-end p-3">
                                <div class="px-2">
                                    <button type="submit" class="btn btn-primary px-5 py-1">Ajustar Precio</button>
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