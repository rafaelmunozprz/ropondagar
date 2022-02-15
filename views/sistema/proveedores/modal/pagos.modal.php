<div class="modal fade" id="modal_pagos" tabindex="-1" role="dialog" aria-labelledby="modal_descuento_label" aria-hidden="true" style="z-index:100001;">
    <div class="modal-dialog modal_descuentos" role="document">
        <div class="modal-content cuerpo">
            <div class="modal-header">
                <h5 class="modal-title mx-auto" id="modal_descuento_label">Generar pago de nota</h5>
            </div>
            <div class="modal-body px-0 form_carrito">
                <div class="pago">
                    <table class="table table-light text-center pago_nota">
                        <tbody>
                            <tr>
                                <td colspan="2" class="border-0 ">
                                    <h3>Saldo total de la nota:</h3>
                                    <h4 class="total_a_pagar">$0.00</h4>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-0 "><b>Total de pago</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="precio text-success fa-sm"><input type="number" step="0.01" placeholder="00.00" id="cantidad_pago_total" class="modificar_precio bb2" value="000.00" autocomplete="off"></span></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-0 "></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-light pago_nota">
                        <tbody>
                            <tr>
                                <td class="no_p py-3 " style="width: 33.33%!important;">
                                    <div class="card p-0 m-0 continuar_pago py-3 bg-dark text-white" data-tipo_pago="efectivo">
                                        <div class="card-body p-0 m-0">
                                            <i class="fas fa-hand-holding-usd fa-2x"></i> <br>
                                            Efectivo
                                        </div>
                                    </div>
                                </td>
                                <td class="no_p py-3 " style="width: 33.33%!important;">
                                    <div class="card p-0 m-0 continuar_pago py-3" data-tipo_pago="tranferencia">
                                        <div class="card-body p-0 m-0">
                                            <i class="fas fa-comments-dollar fa-2x"></i> <br>
                                            Tranferencia
                                        </div>
                                    </div>
                                </td>
                                <td class="no_p py-3 " style="width: 33.33%!important;">
                                    <div class="card p-0 m-0 continuar_pago py-3" data-tipo_pago="cheque">
                                        <div class="card-body p-0 m-0">
                                            <i class="fas fa-money-check-alt fa-2x"></i> <br>
                                            Cheque
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="no_p py-3 " style="width: 33.33%!important;">
                                    <div class="card p-0 m-0 continuar_pago py-3" data-tipo_pago="credito">
                                        <div class="card-body p-0 m-0">
                                            <i class="far fa-credit-card fa-2x"></i> <br>
                                            Crédito
                                        </div>
                                    </div>
                                </td>
                                <td class="no_p py-3 " style="width: 33.33%!important;">
                                    <div class="card p-0 m-0 continuar_pago py-3" data-tipo_pago="debito">
                                        <div class="card-body p-0 m-0">
                                            <i class="fas fa-credit-card fa-2x"></i> <br>
                                            Débito
                                        </div>
                                    </div>
                                </td>
                                <td class="no_p py-3 " style="width: 33.33%!important;"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">
                                    <a class="btn btn-outline-dark btn-block py-1 px-2" id="realizar_pago_nota">Realizar pago</a>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger py-1 px-2 " id="modal_pago_volver" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>