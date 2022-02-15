<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$TEMPLATE->jsBarCode = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('stock', 'materiaprima'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">MATERIA PRIMA</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <form id="form_search_materias" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar todos los productos" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12" id="nueva_materia_prima">
                            <div class="card p-1 mb-2">
                                <div class="card-body c-pointer  p-1">
                                    <div class="d-flex ">
                                        <div class="avatar producto">
                                            <span class="avatar-title rounded-circle border border-primary bg-primary"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="flex-1 ml-3 pt-2 text-center">
                                            <h3>Registrar materia prima</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12" id="nueva_categoria">
                            <div class="card p-1 mb-2">
                                <div class="card-body c-pointer  p-1">
                                    <div class="d-flex ">
                                        <div class="avatar producto">
                                            <span class="avatar-title rounded-circle border border-primary bg-primary"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="flex-1 ml-3 pt-2 text-center">
                                            <h3>Nueva categoría</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="contenedor_materias"></div>
                    <div class="row">
                        <div class="col text-center my-2" style="display: none;">
                            <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php include("modals/nuevo.modal.php"); ?>
            <?php include("modals/editar.modal.php"); ?>
            <?php include("modals/nuevaCategoria.modal.php"); ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/categorias/categorias.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/categorias/nueva_categoria.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/materiaprima/model_materia.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/materiaprima/nuevo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/materiaprima/mostrar.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/materiaprima/editar.js"></script>
</body>

</html>