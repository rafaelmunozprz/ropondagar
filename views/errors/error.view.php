<?php

use App\Models\Templates;

$TEMPLATE = new Templates();

$TEMPLATE->studylab = true;
$TEMPLATE->header();
?>

<body>

    <!-- END nav -->
    <?php $TEMPLATE->nav_bar('') ?>
    <div class="hero-wrap js-fullheight" style="background-image: url('<?php echo $RUTA; ?>galeria/sistema/index/bautizo.jpg');">
        <div class="overlay"></div>
        <div class="container-fluid">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <span class="subheading">Opss </span>
                    <h1 class="mb-4">Error <br>404</h1>
                    <p class="caps">La sección a la que acabas de ingresar no existe, puedes continuar visitando anguna de nuestras otras páginas</p>
                </div>
            </div>
        </div>
    </div>



    <?php echo $TEMPLATE->footer(); ?>
    <?php echo $TEMPLATE->scripts(); ?>
</body>