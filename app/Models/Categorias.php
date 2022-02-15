<?php

namespace App\Models;

use App\Config\Config;

class Categorias
{
    var $id_categoria = false;
    var $nombre = false;
    var $estado = false;
    var $tipo = false;

    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;
    /**Paginacion */
    private $total_categorias = 0;

    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }
    function mostrar_categoria($id_categoria)
    {
        $sql = "SELECT * FROM categorias WHERE id_categoria LIKE '$id_categoria%' OR nombre LIKE '$id_categoria%'";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;

        return $respuesta;
    }
    function mostrar_categorias()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);;
        $filtro = $this->buscar;

        /* if ($buscar = $this->buscar) $filtro = " WHERE eliminacion_definitiva='false'"; */
        /* if ($buscar = $this->buscar) $filtro = " WHERE (nombre LIKE '%$buscar%')  "; */
        /* if ($nombre = $this->nombre) $filtro = ($filtro == '' ? ' WHERE ' : ' AND ') . "nombre = '$nombre')  "; */

        $this->total_categorias = $this->contar_categorias($filtro);
        $sql = "SELECT * FROM categorias WHERE eliminacion_definitiva='false' LIMIT $pagina, 15";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function mostrar_categorias_prima()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);;
        $filtro = '';

        $this->total_categorias = $this->contar_categorias($filtro);
        $sql = "SELECT * FROM categorias WHERE eliminacion_definitiva='false' AND tipo='prima'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function contar_categorias($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM categorias $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function total_categorias()
    {
        return $this->total_categorias;
    }
    function actualizar($id_categoria)
    {
        $update = "";
        $update .= ($this->nombre     ? ($update != "" ? "," : "") . "nombre='$this->nombre'" : "");
        $update .= ($this->estado     ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");

        $sql = "UPDATE categorias SET $update WHERE id_categoria = '$id_categoria'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function crear_categoria($nombre, $tipo)
    {
        $sql = "INSERT INTO categorias (nombre, tipo) VALUES ('$nombre', '$tipo')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function eliminar_categoria($id_categoria)
    {
        $sql = "UPDATE categorias SET eliminacion_definitiva='true' WHERE id_categoria = $id_categoria";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function mostrar_articulos_categoria($id_categoria)
    {
        $sql = "SELECT * FROM materia_prima WHERE id_categoria=$id_categoria";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
}
