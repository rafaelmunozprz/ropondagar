<?php

/**Index o control de ventas */
/**
 * @RUTA /back/timbrado/{here}
 */

if ($DIR_SIZE == 2) {
    require_once "../api/timbrado/timbrar.php";
}
/** */

else if ($DIR_SIZE == 4 && $DIRECTORIO[2] == 'unzip') {
    $folio = $DIRECTORIO[3];
    require_once "../api/timbrado/timbrar_extraer_zip.php";
}
/** */
else if ($DIR_SIZE == 4 && $DIRECTORIO[2] == 'venta') {
    /**
     * @UUD() POST[UUID]
     */
    $folio = $DIRECTORIO[3];
    require_once "../api/timbrado/timbrar_nota_venta.php";
}
/**Inventario */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'inventario') {
    require_once "../views/sistema/inventario/inventario.view.php";
}
/**
 * NO result
 */
else {
    echo "sin resultado";
}
