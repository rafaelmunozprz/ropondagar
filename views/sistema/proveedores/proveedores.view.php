<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('proveedores', 'proveedores'); ?>
        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <form id="form_search_proveedores" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar proveedor" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-xl-5 col-lg-6 col-md-7  col-sm-8 col-12 producto px-1 mb-2" id="nuevo_registro">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-primary h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle border border-warning bg-white"><i class="fas fa-user-tie text-dark"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b> Nuevo Proveedor</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-7  col-sm-8 col-12 producto px-1 mb-2 evento_click" data-href="<?php echo $RUTA; ?>sistema/proveedor/notas">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-primary h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle border border-white"><i class="fas fa-clipboard"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-9 px-md-1 px-0">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b>Nueva nota</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="contenedor_proveedores"></div>
                    <div class="row">
                        <div class="col text-center my-2" style="display: none;">
                            <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("modal/new_proveedor.modal.php"); ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->

    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/show_proveedores.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/new_proveedor.js"></script>
    <script>
        $(document).ready(function() {
            $(".toggle_user").on('click', function() {
                let button = $(this);
                button.children('.toggle_data').toggle('top');
                console.log(button);
            });

            $(".evento_click").on('click', function() {
                let enlace = $(this).data("href");
                location.href = enlace;
            })
        });
    </script>
</body>

</html>