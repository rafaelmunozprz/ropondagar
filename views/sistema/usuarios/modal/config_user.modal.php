<?php

// Recibe por parametros la variable $usuario

?>
<div class="modal fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="modal_edit_user_label" aria-hidden="true" style="z-index: 10001;">
    <div class="modal-dialog modal-lg modal_edit_users" role="document">
        <div class="modal-content cuerpo">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal_edit_user_label">Registro de usuarios</h5>
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form_carrito">
                <form action="nuevo_usuario" id="modificar_usuario" method="post">
                    <div class="row" id="cont_form_user">
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                    </div>
                                    <input type="text" class="form-control" name="nombre_usuario" id="user_nickname" placeholder="Nombre de usuario" value="<?php echo $usuario['nombre_usuario']; ?>">
                                </div>
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="user_name" class="mb-0">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="user_name" placeholder="Nombre" value="<?php echo $usuario['nombre']; ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="user_lastname" class="mb-0">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" id="user_lastname" placeholder="Apellidos" value="<?php echo $usuario['apellidos']; ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="user_tel" class="mb-0">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="user_tel" placeholder="Teléfono" value="<?php echo $usuario['telefono']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-0">Selecciona el cargo</label>
                                <div class="selectgroup w-100">
                                    <div class="row px-3">

                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="vendedor" class="tipo_user selectgroup-input" <?php echo ($usuario['cargo'] == 'vendedor' ? 'checked=""' : "") ?>>
                                            <span class="selectgroup-button">vendedor</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="encargado" class="tipo_user selectgroup-input" <?php echo ($usuario['cargo'] == 'encargado' ? 'checked=""' : "") ?>>
                                            <span class="selectgroup-button">encargado</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="trabajador" class="tipo_user selectgroup-input" <?php echo ($usuario['cargo'] == 'trabajador' ? 'checked=""' : "") ?>>
                                            <span class="selectgroup-button">trabajador</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="destajo" class="tipo_user selectgroup-input" <?php echo ($usuario['cargo'] == 'destajo' ? 'checked=""' : "") ?>>
                                            <span class="selectgroup-button">destajo</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="admin" class="tipo_user selectgroup-input" <?php echo ($usuario['cargo'] == 'admin' ? 'checked=""' : "") ?>>
                                            <span class="selectgroup-button">admin</span>
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
                            <div class="form-group my-0 py-0">
                                <label for="direccion" class="mb-0">Dirección</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Dirección" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['direccion'] : "" ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="numero_externo" class="mb-0">Número exterior</label>
                                <input type="text" class="form-control" id="numero_externo" placeholder="Número exterior" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['numero_externo'] : "" ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="numero_interno" class="mb-0">Número interior</label>
                                <input type="text" class="form-control" id="numero_interno" placeholder="Número interior" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['numero_interno'] : "" ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="colonia" class="mb-0">Colonia</label>
                                <input type="text" class="form-control" id="colonia" placeholder="Colonia" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['colonia'] : "" ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="codigo_postal" class="mb-0">Código postal</label>
                                <input type="text" class="form-control" id="codigo_postal" placeholder="Código postal" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['cp'] : "" ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="ciudad" class="mb-0">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" placeholder="Ciudad" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['ciudad'] : "" ?>">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="estado" class="mb-0">Estado</label>
                                <input type="text" class="form-control" id="estado" placeholder="Estado" value="<?php echo $usuario['direccion'] != "" ? $usuario['direccion'][0]['estado'] : "" ?>">
                            </div>
                            <div class="row">
                                <div class="col-12 text-right mt-2">
                                    <a class="btn btn-info btn-round text-white add_direccion">Volver a los datos del usuario <i class="fas fa-arrow-circle-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-block "> Actualizar datos</button>
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