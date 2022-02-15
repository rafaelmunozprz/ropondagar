<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/ventas/vender.view.php";
} else  if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'notas') {
    require_once "../views/sistema/ventas/ventas.view.php";
}
// Nota encontrada
else if ($DIR_SIZE == 5 && $DIRECTORIO[2] == 'pdf' && in_array($DIRECTORIO[3], ['facturapdf', 'facturaticket', 'ticketzpl'])) {
    $id_nota = (int)$DIRECTORIO[4];
    switch ($DIRECTORIO[3]) {
        case 'facturapdf':
            require_once "../views/PDF/ventas/pdf.venta.php";
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
// Nota encontrada
else if ($DIR_SIZE == 4  && $DIRECTORIO[2] == 'notas') {
    $id_nota = (int)$DIRECTORIO[3];
    require_once "../views/sistema/ventas/nota_historial.view.php";
}

/**ERROR NOT FOUND */
// Nota Facturar view
else if ($DIR_SIZE == 5  && $DIRECTORIO[2] == 'facturacion') {
    $id_nota = $DIRECTORIO[3];
    $folio = $DIRECTORIO[4];
    require_once "../views/sistema/ventas/facturar.view.php";
}

/**ERROR NOT FOUND */
else {
    require_once "../views/sistema/errores/404.view.php";
}
