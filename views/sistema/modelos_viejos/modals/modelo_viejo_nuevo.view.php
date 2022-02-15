<div class="modal fade" id="vista_nuevo_modelo_viejo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-1 px-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="font-weight-bold">Detalles del modelo</h3>
                <form method="POST" id="nuevo_modelo_viejo_ll">
                    <div class="row">
                        <div class="col-12 text-justify text-md-left px-0">
                            <div class="form-group mb-0 py-0">
                                <label for="nombre" class="mb-0">Modelo</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Modelo">
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="color" class="mb-0">Talla</label>
                                <select class="form-control" name="talla" id="talla" autocomplete="off">
                                    <option value="N/A">N/A</option>
                                    <option value="3m">3 Meses</option>
                                    <option value="6m">6 Meses</option>
                                    <option value="12m">12 Meses</option>
                                    <option value="18m">18 Meses</option>
                                    <option value="24m">Talla 2</option>
                                    <option value="26m">Talla 3</option>
                                    <option value="48m">Talla 4</option>
                                    <option value="60m">Talla 5</option>
                                    <option value="72m">Talla 6</option>
                                    <option value="96m">Talla 8</option>
                                    <option value="120m">Talla 10</option>
                                    <option value="144m">Talla 12</option>
                                    <option value="168m">Talla 14</option>
                                    <option value="192m">Talla 16</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 py-1" id="select_coloredit">
                                <label class="form-label mb-0">Color</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="perla" class="selectgroup-input">
                                        <span class="selectgroup-button">Perla</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="blanco" class="selectgroup-input">
                                        <span class="selectgroup-button">Blanco</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="kaki" class="selectgroup-input">
                                        <span class="selectgroup-button">Kaki</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="color" value="na" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">N/A</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-justify text-md-left px-0">
                            <div class="form-group mb-0 py-0" id="select_tipoedit">
                                <label class="form-label mb-0">Tipo</label>
                                <div class="selectgroup px-3">
                                    <div class="row">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="normal" class="selectgroup-input">
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
                                            <input type="radio" name="tipo" value="desmontable" class="selectgroup-input">
                                            <span class="selectgroup-button">Desmontable</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="tirantes" class="selectgroup-input">
                                            <span class="selectgroup-button">Tirantes</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="bombacho" class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">Bombacho</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="corto" class="selectgroup-input">
                                            <span class="selectgroup-button">Corto</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="largo" class="selectgroup-input">
                                            <span class="selectgroup-button">Largo</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo" value="vestido" class="selectgroup-input">
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
                                            <input type="radio" name="tipo" value="na" class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">N/A</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 py-1" id="select_editsexo">
                                <label class="form-label mb-0">Sexo</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="sexo" value="m" class="selectgroup-input">
                                        <span class="selectgroup-button">Masculino</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="sexo" value="f" class="selectgroup-input">
                                        <span class="selectgroup-button">Femenino</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="sexo" value="na" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">N/A</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="nombre" class="mb-0">Precio Menudeo</label>
                                <input type="number" class="form-control" name="precio_menudeo" min="0" step="0.01" placeholder="Precio menudeo sin IVA">
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="nombre" class="mb-0">Precio Mayoreo</label>
                                <input type="number" class="form-control" name="precio_mayoreo" min="0" step="0.01" placeholder="Precio mayoreo sin IVA">
                            </div>
                            <div class="form-group mb-0 py-0">
                                <label for="codigo" class="mb-0">Código</label>
                                <input type="text" class="form-control" name="codigo" placeholder="Código">
                            </div>
                            <div class="row justify-content-end p-3">
                                <div class="px-2">
                                    <button type="submit" class="btn btn-primary px-5 py-1">Guardar</button>
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