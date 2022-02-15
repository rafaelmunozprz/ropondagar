<div class="modal fade" id="modal_new_materia" tabindex="-1" role="dialog" aria-labelledby="nueva_materia_label" aria-hidden="true">
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
                                <h3 class="font-weight-bold">Detalles de material</h3>
                                <div class="row">
                                    <div class="col-12 text-justify text-md-left px-0">
                                        <form method="POST" id="nueva_materia">
                                            <div class="form-group mb-0 py-0">
                                                <label for="codigo_fiscal" class="mb-0">Código Fiscal</label>
                                                <input type="text" class="form-control" name="codigo_fiscal" placeholder="Código Fiscal" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="nombre" class="mb-0">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" placeholder="Nombre" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-0 py-0" id="select_color">
                                                <label class="form-label">Color</label>
                                                <div class="selectgroup w-100">
                                                    <label class="selectgroup-item" style="background-color: #e1edf0;">
                                                        <input type="radio" name="color_nuevo" value="blanco" class="selectgroup-input" autocomplete="off">
                                                        <span class="selectgroup-button" style="color: black;">Blanco</span>
                                                    </label>
                                                    <label class="selectgroup-item text-dark" style="background-color: #c3b091;">
                                                        <input type="radio" name="color_nuevo" value="kaki" class="selectgroup-input" autocomplete="off">
                                                        <span class="selectgroup-button" style="color: black;">Kaki</span>
                                                    </label>
                                                    <label class="selectgroup-item" style="background-color: #eae6ca;">
                                                        <input type="radio" name="color_nuevo" value="perla" class="selectgroup-input" autocomplete="off">
                                                        <span class="selectgroup-button" style="color: black;">Perla</span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="color_nuevo" value="N/A" class="selectgroup-input" checked="" autocomplete="off">
                                                        <span class="selectgroup-button">N/A</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="medida" class="mb-0">Medida o cantidad por unidad</label>
                                                <input type="text" class="form-control" name="medida" placeholder="Medida" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label class="form-label">Unidad de medida</label>
                                                <div class="selectgroup w-100">
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="unidad_medida" value="m" class="selectgroup-input" autocomplete="off">
                                                        <span class="selectgroup-button">m</span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="unidad_medida" value="cm" class="selectgroup-input" autocomplete="off">
                                                        <span class="selectgroup-button">cm</span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="unidad_medida" value="mm" class="selectgroup-input" autocomplete="off">
                                                        <span class="selectgroup-button">mm</span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="unidad_medida" value="pieza" class="selectgroup-input" checked="" autocomplete="off">
                                                        <span class="selectgroup-button">pieza</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="categorias">Categoria</label>
                                                <select class="form-control form-control-sm" name="id_categoria" autocomplete="off"></select>
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="porcentaje_ganancia" class="mb-0">Porcentaje ganancia</label>
                                                <input type="text" class="form-control" name="porcentaje_ganancia" placeholder="Porcentaje ganancia" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-0 py-0">
                                                <label for="codigo" class="mb-0">Código</label>
                                                <input type="text" class="form-control" name="codigo" placeholder="Código" autocomplete="off">
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