<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$TEMPLATE->cropper = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('stock', 'anaqueles'); ?>

        <div class="main-panel">
            <div class="content ">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">ANAQUELES</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 anaquel px-1 mb-2" style="cursor: pointer;" data-toggle="modal" data-target="#modal_nuevo_anaquel" id="nuevo_anaquel">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-success h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title bg-success rounded-circle border border-white"><i class="fas fa-pallet"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b> Nuevo anaquel</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-stretch" id="contenedor_anaqueles"></div>
                    <div class="row">
                        <div class="col text-center my-2" style="display: none;">
                            <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                        </div>
                    </div>
                </div>
                
            </div>
            


            <?php include('modals/nuevo_anaquel.view.php') ?>
            <?php include('modals/editar_anaquel.view.php') ?>
            <?php include('modals/insertar_materia.view.php') ?>
            <?php include('modals/lista_materia.view.php') ?>
            <?php include('modals/redimensionar_anaquel.view.php') ?>
            
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>

    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>

    
    <script src="<?php echo $RUTA; ?>js/sistema/anaqueles/nuevo_anaquel.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/anaqueles/mostrar-anaqueles.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/anaqueles/crear-grid-anaqueles.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/anaqueles/editar-anaqueles.js"></script>

    

</body>

</html>