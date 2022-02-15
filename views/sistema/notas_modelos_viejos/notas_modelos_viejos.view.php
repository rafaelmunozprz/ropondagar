<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$TEMPLATE->cropper = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('produccion', 'categorias'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">Notas de venta modelos Viejos</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">                    
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <form id="form_search_nota_modelo_viejo" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador_nota_modelo_viejo" placeholder="Buscar todas la notas" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 producto px-1 mb-2" id="nuevo_modelo_viejo">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-info h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle border border-white">CF</span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b><i class="fas fa-user-plus"></i> Nuevo modelo</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="row justify-content-between align-items-stretch" id="contenedor_notas_modelos_viejos"></div>
                    <div class="row">
                        <div class="col text-center my-2" style="display: none;">
                            <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <?php //include('modals/modificar_modelos_viejos.view.php') ?>
            <?php //include('modals/opciones_modelo_viejo.view.php') ?>
            <?php //include('modals/modelo_viejo_nuevo.view.php') ?>
            <?php //include('modals/agregar_stock.view.php') ?>
            <?php //include('modals/disminuir_stock_modelo_viejo.view.php') ?> -->
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/notas_modelos_viejos/nota_modelo_viejo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/notas_modelos_viejos/mostrar_notas_modelos_viejos.js"></script>
    
</body>

</html>