<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$TEMPLATE->cropper = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('produccion', 'modelos'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">Modelos</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Recortar imagen</h5>
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
                                    <button type="button" class="btn btn-primary" id="crop">Recortar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#funciones_modelos" role="tab" aria-controls="home" aria-selected="true">Modelos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#historial_movimientos_tab" role="tab" aria-controls="profile" aria-selected="false">Historial</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="desactivados-tab" data-toggle="tab" href="#desactivados_tab" role="tab" aria-controls="desactivados" aria-selected="false">Desactivados</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-4" id="funciones_modelos" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col">
                                <form id="form_search_modelos" method="GET">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                            </div>
                                            <input type="text" class="form-control" name="buscador" placeholder="Buscar todos los productos" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 producto px-1 mb-2" id="nuevo_producto">
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
                                                    <h1 class="py-0 my-0"><b><i class="fas fa-user-tie"></i> Nuevo modelo</b></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 producto px-1 mb-2">
                                <div class="card h-100 mb-2" style="min-height: 90px;">
                                    <div class="card-body py-0 h-100">
                                        <div class="row align-items-center h-100">
                                            <div class="col text-center bg-info h-100 text-white pt-md-2 pt-2">
                                                <div class="avatar mt-md-3 mt-3">
                                                    <span class="avatar-title rounded-circle border border-white">V</span>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="text-center">
                                                    <a class="text-secondary" style="text-decoration: none;" href="<?php echo $RUTA; ?>sistema/ventas">
                                                        <h1 class="py-0 my-0 text-info"><b><i class="fas fa-user-tie"></i> Vender</b></h1>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between" id="contenedor_modelos"></div>
                        <div class="row">
                            <div class="col text-center my-2" style="display: none;">
                                <a class="btn btn-primary btn-border btn-round" id="paginacion">Mostrar más</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-1" id="historial_movimientos_tab" role="tabpanel" aria-labelledby="profile-tab">
                        <!-- INICIO -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="hoy-tab" data-toggle="tab" href="#hoy" role="tab" aria-controls="hoy" aria-selected="true">Hoy</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ayer-tab" data-toggle="tab" href="#ayer" role="tab" aria-controls="ayer" aria-selected="false">Ayer</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="siete_dias-tab" data-toggle="tab" href="#siete_dias" role="tab" aria-controls="siete_dias" aria-selected="false">7 días</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="treinta_dias-tab" data-toggle="tab" href="#treinta_dias" role="tab" aria-controls="treinta_dias" aria-selected="false">30 días</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="siempre_dias-tab" data-toggle="tab" href="#siempre_dias" role="tab" aria-controls="siempre_dias" aria-selected="false">Todo</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="hoy" role="tabpanel" aria-labelledby="hoy-tab">
                                <div class="row">
                                    <div class="col">
                                        <form id="form_historial_hoy" method="POST">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" name="buscador" placeholder="Buscar código" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                                    <button type="button" class="btn btn-success ml-1" id="excel_hoy"><i class="fas fa-file-excel"></i> Descargar Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Proceso</th>
                                                <th>Modelo</th>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedor_hoy">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ayer" role="tabpanel" aria-labelledby="ayer-tab">
                                <div class="row">
                                    <div class="col">
                                        <form id="form_historial_ayer" method="POST">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" name="buscador" placeholder="Buscar código" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                                    <button type="button" class="btn btn-success ml-1" id="excel_ayer"><i class="fas fa-file-excel"></i> Descargar Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Proceso</th>
                                                <th>Modelo</th>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedor_ayer">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="siete_dias" role="tabpanel" aria-labelledby="siete_dias-tab">
                                <div class="row">
                                    <div class="col">
                                        <form id="form_historial_siete_dias" method="POST">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" name="buscador" placeholder="Buscar código" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                                    <button type="button" class="btn btn-success ml-1" id="excel_siete_dias"><i class="fas fa-file-excel"></i> Descargar Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Proceso</th>
                                                <th>Modelo</th>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedor_siete_dias">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="treinta_dias" role="tabpanel" aria-labelledby="treinta_dias-tab">
                                <div class="row">
                                    <div class="col">
                                        <form id="form_historial_treinta_dias" method="POST">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" name="buscador" placeholder="Buscar código" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                                    <button type="button" class="btn btn-success ml-1" id="excel_treinta_dias"><i class="fas fa-file-excel"></i> Descargar Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Proceso</th>
                                                <th>Modelo</th>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedor_treinta_dias">
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade " id="siempre_dias" role="tabpanel" aria-labelledby="siempre_dias-tab">
                                <div class="row">
                                    <div class="col">
                                        <form id="form_historial_siempre" method="POST">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                    </div>
                                                    <input type="text" class="form-control" name="buscador" placeholder="Buscar código" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                                    <button type="button" class="btn btn-success ml-1" id="excel_siempre"><i class="fas fa-file-excel"></i> Descargar Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Proceso</th>
                                                <th>Modelo</th>
                                                <th>Fecha</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedor_siempre">
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col text-center my-2" style="display: none;">
                                            <a class="btn btn-primary btn-border btn-round" id="paginacion_siempre">Mostrar más</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- FIN -->
                    </div>
                    <div class="tab-pane fade activep-4" id="desactivados_tab" role="tabpanel" aria-labelledby="desactivados-tab">
                        <div class="row">
                            <div class="col">
                                <form id="form_search_modelos_desactivados" method="POST">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                            </div>
                                            <input type="text" class="form-control" name="buscador" placeholder="Buscar todos los productos" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row justify-content-between" id="contenedor_modelos_desactivados"></div>
                        <div class="row">
                            <div class="col text-center my-2" style="display: none;">
                                <a class="btn btn-primary btn-border btn-round" id="paginacion_desactivados">Mostrar más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('modals/nuevo_modelo.view.php') ?>
            <?php include('modals/editar_modelo.view.php') ?>
            <?php include('modals/opciones_modelo.view.php') ?>
            <?php include('modals/agregar_stock_modelo.view.php') ?>
            <?php include('modals/ajustar_precio_modelo.view.php') ?>
            <?php include('modals/disminuir_stock_modelo.view.php') ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/categorias/categorias.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/materiaprima.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/nuevo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/mostrar.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/modificar.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/modificar_imagen.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/ajustar_precio_modelo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/disminuir_stock_modelo.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/historiales.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/archivos_excel.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/modelos/mostrar_modelos_desactivados.js"></script>
</body>

</html>