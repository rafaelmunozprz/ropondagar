<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/produccion/produccion.view.php";
}
/** */
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'nuevo') {
    require_once "../views/sistema/produccion/nuevaorden.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'modelos') {
    require_once "../views/sistema/produccion/modelos.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'modelos_viejos') {
    require_once "../views/sistema/modelos_viejos/modelos_viejos.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'categorias') {
    require_once "../views/sistema/categorias/categorias.view.php";
} else {
    echo "no";
}
