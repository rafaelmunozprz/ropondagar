<?php

use App\Libreria\Libreria;
use App\Models\{Funciones, Nota_p, Materiaprima};


$NOTA = new Nota_p();
$MATERIA = new Materiaprima();
$FUNC = new Funciones();


$nota_proveedor = $NOTA->mostrar_nota($id_nota); //LEE LA NOTA

$nota_proveedor['productos'] = json_decode($nota_proveedor['productos'], true); //DECODIFICA LOS PRODUCTOS 

$productos = $nota_proveedor['productos']; // SE ASIGNA PARA VALIDAR
if ($productos) {
    /**BUSCA EL NOMBRE Y DATOS DE EL MATERIAL DE LA NOTA */
    foreach ($productos as $i_prod => $producto) {
        $productos[$i_prod]['data'] = $MATERIA->mostrar_materia($producto['id']); //AGREGA LA DATA
    }
}

$proveedor = $NOTA->mostrar_proveedor($nota_proveedor['id_proveedor']);





//Guarda todos los pagos de la nota ya llega formateados en array
if ($pagos = $NOTA->mostrar_pagos($id_nota)) {
    foreach ($pagos as $i_pago => $pago) {
        /**Datos de cada pago */
    }
}




/********************************** */ /********************************** */ /********************************** */
/********************************** */ /********************************** */ /********************************** */
$FUNC = new Funciones();

/**
 * ------------------------------------------------------------------
 * -----------------------cuerpo de la nota ******-------------------
 * ------------------------------------------------------------------
 */
/**PDF */

$LIB = new Libreria();

$LIB->TCPDF();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CODERALEEM SOFTWARE');
$pdf->SetTitle('NOTA  ROPON DRAGAR');
$pdf->SetSubject('SAN MIGUEL EL ALTO');
$pdf->SetKeywords('NOTA, SAN MIGUEL EL ALTO, FACTURACIÓN ELÉCTRONICA');


$fecha = explode(" ", $nota_proveedor['fecha']);
$fecha = explode("-", $fecha[0]);
$fecha = $fecha[2] . " de " . strtolower($FUNC->meses((int)$fecha[1])) . " de " . $fecha[0];
$pdf->SetHeaderData("", 120, "NOTA ", "ROPONDAGAR - VENTAS\n" . $fecha . "\n\n");
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
$pdf->SetFont('helvetica', '', 9);

// add a page
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
// // create some HTML content
$html = $CSS;

// $html .= '';


// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

/**
 * ------------------------------------------------------------------
 * -----------------------CONFIGURACION DEL HEADER-------------------
 * ------------------------------------------------------------------
 */
$pdf->setJPEGQuality(75);

// echo __DIR__;
// // var_dump(is_file(__DIR__ . '../../logo.jpg'));
// exit;
$pdf->Image(__DIR__ . '../../logo.jpg', 0, 0, 70, 100, 'JPG', '', '', false, 300, '', false, false, 0, "M", false, false);
$ropondagar = "<span><b>&nbsp;&nbsp;&nbsp;&nbsp; Ropón Dagar</b></span><br>";
$ropondagar .= "
        Prolongación Macias #212, C.P. 47140<br>
        Col. Sagrada Familia<br>
        San Miguel el Alto, Jal.<br>
        RFC: AOGA730511IC3<br>
        <span>TEL:347 106 4585,
        CEL:347 108 0422</span>
    ";
/**DATOS del proveedor */
$direccion = $proveedor['direccion'][0];

/***************DIRECCION */

$dir_body = "";
if ($direccion) {
    $dir_body  .= "<br><b>Dir.</b> " .   $direccion['ciudad'];
    $dir_body  .= ($direccion['estado'] != ''         ? ", " . $direccion['estado'] : "");
    $dir_body  .= ($direccion['cp'] != ''             ? ", CP. " . $direccion['cp'] : "");
    $dir_body  .= ($direccion['ciudad'] != ''         ? "<br>" . $direccion['direccion'] : "") . "";
    $dir_body  .= ($direccion['numero_externo'] != '' ? ", No. Ext. " . $direccion['numero_externo'] : "");
    $dir_body  .= ($direccion['numero_interno'] != '' ? ", No. Int. " . $direccion['numero_interno']  : "");
    $dir_body  .= ($direccion['colonia'] != ''        ? ", Col." . $direccion['colonia'] : "");
}
/***************DIRECCION */

$p_body   = "<span style=\"font-size:1em;\"><b>   &nbsp;&nbsp;&nbsp;&nbsp; Proveedor</b></span>";
$p_body  .= "<br><span style=\"font-size:1em\"><b>Razón social:</b> " . $proveedor['razon_social'] . "</span>";
$p_body  .= "<br><span style=\"font-size:1em\"><b>RFC:</b> " . $proveedor['rfc'] . "</span>";
$p_body  .= $dir_body;
$p_body  .= "<br><span style=\"font-size:1em\"><b>Correo:</b> " . $proveedor['correo'] . "</span>";
$p_body  .= "<br><span style=\"font-size:1em\"><b>Tel:</b> " . $proveedor['telefono'] . "</span>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 70, 15, 30, $ropondagar, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(99, 70, 90, 30, $p_body, 0, 1, 0, true, '', true);

$fila = '';
$total = 0;
$subtotal = 0;


$no_nota = '<span style="text-align: right; font-size: 1.3em;">Nota: <b style=" color:red;">' . $FUNC->rellenar_cero($nota_proveedor['id_nota_proveedor'], 6) . '</b></span>';
$t_fecha = '<span style="text-align: right;"><b>' . $fecha . '</b></span>';
$pdf->writeHTMLCell(45, 0, 145, 20, $no_nota, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(45, 0, 145, 15, $t_fecha, 0, 1, 0, true, '', true);

foreach ($productos as $i_prod => $producto) {
    // var_dump($producto);
    // echo "<br>";
    /**Datos de cada producto */

    $sub_total = ($producto['cantidad'] * $producto['precio_compra']);
    $total += $sub_total;
    $fila .= '
            <tr ' . (($i_prod % 2) ? 'style="background-color:#c3c3c3;"' : "") . '>
                <td style="text-align:center;">' . $producto['cantidad'] . '</td>
                <td>' . $producto['data']['nombre'] . '</td>
                <td> $ ' . number_format($producto['precio_compra'], 2) . '</td>
                <td style="text-align:right; "> $ ' . number_format($sub_total, 2) . '</td>
            </tr>';
}
// echo $fila;

// exit;
$tbl = '
    <table cellspacing="0" cellpadding="4">
        <tr class="fila_tabla" style="background-color:#727272; color:#fff">
            <td style="width:10%; text-align:center;"><h4>CANT.</h4></td>
            <td style="width:50%;"><h4>Nombre</h4></td>
            <td style="width:15%;"><h4>Precio</h4></td>
            <td style="width:15%; text-align:right;"><h4>Subtotal</h4></td>
        </tr>
        ' . $fila . '
        <tr> <td colspan="4" class="text-right"></td> </tr>
        <tr> <td colspan="4" class="text-right"></td> </tr>
        <tr>
            <td colspan="2"></td>
            <td>Sub Total:</td>
            <td style="text-align:right;"> $ ' . number_format($total, 2) . '</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td>Descuento:</td>
            <td style="text-align:right;"> $ ' . number_format($nota_proveedor['descuento'], 2) . '</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td>TOTAL:' . ('<br>' . ($nota_proveedor['iva'] == 'si' ? '<b> IVA + 16%</b>' : "")) . '</td>
            <td style="text-align:right;"> $ ' . number_format($nota_proveedor['total_costo'], 2) . '</td>
        </tr>
        <tr><td colspan="4"></td></tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">
                <b>' . ($nota_proveedor['estado'] == 'pagado' ? "La nota se ha pagado en su totalidad" : "Aún resta pagar $ " . (number_format(($nota_proveedor['total_costo'] - $nota_proveedor['total_pagado']), 2))) . '</b>
            </td>
        </tr>
    </table>';
// <sup>IMPORTE TOTAL CON LETRA:</sup> Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque quod saepe nisi dolorem nostrum quaerat aspernatur deserunt.

$pdf->writeHTMLCell(200, 0, 10, 65, $tbl, 0, 1, 0, true, '', true);

/**
 * Tabla de datos @ JSON llega por post
 */

// reset pointer to the last page


// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 11);

// add a page
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

// test Cell stretching

// Set some content to print
$html = <<<EOD
<p style="text-align: justify; font-size:.75em"><b>Políticas de venta:</b> Una vez generado el encargo, el comprador deberá de pagar por lo menos la mitad de la suma total del pedido en un plazo no mayor a una semana.
Política de ajustes: El comprador únicamente tiene 3 días después de generado el encargo para hacer cualquier cambio en el pedido, de lo contrario cualquier cambio no es aplicable para ningún tipo de descuento.</p>
<p style="text-align: justify; font-size:.75em"><b>Política de cobro:</b> Las notas liquidadas como "pronto pago (liquidación en los primeros 10 días)" aplicarán descuento para los compradores mayoristas, minoristas y menudeo, con sus respectivos porcentajes. Los pagos atrasados denegarán la aplicación de descuento para cualquier tipo de cliente</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(120, 0, 15, 243, $html, 0, 1, 0, true, '', true);

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('nota_no_.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
