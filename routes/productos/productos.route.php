<?php


if ($DIR_SIZE == 1 && $DIRECTORIO[0] == 'productos') {
    require_once "../views/productos/productos.view.php";
} else {
    echo "no";
}