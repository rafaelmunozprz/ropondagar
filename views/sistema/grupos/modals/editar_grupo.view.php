<div class="modal fade" id="modal_editar_grupo_trabajo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Crear un nuevo grupo de trabajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_editar_grupo">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editar_nombre_grupo">Nombre grupo</label>
                        <input type="text" class="form-control" name="editar_nombre_grupo" id="editar_nombre_grupo" aria-describedby="Nombre nuevo grupo" placeholder="Ingresar nombre del nuevo grupo">
                    </div>
                    <div class="form-group">
                        <label for="editar_estado_grupo">Estado</label>
                        <select class="form-control" name="editar_estado_grupo" id="editar_estado_grupo">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="editar_grupo" class="btn btn-primary">Guardar Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>