<?php

/**Index o control de ventas */
if ($DIR_SIZE == 2) {
    // require_once "../api/stock/inventario.php";
    echo "sin resultado";
}
/** */
else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'orden') {
    $folio = $DIRECTORIO[2];
    require_once "../api/ordenes/ordenes.php";
}
else {
    echo "sin resultado";
}