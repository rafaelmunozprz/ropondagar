<?php

/**Index o control de ventas */
if ($DIR_SIZE == 2) {
    require_once "../api/modelos/modelos.php";
}
/**Inventario */
else if ($DIR_SIZE  == 3 && $DIRECTORIO[2] == 'galeria') {
    require_once "../api/modelos/modelos_galeria.php";
}
/**Inventario */
else if ($DIR_SIZE  == 3 && $DIRECTORIO[2] == 'viejos') {
    require_once "../api/modelos/modelos_viejos.php";
}
/**Inventario */

else {
    echo "No model";
}
