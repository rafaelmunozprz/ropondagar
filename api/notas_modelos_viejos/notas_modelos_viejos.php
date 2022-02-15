<?php

use App\Models\Notas_modelos_viejos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$NOTA_MODELO_VIEJO = new Notas_modelos_viejos();

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        $id_modelo_viejo  = (isset($_POST['id_modelo_viejo']) && !empty($_POST['id_modelo_viejo']) ? $_POST['id_modelo_viejo'] : false);
        if ($id_modelo_viejo) {
            if ($modelo_viejo = $NOTA_MODELO_VIEJO->mostrar_nota_modelo_viejo($id_modelo_viejo)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La nota no se encontró',
                    'data' => [$modelo_viejo],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'La nota que fue buscada no fue encontrada'];
            }
        } else {
            $NOTA_MODELO_VIEJO->buscar = $buscar;
            $NOTA_MODELO_VIEJO->pagina = $pagina;
            $NOTA_MODELO_VIEJO->limite = $limite;

            if ($modelos_viejos = $NOTA_MODELO_VIEJO->mostrar_notas_modelos_viejos()) {
                $modelos_data = [];
                while ($modelo_viejo = $modelos_viejos->fetch_assoc()) {
                    $modelos_data[] = $modelo_viejo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La nota fue encontrada',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $NOTA_MODELO_VIEJO->total_notas_modelos_viejos(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
