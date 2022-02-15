<?php

use App\Models\Burros;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$BURROS = new Burros();

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];
header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'crear_burro':
        $niveles_NUEVO_BURRO = isset($_POST['niveles_NUEVO_BURRO']) && !empty($_POST['niveles_NUEVO_BURRO']) ? htmlspecialchars($_POST['niveles_NUEVO_BURRO']) : false;
        $secciones_NUEVO_BURRO = isset($_POST['secciones_NUEVO_BURRO']) && !empty($_POST['secciones_NUEVO_BURRO']) ? htmlspecialchars($_POST['secciones_NUEVO_BURRO']) : false;
        $respuesta = ['response' => 'success', 'text' => 'Burro registrado con éxito, ¡recuerda que los burros no pueden disminuir su tamaño!', "data" => ["niveles_NUEVO_BURRO" => $niveles_NUEVO_BURRO]];
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
