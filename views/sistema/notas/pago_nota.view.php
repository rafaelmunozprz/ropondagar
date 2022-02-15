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
                        <div class="col-12 p-0">
                            <div class="card p-0">
                                <div class="card-body p-0">
                                    <?php for ($i = 0; $i < 10; $i++) { ?>
                                        <div class="row form_carrito">
                                            <div class="col-md-2 col-3"><img src="<?php echo $RUTA; ?>galeria/sistema/index/1.jpg" alt="" class="img-fluid w-100" style="width: 100%; max-width: 100px"></div>
                                            <div class="col-md-10 col-9 " style="padding: 0 30px 0 10px;">
                                                <div class="row">
                                                    <div class="col descripcion">
                                                        <h5> Ropón avenute</h5>
                                                        <p class="text-muted mb-1">
                                                            Cantidad
                                                            <b class="h5 text-muted">
                                                                <input type="number" placeholder="0" class="modificar_precio" value="" autocomplete="off">
                                                            </b>
                                                        </p>
                                                        <p class="text-muted mb-1">
                                                            p/u:
                                                            <b class="h5 text-muted">
                                                                $<input type="number" placeholder="00.00" class="modificar_precio" value="" autocomplete="off">
                                                            </b>

                                                        </p>
                                                        <hr class="my-0">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <div class="btn-group radio-group ml-2 descuentos" data-id="1" data-cantidad="1">

                                                            <a class="btn btn-outline-warning py-1 px-md-3 px-2 mx-md-3 mx-1 accion_producto" data-action="remove"> <i class="fas fa-minus-circle text-warning"></i> <i class="fas fa-cart-arrow-down text-warning"></i> </a>
                                                            <a class="btn btn-outline-success py-1 px-md-3 px-2 mx-md-3 mx-1 accion_producto" data-action="add"><i class="fas fa-plus-circle text-success"></i> <i class="fas fa-cart-plus text-success"></i></a>

                                                            <a class="btn btn-outline-primary py-1 px-md-3 px-2 mx-md-3 mx-1 accion_producto" data-action="descuento"><i class="fas fa-tag mr-3"></i><i class="fas fa-percent text-info"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-12 text-right ">
                                                        <span class="text-right my-0 precio descuento"> $ <span class=" total_costo_producto">335.50</span> </span>
                                                        <span class="text-right my-0 precio ml-4"> <i class="fas fa-tag mr-2 text-success"></i> $ <span class=" total_costo_descuento">225.20</span> </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <hr class="my-2">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                        <div class="continuar_venta active">
                            <div class="row vender-lg">
                                <div class="col text-right py-3">
                                    <a class="text-white" href="<?php echo $RUTA; ?>sistema/cobronota"><span>Productos</span> <strong id="total_productos">1</strong></a><br>
                                    <a class="text-white" href="<?php echo $RUTA; ?>sistema/cobronota"><span>Total</span> <strong id="total_compra">$ 129.00</strong></a>
                                </div>
                                <div class="col-2 pt-2 mt-1 pt-4">
                                    <i class="fas fa-shopping-basket fa-lg "></i>
                                </div>
                            </div>
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
            $("#modal_descuento").modal('show');
            $(".accion_producto").on('click', function() {
                let descuento = $(this);
                if (descuento.attr('data-action') == 'descuento') {
                    $("#modal_descuento").modal('show');

                }
            })
        });
    </script>

</body>

</html>