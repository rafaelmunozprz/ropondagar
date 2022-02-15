<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/produccion/produccion.view.php";
}
/** */
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'materiaprima') {
    require_once "../views/sistema/produccion/nuevaorden.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'modelos') {
    require_once "../views/sistema/produccion/modelos.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'burros') {
    require_once "../views/sistema/burros/burros.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'anaqueles') {
    require_once "../views/sistema/anaqueles/anaqueles.view.php";
} else {
    echo "no";
}
