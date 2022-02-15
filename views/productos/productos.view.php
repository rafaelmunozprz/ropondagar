<?php

use App\Models\Templates;

$TEMPLATE = new Templates();

$TEMPLATE->studylab = true;
$TEMPLATE->TITULO = 'Productos | ' . $TEMPLATE->TITULO;
$TEMPLATE->header();
?>

<body>    
    <section class="ftco-section bg-light">
        <div class="container">
            <!--Ropones-->
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Ropones para Bautizo de Niña y Niño</span>
                    <h2 class="mb-4">Ropones</h2>
                </div>
            </div>
            <div class="row">
                <?php for ($i = 1; $i < 13; $i++) { ?>
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="#" class="img" style="background-image: url(<?php echo $RUTA; ?>galeria/sistema/index/ropones/<?php echo $i; ?>.jpg);">
                                <span class="price">ROPONES DAGAR</span>
                            </a>
                            <div class="text p-4">
                                <h3><a href="#">Maquilado en San Miguel el Alto, Jal.</a></h3>
                                <p>Creado: <span class="brown-text">DISEÑOS DAGAR</span></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!--Velas-->
            <div class="row justify-content-center">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Velas</h2>
                </div>
            </div>
            <div class="row">
                <?php for ($i = 1; $i < 4; $i++) { ?>
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="#" class="img" style="background-image: url(<?php echo $RUTA; ?>galeria/sistema/index/velas/<?php echo $i; ?>.jpeg);">
                                <span class="price">VELAS DAGAR</span>
                            </a>
                            <div class="text p-4">
                                <h3><a href="#">Maquilado en San Miguel el Alto, Jal.</a></h3>
                                <p>Creado: <span class="brown-text">DISEÑOS DAGAR</span></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!--Velas-->
            <div class="row justify-content-center">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Diademas</h2>
                </div>
            </div>
            <div class="row">
                <?php for ($i = 2; $i < 8; $i++) { ?>
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="#" class="img" style="background-image: url(<?php echo $RUTA; ?>galeria/sistema/index/diademas/<?php echo $i; ?>.jpg);">
                                <span class="price">DIADEMAS DAGAR</span>
                            </a>
                            <div class="text p-4">
                                <h3><a href="#">Maquilado en San Miguel el Alto, Jal.</a></h3>
                                <p>Creado: <span class="brown-text">DISEÑOS DAGAR</span></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- END nav -->
    <?php $TEMPLATE->nav_bar('Nuestros productos') ?>
    <?php echo $TEMPLATE->footer(); ?>
    <?php echo $TEMPLATE->scripts(); ?>

    <script src="<?php echo $RUTA; ?>js/nuestros_productos/nuestros_productos.js"></script>

</body>