<?php

use App\Models\Clientes;
use App\Email\Email;
use App\Libreria\Libreria;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);
// $LIB = new Libreria();
// $LIB->PHPMailer();
$MAIL = new Email();
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

//print_r($opcion); endejo es estehahahanhaahahahahahah

switch ($opcion) {
    case 'enviar_nota_correo':
        $cliente = $_POST['cliente'];
        $datos = $_POST['datos'];
        $descuento = $_POST['descuento'];
        $EMAIL = new Email();
        if ($mail = $EMAIL->sendMailNota($cliente,  $datos, $descuento)) {
            $respuesta = ['response' => 'success', 'text' => 'El correo fue enviado exitosamente, revise su bandeja de correo no deseado.'];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible enviar el correo'];
        }
        echo json_encode($respuesta);
        break;
    case 'enviar_pdf':
        $cliente = $_POST['cliente'];
        $datos = $_POST['datos'];
        $descuento = $_POST['descuento'];
        $EMAIL = new Email();
        if ($mail = $EMAIL->sendMailNota($cliente,  $datos, $descuento)) {
            $respuesta = ['response' => 'success', 'text' => 'El correo fue enviado exitosamente, revise su bandeja de correo no deseado.'];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible enviar el correo'];
        }
        echo json_encode($respuesta);
        break;
    case 'index_mail':
        /* $LIBRARY = new Libreria();
        $LIBRARY->PHPMailer(); */
        $nombre_contacto = isset($_POST['nombre_contacto'])     && !empty($_POST['nombre_contacto'])     ? htmlspecialchars($_POST['nombre_contacto']) : false;
        $correo_contacto = isset($_POST['correo_contacto'])     && !empty($_POST['correo_contacto'])     ? htmlspecialchars($_POST['correo_contacto']) : false;
        $telefono_contacto = isset($_POST['telefono_contacto'])     && !empty($_POST['telefono_contacto'])     ? htmlspecialchars($_POST['telefono_contacto']) : false;
        $EMAIL = new Email();
        if ($mail = $EMAIL->sendMailIndex($nombre_contacto, $correo_contacto, $telefono_contacto)) {
            $respuesta = ['response' => 'success', 'text' => 'El correo fue enviado exitosamente, espera nuestra llamada.', "data" => ["correo" => $correo_contacto]];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible enviar el correo', "data" => $correo_contacto];
        }

        echo json_encode($respuesta);
        break;
    case 'index_contacto':
        $nombre_contacto = isset($_POST['nombre_contacto'])     && !empty($_POST['nombre_contacto'])     ? htmlspecialchars($_POST['nombre_contacto']) : false;
        $correo_contacto = isset($_POST['correo_contacto'])     && !empty($_POST['correo_contacto'])     ? htmlspecialchars($_POST['correo_contacto']) : false;
        $telefono_contacto = isset($_POST['telefono_contacto'])     && !empty($_POST['telefono_contacto'])     ? htmlspecialchars($_POST['telefono_contacto']) : false;
        $asunto_contacto = isset($_POST['asunto_contacto'])     && !empty($_POST['asunto_contacto'])     ? htmlspecialchars($_POST['asunto_contacto']) : false;
        $cuerpo_mensaje = isset($_POST['cuerpo_mensaje'])     && !empty($_POST['cuerpo_mensaje'])     ? htmlspecialchars($_POST['cuerpo_mensaje']) : false;
        $EMAIL = new Email();
        if ($mail = $EMAIL->sendMailContacto($nombre_contacto, $correo_contacto, $telefono_contacto, $asunto_contacto, $cuerpo_mensaje)) {
            $respuesta = ['response' => 'success', 'text' => 'El correo fue enviado exitosamente, espera nuestra llamada.', "data" => ["correo" => $correo_contacto]];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'No fue posible enviar el correo', "data" => $correo_contacto];
        }
        echo json_encode($respuesta);
        break;
}
