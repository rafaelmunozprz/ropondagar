<?php

/**Index o control de ventas */
if ($DIR_SIZE == 2) {
    // require_once "../api/stock/inventario.php";
    echo "sin resultado";
}
/** */
else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'materiaprima') {
    $folio = $DIRECTORIO[2];
    require_once "../api/materiaprima/inventario.php";
}
// /**Inventario */
// else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'inventario') {
//     require_once "../api/stock/inventario.php";
// }
/**
 * NO result
 */
else {
    echo "sin resultado";
}
