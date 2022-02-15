<?php

use App\Models\Clientes;
use App\Models\Funciones;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$MODEL = new Clientes();

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
        $id_cliente  = (isset($_POST['id_cliente']) && !empty($_POST['id_cliente']) ? $_POST['id_cliente'] : false);


        if ($id_cliente) {
            if ($cliente = $MODEL->mostrar_cliente($id_cliente)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El cliente se encontro',
                    'data' => [$cliente],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => 1,
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El cliente que estas buscando no fue encontrado'];
            }
        } else {
            $MODEL->buscar = $buscar;
            $MODEL->pagina = $pagina;
            $MODEL->limite = $limite;

            if ($clientes = $MODEL->mostrar_clientes()) {
                $clientes_data = [];
                while ($cliente = $clientes->fetch_assoc()) {
                    $cliente['direccion'] = json_decode($cliente['direccion'], true);
                    $clientes_data[] = $cliente;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El cliente se encontro',
                    'data' => $clientes_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => (int)$MODEL->total_clientes(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'registrar_cliente':
        $razon_social      = isset($_POST['razon_social'])     && !empty($_POST['razon_social'])     ? htmlspecialchars($_POST['razon_social']) : false;
        $rfc               = isset($_POST['rfc'])              && !empty($_POST['rfc'])              ? htmlspecialchars($_POST['rfc']) : false;
        $telefono          = isset($_POST['telefono'])         && !empty($_POST['telefono'])         ? htmlspecialchars($_POST['telefono']) : false;
        $direccion         = isset($_POST['direccion'])        && !empty($_POST['direccion'])        ? json_decode($_POST['direccion'], true) : false;
        $correo            = isset($_POST['correo'])           && !empty($_POST['correo'])           ? htmlspecialchars($_POST['correo']) : false;
        $tipo_persona      = isset($_POST['tipo_persona'])     && !empty($_POST['tipo_persona'])     ? htmlspecialchars($_POST['tipo_persona']) : false;
        $tipo_cliente      = isset($_POST['tipo_cliente'])     && !empty($_POST['tipo_cliente'])     ? htmlspecialchars($_POST['tipo_cliente']) : false;

        $CLIENT = new Clientes();
        if ($razon_social && $rfc && $telefono && $correo && $tipo_persona && $tipo_cliente) {
            $FUNC = new Funciones();
            $direccion = ($direccion ? json_encode($direccion, JSON_UNESCAPED_UNICODE) : "");
            if ($id_cliente = $CLIENT->crear_cliente($razon_social, $rfc, $tipo_persona, $telefono, $correo, $direccion, $tipo_cliente))
                $respuesta = ['response' => 'success', 'text' => 'El cliente fue registrado correctamente', "data" => ["id_cliente" => $id_cliente]]; //Crea usuario y arroja respuesta: id_usuario
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar el registro',]; //Error en la actualización no funciono el query
        } else $respuesta = ['response' => 'warning', 'text' => 'Es necesario que completes todos los campos obligatorios',]; //Error al consultar el usuario bd no conección

        echo json_encode($respuesta);
        break;
    case 'modificar_cliente':
        $id_cliente       = (isset($_POST['id_cliente'])      && !empty($_POST['id_cliente'])      ? $_POST['id_cliente'] : false);
        $razon_social      = isset($_POST['razon_social'])     && !empty($_POST['razon_social'])     ? htmlspecialchars($_POST['razon_social']) : false;
        $rfc               = isset($_POST['rfc'])              && !empty($_POST['rfc'])              ? htmlspecialchars($_POST['rfc']) : false;
        $telefono          = isset($_POST['telefono'])         && !empty($_POST['telefono'])         ? htmlspecialchars($_POST['telefono']) : false;
        $direccion         = isset($_POST['direccion'])        && !empty($_POST['direccion'])        ? json_decode($_POST['direccion'], true) : false;
        $correo            = isset($_POST['correo'])           && !empty($_POST['correo'])           ? htmlspecialchars($_POST['correo']) : false;
        $tipo_persona      = isset($_POST['tipo_persona'])     && !empty($_POST['tipo_persona'])     ? htmlspecialchars($_POST['tipo_persona']) : false;
        $tipo_cliente      = isset($_POST['tipo_cliente'])     && !empty($_POST['tipo_cliente'])     ? htmlspecialchars($_POST['tipo_cliente']) : false;
        $estado            = isset($_POST['estado'])           && !empty($_POST['estado'])           ? htmlspecialchars($_POST['estado']) : false;

        $CLIENT = new Clientes();
        $cliente = $CLIENT->mostrar_cliente($id_cliente);
        if ($cliente) {
            $CLIENT->razon_social   = $razon_social;
            $CLIENT->rfc            = $rfc;
            $CLIENT->tipo_persona   = $tipo_persona;
            $CLIENT->telefono       = $telefono;
            $CLIENT->correo         = $correo;
            $CLIENT->direccion        = $direccion ? json_encode($direccion, JSON_UNESCAPED_UNICODE) : "";
            $CLIENT->tipo_cliente   = $tipo_cliente;
            // $CLIENT->fecha_registro = $fecha_registro;
            $CLIENT->estado         = $estado;
            if ($id = $CLIENT->actualizar($id_cliente)) $respuesta = [
                'response' => 'success', 'text' => 'La actualización se realizo de forma exitosa',
                'data' => [
                    'id_cliente' => $id_cliente,
                    'estado' => $CLIENT->estado,
                ]
            ];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al cliente'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el cliente, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;

    default:
        echo json_encode($respuesta);
        break;
}
