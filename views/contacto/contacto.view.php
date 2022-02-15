<?php

use App\Models\Templates;

$TEMPLATE = new Templates();

$TEMPLATE->studylab = true;
$TEMPLATE->TITULO = 'Contacto | ' . $TEMPLATE->TITULO;
$TEMPLATE->header();
?>

<body>

    <!-- END nav -->
    <?php $TEMPLATE->nav_bar('contacto') ?>
    <section class="ftco-section pb-2 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                                <div class="contact-wrap w-100 p-sm-3 p-2">
                                    <h3 class="mb-4">Completa el formulario</h3>
                                    <form method="POST" id="contacto_formulario">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="nombre_contacto">Nombre completo</label>
                                                    <input type="text" class="form-control" name="nombre_contacto" id="nombre_contacto" placeholder="Nombre completo">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="telefono_contacto">Teléfono de contacto</label>
                                                    <input type="number" class="form-control" name="telefono_contacto" id="telefono_contacto" placeholder="Teléfono">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="correo_contacto">Correo Eléctronico</label>
                                                    <input type="email" class="form-control" name="correo_contacto" id="correo_contacto" placeholder="Correo Eléctronico">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="asunto_contacto">Asunto</label>
                                                    <input type="text" class="form-control" name="asunto_contacto" id="asunto_contacto" placeholder="Asunto">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="cuerpo_mensaje">Mensaje</label>
                                                    <textarea name="cuerpo_mensaje" class="form-control" id="cuerpo_mensaje" cols="30" rows="4" placeholder="Mensaje"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                                <div class="info-wrap bg-primary w-100 p-lg-5 p-md-4 p-2">
                                    <h3>Contacta con nosotros</h3>
                                    <p class="mb-4">Estamos listos para chatear contigo</p>
                                    <div class="dbox w-100 d-flex align-items-start">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-map-marker"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Calle:</span> <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination=21.03033865%2C-102.39818744&fbclid=IwAR30RfE10i1lNK70qAlLRkpfM5ZtjCw4sMTjF07iopD4-wnSeIgv-CNBvFc"></a> Prolongación Macias #212, 47140, San Miguel el Alto, Jalisco, Mexico</p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Teléfono:</span> <a href="tel:347 106 4585">+52 347 106 4585</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-paper-plane"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Correo:</span> <a href="mailto:ropondagar@gmail.com">ropondagar@gmail.com</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-paper-plane"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Correo:</span> <a href="mailto:dearcosart@hotmail.com">dearcosart@hotmail.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col py-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d476990.6577180943!2d-102.8539012332634!3d20.932848130145796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!3e0!4m3!3m2!1d20.814233599999998!2d-102.74734079999999!4m3!3m2!1d21.030338699999998!2d-102.3981874!5e0!3m2!1ses-419!2smx!4v1606677757578!5m2!1ses-419!2smx" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>
    <div class="container my-5 py-5 z-depth-1">
        <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text">
            <div class="row d-flex justify-content-center mb-4">
                <div class="col text-center">
                    <p class="font-weight-bold">Contáctanos</p>
                    <p>Somos expertos en diseño de Ropones para Bautizo de Niña y Niño, además contamos con accesorios como vela, concha, etc.</p>
                    <a target="_blank" href="https://www.facebook.com/Dise%C3%B1os-Dagar-1421061768128085/" class="btn light-blue darken-4"><span class="fab fa-facebook-f text-white"></span></a>
                    <a target="_blank" href="https://m.me/1421061768128085" class="btn light-blue darken-1"><span class="fab fa-facebook-messenger text-white"></span></a>
                    <a target="_blank" href="https://wa.me/523471064585" class="btn teal darken-1"><span class="fab fa-whatsapp text-white"></span></a>
                    <a target="_blank" href="https://www.instagram.com/" class="btn purple-gradient"><span class="fab fa-instagram text-white"></span></a>
                </div>
            </div>
        </section>
    </div>

    <?php echo $TEMPLATE->footer(); ?>
    <?php echo $TEMPLATE->scripts(); ?>

    <script src="<?php echo $RUTA; ?>js/contacto/contacto.js"></script>

</body>