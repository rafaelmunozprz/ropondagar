<?php


if ($DIR_SIZE == 1 && $DIRECTORIO[0] == 'login') {
    require_once "../views/login/login.view.php";
} else {
    echo "no";
}
