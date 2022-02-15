<?php

namespace App\Models;

use App\Config\Config;

class ModelosViejos
{
    private $CONEXION  = false;

    var $id_modelo = false;
    var $modelo = false;
    var $nombre = false;
    var $codigo = false;
    var $color = false;
    var $talla = false;
    var $tipo = false;
    var $sexo = false;
    var $codigo_completo = false;
    var $materia_prima = false;
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
    function mostrar_modelo($id_modelo)
    {
        $sql = "SELECT * FROM modelos_viejos WHERE id_modelo = $id_modelo";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
    function mostrar_modelos()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $filtro = '';

        if ($buscar = $this->buscar) $filtro = " AND (M.modelo LIKE '%$buscar%' OR M.nombre LIKE '%$buscar%' OR M.color LIKE '%$buscar%' OR M.tipo LIKE '%$buscar%' OR C.nombre LIKE '%$buscar%')  ";
        if ($modelo = $this->modelo) $filtro .=  "AND M.modelo = '$modelo'";

        $this->total_modelos = $this->contar_modelos($filtro);
        $sql = "SELECT M.*,C.nombre AS categoria FROM modelos_viejos AS M 
                    INNER JOIN categorias AS C ON C.id_categoria = M.id_categoria
                    WHERE stock>0 $filtro LIMIT $pagina,$limite";
        // echo $sql;exit;
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function contar_modelos($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM modelos_viejos AS M INNER JOIN categorias AS C ON C.id_categoria = M.id_categoria $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function total_modelos()
    {
        return $this->total_modelos;
    }
}
