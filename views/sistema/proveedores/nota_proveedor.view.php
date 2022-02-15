<?php

use App\Models\Funciones;
use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$FUNC = new Funciones();

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('proveedores', 'nota_proveedor'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">NOTA</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form id="form_search_almacen" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar materia prima para nota" autocomplete="off">
                                    </div><input type="button" value="" hidden class="d-none">
                                </div>
                            </form>
                        </div>
                        <div class="col-12 clientes-h">
                            <div class="row " id="contenedor_materias"></div>
                            <div class="row justify-content-center bg-white my-2" id="paginacion">
                                <div class="col-md-6 col-8  " style="display: none;">
                                    <a class="btn btn-secondary btn-border btn-round btn-block">Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right py-0" style="display: none;"><a class="btn btn-danger btn-border btn-round btn-sm" id="borrar_busqueda"> <i class="far fa-times-circle"></i> CERRAR</a></div>
                    </div>
                    <div class="row">
                        <div class="col px-0">
                            <div class="card">
                                <div class="card-body pb-0 text-center">
                                    <div class="row">
                                        <div class="col">
                                            <h2>Nota <?php echo $TEMPLATE->SISTEMNAME; ?></h2>
                                            <input type="hidden" value="<?php echo date("Y-m-d"); ?>" hidden id="fecha_actual" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0" id="config_nota_proveedor" style="cursor: pointer;">
                                    <div class="text-right">
                                        <div class="">
                                            <small class="text-muted"><?php echo date('d') . " de " . $FUNC->meses(((int)date('m'))) . " de " . date('Y') ?></small>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="avatar avatar-online">
                                            <span class="avatar-title rounded-circle border border-white bg-info">J</span>
                                        </div>
                                        <div class="flex-1 ml-3 pt-1">
                                            <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">Sin nombre de proveedor</span></h6>
                                            <p class="my-0 py-0">Dirección:<span class="text-muted"> Sin dirección</span></p>
                                            <p class="my-0 py-0">Ciudad:<span class="text-muted"> Sin ciudad</span></p>
                                            <p class="my-0 py-0">Email:<span class="text-muted"> no-email@email.com</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col table-responsive" id="tabla_nota">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-6 my-2"><a class="btn btn-warning btn-border btn-round  btn-block" id="clear_nota_venta"> <span class="btn-label"> <i class="fas fa-broom"></i></span>Limpiar nota</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include 'modal/pagos.modal.php'; ?>
                <?php include 'modal/modificar_producto.modal.php'; ?>
                <?php include 'modal/proveedores.modal.php'; ?>
                <?php include 'modal/descuento.modal.php'; ?>
                <?php include 'modal/notificacion.modal.php'; ?>
            </div>
            <?php echo $TEMPLATE->footer_admin(); ?>
            <br><br><br><br><br><br>
            <div class="page-inner py-0">

                <div class="continuar_venta active">
                    <div class="row vender" id="print_PDF">
                        <div class="col pt-2 mt-1 text-center">
                            <h3 class="ml-5" id="total_nota"> <a href="<?php echo $RUTA; ?>sistema/pagonota"><span class="cantidad">0</span> prod <span class="total">$0.00 mxn</span></a></h3>
                        </div>
                        <div class="col-2 pt-2 mt-1">
                            <i class="fas fa-hand-point-right fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas/nueva_nota.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas/mostrar_proveedores.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas/materia_prima.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas/descuentos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas/finalizar_nota.js"></script>
    <!-- <script src="<?php echo $RUTA; ?>js/sistema/proveedores/des.js"></script> -->
    <!-- <script src="<?php echo $RUTA; ?>js/sistema/proveedores/send_mail.js"></script> -->
</body>

</html>