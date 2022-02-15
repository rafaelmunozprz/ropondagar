<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/clientes/clientes.view.php";
}
/** Buscar nota*/
elseif ($DIR_SIZE == 3 && ($id_cliente = (int)$DIRECTORIO[2])) {
    require_once "../views/sistema/clientes/cliente.perfil.view.php";
}
// Nota encontrada
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'cobronota') {
    require_once "../views/sistema/usuarios/cobro_nota.view.php";
} else {
    echo "no";
}
