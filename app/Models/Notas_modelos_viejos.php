<?php

namespace App\Models;

use App\Config\Config;

class Notas_modelos_viejos
{
    private $CONEXION  = false;

    var $id_nota_modelo_viejo = false;
    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;

    private $total_modelos = 0;
    /**Paginacion */
    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    } 
    function mostrar_notas_modelos_viejos()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        if ($buscar) {
            $filtro = " WHERE (id_venta_modelo_viejo LIKE '%$buscar%')";
        }
        $this->total_proveedores = $this->total_notas_modelos_viejos($filtro);
        $sql = "SELECT * FROM venta_modelos_viejos $filtro ORDER BY id_venta_modelo_viejo DESC LIMIT $pagina,$limite ";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function total_notas_modelos_viejos($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM venta_modelos_viejos $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function mostrar_nota_modelo_viejo($id_nota_modelo_viejo)
    {
        $sql = "SELECT * FROM venta_modelos_viejos WHERE id_venta_modelo_viejo = '$id_nota_modelo_viejo'";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $respuesta;
    }
    
}
