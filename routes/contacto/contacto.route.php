<?php


if ($DIR_SIZE == 1 && $DIRECTORIO[0] == 'contacto') {
    require_once "../views/contacto/contacto.view.php";
} else {
    echo "no";
}
