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
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="card-title fw-mediumbold">Creación de orden de producción</div>
                                    <div class="card-list">
                                        <div class="item-list  px-3 z-depth-1-half c-pointer">
                                            <div class="avatar">
                                                <img src="<?php echo $RUTA; ?>galeria/sistema/productos/3.jpg" alt="..." class="avatar-img rounded-circle">
                                            </div>
                                            <div class="info-user ml-3 ">
                                                <div class="username text-success">Agregar un modelo</div>
                                                <div class="status text-success">Agregar un modelo</div>
                                            </div>
                                            <button class="btn btn-icon btn-success btn-round btn-xs">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-none">
                            <div class="card modelo">
                                <div class="card-body">
                                    <div class="d-flex header_modelo ">
                                        <div class="avatar">
                                            <img src="<?php echo $RUTA; ?>/galeria/sistema/index/4.jpg" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                        <div class="info-post ml-2">
                                            <p class="username my-0">Modelo niña 2M talla CH</p>
                                            <p class="date text-muted my-0">Coto estimado: $350 .00 c/u</p>
                                            <p class="date text-muted my-0">Cantidad de materiales</p>
                                        </div>
                                    </div>
                                    <div class="cuerpo_modelo active">
                                        <div class="">
                                            <div class="card-list">
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
                            </div>
                        </div>
                        <?php for ($j = 0; $j < 5; $j++) { ?>
                            <div class="col-12">
                                <div class="card modelo mb-3">
                                    <div class="card-body">
                                        <div class="d-flex header_modelo ">
                                            <?php if ($j % 2) { ?>
                                                <div class="avatar">
                                                    <span class="avatar-title rounded-circle border border-white bg-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                </div>
                                            <?php } else { ?>
                                                <div class="avatar">
                                                    <img src="<?php echo $RUTA; ?>/galeria/sistema/index/4.jpg" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                            <?php } ?>

                                            <div class="info-post ml-2">
                                                <p class="username my-0">Modelo niña 2M talla CH</p>
                                                <p class="date text-muted my-0">Coto estimado: $350 .00 c/u</p>
                                                <p class="date text-muted my-0">Cantidad de materiales: <b>12</b></p>
                                            </div>

                                        </div>
                                        <div class="cuerpo_modelo">
                                            <div class="">
                                                <div class="card-list">
                                                    <?php for ($i = 0; $i < 6; $i++) { ?>
                                                        <div class="item-list">
                                                            <?php if ($i % 2) { ?>
                                                                <div class="avatar">
                                                                    <span class="avatar-title rounded-circle border border-white bg-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="avatar">
                                                                    <img src="<?php echo $RUTA; ?>/galeria/sistema/index/4.jpg" alt="..." class="avatar-img rounded-circle">
                                                                </div>
                                                            <?php } ?>
                                                            <div class="info-user ml-3">
                                                                <div class="username">Boton rosa de estilo</div>
                                                                <div class="status">Cantidad necesaria: 12</div>
                                                            </div>
                                                            <button class="btn btn-icon btn-primary btn-round btn-xs">
                                                                <i class="fas fa-exchange-alt"></i>
                                                            </button>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="item-list  px-3 z-depth-1-half c-pointer">
                                                        <div class="avatar">
                                                            <img src="<?php echo $RUTA; ?>galeria/sistema/productos/3.jpg" alt="..." class="avatar-img rounded-circle">
                                                        </div>
                                                        <div class="info-user ml-3 ">
                                                            <div class="username text-success">Agregar otro material</div>
                                                            <div class="status text-success">Elegir otro tipo de material</div>
                                                        </div>
                                                        <button class="btn btn-icon btn-success btn-round btn-xs">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card modelo mb-3">
                                    <div class="card-body">
                                        <div class="d-flex header_modelo ">
                                            <?php if ($j % 2) { ?>
                                                <div class="avatar">
                                                    <span class="avatar-title rounded-circle border border-white bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
                                                </div>
                                            <?php } else { ?>
                                                <div class="avatar">
                                                    <img src="<?php echo $RUTA; ?>galeria/sistema/index/4.jpg" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                            <?php } ?>

                                            <div class="info-post ml-2">
                                                <p class="username my-0">Modelo niña 2M talla CH</p>
                                                <p class="date text-muted my-0">Coto estimado: $350 .00 c/u</p>
                                                <p class="date text-muted my-0">Cantidad de materiales</p>
                                            </div>

                                        </div>
                                        <div class="cuerpo_modelo">
                                            <div class="">
                                                <div class="card-list">
                                                    <?php for ($i = 0; $i < 2; $i++) { ?>
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
                                                    <div class="item-list  px-3 z-depth-1-half c-pointer">
                                                        <div class="avatar">
                                                            <img src="<?php echo $RUTA; ?>/galeria/sistema/productos/3.jpg" alt="..." class="avatar-img rounded-circle">
                                                        </div>
                                                        <div class="info-user ml-3 ">
                                                            <div class="username text-success">Agregar otro material</div>
                                                            <div class="status text-success">Elegir otro tipo de material</div>
                                                        </div>
                                                        <button class="btn btn-icon btn-success btn-round btn-xs">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
            });
            $(".header_modelo").on('click', function(e) {
                e.preventDefault();
                $(this).parent().find(".cuerpo_modelo").toggle('slow', 'linear');
            });

        });
    </script>
    <script></script>
    <div class="container my-5 py-3"></div>
</body>

</html>