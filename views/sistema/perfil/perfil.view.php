<?php

use App\Models\TemplateAdmin;
use App\Models\Usuarios;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);

$TEMPLATE->header();
$TEMPLATE->library_admin();

$USER  =  new Usuarios();
$usuario = $USER->buscar_usuario($USERSYSTEM['idUsuario']);

?>

<!-- Fonts and icons -->

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('perfil', ''); ?>

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
                                    <a href="#" class="title h4 show_direccion text-dark" style="display: none;"> <u>Dirección</u> <i class="fas fa-arrow-circle-down ml-3"></i></a>
                                    <div class="row content">
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
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="form-group">
                                                <div class="input-group mb-0">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">@</span>
                                                    </div>
                                                    <input type="text" class="form-control disabled" disabled placeholder="Nombre de usuario" value="<?php echo $usuario['nombre_usuario']; ?>" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row password_cont">
                                        <div class="col-12 form_pass" style="display: none;">
                                            <form action="#" id="cambiar_password" method="post">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group my-0 py-0">
                                                            <label for="user_name" class="mb-0">Contraseña actual</label>
                                                            <input type="text" class="form-control" name="password" id="password" placeholder="Contraseña actual" autocomplete="off">
                                                        </div>
                                                        <div class="form-group my-0 py-0">
                                                            <label for="user_lastname" class="mb-0">Nueva contraseña</label>
                                                            <input type="text" class="form-control" name="new_password" id="new_password" placeholder="Nueva contraseña" autocomplete="off">
                                                        </div>
                                                        <div class="form-group my-0 py-0">
                                                            <label for="user_tel" class="mb-0">Repite tu nueva contraseña</label>
                                                            <input type="text" class="form-control" name="r_new_password" id="r_new_password" placeholder="Repite tu nueva contraseña" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-2 text-center">
                                                        <button type="submit" class="btn btn-success p-1 px-4 "> Actualizar datos</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col text-center button_pass">
                                            <div class="btn btn-outline-dark p-1" id="show_change_pass">Cambiar Contraseña</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="<?php echo $RUTA; ?>js/sistema/perfil/cambiar_pass.js"></script>
</body>

</html>