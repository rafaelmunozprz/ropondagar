<?php

use App\Models\Ordenes;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$ORDENES = new Ordenes();

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
$raiz = '../public/';
switch ($opcion) {
    case 'mostrar_ordenes_finalizadas':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        if ($buscar) {
            if ($orden_buscada = $ORDENES->mostrar_orden_finalizada($buscar)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo no se encontró',
                    'data' => [$orden_buscada],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'La orden buscada no fue encontrada'];
            }
        } else {
            $ORDENES->buscar = $buscar;
            $ORDENES->pagina = $pagina;
            $ORDENES->limite = $limite;
            if ($ordenes_encontradas = $ORDENES->mostrar_ordenes_finalizadas()) {
                $ordenes_data = [];
                while ($orden = $ordenes_encontradas->fetch_assoc()) {
                    $ordenes_data[] = $orden;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Ordenes encontradas',
                    'data' => $ordenes_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $ORDENES->total_ordenes(),
                    ]
                ];
            } else $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
        }
        echo json_encode($respuesta);
        break;
    case 'avanzar_estado':
        $uuid     = (isset($_POST['uuid'])    && !empty($_POST['uuid'])    ? $_POST['uuid'] : false);
        $siguiente_estado     = (isset($_POST['siguiente_estado'])    && !empty($_POST['siguiente_estado'])    ? $_POST['siguiente_estado'] : false);
        if ($actualizado = $ORDENES->avanzar_estado($uuid, $siguiente_estado)) {
            $respuesta = ['response' => 'success', 'text' => 'Orden de producción #' . $uuid . ' actualizado'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No hemos podido actualizar la orden #' . $uuid];
        echo json_encode($respuesta);
        break;
    case 'mostrar_ordenes_produccion':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        if ($buscar) {
            if ($orden_buscada = $ORDENES->mostrar_orden_produccion($buscar)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo no se encontró',
                    'data' => [$orden_buscada],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'La orden buscada no fue encontrada'];
            }
        } else {
            $ORDENES->buscar = $buscar;
            $ORDENES->pagina = $pagina;
            $ORDENES->limite = $limite;
            if ($ordenes_encontradas = $ORDENES->mostrar_ordenes_produccion()) {
                $ordenes_data = [];
                while ($orden = $ordenes_encontradas->fetch_assoc()) {
                    $ordenes_data[] = $orden;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Ordenes encontradas',
                    'data' => $ordenes_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $ORDENES->total_ordenes(),
                    ]
                ];
            } else $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
        }
        echo json_encode($respuesta);
        break;
    case 'iniciar_proceso_maquila':
        $uuid  = (isset($_POST['uuid']) && !empty($_POST['uuid']) ? $_POST['uuid'] : false);
        if ($iniciado = $ORDENES->iniciar_proceso_maquila($uuid)) {
            $respuesta = ['response' => 'success', 'text' => 'Proceso de trabajo producción iniciado'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible iniciar la orden de producción'];
        echo json_encode($respuesta);
        break;
    case 'cargar_detalle_orden':
        $uuid  = (isset($_POST['uuid']) && !empty($_POST['uuid']) ? $_POST['uuid'] : false);
        if ($encontrado = $ORDENES->cargar_detalle_orden($uuid)) {
            $ordenes_data = [];
            while ($orden = $encontrado->fetch_assoc()) {
                $ordenes_data[] = $orden;
            }
            $respuesta = ['response' => 'success', 'text' => 'Artículos encontradas exitósamente', 'data' => $ordenes_data];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible cargar la orden en espera'];
        echo json_encode($respuesta);
        break;
    case 'eliminar_ordenes_espera':
        $uuid  = (isset($_POST['uuid']) && !empty($_POST['uuid']) ? $_POST['uuid'] : false);
        if ($eliminado = $ORDENES->eliminar_ordenes_espera($uuid)) {
            $respuesta = ['response' => 'success', 'text' => 'Orden eliminada exitósamente'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible eliminar la orden'];
        echo json_encode($respuesta);
        break;
    case 'mostrar_ordenes_espera':
        if ($encontrado = $ORDENES->mostrar_ordenes_espera()) {
            $ordenes_data = [];
            while ($orden = $encontrado->fetch_assoc()) {
                $ordenes_data[] = $orden;
            }
            $respuesta = ['response' => 'success', 'text' => 'Ordenes encontradas exitósamente', 'data' => $ordenes_data];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible cargar las órdenes en espera'];
        echo json_encode($respuesta);
        break;
    case 'crear_orden_nueva':
        $orden  = (isset($_POST['orden']) && !empty($_POST['orden']) ? $_POST['orden'] : false);
        if ($insertado = $ORDENES->crear_orden_nueva($orden)) {
            $respuesta = ['response' => 'success', 'text' => 'Nueva orden registrada exitosamente'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible registrar la orden'];
        echo json_encode($respuesta);
        break;
    case 'mostrar_modelo':
        $codigo  = (isset($_POST['codigo']) && !empty($_POST['codigo']) ? $_POST['codigo'] : false);
        if ($encontrado = $ORDENES->mostrar_modelo($codigo)) {
            $respuesta = ['response' => 'success', 'text' => 'El modelo se encontró', 'data' => $encontrado];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue encontrar el modelo'];
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
