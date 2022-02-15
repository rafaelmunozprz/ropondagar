<?php

use App\Models\Funciones;
use App\Models\Modelos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$MODEL = new Modelos();
$FUNC = new Funciones();

/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */
$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada',
];
// die(json_encode($respuesta));

header('Content-type:application/json;charset=utf-8');
$raiz = '../public/';
$imagenes = 'galeria/productos/';
switch ($opcion) {
    case 'cargar_imagen':

        /**
         * Si recibe @$id_modelo_imagen y existe realizara una actualización
         * De lo contraron insertara una imagen 
         * Y TAREA TERMINADA
         */

        $id_modelo_imagen  = (isset($_POST['id_galeria_modelo'])  && !empty($_POST['id_galeria_modelo'])  ? (int)$_POST['id_galeria_modelo'] : false);
        $id_modelo = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? (int)$_POST['id_modelo'] : false);
        $imagen    = (isset($_FILES['imagen'])   && !empty($_FILES['imagen'])   ? $_FILES['imagen'] : false);

        $FORMATOS = $FUNC->formatos_imagen();

        if ($imagen) {
            $ext = (explode(".", $imagen['name']));
            $ext = strtolower(end($ext));

            if (!isset($FORMATOS[$ext])) {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'Es formato de tu imagen no es el correcto asegurate que sea:  JPEG, PNG o JPG',
                    'ext' => $ext, $FORMATOS
                ];
            } else if ($modelo = $MODEL->mostrar_modelo($id_modelo)) {
                $name = $id_modelo . "_" . time() . "_" . date("Y-m-d") . "." . $ext; //Nombre de la imagen
                $dir_modelo = $imagenes . $FUNC->rellenar_cero($id_modelo); //Dirección del modelo
                if (!file_exists($raiz . $dir_modelo)) {
                    /**Se crea el directorio de extración */
                    mkdir($raiz . $dir_modelo, 0777) or die(json_encode(array('respuesta' => 'error', 'Texto' => "No se puede crear el directorio de extracción")));
                }
                $name = $dir_modelo . "/" . $name;
                $FUNC->optimizar_imagen($imagen['tmp_name'], $raiz . $name, 70); //Guarda la imagen y la comprime

                $termino = false;
                if ($id_modelo_imagen && ($img_model = $MODEL->mostrar_imagen_modelo($id_modelo, $id_modelo_imagen))) {
                    if (is_file($raiz . $img_model['imagen'])) unlink($raiz . $img_model['imagen']); //Si existe se elimina
                    $termino = $MODEL->actualizar_foto($id_modelo_imagen, 'activo', $name); //Se actualiza la imagen
                } else {
                    $id_modelo_imagen = $termino = $MODEL->agregar_foto($id_modelo, $name);
                }

                /**Enviar respuesta */
                if ($termino) {
                    $respuesta = [
                        'response' => 'exito',
                        'text' => 'La imagen se agrego correctamente',
                        'imagen' => $name,
                        'id_modelo_imagen' => $id_modelo_imagen
                    ];
                } else $respuesta = ['response' => 'error', 'text' => 'La solicitud esta equivocada',];
            } else {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'Ocurrio un error al consultar el modelo, vuelva a intentar o recargue su página'
                ];
            }
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'La imagen no se cargo correctamente'
            ];
        }
        echo json_encode($respuesta);
        break;


    default:
        echo json_encode($respuesta);
        break;
}
