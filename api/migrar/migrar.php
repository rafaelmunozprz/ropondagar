<?php

use App\Config\Config;

$CONF = new Config();

$conexion = $CONF->getConexion();


$sql = "SELECT id_modelo_viejo, codigo_completo  FROM `modelos`";
$todos_los_modelos = $conexion->query($sql);

while ($modelo_viejo = $todos_los_modelos->fetch_assoc()) {
    print_r($modelo_viejo['codigo_completo']);
    /* $sql_insert = "INSERT INTO `modelos`(`nombre`, `codigo`, `color`, `talla`, `tipo`, `sexo`, `codigo_completo`, `materia_prima`, `codigo_antiguo`, `eliminacion_definitiva`, `id_categoria`) VALUES ($row['nombre],$row['codigo'],$row['color'])";
    $nuevo_modelo = $conexion->query($sql_insert);
    
    $id = $conexion->insert_id;
    $sql_stock = "INSERT INTO `stock_maquilas`(`id_modelo`, `id_usuario`, `cantidad`, `cantidad_vendida`, `costo`, `precio_mayoreo`, `precio_menudeo`, `codigo_maquila`, `historico_venta`, `codigo_final`, `fecha`) VALUES ($id,1,$row['stock']),''"; */
}
/*/*********************************SALI A COMER  */