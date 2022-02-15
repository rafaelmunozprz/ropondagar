<div class="modal fade" id="modal_new_categoria" tabindex="-1" role="dialog" aria-labelledby="nueva_categoria_label" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 px-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-post card-round">
                    <div class="card-body p-1">
                        <div class="container">
                            <section class="text-center">
                                <h3 class="font-weight-bold">Detalles de la categoría</h3>
                                <div class="row">
                                    <div class="col-12 text-justify text-md-left px-0">
                                        <form method="POST" id="form_nueva_categoria">
                                            <div class="form-group mb-0 py-0">
                                                <label for="nombre" class="mb-0">Nombre</label>
                                                <input type="text" class="form-control" name="nombre_categoria" placeholder="Nombre categoría" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="tipo" class="mb-0">Tipo</label>
                                                <select class="form-control" name="tipo" id="tipo">
                                                    <option value="prima">Materia Prima</option>
                                                    <option value="maquila">Maquilado</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="color" class="mb-0">Estado</label>
                                                <select class="form-control" name="estado_categoria" id="estado_categoria">
                                                    <option value="activo">Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                            <div class="row justify-content-end p-3">
                                                <div class="px-2">
                                                    <button type="submit" class="btn btn-primary px-5 py-1">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>