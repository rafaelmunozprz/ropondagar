<div class="modal fade" id="modal_new_user" tabindex="-1" role="dialog" aria-labelledby="modal_new_user_label" aria-hidden="true" style="z-index: 10001;">
    <div class="modal-dialog modal-lg modal_new_users" role="document">
        <div class="modal-content cuerpo">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal_new_user_label">Registro de usuarios</h5>
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form_carrito">
                <form action="nuevo_usuario" id="registrar_usuario" method="post">
                    <div class="row" id="cont_form_user">
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                    </div>
                                    <input type="text" class="form-control" name="nombre_usuario" id="user_nickname" placeholder="Nombre de usuario" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="user_name" class="mb-0">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="user_name" placeholder="Nombre" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="user_lastname" class="mb-0">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" id="user_lastname" placeholder="Apellidos" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="user_tel" class="mb-0">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="user_tel" placeholder="Teléfono" autocomplete="off">
                            </div>
                            <!-- <div class="form-group my-0 py-0">
                                <label for="user_email" class="mb-0">Correo</label>
                                <input type="text" class="form-control" name="correo" id="user_email" placeholder="Ingresa tu correo">
                            </div> -->

                            <div class="form-group">
                                <label class="form-label mb-0">Selecciona el cargo</label>
                                <div class="selectgroup w-100">
                                    <div class="row px-3">

                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="vendedor" class="selectgroup-input" autocomplete="off" autocomplete="off">
                                            <span class="selectgroup-button">vendedor</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="encargado" class="selectgroup-input" autocomplete="off" autocomplete="off">
                                            <span class="selectgroup-button">encargado</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="trabajador" class="selectgroup-input" autocomplete="off" autocomplete="off">
                                            <span class="selectgroup-button">trabajador</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="destajo" class="selectgroup-input" autocomplete="off" autocomplete="off">
                                            <span class="selectgroup-button">destajo</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="cargo" value="admin" class="selectgroup-input" checked="" autocomplete="off" autocomplete="off">
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
                                <input type="text" class="form-control" id="direccion" placeholder="Dirección" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="numero_externo" class="mb-0">Número exterior</label>
                                <input type="text" class="form-control" id="numero_externo" placeholder="Número exterior" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="numero_interno" class="mb-0">Número interior</label>
                                <input type="text" class="form-control" id="numero_interno" placeholder="Número interior" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="colonia" class="mb-0">Colonia</label>
                                <input type="text" class="form-control" id="colonia" placeholder="Colonia" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="codigo_postal" class="mb-0">Código postal</label>
                                <input type="text" class="form-control" id="codigo_postal" placeholder="Código postal" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="ciudad" class="mb-0">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" placeholder="Ciudad" autocomplete="off">
                            </div>
                            <div class="form-group my-0 py-0">
                                <label for="estado" class="mb-0">Estado</label>
                                <input type="text" class="form-control" id="estado" placeholder="Estado" autocomplete="off">
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
                            <button type="submit" class="btn btn-success btn-block "> Completar registro de usuario</button>
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