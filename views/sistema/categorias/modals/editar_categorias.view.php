<div class="modal fade" id="modal_editar_categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content" id="categoria_form_cont">
            <div class="modal-header py-3 px-2">
                <button type="button" class="close mr-3 pt-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card card-post card-round">
                <div class="card-body p-1">
                    <div class="container">
                        <section class="text-center">
                            <h3 class="font-weight-bold">Detalles de la categoría</h3>
                            <div class="row">
                                <div class="col-12 text-justify cuerpo_categoria text-md-left px-0">
                                    <form method="POST" id="editar_categoria">
                                        <div class="form-group mb-0 py-0">
                                            <label for="nombre" class="mb-0">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-0 py-0">
                                            <label for="tipo" class="mb-0">Tipo</label>
                                            <select class="form-control" name="tipo" id="tipo">
                                                <option value="prima">Materia Prima</option>
                                                <option value="maquila">Maquilado</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-0 py-0">
                                            <label for="estado" class="mb-0">Estado</label>
                                            <select class="form-control" name="estado" id="estado">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>