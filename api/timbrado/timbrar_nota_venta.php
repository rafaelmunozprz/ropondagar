<?php

use App\Facturacion\Facturacion;
use App\Models\{ClienteNota, Materiaprima, Modelos, Notificacion};


header('Content-type:application/json;charset=utf-8');

/**
 * @folio viene en la URI $DIRECTORIO[3]
 * $folio = $folio
 */
$NT_C = new ClienteNota();
$CFDI = new Facturacion();

$NT_C->uuid = $folio;
$nota_cliente = $NT_C->mostrar_notas();
if (!$nota_cliente || strlen($folio) < 12) {
    $respuesta = ['status' => false, 'response' => 'error', 'text' => "Error al consultar la nota creada el folio $folio es incorrecto"];
    die(json_encode($respuesta));
}
$nota_cliente = $nota_cliente->fetch_assoc();

if ($nota = $CFDI->mostrar_factura($folio)) {

    $respuesta = ['status' => false, 'response' => 'error', 'text' => "Esta nota ya fue facturada"];
    die(json_encode($respuesta));
}

if ($nota_cliente['estado'] != 'pagado') {
    $respuesta = ['status' => false, 'response' => 'error', 'text' => "Para poder facturar la nota tiene que estar completamente pagada"];
    die(json_encode($respuesta));
}

if ($nota_cliente['descuento'] > 0) {
    $respuesta = ['status' => false, 'response' => 'error', 'text' => "No puedes facturar notas con descuentos"];
    die(json_encode($respuesta));
}






// ███╗░░░███╗░█████╗░██████╗░██╗░░░██╗██╗░░░░░░█████╗░  ██████╗░███████╗  ███████╗░█████╗░░█████╗░████████╗██╗░░░██╗██████╗░░█████╗░░██████╗
// ████╗░████║██╔══██╗██╔══██╗██║░░░██║██║░░░░░██╔══██╗  ██╔══██╗██╔════╝  ██╔════╝██╔══██╗██╔══██╗╚══██╔══╝██║░░░██║██╔══██╗██╔══██╗██╔════╝
// ██╔████╔██║██║░░██║██║░░██║██║░░░██║██║░░░░░██║░░██║  ██║░░██║█████╗░░  █████╗░░███████║██║░░╚═╝░░░██║░░░██║░░░██║██████╔╝███████║╚█████╗░
// ██║╚██╔╝██║██║░░██║██║░░██║██║░░░██║██║░░░░░██║░░██║  ██║░░██║██╔══╝░░  ██╔══╝░░██╔══██║██║░░██╗░░░██║░░░██║░░░██║██╔══██╗██╔══██║░╚═══██╗
// ██║░╚═╝░██║╚█████╔╝██████╔╝╚██████╔╝███████╗╚█████╔╝  ██████╔╝███████╗  ██║░░░░░██║░░██║╚█████╔╝░░░██║░░░╚██████╔╝██║░░██║██║░░██║██████╔╝
// ╚═╝░░░░░╚═╝░╚════╝░╚═════╝░░╚═════╝░╚══════╝░╚════╝░  ╚═════╝░╚══════╝  ╚═╝░░░░░╚═╝░░╚═╝░╚════╝░░░░╚═╝░░░░╚═════╝░╚═╝░░╚═╝╚═╝░░╚═╝╚═════╝░




// $nota_cliente = $nota_cliente->fetch_assoc();

$datos_fiscales = isset($_POST['datos_fiscales']) && !empty($_POST['datos_fiscales']) ? json_decode($_POST['datos_fiscales'], true) : false;

$productos = ($nota_cliente['productos']             = json_decode($nota_cliente['productos'], JSON_UNESCAPED_UNICODE));
$cliente   = ($nota_cliente['datos_cliente_general'] = json_decode($nota_cliente['datos_cliente_general'], JSON_UNESCAPED_UNICODE));
// $nota_cliente['stock_historico']                  = json_decode($nota_cliente['stock_historico'], JSON_UNESCAPED_UNICODE);// No es necesario aquí

$cliente['direccion'] = $cliente['direccion'][0];

// echo json_encode($cliente);

$folio_cfdi = (empty($_SESSION['folio']) ? ($_SESSION['folio'] = 9917) : $_SESSION['folio']++);




/** CONFIG TIMBRADO */
$config_cfdi = $CFDI->getConfig();
$fecha = (date("Y-m-d", strtotime("-2 days")) . "T" . date("H:m:s"));

/**Desglose de productos */

$desglose_factura = "";

$sub_total = 0;
$MODEL = new Modelos();
$PRIMA = new Materiaprima();
$fiscales = true;
foreach ($productos as $i_prod => $producto) {

    $prod_data = $producto['tipo'] == 'modelo' ? $MODEL->mostrar_modelo($producto['id']) : $PRIMA->mostrar_materia($producto['id']);


    /**
     * En esta parte se completa el codigo fiscal
     */
    $producto['codigo_fiscal'] = $prod_data['codigo_fiscal'];
    if ($datos_fiscales) {
        foreach ($datos_fiscales as $i_prod => $fis_prod) {
            /** $fis_prod = data de los productos fiscales [id,tipo,codigo_fiscal] */
            if (($fis_prod['tipo'] == $producto['tipo']) && ($fis_prod['id'] == $producto['id']) && ($fis_prod['codigo_fiscal'] != $producto['codigo_fiscal'])) {
                $producto['codigo_fiscal'] = $fis_prod['codigo_fiscal'];
            }
        }
    }
    /** */
    if ($producto['codigo_fiscal'] == '') {
        $fiscales = false;
        break;
    }


    $costo_total = ($producto['cantidad'] * $producto['precio_venta']);
    $total_iva   = round(($costo_total * .16), 4);
    $total_costo_iva   = ($costo_total + $total_iva);

    $sub_total += $costo_total;

    $desglose_factura .= ($desglose_factura == '' ? "" : "|"); //Separa los varios productos segun su api
    $desglose_factura .= "CodigoArticulo:"    . ("00012")                   . ";";
    $desglose_factura .= "FolioDocumento:"    . ("G223")                    . ";";
    $desglose_factura .= "Cantidad:"          . ($producto['cantidad'])     . ";";
    $desglose_factura .= "ClaveProdServ:"     . ("01010101")                . ";";
    $desglose_factura .= "ClaveUnidad:"       . ("H87")                     . ";";
    $desglose_factura .= "NoIndentificacion:" . ("00012")                   . ";";
    $desglose_factura .= "Descripcion:"       . ($producto['nombre'])       . ";";
    $desglose_factura .= "ValorUnitario:"     . ($producto['precio_venta']) . ";";
    $desglose_factura .= "Descuento:"         . ("0")                       . ";";
    $desglose_factura .= "Ieps:"              . ("")                        . ";";
    $desglose_factura .= "Iva:"               . ("IVA16")                   . ";";
    $desglose_factura .= "SubImporte:"        . ($costo_total)              . ";";
    $desglose_factura .= "Importe:"           . ($costo_total)              . ";";
    $desglose_factura .= "IepsTotal:"         . ("0")                       . ";";
    $desglose_factura .= "IvaTotal:"          . ($total_iva)                . ";";
    $desglose_factura .= "Total:"             . ($total_costo_iva)          . ";";
}

if (!$fiscales) {
    $respuesta = ['status' => false, 'response' => 'error', 'text' => "Ocurrio un error con uno de los folios fiscales"];
    die(json_encode($respuesta));
}

// echo "\n";
// echo $nota_cliente['total_costo'];
// echo "\n";
// @subtotal = °
$total_iva = round(($sub_total * .16), 4);
$total_costo_iva = $sub_total + $total_iva;

$totales = [
    'subtotal' => $sub_total,
    'iva' => $total_iva,
    'total' => $total_costo_iva,
];


/**DATOS NOTA */
$documento_factura = "";
$documento_factura .= "Serie:"                 . ("A")            . ";";
$documento_factura .= "Folio:"                 . ($folio_cfdi)    . ";";
$documento_factura .= "Estado:"                . ("Prueba")       . ";";
$documento_factura .= "TipoDeComprobante:"     . ("I")            . ";";
$documento_factura .= "FechaDocumento:"        . ($fecha)         . ";";
$documento_factura .= "FormaDePago:"           . ("01")           . ";";
$documento_factura .= "MetodoDePago:"          . ("PUE")          . ";";
$documento_factura .= "TipoDescuento:"         . ("Porcentaje")   . ";";
$documento_factura .= "TipoCambio:"            . ("1")            . ";";
$documento_factura .= "CodigoMoneda:"          . ("MXN")          . ";";
$documento_factura .= "PrecioPreferente:"      . ("Precio1")      . ";";
$documento_factura .= "CodigoReceptor:"        . ("0001")         . ";";
$documento_factura .= "RfcReceptor:"           . ('XAXX010101000') . ";"; //cambiar por $cliente['rfc']
$documento_factura .= "CorreoEnvio:"           . ($config_cfdi['correo'])      . ";"; //CorreoEnvio"CorreoEnvio:" . $config_cfdi['correo'] . ";";
$documento_factura .= "NombreEmpresaReceptor:" . ($cliente['razon_social'])    . ";";
$documento_factura .= "RazonSocialReceptor:"   . ($cliente['razon_social'])    . ";";
$documento_factura .= "CalleReceptor:"         . ($cliente['direccion']['direccion'])         . ";";
$documento_factura .= "NoExteriorReceptor:"    . ($cliente['direccion']['numero_externo'])    . ";";
$documento_factura .= "NoInteriorReceptor:"    . ($cliente['direccion']['numero_interno'])    . ";";
$documento_factura .= "ColoniaReceptor:"       . ($cliente['direccion']['colonia']) . ";";
$documento_factura .= "LocalidadReceptor:"     . ($cliente['direccion']['colonia']) . ";";
$documento_factura .= "MunicipioReceptor:"     . ($cliente['direccion']['ciudad'])  . ";";
$documento_factura .= "EstadoReceptor:"        . ($cliente['direccion']['estado'])  . ";";
$documento_factura .= "PaisReceptor:"          . ("México")                         . ";";
$documento_factura .= "CodigoPostalReceptor:"  . ($cliente['direccion']['cp'])      . ";";
$documento_factura .= "TelefonoReceptor:"      . ($cliente['telefono'])             . ";";
$documento_factura .= "UsoCFDI:"               . ("P01")                            . ";";
$documento_factura .= "SubImporte:"            . ($sub_total)                       . ";";
$documento_factura .= "Importe:"               . ($sub_total)                       . ";";
$documento_factura .= "DescuentoIndividual:"   . ("0")                              . ";";
$documento_factura .= "ImpuestosRetenidos:"    . ("0")                              . ";";
$documento_factura .= "ImpuestosTrasladados:"  . ($total_iva)                       . ";";
$documento_factura .= "Total:"                 . ($total_costo_iva)                 . ";";
$documento_factura .= "Sucursal:"              . ("MATRIZ")                         . ";";

// echo $documento_factura;

// exit;


/**CREACIÓN DE NOTIFICACIONES */

$NTF = new Notificacion();
$opciones_ntf = $NTF->config;


/**FIN CREACIÓN DE NOTIFICACIONES */


try {


    $varUsuario       = $config_cfdi['usuario'];
    $varContrasena    = $config_cfdi['password'];
    $varCodigoEmpresa = $config_cfdi['codigo_empresa'];

    $options        = $config_cfdi['options'];
    $urlTimbrado    = $config_cfdi['link_timbrado'];
    /** CONFIG TIMBRADO */

    // $timbrado = new SoapClient($urlTimbrado, $options);
    // $timbrarDatos = array('Usuario' => $varUsuario, 'Contrasena' => $varContrasena, 'DocumentoFactura' => $documento_factura, 'DesgloseFactura' => $desglose_factura, 'CodigoEmpresa' => $varCodigoEmpresa);
    // $result = $timbrado->generacfdi($timbrarDatos)->generacfdiResult;

    // $zip_file = file_get_contents('compress.zlib://data://text/plain,' . urlencode($result)); //Guardamos la respuesta
    // $dir_zip = "documentos/cfdi/" . $folio . ".zip";
    // file_put_contents($dir_zip, $zip_file);
    $response  = $CFDI->extract_zip_cfdi($folio, '../public/');




    if ($response['status']) {
        $response['data']['zip'] = "documentos/cfdi/$folio.zip";
        $respuesta = [
            'status' => true,
            'response' => 'success',
            'text' => 'La nota fue timbrada de forma exitosa',
            'data' => [
                'id_factura' => $nota_cliente['id_nota_cliente'],
                'folio' => $folio,
                'documentos' => $response['data'],
                'factura' => [
                    'documento_factura' => $documento_factura,
                    'desglose_factura'  => $desglose_factura,
                    'fisco'  => $datos_fiscales,
                ],
                'totales' => $totales,
                'folio' => $folio_cfdi,
                'serie' => "A",
            ],
        ];

        /** NOTIFICACION */
        $config = [
            'bg_color' => $opciones_ntf['bg_color']['success'],
            'color' => $opciones_ntf['color']['success'],
            'icon' => $opciones_ntf['icons']['factura_lite'],
            'link' => 'sistema/ventas/facturacion/' . $folio
        ];
        $config = json_encode($config, JSON_UNESCAPED_UNICODE);
        $NTF->crear_notificacion(1, "FACTURA", "Creación de factura con folio " . $folio, "success", $config);
        /** NOTIFICACION */

        Facturacion::save_factura($nota_cliente['id_nota_cliente'], $folio, json_encode($response['data'], JSON_UNESCAPED_UNICODE), json_encode($respuesta['data'], JSON_UNESCAPED_UNICODE), 'activa');
    } else {
        $respuesta = [
            'status' => false,
            'response' => 'error',
            'text' => 'No es posible extraer el archivo: ' . $folio . ".zip",
        ];
        /** NOTIFICACION */
        $config = [
            'bg_color' => $opciones_ntf['bg_color']['danger'],
            'color' => $opciones_ntf['color']['danger'],
            'icon' => $opciones_ntf['icons']['factura'],
            'link' => 'sistema/ventas/facturacion/' . $folio
        ];
        $config = json_encode($config, JSON_UNESCAPED_UNICODE);
        $NTF->crear_notificacion(1, "FACTURA", "Error al obtener la factura con folio " . $folio, "error", $config);
        /** NOTIFICACION */
    }

    /** */
} catch (SoapFault $e) {
    // echo "\n FOLIO:" . $folio_cfdi . "\n";

    $respuesta = [
        'status' => false,
        'response' => 'error',
        'text' => 'No es posible facturar el folio: ' . $folio_cfdi,
        'error' => $e->faultstring
    ];

    /** NOTIFICACION */
    $config = [
        'bg_color' => $opciones_ntf['bg_color']['danger'],
        'color' => $opciones_ntf['color']['danger'],
        'icon' => $opciones_ntf['icons']['factura'],
        'link' => 'sistema/ventas/facturacion/' . $folio
    ];
    $config = json_encode($config, JSON_UNESCAPED_UNICODE);
    $NTF->crear_notificacion(1, "FACTURA", "Error al timbrar la factura con folio " . $folio, "error", $config);
    /** NOTIFICACION */
}


die(json_encode($respuesta));
