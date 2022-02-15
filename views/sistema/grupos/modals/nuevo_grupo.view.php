<div class="modal fade" id="modal_nuevo_grupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Crear un nuevo grupo de trabajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_nuevo_grupo">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre_nuevo_grupo">Nombre grupo</label>
                        <input type="text" class="form-control" name="nombre_nuevo_grupo" id="nombre_nuevo_grupo" aria-describedby="Nombre nuevo grupo" placeholder="Ingresar nombre del nuevo grupo">
                    </div>
                    <div class="form-group">
                        <label for="estado_nuevo_grupo">Grupo</label>
                        <select class="form-control" name="grupo" id="grupo">
                            <option value="preparacion">Preparación</option>
                            <option value="corte">Corte</option>
                            <option value="prebordado">Prebordado</option>
                            <option value="bordado">Bordado</option>
                            <option value="costura">Costura</option>
                            <option value="maquila">Maquila</option>
                            <option value="ojal">Ojal</option>
                            <option value="deshebre">Deshebre</option>
                            <option value="planchado">Planchado</option>
                            <option value="terminado">Terminado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="guardar_nuevo_grupo" class="btn btn-primary">Guardar Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>