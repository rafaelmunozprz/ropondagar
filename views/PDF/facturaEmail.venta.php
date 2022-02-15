<?php

use App\Libreria\Libreria;
use App\Models\Funciones;
use App\Config\Config;

$FUNC = new Funciones();

$cliente     = isset($_POST['cliente']) && !empty($_POST['cliente']) ? json_decode($_POST['cliente'], true) : false;
$datos       = isset($_POST['datos'])   && !empty($_POST['datos'])   ? json_decode($_POST['datos'], true) : false;
$descuento   = isset($_POST['descuento'])   && !empty($_POST['descuento'])   ? json_decode($_POST['descuento'], true) : 0;
$cliente = ($cliente ? $cliente : array(
    'razon_social' => '____________________________________________________________________',
    "direccion" => array(
        0 => [
            "direccion" => "Sin dirección",
            "numero_externo" => '',
            "numero_interno" => "N/A",
            "colonia" => "",
            "ciudad" => "Sin ciudad",
            "estado" => ""
        ]
    ),
    'ciudad' => '____________________________________________________________________',
    'fecha' => date('Y-m-d'),
    'numero' => '1',
));
$productos = ($datos ? $datos : array(
    array(
        'cantidad' => 'NO',
        'modelo' => 'NO',
        'color' => 'NO',
        'talla' => 'NO',
        'tipo' => 'NO',
        'precio' => '0',
    )
));


$LIB = new Libreria();
$LIB->TCPDF();
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CODERALEEM SOFTWARE');
$pdf->SetTitle('NOTA DE VENTA ROPON DRAGAR');
$pdf->SetSubject('SAN MIGUEL EL ALTO');
$pdf->SetKeywords('NOTA VENTA, SAN MIGUEL EL ALTO, FACTURACIÓN ELÉCTRONICA');
$fecha = explode("-", $cliente['fecha']);
$fecha = $fecha[2] . " de " . $FUNC->meses((int)$fecha[1]) . " de " . $fecha[0];
$pdf->SetHeaderData("", 120, "NOTA DE VENTA", "ROPONDAGAR - VENTAS\n" . $fecha . "\n\n");
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

$CSS = '
    <style>
        h1{
            border-radius: 15px;
        }
        .text-danger{
            color:red;
        }
        .fila_tabla{
            text-align: right;
            padding-bottom: 1px solid #000;          
        }
        .fila_cliente{
            width:60px
        }
    </style>
';
$html = $CSS;
$pdf->writeHTML($html, true, 0, true, 0);

$pdf->setJPEGQuality(75);

$pdf->Image(__DIR__ . '/logo.jpg', 0, 0, 70, 100, 'JPG', '', '', false, 300, '', false, false, 0, "M", false, false);
$html = <<<EOD
<p style="font-size:1.2em">Prolongación Macias #212, C.P. 47140<br>
Col. Sagrada Familia<br>
San Miguel el Alto, Jal.<br>
RFC: AOGA730511IC3<br>
<span>TEL:347 106 4585,
CEL:347 108 0422</span>
<p>
EOD;
$pdf->writeHTMLCell(0, 10, 72, 5, $html, 0, 1, 0, true, '', true);

$fila = '';
$total = 0;

$no_nota = '<table style="width:80px;border: 1px solid #000; padding:2px 0;"> <tr> <td style="width: 90px; text-align: center;">Nota de venta</td> </tr> <tr> <td style="text-align: center;"><b style="font-size: 1.4em; color:red;">' . $cliente['numero'] . '</b></td> </tr> </table>';
$pdf->writeHTMLCell(0, 0, 163, 24, $no_nota, 0, 1, 0, true, '', true);

foreach ($productos as $i => $producto) {
    $sub_total = floatval($producto['cantidad']) * floatval($producto['precio']);
    $total += $sub_total;
    $fila .= '
        <tr>
            <td>' . $producto['cantidad'] . '</td>
            <td>' . $producto['nombre'] . '</td>
            <td>' . $producto['color'] . '</td>
            <td>' . $producto['talla'] . '</td>
            <td>' . $producto['tipo'] . '</td>
            <td> $ ' . number_format($producto['precio'], 2) . '</td>
            <td> $ ' . number_format($sub_total, 2) . '</td>
        </tr>';
}
$direccion = $cliente['direccion'] ? $cliente['direccion'][0] : false;

if ($descuento && $descuento['tipo'] == 'moneda') $descuento = floatval($descuento['cantidad']);
else if ($descuento && $descuento['tipo'] == 'porcentaje') $descuento = ($total * ((floatval($descuento['cantidad']) / 100)));
else $descuento = 0;

$sub_total = $total;
$total = $total - $descuento;


$tbl = '<br><h1 style="text-align:center">Nota de venta Ropón Dagar</h1><br>
    <table cellspacing="0" cellpadding="1">
        <tr>
            <td style="width: 55px;"><h4>Nombre: </h4></td>
            <td style="width: 65%;">' . $cliente['razon_social'] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 55px;"><h4>Dirección: </h4></td>
            <td>' . ($direccion ? $direccion['direccion'] : "") . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 55px;"><h4>Ciudad: </h4></td>
            <td>' . ($direccion ? $direccion['ciudad'] : "") . '</td>
            <td></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table cellspacing="0" cellpadding="4">
        <tr class="fila_tabla">
            <td style="width:10%;"><h4>CANT.</h4></td>
            <td style="width:21%;"><h4>Código.</h4></td>
            <td style="width:15%;"><h4>Color</h4></td>
            <td style="width:10%;"><h4>Talla</h4></td>
            <td style="width:10%;"><h4>Tipo</h4></td>
            <td style="width:15%;"><h4>P.UNITARIO</h4></td>
            <td style="width:19%;"><h4>IMPORTE</h4></td>
        </tr>
        ' . $fila . '
        <tr>
            <td colspan="6" class="text-right"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>Sub Total:</td>
            <td> $ ' . number_format($sub_total, 2) . '</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>Descuento:</td>
            <td> $ ' . number_format($descuento, 2) . '</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>TOTAL:</td>
            <td> $ ' . number_format($total, 2) . '</td>
        </tr>
    </table>';

$pdf->writeHTMLCell(200, 0, 10, 25, $tbl, 0, 1, 0, true, '', true);
$pdf->SetFont('times', '', 11);
$html = <<<EOD
<p style="text-align: justify; font-size:.75em"><b>Políticas de venta:</b> Una vez generado el encargo, el comprador deberá de pagar por lo menos de la mitad de la suma total del pedido en un plazo no mayor a una semana.
Política de ajustes: El comprador únicamente tiene 3 días después de generado el encargo para hacer cualquier cambio en el pedido, de lo contrario cualquier cambio no es aplicable para ningún tipo de descuento.</p>
<p style="text-align: justify; font-size:.75em"><b>Política de cobro:</b> Las notas liquidadas como "pronto pago (liquidación en los primeros 10 días)" aplicarán descuento para nuestros los compradores mayoristas, minoristas y menudeo, con sus respectivos porcentajes. Los pagos atrasados denegarán la aplicación de descuento para cualquier tipo de cliente</p>
EOD;
$pdf->writeHTMLCell(120, 0, 15, 243, $html, 0, 1, 0, true, '', true);

$pdf->lastPage();

$dir = __DIR__;
if ($dir == '/home1/ropondag/public_html/views/PDF')
    $dirArray = explode("/", $dir);
else $dirArray = explode("\\", $dir);
$newDir = '';
foreach ($dirArray as $option) {
    if ($option == 'views') {
        break;
    } else {
        $newDir .= $option . '/';
    }
}
$dir = '../public/';
$documento = 'documentos/zebra/ticket.pdf';
$pdf->Output($newDir . 'public/documentos/zebra/ticket.pdf', 'F');
$respuesta = [
    'response' => 'success',
    'text' => 'PDF Creado',
    'data' => ["link" => ($RUTA . $documento)],
];
die(json_encode($respuesta));
