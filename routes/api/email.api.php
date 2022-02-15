<?php

/**Index o control de ventas */
if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'notatest') {
    //$folio = $DIRECTORIO[1];
    require_once "../api/email/nota_test.php";
}
else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'notatest') {
    require_once "../api/email/nota_test.php";
}
/**
 * NO result
 */
else {
    echo "sin resultado aqui";
}
