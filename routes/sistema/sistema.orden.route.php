<?php

/**
 *  CURL POST
 *  RUTA => sistema/orden
 */
if ($DIR_SIZE == 2) {
    require_once "../views/sistema/ordenes/ordenes.view.php";
}
// Nota encontrada
/**
 *  CURL POST
 *  RUTA => sistema/orden/pdf/${tipo_pdf}/${id}
 */
else if ($DIR_SIZE == 5 && $DIRECTORIO[2] == 'pdf' && in_array($DIRECTORIO[3], ['facturapdf', 'facturaticket', 'ticketzpl'])) {
    $id_nota = (int)$DIRECTORIO[4];

    switch ($DIRECTORIO[3]) {
        case 'facturapdf':
            require_once "../views/PDF/ordenes/pdf.orden.php";
            break;
        case 'facturaticket':
            require_once "../views/PDF/ventas/ticket.venta.php";
            break;
        case 'ticketzpl':
            require_once "../views/PDF/ventas/zpl.venta.php";
            break;
        default:
            require_once "../views/sistema/errores/404.view.php";
            break;
    }
}
/**ERROR NOT FOUND */
else {
    require_once "../views/sistema/errores/404.view.php";
}
