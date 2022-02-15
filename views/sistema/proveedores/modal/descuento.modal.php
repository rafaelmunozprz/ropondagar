<div class="modal fade" id="modal_descuento" tabindex="-1" role="dialog" aria-labelledby="modal_descuento_label" aria-hidden="true" style="z-index: 10001;">
    <div class="modal-dialog modal_descuentos" role="document">
        <div class="modal-content cuerpo">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal_descuento_label">Aplicar descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form_carrito">
                <form action="#" id="calculo_descuento" method="post">
                    <table class="table table-light text-center">
                        <tbody>
                            <tr>
                                <div class="form-group py-0">
                                    <label class="mb-0">Tipo de descuento</label>
                                    <div class="selectgroup w-100">

                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipodescuento" value="moneda" class="selectgroup-input" checked="" autocomplete="off">
                                            <span class="selectgroup-button">Moneda</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="tipodescuento" value="porcentaje" class="selectgroup-input" autocomplete="off">
                                            <span class="selectgroup-button">Porcentaje</span>
                                        </label>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <td><input type="number" step="any" placeholder="0.0" name="cantidad" class="modificar_precio xxl bb2" attr-tipo="porcentaje" value="" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-0 "></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-0 "></b></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <a class="btn success-color-dark py-1 px-2 btn-block" id="guardar_descuento">Aplicar descuento</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger py-1 px-2" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>