<?php

use App\Models\Funciones;
use App\Models\Usuarios;

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
    case 'mostrar_usuarios':
        $id_usuario     = isset($_POST['id_usuario'])    && !empty($_POST['id_usuario'])    ? htmlspecialchars($_POST['id_usuario']) : false;
        $buscar         = isset($_POST['buscar'])        && !empty($_POST['buscar'])        ? htmlspecialchars($_POST['buscar']) : "";
        $pagina         = isset($_POST['pagina'])        && !empty($_POST['pagina'])        ? (int)($_POST['pagina']) : 1;
        $limite         = isset($_POST['limite'])        && !empty($_POST['limite'])        ? (int)($_POST['limite']) : 12;

        $USER = new Usuarios();

        if ($id_usuario) {
            if ($usuario = $USER->buscar_usuario($id_usuario)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El usuario se encontro',
                    'data' => [$usuario],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => 1,
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El usuario que estas buscando no fue encontrado'];
            }
        } else {
            $USER->buscar = $buscar;
            $USER->pagina = $pagina;
            $USER->limite = $limite;

            if ($usuarios = $USER->mostrar_usuarios()) {
                $usuarios_data = [];
                while ($usuario = $usuarios->fetch_assoc()) {
                    $usuario['direccion'] = json_decode($usuario['direccion'], true);
                    $usuarios_data[] = $usuario;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El usuario se encontro',
                    'data' => $usuarios_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int)$limite,
                        'total' => (int)$USER->total_usuarios(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);

        break;
    case 'registrar_usuario':
        $nombre            = isset($_POST['nombre'])           && !empty($_POST['nombre'])           ? htmlspecialchars($_POST['nombre']) : false;
        $apellidos         = isset($_POST['apellidos'])        && !empty($_POST['apellidos'])        ? htmlspecialchars($_POST['apellidos']) : false;
        $telefono          = isset($_POST['telefono'])         && !empty($_POST['telefono'])         ? htmlspecialchars($_POST['telefono']) : false;
        $direccion         = isset($_POST['direccion'])        && !empty($_POST['direccion'])        ? json_decode($_POST['direccion'], true) : false;
        $cargo             = isset($_POST['cargo'])            && !empty($_POST['cargo'])            ? htmlspecialchars($_POST['cargo']) : false;
        $correo            = isset($_POST['correo'])           && !empty($_POST['correo'])           ? htmlspecialchars($_POST['correo']) : false;
        $nombre_usuario    = isset($_POST['nombre_usuario'])   && !empty($_POST['nombre_usuario'])   ? htmlspecialchars($_POST['nombre_usuario']) : false;
        $fecha_nacimiento  = isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : "";
        $estado            = isset($_POST['estado'])           && !empty($_POST['estado'])           ? htmlspecialchars($_POST['estado']) : 'inactivo';
        $id_avatar         = isset($_POST['id_avatar'])        && !empty($_POST['id_avatar'])        ? (int)($_POST['id_avatar']) : 1;

        $USER = new Usuarios();
        if ($USER->encontrar_usuario($nombre_usuario)) {
            $respuesta = ['response' => 'warning', 'text' => 'El nombre de usuario ya fue registrado',];
        } elseif ($USER->encontrar_usuario($correo)) {
            $respuesta = ['response' => 'warning', 'text' => 'El correo eléctronico ya se encuentra registrado',];
        } else if ($nombre && $apellidos && $telefono && $cargo && $nombre_usuario) {
            $FUNC = new Funciones();
            $password = ($FUNC->generarPassword(10));
            $md_password = md5($password);
            $direccion = ($direccion ? json_encode($direccion, JSON_UNESCAPED_UNICODE) : "");
            if ($id_usuario = $USER->crear_usuario($nombre, $apellidos, $telefono, $direccion, $cargo, $nombre_usuario, $md_password, $fecha_nacimiento, $estado, $id_avatar))
                $respuesta = ['response' => 'success', 'text' => 'Actualización creada de forma exitosa', "data" => ["id_usuario" => $id_usuario, "password" => $password]]; //Crea usuario y arroja respuesta: id_usuario
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar el registro',]; //Error en la actualización no funciono el query
        } else $respuesta = ['response' => 'warning', 'text' => 'Es necesario que completes todos los campos obligatorios',]; //Error al consultar el usuario bd no conección

        echo json_encode($respuesta);
        break;
    case 'actualizar_usuario':
        $id_usuario        = isset($_POST['id_usuario'])       && !empty($_POST['id_usuario'])       ? (int)($_POST['id_usuario']) : false;
        $nombre            = isset($_POST['nombre'])           && !empty($_POST['nombre'])           ? htmlspecialchars($_POST['nombre']) : false;
        $apellidos         = isset($_POST['apellidos'])        && !empty($_POST['apellidos'])        ? htmlspecialchars($_POST['apellidos']) : false;
        $telefono          = isset($_POST['telefono'])         && !empty($_POST['telefono'])         ? htmlspecialchars($_POST['telefono']) : false;
        $direccion         = isset($_POST['direccion'])        && !empty($_POST['direccion'])        ? json_decode($_POST['direccion'], true) : false; // La dirección es un JSON que contiene más información del domicilio
        $cargo             = isset($_POST['cargo'])            && !empty($_POST['cargo'])            ? htmlspecialchars($_POST['cargo']) : false;
        $nombre_usuario    = isset($_POST['nombre_usuario'])   && !empty($_POST['nombre_usuario'])   ? htmlspecialchars($_POST['nombre_usuario']) : false;
        $fecha_nacimiento  = isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : false;
        $fecha_salida      = isset($_POST['fecha_salida'])     && !empty($_POST['fecha_salida'])     ? htmlspecialchars($_POST['fecha_salida']) : false;
        $estado            = isset($_POST['estado'])           && !empty($_POST['estado'])           ? htmlspecialchars($_POST['estado']) : false;
        $id_avatar         = isset($_POST['id_avatar'])        && !empty($_POST['id_avatar'])        ? (int)($_POST['id_avatar']) : 1;

        $USER = new Usuarios();
        if ($usuario = $USER->buscar_usuario($id_usuario)) {

            $USER->nombre            = $nombre;
            $USER->apellidos         = $apellidos;
            $USER->telefono          = $telefono;
            $USER->direccion         = $direccion ? json_encode($direccion, JSON_UNESCAPED_UNICODE) : "";
            $USER->cargo             = $cargo;
            $USER->nombre_usuario    = $nombre_usuario;
            $USER->fecha_nacimiento  = $fecha_nacimiento;
            $USER->fecha_salida      = $fecha_salida;
            $USER->estado            = $estado;
            $USER->id_avatar         = $id_avatar;

            if ($USER->actualizar_usuario($id_usuario)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Actualización realizada de forma exitosa',
                    'data' => [
                        'id_usuario' => $id_usuario,
                        'estado' => $USER->estado,
                    ]
                ];
            } else {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'Error al realizar la actualización, no se registro ningun cambio',
                ];
            }
        } else {
            $respuesta = [
                'response' => 'warning',
                'text' => 'Ocurrio un error al buscar el usuario',
            ];
        }

        echo json_encode($respuesta);

        break;
    case 'reiniciar_password':
        $id_usuario        = isset($_POST['id_usuario'])       && !empty($_POST['id_usuario'])       ? (int)($_POST['id_usuario']) : false;

        $USER = new Usuarios();
        $FUNC = new Funciones();
        if ($usuario = $USER->buscar_usuario($id_usuario)) {
            $password  = $FUNC->generarPassword(10);
            $USER->password = md5($password);

            if ($USER->actualizar_usuario($id_usuario)) {
                $respuesta = ['response' => 'success', 'text' => 'Actualización creada de forma exitosa', "data" =>
                ["id_usuario" => $id_usuario, "password" => $password]]; //Crea usuario y arroja respuesta: id_usuario
            } else {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'Error al realizar la actualización, no se registro ningun cambio',
                ];
            }
        } else {
            $respuesta = [
                'response' => 'warning',
                'text' => 'Ocurrio un error al buscar el usuario',
            ];
        }
        echo json_encode($respuesta);
        break;
    case 'cambiar_password':
        $id_usuario = $USERSYSTEM['idUsuario'];
        $password       = isset($_POST['password'])       && !empty($_POST['password'])       ? htmlspecialchars($_POST['password']) : false;
        $new_password   = isset($_POST['new_password'])   && !empty($_POST['new_password'])   ? htmlspecialchars($_POST['new_password']) : false;
        $r_new_password = isset($_POST['r_new_password']) && !empty($_POST['r_new_password']) ? htmlspecialchars($_POST['r_new_password']) : false;


        $USER = new Usuarios();
        $FUNC = new Funciones();
        if ($usuario = $USER->mostrar_usuario($id_usuario)) {
            if (md5($password) != $usuario['password']) {
                $respuesta = ['response' => 'warning', 'text' => 'La contraseña tu contraseña actual no coincide con la contraseña activa',];
            } else if (strlen($new_password) < 8 || strlen($new_password) > 130) {
                $respuesta = ['response' => 'warning', 'text' => 'La contraseña no puede ser' . (strlen($new_password) < 8 ? " menor a 8 caracteres" : " mayor a 130 caracteres"),];
            } else if ($new_password != $r_new_password) {
                $respuesta = ['response' => 'warning', 'text' => "Las contraseña nueva no incide"];
            } elseif (md5($password) == $usuario['password'] && $new_password == $r_new_password && strlen($new_password) >= 8 && strlen($new_password) <= 130) {
                $USER->password = md5($new_password);
                if ($USER->actualizar_usuario($id_usuario)) {
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'Actualización creada de forma exitosa',
                        "data" => ["id_usuario" => $id_usuario, "password" => $password]
                    ]; //Crea usuario y arroja respuesta: id_usuario
                } else {
                    $respuesta = [
                        'response' => 'warning',
                        'text' => 'Error al realizar la actualización, no se registro ningun cambio',
                    ];
                }
            } else {
                $respuesta = [
                    'response' => 'warning',
                    'text' => 'Las contraseñas no estan escritas correctamente',
                ];
            }
        } else {
            $respuesta = [
                'response' => 'warning',
                'text' => 'Ocurrio un error al buscar el usuario',
            ];
        }

        echo json_encode($respuesta);
        break;
}
