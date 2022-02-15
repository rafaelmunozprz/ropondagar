<div class="modal fade" id="modal_editar_modelo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content" id="modelo_form_cont">
            <div class="modal-header py-3 px-2">
                <button type="button" class="close mr-3 pt-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <h3 class="font-weight-bold">Detalles del modelo</h3>
            </div>
            <div class="modal-body cuerpo_modelo py-0">
                <form method="POST" id="editar_modelo">
                    <div class="row justify-content-end">
                        <div class="col text-right mt-0 mb-3">
                            <a class="btn btn-success btn-border btn-round py-1 modificar_modelo_views">Configurar materiales para el modelo</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert" role="alert"></div>
                        </div>
                        <div class="col-sm-4 col-4 px-1">
                            <label class="label" data-toggle="tooltip" title="Cambia la imagen del modelo">
                                <img class="img-fluid" id="avatar" src="<?php echo $RUTA; ?>galeria/sistema/default/default_load.png" alt="avatar">
                                <input type="file" class="sr-only" id="input" name="image" accept="image/*" autocomplete="off">
                            </label>
                            <a class="btn btn-outline-info py-0 btn-block px-0 text-dark"><i class="fas fa-camera fa-lg"></i> Modificar</a>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>

                        </div>
                        <div class="col-8 text-justify text-md-left px-0">
                            <div class="form-group mb-0 py-0">
                                <label for="nombre" class="mb-0">Modelo</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Modelo" autocomplete="off">
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="color" class="mb-0">Talla</label>
                                <select class="form-control" name="talla" autocomplete="off">
                                    <option value="N/A">N/A</option>
                                    <option value="3m">3 Meses</option>
                                    <option value="6m">6 Meses</option>
                                    <option value="12m">12 Meses</option>
                                    <option value="18m">18 Meses</option>
                                    <option value="24m">Talla 2</option>
                                    <option value="36m">Talla 3</option>
                                    <option value="48m">Talla 4</option>
                                    <option value="60m">Talla 5</option>
                                    <option value="72m">Talla 6</option>
                                    <option value="84m">Talla 8</option>
                                    <option value="120m">Talla 10</option>
                                    <option value="144m">Talla 12</option>
                                    <option value="168m">Talla 14</option>
                                    <option value="192m">Talla 16</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 py-1">
                                <label class="form-label mb-0">Color</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="perla" class="selectgroup-input" autocomplete="off">
                                        <span class="selectgroup-button">perla</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="blanco" class="selectgroup-input" autocomplete="off">
                                        <span class="selectgroup-button">blanco</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="kaki" class="selectgroup-input" autocomplete="off">
                                        <span class="selectgroup-button">kaki</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="na" class="selectgroup-input" checked="" autocomplete="off">
                                        <span class="selectgroup-button">N/A</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-justify text-md-left px-0">

                            <div class="form-group mb-0 py-0">
                                <label class="form-label mb-0">Tipo</label>
                                <div class="selectgroup px-3">
                                    <div class="row">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="normal" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Normal</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="estola" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Estola</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="nicker" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Nicker</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="desmontable" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Desmontable</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="tirantes" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Tirantes</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="bombacho" class="selectgroup-input" checked="" autocomplete="off">
                                            <span class="selectgroup-button">Bombacho</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="corto" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Corto</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="largo" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Largo</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="vestido" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Vestido</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="short" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Short</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="Bata" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Bata</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="na" class="selectgroup-input" checked="" autocomplete="off">
                                            <span class="selectgroup-button">N/A</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 py-1">
                                <label class="form-label mb-0">Sexo</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="sexo" value="m" class="selectgroup-input" autocomplete="off">
                                        <span class="selectgroup-button">Masculino</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="sexo" value="f" class="selectgroup-input" autocomplete="off">
                                        <span class="selectgroup-button">Femenino</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="sexo" value="na" class="selectgroup-input" checked="" autocomplete="off">
                                        <span class="selectgroup-button">N/A</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="codigo_fiscal" class="mb-0">Código Fiscal</label>
                                <input type="text" class="form-control" name="codigo_fiscal" placeholder="Código Fiscal" autocomplete="off">
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="codigo" class="mb-0">Código</label>
                                <input type="text" class="form-control" name="codigo" placeholder="Código" autocomplete="off">
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="codigo_completo" class="mb-0">Código completo</label>
                                <input type="text" class="form-control" name="codigo_completo" placeholder="Código completo" autocomplete="off" readonly>
                            </div>
                            <div class="row justify-content-end p-3">
                                <div class="px-2">
                                    <button type="button" name="btn_eliminar_modelo" id="btn_eliminar_modelo" class="btn btn-danger p-1" data-dismiss="modal">Desactivar Modelo</button>
                                    <button type="submit" class="btn btn-primary px-5 py-1">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-body modelo_materiaprima py-1" style="display: none;">
                <div class="row justify-content-end">
                    <div class="col text-right mt-0 mb-3">
                        <a class="btn btn-success btn-border btn-round py-1 modificar_modelo_views">
                            < Volver a para guardar cambios</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form id="form_search_materiaprima" method="POST">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                    </div>
                                    <input type="text" class="form-control" name="buscador" placeholder="Buscar materia prima" autocomplete="off">
                                </div>
                                <input type="button" value="" hidden class="d-none" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="col-12 clientes-h">
                        <div class="row " id="contenedor_materia"></div>
                        <div class="row">
                            <div class="col text-center my-2" style="display: none;">
                                <a class="btn btn-primary btn-border btn-round" id="paginacion_materia">Mostrar más</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right py-0" style="display: none;"><a class="btn btn-danger btn-border btn-round btn-sm" id="borrar_busqueda_materiaprima"> <i class="far fa-times-circle"></i> CERRAR</a></div>
                </div>
                <div class="row">
                    <div class="col-12 text-center my-2">
                        <span class="h2"><b>Materiales necesarios para su elaboración</b></span>
                    </div>
                    <div class="col-12 text-justify materia_prima-h">
                        <table class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <td class="no_p" style="width: 40px;">#</td>
                                    <td class="no_p">Materia Prima</td>
                                    <td class="no_p" style="width: 80px;">quitar</td>
                                </tr>
                            </thead>
                            <tbody id="body_materiaprima_table">
                                <tr>
                                    <td class="no_p"> <a class="btn btn-icon btn-info text-white btn-round btn-xs py-1">1</a></td>
                                    <td class="no_p text-justify"> </td>
                                    <td class="no_p"> <a class="btn btn-icon btn-warning btn-round btn-xs py-1"><i class="fas fa-trash"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Ajustar la imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="crop">Ajustar</button>
            </div>
        </div>
    </div>
</div>