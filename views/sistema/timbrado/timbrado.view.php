<!-- <form action="<?php

                    use App\Libreria\Libreria;
                    use PHPMailer\PHPMailer\PHPMailer;

                    echo $RUTA; ?>back/timbrado" method="post">
    Servidor (g17.opravymx.com / g17pro.opravymexico.com):<br><br>
    <input type="text" name="txtServidor" value="g17.opravymx.com" /><br><br>
    <input type="text" name="folio" style="width:500px;" placeholder="FOLIO" /><br><br>
    Usuario:<br>
    <input type="text" name="txtUsuario" value="pruebag17" /><br>
    Contrasena:<br>
    <input type="password" name="txtContrasena" value="123456" /><br>
    CodigoEmpresa:<br>
    <input type="text" name="txtCodigoEmpresa" value="E0001" /><br><br>
    Datos CFDI:<br>
    <input type="text" name="txtDocumentoFactura" style="width:500px;" /><br>
    Conceptos:<br>
    <input type="text" name="txtDesgloseFactura" style="width:500px;" /><br><br>

    <input type="submit" name="btnTimbrar" value="Timbrar" />
</form> -->
<!-- <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="zip" id="">
    <button type="submit">Enviar</button>
</form> -->

<?php
try {
    $dir = "../public/"; //Raiz publica
    $file_zip = "documentos/cfdi/"; //Archivos comprimidos
    $file_unzip = "documentos/cfdi_unzip/"; //Archivos descomprimidos
    $new_folder = date("d-m-Y") . '/';
    $dir_zip = "../public/documentos/cfdi/cfdi_1609819708.zip"; // ubicación y nombre del ZIP
    $dir_ext = "../public/documentos/cfdi_ext/";
    $archivo = isset($_FILES['zip']) && !empty($_FILES['zip']) ? ($_FILES['zip']) : false;

    $zip = new ZipArchive();
    $archivo = $zip->open($dir_zip);
    $respuesta = [
        'estado' => 'success',
        'data' => [
            'id_factura' => '',
            'pdf' => "",
            'xml' => "",
        ],
    ];
    $route = $dir . $file_zip . $new_folder;
    if (!file_exists($route)) mkdir($route, 0777); //Creamos el directorio con la fecha actual para guardar el archivo ZIP

    for ($i = 0; $i < $zip->numFiles; $i++) { //Recorre los elementos dentro del ZIP
        $archivo = $zip->getNameIndex($i); //Se obtiene el nombre
        $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION)); //Conseguimos la extención
        $nombre = str_replace(".$ext", "", $archivo); //borramos la extención para obtener un nombre limpio
        $id_factura  =  explode("_", $nombre); //El delimitador de tipo_nombre es "_" así que volvemos a separar el arreglo
        $id_factura  =  end($id_factura); //El ultimo segmento del arreglo debe de ser el id de la factura

        /**
         * Se pasa a hacer el guardado de los datos obtenidos
         */
        $respuesta['data']['id_factura'] = $id_factura;
        if ($ext == 'pdf') $respuesta['data']['pdf'] = $nombre . ".$ext";
        if ($ext == 'xml') $respuesta['data']['xml'] = $nombre . ".$ext";
    }
    echo "<br>";
    // $archivo = $zip->extractTo($dir_ext);
    echo json_encode($respuesta);
    print_r($archivo);
} catch (Exception $e) {
    echo $e;
}
