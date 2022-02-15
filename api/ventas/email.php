<?php

use App\Email\{Email, Emailtemplate};
use App\Models\{ClienteNota, Materiaprima};

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);


/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada', $_POST
];

header('Content-type:application/json;charset=utf-8');
$permisos = ['enviar_email'];

switch ($opcion) {
    case 'enviar_email':
        $id_nota = (isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? (int)($_POST['id_nota']) : false);

        $total = 0;

        // $LIB = new Libreria();
        // $LIB->PHPMailer();

        $NOTE_P = new ClienteNota();
        $MATERIA = new Materiaprima();
        $EMAIL = new Email();
        $TEMPLATE = new Emailtemplate();

        if ($nota = $NOTE_P->mostrar_nota($id_nota)) {
            $nota['productos'] = json_decode($nota['productos'], true);
            $cliente = $NOTE_P->mostrar_cliente($nota['id_cliente']);
            $pagos = $NOTE_P->mostrar_pagos($nota['id_nota_cliente']);

            $template_mail = $TEMPLATE->nota_venta_cliente($nota, $cliente, $pagos);
            $user = array(
                'name' => $cliente['razon_social'],
                'lastname' => '',
                'email' => $cliente['correo'],
                'Subject' => '📝 Recibo nota de venta',
                'message' => 'Gracias por ser parte de esta gran familia',
            );
            if ($email_res = $EMAIL->sendMail($user, $template_mail)) {
                $respuesta = [
                    'status' => true,
                    'response' => 'success',
                    'text' => 'El correo se envio de forma correcta',
                    'data' => $email_res
                ];
            } else {
                $respuesta = [
                    'status' => false,
                    'response' => 'error',
                    'text' => 'Por el momento no es posible seguir enviando correos',
                ];
            }
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'La nota no se encotro',
            ];
        }




        echo json_encode($respuesta);
        break;
}
