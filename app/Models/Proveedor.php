<?php

namespace App\Models;

use App\Config\Config;

class Proveedores
{
    var $id_proveedor = false;
    var $razon_social = false;
    var $rfc = false;
    var $tipo_persona = false;
    var $telefono = false;
    var $correo = false;
    var $direccion = false;
    var $fecha_registro = false;
    var $estado = false;

    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;
    /**Paginacion */
    var $total_proveedores = 0;

    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }
    function mostrar_proveedor($id_proveedor)
    {
        $sql = "SELECT * FROM proveedores WHERE id_proveedor = $id_proveedor";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        if ($respuesta) $respuesta['direccion'] = json_decode($respuesta['direccion'], true);
        return $respuesta;
    }
    function mostrar_proveedores()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        if ($buscar) {
            $filtro = " WHERE (razon_social LIKE '%$buscar%' OR rfc LIKE '%$buscar%' OR correo LIKE '%$buscar%')  ";
        }
        $this->total_proveedores = $this->contar_proveedores($filtro);
        $sql = "SELECT * FROM proveedores $filtro ORDER BY razon_social LIMIT $pagina,$limite ";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function contar_proveedores($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM proveedores $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function total_proveedores()
    {
        return $this->total_proveedores;
    }
    function actualizar($id_proveedor)
    {
        $update = "";
        $update .= ($this->razon_social     ? ($update != "" ? "," : "") . "razon_social='$this->razon_social'" : "");
        $update .= ($this->rfc              ? ($update != "" ? "," : "") . "rfc='$this->rfc'" : "");
        $update .= ($this->tipo_persona     ? ($update != "" ? "," : "") . "tipo_persona='$this->tipo_persona'" : "");
        $update .= ($this->telefono         ? ($update != "" ? "," : "") . "telefono='$this->telefono'" : "");
        $update .= ($this->correo           ? ($update != "" ? "," : "") . "correo='$this->correo'" : "");
        $update .= ($this->direccion        ? ($update != "" ? "," : "") . "direccion='$this->direccion'" : "");
        $update .= ($this->fecha_registro   ? ($update != "" ? "," : "") . "fecha_registro='$this->fecha_registro'" : "");
        $update .= ($this->estado           ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");

        $sql = "UPDATE proveedores SET $update WHERE id_proveedor = '$id_proveedor'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function crear_proveedor($razon_social, $rfc, $tipo_persona, $telefono, $correo, $direccion)
    {
        $sql = "INSERT INTO proveedores(razon_social, rfc, tipo_persona, telefono, correo, direccion) VALUES ('$razon_social', '$rfc', '$tipo_persona', '$telefono', '$correo', '$direccion')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
}
