<?php

namespace App\Models;

class StockMaP extends Materiaprima
{
    /**Paginacion */
    /** 
     * Stock de materia prima 
     * **/
    var $id_stock_materia_prima = false;
    var $historico_venta        = false;
    var $cantidad_vendida       = false;

    function __construct()
    {
        parent::__construct();
    }
    function registrar_materia($id_materia_prima, $id_proveedor, $id_usuario, $cantidad, $precio_compra, $precio_menudeo, $precio_mayoreo, $codigo_materia, $id_nota_proveedor)
    {
        $sql = "INSERT INTO stock_materia_prima(id_materia_prima, id_proveedor, id_usuario, cantidad, precio_compra, precio_menudeo, precio_mayoreo, codigo_materia, id_nota_proveedor) VALUES ($id_materia_prima,'$id_proveedor' ,'$id_usuario' ,'$cantidad' ,'$precio_compra' ,'$precio_menudeo' ,'$precio_mayoreo' ,'$codigo_materia' ,'$id_nota_proveedor')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function mostrar_materia_stock($id_stock_materia_prima)
    {
        $sql = "SELECT * FROM stock_materia_prima WHERE id_stock_materia_prima = $id_stock_materia_prima";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
    function mostrar_stock($id_materia_prima)
    {

        $sql = "SELECT SMP.id_stock_materia_prima,MP.*,C.nombre AS categoria ,SMP.cantidad, SMP.cantidad_vendida as vendido, SMP.historico_venta FROM stock_materia_prima AS SMP
                    INNER JOIN materia_prima AS MP ON SMP.id_materia_prima = MP.id_materia_prima
                    INNER JOIN nota_proveedor AS NP ON NP.id_nota_proveedor = SMP.id_nota_proveedor
                    INNER JOIN categorias AS C ON MP.id_categoria = C.id_categoria
                    WHERE MP.id_materia_prima = $id_materia_prima AND SMP.cantidad > SMP.cantidad_vendida AND NP.estado!='eliminado'
                    ORDER BY SMP.id_stock_materia_prima";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }
    function total_materia_nota($id_nota)
    {
        $sql = "SELECT N.*, SUM(N.cantidad) AS cantidad_t, SUM(N.cantidad_vendida) AS vendidas_t FROM stock_materia_prima  AS N WHERE N.id_nota_proveedor = $id_nota GROUP BY N.id_nota_proveedor";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }

    function modificar_materia_stock($id_materia = false, $id_nota = false)
    {
        $update = "";
        $filtro = "";
        $update .= $this->estado ? ($update == "" ? "" : ",") . "estado = '$this->estado'" : "";
        $update .= ((($cantidad_vendida = $this->cantidad_vendida) !== false)   ? ($update == "" ? "" : ",") . "cantidad_vendida = '$cantidad_vendida'" : "");
        $update .= ((($historico_venta = $this->historico_venta) !== false)     ? ($update == "" ? "" : ",") . "historico_venta = '$historico_venta'" : "");


        if ($id_materia) $filtro = "WHERE id_materia_prima = $id_materia";
        else if ($id_nota) $filtro = "WHERE id_nota_proveedor = $id_nota";
        else if ($id_stock_materia_prima = $this->id_stock_materia_prima) $filtro = "WHERE id_stock_materia_prima = $id_stock_materia_prima";

        $sql = "UPDATE stock_materia_prima SET $update $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    /**MATERIA PRIMA EN STOCK, por unidad, muestra totales pero solo de las notas que existan en stock */

    function mostrar_stock_materia()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $filtro = '';
        if ($buscar = $this->buscar) {
            $filtro = " AND (C.nombre LIKE '%$buscar%' OR MP.nombre LIKE '%$buscar%' OR MP.color LIKE '%$buscar%' OR MP.codigo LIKE '%$buscar%')";
        }
        if ($id_materia = $this->id_materia) {
            $filtro = "AND  SMP.id_materia_prima = $id_materia";
        }
        if (($codigo = $this->codigo) !== false) {
            $filtro .= " AND (MP.codigo = '$codigo' OR SMP.codigo_materia='$codigo') ";
        }
        /**El primer query busca la materia prima */
        $query = "SELECT MP.*,C.nombre AS categoria,SMP.precio_compra,SMP.precio_mayoreo,SMP.precio_menudeo, 
                        COUNT(SMP.id_stock_materia_prima) AS registros,SUM(SMP.cantidad) AS cantidad,
                        SUM(SMP.cantidad_vendida) AS vendido, SMP.codigo_materia
                    FROM stock_materia_prima AS SMP
                    INNER JOIN materia_prima AS MP ON SMP.id_materia_prima = MP.id_materia_prima
                    INNER JOIN categorias AS C ON MP.id_categoria = C.id_categoria
                        $filtro                        
                        GROUP BY MP.id_materia_prima ORDER BY SMP.id_stock_materia_prima ASC";

        $sql = "SELECT * FROM ($query) AS MPS
                    WHERE MPS.cantidad > MPS.vendido LIMIT $pagina,$limite";
        $resultado = $this->CONEXION->query($sql);
        $this->total_materia = $this->contar_stock_materia($filtro, $query);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    private function contar_stock_materia($filtro, $query)
    {
        $sql = "SELECT COUNT(*) as total FROM ($query) AS MPS
                    WHERE MPS.cantidad > MPS.vendido $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : 0);
    }
    /**
     * La clase principal tiene una funcion que retorna el total de materia, por herencia esta clase se encarga de devolver el total
     */
}
