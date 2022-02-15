<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/timbrado/timbrado.view.php";
}
/** Buscar nota*/
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'notas') {
    require_once "../views/sistema/proveedores/notas_proveedor.view.php";
}

// Nota encontrada
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'cobronota') {
    require_once "../views/sistema/proveedores/cobro_nota.view.php";
}

// Nota encontrada
elseif ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'facturapdf') {
    require_once "../views/PDF/factura.venta.php";
} else {
    echo "no";
}
