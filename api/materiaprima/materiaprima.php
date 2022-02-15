<?php

use App\Models\Materiaprima;
use App\Models\StockMaP;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);


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
        $buscar     = (isset($_POST['buscar'])      && !empty($_POST['buscar'])     ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])      && !empty($_POST['pagina'])     ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])      && !empty($_POST['limite'])     ? $_POST['limite'] : 9);
        $id_materia = (isset($_POST['id_materia'])  && !empty($_POST['id_materia']) ? $_POST['id_materia'] : false);
        $stock      = (isset($_POST['stock'])       && !empty($_POST['stock'])      ? true : false);
        $codigo     = (isset($_POST['codigo']) ? $_POST['codigo'] : false);


        $MATERIA = new Materiaprima();
        $STOCK_M_P = new StockMaP();

        $MATERIA->id_materia = $id_materia;
        $STOCK_M_P->buscar = $MATERIA->buscar = $buscar;
        $STOCK_M_P->pagina = $MATERIA->pagina = $pagina;
        $STOCK_M_P->limite = $MATERIA->limite = $limite;

        $STOCK_M_P->codigo = $codigo;


        $materias = false;
        if ($stock) $materias  = $STOCK_M_P->mostrar_stock_materia();
        else $materias = $MATERIA->mostrar_materia_prima();

        if ($materias) {
            $materias_data = [];
            while ($materia = $materias->fetch_assoc()) {
                if ($id_materia) $materia['stock'] = $STOCK_M_P->mostrar_stock($id_materia);
                $materias_data[] = $materia;
            }
            $respuesta = [
                'response' => 'success',
                'text' => 'El materia se encontro',
                'data' => $materias_data,
                'pagination' => [
                    'page' => (int)$pagina,
                    'limit' => (int)$limite,
                    'total' => (int)$MATERIA->total_materia(),
                ],
            ];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
        }
        $respuesta['post'] = $_POST;

        echo json_encode($respuesta);

        break;
    case 'crear_materia':
        $MATERIA = new Materiaprima();

        $id_categoria        = (isset($_POST['id_categoria'])        && !empty($_POST['id_categoria'])        ? (int)$_POST['id_categoria']   : false);
        $nombre              = (isset($_POST['nombre'])              && !empty($_POST['nombre'])              ? $_POST['nombre']              : false);
        $color               = (isset($_POST['color_nuevo'])         && !empty($_POST['color_nuevo'])         ? $_POST['color_nuevo']         : false);
        $medida              = (isset($_POST['medida'])              && !empty($_POST['medida'])              ? $_POST['medida']              : false);
        $unidad_medida       = (isset($_POST['unidad_medida'])       && !empty($_POST['unidad_medida'])       ? $_POST['unidad_medida']       : false);
        $porcentaje_ganancia = (isset($_POST['porcentaje_ganancia']) && !empty($_POST['porcentaje_ganancia']) ? $_POST['porcentaje_ganancia'] : false);
        $estado              = (isset($_POST['estado'])              && !empty($_POST['estado'])              ? $_POST['estado']              : false);
        $codigo              = (isset($_POST['codigo_nuevo'])        && !empty($_POST['codigo_nuevo'])        ? $_POST['codigo_nuevo']        : false);
        $codigo_fiscal       = (isset($_POST['codigo_fiscal'])       && !empty($_POST['codigo_fiscal'])       ? $_POST['codigo_fiscal']       : false);

        $imagen    = (isset($_FILES['imagen'])   && !empty($_FILES['imagen'])   ? $_FILES['imagen'] : false);


        if (($id_categoria && $nombre && $color && $medida && $unidad_medida && $porcentaje_ganancia && $codigo)) {
            if ($id = $MATERIA->crear_materia($id_categoria, $nombre, $color, $medida, $unidad_medida, $porcentaje_ganancia, $estado, $codigo, $codigo_fiscal)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El registro del materia fue creado de manera correcta'
                ];
            } else {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'No fue posible terminar con el registro del nuevo materia'
                ];
            }
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'Completa los campos obligatorios'
            ];
        }
        $respuesta['post'] = $_POST;
        echo json_encode($respuesta);
        break;
    case 'modificar_materia':
        $id_materia          = (isset($_POST['id_materia'])          && !empty($_POST['id_materia'])          ? (int)$_POST['id_materia'] : false);
        $id_categoria        = (isset($_POST['id_categoria'])        && !empty($_POST['id_categoria'])        ? (int)$_POST['id_categoria']        : false);
        $nombre              = (isset($_POST['nombre'])              && !empty($_POST['nombre'])              ? $_POST['nombre']              : false);
        $color               = (isset($_POST['color'])               && !empty($_POST['color'])               ? $_POST['color']               : false);
        $medida              = (isset($_POST['medida'])              && !empty($_POST['medida'])              ? $_POST['medida']              : false);
        $unidad_medida       = (isset($_POST['unidad_medida'])       && !empty($_POST['unidad_medida'])       ? $_POST['unidad_medida']       : false);
        $porcentaje_ganancia = (isset($_POST['porcentaje_ganancia']) && !empty($_POST['porcentaje_ganancia']) ? $_POST['porcentaje_ganancia'] : false);
        $estado              = (isset($_POST['estado'])              && !empty($_POST['estado'])              ? $_POST['estado']              : false);
        $codigo              = (isset($_POST['codigo'])              && !empty($_POST['codigo'])              ? $_POST['codigo']              : false);
        $codigo_fiscal       = (isset($_POST['codigo_fiscal'])       && !empty($_POST['codigo_fiscal'])       ? $_POST['codigo_fiscal']       : false);

        $MATERIA = new Materiaprima();

        if ($materia = $MATERIA->mostrar_materia($id_materia)) {
            $MATERIA->id_categoria        = $id_categoria;
            $MATERIA->nombre              = $nombre;
            $MATERIA->color               = $color;
            $MATERIA->medida              = $medida;
            $MATERIA->unidad_medida       = $unidad_medida;
            $MATERIA->porcentaje_ganancia = $porcentaje_ganancia;
            $MATERIA->estado              = $estado;
            $MATERIA->codigo              = $codigo;
            $MATERIA->codigo_fiscal              = $codigo_fiscal;

            if ($id = $MATERIA->modificar_materia($id_materia)) $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al materia'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el materia, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;

    default:
        echo json_encode($respuesta);
        break;
}
