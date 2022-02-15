<?php

namespace App\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use App\Config\Config;
use App\Models\Funciones;

include_once('PHPMailer/PHPMailer.php');
include_once('PHPMailer/Exception.php');
include_once('PHPMailer/SMTP.php');

class Email
{
    public $RUTA;
    private $SMTP_CONFIG;
    public $EMAIL_USER_CONTACT;

    function __construct()
    {
        $CONFIG = new Config();
        $this->RUTA = $CONFIG->RUTA();
        $this->CONEXION = $CONFIG->getConexion();
        $this->SMTP_CONFIG = array(
            'Host' => "mail.ropondagar.com",
            'PORT' => 465,
            'Username' => 'ventas@ropondagar.com',
            'Password' => 'Android2021.',
            'name' => utf8_decode('DISEÑOS DAGAR - VENTAS'),
            'mailTest' => 'prueba@ropondagar.com',

        );
        $this->EMAIL_USER_CONTACT = array(
            'name' => 'VENTAS',
            'lastname' => '',
            'email' => 'ventas@ropondagar.com',
            'Subject' => 'Ventas ropondagar.com',
            'message' => '',
        );
        $this->INDEX_MAIL = array(
            'name' => 'Ventas Ropon Dagar',
            'email' => 'ventas@ropondagar.com',
            'subject' => 'Llamar a nuevo usuario',
            'message' => ''
        );
    }
    function getMes()
    {
        $mes = date("m");
        $FUNC = new Funciones();
        return $FUNC->meses((int)$mes);
    }
    function sendMail($USUARIO = false, $bodyMessage = "empty")
    {
        $config = $this->SMTP_CONFIG;
        $USUARIO = ($USUARIO) ? $USUARIO : $this->EMAIL_USER_CONTACT;
        $mail = new PHPMailer();
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $config['Host'];
            $mail->Port = 465;
            $mail->Username = $config['Username'];
            $mail->Password = $config['Password'];
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = 0;
            $mail->SMTPSecure = 'ssl';
            $mail->CharSet = 'UTF-8';
            $mail->Debugoutput = 'html';
            $mail->IsHTML(true);
            $mail->SetFrom($config['Username'], $config['name']);
            $mail->Subject = $USUARIO['Subject'];
            $mail->msgHTML($bodyMessage);
            $mail->AddAddress($USUARIO['email'], $USUARIO['name'] . ' ' . $USUARIO['lastname']);
            $mail->AddAddress('ventas@ropondagar.com', utf8_decode('Ventas Ropones Dagar'));
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }
    function sendMailIndex($nombre_contacto, $correo_contacto, $telefono_contacto)
    {
        $mes = $this->getMes();
        $hoy = date("j, Y, g:i a");

        $mail = new PHPMailer(true);
        try {
            $nombre_contacto = utf8_decode($nombre_contacto);
            $correo_contacto = utf8_decode($correo_contacto);
            $telefono_contacto = utf8_decode($telefono_contacto);
            $signos = '¡No hay que hacerlo esperar, ' . $nombre_contacto . ' est&aacute; esperando nuestra respuesta!';
            $cuerpo_mensaje = '
            <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
                <tr>
                    <td align="center">
                        <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                            <tr>
                                <td align="center">
                                    <table border="0" width="400" cellpadding="0" cellspacing="0" class="container590">
                                        <tr>
                                            <td align="center" style="color: #888888; font-size: 16px; font-family: ´Work Sans´, Calibri, sans-serif; line-height: 24px;">
                                                <div style="line-height: 24px">
                                                    ' . $nombre_contacto . ' est&aacute; buscando asistencia, ll&aacute;malo<br><br>
                                                    Nos ha proporcionado un n&uacute;mero de tel&eacute;fono: <a href="tel:+52' . $telefono_contacto . '">' . $telefono_contacto . '</a><br>
                                                    Tambien nos brinda su correo electr&oacute;nico: <a href="mailto:' . $correo_contacto . '">' . $correo_contacto . '</a> <br>
                                                    ' . $signos . '
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';
            $mail->isSMTP();
            $mail->Host = 'mail.ropondagar.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ventas@ropondagar.com';
            $mail->Password = 'Android2021.';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('ventas@ropondagar.com', 'Ventas Ropones Dagar');
            $mail->addAddress('ventas@ropondagar.com', utf8_decode('Ventas Ropones Dagar'));
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Comuniquémonos con ' . utf8_encode($nombre_contacto) . ', solicita información, ' . $mes . ' ' . $hoy;
            $mail->Body = $cuerpo_mensaje;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    function sendMailContacto($nombre_contacto, $correo_contacto, $telefono_contacto, $asunto_contacto, $cuerpo_mensaje)
    {
        $mes = $this->getMes();
        $hoy = date("j, Y, g:i a");

        $mail = new PHPMailer(true);
        try {
            $nombre_contacto = utf8_decode($nombre_contacto);
            $correo_contacto = utf8_decode($correo_contacto);
            $telefono_contacto = utf8_decode($telefono_contacto);
            $signos = '¡No hay que hacerlo esperar, ' . $nombre_contacto . ' est&aacute; esperando nuestra respuesta!';
            $mensaje = '
            <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
                <tr>
                    <td align="center">
                        <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                            <tr>
                                <td align="center">
                                    <table border="0" width="400" cellpadding="0" cellspacing="0" class="container590">
                                        <tr>
                                            <td align="center" style="color: #888888; font-size: 16px; font-family: ´Work Sans´, Calibri, sans-serif; line-height: 24px;">
                                                <div style="line-height: 24px">
                                                ' . $nombre_contacto . ' est&aacute; buscando asistencia, ll&aacute;malo<br><br>
                                                Nos ha proporcionado un n&uacute;mero de tel&eacute;fono: <a href="tel:+52' . $telefono_contacto . '">' . $telefono_contacto . '</a><br>
                                                Tambien nos brinda su correo electr&oacute;nico: <a href="mailto:' . $correo_contacto . '">' . $correo_contacto . '</a> <br>
                                                    ' . $cuerpo_mensaje . ' <br>
                                                    ' . $signos . '
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';
            $mail->isSMTP();
            $mail->Host = 'mail.ropondagar.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ventas@ropondagar.com';
            $mail->Password = 'Android2021.';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('ventas@ropondagar.com', 'Ventas Ropones Dagar');
            $mail->addAddress('ventas@ropondagar.com', utf8_decode('Contacto Ropones Dagar'));
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Asunto: ' . utf8_encode($asunto_contacto) . ', ' . $mes . ' ' . $hoy;
            $mail->Body = $mensaje;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    function sendMailNota($cliente, $datos, $descuento)
    {
        $mes = $this->getMes();
        $hoy = date("j, Y, g:i a");
        $mail = new PHPMailer(true);
        $cuerpo_mensaje = '';
        try {
            $cliente = json_decode($cliente, true);
            $datos = json_decode($datos, true);
            $descuento = json_decode($descuento, true);
            $cuerpo_datos = "";
            $total = 0;
            $desc = $descuento['cantidad'];
            if ($datos) {
                foreach ($datos as $value) {
                    $subtotal = $value['precio'] * $value['cantidad'];
                    $total += $subtotal;
                    $cuerpo_datos .= '
                        <tr style="text-align: left; font-weight: bold; border-bottom: 1px solid #453e3d;">
                            <td style="padding: 12px 15px;">' . $value['cantidad'] . '</td>
                            <td style="padding: 12px 15px;">' . $value['modelo'] . '</td>
                            <td style="padding: 12px 15px;">' . $value['nombre'] . '</td>
                            <td style="padding: 12px 15px;">' . $value['color'] . ' / ' . $value['talla'] . '</td>
                            <td style="padding: 12px 15px;">$ ' . number_format($value['precio'], 2, '.', '') . '</td>
                            <td style="padding: 12px 15px;">$ ' . number_format($subtotal, 2, '.', '') . '</td>
                        </tr>';
                }
            }
            if ($descuento['tipo'] == "porcentaje") {
                if ($descuento['cantidad'] != '0') {
                    $des = ($descuento['cantidad'] * $total) / 100;
                } else {
                    $des = 0;
                }
                $subtotal = $total;
                $total = $total - $des;
            } else { //$descueto['tipo']==moneda
                $subtotal = $total;
                $total = $total - $descuento['cantidad'];
            }
            $mail->isSMTP();
            $mail->Host = 'mail.ropondagar.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ventas@ropondagar.com';
            $mail->Password = 'Android2021.';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('ventas@ropondagar.com', 'Ventas Ropones Dagar');
            $mail->addAddress('ventas@ropondagar.com', utf8_decode('Contacto Diseños Dagar'));
            if ($cliente['correo']) {
                $mail->addAddress($cliente['correo'], utf8_encode($cliente['razon_social']));
            }
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Asunto: Compra' . ' ' . $mes . ' ' . $hoy;
            $mail->Body = '
            <div style="text-align: center; align-items: center;">
                <img src="cid:logoDagar" alt="Logo Ropon Dagar" width="370px">
                <h1 style="color: #453e3d;">Diseños Dagar agradece su preferencia</h1>
                <table style="width: 100%; border-collapse: collapse; margin: 25px 0; font-size: 0.9em; min-width: 400px; border-radius: 5px 5px 0 0; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15); ">
                    <thead style="background-color: #edddb9; text-align: left; font-weight: bold;">
                        <th style="padding: 12px 15px;">Cantidad</th>
                        <th style="padding: 12px 15px;">Modelo</th>
                        <th style="padding: 12px 15px;">Artículo</th>
                        <th style="padding: 12px 15px;">Color / Talla</th>
                        <th style="padding: 12px 15px;">Precio</th>
                        <th style="padding: 12px 15px;">Subtotal</th>
                    </thead>
                    <tbody style="border-bottom: 1px solid #453e3d;">
                        ' . $cuerpo_datos . '
                    </tbody>
                </table>
                <h2 style="color: #453e3d; font-size: 1em;">Subtotal: <span>$ ' . number_format($subtotal, 2, '.', '') . '</span></h2>
                <h2 style="color: #453e3d; font-size: 1em;">Descuento: <span>- $ ' . number_format($desc, 2, '.', '') . '</span></h2>
                <h2 style="color: #453e3d; font-size: 1em;">Total:  <span>$ ' . number_format($total, 2, '.', '') . '</span></h2>
                <h2 style="color: #453e3d; font-size: 1em;">Este correo incluye una versión imprimible de su ticket ¡Consérvelo para cualquier aclaración!</h2>
                <h2 style="width: 100%; color: #453e3d; background-color: #edddb9;">Para cualquier duda o aclaración, visita nuestras redes sociales o llámanos</h2>
                <table style="width: 100%; border-collapse: collapse; margin: 25px 0; font-size: 0.9em; min-width: 400px; border-radius: 5px 5px 0 0; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15); text-align: center;" >
                    <tr >
                        <td>
                            <a href="https://www.facebook.com/Dise%C3%B1os-Dagar-1421061768128085"><img src="cid:facebook" alt="Facebook Diseños Dagar"></a>
                        </td>
                        <td>
                            <a href="https://m.me/1421061768128085"><img src="cid:messenger" alt="Messenger Diseños Dagar"></a>
                        </td>
                        <td>
                            <a href="https://wa.me/523471064585"><img src="cid:whatsapp" alt="WhatsApp Diseños Dagar"></a>
                        </td>
                        <td>
                            <a href="https://www.instagram.com"><img src="cid:instagram" alt="Instagram Diseños Dagar"></a>
                        </td>
                    </tr>
                </table>
            </div>';
            $mail->addEmbeddedImage('../public/galeria/mail/Logo.jpg', 'logoDagar');
            $mail->addEmbeddedImage('../public/galeria/mail/facebook.png', 'facebook');
            $mail->addEmbeddedImage('../public/galeria/mail/messenger.png', 'messenger');
            $mail->addEmbeddedImage('../public/galeria/mail/whatsapp.png', 'whatsapp');
            $mail->addEmbeddedImage('../public/galeria/mail/instagram.png', 'instagram');
            $mail->addAttachment('../public/documentos/zebra/ticket.zpl', 'ticket.zpl');
            $mail->addAttachment('../public/documentos/zebra/ticket.pdf', 'ticket.pdf');
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
