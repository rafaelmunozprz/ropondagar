<?php

use App\Models\Notificacion;
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
    case 'mostrar_notificaciones':
        $pagina  = isset($_POST['pagina']) && !empty($_POST['pagina']) ? (int)$_POST['pagina']  : 1;
        $limite  = isset($_POST['limite']) && !empty($_POST['limite']) ? (int)$_POST['limite']   : 16;

        $hoy = date('Y-m-d');

        // if ($USERSYSTEM && $USERSYSTEM['cargo'] == 'administrador') {
        if (true) {
            $NTF = new Notificacion();
            $NTF->limite =        $limite;
            $NTF->pagina =        $pagina;

            if ($notificaciones = $NTF->mostrar_notificacion()) {
                $noti_array = $notificaciones->fetch_all(MYSQLI_ASSOC);

                foreach ($noti_array as $i_ntf => $notificacion)  $noti_array[$i_ntf]['config'] = json_decode($notificacion['config'], true);

                $respuesta = array(
                    'status' => true,
                    'response' => 'exito',
                    'text' => 'La notificación fue creada de forma exitosa',
                    'data' => $noti_array,
                    // 'pagina' => $pagina,
                    // 'limite' => $limite,
                );
            } else {
                $respuesta = array('status' => false, 'respuesta' => 'error', 'Texto' => 'No existen notificaciones en el sistema',);
            }
        } else {
            $respuesta = array('status' => false, 'respuesta' => 'error', 'Texto' => 'No existen notificaciones en el sistema',);
        }
        die(json_encode($respuesta));
        break;
    case 'actualizar':
        $id_ntf  = isset($_POST['id_ntf']) && !empty($_POST['id_ntf']) ? (int)$_POST['id_ntf']  : false;

        $hoy = date('Y-m-d H:m:s');

        $NTF = new Notificacion();
        if ($id_ntf && ($notificacion = $NTF->mostrar_notificacion($id_ntf))) {
            $notificacion = $notificacion->fetch_assoc();

            $visto = ($notificacion['visto'] ? json_decode($notificacion['visto'], true) : false);

            $id_usuario = $USERSYSTEM['idUsuario'];

            $ya_vio = false;
            $vistas = [];
            if ($visto) {
                foreach ($visto as $i_ntf => $usuario) {
                    if (isset($usuario['id_usuario']) &&  $usuario['id_usuario']) $ya_vio = true;
                    $vistas[] = $usuario;
                }
            }
            if (!$ya_vio) $vistas[] = ['id_usuario' => $id_usuario, 'fecha' => $hoy];

            $NTF->actualizar_notificacion($id_ntf, json_encode($vistas, JSON_UNESCAPED_UNICODE));

            $respuesta = array(
                'status' => true,
                'response' => 'exito',
                'text' => 'La notificación fue creada de forma exitosa',
                'data' => $vistas,
            );
        } else {
            $respuesta = array('status' => false, 'respuesta' => 'error', 'Texto' => 'No existen notificaciones en el sistema',);
        }

        die(json_encode($respuesta));
        break;

    default:
        # code...
        break;
}
