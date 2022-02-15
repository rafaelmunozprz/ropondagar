<?php

use App\Models\TemplateAdmin;
use App\Models\Usuarios;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin();

$USER  =  new Usuarios();

$usuario = $USER->buscar_usuario($id_usuario);
?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('usuarios', 'usuarios'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col px-md-3 px-0">
                            <div class="card card-profile px-0">
                                <div class="card-header bg-info">
                                    <div class="profile-picture">
                                        <div class="avatar avatar-xl ">
                                            <input type="hidden" id="id_usuario" value="<?php echo $id_usuario; ?>" hidden="hidden" class="hidden d-none" autocomplete="off">
                                            <img src=" <?php echo $RUTA . $usuario['imagen']; ?>" alt="..." class="Imagen de perfil" style="width: 5rem; height: 5rem; border-radius: 50%; cursor:pointer;">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body mb-0 pb-0">
                                    <div class="user-profile text-center" id="perfil_principal">
                                        <div class="name"> <?php echo $usuario['nombre'] . " " . $usuario['apellidos']; ?>.</div>
                                        <div class="job"> <?php echo $usuario['cargo']; ?></div>
                                        <div class="contact"> <a href="te:<?php echo $usuario['telefono']; ?>"><?php echo $usuario['telefono']; ?></a></div>
                                    </div>
                                </div>
                                <div class="card-body my-0 py-0 direccion_cont text-center">
                                    <a href="#" class="title h4 show_direccion text-dark"> <u>Dirección</u> <i class="fas fa-arrow-circle-down ml-3"></i></a>
                                    <div class="row content" style="display: none;">
                                        <div class="col-12" id="contenedor_direccion">
                                            <?php echo $usuario['direccion'] != "" ? '<p class="my-0 py-0">' . $usuario['direccion'][0]['estado'] . '</p>' : ""; ?>
                                            <?php echo $usuario['direccion'] != "" ? '<p class="my-0 py-0">' . $usuario['direccion'][0]['ciudad'] . ' ' . $usuario['direccion'][0]['cp'] . '</p>' : ""; ?>
                                            <?php echo $usuario['direccion'] != "" ? '<span>' . $usuario['direccion'][0]['colonia'] . ',</span>' : ""; ?>
                                            <?php echo $usuario['direccion'] != "" ? '<span>' . $usuario['direccion'][0]['direccion'] . '</span> #' : ""; ?>
                                            <?php echo $usuario['direccion'] != "" ? '<a class="ml-2">Int: ' . $usuario['direccion'][0]['numero_interno'] . '</a>' : ""; ?>
                                            <?php echo $usuario['direccion'] != "" ? '<a class="ml-2">Ext: ' . $usuario['direccion'][0]['numero_externo'] . '</a>' : ""; ?>

                                        </div>
                                        <div class="col-12">
                                            <a href="#" class="h4 show_direccion text-muted"> <u>Ocultar</u> <i class="fas fa-arrow-circle-up ml-3"></i></a>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col text-right">
                                            <a href="#" class="h4 text-info " id="mostrar_cambios_usuario"> <u> <i class="fas fa-user-cog mr-2"></i> Modificar usuario</u></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row user-stats text-center">
                                        <div class="col">
                                            <div class="number"><?php echo $usuario['estado']; ?></div>
                                            <div class="title">
                                                <a class="btn btn-primary btn-border btn-round py-0" id="update_user" data-status="<?php echo $usuario['estado']; ?>">
                                                    <i class="<?php echo ($usuario['estado'] == 'activo' ? 'fas fa-toggle-on text-success' : 'fas fa-toggle-off text-warning'); ?> fa-2x"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="number">Contraseña</div>
                                            <div class="title">
                                                <a id="reset_password" class="btn btn-primary btn-border btn-round py-1 px-1">Reiniciar</a>
                                            </div>
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
                    <div class="row">
                        <div class="col px-md-3 px-0">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Ordenes de producción</div>
                                        <div class="card-tools">
                                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php for ($i = 0; $i < 7; $i++) { ?>
                                        <div class="separator-dashed"></div>
                                        <div class="d-flex">
                                            <div class="avatar avatar-offline">
                                                <span class="avatar-title rounded-circle border border-white bg-secondary"><i class="fas fa-street-view"></i></span>
                                            </div>
                                            <div class="flex-1 ml-3 pt-1">
                                                <h6 class="text-uppercase fw-bold mb-1">4 prendas <span class="text-success pl-3">INICIADA</span></h6>
                                                <span class="text-muted">El proceso esta inicializado, <span class="text-danger">2 </span> de <span class="text-success">4 </span>procesos asignados</span>
                                                <p class="my-0"><span class="orange-text pl-3">Total usuarios <span><b>15</b></span></span></p>
                                            </div>
                                            <div class="float-right pt-1">
                                                <small class="text-muted">hace 1 semana</small>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("modal/config_user.modal.php"); ?>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/usuarios/editar_usuario.js"></script>
</body>

</html>