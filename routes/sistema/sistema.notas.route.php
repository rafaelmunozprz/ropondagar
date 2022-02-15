<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/notas/notas_ventas.view.php";
}


// Nota encontrada
elseif (($DIR_SIZE >= 3 || $DIR_SIZE <= 4) && $DIRECTORIO[2] == 'facturapdf') {
    $id_nota = (isset($DIRECTORIO[3]) ? (int)$DIRECTORIO[3] : false);
    require_once "../views/PDF/factura.venta.php";
} elseif (($DIR_SIZE >= 3 || $DIR_SIZE <= 4) && $DIRECTORIO[2] == 'facturaticket') {
    $id_nota = (isset($DIRECTORIO[3]) ? (int)$DIRECTORIO[3] : false);
    require_once "../views/PDF/ticket.venta.php";
} elseif (($DIR_SIZE >= 3 || $DIR_SIZE <= 4) && $DIRECTORIO[2] == 'facturazpl') {
    $id_nota = (isset($DIRECTORIO[3]) ? (int)$DIRECTORIO[3] : false);
    require_once "../views/PDF/ticket.zpl.php";
} elseif (($DIR_SIZE >= 3 || $DIR_SIZE <= 4) && $DIRECTORIO[2] == 'pdfmail') {
    $id_nota = (isset($DIRECTORIO[3]) ? (int)$DIRECTORIO[3] : false);
    require_once "../views/PDF/facturaEmail.venta.php";
} elseif (($DIR_SIZE >= 3 || $DIR_SIZE <= 4) && $DIRECTORIO[2] == 'vender') {
    $id_nota = (isset($DIRECTORIO[3]) ? (int)$DIRECTORIO[3] : false);
    require_once "../views/PDF/vender.php";
}
/**ERROR NOT FOUND */
else {
    require_once "../views/sistema/errores/404.view.php";
}
