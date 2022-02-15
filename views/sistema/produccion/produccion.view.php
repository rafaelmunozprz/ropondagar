<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('produccion', ''); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">Producción</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <form id="form_search_almacen" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="search" placeholder="Buscar todos los productos" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card card-info card-annoucement card-round">
                                <div class="card-body text-center">
                                    <div class="card-opening">Bienvenido, Leonardo Vázquez</div>
                                    <div class="card-desc">
                                        ¡Es momento de poner a nuestro equípo a trabajar! Manos a la obra
                                    </div>
                                    <div class="card-detail">
                                        <a href="<?php echo $RUTA; ?>sistema/produccion/nuevo" class="btn btn-light btn-rounded">Comenzar nueva orden</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Ordenes de producción</div>
                                        <div class="card-tools">
                                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php for ($i = 0; $i < 7; $i++) { ?>
                                        <div class="separator-dashed"></div>
                                        <div class="d-flex">
                                            <div class="avatar avatar-offline">
                                                <span class="avatar-title rounded-circle border border-white bg-secondary"><i class="fas fa-street-view"></i></span>
                                            </div>
                                            <div class="flex-1 ml-3 pt-1">
                                                <h6 class="text-uppercase fw-bold mb-1">4 prendas <span class="text-success pl-3">INICIADA</span></h6>
                                                <span class="text-muted">El proceso esta inicializado, <span class="text-success pl-3">4 procesos asignados</span></span>
                                                <p class="my-0"><span class="orange-text pl-3">Total usuarios <span><b>15</b></span></span></p>
                                            </div>
                                            <div class="float-right pt-1">
                                                <small class="text-muted">hace 1 semana</small>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
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
                                        <section class="text-center">
                                            <h3 class="font-weight-bold">Detalles del modelo</h3>
                                            <div class="row">
                                                <div class="col-lg-4 col-4 px-1">
                                                    <img src="<?php echo $RUTA; ?>galeria/sistema/index/1.jpg" class="img-fluid">
                                                    <a href="" class="btn btn-outline-info py-0 btn-block px-0"><i class="fas fa-camera fa-lg"></i> CAMBIAR</a>
                                                </div>
                                                <div class="col-lg-8 col-sm-8 col-12 text-justify text-md-left px-0">
                                                    <h5 class="h5-responsive py-0 my-0"><b>MODELO SHANEL 321548JMCB</b></h5>
                                                    <div class="h6 py-0 my-0"><b>350 en Stock.</b></div>
                                                    <div class="desc">1M Azul</div>
                                                    <div class="desc">5 Materiales</small></div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-title fw-mediumbold">Materiales</div>
                                    <div class="card-list">
                                        <div class="item-list  px-3 z-depth-1-half c-pointer my-3">
                                            <div class="avatar">
                                                <img src="<?php echo $RUTA; ?>galeria/sistema/productos/3.jpg" alt="..." class="avatar-img rounded-circle">
                                            </div>
                                            <div class="info-user ml-3 ">
                                                <div class="username text-success">Agregar material</div>
                                                <div class="status text-success">Buscar en stock</div>
                                            </div>
                                            <button class="btn btn-icon btn-success btn-round btn-xs">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <?php for ($i = 0; $i < 6; $i++) { ?>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img src="<?php echo $RUTA; ?>galeria/sistema/productos/1.jpg" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Boton rosa de estilo</div>
                                                    <div class="status">Cantidad necesaria: 12</div>
                                                </div>
                                                <button class="btn btn-icon btn-primary btn-round btn-xs">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary p-1" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary p-1">Guardar</button>
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
            $(".producto").on('click', function() {
                $("#vista_producto").modal('show');
            });
            $("#agregar_carrito").on('click', function(e) {
                e.preventDefault();
            })
        });
    </script>
    <script></script>
    <div class="container my-5 py-3"></div>
</body>

</html>