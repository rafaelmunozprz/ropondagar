<?php
// @request post: back/cliente
/**Index o control de ventas */
if ($DIR_SIZE == 2) {
    require_once "../api/clientes/clientes.php";
}
/** */
else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'notas') {
    $folio = $DIRECTORIO[2];
    require_once "../api/clientes/notas.php";
}
/**Generar nota de venta */
else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'nota_venta') {
    require_once "../api/ventas/notas.php";
}
/**ENVIAR CORREO */
else if ($DIR_SIZE == 4 && $DIRECTORIO[2] == 'nota_venta') {
    if ($DIRECTORIO[3] == 'correo') {
        require_once "../api/ventas/email.php";
    } else {
        die(json_encode(['status' => false, "response" => 'error_log']));
    }
}
/**
 * NO result
 */
else {
    die(json_encode(['status' => false, "response" => 'error_log']));
}
