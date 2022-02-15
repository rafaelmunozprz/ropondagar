<div class="modal fade" id="modal_editar_materia" tabindex="-1" role="dialog" aria-labelledby="nueva_materia_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-4 px-2">
                <button type="button" class="close mr-3 py-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-1">
                <div class="container" id="materiaprima_form_cont">
                    <section class="text-center">
                        <h3 class="font-weight-bold">Detalles de material</h3>
                        <div class="row cuerpo_materiaprima"></div>
                        <div class="row configurar_materiaprima" style="display: none;">
                            <div class="col-12 text-justify text-md-left px-0">
                                <form method="POST" id="editar_materia">
                                    <div class="form-group mb-0 py-0">
                                        <label for="codigo_fiscal" class="mb-0">Código Fiscal</label>
                                        <input type="text" class="form-control" name="codigo_fiscal" placeholder="Código Fiscal" autocomplete="off">
                                    </div>
                                    <div class="form-group mb-0 py-0">
                                        <label for="nombre" class="mb-0">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" autocomplete="off">
                                    </div>
                                    <div class="form-group mb-0 py-0">
                                        <label for="nombre" class="mb-0">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" autocomplete="off">
                                    </div>
                                    <div class="form-group mb-0 py-0" id="select_coloredit">
                                        <label class="form-label">Color</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item" style="background-color: #e1edf0;">
                                                <input type="radio" name="color" value="blanco" class="selectgroup-input" autocomplete="off">
                                                <span class="selectgroup-button" style="color: black;">Blanco</span>
                                            </label>
                                            <label class="selectgroup-item text-dark" style="background-color: #c3b091;">
                                                <input type="radio" name="color" value="kaki" class="selectgroup-input" autocomplete="off">
                                                <span class="selectgroup-button" style="color: black;">Kaki</span>
                                            </label>
                                            <label class="selectgroup-item" style="background-color: #eae6ca;">
                                                <input type="radio" name="color" value="perla" class="selectgroup-input" autocomplete="off">
                                                <span class="selectgroup-button" style="color: black;">Perla</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="color" value="N/A" class="selectgroup-input" checked="" autocomplete="off">
                                                <span class="selectgroup-button">N/A</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 py-0">
                                        <label for="medida" class="mb-0">Medida o cantidad por unidad</label>
                                        <input type="text" class="form-control" name="medida" placeholder="Medida" autocomplete="off">
                                    </div>
                                    <div class="form-group mb-0 py-0" id="select_umedida">
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
                                        <div class="col-12">
                                            <div class="">
                                                <button type="submit" class="btn btn-primary btn-block px-5 py-2">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 text-right">
                                <a href="#" class="btn btn-warning py-1 mr-3 modificar_materia_prima"> Volver</a>
                            </div>
                        </div>
                        <div class="row " id="container_stock">

                        </div>
                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>