<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('ordenes', 'notas'); ?>

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
                    <div class="row ">
                        <div class="col table-responsive mt-3">
                            <div class="row justify-content-between" style="min-width: 1350px;">
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body p-3 text-center">
                                            <div class="text-right text-danger">
                                                -3%
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                            <div class="h1 m-0">$17,000,000. 00 MXN</div>
                                            <div class="text-muted mb-3">Total generado</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-body p-3 text-center">
                                            <div class="text-right text-success">
                                                3%
                                                <i class="fa fa-chevron-up"></i>
                                            </div>
                                            <div class="h1 m-0">27.3K</div>
                                            <div class="text-muted mb-3">Total de ingresos del dia</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="card">
                                        <div class="card-body p-3 text-center">
                                            <div class="text-right text-danger">
                                                -2%
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                            <div class="h1 m-0">$95</div>
                                            <div class="text-muted mb-3">Daily Earnings</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="card">
                                        <div class="card-body p-3 text-center">
                                            <div class="text-right text-danger">
                                                -1%
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                            <div class="h1 m-0">621</div>
                                            <div class="text-muted mb-3">Products</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form id="form_search_almacen" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="search" placeholder="Buscar entre las notas de los clientes" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="card p-0">
                                <?php for ($i = 0; $i < 10; $i++) { ?>
                                    <div class="card-body my-0 py-2 px-0">
                                        <div class="d-flex hoverable px-3">
                                            <div class="avatar avatar-online">
                                                <span class="avatar-title rounded-circle border border-white bg-info">J</span>
                                            </div>
                                            <div class="flex-1 ml-3 pt-1 ">
                                                <h6 class="text-uppercase fw-bold mb-1">Joko Subianto <span class="text-warning pl-3">PENDIENTE</span></h6>
                                                <p class="mb-0"><span class="text-success pl-3">$450.00</span></p>
                                                <span class="text-muted">PAGO EN EFECTIVO, 1 pago, total restante: $2 550.00</span>
                                            </div>
                                            <div class="float-right pt-1">
                                                <small class="text-muted">8:40 PM</small>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-outline-dark fw-bold my-sm-3 my-1 py-1 px-3 realizar_pago">Agregar pago</a>
                                        <a href="#" class="btn btn-outline-dark fw-bold my-sm-3 my-1 py-1 px-3 realizar_pago">Imprimir nota</a>
                                        <a href="#" class="btn btn-outline-dark fw-bold my-sm-3 my-1 py-1 px-3 realizar_pago">Visualizar</a>
                                        <div class="separator-dashed"></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modal_pagos" tabindex="-1" role="dialog" aria-labelledby="modal_descuento_label" aria-hidden="true">
                <div class="modal-dialog modal_descuentos" role="document">
                    <div class="modal-content cuerpo">
                        <div class="modal-header">
                            <h5 class="modal-title mx-auto" id="modal_descuento_label">Generar pago de nota</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body px-0 form_carrito">
                            <div class="pago">
                                <table class="table table-light text-center pago_nota">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" class="border-0 "><b>Total de pago</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span class="precio text-success fa-sm"><input type="number" placeholder="0.000" class="modificar_precio bb2" value="$ 5,000.00" autocomplete="off"></span></td>
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
                                                <a class="btn btn-outline-dark btn-block py-1 px-2">Realizar pago</a>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger py-1 px-2" data-dismiss="modal">Volver</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <div class="container my-5 py-3"></div>
    <script>
        $(document).ready(function() {
            let FUNC = new Funciones();
            FUNC.input_number(".modificar_precio");
            $(".descripcion").on('click', function() {
                let producto = $(this).parent().parent();
                producto.find('.descuentos').toggle('show');
            });
            // $("#modal_descuento").modal('show');
            $(".realizar_pago").on('click', function() {
                let descuento = $(this);
                // if (descuento.attr('data-action') == 'descuento') {
                $("#modal_pagos").modal('show');

                // }
            })
        });
    </script>

</body>

</html>