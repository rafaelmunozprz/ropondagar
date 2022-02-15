<?php

use App\Models\ClienteNota;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$CLIENT = new ClienteNota();

/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
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
        $id_nota  = (isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? $_POST['id_nota'] : false);


        if ($id_nota) {
            if ($modelo = $CLIENT->mostrar_nota($id_nota)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => [$modelo]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            $CLIENT->buscar = $buscar;
            $CLIENT->pagina = $pagina;
            $CLIENT->limite = $limite;
            if ($modelos = $CLIENT->mostrar_notas()) {
                $modelos_data = [];
                while ($modelo = $modelos->fetch_assoc()) {
                    $modelo['materia_prima'] = json_decode($modelo['materia_prima'], true);
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'crear':
        $nombre               = (isset($_POST['nombre'])               && !empty($_POST['nombre'])              ? htmlspecialchars($_POST['nombre'])              : false);
        $categoria            = (isset($_POST['categoria'])            && !empty($_POST['categoria'])           ? htmlspecialchars($_POST['categoria'])           : false);
        $id_categoria         = (isset($_POST['id_categoria'])         && !empty($_POST['id_categoria'])        ? (int)$_POST['id_categoria']                     : false);
        $color                = (isset($_POST['color'])                && !empty($_POST['color'])               ? htmlspecialchars($_POST['color'])               : false);
        $medida               = (isset($_POST['medida'])               && !empty($_POST['medida'])              ? htmlspecialchars($_POST['medida'])              : false);
        $unidad_medida        = (isset($_POST['unidad_medida'])        && !empty($_POST['unidad_medida'])       ? htmlspecialchars($_POST['unidad_medida'])       : false);
        $porcentaje_ganancia  = (isset($_POST['porcentaje_ganancia'])  && !empty($_POST['porcentaje_ganancia']) ? htmlspecialchars($_POST['porcentaje_ganancia']) : false);
        // $estado               = (isset($_POST['estado'])               && !empty($_POST['estado'])              ? htmlspecialchars($_POST['estado'])              : false);
        $codigo               = (isset($_POST['codigo'])               && !empty($_POST['codigo'])              ? htmlspecialchars($_POST['codigo'])              : false);


        if ($nombre && ($categoria || $id_categoria)) {
            $cantidad_productos = sizeof($productos);
            $total_costo = 0;
            if ($id = 1) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El registro del modelo fue creado de manera correcta',
                    'data' => ['id_nota' => $id]
                ];
            } else {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'No fue posible terminar con el registro del nuevo modelo'
                ];
            }
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'Completa los campos obligatorios'
            ];
        }
        echo json_encode($respuesta);
        break;
    case 'modificar_nota':
        $id_nota        = (isset($_POST['id_nota'])       && !empty($_POST['id_nota'])       ? $_POST['id_nota'] : false);
        $nombre           = (isset($_POST['nombre'])          && !empty($_POST['nombre'])          ? $_POST['nombre'] : false);
        $codigo           = (isset($_POST['codigo'])          && !empty($_POST['codigo'])          ? $_POST['codigo'] : false);
        $color            = (isset($_POST['color'])           && !empty($_POST['color'])           ? $_POST['color'] : false);
        $talla            = (isset($_POST['talla'])           && !empty($_POST['talla'])           ? $_POST['talla'] : false);
        $tipo             = (isset($_POST['tipo'])            && !empty($_POST['tipo'])            ? $_POST['tipo'] : false);
        $sexo             = (isset($_POST['sexo'])            && !empty($_POST['sexo'])            ? $_POST['sexo'] : false);
        $codigo_completo  = (isset($_POST['codigo_completo']) && !empty($_POST['codigo_completo']) ? $_POST['codigo_completo'] : false);
        $materia_prima    = (isset($_POST['materia_prima'])   && !empty($_POST['materia_prima'])   ? $_POST['materia_prima'] : false);
        $modelo = $CLIENT->mostrar_nota($id_nota);
        if ($modelo) {
            $CLIENT->nombre          = $nombre;
            $CLIENT->codigo          = $codigo;
            $CLIENT->color           = $color;
            $CLIENT->talla           = $talla;
            $CLIENT->tipo            = $tipo;
            $CLIENT->sexo            = $sexo;
            $CLIENT->codigo_completo = $codigo_completo;
            $CLIENT->materia_prima   = $materia_prima;

            if ($id = $CLIENT->modificar_nota($id_nota)) $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al modelo'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el modelo, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;

    default:
        echo json_encode($respuesta);
        break;
}
