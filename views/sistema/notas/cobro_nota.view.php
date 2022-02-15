<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('ordenes', 'nueva_orden'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">Nota</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <table class="table table-light text-center pago_nota">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border-0 "><b>Total de pago</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="precio">$ 5,000.00</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="" class="border-0 ">
                                            <a class="btn btn-outline-dark btn-block py-1 px-2">Guardar para más tarde</a>
                                        </td>
                                        <td colspan="" class="border-0 ">
                                            <a href="<?php echo $RUTA; ?>sistema/notas/facturapdf/" class="btn btn-outline-dark btn-block py-1 px-2">Imprimir ticket</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 "></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-light pago_nota">
                                <tbody>
                                    <tr>
                                        <td class="text-center continuar_pago" data-tipo_pago="efectivo">
                                            <i class="fab fa-amazon-pay fa-2x"></i> <br>
                                            Efectivo
                                        </td>
                                        <td class="text-center continuar_pago" data-tipo_pago="efectivo">
                                            <i class="fab fa-amazon-pay fa-2x"></i> <br>
                                            Débito
                                        </td>
                                        <td class="text-center continuar_pago" data-tipo_pago="efectivo">
                                            <i class="fab fa-amazon-pay fa-2x"></i> <br>
                                            Crédito
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center continuar_pago" data-tipo_pago="efectivo">
                                            <i class="fab fa-amazon-pay fa-2x"></i> <br>
                                            Cliente
                                        </td>
                                        <td class="text-center continuar_pago" data-tipo_pago="efectivo">
                                            <i class="fab fa-amazon-pay fa-2x"></i> <br>
                                            Cheque
                                        </td>
                                        <td class="text-center continuar_pago" data-tipo_pago="efectivo">
                                            <i class="fab fa-amazon-pay fa-2x"></i> <br>
                                            Otro
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">
                                            <a class="btn btn-outline-dark btn-block py-1 px-2">Avanzar</a>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modal_descuento" tabindex="-1" role="dialog" aria-labelledby="modal_descuento_label" aria-hidden="true">
                <div class="modal-dialog modal_descuentos" role="document">
                    <div class="modal-content cuerpo">
                        <div class="modal-header">
                            <h5 class="modal-title mx-auto" id="modal_descuento_label">Aplicar descuento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body form_carrito">
                            <table class="table table-light text-center">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border-0 "><b>Descuento fijo</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">$<input type="number" placeholder="00.00" class="modificar_precio xxl bb2" value="" autocomplete="off"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 "><b></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 "><b>Descuento por Porcentaje</b></td>
                                    </tr>
                                    <tr>
                                        <td>%<input type="number" placeholder="0.000" class="modificar_precio xxl bb2" value="" autocomplete="off"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 "></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 "></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <a class="btn success-color-dark py-1 px-2 btn-block">Aplicar descuento</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger py-1 px-2" data-dismiss="modal">Volver</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script>
        $(document).ready(function() {
        });
    </script>

</body>

</html>