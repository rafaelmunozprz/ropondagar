<?php

use App\Models\Anaqueles;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$ANAQUELES = new Anaqueles();
$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];
header('Content-type:application/json;charset=utf-8');
switch ($opcion) {
    case 'redimensionar_anaquel':
        $redimensionar_columnas_anaquel = isset($_POST['redimensionar_columnas_anaquel']) && !empty($_POST['redimensionar_columnas_anaquel']) ? htmlspecialchars($_POST['redimensionar_columnas_anaquel']) : false;
        $redimensionar_filas_anaquel = isset($_POST['redimensionar_filas_anaquel']) && !empty($_POST['redimensionar_filas_anaquel']) ? htmlspecialchars($_POST['redimensionar_filas_anaquel']) : false;
        $codigo_anaquel = isset($_POST['codigo_anaquel']) && !empty($_POST['codigo_anaquel']) ? htmlspecialchars($_POST['codigo_anaquel']) : false;
        if ($anaquel = $ANAQUELES->cargar_dimensiones($codigo_anaquel)) {
            $anaquel = $anaquel->fetch_assoc();
            $nuevas_dimensiones = $redimensionar_filas_anaquel.','.$redimensionar_columnas_anaquel;
            if($anaquel['tamano']==$nuevas_dimensiones){
                $respuesta = ['response' => 'igual', 'text' => 'El tamaño no ha sido modificado, revisar las dimensiones', "data" => ["dimensiones" => $anaquel['tamano']]];
            }else{
                if($actualizacion = $ANAQUELES->redimensionar_anaquel($codigo_anaquel, $redimensionar_filas_anaquel, $redimensionar_columnas_anaquel)){
                    $respuesta = ['response' => 'success', 'text' => 'El tamaño ha sido modificado satisfactoriamente', "data" => ["dimensiones" => $actualizacion]];
                }
            }            
        } else $respuesta = ['response' => 'warning', 'text' => 'No se puedo cargar el anaquel',];
        echo json_encode($respuesta);
        break;
    case 'cargar_dimensiones':
        $codigo_anaquel = isset($_POST['codigo_anaquel']) && !empty($_POST['codigo_anaquel']) ? htmlspecialchars($_POST['codigo_anaquel']) : false;
        $ANAQUELES = new Anaqueles();
        if ($anaquel = $ANAQUELES->cargar_dimensiones($codigo_anaquel)) {
            $anaquel = $anaquel->fetch_assoc();
            $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["dimensiones" => $anaquel]];
        } else $respuesta = ['response' => 'warning', 'text' => 'No se puedo cargar el anaquel',];
        echo json_encode($respuesta);
        break;
    case 'crear_anaquel':
        $filas_anaquel = isset($_POST['filas_anaquel']) && !empty($_POST['filas_anaquel']) ? htmlspecialchars($_POST['filas_anaquel']) : false;
        $columnas_anaquel = isset($_POST['columnas_anaquel']) && !empty($_POST['columnas_anaquel']) ? htmlspecialchars($_POST['columnas_anaquel']) : false;
        $tamano = $filas_anaquel . ',' . $columnas_anaquel;
        $ANAQUELES = new Anaqueles();
        if ($id_anaquel = $ANAQUELES->crear_anaquel($tamano, '3'))
            $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["filas_anaquel" => $filas_anaquel]];
        else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar el registro',];
        echo json_encode($respuesta);
        break;
    case 'mostrar_grid':
        $codigo_anaquel = isset($_POST['codigo']) && !empty($_POST['codigo']) ? htmlspecialchars($_POST['codigo']) : false;
        $ANAQUELES = new Anaqueles();
        $materia_data = [];
        if ($codigo = $ANAQUELES->mostrar_grid($codigo_anaquel)) {
            while ($anaquel = $codigo->fetch_assoc()) {
                $materia_data[] = $anaquel;
            }
            $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["grid_anaquel" => $materia_data]];
        }
        echo json_encode($respuesta);
        break;
    case 'mostrar_materia':
        $posicion = isset($_POST['posicion']) && !empty($_POST['posicion']) ? htmlspecialchars($_POST['posicion']) : false;
        $codigo_anaquel = isset($_POST['codigo_anaquel']) && !empty($_POST['codigo_anaquel']) ? htmlspecialchars($_POST['codigo_anaquel']) : false;
        $materia_data = [];
        $ANAQUELES = new Anaqueles();
        if ($codigo = $ANAQUELES->mostrar_materia($posicion, $codigo_anaquel)) {
            while ($anaquel = $codigo->fetch_assoc()) {
                $materia_data[] = $anaquel;
            }
            if (count($materia_data) > 0) {
                $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["posicion_anaquel" => $materia_data]];
            } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible encontrar este anaquel'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible encontrar este anaquel'];
        echo json_encode($respuesta);
        break;
    case 'agregar_materia':
        $codigo_materia = isset($_POST['contenedor_codigo_materia']) && !empty($_POST['contenedor_codigo_materia']) ? htmlspecialchars($_POST['contenedor_codigo_materia']) : false;
        $cantidad = isset($_POST['contenedor_agregar_cantidad']) && !empty($_POST['contenedor_agregar_cantidad']) ? htmlspecialchars($_POST['contenedor_agregar_cantidad']) : false;
        $espacio = isset($_POST['nombre_espacio']) && !empty($_POST['nombre_espacio']) ? htmlspecialchars($_POST['nombre_espacio']) : false;
        $ANAQUELES = new Anaqueles();
        if ($material = $ANAQUELES->guardar_articulo($cantidad, $codigo_materia, $espacio)) {
            //print_r($material);
            $respuesta = ['response' => 'success', 'text' => 'Material registrado con éxito, ¡recuerda guardarlo en el lugar seleccionado!', "data" => ["filas_anaquel" => $cantidad]];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible registrar el artículo'];
        }
        echo json_encode($respuesta);
        break;
    case 'agregar_productos':
        $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["filas_anaquel" => $filas_anaquel]];
        echo json_encode($respuesta);
        break;
    case 'eliminar_anaquel':
        $codigo_anaquel = isset($_POST['codigo_anaquel']) && !empty($_POST['codigo_anaquel']) ? htmlspecialchars($_POST['codigo_anaquel']) : false;
        if($ocupado = $ANAQUELES->comprobar_ocupado($codigo_anaquel)){
            $respuesta = ['response' => 'ocupado', 'text' => 'No fue posible registrar el anaquel, los campos ocupado están pintados de verde'];
        }else{
            if($eliminacion = $ANAQUELES->eliminar_anaquel($codigo_anaquel)){
                $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["filas_anaquel" => $eliminacion]];
            }else{
                $respuesta = ['response' => 'ocupado', 'text' => 'No fue posible eliminar el anaquel'];
            }
        }               
        echo json_encode($respuesta);
        break;
    case 'mostrar_anaqueles':
        $buscar = $_POST['buscar'];
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        //
        if ($buscar) {
            if ($anaquel = $ANAQUELES->mostrar_anaqueles()) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Anaquel encontrado',
                    'data' => [$anaquel],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El anaquel que se está solicitando, no fue encontrado'];
            }
        } else {
            $ANAQUELES->buscar = $buscar;
            $ANAQUELES->pagina = $pagina;
            $ANAQUELES->limite = $limite;
            if ($anaqueles = $ANAQUELES->mostrar_anaqueles()) {
                $anaqueles_data = [];
                while ($anaquel = $anaqueles->fetch_assoc()) {
                    $anaqueles_data[] = $anaquel;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El anaquel se encontró',
                    'data' => $anaqueles_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $ANAQUELES->total_anaqueles(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'mostrar_productos':
        $respuesta = ['response' => 'success', 'text' => 'Anaquel registrado con éxito, ¡recuerda que los anaqueles no pueden disminuir su tamaño!', "data" => ["filas_anaquel" => $filas_anaquel]];
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
