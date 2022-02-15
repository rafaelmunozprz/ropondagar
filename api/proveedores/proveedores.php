<?php

use App\Models\Proveedores;
use App\Models\Funciones;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$MODEL = new Proveedores();

/**
 * /// @RUTA/back/proveedores
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */
$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

$permisos = ['mostrar', 'registrar_proveedor', 'modificar_proveedor'];

switch ($opcion) {
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 8);
        $id_proveedor  = (isset($_POST['id_proveedor']) && !empty($_POST['id_proveedor']) ? $_POST['id_proveedor'] : false);


        if ($id_proveedor) {
            if ($proveedor = $MODEL->mostrar_proveedor($id_proveedor)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El proveedor se encontro',
                    'data' => [$proveedor],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => 1,
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El proveedor que estas buscando no fue encontrado'];
            }
        } else {
            $MODEL->buscar = $buscar;
            $MODEL->pagina = $pagina;
            $MODEL->limite = $limite;

            if ($proveedores = $MODEL->mostrar_proveedores()) {
                $proveedores_data = [];
                while ($proveedor = $proveedores->fetch_assoc()) {
                    $proveedor['direccion'] = json_decode($proveedor['direccion'], true);
                    $proveedores_data[] = $proveedor;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El proveedor se encontro',
                    'data' => $proveedores_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => (int)$MODEL->total_proveedores(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'registrar_proveedor':
        $razon_social      = isset($_POST['razon_social'])     && !empty($_POST['razon_social'])     ? htmlspecialchars($_POST['razon_social']) : false;
        $rfc               = isset($_POST['rfc'])              && !empty($_POST['rfc'])              ? htmlspecialchars($_POST['rfc']) : false;
        $telefono          = isset($_POST['telefono'])         && !empty($_POST['telefono'])         ? htmlspecialchars($_POST['telefono']) : false;
        $direccion         = isset($_POST['direccion'])        && !empty($_POST['direccion'])        ? json_decode($_POST['direccion'], true) : false;
        $correo            = isset($_POST['correo'])           && !empty($_POST['correo'])           ? htmlspecialchars($_POST['correo']) : false;
        $tipo_persona      = isset($_POST['tipo_persona'])     && !empty($_POST['tipo_persona'])     ? htmlspecialchars($_POST['tipo_persona']) : false;
        $tipo_proveedor    = isset($_POST['tipo_proveedor'])   && !empty($_POST['tipo_proveedor'])   ? htmlspecialchars($_POST['tipo_proveedor']) : false;

        $CLIENT = new Proveedores();
        if ($razon_social && $rfc && $telefono && $correo && $tipo_persona) {
            $FUNC = new Funciones();
            $direccion = ($direccion ? json_encode($direccion, JSON_UNESCAPED_UNICODE) : "");
            if ($id_proveedor = $CLIENT->crear_proveedor($razon_social, $rfc, $tipo_persona, $telefono, $correo, $direccion))
                $respuesta = ['response' => 'success', 'text' => 'El proveedor fue registrado correctamente', "data" => ["id_proveedor" => $id_proveedor]]; //Crea usuario y arroja respuesta: id_usuario
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar el registro',]; //Error en la actualización no funciono el query
        } else $respuesta = ['response' => 'warning', 'text' => 'Es necesario que completes todos los campos obligatorios',]; //Error al consultar el usuario bd no conección

        echo json_encode($respuesta);
        break;
    case 'modificar_proveedor':
        $id_proveedor      = (isset($_POST['id_proveedor'])    && !empty($_POST['id_proveedor'])     ? $_POST['id_proveedor'] : false);
        $razon_social      = isset($_POST['razon_social'])     && !empty($_POST['razon_social'])     ? htmlspecialchars($_POST['razon_social']) : false;
        $rfc               = isset($_POST['rfc'])              && !empty($_POST['rfc'])              ? htmlspecialchars($_POST['rfc']) : false;
        $telefono          = isset($_POST['telefono'])         && !empty($_POST['telefono'])         ? htmlspecialchars($_POST['telefono']) : false;
        $direccion         = isset($_POST['direccion'])        && !empty($_POST['direccion'])        ? json_decode($_POST['direccion'], true) : false;
        $correo            = isset($_POST['correo'])           && !empty($_POST['correo'])           ? htmlspecialchars($_POST['correo']) : false;
        $tipo_persona      = isset($_POST['tipo_persona'])     && !empty($_POST['tipo_persona'])     ? htmlspecialchars($_POST['tipo_persona']) : false;
        $estado            = isset($_POST['estado'])           && !empty($_POST['estado'])           ? htmlspecialchars($_POST['estado']) : false;

        $CLIENT = new Proveedores();
        $proveedor = $CLIENT->mostrar_proveedor($id_proveedor);
        if ($proveedor) {
            $CLIENT->razon_social   = $razon_social;
            $CLIENT->rfc            = $rfc;
            $CLIENT->tipo_persona   = $tipo_persona;
            $CLIENT->telefono       = $telefono;
            $CLIENT->correo         = $correo;
            $CLIENT->direccion      = $direccion ? json_encode($direccion, JSON_UNESCAPED_UNICODE) : "";

            $CLIENT->estado         = $estado;
            if ($id = $CLIENT->actualizar($id_proveedor)) $respuesta = [
                'response' => 'success', 'text' => 'La actualización se realizo de forma exitosa',
                'data' => [
                    'id_proveedor' => $id_proveedor,
                    'estado' => $CLIENT->estado,
                ]
            ];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al proveedor'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el proveedor, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;

    default:
        echo json_encode($respuesta);
        break;
}
