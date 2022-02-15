<?php

use App\Models\Categorias;
use App\Models\Modelos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$CAT = new Categorias();

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'mostrar_categorias_prima':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        $id_categoria  = (isset($_POST['id_categoria']) && !empty($_POST['id_categoria']) ? $_POST['id_categoria'] : false);


        if ($id_categoria) {
            if ($categoria = $CAT->mostrar_categoria($id_categoria)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontró',
                    'data' => [$categoria],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 2
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El categoria que estas buscando no fue encontrado'];
            }
        } else {
            $CAT->buscar = $buscar;
            $CAT->pagina = $pagina;
            $CAT->limite = $limite;
            if ($categorias = $CAT->mostrar_categorias_prima()) {
                $categorias_data = [];
                while ($categoria = $categorias->fetch_assoc()) {
                    $categorias_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $categorias_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $CAT->total_categorias(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 15);
        if ($buscar) {
            if ($categoria = $CAT->mostrar_categoria($buscar)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontró',
                    'data' => [$categoria],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El categoria que estas buscando no fue encontrado'];
            }
        } else {
            $CAT->buscar = $buscar;
            $CAT->pagina = $pagina;
            $CAT->limite = $limite;
            if ($categorias = $CAT->mostrar_categorias()) {
                $categorias_data = [];
                while ($categoria = $categorias->fetch_assoc()) {
                    $categorias_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $categorias_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $CAT->total_categorias(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'crear':
        $nombre      = isset($_POST['nombre_categoria'])     && !empty($_POST['nombre_categoria'])     ? htmlspecialchars($_POST['nombre_categoria']) : false;
        $tipo      = isset($_POST['tipo'])     && !empty($_POST['tipo'])     ? htmlspecialchars($_POST['tipo']) : false;
        $CAT = new Categorias();
        $CAT->nombre = $nombre;
        $CAT->tipo = $tipo;
        $categoria = $CAT->mostrar_categorias();
        if ($categoria) {
            if ($id_categoria = $CAT->crear_categoria($nombre, $tipo))
                $respuesta = ['response' => 'success', 'text' => 'La categoria fue registrado correctamente', "data" => ["id_categoria" => $id_categoria]]; //Crea usuario y arroja respuesta: id_usuario
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar el registro',]; //Error en la actualización no funciono el query
        } else $respuesta = ['response' => 'warning', 'text' => 'Es necesario que completes todos los campos obligatorios',]; //Error al consultar el usuario bd no conección

        echo json_encode($respuesta);
        break;
    case 'eliminar_categoria':
        $id_categoria      = isset($_POST['idcategoria'])     && !empty($_POST['idcategoria'])     ? htmlspecialchars($_POST['idcategoria']) : false;
        $CATEGORAS = new Categorias();
        if ($eliminacion = $CATEGORAS->eliminar_categoria($id_categoria)) {
            $respuesta = ['response' => 'success', 'text' => 'La categoría fue eliminada', "data" => ["id_categoria" => $eliminacion]];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No pudimos eliminar esta categoria',];
        }
        echo json_encode($respuesta);
        break;
    case 'crear_categoria':
        $nombre      = isset($_POST['nombre_categoria'])     && !empty($_POST['nombre_categoria'])     ? htmlspecialchars($_POST['nombre_categoria']) : false;
        $tipo      = isset($_POST['tipo'])     && !empty($_POST['tipo'])     ? htmlspecialchars($_POST['tipo']) : false;
        $CAT = new Categorias();
        $CAT->nombre = $nombre;
        $categoria = $CAT->mostrar_categorias();
        if ($id_categoria = $CAT->crear_categoria($nombre, $tipo))
            $respuesta = ['response' => 'success', 'text' => 'La categoria fue registrado correctamente', "data" => ["id_categoria" => $id_categoria]]; //Crea usuario y arroja respuesta: id_usuario
        else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar el registro',]; //Error en la actualización no funciono el query
        echo json_encode($respuesta);
        break;
    case 'modificar':
        $id_categoria  = (isset($_POST['id_categoria']) && !empty($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : false);
        $nombre        = isset($_POST['nombre'])        && !empty($_POST['nombre'])       ? htmlspecialchars($_POST['nombre']) : false;
        $estado        = isset($_POST['estado'])        && !empty($_POST['estado'])       ? htmlspecialchars($_POST['estado']) : false;

        $CAT = new Categorias();
        $CAT->nombre = $nombre;
        $categoria = $CAT->mostrar_categoria($id_categoria);
        if ($categoria) {
            $CAT->nombre          = $nombre;
            $CAT->estado          = $estado;
            if ($id = $CAT->actualizar($id_categoria)) $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al categoria' . $id_categoria . $nombre . $estado];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el categoria, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;
    case 'cargar_articulos_categoria':
        $id_categoria  = (isset($_POST['id_categoria']) && !empty($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : false);
        $CATEGORIAS = new Categorias();
        $articulos_data = [];
        if ($articulos = $CATEGORIAS->mostrar_articulos_categoria($id_categoria)) {
            while ($articulo = $articulos->fetch_assoc()) {
                $articulos_data[] = $articulo;
            }
            $respuesta = ['response' => 'success', 'text' => 'La categoria fue registrado correctamente', "data" => ["articulos" => $articulos_data]];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar los artículos de esta categoría'];
        }
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
