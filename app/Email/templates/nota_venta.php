<?php

namespace App\Email\Templates;

use App\Models\Funciones;

class TemplateNotaCliente
{
    static function template_nota($nota, $cliente, $pagos)
    {
        $FUNC = new Funciones();
        $p_body = '';
        $sub_total = 0;
        if ($productos = $nota['productos']) {
            foreach ($productos as $i_prod => $producto) {
                $sub_prod = (floatval($producto['cantidad']) * floatval($producto['precio_venta']));
                $sub_total += $sub_prod;
                $p_body .= '
                    <tr class="fila_tabla" style="padding:0; margin:0;">
                        <td style="width:10%; text-align:center;">  ' . $producto['cantidad'] . '</td>
                        <td style="width:50%;"                   >  ' . $producto['nombre'] . '</td>
                        <td style="width:15%;"                   >$ ' . number_format($producto['precio_venta'], 2) . '</td>
                        <td style="width:15%; text-align:right; ">$ ' . number_format($sub_prod, 2) . '</td>
                    </tr>
                ';
            }
        }
        $sub_desc = ($sub_total - $nota['descuento']);

        $b_pagos = '';
        $total_pagado = 0;

        if ($pagos) {
            foreach ($pagos as $i_pago => $pago) {
                $fecha = explode(" ", $pago['fecha_pago']);
                $fecha = explode("-", $fecha[0]);

                $total_pagado += floatval($pago['cantidad']);

                $b_pagos .= '
                    <tr class="fila_tabla" style="padding:0;margin:0;">
                        <td style="width:20%; text-align:center;">$ ' . number_format($pago['cantidad'], 2) . '</td>
                        <td style="width:20%; text-align:center;">' . (strtoupper($pago['tipo_pago'])) . '</td>
                        <td style="width:20%; text-align:center; padding:0 10px;">' . ($fecha[2] . " " . ($FUNC->meses((int)$fecha[1])) . " " . $fecha[0]) . '</td>
                    </tr>';
            }
        }

        $template = '
            <div style="min-width: 800px; max-width: 1200px; margin: 0 auto; padding: 15px; font-size:1.3rem; font-family: \'Courier New\', Courier, monospace; text-align:justify;">
                <div style="width:100%"> <img src="tanks.png" style="width:100%;" alt=""></div>
                <p class="MsoNormal"><b>HOLA QUE TAL ' . $cliente['razon_social'] . ' TE ENVIÓ LOS DATOS DE TU NOTA,
                    ANEXANDO LOS PAGOS EN RESUMEN, SI TIENES CUALQUIER DUDA O REQUIERES ACLARACIÓN
                    NO DUDES EN CONTACTARNOS</b></p>
                <h3>Nota:</h3>
                <table style="width:100%">
                    <tbody>
                        <tr>
                            <th style="padding-bottom:30px">
                                <address>
                                    <strong style="font-size: 1.35em; font-weight:700;">Ropón Dagar.</strong><br>
                                    Prolongación Macias #212, C.P. 47140<br>
                                    <b>Col. </b><span style="font-weight:300;">Sagrada Familia </span> <br>
                                    <b>RFC: </b><span style="font-weight:300;">AOGA730511IC3 </span> <br>
                                    <b>TEL: </b><a href="" style="text-decoration: none; color:blue; font-weight:300">347 106 4585 </a> <br>
                                    <b>CEL: </b><a href="" style="text-decoration: none; color:blue; font-weight:300">347 108 0422 </a>
                                </address>
                            </th>
                        </tr>
                    </tbody>
                </table>

                <table style="width:100%;margin-top: 90px;">
                    <tr class="fila_tabla" style="background-color:#727272; padding:0;margin:0; color:#fff">
                        <td style="width:10%; text-align:center;">
                            <h4 style="margin:0;">CANT.</h4>
                        </td>
                        <td style="width:50%;">
                            <h4 style="margin:0;">Nombre</h4>
                        </td>
                        <td style="width:15%;">
                            <h4 style="margin:0;">Precio</h4>
                        </td>
                        <td style="width:15%; text-align:right;">
                            <h4 style="margin:0;">Subtotal</h4>
                        </td>
                    </tr>
                    ' . $p_body . '
                </table>
                <table style="width:100%;margin-top: 90px;">
                    <tr class="fila_tabla" style="padding:0;margin:0;">
                        <td colspan="2">
                        <td style="width:20%; text-align:right;">
                            <h4 style="margin:0;">Subtotal</h4>
                        </td>
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;">$ ' . number_format($sub_total, 2) . ' </h4>
                        </td>
                    </tr>
                    <tr class="fila_tabla" style="padding:0;margin:0;">
                        <td colspan="2">
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;">Descuento</h4>
                        </td>
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;">$ ' . number_format($nota['descuento'], 2) . ' </h4>
                        </td>
                    </tr>
                    <tr class="fila_tabla" style="padding:0;margin:0;">
                        <td colspan="2">
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;">Total</h4>
                        </td>
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;">$ ' . number_format($sub_desc, 2) . ' </h4>
                        </td>
                    </tr>' . (($nota['iva'] == 'si') ? '
                    <tr class="fila_tabla" style="padding:0;margin:0;">
                        <td colspan="2"></td>
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;">Total + IVA</h4>
                        </td>
                        <td style="width:20%; text-align:right; padding:0 10px;">
                            <h4 style="margin:0;"> $ ' . number_format($nota['total_costo'], 2) . ' </h4>
                        </td>
                    </tr>' : '') . '
                </table>
                <div style="width:100%;">
                    <h3>Lista de pagos a la nota:</h3>
                </div>
                <table style="width:100%;">
                    <tr class="fila_tabla" style="background-color:#727272; padding:0;margin:0; color:#fff;">
                        <td style="width:20%; text-align:center;">
                            <h4 style="margin:0;">Cantidad</h4>
                        </td>
                        <td style="width:20%; text-align:center;">
                            <h4 style="margin:0;">Tipo</h4>
                        </td>
                        <td style="width:20%; text-align:center; padding:5px 10px;">
                            <h4 style="margin:0;"> Fecha </h4>
                        </td>
                    </tr>
                    ' . $b_pagos . '
                    <tr class="fila_tabla" style="padding:0;margin:0; background: #000; color: #fff;">
                        <td colspan="3" style="width:20%; text-align:center; font-weight:bold; ">Total pagado: $ ' . number_format($total_pagado, 2) . '</td>
                    </tr>
                </table>
            </div>
        ';

        return $template;
    }
}
