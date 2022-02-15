<?php


// INDEX CONTROLADOR DE NOTAS DE PRUEBA

if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'notatest') {
    require_once "../views/sistema/tempnotes/nueva_nota.view.php";
} else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'nota_modelo_viejo') {
    require_once "../views/sistema/notas_modelos_viejos/notas_modelos_viejos.view.php";
}


/**Index o control de ventas */
else if ($DIR_SIZE == 1 && $DIRECTORIO[0] == 'sistema') {
    require_once "../views/sistema/index/index.view.php";
}
/**Inventario */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'inventario') {
    require_once "../views/sistema/inventario/inventario.view.php";
}
/**Ordenes */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'orden') {
    require_once "sistema.orden.route.php";
}
/**Inventario */
else if ($DIR_SIZE == 3 && $DIRECTORIO[1] == 'producto') {
    require_once "../views/sistema/producto/producto.view.php";
}
/**Perfil */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'perfil') {
    require_once "../views/sistema/perfil/perfil.view.php";
}

/**usuarios */

else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'pagonota') {
    require_once "../views/sistema/notas/pago_nota.view.php";
}
/**usuarios */

else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'cobronota') {
    require_once "../views/sistema/notas/cobro_nota.view.php";
}
/**usuarios */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'usuarios') {
    require_once "sistema.usuarios.route.php";
} else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'grupos') {
    require_once "../views/sistema/grupos/grupos.view.php";
}
/**clientes */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'clientes') {
    require_once "sistema.clientes.route.php";
}
/**PROVEEDOR
 * 
 */

/**materiaprima */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'materiaprima') {
    require_once "../views/sistema/materiaprima/materiaprima.view.php";
}
/**Categorías */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'categorias') {
    require_once "../views/sistema/categorias/categorias.view.php";
}
/**Burros */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'burros') {
    require_once "../views/sistema/burros/burros.view.php";
} 
/**Anaqueles */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'anaqueles') {
    require_once "../views/sistema/anaqueles/anaqueles.view.php";
}

/**Controladores externos */

else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'ventas') {
    require_once "sistema.ventas.route.php";
} else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'notas') {
    require_once "sistema.notas.route.php";
}
/**Controladores externos */

else if ($DIR_SIZE > 1 && in_array($DIRECTORIO[1], ['proveedores', 'proveedor'])) {
    require_once "sistema.proveedor.route.php";
}
/**produccion
 * 
 */

else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'produccion') {
    require_once "sistema.produccion.route.php";
}
/**inventario
 * 
 */

else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'inventario') {
    require_once "sistema.inventario.route.php";
}
/**produccion
 * 
 */

else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'timbrado') {
    require_once "sistema.timbrado.route.php";
}

/**trow Error exeption */
else {
    require_once "../views/errors/error.view.php";
}
