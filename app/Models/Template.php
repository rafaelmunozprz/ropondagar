<?php

namespace App\Models;

use App\Config\Config;

class Templates
{
    /**Variables publicas de header */
    public $TITULO;
    public $DESCRIPCION;
    public $KEYWORDS;
    public $RUTA;
    public $SISTEMNAME;
    public $DIRECCION = "";
    public $URL_ICON = "";
    public $URL_IMG = "";

    /**Complementos para funcionalidad */
    var $keyCaptcha_public = "";

    /**Librerias y archivos agregados extras */

    var $bootstrap = true;
    var $recaptcha = false;
    var $sweetAlert = true;
    var $cropper = false;

    var $studylab = false;


    function __construct()
    {
        $CONFIG = new Config();
        $this->RUTA = $CONFIG->RUTA();
        $this->SISTEMNAME = "Ropón Dagar ";
        $this->TITULO = $this->SISTEMNAME . " | San Miguel el Alto | Jalisco";
        $this->DESCRIPCION = "Aquí encontrarás los mejores trajes.";
        $this->DIRECCION = "San Miguel el Alto";
        $this->KEYWORDS = "Creación de ropa a la medida y en maza ";
        $this->URL_ICON = $this->RUTA . "galeria/sistema/logos/icon.png";
        $this->URL_IMG = $this->URL_ICON;
        $this->keyCaptcha_public = $CONFIG->keyCaptcha_public;
    }

    function header()
    {
        $headerBody =
            '<!DOCTYPE html>' .
            '<html lang="es">' .

            '<head>' .
            '<meta charset="UTF-8">' .
            '<meta http-equiv="X-UA-Compatible" content="IE=edge">' .
            '<title>' . $this->TITULO . ' </title>' .
            '<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">' .
            '<meta http-equiv="Cache-control" content="no-cache">' .
            '<meta http-equiv="Pragma" content="no-cache">' .
            '<meta http-equiv="Expires" Content="0">' .
            '<meta name="keywords" content="' . $this->KEYWORDS . '">' .
            '<meta name="description" content="' . $this->DESCRIPCION . '">' .
            '<meta name="robots" content="all">' .
            '<meta name="author" content="WEBMASTER - Ing. Leonardo Vázquez Angulo">' .
            '<!-- Open Graph protocol -->' .
            '<meta property="og:title" content="' . $this->DESCRIPCION . '" />' .
            '<meta property="og:site_name" content="' . $this->TITULO . '" />' .
            '<meta property="og:type" content="website" />' .
            '<meta property="og:url" content="' . $this->RUTA . '" />' .
            '<meta property="og:image" content="' . $this->URL_IMG . '" />' .
            '<meta property="og:image:type" content="image/png" />' .
            '<meta property="og:image:width" content="200" />' .
            '<meta property="og:image:height" content="200" />' .
            '<meta property="og:description" content="' . $this->KEYWORDS . '" />' .
            '<meta name="twitter:title" content="' . $this->TITULO . '" />' .
            '<meta name="twitter:image" content="' . $this->URL_IMG . '" />' .
            '<meta name="twitter:url" content="' . $this->RUTA . '" />' .
            '<meta name="twitter:card" content="" />' .
            '<link rel="icon" href="' . $this->URL_ICON . '" type="image/x-icon">';

        /**
         * LIBRERIAS
         */
        if ($this->bootstrap) {
            $headerBody .= '<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> ';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/fontawesome/css/all.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/bootstrap.min.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/mdb.min.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/style.css">';
            $headerBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/jquery.min.js"></script>';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'css/estilos.css">';
        }
        if ($this->studylab) {
            $headerBody .= '<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/studylab/css/animate.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/studylab/css/magnific-popup.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/studylab/css/jquery.timepicker.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/studylab/css/style.css">';
        }
        if ($this->recaptcha) {
            $headerBody .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
        }
        if ($this->sweetAlert) {
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/sweetalert/sweetalert2.min.css">';
            $headerBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/sweetalert/sweetalert2.min.js"></script>';
        }
        if ($this->cropper) {
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/cropper/css/cropper.css">';
            $headerBody .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/cropper/css/main.css">';
        }
        $headerBody .= '</head>';

        echo $headerBody;
    }
    function scripts()
    {
        $scripsBody = '';
        $scripsBody .= '<script> var RUTA ="' . $this->RUTA . '";</script>';
        if ($this->bootstrap) {
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/popper.min.js"></script>';
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/bootstrap.min.js"></script>';
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/mdbootstrap/js/mdb.min.js"></script>';
            $scripsBody .= '<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>';
        }
        if ($this->studylab) {
            $scripsBody .= '<script src="' . $this->RUTA . 'library/studylab/js/jquery-migrate-3.0.1.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/studylab/js/jquery.waypoints.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/studylab/js/jquery.stellar.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/studylab/js/scrollax.min.js"></script>';
            $scripsBody .= '<script src="' . $this->RUTA . 'library/studylab/js/main.js"></script>';

            $scripsBody .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>';
        }
        if ($this->cropper) {
            $scripsBody .= '<script type="text/javascript" src="' . $this->RUTA . 'library/cropper/js/cropper.js"></script>';
        }
        echo $scripsBody;
    }

    function nav_bar($active = '')
    {
        $nav_body = '
        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light pb-0" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="' . $this->RUTA . '" style="background:none !important;"><span>Ropones</span> Dagar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ' . ($active == '' ? "active" : "") . '"><a href="' . $this->RUTA . '" class="nav-link">Inicio</a></li>
                        <li class="nav-item ' . ($active == 'contacto' ? "active" : "") . '"><a href="' . $this->RUTA . 'contacto" class="nav-link">Contacto</a></li>
                        <li class="nav-item ' . ($active == 'nosotros' ? "active" : "") . '"><a href="' . $this->RUTA . 'nosotros" class="nav-link">Nosotros</a></li>
                        <li class="nav-item ' . ($active == 'productos' ? "active" : "") . '"><a href="' . $this->RUTA . 'productos" class="nav-link">Productos</a></li>
                        <li class="nav-item "><a class="nav-link"></a></li>
                        <li class="nav-item "><a class="nav-link"></a></li>
                        <li class="nav-item ' . ($active == 'login' ? "active" : "") . '"><a href="' . $this->RUTA . 'login" class="nav-link">Ingresar</a></li>
                    </ul>
                </div>
            </div>
        </nav>';
        echo $nav_body;
    }

    function footer()
    {
        $footer_body = '
        <footer class="ftco-footer ftco-no-pt">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md pt-5">
                        <div class="ftco-footer-widget pt-md-5 mb-4">
                            <h2 class="ftco-heading-2">Nosotros</h2>
                            <p>Venta de Ropones para Bautizo de Niña y Niño, ademas contamos con accesorios como vela, concha, etc.</p>
                            <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                                <li class="ftco-animate"> <a target="_blank" href="https://www.facebook.com/Dise%C3%B1os-Dagar-1421061768128085/" class="btn light-blue darken-4"><span class="fab fa-facebook-f text-white"></span></a></li>
                                <li class="ftco-animate"> <a target="_blank" href="https://m.me/1421061768128085" class="btn light-blue darken-1"><span class="fab fa-facebook-messenger text-white"></span></a></li>
                                <li class="ftco-animate"> <a target="_blank" href="https://wa.me/523471064585" class="btn teal darken-1"><span class="fab fa-whatsapp text-white"></span></a></li>
                                <li class="ftco-animate"> <a target="_blank" href="https://www.instagram.com/" class="btn purple-gradient"><span class="fab fa-instagram text-white"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md pt-5">
                        <div class="ftco-footer-widget pt-md-5 mb-4">
                            <h2 class="ftco-heading-2">Documentos</h2>
                            <ul class="list-unstyled">
                                <li><a href="#" class="py-2 d-block">Servicios</a></li>
                                <li><a href="#" class="py-2 d-block">Politicas de privacidad</a></li>
                                <li><a href="#" class="py-2 d-block">Politicas de uso</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md pt-5">
                        <div class="ftco-footer-widget pt-md-5 mb-4">
                            <h2 class="ftco-heading-2">¿Tienes preguntas?</h2>
                            <div class="block-23 mb-3">
                                <ul>
                                    <li><a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination=21.03033865%2C-102.39818744&fbclid=IwAR30RfE10i1lNK70qAlLRkpfM5ZtjCw4sMTjF07iopD4-wnSeIgv-CNBvFc"><span class="icon fa fa-map-marker"></span><span class="text">Calle Prolongación Macías #212, Colonia Sagrada Familia, 47140, San Miguel el Alto, Jalisco, Mexico</span></a></li>
                                    <li><a target="_blank" href="tel:3471064585"><span class="icon fa fa-phone"></span><span class="text">+52 347 106 4585</span></a></li>
                                    <li><a target="_blank" href="mailto:ropondagar@gmail.com"><i class="icon fa fa-paper-plane pr-3"></i><span class="text ml-3">ropondagar@gmail.com</span></a></li>
                                    <li><a target="_blank" href="mailto:dearcosart@hotmail.com"><i class="icon fa fa-paper-plane pr-3"></i><span class="text ml-3">dearcosart@hotmail.com</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">

                        <p>
                            Copyright:
                            <a href="https://coderaleemsoftware.com.mx"> CODERALEEM SOFTWARE</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        ';
        echo $footer_body;
    }
}
