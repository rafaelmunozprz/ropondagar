<?php

namespace App\Models;

use App\Config\Config;

class Modelos_Viejos
{
    private $CONEXION  = false;

    var $id_modelo_viejo = false;
    var $id_categoria = false;
    var $modelo = false;
    var $nombre = false;
    var $color = false;
    var $talla = false;
    var $tipo = false;
    var $sexo = false;
    var $inversion = false;
    var $precio_menudeo = false;
    var $precio_mayoria = false;
    var $precio_mayoria_iva = false;
    var $precio_menudeo_iva = false;
    var $estado = false;
    var $stock = false;
    var $historial = false;
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
    function comprobar_stock_articulos($datos)
    {
        $flag=true;
        for ($i = 0; $i < count($datos); $i++) {
            $viejo_stock = $this->revisar_stock($datos[$i]['id_modelo_viejo']);
            $viejo_stock = $viejo_stock['stock'];
            $stock_venta = intval($datos[$i]['cantidad']);
            if ($stock_venta > $viejo_stock) {
                $flag = false;
                break;
            }
        }
        return $flag;
    }
    function vender($cliente, $datos, $descuento)
    {
        $cliente = ($cliente ? $cliente : array(
            'razon_social' => '',
            "direccion" => array(
                [
                    "direccion" => "Sin dirección",
                    "numero_externo" => '',
                    "numero_interno" => "N/A",
                    "colonia" => "",
                    "ciudad" => "Sin ciudad",
                    "estado" => ""
                ]
            ),
            'fecha' => date('Y-m-d'),
            'numero' => '1',
            'correo' => 'test@gmail.com',
            'telefono' => '333 1333333 333',
        ));
        $descuento = ($descuento ? $descuento : array(
            'tipo' => 'modeda',            
            'cantidad' => '0',
        ));

        for ($i = 0; $i < count($datos); $i++) {
            $this->disminuir_stock($datos[$i]['id_modelo_viejo'], $datos[$i]['cantidad']);            
        }

        $cliente = json_encode($cliente, JSON_UNESCAPED_UNICODE);
        $datos = json_encode($datos, JSON_UNESCAPED_UNICODE);
        $descuento = json_encode($descuento);
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO venta_modelos_viejos (cliente, articulos, descuento, estado, fecha_registro) VALUES ('$cliente', '$datos', '$descuento', 'activo', '$date')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
        
    }
    function disminuir_stock($id_modelo_viejo, $disminuir_stock)
    {
        $viejo_stock = $this->revisar_stock($id_modelo_viejo);
        $stock = $viejo_stock['stock'];

        $stock = $stock - $disminuir_stock;
        if ($stock < 0)
            return false;
        else {
            $sql = "UPDATE modelos_viejos SET stock=$stock WHERE id_modelo_viejo = '$id_modelo_viejo'";
            $resultado = $this->CONEXION->query($sql);
            return ($resultado && $this->CONEXION->affected_rows ? true : false);
        }
    }
    function agregar_stock($id_modelo_viejo, $nuevo_stock)
    {
        $viejo_stock = $this->revisar_stock($id_modelo_viejo);
        //print_r($viejo_stock['stock']);
        $nuevo_stock = $nuevo_stock + $viejo_stock['stock'];
        $sql = "UPDATE modelos_viejos SET stock=$nuevo_stock WHERE id_modelo_viejo = '$id_modelo_viejo'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function revisar_stock($id_modelo_viejo)
    {
        $sql = "SELECT stock FROM modelos_viejos WHERE id_modelo_viejo = '$id_modelo_viejo'";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $respuesta;
    }
    function eliminar_modelo($id_modelo_viejo)
    {
        $sql = "UPDATE modelos_viejos SET eliminacion_definitiva='true' WHERE id_modelo_viejo = '$id_modelo_viejo'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }

    function mostrar_modelos_viejos()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        if ($buscar) {
            $filtro = " AND (modelo LIKE '%$buscar%' OR nombre LIKE '%$buscar%')  ";
        }
        $this->total_proveedores = $this->total_modelos_viejos($filtro);
        $sql = "SELECT * FROM modelos_viejos WHERE eliminacion_definitiva='false' $filtro ORDER BY modelo LIMIT $pagina,$limite ";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function total_modelos_viejos($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM modelos_viejos $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function mostrar_modelo_viejo($id_modelo_viejo)
    {
        $sql = "SELECT * FROM modelos_viejos WHERE id_modelo_viejo = '$id_modelo_viejo' AND eliminacion_definitiva='false'";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $respuesta;
    }
    function actualizar_modelo_viejo($modificar_nombre, $modificar_talla, $modificar_color, $modificar_tipo, $modificar_sexo, $precio_mayoreo, $precio_menudeo, $modificar_codigo)
    {
        $precio_mayoreo_iva = number_format(($precio_mayoreo * 1.16), 2, '.', '');
        $precio_menudeo_iva = number_format(($precio_menudeo * 1.16), 2, '.', '');
        $sql = "UPDATE modelos_viejos SET nombre='$modificar_nombre', talla='$modificar_talla', color='$modificar_color', tipo='$modificar_tipo', sexo='$modificar_sexo', precio_mayoreo=$precio_mayoreo, precio_menudeo=$precio_menudeo, precio_menudeo_iva=$precio_menudeo_iva, precio_mayoreo_iva=$precio_mayoreo_iva WHERE modelo = '$modificar_codigo'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }

    function nuevo($nombre, $talla, $color, $tipo, $sexo, $precio_mayoreo, $precio_menudeo, $modelo)
    {
        $precio_mayoreo_iva = number_format(($precio_mayoreo * 1.16), 2, '.', '');
        $precio_menudeo_iva = number_format(($precio_menudeo * 1.16), 2, '.', '');
        $sql = "INSERT INTO modelos_viejos (id_categoria, modelo, nombre, color, talla, tipo, sexo, precio_mayoreo, precio_menudeo, precio_mayoreo_iva, precio_menudeo_iva, estado, stock, eliminacion_definitiva) VALUES (1, '$modelo', '$nombre', '$color', '$talla', '$tipo', '$sexo', $precio_mayoreo, $precio_menudeo, $precio_mayoreo_iva, $precio_menudeo_iva, 'activo', 0, 'false')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
}
