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
    case 'crear_nota':
        $productos             = (isset($_POST['productos'])             && !empty($_POST['productos'])             ? json_decode($_POST['productos'], true)       : false);
        $descuento             = (isset($_POST['descuento'])             && !empty($_POST['descuento'])             ? json_decode($_POST['descuento'], true)             : false);
        $datos_cliente_general = (isset($_POST['datos_cliente_general']) && !empty($_POST['datos_cliente_general']) ? json_decode($_POST['datos_cliente_general'], true) : false);
        $id_cliente            = (isset($_POST['id_cliente'])            && !empty($_POST['id_cliente'])            ? (int)$_POST['id_cliente']                    : 1);
        $id_usuario            = (isset($_POST['id_usuario'])            && !empty($_POST['id_usuario'])            ? (int)$_POST['id_usuario']                    : 1);

        // $cantidad_productos    = (isset($_POST['cantidad_productos'])    && !empty($_POST['cantidad_productos'])    ? (int)$_POST['cantidad_productos']    : false);
        // $total_costo           = (isset($_POST['total_costo'])           && !empty($_POST['total_costo'])           ? $_POST['total_costo']           : false);
        // $fecha                 = (isset($_POST['fecha'])                 && !empty($_POST['fecha'])                 ? $_POST['fecha']                 : false);
        $iva                   = (isset($_POST['iva'])                   && !empty($_POST['iva'])                   ? floatval($_POST['iva'])                   : 0);
        $total_pagado          = (isset($_POST['total_pagado'])          && !empty($_POST['total_pagado'])          ? $_POST['total_pagado']          : 0);
        $comentario            = (isset($_POST['comentario'])            && !empty($_POST['comentario'])            ? $_POST['comentario']            : false);

        if ($productos) {
            $cantidad_productos = sizeof($productos);
            $total_costo = 0;
            foreach ($productos as $i_prod => $producto) {
                $total_costo += (floatval($producto['precio']) * ((int)$producto['cantidad']));
            }
            $descuento_val = 0;

            $tipo_descuento = ($descuento ? $descuento['tipo'] : "moneda"); //Tiene que venir en el arreglo del descuento {tipo:"",cantidad:0}
            $descuento = ($descuento ? $descuento['cantidad'] : 0); //Tiene que venir en el arreglo del descuento {tipo:"",cantidad:0}
            $descuento_val = ($tipo_descuento == 'moneda' ? $descuento : (($descuento / 100) * $total_costo)); //Descuento aplicado por el tipo de producto, esto solo afecta al precio final

            $total_costo = $total_costo - $descuento_val; //La suma total menos el descuento

            $productos = json_encode($productos, JSON_UNESCAPED_UNICODE); //Se vuelven String para almacenar
            $datos_cliente_general = $datos_cliente_general ? json_encode($datos_cliente_general, JSON_UNESCAPED_UNICODE) : ""; //Se vuelven String para almacenar


            // if ($id = $CLIENT->crear_nota($productos, $cantidad_productos, $total_costo, $id_cliente, $id_usuario, $iva, $descuento, $tipo_descuento, $datos_cliente_general, $comentario)) {
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
