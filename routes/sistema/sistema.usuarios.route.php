<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/usuarios/usuarios.view.php";
}
/** Buscar nota*/
elseif ($DIR_SIZE == 3 && ($id_usuario = (int)$DIRECTORIO[2])) {
    require_once "../views/sistema/usuarios/usuario.perfil.view.php";
}
// Nota encontrada
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'cobronota') {
    require_once "../views/sistema/usuarios/cobro_nota.view.php";
} elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'grupos') {
    require_once "../views/sistema/grupos/grupos.view.php";
} else {
    echo "no";
}
