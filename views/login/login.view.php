<?php

use App\Models\Templates;

$TEMPLATE = new Templates();

$TEMPLATE->recaptcha = true;
$TEMPLATE->studylab = true;
$TEMPLATE->header();
?>

<body>

    <!-- END nav -->
    <?php $TEMPLATE->nav_bar('login') ?>
    <div class="hero-wrap js-fullheight d-md-block d-none" style="background-image: url('<?php echo $RUTA; ?>galeria/sistema/index/bautizo.jpg');">
        <div class="overlay"></div>
        <div class="container-fluid">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <h1 class="mb-4">Es momento de seguir trabajando juntos</h1>
                    <p class="caps">Es momento de trabajar juntos por la “Ruta Hacia Un Futuro Compartido”</p>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5 order-md-last">
                    <div class="login-wrap p-4 p-md-5">
                        <h3 class="mb-4 brown-text">Iniciar sesión</h3>
                        <form id="login_formulario">
                            <div class="form-group">
                                <label class="label" for="correo">Usuario o correo</label>
                                <input type="text" class="form-control" placeholder="Nombre de usuario o correo" name="correo" id="correo">
                            </div>
                            <div class="form-group">
                                <label class="label" for="password">Contraseña</label>
                                <input id="password" name="password" type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="<?php echo $TEMPLATE->keyCaptcha_public; ?>"></div>
                            </div>
                            <div class="form-group d-flex justify-content-end mb-0">
                                <button type="submit" class="btn brown lighten-2 text-white submit">Ingresar<span class="fa fa-paper-plane ml-4"></span></button>
                            </div>
                        </form>
                        <p class="text-center">¡Es momento de seguir trabajando!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- loader -->


    <?php echo $TEMPLATE->footer(); ?>
    <?php echo $TEMPLATE->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/login/login.js"></script>


</body>