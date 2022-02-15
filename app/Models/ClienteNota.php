<?php

namespace App\Models;

use App\Config\Config;

class ClienteNota extends Clientes
{
    /**VARS */
    var $id_nota_cliente        = false;
    var $uuid                   = false;
    var $productos              = false;
    var $cantidad_productos     = false;
    var $total_costo            = false;
    var $fecha                  = false;
    var $id_cliente             = false;
    var $id_usuario             = false;
    var $iva                    = false;
    var $descuento              = false;
    var $tipo_descuento         = false;
    var $total_pagado           = false;
    var $fecha_pago_total       = false;
    var $datos_cliente_general  = false;
    var $comentario             = false;
    var $stock_historico        = false;
    var $estado                 = false;

    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;
    /**Paginacion */

    var $total_notas = 0;

    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }
    function crear_nota($productos, $cantidad_productos, $total_costo, $id_cliente, $id_usuario, $iva, $descuento, $tipo_descuento, $datos_cliente_general, $comentario)
    {
        
        $sql = "INSERT INTO notas_clientes(uuid,productos, cantidad_productos, total_costo, id_cliente, id_usuario, iva, descuento, tipo_descuento, datos_cliente_general, comentario) VALUES (UUID(),'$productos','$cantidad_productos','$total_costo','$id_cliente','$id_usuario','$iva','$descuento','$tipo_descuento','$datos_cliente_general','$comentario')";
        $resultado = $this->CONEXION->query($sql);
        $productos = json_decode($productos, true);
        foreach ($productos as $producto) {
            $id_modelo = $producto['id'];
            $stock = $producto['cantidad'];
            $SQL = "INSERT INTO logs_movimientos (id_usuario, id_modelo, fecha, cantidad, tipo_movimiento) VALUES (4, $id_modelo, CURDATE(), $stock, 'venta')";
            $res = $this->CONEXION->query($SQL);
        }
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function modificar_nota($id_nota)
    {
        $update = "";

        $update .= ($this->productos                ? ($update != "" ? "," : "") . "productos='$this->productos'" : "");
        $update .= ($this->cantidad_productos       ? ($update != "" ? "," : "") . "cantidad_productos='$this->cantidad_productos'" : "");
        $update .= ($this->total_costo              ? ($update != "" ? "," : "") . "total_costo='$this->total_costo'" : "");
        $update .= ($this->fecha                    ? ($update != "" ? "," : "") . "fecha='$this->fecha'" : "");
        $update .= ($this->id_cliente               ? ($update != "" ? "," : "") . "id_cliente='$this->id_cliente'" : "");
        $update .= ($this->id_usuario               ? ($update != "" ? "," : "") . "id_usuario='$this->id_usuario'" : "");
        $update .= ($this->iva                      ? ($update != "" ? "," : "") . "iva='$this->iva'" : "");
        $update .= ($this->descuento                ? ($update != "" ? "," : "") . "descuento='$this->descuento'" : "");
        $update .= ($this->tipo_descuento           ? ($update != "" ? "," : "") . "tipo_descuento='$this->tipo_descuento'" : "");
        $update .= (($this->total_pagado !== false) ? ($update != "" ? "," : "") . "total_pagado='$this->total_pagado'" : "");
        $update .= ($this->fecha_pago_total         ? ($update != "" ? "," : "") . "fecha_pago_total='$this->fecha_pago_total'" : "");
        $update .= ($this->datos_cliente_general    ? ($update != "" ? "," : "") . "datos_cliente_general='$this->datos_cliente_general'" : "");
        $update .= ($this->comentario               ? ($update != "" ? "," : "") . "comentario='$this->comentario'" : "");
        $update .= ($this->stock_historico          ? ($update != "" ? "," : "") . "stock_historico='$this->stock_historico'" : "");
        $update .= ($this->estado                   ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");

        $sql = "UPDATE notas_clientes SET $update WHERE id_nota_cliente = $id_nota";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function eliminar_nota($id_nota)
    {
        $sql = "";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function mostrar_nota($id_nota)
    {
        $sql = "SELECT * FROM notas_clientes WHERE id_nota_cliente = $id_nota";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
    function mostrar_notas()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;

        $filtro = '';
        // if ($buscar = $this->buscar)
        //     // C.razon_social LIKE '%$buscar%' OR
        //     $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " ( NC.estado LIKE '$buscar%' OR NC.id_nota_cliente = '$buscar')";

        // if (($fecha_inicio = $this->fecha_inicio) && !$this->fecha_limite) {
        //     /**FILTRO DE FECHA UNICA */
        //     $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.fecha LIKE '$fecha_inicio%'";
        // }
        // if (($fecha_limite = $this->fecha_limite) && !$this->fecha_inicio) {
        //     /**FILTRO DE FECHA UNICA */
        //     $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.fecha <= '$fecha_limite%'";
        // }

        // if (($fecha_inicio = $this->fecha_inicio) && ($fecha_limite = $this->fecha_limite)) {
        //     /**FILTRO ENTRE FECHAS */
        //     $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " (NC.fecha >= '$fecha_inicio%' AND NC.fecha <= '$fecha_limite%')";
        // }


        // if ($id_nota_cliente = $this->id_nota_cliente)  $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.id_nota_cliente = " . $id_nota_cliente;

        if ($uuid = $this->uuid)             $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.uuid = '$uuid'";
        if ($id_cliente = $this->id_cliente) $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.id_cliente = " . $id_cliente;


        // if ($id_usuario = $this->id_usuario)                $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.id_usuario = " . $id_usuario;
        // /**Validacion del estado */

        // if ($estado = $this->estado) {
        //     $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.estado = '$estado' ";
        // } else {
        //     $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NC.estado != 'eliminado' ";
        // }
        // /**Validacion del estado */

        $this->total_notas = $this->contar_notas($filtro);

        $sql = "SELECT * FROM notas_clientes AS NC $filtro  ORDER BY NC.id_nota_cliente DESC LIMIT $pagina,$limite";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    function contar_notas($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM notas_clientes AS NC $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function total_notas()
    {
        return $this->total_notas;
    }
    /**
     * PAGOS 
     */
    function agregar_pago($id_nota_cliente, $cantidad, $id_usuario, $tipo_pago = 'efectivo', $comentario = "", $iva = "no")
    {
        $sql = "INSERT INTO pagos_notas_clientes(id_nota_cliente, cantidad, tipo_pago, id_usuario, iva, comentario) VALUES ('$id_nota_cliente','$cantidad','$tipo_pago','$id_usuario','$iva','$comentario')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function mostrar_pagos($id_nota, $id_pago = false)
    {
        $filtro = "";

        if ($id_pago) $filtro .= " AND id_pago_nota_clientes = $id_pago ";

        $sql = "SELECT * FROM pagos_notas_clientes WHERE estado != 'eliminado' AND id_nota_cliente  = $id_nota $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }
    function actualizar_pago($id_pago, $id_nota)
    {
        $update = "";
        $update .= ($this->estado ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");

        $sql = "UPDATE pagos_notas_clientes SET $update WHERE id_pago_nota_clientes=$id_pago AND  id_nota_cliente = $id_nota";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }

    function estadisticas_pagos()
    {
        $filtro = "";

        if ($id_cliente = $this->id_cliente) $filtro .= "AND NC.id_cliente = $id_cliente ";

        $sql = "SELECT COUNT(*) AS pagos, 
                       ROUND(SUM(PNP.cantidad),2) as cantidad
                        FROM pagos_notas_clientes AS PNP
                        INNER JOIN nota_cliente AS NP ON  PNP.id_nota_cliente = NC.id_nota_cliente 
                        WHERE PNP.estado != 'eliminado' AND NC.estado != 'eliminado' $filtro;";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }

    function estadisticas_notas()
    {
        $filtro = "";

        if ($id_cliente = $this->id_cliente) $filtro .= "AND NC.id_cliente = $id_cliente ";

        $sql = "SELECT COUNT(*) AS notas,
                    SUM(NC.cantidad_productos) AS cantidad_productos,
                    ROUND(SUM(NC.total_costo),2) AS total_costo,
                    ROUND(SUM(NC.total_pagado),2) AS total_pagado
                        FROM notas_clientes AS NC WHERE NC.estado != 'eliminado' $filtro;";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo

    }
}
