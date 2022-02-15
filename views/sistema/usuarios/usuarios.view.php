<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('usuarios', 'usuarios'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <form id="form_search_usuarios" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="search" placeholder="Buscar todos los usuarios" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-sm-6 col-12">
                            <a class="btn btn-default btn-border mt-2" id="nuevo_registro">Nuevo Usuario</a>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class=" col-xl-5 col-lg-6 col-md-7  col-sm-8 col-12 producto px-1 mb-2" id="nuevo_registro">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-info h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle border border-white">US</span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b><i class="fas fa-user-tie"></i> Nuevo Usuario</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="contenedor_usuarios"></div>
                    <div class="row justify-content-center bg-white my-2" id="paginacion">
                        <div class="col-md-6 col-8  " style="display: none;">
                            <a class="btn btn-secondary btn-border btn-round btn-block">Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php include_once('modal/new_user.modal.php'); ?>
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
    <script src="<?php echo $RUTA; ?>js/sistema/usuarios/new_user.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/usuarios/show_users.js"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>