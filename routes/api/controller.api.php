<?php

/**Index o control de ventas */
if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'login') {
    require_once "../api/login/login.php";
}
/**Controlador de indes public se puede usar sin sesión */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'index') {
    require_once "index.api.php";
}


/**Al terminar validar que se deba tener sesión iniciada && USERSYSTEM a cada if */
/**Inventario */
else if ($DIR_SIZE == 2 && $DIRECTORIO[1] == 'inventario') {
    require_once "../api/stock/modelo.php";
}
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'orden') {
    require_once "../api/ordenes/ordenes.php";
}
/**Inventario */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'stock') {
    require_once "stock.api.php";
}
/**MODELOS */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'modelos') {
    require_once "modelos.api.php";
}
else if($DIR_SIZE > 1 && $DIRECTORIO[1] == 'reportes'){
    require_once "reportes_excel.api.php";
}
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'modelos_viejos') {
    require_once "modelos_viejos.api.php";
}
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'notas_modelos_viejos') {
    require_once "notas_modelos_viejos.api.php";
}
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'grupos') {
    require_once "grupos.api.php";
}
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'anaqueles') {
    require_once "anaqueles.api.php";
}

else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'burros') {
    require_once "burros.api.php";
}
/**TIMBRADO */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'timbrado') {
    require_once "timbrado.api.php";
}
/**Correos */
else if ($DIR_SIZE > 2 && $DIRECTORIO[1] == 'login') {
    require_once "email.api.php";
}
/**Correos */
else if ($DIR_SIZE == 3 && $DIRECTORIO[2] == 'notatest') {
    require_once "email.api.php";
}
/**Inventario */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'cliente') {
    require_once "cliente.api.php";
}
/**USUARIOS */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'usuarios') {
    require_once "usuarios.api.php";
}
/**USUARIOS */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'proveedores') {
    require_once "proveedores.api.php";
}



/***
 * --------------------------------------------------------------------------------
 * --------------------------------MODELOS Y MATERIA PRIMA--------------------
 * --------------------------------------------------------------------------------
 */
/**MATERIA PRIMA */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'materiaprima') {
    require_once "materiaprima.api.php";
}
/**USUARIOS */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'categorias') {
    require_once "categorias.api.php";
}
/***
 * --------------------------------------------------------------------------------
 * --------------------------------NOTIFICACIONES DEL SISTEMA  --------------------
 * --------------------------------------------------------------------------------
 */
/**NOTIFICACIONES */
else if ($DIR_SIZE > 1 && $DIRECTORIO[1] == 'notificacion') {
    require_once "notificaciones.api.php";
}


/**
 * NO result
 */
else {
    echo "sin resultado";
}
