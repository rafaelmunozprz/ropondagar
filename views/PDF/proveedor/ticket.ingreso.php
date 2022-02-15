<?php

use App\Libreria\Libreria;
use App\Models\{Funciones, Nota_p, Materiaprima};


$NOTA = new Nota_p();
$MATERIA = new Materiaprima();
$FUNC = new Funciones();


$nota_proveedor = $NOTA->mostrar_nota($id_nota); //LEE LA NOTA

$nota_proveedor['productos'] = json_decode($nota_proveedor['productos'], true); //DECODIFICA LOS PRODUCTOS 

$productos = $nota_proveedor['productos']; // SE ASIGNA PARA VALIDAR
if ($productos) {
    /**BUSCA EL NOMBRE Y DATOS DE EL MATERIAL DE LA NOTA */
    foreach ($productos as $i_prod => $producto) {
        $productos[$i_prod]['data'] = $MATERIA->mostrar_materia($producto['id']); //AGREGA LA DATA
    }
}

$proveedor = $NOTA->mostrar_proveedor($nota_proveedor['id_proveedor']);





//Guarda todos los pagos de la nota ya llega formateados en array
if ($pagos = $NOTA->mostrar_pagos($id_nota)) {
    foreach ($pagos as $i_pago => $pago) {
        /**Datos de cada pago */
    }
}


/********************************** */ /********************************** */ /********************************** */
/********************************** */ /********************************** */ /********************************** */


