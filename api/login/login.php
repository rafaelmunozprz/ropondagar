<?php
header('Content-type: aplication/json');

use App\Config\Config;
use App\Email\Email;
use App\Email\Emailtemplate;
use App\Models\{Usuarios};

$CONFIG = new Config();
$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */

switch ($opcion) {
    case 'login':
        $correo  = isset($_POST['correo']) && !empty($_POST['correo']) ? $_POST['correo'] : false;
        $password  = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : false;
        $recaptcha  = isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;
        $USER = new Usuarios();
        /* if (!$recaptcha) {
            $response = array(
                'response' => 'error',
                'text' => 'No se completo el capcha'
            );
        } else */
        if ($correo) {
            // if ($USUARIO = [$USER->encontrar_usuario($correo)]) {


            if ($USUARIO = $USER->encontrar_usuario($correo)) {
                if ($USUARIO['intento_login'] > 3 && $USUARIO['ultimo_login'] == date("Y-m-d")) {
                    $response = array(
                        'response' => 'warning',
                        'text' => 'Excediste el número de intentos para iniciar sesión, espera al dia de mañana para volver a intentar o consulta a el administrador',
                    );
                } else if ($USUARIO['estado'] != 'activo') {
                    $response = array(
                        'response' => 'error',
                        'text' => 'Para ingresar es necesaria la activación de tu usuario'
                    );
                    // } elseif ($USUARIO['password'] == md5($password)) {

                } else if (md5($password) != $USUARIO['password']) {
                    $USER->intento_login = ((int)$USUARIO['intento_login'] + 1);
                    $USER->ultimo_login = date("Y-m-d");
                    if ($USUARIO['ultimo_login'] != date("Y-m-d")) {
                        $USER->intento_login = 1;
                    }

                    $USER->actualizar_usuario($USUARIO['id_usuario']);

                    $response = array(
                        'response' => 'error',
                        'text' => 'Correo o contraseña no son correctos'
                    );
                } elseif (md5($password) == $USUARIO['password']) {
                    $_SESSION[$CONFIG->sessionName()]['validarSesion']  = "ok";
                    $_SESSION[$CONFIG->sessionName()]['user_name']      = $USUARIO['nombre_usuario'];
                    $_SESSION[$CONFIG->sessionName()]['idUsuario']      = $USUARIO['id_usuario'];
                    // $_SESSION[$CONFIG->sessionName()]['correo']         = $USUARIO['correo'];
                    $_SESSION[$CONFIG->sessionName()]['nombre']         = $USUARIO['nombre'];
                    $_SESSION[$CONFIG->sessionName()]['apellidos']      = $USUARIO['apellidos'];
                    $_SESSION[$CONFIG->sessionName()]['cargo']          = $USUARIO['cargo'];
                    $_SESSION[$CONFIG->sessionName()]['fingreso']       = $USUARIO['fecha_registro'];
                    $USER->intento_login = 0;
                    $USER->ultimo_login = date("Y-m-d");
                    $USER->actualizar_usuario($USUARIO['id_usuario']);

                    $response = array(
                        'response' => 'exito',
                        'text' => 'Sesión creada de manera correcta',
                    );
                } else {
                    $response = array(
                        'response' => 'error',
                        'text' => 'Correo o contraseña no son correctos'
                    );
                }
            } else {
                $response = array(
                    'response' => 'error',
                    'text' => 'Usuario o contraseña incorrectos'
                );
            }
        } else {
            $response = array(
                'response' => 'error',
                'text' => 'Es necesario que completes todos los campos'
            );
        }
        die(json_encode($response));
        break;


    case 'recuperar_pass':
        $correo     = isset($_POST['correo'])     && !empty($_POST['correo'])       ? $_POST['correo'] : false;
        $reset_code = isset($_POST['codigo']) && !empty($_POST['codigo'])   ? $_POST['codigo'] : false;
        $password   = isset($_POST['password'])   && !empty($_POST['password'])     ? $_POST['password'] : false;
        $password_r = isset($_POST['password_r']) && !empty($_POST['password_r'])   ? $_POST['password_r'] : false;

        $captcha  = isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false;

        $USUARIOS = new Usuarios();

        if ($captcha) {
            $secret = $TEMPLATE->setCaptchaPrivate();
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
            $arr = json_decode($response, true);
            if ($arr['success']) {
                // echo '<h2>Thanks</h2>';
            } else {
                die(json_encode(array(
                    'response' => 'error',
                    'text' => 'No se capturo de forma correcta el captcha',
                )));
            }
        } else {
            die(json_encode(array(
                'response' => 'error',
                'text' => 'Debes de completar el capcha',
            )));
        }

        if ($correo) {
            if ($USUARIO = $USUARIOS->encontrar_usuario($correo)) {

                $recuperar = $USUARIOS->recuperar_password($USUARIO['id']);
                $fecha = $recuperar ? explode(" ", $recuperar['fecha'])[0] : "";
                if ($USUARIO['estado'] == 'activo') {
                    /**Envio de Código */
                    if ($correo && !$reset_code && !$password && !$password_r) {
                        if ($recuperar && ($fecha == date('Y-m-d') && $recuperar['intentos'] > 2)) {
                            $response = array('response' => 'error', 'text' => 'Superaste el número de intentos, vuelve a intentar mañana',);
                        } else {
                            $codigo = $ADMIN->generarCodigo(6);

                            if ($recuperar) {
                                $intentos = ($recuperar['intentos'] > 2 ? 1 : (int)$recuperar['intentos'] + 1);
                                if ($fecha == date('Y-m-d')) $codigo = $recuperar['codigo'];
                                $USUARIOS->restablecer_password_update($USUARIO['id'], $codigo, $intentos);
                            } else {
                                $USUARIOS->restablecer_password($USUARIO['id'], $codigo, 1);
                            }
                            /**Aquí va el envio de correo eléctronico */
                            $config = [
                                'nombre' => $USUARIO['nombre'] . ' ' . $USUARIO['apellidos'],
                                'correo' => $USUARIO['correo'],
                                'codigo' => $codigo,
                            ];
                            $usuarios_send[] = $USUARIOS->buscar_usuario($USUARIO['id']);

                            $EMAIL_TEMP = new Emailtemplate();
                            $email_send = $EMAIL_TEMP->reset_password($config);
                            // echo $email_send;
                            // exit;
                            $EMAIL =  new Email();
                            $send = $EMAIL->sendMail($usuarios_send, $email_send, 'Recuperación de contraseña');

                            $response = array(
                                'response' => 'exito',
                                'text' => 'El código ha sido enviado a tu correo eléctronico, revisa tu bandeja de entrada y continua con la verificación', $send
                            );
                        }
                        $response['paso'] = 1;
                    }
                    /**Verificación de código */
                    else if ($correo && $reset_code && !$password && !$password_r) {
                        if ($recuperar && (int)$recuperar['intento_restaurar'] > 5) {
                            $response = array('response' => 'error', 'text' => 'Excediste el número de intentos de validación de código, intenta de nuevo mañana');
                        } else if ($recuperar && $recuperar['codigo'] == $reset_code) {
                            $response = array('response' => 'exito', 'text' => 'El código es correcto',);
                        } else {
                            if ($recuperar)
                                $USUARIOS->restablecer_password_update($recuperar['id_usuario'], $recuperar['codigo'], $recuperar['intentos'], ((int)$recuperar['intento_restaurar'] + 1));
                            $response = array('response' => 'error', 'text' => 'El código no es correcto',);
                        }
                        $response['paso'] = 2;
                    }
                    /**Verificación de código y cambio de password */
                    else if ($correo && $reset_code && $password && $password_r) {
                        if ($recuperar && (int)$recuperar['intento_restaurar'] > 5) {
                            $response = array('response' => 'error', 'text' => 'Excediste el número de intentos de validación de código, intenta de nuevo mañana');
                        } else if ($recuperar && $recuperar['codigo'] == $reset_code) {
                            if (md5($password) != $USUARIO['password']) {
                                if ($password == $password_r) {
                                    $USUARIOS->id = $USUARIO['id'];
                                    $USUARIOS->password = md5($password);
                                    // if ($USUARIOS->actualizar_password(1)) {
                                    //     $USUARIOS->restablecer_password_update($recuperar['id_usuario'], $ADMIN->generarCodigo(10), $recuperar['intentos'], 6);
                                    //     $response = array('response' => 'exito', 'text' => 'Éxito, tu contraseña fue actualizada');
                                    // } else {
                                    //     $response = array('response' => 'error', 'text' => 'Tus contraseñas no coinciden');
                                    // }
                                } else {
                                    $response = array('response' => 'error', 'text' => 'Tus contraseñas no coinciden');
                                }
                            } else {
                                $response = array('response' => 'error', 'text' => 'Tu nueva contraseña no puede ser igual a la anterior');
                            }
                        } else {
                            if ($recuperar)
                                $USUARIOS->restablecer_password_update($recuperar['id_usuario'], $recuperar['codigo'], $recuperar['intentos'], ((int)$recuperar['intento_restaurar'] + 1));
                            $response = array('response' => 'error', 'text' => 'El código no es correcto',);
                        }
                        $response['paso'] = 3;
                    }
                    /**Excepción ya no hay mas opciones */
                    else {
                        $response = array('response' => 'error', 'text' => 'Es necesario que completes los campos',);
                        $response['paso'] = 3;
                    }
                } else {
                    $response = array('response' => 'error', 'text' => 'Tu cuenta no se encuentra activa, consulta con el administrador',);
                }
            } else {
                $response = array('response' => 'error', 'text' => 'El correo que intentas recuperar no esta registrado',);
            }
        } else {
            $response = array('response' => 'error', 'text' => 'Es necesario que completes todos los campos',);
        }
        die(json_encode($response));
        break;
    case 'cerrarSesion':
        if (session_destroy()) {
            $response = array(
                'response' => 'exito',
                'text' => 'Cerrando Sesión',
            );
        } else {
            $response = array(
                'response' => 'error',
                'text' => 'Intenta cerrar de nuevo o recarga la página',
            );
        }
        die(json_encode($response));
        break;
    default:
        break;
}
