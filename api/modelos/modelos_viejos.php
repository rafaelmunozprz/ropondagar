<?php

use App\Models\ModelosViejos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$MODEL = new ModelosViejos();

/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 * pagination = @array[]
 */
$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 8);
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);

        // $codigo = strlen($buscar) == 4 ? $buscar : false;
        $codigo = $buscar;
        // $buscar = !$codigo ? $buscar : false;


        if ($id_modelo) {
            if ($modelo = $MODEL->mostrar_modelo($id_modelo)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => [$modelo],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            // $MODEL->buscar = $buscar;
            $MODEL->modelo = $codigo;
            $MODEL->pagina = $pagina;
            $MODEL->limite = $limite;
            if ($modelos = $MODEL->mostrar_modelos()) {
                $modelos_data = [];
                while ($modelo = $modelos->fetch_assoc()) { //REARMA  Y ENTREGA UN OBJETO PARA RETORNAR EL CUERPO DEL MODELO Y PODER MANIPULARLO
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => (int)$MODEL->total_modelos(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    default:
        break;
}
