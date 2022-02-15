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
                    <span class="subheading">Bienvenidos a Diseños Dagar</span>
                    <h1 class="mb-4">Diseños Dagar<br>Mayoreo y Menudeo</h1>
                    <p class="caps">Tienda de ropa para ceremonias religiosas.</p>
                    <p class="mb-0"><a href="#" class="btn btn-primary">Contáctanos</a> <a href="#" class="btn btn-white">Visítanos</a></p>
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
                        <h3 class="mb-4 brown-text">¡Nosotros te contactamos!</h3>
                        <form id="contacto_index">
                            <div class="form-group">
                                <label class="label" for="nombre_contacto">Nombre completo</label>
                                <input type="text" class="form-control" placeholder="Diseños Dagar" name="nombre_contacto" id="nombre_contacto">
                            </div>
                            <div class="form-group">
                                <label class="label" for="correo_contacto">Correo electronico</label>
                                <input type="text" class="form-control" id="correo_contacto" name="correo_contacto" placeholder="tucorreo@gmail.com">
                            </div>
                            <div class="form-group">
                                <label class="label" for="telefono_contacto">Télefono</label>
                                <input id="telefono_contacto" name="telefono_contacto" type="number" class="form-control" placeholder="333-333-3333">
                            </div>
                            <div class="form-group d-flex justify-content-end mb-0">
                                <button type="submit" class="btn brown lighten-2 text-white submit">Enviar mis datos<span class="fa fa-paper-plane ml-4"></span></button>
                            </div>
                            <div class="form-group d-flex justify-content-end mt-4">
                                <a target="_blank" href="https://www.facebook.com/Dise%C3%B1os-Dagar-1421061768128085/" class="btn light-blue darken-4"><span class="fab fa-facebook-f text-white"></span></a>
                                <a target="_blank" href="https://m.me/1421061768128085" class="btn light-blue darken-1"><span class="fab fa-facebook-messenger text-white"></span></a>
                                <a target="_blank" href="https://wa.me/523471064585" class="btn teal darken-1"><span class="fab fa-whatsapp text-white"></span></a>
                                <a target="_blank" href="https://www.instagram.com/" class="btn purple-gradient"><span class="fab fa-instagram text-white"></span></a>
                            </div>
                        </form>
                        <p class="text-center">¡Estamos listos para trabajar contigo!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Ropones para Bautizo de Niña y Niño</span>
                    <h2 class="mb-4">Contamos con accesorios</h2>
                </div>
            </div>
            <div class="row">
                <?php for ($i = 1; $i < 7; $i++) { ?>
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="#" class="img" style="background-image: url(<?php echo $RUTA; ?>galeria/sistema/index/<?php echo $i; ?>.jpg);">
                                <span class="price">ROPON DAGAR</span>
                            </a>
                            <div class="text p-4">
                                <h3><a href="#">Maquilado en San Miguel el Alto, Jal.</a></h3>
                                <p>Creado: <span class="brown-text">ROPON DAGAR</span></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>





    <script src="<?php echo $RUTA; ?>js/index/index.js"></script>

    <!-- loader -->


    <?php echo $TEMPLATE->footer(); ?>
    <?php echo $TEMPLATE->scripts(); ?>
</body>