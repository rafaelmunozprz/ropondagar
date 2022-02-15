<?php

namespace App\Models;

class Permisos extends Usuarios
{
    function __construct()
    {
        parent::__construct();
    }
    function buscar_permiso($id_usuario)
    {
        $sql = "SELECT * FROM permisos WHERE id_usuario = $id_usuario";
        $resultado = $this->CONEXION->query($sql);
        $resultado =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;

        if ($resultado) $resultado['permisos'] = json_decode($resultado['permisos'], true);
        return $resultado;
    }
    function revisar_permisos($id_usuario, $grupo, $tipo)
    {
        $permiso = $this->buscar_permiso($id_usuario);

        if (!$permiso) return false; //Si no se encuentran los permisos no podrá hacer nada
        else if ($permiso['permisos'] === false) return false; // Si no se le asigno nada correctamente cancela el proceso

        return (($permiso['permisos'][$grupo][$tipo] === true) ? true : false);
    }
    function crear_permiso($id_usuario, $permiso)
    {
        $sql = "";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id) ? $this->CONEXION->insert_id : false;
    }
    function modificar_permiso($id_usuario, $permiso)
    {
        $sql = "";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows) ? true : false;
    }
}
