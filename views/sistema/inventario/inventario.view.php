<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('stock', 'inventario'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">INVENTARIO</h2>
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
                                        <input type="text" class="form-control" name="search" placeholder="Buscar todos los productos" aria-label="" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <?php for ($i = 6; $i > 0; $i--) { ?>
                            <div class="col-lg-4 col-sm-6 col-12 producto px-1 " data-id="<?php echo $i; ?>">
                                <div class="card mb-2">
                                    <div class="card-body py-0">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href=""><img src="<?php echo $RUTA ?>galeria/sistema/index/<?php echo $i ?>.jpg" alt="" class="w-100"></a>

                                            </div>
                                            <div class="col-8">
                                                <div>
                                                    <div class="text-justify">
                                                        <h5 class="h5-responsive py-0 my-0"><b>Lorem ipsum dolor sit amet.</b></h5>
                                                        <div class="h6 py-0 my-0"><b>350 en Stock.</b></div>
                                                        <div class="desc">1M Azul</div>
                                                        <div class="desc">$ 550 .00 -- <small class="text-muted text-truncate1">$ 450.00</small></div>
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
                                            <h3 class="font-weight-bold">Detalles del producto</h3>
                                            <div class="row">
                                                <div class="col-lg-4 col-4 px-1">
                                                    <img src="<?php echo $RUTA; ?>galeria/sistema/index/1.jpg" class="img-fluid">
                                                    <a href="" class="btn btn-outline-info py-0 btn-block px-0"><i class="fas fa-camera fa-lg"></i> CAMBIAR</a>
                                                </div>
                                                <div class="col-lg-8 col-sm-8 col-12 text-justify text-md-left px-0">
                                                    <form method="GET" id="editar_producto">
                                                        <div class="form-group px-0">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="nombre_icon"><i class="fas fa-signature"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="nombre_icon" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-group px-0">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="codigo_icon"><i class="fas fa-barcode"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="Código" aria-label="Código" aria-describedby="codigo_icon" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <h5 class="h5-responsive py-0 my-0"><b>Lorem ipsum dolor sit amet.</b></h5>
                                                    <div class="h6 py-0 my-0"><b>350 en Stock.</b></div>
                                                    <div class="desc">1M Azul</div>
                                                    <div class="desc">$ 550 .00 -- <small class="text-muted text-truncate1">$ 450.00</small></div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="font-weight-normal text-right">
                                                        <p class=""><strong>Existencia: </strong>En stock</p>
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
            $("#vista_producto").modal('show');
            $("#agregar_carrito").on('click', function(e) {
                e.preventDefault();
            })
        });
    </script>
    <script></script>
    <div class="container my-5 py-3"></div>
</body>

</html>