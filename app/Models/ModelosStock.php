<?php

namespace App\Models;

class StockModelos extends Modelos
{
    var $cantidad_vendida = false;
    var $historico_venta = false;

    function __construct()
    {
        parent::__construct();
    }
    private function query_stock_modelos($filtro)
    {
        $query = "SELECT SM.id_stock_maquila,SM.costo,SM.precio_mayoreo,SM.precio_menudeo,SM.codigo_final, M.*,
                        COUNT(SM.id_modelo) AS registros ,SUM(SM.cantidad) AS cantidad,SUM(SM.cantidad_vendida) AS vendido,SM.historico_venta FROM stock_maquilas AS SM
                    INNER JOIN modelos AS M ON SM.id_modelo = M.id_modelo WHERE (M.eliminacion_definitiva='false' $filtro)";
        return $query;
    }

    function modificar_stock_modelo($id_stock)
    {
        $update = "";
        $update .= ((($cantidad_vendida = $this->cantidad_vendida) !== false) ? ($update == "" ? "" : ",") . "cantidad_vendida = '$cantidad_vendida'" : "");
        $update .= ((($historico_venta = $this->historico_venta) !== false) ? ($update == "" ? "" : ",") . "historico_venta = '$historico_venta'" : "");

        $sql = "UPDATE stock_maquilas SET $update WHERE id_stock_maquila = $id_stock";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }

    function mostrar_modelo_stock($id_stock_maquila)
    {
        $sql = $this->query_stock_modelos("AND SM.id_stock_maquila = $id_stock_maquila");
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
    function mostrar_stock_modelos($id_modelo = false)
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        $codigo_c = $this->codigo_completo;

        if ($buscar !== false) $filtro .= " AND (M.nombre LIKE '%$buscar%' OR M.codigo LIKE '%$buscar%' OR M.color LIKE '%$buscar%' OR M.tipo LIKE '%$buscar%' OR M.sexo LIKE '%$buscar%')  ";
        if ($id_modelo) $filtro .= " AND (M.id_modelo = $id_modelo) ";
        if (($codigo = $this->codigo) !== false) {
            $filtro .= " AND (M.codigo = '$codigo' OR M.codigo_completo='$codigo') ";
        }

        $sql = $this->query_stock_modelos($filtro) . " GROUP BY M.id_modelo";
        $sql_supremo = "SELECT * FROM ($sql) AS SM WHERE SM.cantidad>SM.vendido";

        $this->total_modelos = $this->contar_stock_modelos($sql_supremo);

        $resultado = $this->CONEXION->query(($sql_supremo . " LIMIT $pagina,$limite"));
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    private function contar_stock_modelos($sql)
    {
        $sql = "SELECT COUNT(*) AS total FROM ($sql) AS M";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }

    /**todos los modelos */

    function mostrar_stock_m($id_modelo)
    {
        $sql = "SELECT SM.id_stock_maquila,SM.costo,SM.precio_mayoreo,SM.precio_menudeo,SM.codigo_final, M.*,
                    SM.cantidad ,SM.cantidad_vendida AS vendido,SM.historico_venta FROM stock_maquilas AS SM
                    INNER JOIN modelos AS M ON SM.id_modelo = M.id_modelo
                    WHERE (M.eliminacion_definitiva='false') AND (SM.cantidad > SM.cantidad_vendida) AND SM.id_modelo = $id_modelo";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }
}
