<?php

// Recibe por parametros la variable $cliente

?>
<div class="modal fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="modal_edit_user_label" aria-hidden="true" style="z-index: 10001;">
    <div class="modal-dialog modal-lg modal_edit_users" role="document">
        <div class="modal-content cuerpo">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal_edit_user_label">Registro de clientes</h5>
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form_carrito">
                <form action="modificar_cliente" id="modificar_cliente" method="post">
                    <div class="row" id="cont_form_cliente">
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">R.S.</span>
                                    </div>
                                    <input type="text" class="form-control" name="razon_social" id="razon_social" placeholder="Razón Social" value="<?php echo $cliente['razon_social']; ?>">
                                </div>
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="cliente_name" class="mb-0">R.F.C</label>
                                <input type="text" class="form-control" name="rfc" id="rfc" placeholder="R.F.C" value="<?php echo $cliente['rfc']; ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="cliente_lastname" class="mb-0">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $cliente['telefono']; ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="cliente_tel" class="mb-0">Correo</label>
                                <input type="text" class="form-control" name="correo" id="correo" placeholder="Correo" value="<?php echo $cliente['correo']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-0">Tipo de persona</label>
                                <div class="selectgroup w-100">
                                    <div class="row px-3">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo_persona" value="fisica" class="selectgroup-input" <?php echo ($cliente['tipo_persona'] == "fisica" ? 'checked=""' : ""); ?>>
                                            <span class="selectgroup-button">Fisica</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo_persona" value="moral" class="selectgroup-input" <?php echo ($cliente['tipo_persona'] == "moral" ? 'checked=""' : ""); ?>>
                                            <span class="selectgroup-button">Moral</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="form-label mb-0">Tipo de cliente</label>
                                <div class="selectgroup w-100">
                                    <div class="row px-3">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo_cliente" value="mayorista" class="selectgroup-input" <?php echo ($cliente['tipo_cliente'] == "mayorista" ? 'checked=""' : ""); ?>>
                                            <span class="selectgroup-button">Mayorista</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo_cliente" value="minoritsta" class="selectgroup-input" <?php echo ($cliente['tipo_cliente'] == "minoritsta" ? 'checked=""' : ""); ?>>
                                            <span class="selectgroup-button">Minoritsta</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo_cliente" value="menudeo" class="selectgroup-input" <?php echo ($cliente['tipo_cliente'] == "menudeo" ? 'checked=""' : ""); ?>>
                                            <span class="selectgroup-button">Menudeo</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipo_cliente" value="publico" class="selectgroup-input" <?php echo ($cliente['tipo_cliente'] == "publico" ? 'checked=""' : ""); ?>>
                                            <span class="selectgroup-button">Publico</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="registro_direccion">
                        <div class="col contenedor_titulos text-center">
                            <h2 class="mb-0" style="display: none;">Registrar dirección</h2>
                            <div class="btn btn-primary btn-round add_direccion">Completar campos de dirección <i class="fas fa-arrow-circle-down"></i></div>
                        </div>
                        <div class="col-12 direccion_cont" style="display: none;">
                            <?php $direccion = !empty($cliente['direccion']) ? $cliente['direccion'][0] : false; ?>
                            <div class="form-group my-0 py-0">
                                <label for="direccion" class="mb-0">Dirección</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Dirección" value="<?php echo ($direccion ? $direccion['direccion'] : ""); ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="numero_externo" class="mb-0">Número exterior</label>
                                <input type="text" class="form-control" id="numero_externo" placeholder="Número exterior" value="<?php echo ($direccion ? $direccion['numero_externo'] : ""); ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="numero_interno" class="mb-0">Número interior</label>
                                <input type="text" class="form-control" id="numero_interno" placeholder="Número interior" value="<?php echo ($direccion ? $direccion['numero_interno'] : ""); ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="colonia" class="mb-0">Colonia</label>
                                <input type="text" class="form-control" id="colonia" placeholder="Colonia" value="<?php echo ($direccion ? $direccion['colonia'] : ""); ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="codigo_postal" class="mb-0">Código postal</label>
                                <input type="text" class="form-control" id="codigo_postal" placeholder="Código postal" value="<?php echo ($direccion ? $direccion['cp'] : ""); ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="ciudad" class="mb-0">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" placeholder="Ciudad" value="<?php echo ($direccion ? $direccion['ciudad'] : ""); ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="estado" class="mb-0">Estado</label>
                                <input type="text" class="form-control" id="estado" placeholder="Estado" value="<?php echo ($direccion ? $direccion['estado'] : ""); ?>">
                            </div>
                            <div class="row">
                                <div class="col-12 text-right mt-2">
                                    <a class="btn btn-info btn-round text-white add_direccion">Cerrar llenado de dirección <i class="fas fa-arrow-circle-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-block "> Completar registro de cliente</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger py-1 px-2" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>