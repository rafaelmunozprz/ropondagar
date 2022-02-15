<?php

namespace App\Models;

class Nota_p extends Proveedores
{
    var $id_nota_proveedor = false;
    var $id_usuario = false;
    var $productos = false;
    var $cantidad_productos = false;
    var $total_costo = false;
    var $fecha = false;
    var $iva = false;
    var $descuento = false;
    var $tipo_descuento = false;
    var $total_pagado = false;
    var $fecha_pago_total = false;
    var $datos_proveedor_general = false;
    var $comentario = false;
    var $stock = false;
    var $estado = false;
    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;

    /**otros FILTROS */
    var $fecha_inicio = false;
    var $fecha_limite = false;
    /**otros FILTROS */
    /**Paginacion */
    var $total_notas = 0;

    function __construct()
    {
        parent::__construct();
    }

    function mostrar_nota($id_nota_proveedor)
    {
        $sql = "SELECT * FROM nota_proveedor WHERE id_nota_proveedor = $id_nota_proveedor";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $respuesta;
    }
    function mostrar_notas()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);

        $filtro = '';

        if ($buscar = $this->buscar)
            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " (P.razon_social LIKE '%$buscar%' OR NP.estado LIKE '$buscar%' OR NP.id_nota_proveedor = '$buscar')";

        if (($fecha_inicio = $this->fecha_inicio) && !$this->fecha_limite) {
            /**FILTRO DE FECHA UNICA */
            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.fecha LIKE '$fecha_inicio%'";
        }
        if (($fecha_limite = $this->fecha_limite) && !$this->fecha_inicio) {
            /**FILTRO DE FECHA UNICA */
            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.fecha <= '$fecha_limite%'";
        }

        if (($fecha_inicio = $this->fecha_inicio) && ($fecha_limite = $this->fecha_limite)) {
            /**FILTRO ENTRE FECHAS */
            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " (NP.fecha >= '$fecha_inicio%' AND NP.fecha <= '$fecha_limite%')";
        }


        if ($id_nota_proveedor = $this->id_nota_proveedor)  $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.id_nota_proveedor = " . $id_nota_proveedor;

        if ($id_proveedor = $this->id_proveedor)            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.id_proveedor = " . $id_proveedor;

        if ($id_usuario = $this->id_usuario)                $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.id_usuario = " . $id_usuario;
        /**Validacion del estado */

        if ($estado = $this->estado) {
            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.estado = '$estado' ";
        } else {
            $filtro .= (($filtro == '') ?  " WHERE " : " AND ") . " NP.estado != 'eliminado' ";
        }
        /**Validacion del estado */


        $this->total_notas = $this->contar_notas($filtro);
        $sql = "SELECT NP.* FROM nota_proveedor AS NP
                    INNER JOIN proveedores AS P ON NP.id_proveedor = P.id_proveedor 
                    $filtro ORDER BY NP.id_nota_proveedor DESC LIMIT $pagina,$limite ";

        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function contar_notas($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM nota_proveedor AS NP
		            INNER JOIN proveedores AS P ON NP.id_proveedor = P.id_proveedor $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function total_notas()
    {
        return $this->total_notas;
    }
    function actualizar($id_nota_proveedor)
    {
        $update = "";
        $update .= ($this->productos                ? ($update != "" ? "," : "") . "productos='$this->productos'" : "");
        $update .= ($this->cantidad_productos       ? ($update != "" ? "," : "") . "cantidad_productos='$this->cantidad_productos'" : "");
        $update .= ($this->total_costo              ? ($update != "" ? "," : "") . "total_costo='$this->total_costo'" : "");
        $update .= ($this->fecha                    ? ($update != "" ? "," : "") . "fecha='$this->fecha'" : "");
        $update .= ($this->id_proveedor             ? ($update != "" ? "," : "") . "id_proveedor='$this->id_proveedor'" : "");
        $update .= ($this->id_usuario               ? ($update != "" ? "," : "") . "id_usuario='$this->id_usuario'" : "");
        $update .= ($this->iva                      ? ($update != "" ? "," : "") . "iva='$this->iva'" : "");
        $update .= ($this->descuento                ? ($update != "" ? "," : "") . "descuento='$this->descuento'" : "");
        $update .= ($this->tipo_descuento           ? ($update != "" ? "," : "") . "tipo_descuento='$this->tipo_descuento'" : "");
        $update .= (($this->total_pagado !== false) ? ($update != "" ? "," : "") . "total_pagado='$this->total_pagado'" : "");
        $update .= ($this->fecha_pago_total         ? ($update != "" ? "," : "") . "fecha_pago_total='$this->fecha_pago_total'" : "");
        $update .= ($this->datos_proveedor_general  ? ($update != "" ? "," : "") . "datos_proveedor_general='$this->datos_proveedor_general'" : "");
        $update .= ($this->comentario               ? ($update != "" ? "," : "") . "comentario='$this->comentario'" : "");
        $update .= ($this->stock                    ? ($update != "" ? "," : "") . "stock='$this->stock'" : "");
        $update .= ($this->estado                   ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");


        $sql = "UPDATE nota_proveedor SET $update WHERE id_nota_proveedor = '$id_nota_proveedor'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function crear_nota_proveedor($productos, $cantidad_productos, $total_costo, $fecha, $id_proveedor, $id_usuario, $iva, $descuento, $tipo_descuento, $total_pagado, $fecha_pago_total = "", $datos_proveedor_general = "", $comentario = "")
    {
        $sql = "INSERT INTO nota_proveedor(productos, cantidad_productos, total_costo, fecha, id_proveedor, id_usuario, iva, descuento, tipo_descuento, total_pagado, fecha_pago_total, datos_proveedor_general, comentario) VALUES ('$productos','$cantidad_productos','$total_costo','$fecha','$id_proveedor','$id_usuario','$iva','$descuento','$tipo_descuento','$total_pagado','$fecha_pago_total','$datos_proveedor_general','$comentario')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    /**
     * PAGOS
     */
    function agregar_pago($id_nota_proveedor, $cantidad, $id_usuario, $tipo_pago = 'efectivo', $comentario = "", $iva = "no")
    {
        $sql = "INSERT INTO pagos_nota_proveedor(id_nota_proveedor, cantidad, tipo_pago, id_usuario, iva, comentario) VALUES ('$id_nota_proveedor','$cantidad','$tipo_pago','$id_usuario','$iva','$comentario')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function mostrar_pagos($id_nota, $id_pago = false)
    {
        $filtro = "";

        if ($id_pago) $filtro .= " AND id_pago_nota_proveedor = $id_pago ";

        $sql = "SELECT * FROM pagos_nota_proveedor WHERE estado != 'eliminado' AND id_nota_proveedor  = $id_nota $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }
    function actualizar_pago($id_pago, $id_nota)
    {
        $update = "";
        $update .= ($this->estado ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");

        $sql = "UPDATE pagos_nota_proveedor SET $update WHERE id_pago_nota_proveedor=$id_pago AND  id_nota_proveedor = $id_nota";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo
    }
    function estadisticas_pagos()
    {
        $filtro = "";

        if ($id_proveedor = $this->id_proveedor) $filtro .= "AND NP.id_proveedor = $id_proveedor ";

        $sql = "SELECT COUNT(*) AS pagos, 
                       ROUND(SUM(PNP.cantidad),2) as cantidad
                        FROM pagos_nota_proveedor AS PNP
                        INNER JOIN nota_proveedor AS NP ON  PNP.id_nota_proveedor = NP.id_nota_proveedor 
                        WHERE PNP.estado != 'eliminado' AND NP.estado != 'eliminado' $filtro;";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo

    }
    function estadisticas_notas()
    {
        $filtro = "";

        if ($id_proveedor = $this->id_proveedor) $filtro .= "AND NP.id_proveedor = $id_proveedor ";



        $sql = "SELECT COUNT(*) AS notas,
                    SUM(NP.cantidad_productos) AS cantidad_productos,
                    ROUND(SUM(NP.total_costo),2) AS total_costo,
                    ROUND(SUM(NP.total_pagado),2) AS total_pagado
                        FROM nota_proveedor AS NP WHERE NP.estado != 'eliminado' $filtro;";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_all(MYSQLI_ASSOC) : false); //Devuelve array con todos los datos Solo usar cuando necesitas todo de putazo

    }
}
