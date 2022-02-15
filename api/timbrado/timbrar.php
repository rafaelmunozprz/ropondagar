<?php
if (!empty($_POST["txtUsuario"])) {
    $options = array('trace' => 1, 'exceptions' => true, "connection_timeout" => 580);
    $urlTimbrado = 'http://g17.opravymx.com/ws/cfdi/opravycfdi.asmx?WSDL';
    // http: //g17.opravymx.com/ws/cfdi/opravycfdi.asmx?WSDL
    $varUsuario = "pruebag17";
    $varContrasena = '123456';
    $varCodigoEmpresa = 'E0001';
    $folio = (isset($_POST['folio']) && !empty($_POST['folio']) ? $_POST['folio'] : 9917);
    $folio = (isset($_GET['folio']) && !empty($_GET['folio']) ? $_GET['folio'] : $folio);
    $varDocumentoFactura = "Serie:A;Folio:$folio;Estado:Prueba;TipoDeComprobante:I;FechaDocumento:2021-01-04T04:05:30;FormaDePago:01;MetodoDePago:PUE;TipoDescuento:Porcentaje;TipoCambio:1;CodigoMoneda:MXN;PrecioPreferente:Precio1;CorreoEnvio:prueba@prueba.com;CodigoReceptor:0001;NombreEmpresaReceptor:Empresa de Prueba;RfcReceptor:XAXX010101000;RazonSocialReceptor:Empresa de Prueba SA;CalleReceptor:Benito Juarez;NoExteriorReceptor:123;NoInteriorReceptor:A;ColoniaReceptor:Centro:LocalidadReceptor:08;MunicipioReceptor:093;EstadoReceptor:JAL;PaisReceptor:MEX;CodigoPostalReceptor:47600;TelefonoReceptor:01-800-123-45789;UsoCFDI:P01;SubImporte:100;Importe:100;DescuentoIndividual:0;ImpuestosRetenidos:0;ImpuestosTrasladados:16;Total:116;Sucursal:MATRIZ";
    $varDesgloseFactura = "CodigoArticulo:00012;FolioDocumento:G223;Cantidad:1;ClaveProdServ:01010101;ClaveUnidad:H87;NoIndentificacion:00012;Descripcion:Articulo de prueba;ValorUnitario:100;Descuento:0;Ieps:;Iva:IVA16;SubImporte:100;Importe:100;IepsTotal:0;IvaTotal:16;Total:116";

    try {
        $timbrado = new SoapClient($urlTimbrado, $options);
        $timbrarDatos = array('Usuario' => $varUsuario, 'Contrasena' => $varContrasena, 'DocumentoFactura' => $varDocumentoFactura, 'DesgloseFactura' => $varDesgloseFactura, 'CodigoEmpresa' => $varCodigoEmpresa);
        $result = $timbrado->generacfdi($timbrarDatos)->generacfdiResult;
        $zip_file = file_get_contents('compress.zlib://data://text/plain,' . urlencode($result)); //Guardamos la respuesta
        $dir_zip = "documentos/cfdi/cfdi_" . time() . ".zip";
        file_put_contents($dir_zip, $zip_file);

        // Creamos un instancia de la clase ZipArchive
        $zip = new ZipArchive();
        //Creo un directorio para almacenar el archivo
        $dir_ext = "documentos/cfdi_ext/";

        // Creamos y abrimos un archivo zip temporal
        var_dump($zip->open($zip_file));
        // $zip->open($dir_zip, ZipArchive::CREATE);
        // Añadimos un directorio
        //Añadimos un archivo dentro del directorio que hemos creado
        $zip->addFile($xml);
        // Una vez añadido los archivos deseados cerramos el zip.
        $zip->extractTo($dir_ext);
        $zip->close();
        // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
        // header("Content-type: application/octet-stream");
        // header("Content-disposition: attachment; filename=cfdi.zip");
        // leemos el archivo creado
        // readfile($dir_zip);
        // Por último eliminamos el archivo temporal creado
        // unlink($dir_zip); //Destruye el archivo temporal
        // var_dump($xml);
    } catch (SoapFault $e) {
        echo $e->faultstring;
    }
} else {
    echo "Ningun campo debe estar vacio";
}
