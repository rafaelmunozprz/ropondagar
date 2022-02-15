<?php

use App\Models\Proveedores;
use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin();

$CLIENT = new Proveedores();

$proveedor = $CLIENT->mostrar_proveedor($id_proveedor);
?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper bg-white">
        <?php $TEMPLATE->nav_bar_admin('proveedores', 'proveedores'); ?>
        <input type="hidden" id="id_proveedor" value="<?php echo $id_proveedor; ?>" hidden="hidden" style="display: none;" class="d-none disabled" disabled="disabled" autocomplete="off">

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col px-md-3 px-0">
                            <div class="card card-profile px-0">
                                <div class="card-header bg-primary">
                                    <div class="profile-picture">
                                        <div class="avatar avatar-online">
                                            <input type="hidden" id="id_proveedor" value="<?php echo $id_proveedor; ?>" hidden="hidden" class="hidden d-none" autocomplete="off">

                                            <span class="avatar-title rounded-circle border border-white bg-primary"><?php echo $proveedor['razon_social'][0]; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body mb-0 pb-0">
                                    <div class="user-profile text-center" id="perfil_principal">
                                        <div class="name"> <?php echo $proveedor['razon_social']; ?>.</div>
                                        <div class="job">Persona: <?php echo $proveedor['tipo_persona']; ?></div>
                                        <div class="tel"> <a href="tel:<?php echo $proveedor['telefono']; ?>"><?php echo $proveedor['telefono']; ?></a></div>
                                    </div>
                                </div>
                                <div class="card-body my-0 py-0 direccion_cont text-center">
                                    <a href="#" class="title h4 show_direccion text-dark"> <u>Dirección</u> <i class="fas fa-arrow-circle-down ml-3"></i></a>
                                    <div class="row content" style="display: none;">
                                        <div class="col-12" id="contenedor_direccion">
                                            <?php $direccion = !empty($proveedor['direccion']) ? $proveedor['direccion'][0] : false;
                                            if ($direccion) {
                                                echo '<p class="my-0 py-0">' . $direccion['estado'] . '</p>'
                                                    . '<p class="my-0 py-0">' . $direccion['ciudad'] . ' ' . $direccion['cp'] . '</p>'
                                                    . '<span>' . $direccion['colonia'] . ',</span>'
                                                    . '<span>' . $direccion['direccion'] . '</span> #'
                                                    . '<a class="ml-2">Int: ' . $direccion['numero_interno'] . '</a>'
                                                    . '<a class="ml-2">Ext: ' . $direccion['numero_externo'] . '</a>';
                                            } ?>

                                        </div>
                                        <div class="col-12">
                                            <a href="#" class="h4 show_direccion text-muted"> <u>Ocultar</u> <i class="fas fa-arrow-circle-up ml-3"></i></a>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col text-right">
                                            <a href="#" class="h4 text-info " id="mostrar_cambios_proveedor"> <u> <i class="fas fa-user-cog mr-2"></i> Modificar proveedor</u></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row user-stats text-center">
                                        <div class="col">
                                            <div class="number"><?php echo $proveedor['estado']; ?></div>
                                            <div class="title">
                                                <a class="btn btn-primary btn-border btn-round py-0" id="update_user" data-status="<?php echo $proveedor['estado']; ?>">
                                                    <i class="<?php echo ($proveedor['estado'] == 'activo' ? 'fas fa-toggle-on text-success' : 'fas fa-toggle-off text-warning'); ?> fa-2x"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="number"></div>
                                            <div class="title"></div>
                                        </div>
                                        <div class="col">
                                            <div class="number">134</div>
                                            <div class="title">Tiempo de registro</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col table-responsive mt-3">
                            <div class="row justify-content-between px-3" id="contenedor_estadisticas" style="min-width: 1350px;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form id="form_search_notas_p" method="GET">
                                <div class="form-group pb-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend ">
                                            <button class="btn btn-default btn-border qrcodecont" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar notas" autocomplete="off">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mb-3">
                            <u><a id="filtro_avanzado" class="text-primary"><i class="fas fa-filter mx-3 mt-2"></i> Filtro avanzado</a></u>
                            <div class="card p-1 mt-2" id="filter_content" style="display: none;">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-5 col-sm-6 col-12 ml-2 mb-2">
                                            <label class="form-label ml-3"><b><span id="icon_filter" class="mx-3"><i class="fas fa-toggle-off"></i></span> Estado de la nota</b></label>
                                            <div class="form-group pt-md-4 pt-2">
                                                <div class="selectgroup selectgroup-pills selectgroup-warning">
                                                    <label class="selectgroup-item ">
                                                        <input type="radio" name="estado" value="pendiente" class="selectgroup-input check_estado" autocomplete="off">
                                                        <span class="selectgroup-button">PENDIENTES</span>
                                                    </label>
                                                    <label class="selectgroup-item ">
                                                        <input type="radio" name="estado" value="pagado" class="selectgroup-input check_estado" autocomplete="off">
                                                        <span class="selectgroup-button">PAGADAS</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col ml-2 mb-2">
                                            <h5><b><i class="far fa-calendar-alt mr-3"></i>Filtrar por fechas</b></h5>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="md-form">
                                                        <label for="fecha_inicio"><b>Fecha de inicio</b></label>
                                                        <input type="date" id="fecha_inicio" class="form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="md-form">
                                                        <label for="fecha_limite"><b>Fecha de limite</b></label>
                                                        <input type="date" id="fecha_limite" class="form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 text-right">
                                            <a class="btn btn-round btn-danger pl-1 py-1 text-white" id="filter_cancel">
                                                <i class="fas fa-times-circle mx-2"></i>Cancelar filtro
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row " id="contenedor_notas"></div>
                    <div class="row justify-content-center bg-white my-2" id="paginacion_p">
                        <div class="col-md-6 col-8  ">
                            <a class="btn btn-secondary btn-border btn-round btn-block notas_proveedores">Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("modal/config_proveedor.modal.php"); ?>
            <?php include 'modal/pagos.modal.php'; ?>
            <?php include 'modal/impresiones.modal.php'; ?>
            <?php include 'modal/opciones.modal.php'; ?>

            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/editar_proveedor.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas_proveedores/cuerpo_notas.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas_proveedores/mostrar_notas.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas_proveedores/pagar_nota.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/proveedores/notas_proveedores/estadisticas.js"></script>


</body>

</html>