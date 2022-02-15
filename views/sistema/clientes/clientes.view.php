<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('usuarios', 'clientes'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <form id="form_search_clientes" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar todos los usuarios" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-sm-6 col-12">
                            <a class="btn btn-default btn-border mt-2">Nuevo Usuario</a>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class=" col-xl-5 col-lg-6 col-md-7  col-sm-8 col-12 producto px-1 mb-2" id="nuevo_registro">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-primary h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle border border-white">CL</span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b><i class="fas fa-user-tie"></i> Nuevo Cliente</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="contenedor_clientes"></div>
                    <div class="row">
                        <div class="col text-center my-2" style="display: none;">
                            <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("modal/new_cliente.modal.php"); ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->

    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/clientes/show_clientes.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/clientes/new_cliente.js"></script>
    <script>
        $(document).ready(function() {
            $(".toggle_user").on('click', function() {
                let button = $(this);
                button.children('.toggle_data').toggle('top');
                console.log(button);
            })
        });
    </script>
</body>

</html>