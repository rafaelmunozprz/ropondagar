<?php

if ($DIR_SIZE == 2) {
    require_once "../views/sistema/proveedores/proveedores.view.php";
}

/// Perfil
elseif ($DIR_SIZE == 3 && ($id_proveedor = (int)$DIRECTORIO[2])) {
    require_once "../views/sistema/proveedores/proveedor.perfil.view.php";
}
/// Nota
elseif ($DIR_SIZE == 3 && ($DIRECTORIO[2] == 'nueva_nota')) {
    require_once "../views/sistema/proveedores/nota_proveedor.view.php";
}
/// Notas
elseif ($DIR_SIZE == 3 && ($DIRECTORIO[2] == 'notas')) {
    require_once "../views/sistema/proveedores/notas_proveedores.view.php";
}
// Notas para inventariar
elseif ($DIR_SIZE == 4 && ($DIRECTORIO[2] == 'notas') && ($id_nota = (int)$DIRECTORIO[3])) {

    require_once "../views/sistema/proveedores/notas_inventariar.view.php";
}

/**GENERAR PDF */
elseif ($DIR_SIZE == 5 && ($DIRECTORIO[2] == 'pdf' && in_array($DIRECTORIO[3], ['facturaticket', 'facturapdf', 'ticketzpl']))) {
    $id_nota = (int)$DIRECTORIO[4];
    if ($DIRECTORIO[3] == 'facturaticket') {

        require_once "../views/PDF/proveedor/ticket.ingreso.php";

        /** */
    } else  if ($DIRECTORIO[3] == 'facturapdf') {

        require_once "../views/PDF/proveedor/pdf.ingreso.php";
    } else  if ($DIRECTORIO[3] == 'ticketzpl') {

        require_once "../views/PDF/proveedor/zpl.ingreso.php";

        /** */
    }
}

// Nota encontrada
else {
    echo "no";
    var_dump($DIRECTORIO);
}
