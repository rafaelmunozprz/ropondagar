<div class="modal fade" id="modal_determinar_encargado" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Asignar encargado de grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_asignar_encargado">
                <div class="modal-body" style="max-height: 60vh; overflow: scroll;">
                    <table class="table">
                        <thead>
                            <th>Nombre</th>
                            <th>Encargado</th>
                        </thead>
                        <tbody id="contenedor_usuarios_encargados"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="btn_agregar_personal" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>