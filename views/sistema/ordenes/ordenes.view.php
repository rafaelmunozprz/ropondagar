<?php

use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$TEMPLATE->cropper = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('orden', 'orden'); ?>

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
                            <!-- <form id="form_search_modelos" method="GET">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar todos los productos" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                            </form> -->
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 orden_produccion px-1 mb-2" style="cursor: pointer;" id="nueva_orden_produccion">
                            <div class="card h-100 mb-2" style="min-height: 90px;">
                                <div class="card-body py-0 h-100">
                                    <div class="row align-items-center h-100">
                                        <div class="col text-center bg-info h-100 text-white pt-md-2 pt-2">
                                            <div class="avatar mt-md-3 mt-3">
                                                <span class="avatar-title rounded-circle border border-white">NO</span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="text-center">
                                                <h1 class="py-0 my-0"><b><i class="fas fa-clipboard-list"></i> Nueva orden</b></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="ordenes_produccion-tab" data-toggle="tab" href="#ordenes_produccion" role="tab" aria-controls="ordenes_produccion" aria-selected="true">Órdenes en producción</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ordenes_finalizadas-tab" data-toggle="tab" href="#ordenes_finalizadas" role="tab" aria-controls="ordenes_finalizadas" aria-selected="false">Órdenes finalizadas</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ordenes_espera-tab" data-toggle="tab" href="#ordenes_espera" role="tab" aria-controls="ordenes_espera" aria-selected="false">Órdenes en espera</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="ordenes_produccion" role="tabpanel" aria-labelledby="ordenes_produccion-tab">
                            <div class="row">
                                <div class="col">
                                    <form id="form_ordenes_produccion" method="POST">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-default btn-border" type="button"><i class="fas fa-file-alt"></i></button>
                                                </div>
                                                <input type="text" class="form-control" name="buscador_ordenes_produccion" placeholder="Buscar orden de producción, ejemplo: 789ASD6F8769" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-responsive">
                                <thead>
                                    <th>Grupo</th>
                                    <th># Orden</th>
                                    <th>Fecha</th>
                                    <th>Progreso</th>
                                    <th class="text-center">Ver Orden</th>
                                    <th class="text-center">Estado</th>
                                </thead>
                                <tbody id="contenedor_ordenes_produccion">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col text-center my-2" style="display: none;">
                                    <a class="btn btn-primary btn-border btn-round" id="paginacion_produccion">Mostrar más</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ordenes_finalizadas" role="tabpanel" aria-labelledby="ordenes_finalizadas-tab">
                            <div class="row">
                                <div class="col">
                                    <form id="form_ordenes_finalizadas" method="POST">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-default btn-border" type="button"><i class="fas fa-file-alt"></i></button>
                                                </div>
                                                <input type="text" class="form-control" name="buscador_ordenes_finalizadas" placeholder="Buscar orden de producción finalizadas, ejemplo: 789ASD6F8769" aria-label="" aria-describedby="basic-addon1" autocomplete="off">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <th>Estado</th>
                                    <th># Orden</th>
                                    <th>Fecha finalización</th>
                                    <th>Orden</th>
                                </thead>
                                <tbody id="contenedor_ordenes_finalizadas">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col text-center my-2" style="display: none;">
                                    <a class="btn btn-primary btn-border btn-round" id="paginacion_finalizadas">Mostrar más</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ordenes_espera" role="tabpanel" aria-labelledby="ordenes_espera-tab">
                            <table class="table table-responsive">
                                <thead>
                                    <th>Grupo</th>
                                    <th># Orden</th>
                                    <th>Fecha de registro</th>
                                    <th>Progreso</th>
                                    <th class="text-center">Acción</th>
                                    <th class="text-center">Eliminar</th>
                                </thead>
                                <tbody id="contenedor_ordenes_espera">
                                    <div class="row">
                                        <div class="col text-center my-2" style="display: none;">
                                            <a class="btn btn-primary btn-border btn-round" id="paginacion_espera">Mostrar más</a>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('modals/nueva_orden.view.php') ?>
            <?php include('modals/editar_orden_espera.view.php') ?>
            <?php include('modals/historial_cambios.view.php') ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/ordenes.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/ordenes_storage.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/nueva_orden_produccion.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/mostrar_modelos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/mostrar_articulos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/limpiar_ordenes.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/mostrar_ordenes_espera.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/eliminar_ordenes.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/ver_ordenes_espera.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/procesos_maquila.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/mostrar_ordenes_produccion.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ordenes/mostrar_ordenes_finalizadas.js"></script>
</body>

</html>