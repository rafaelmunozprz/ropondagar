<?php

use App\Models\Templates;

$TEMPLATE = new Templates();

$TEMPLATE->studylab = true;
$TEMPLATE->TITULO = 'Nosotros | ' . $TEMPLATE->TITULO;
$TEMPLATE->header();
?>

<body>
    <section class="ftco-section pb-2 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-sm-3 p-2">
                                    <h3 class="mb-4">Nosotros</h3>
                                    <div class="row">
                                        <div class="mx-1">
                                            Somos una empresa dedicada al diseño y confección de ropa de bautizos y ceremonias.
                                            Iniciamos nuestra aventura en 2011 en San Miguel el Alto, Jalisco, que ha logrado consolidarse en el mercado nacional con el objetivo de incorporarnos en el mercado internacional.
                                        </div>
                                    </div>
                                    <h3 class="mb-4">Valores</h3>
                                    <div class="row">
                                        <ul>
                                            <li>Compromiso para ofrecer el producto de mayor calidad posible</li>
                                            <li>Respeto a las culturas, tradiciones, creencias y religiones</li>
                                            <li>Tolerancia a las ideas y opiniones de los demás</li>
                                            <li>Amplia apertura a ideas de nuestros clientes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 d-flex align-items-center">
                                <div class="bg-muted w-100 p-lg-5 p-md-4 p-2">
                                    <h3 class="display-1 text-xs-center text-sm-center text-lg-center">NV</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-8 col-md-7 order-md-first d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-sm-3 p-2">
                                    <h3 class="mb-4">Misión<nav></nav>
                                    </h3>
                                    <div class="row">
                                        <div class="mx-1">
                                            Vestir y arropar a cada niño y niña en las ceremonias religiosas más importantes de su infancia, sin importar el lugar en donde este se encuentre.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 d-flex align-items-center">
                                <div class="bg-muted w-100 p-lg-5 p-md-4 p-2">
                                    <h3 class="display-1 text-xs-center text-sm-center text-lg-center">M</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4 mb-4">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-sm-3 p-2">
                                    <h3 class="mb-4">Visión<nav></nav>
                                    </h3>
                                    <div class="row">
                                        <div class="mx-1">
                                            Innovar en el abrigo que acompaña a los infantes en sus ceremonias más importantes, poniendo la prenda en la puerta de su casa con un solo ¡click!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 d-flex align-items-center">
                                <div class="bg-muted w-100 p-lg-5 p-md-4 p-2">
                                    <h3 class="display-1 text-xs-center text-sm-center text-lg-center">V</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END nav -->
    <?php $TEMPLATE->nav_bar('nosotros') ?>
    <?php echo $TEMPLATE->footer(); ?>
    <?php echo $TEMPLATE->scripts(); ?>

    <script src="<?php echo $RUTA; ?>js/nosotros/nosotros.js"></script>

</body>