<?php

use App\Libreria\Libreria;
use App\Models\Funciones;

$FUNC = new Funciones();

$cliente     = isset($_POST['cliente']) && !empty($_POST['cliente']) ? json_decode($_POST['cliente'], true) : false;
$datos       = isset($_POST['datos'])   && !empty($_POST['datos'])   ? json_decode($_POST['datos'], true) : false;
$descuento   = isset($_POST['descuento'])   && !empty($_POST['descuento'])   ? json_decode($_POST['descuento'], true) : 0;

/**
 * ------------------------------------------------------------------
 * -----------------------cuerpo de la nota ******-------------------
 * ------------------------------------------------------------------
 */
/**PDF */
$cliente = ($cliente ? $cliente : array(
    'razon_social' => '_________________________________________________________',

    'ciudad' => '_________________________________________________________',
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




$medidas = array(200, 600); // Ajustar aqui segun los milimetros necesarios;
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CODERALEEM SOFTWARE');
$pdf->SetTitle('TICKET DE VENTA ROPON DRAGAR');
$pdf->SetSubject('SAN MIGUEL EL ALTO');
$pdf->SetKeywords('TICKET VENTA, SAN MIGUEL EL ALTO, FACTURACIÓN ELÉCTRONICA');

// set default header data
$fecha = explode("-", $cliente['fecha']);
$fecha = $fecha[2] . " de " . $FUNC->meses((int)$fecha[1]) . " de " . $fecha[0];
// $pdf->SetHeaderData("", 120, );
$pdf->AddPage();

$pdf->writeHTMLCell(0, 60, 148, 5, ("TICKET  DE VENTA<br>ROPONDAGAR <br> VENTAS<br>" . $fecha), 0, 1, 0, true, '', true);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
// $pdf->Image('', 15, 140, 75, 113, 'JPG', $RUTA, '', true, 150, '', false, false, 1, false, false, false);
// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page

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
// // create some HTML content
$html = $CSS;

// $html .= '';


// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

/**
 * Tabla de datos @ JSON llega por post
 */
/**PDF */
// set JPEG quality


/**
 * ------------------------------------------------------------------
 * -----------------------CONFIGURACION DEL HEADER-------------------
 * ------------------------------------------------------------------
 */
$pdf->setJPEGQuality(75);

$pdf->Image(__DIR__ . '/logo.jpg', 0, 0, 70, 100, 'JPG', '', '', false, 300, '', false, false, 0, "M", false, false);
$html = <<<EOD
<p style="font-size:1em">Prolongación Macias #212, C.P. 47140<br>
Col. Sagrada Familia<br>
San Miguel el Alto, Jal.<br>
RFC: AOGA730511IC3<br>
<span>TEL:347 106 4585,
CEL:347 108 0422</span>
<p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 10, 72, 5, $html, 0, 1, 0, true, '', true);

$fila = '';
$total = 0;

$no_nota = '<table style="width:90px;border: 1px solid #000; padding:2px 0;"> <tr> <td style="width: 90px; text-align: center;">Nota de venta</td> </tr> <tr> <td style="text-align: center;"><b style="font-size: 1.4em; color:red;">' . $cliente['numero'] . '</b></td> </tr> </table>';
$pdf->writeHTMLCell(0, 0, 163, 27, $no_nota, 0, 1, 0, true, '', true);

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

$tbl = '<br><h1 style="text-align:center">Nota de venta Ropón Dagar</h1><br>
    <table cellspacing="0" cellpadding="1">
        <tr>
            <td style="width: 65px;"><h4>Nombre: </h4></td>
            <td style="width: 70%">' . $cliente['razon_social'] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 65px;"><h4>Dirección: </h4></td>
            <td>' . $cliente['direccion'] . '</td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 65px;"><h4>Ciudad: </h4></td>
            <td>' . $cliente['ciudad'] . '</td>
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
            <td style="width:7%;"><h4>Talla</h4></td>
            <td style="width:7%;"><h4>Tipo</h4></td>
            <td style="width:15%;"><h4>P.UNITARIO</h4></td>
            <td style="width:22%;"><h4>IMPORTE</h4></td>
        </tr>
        ' . $fila . '
        <tr>
            <td colspan="6" class="text-right"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>Sub Total:</td>
            <td> $ ' . number_format($descuento, 2) . '</td>
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
// <sup>IMPORTE TOTAL CON LETRA:</sup> Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque quod saepe nisi dolorem nostrum quaerat aspernatur deserunt.

$pdf->writeHTMLCell(200, 0, 10, 25, $tbl, 0, 1, 0, true, '', true);

/**
 * Tabla de datos @ JSON llega por post
 */

// reset pointer to the last page


// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 14);

// add a page
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

// test Cell stretching

// Set some content to print
$html = <<<EOD
<p style="text-align: justify; font-size:.75em"><b>Políticas de venta:</b> Una vez generado el encargo, el comprador deberá de pagar por lo menos de la mitad de la suma total del pedido en un plazo no mayor a una semana.
Política de ajustes: El comprador únicamente tiene 3 días después de generado el encargo para hacer cualquier cambio en el pedido, de lo contrario cualquier cambio no es aplicable para ningún tipo de descuento.</p>
<p style="text-align: justify; font-size:.75em"><b>Política de cobro:</b> Las notas liquidadas como "pronto pago (liquidación en los primeros 10 días)" aplicarán descuento para nuestros los compradores mayoristas, minoristas y menudeo, con sus respectivos porcentajes. Los pagos atrasados denegarán la aplicación de descuento para cualquier tipo de cliente</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, 0, true, 0);

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('ticket_venta.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
