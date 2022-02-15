<?php

use App\Facturacion\Facturacion;

header('Content-type:application/json;charset=utf-8');

$CFDI = new Facturacion();

$response  = $CFDI->extract_zip_cfdi($folio, '../public/');

echo json_encode($response);
