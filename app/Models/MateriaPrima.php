<?php

namespace App\Models;

use App\Config\Config;

class Materiaprima
{
    protected $CONEXION  = false;

    var $id_materia = false;
    var $id_categoria = false;
    var $nombre = false;
    var $color = false;
    var $medida = false;
    var $unidad_medida = false;
    var $porcentaje_ganancia = false;
    var $estado = false;
    var $codigo = false;
    var $codigo_fiscal = false;
    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;

    var $total_materia = 0;
    /**Paginacion */
    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }
    function crear_materia($id_categoria, $nombre, $color, $medida, $unidad_medida, $porcentaje_ganancia, $estado, $codigo, $codigo_fiscal = "")
    {
        $sql = "INSERT INTO materia_prima(id_categoria, nombre, color, medida, unidad_medida, porcentaje_ganancia, estado, codigo,codigo_fiscal) VALUES ('$id_categoria','$nombre','$color','$medida','$unidad_medida','$porcentaje_ganancia','$estado','$codigo','$codigo_fiscal')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function modificar_materia($id_materia)
    {
        $update = "";
        $update .= $this->id_categoria        ? ($update == "" ? "" : ",") . "id_categoria = '$this->id_categoria'" : "";
        $update .= $this->nombre              ? ($update == "" ? "" : ",") . "nombre = '$this->nombre'" : "";
        $update .= $this->color               ? ($update == "" ? "" : ",") . "color = '$this->color'" : "";
        $update .= $this->medida              ? ($update == "" ? "" : ",") . "medida = '$this->medida'" : "";
        $update .= $this->unidad_medida       ? ($update == "" ? "" : ",") . "unidad_medida = '$this->unidad_medida'" : "";
        $update .= $this->porcentaje_ganancia ? ($update == "" ? "" : ",") . "porcentaje_ganancia = '$this->porcentaje_ganancia'" : "";
        $update .= $this->estado              ? ($update == "" ? "" : ",") . "estado = '$this->estado'" : "";
        $update .= $this->codigo              ? ($update == "" ? "" : ",") . "codigo = '$this->codigo'" : "";
        $update .= $this->codigo_fiscal       ? ($update == "" ? "" : ",") . "codigo_fiscal = '$this->codigo_fiscal'" : "";

        $sql = "UPDATE materia_prima SET $update WHERE id_materia_prima = $id_materia";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function eliminar_materia($id_materia)
    {
        $sql = "";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function mostrar_materia($id_materia)
    {
        $sql = "SELECT M.*,C.nombre AS categoria FROM materia_prima AS M
                    INNER JOIN  categorias AS C ON M.id_categoria = C.id_categoria WHERE M.id_materia_prima = $id_materia";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
    function mostrar_materia_prima()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $filtro = '';
        if ($buscar = $this->buscar) {
            $filtro = " WHERE (C.nombre LIKE '%$buscar%' OR M.nombre LIKE '%$buscar%' OR M.color LIKE '%$buscar%' OR M.codigo LIKE '%$buscar%')";
        }
        if ($id_materia = $this->id_materia) {
            $filtro = ($filtro == '' ? " WHERE " : " AND ") . " M.id_materia_prima = $id_materia";
        }
        /**El primer query busca la materia prima */
        $sql = "SELECT M.*,C.nombre AS categoria FROM materia_prima AS M
                    INNER JOIN  categorias AS C ON M.id_categoria = C.id_categoria 
                    $filtro ORDER BY M.nombre ASC LIMIT $pagina,$limite";
        /**Query avanzado se encargara de contar la materia prima asignada */
        $sql_advance = "SELECT MP.*,COUNT(SMP.id_stock_materia_prima) AS registros,SUM(SMP.cantidad) AS cantidad,SUM(SMP.cantidad_vendida) AS vendido FROM ($sql) AS MP
                            LEFT JOIN (SELECT * FROM stock_materia_prima WHERE estado !='eliminado') AS SMP ON SMP.id_materia_prima = MP.id_materia_prima
                            GROUP BY MP.id_materia_prima";

        $resultado = $this->CONEXION->query($sql_advance);
        $this->total_materia = $this->contar_materia($filtro);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    private function contar_materia($filtro)
    {
        $sql = "SELECT COUNT(*) AS total FROM materia_prima AS M
                    INNER JOIN  categorias AS C ON M.id_categoria = C.id_categoria $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : 0);
    }
    function total_materia()
    {
        return $this->total_materia;
    }
}
