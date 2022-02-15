<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once "../app/controller.php";


use App\Config\{Config};

$CONFIG = new Config();

$RUTA = $CONFIG->RUTA();

$route = str_replace($CONFIG->route(), "", $_SERVER["REQUEST_URI"]); //Obtiene la carpeta donde esta el proyecto
$URI_REQUEST = explode("?", $route)[0]; //Separa los elementos $_GET
// echo $URI_REQUEST;

$USERSYSTEM = isset($_SESSION[$CONFIG->sessionName()]) ? $_SESSION[$CONFIG->sessionName()] : false; //Registra la sesión en una variable más manipulable

/**----------------------------------------------------- */
/**-------------------Controlador MVC------------------- */
/**----------------------------------------------------- */
$DIRECTORIO = isset($URI_REQUEST) ? explode('/', $URI_REQUEST) : false; //Configura y limpia la URI
if ($DIRECTORIO) {
    $dirArray = [];
    foreach ($DIRECTORIO as $key => $value) {
        if ($DIRECTORIO[$key] != '') {
            $dirArray[] = $DIRECTORIO[$key];
        }
    }
    $DIRECTORIO = $dirArray;
}
$DIR_SIZE = ($DIRECTORIO ? sizeof($DIRECTORIO) : 0); //Tamaño de la URI

/**----------------------------------------------------- */
/**-------------------Controlador MVC------------------- */
/**----------------------------------------------------- */


/**
 * CONTROLADOR raiz
 */
if (!$DIRECTORIO) {
    require_once("../views/index/index.view.php");
}
/**Controlador contacto */
else if ($DIRECTORIO[0] == "contacto") {
    require_once '../routes/contacto/contacto.route.php';
}
else if ($DIRECTORIO[0] == "nosotros") {
    require_once '../routes/nosotros/nosotros.route.php';
}
else if ($DIRECTORIO[0] == "productos") {
    require_once '../routes/productos/productos.route.php';
}

/**
 * CONTROLADOR LOGIN OPTIONS
 */
else if ($DIRECTORIO[0] == "login") {

    if (!$USERSYSTEM) {
        require_once '../routes/login/login.route.php';
    } else {
        header('Location: ' . $RUTA . 'sistema/ventas');
    }
}

/**
 * APARTADO ADMINISTRADORES DEL SISTEMA
 */
else if ($DIRECTORIO[0] == "sistema") {

    if ($USERSYSTEM) {
        require_once '../routes/sistema/sistema.admin.route.php';
    } else {
        header('Location:' . $RUTA . 'login');
    }
}


/**
 * CONTROLADOR API solicitudes
 */
//back

else if ($DIRECTORIO[0] == "back" && $_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../routes/api/controller.api.php';
}

/**
 * ERROR  APARTADOS ERRONEOS
 */
else {
    require_once("../views/errors/error.view.php");
}
