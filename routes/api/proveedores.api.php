<?php

/**Index o control de proveedoress */
if ($DIR_SIZE == 2) {
    require_once "../api/proveedores/proveedores.php";
} else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'nota') {
    require_once "../api/proveedores/notas.php";
} else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'email') {
    require_once "../api/proveedores/email.php";
}
/**END */
else {
    echo "No result fount";
}
