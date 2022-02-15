<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('ordenes', 'nueva_venta'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col px-0">
                            <ul class="nav nav-pills nav-secondary px-0 mx-0" id="pills-tab" role="tablist">
                                <li class="nav-item w-50 text-center">
                                    <a class="nav-link active px-0" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Ropones y producción<i class="fas fa-tshirt ml-1 ml-md-3"></i></a>
                                </li>
                                <li class="nav-item w-50 text-center">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Materia Prima <i class="fas fa-shopping-bag ml-1 ml-md-3"></i></a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2 mb-3 px-4" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <form id="form_search_almacen" method="POST">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-dark" type="button" id="search_advance"><i class="fas fa-qrcode"></i></button>
                                                        </div>
                                                        <input type="text" class="form-control" id="buscador_inventario" name="buscador" placeholder="Buscar materia prima para nota" autocomplete="off">
                                                    </div><button type="submit" hidden class="d-none"></button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-12 venta-h" style="display:none;">
                                            <div class="col-12 text-right">
                                                <a class="btn btn-dark btn-border btn-round btn-sm py-1 hide_cont_nota"><i class="fas fa-arrow-circle-up mr-2"></i> Ocultar</a>
                                            </div>
                                            <div class="row" id="contenedor_inventario"></div>
                                            <div class="row">
                                                <div class="col text-center my-2" style="display: none;">
                                                    <a class="btn btn-primary btn-border btn-round" id="paginacion_inv">Mostrar más</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <form id="form_search_materiaprima" method="POST">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-dark" type="button" id="search_advance_mp"><i class="fas fa-qrcode"></i></button>
                                                        </div>
                                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar materia prima para nota" autocomplete="off">
                                                    </div> <button type="submit" hidden class="d-none"></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-12 venta-h" style="display:none;">
                                            <div class="col-12 text-right">
                                                <a class="btn btn-dark btn-border btn-round btn-sm py-1 hide_cont_nota"><i class="fas fa-arrow-circle-up mr-2"></i> Ocultar</a>
                                            </div>
                                            <div class="row" id="contenedor_materias"></div>
                                            <div class="row">
                                                <div class="col text-center my-2" style="display: none;">
                                                    <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="contenedor_nota"></div>
                    <div class="row">
                        <div class="col-md-4 col-6 my-2"><a class="btn btn-warning btn-border btn-round  btn-block" id="limpiar_nota_venta"> <span class="btn-label"> <i class="fas fa-broom"></i></span>Limpiar nota</a></div>
                    </div>
                </div>
                <div class="page-inner py-0">

                    <div class="continuar_venta active">
                        <div class="row vender" id="total_nota">
                            <div class="col pt-2 mt-1 text-center">
                                <h3 class="ml-5"> <a href="<?php echo $RUTA; ?>sistema/pagonota"><span class="cantidad">0</span> productos = <span class="total">$0.00 mxn</span></a></h3>
                            </div>
                            <div class="col-2 pt-2 mt-1">
                                <i class="fas fa-hand-point-right fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../views/sistema/proveedores/modal/notificacion.modal.php'; ?>
            <?php include '../views/sistema/proveedores/modal/descuento.modal.php'; ?>
            <?php include '../views/sistema/proveedores/modal/pagos.modal.php'; ?>
            <?php include 'modal/cliente.modal.php'; ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>

    <!-- <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script> -->
    <!-- MOSTRAR CLIENTES -->
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/clientes/clientes.js"></script>
    <!-- VISTA DE LA NOTA -->
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/nota/nota_storage.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/nota/model_nota.js"></script>
    <!-- VISTA DE LA MATERIA PRIMA -->
    <script src="<?php echo $RUTA; ?>js/sistema/materiaprima/model_materia.js"></script>
    <!-- VISTA DE MODELOS -->
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/modelos/model_modelos.js"></script>
    <!-- CONSTRUCTORES -->
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/modelos/modelos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/materia/materia.js"></script>
    <!-- Script editar la nota y agregar descuentos -->
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/nota/descuentos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/nota/nota.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ventas/nota/finalizar.js"></script>
    <!-- CONSTRUCTORES -->
    <div class="container my-5 py-1"></div>
</body>

</html>