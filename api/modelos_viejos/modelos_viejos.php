<?php

use App\Models\Modelos_Viejos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$MODELO_VIEJO = new Modelos_Viejos();

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'disminuir_stock';
        $id_modelo_viejo  = (isset($_POST['id_modelo_viejo']) && !empty($_POST['id_modelo_viejo']) ? $_POST['id_modelo_viejo'] : false);
        $disminuir_stock  = (isset($_POST['disminuir_stock']) && !empty($_POST['disminuir_stock']) ? $_POST['disminuir_stock'] : false);
        if ($disminuido = $MODELO_VIEJO->disminuir_stock($id_modelo_viejo, $disminuir_stock)) {
            $respuesta = ['response' => 'success', 'text' => 'Stock actualizado de manera correcta'];
        } else $respuesta = ['response' => 'warning', 'text' => 'El stock no puede ser negativo'];
        echo json_encode($respuesta);
        break;
    case 'agregar_stock':
        $id_modelo_viejo  = (isset($_POST['id_modelo_viejo']) && !empty($_POST['id_modelo_viejo']) ? $_POST['id_modelo_viejo'] : false);
        $nuevo_stock  = (isset($_POST['nuevo_stock']) && !empty($_POST['nuevo_stock']) ? $_POST['nuevo_stock'] : false);
        if ($agregado = $MODELO_VIEJO->agregar_stock($id_modelo_viejo, $nuevo_stock)) {
            $respuesta = ['response' => 'success', 'text' => 'Stock actualizado de manera correcta'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible agregar el nuevo stock'];
        echo json_encode($respuesta);
        break;
    case 'eliminar_modelo':
        $id_modelo_viejo  = (isset($_POST['id_modelo_viejo']) && !empty($_POST['id_modelo_viejo']) ? $_POST['id_modelo_viejo'] : false);
        if ($stock = $MODELO_VIEJO->revisar_stock($id_modelo_viejo)) {
            if ($stock['stock'] > 0) {
                $respuesta = ['response' => 'warning', 'text' => 'No es posible eliminar un modelo con STOCK'];
            } else {
                if ($eliminacion = $MODELO_VIEJO->eliminar_modelo($id_modelo_viejo)) {
                    $respuesta = ['response' => 'success', 'text' => 'Modelo eliminado de forma exitosa'];
                } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible eliminar el modelo'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'nuevo':
        $nombre     = (isset($_POST['nombre'])    && !empty($_POST['nombre'])    ? $_POST['nombre'] : false);
        $talla     = (isset($_POST['talla'])    && !empty($_POST['talla'])    ? $_POST['talla'] : false);
        $color     = (isset($_POST['color'])    && !empty($_POST['color'])    ? $_POST['color'] : false);
        $tipo     = (isset($_POST['tipo'])    && !empty($_POST['tipo'])    ? $_POST['tipo'] : false);
        $sexo     = (isset($_POST['sexo'])    && !empty($_POST['sexo'])    ? $_POST['sexo'] : false);
        $precio_menudeo     = (isset($_POST['precio_menudeo'])    && !empty($_POST['precio_menudeo'])    ? $_POST['precio_menudeo'] : false);
        $precio_mayoreo     = (isset($_POST['precio_mayoreo'])    && !empty($_POST['precio_mayoreo'])    ? $_POST['precio_mayoreo'] : false);
        $codigo     = (isset($_POST['codigo'])    && !empty($_POST['codigo'])    ? $_POST['codigo'] : false);
        if ($modificacion = $MODELO_VIEJO->nuevo($nombre, $talla, $color, $tipo, $sexo, $precio_mayoreo, $precio_menudeo, $codigo)) {
            $respuesta = ['response' => 'success', 'text' => 'La registro creado de forma exitosa'];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible crear el modelo'];
        }
        echo json_encode($respuesta);
        break;
    case 'actualizar_modelo':
        $modificar_nombre     = (isset($_POST['modificar_nombre'])    && !empty($_POST['modificar_nombre'])    ? $_POST['modificar_nombre'] : false);
        $modificar_talla     = (isset($_POST['modificar_talla'])    && !empty($_POST['modificar_talla'])    ? $_POST['modificar_talla'] : false);
        $modificar_color     = (isset($_POST['modificar_color'])    && !empty($_POST['modificar_color'])    ? $_POST['modificar_color'] : false);
        $modificar_tipo     = (isset($_POST['modificar_tipo'])    && !empty($_POST['modificar_tipo'])    ? $_POST['modificar_tipo'] : false);
        $modificar_sexo     = (isset($_POST['modificar_sexo'])    && !empty($_POST['modificar_sexo'])    ? $_POST['modificar_sexo'] : false);
        $modificar_precio_menudeo     = (isset($_POST['modificar_precio_menudeo'])    && !empty($_POST['modificar_precio_menudeo'])    ? $_POST['modificar_precio_menudeo'] : false);
        $modificar_precio_mayoreo     = (isset($_POST['modificar_precio_mayoreo'])    && !empty($_POST['modificar_precio_mayoreo'])    ? $_POST['modificar_precio_mayoreo'] : false);
        $modificar_codigo     = (isset($_POST['modificar_codigo'])    && !empty($_POST['modificar_codigo'])    ? $_POST['modificar_codigo'] : false);
        if ($modificacion = $MODELO_VIEJO->actualizar_modelo_viejo($modificar_nombre, $modificar_talla, $modificar_color, $modificar_tipo, $modificar_sexo, $modificar_precio_mayoreo, $modificar_precio_menudeo, $modificar_codigo)) {
            $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización del modelo'];
        }
        echo json_encode($respuesta);
        break;
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        $id_modelo_viejo  = (isset($_POST['id_modelo_viejo']) && !empty($_POST['id_modelo_viejo']) ? $_POST['id_modelo_viejo'] : false);
        if ($id_modelo_viejo) {
            if ($modelo_viejo = $MODELO_VIEJO->mostrar_modelo_viejo($id_modelo_viejo)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo no se encontró',
                    'data' => [$modelo_viejo],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que fue buscado no fue encontrado'];
            }
        } else {
            $MODELO_VIEJO->buscar = $buscar;
            $MODELO_VIEJO->pagina = $pagina;
            $MODELO_VIEJO->limite = $limite;

            if ($modelos_viejos = $MODELO_VIEJO->mostrar_modelos_viejos()) {
                $modelos_data = [];
                while ($modelo_viejo = $modelos_viejos->fetch_assoc()) {
                    $modelos_data[] = $modelo_viejo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $MODELO_VIEJO->total_modelos_viejos(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'cargar_modelo';

        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
