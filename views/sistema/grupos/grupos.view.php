<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$TEMPLATE->cropper = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('usuarios', 'grupos'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">Grupos de trabajo</h2>
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
                            <form id="form_search_grupos" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador_grupos" placeholder="Buscar en todos los grupos" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 producto px-1 mb-2" id="nuevo_grupo">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-success h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle bg-success border border-white">NG</span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b><i class="fas fa-users"></i> Nuevo grupo</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-stretch" id="contenedor_grupos"></div>
                    <div class="row">
                        <div class="col text-center my-2" style="display: none;">
                            <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('modals/nuevo_grupo.view.php') ?>
            <?php include('modals/opciones_grupo.view.php') ?>
            <?php include('modals/editar_grupo.view.php') ?>
            <?php include('modals/agregar_personal.view.php') ?>
            <?php include('modals/eliminar_personal.view.php') ?>
            <?php include('modals/determinar_encargado.view.php') ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/grupos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/mostrar_grupos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/nuevo_grupo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/opciones_grupo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/modificar_grupos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/eliminar_grupos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/agregar_personal.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/mostrar_personal_agregar.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/grupos/determinar_encargado.js"></script>
    
</body>

</html>