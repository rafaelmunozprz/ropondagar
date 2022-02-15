<?php

use App\Models\Funciones;
use App\Models\Modelos_Viejos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$VENTA_MODELO_VIEJO = new Modelos_Viejos();

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];
header('Content-type:application/json;charset=utf-8');
switch ($opcion) {
    case 'vender':
        $cliente     = isset($_POST['cliente']) && !empty($_POST['cliente']) ? json_decode($_POST['cliente'], true) : false;
        $datos       = isset($_POST['datos'])   && !empty($_POST['datos'])   ? json_decode($_POST['datos'], true) : false;
        $descuento   = isset($_POST['descuento'])   && !empty($_POST['descuento'])   ? json_decode($_POST['descuento'], true) : 0;
        if ($stock = $VENTA_MODELO_VIEJO->comprobar_stock_articulos($datos)) {
            if($VENTA_MODELO_VIEJO->vender($cliente, $datos, $descuento)){
                $respuesta = ['response' => 'success', 'text' => 'Venta registrada con éxito'];
            }else{
                $respuesta = ['response' => 'warning', 'text' => 'No se ha podido realizar la venta'];
            }
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'Alguno de los artículos no cuenta con suficiente stock'];
        }
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
