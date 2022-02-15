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
                                <h2 class="text-white fw-bold pb-0">VENTAS</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item w-50 text-center">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Maquila <i class="fas fa-tshirt ml-1 ml-md-3"></i></a>
                                </li>
                                <li class="nav-item w-50 text-center">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Materia Prima <i class="fas fa-shopping-bag ml-1 ml-md-3"></i></a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <div class="col p-0">
                                            <form id="form_search_almacen" method="GET">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                        </div>
                                                        <input type="text" class="form-control" name="search" placeholder="Código o nombre" aria-label="" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <?php for ($i = 1; $i < 7; $i++) { ?>
                                            <div class="col-lg-2 col-md-3 col-4 card-productos px-1 ">
                                                <div class="card card-post card-round">
                                                    <img class="card-img-top producto_carrito" src="<?php echo $RUTA; ?>galeria/sistema/index/<?php echo $i; ?>.jpg" alt="Card image cap">
                                                    <div class="card-body p-1">
                                                        <div class="d-flex">
                                                            <div class="info-post ml-2">
                                                                <p class="username">Joko Subianto</p>
                                                                <p class="date text-muted">20 Jan 18</p>
                                                            </div>
                                                        </div>
                                                        <div class="herramientas">
                                                            <a class="btn btn-primary text-white btn-rounded btn-sm agregar_carrito"><i class="fas fa-shopping-bag"></i></a>
                                                            <a class="btn btn-info text-white btn-rounded btn-sm producto_carrito"><i class="far fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="row">
                                        <div class="col p-0">
                                            <form id="form_search_materiaprima" method="GET">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                        </div>
                                                        <input type="text" class="form-control" name="search" placeholder="Código o nombre" aria-label="" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <?php for ($i = 6; $i > 3; $i--) { ?>
                                            <div class="col-lg-2 col-md-3 col-4 card-productos px-1 ">
                                                <div class="card card-post card-round">
                                                    <img class="card-img-top producto_carrito" src="<?php echo $RUTA; ?>galeria/sistema/index/<?php echo $i; ?>.jpg" alt="Card image cap">
                                                    <div class="card-body p-1">
                                                        <div class="d-flex">
                                                            <div class="info-post ml-2">
                                                                <p class="username">Joko Subianto</p>
                                                                <p class="date text-muted">20 Jan 18</p>
                                                            </div>
                                                        </div>
                                                        <div class="herramientas">
                                                            <a class="btn btn-primary text-white btn-rounded btn-sm agregar_carrito"><i class="fas fa-shopping-bag"></i></a>
                                                            <a class="btn btn-info text-white btn-rounded btn-sm producto_carrito"><i class="far fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner py-0">

                    <div class="continuar_venta active">
                        <div class="row vender">
                            <div class="col pt-2 mt-1 text-center">
                                <h3 class="ml-5"> <a href="<?php echo $RUTA; ?>sistema/pagonota"><span class="cantidad">56</span> productos = <span class="total">$256.00 mxn</span></a></h3>
                            </div>
                            <div class="col-2 pt-2 mt-1">
                                <i class="fas fa-hand-point-right fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="vista_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header py-1 px-2">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-post card-round">
                                <div class="card-body p-1">
                                    <div class="container">


                                        <!--Section: Content-->
                                        <section class="text-center">

                                            <!-- Section heading -->
                                            <h3 class="font-weight-bold">Detalles del producto</h3>

                                            <div class="row">
                                                <div class="col px-1">
                                                    <img src="<?php echo $RUTA; ?>galeria/sistema/index/1.jpg" class="img-fluid">
                                                </div>
                                                <div class="col-lg-5 col-7 text-justify text-md-left">
                                                    <h5 class="h5-responsive text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4">iPad PRO</h5>
                                                    <h6 class="h3-responsive text-md-left my-0 py-0">
                                                        <span class="red-text  my-0 py-0"><strong>$1449</strong></span>
                                                        <span class="grey-text "> <small> <s>$1789</s> </small></span>
                                                    </h6>
                                                    <p class="ml-xl-0 my-0 py-0"> <strong> Cantidad: </strong>64GB</p>
                                                    <p class="ml-xl-0 my-0 py-0"> <strong> Size: </strong>9.6-inch</p>
                                                    <p class="ml-xl-0 my-0 py-0"> <strong> Talla: </strong>2M</p>


                                                </div>
                                                <div class="col-12">
                                                    <div class="font-weight-normal">
                                                        <p class="ml-xl-0 ml-4"><strong>Availability: </strong>In stock</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary p-1">Agregar</button>
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
    <script>
        $(document).ready(function() {
            $(".producto_carrito").on('click', function() {
                $("#vista_producto").modal('show');
            });
            $("#vista_producto").modal('show');
            $("#agregar_carrito").on('click', function(e) {
                e.preventDefault();
            });
        });
    </script>
    <div class="container my-5 py-3"></div>
</body>

</html>