<div class="modal fade" id="modal_config_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10001;">
    <div class="modal-dialog modal-" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 px-2 ">
                <h4 class="mx-auto">Seleccionar cliente</h4>
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div class="card card-post card-round py-0">
                    <div class="card-body cliente_cuerpo">
                        <div class="row">
                            <div class="col-12">
                                <form id="form_search_clientes" method="POST">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                            </div>
                                            <input type="text" class="form-control" name="buscador" placeholder="Buscar entre los clientes" autocomplete="off">
                                        </div>
                                        <input type="button" value="" hidden class="d-none">
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 clientes-h">
                                <div class="row " id="contenedor_clientes"></div>
                                <div class="row justify-content-center bg-white my-2">
                                    <div class="col-md-6 col-8  " style="display: none;">
                                        <a class="btn btn-secondary btn-border btn-round btn-block cliente" id="paginacion_cliente">Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning p-1 mr-5" id="limpiar_cliente">Limpiar cliente</button>
                <button type="button" class="btn btn-secondary p-1 ml-1 mr-3" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary p-1 ml-3" id="guardar_cliente">Guardar datos</button>
            </div>
        </div>
    </div>
</div>