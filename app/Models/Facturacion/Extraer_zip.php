<?php

namespace App\Facturacion;

class Zip_extract
{
    static function extract_cfdi($folio, $dir =  "../public/")
    {
        $response = [];
        try {

            // @ $folio = $folio $DIRECTORIO[3]

            $zip = new \ZipArchive();

            $dir_zip = "documentos/cfdi/$folio.zip";
            $dir_ext = "documentos/cfdi_ext/$folio/";

            if (is_file($dir . $dir_zip)) {
                if (!file_exists($dir . $dir_ext)) {
                    mkdir($dir . $dir_ext, 0777) or die(json_encode(array('respuesta' => 'error', 'Texto' => "No se puede crear el directorio de extracción")));
                }

                $comprimido = $zip->open($dir . $dir_zip);

                if ($comprimido === true) {
                    // Declaramos la carpeta que almacenara ficheros descomprimidos

                    $archivos = [];
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $filename =  $zip->getNameIndex($i);
                        $file_format = explode('.', $filename);
                        $ext = END($file_format);
                        $new_name = $folio . '.' . $ext;
                        $zip->renameName($filename, ($new_name));
                        /**
                         * Se guarda el tipo de archivo y su ruta
                         */
                        $archivos[$ext] = ($dir_ext . $new_name);
                    }
                    $zip->extractTo($dir . $dir_ext);

                    $zip->close();

                    $response = [
                        'status' => true,
                        'response' => 'success',
                        'text' => "Los archivos fueron guardados de forma correcta",
                        'data' => $archivos,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'response' => 'error',
                        'text' => "El fichero con la factura exta dañado los archivos PDF y XML $folio.zip no se encontraron"
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'response' => 'error',
                    'text' => "No fue posible encontrar el archivo que contiene la factura PDF y XML $folio.zip no existe"
                ];
            }

            return ($response);
            /** */
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'response' => 'error',
                'text' => "No fue posible encontrar el archivo que contiene la factura PDF y XML $folio.zip no existe"
            ];
            return  $response;
        }
    }
}
