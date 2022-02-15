<?php

namespace App\Models;

use App\Config\Config;

class Usuarios
{
    /**Config */
    var $CONF = false;
    protected $CONEXION = false;
    /**variables */

    var $id_usuario = false;
    var $nombre = false;
    var $apellidos = false;
    var $telefono = false;
    var $direccion = false;
    var $cargo = false;
    var $nombre_usuario = false;
    var $password = false;
    var $fecha_nacimiento = false;
    var $fecha_salida = false;
    var $estado = false;
    var $id_avatar = false;
    var $intento_login = false;
    var $ultimo_login = false; // YYY-mm-dd

    /**paginacion  y busqueda*/
    var $total_usuarios = 0;
    var $pagina = 1;
    var $limite = 20;
    var $buscar = '';

    function __construct()
    {
        $this->CONF = new Config();
        $this->CONEXION = $this->CONF->getConexion();
    }
    function encontrar_usuario($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$usuario'";
        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false;
    }
    function avatars()
    {
        $sql = "SELECT * FROM avatar";
        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $respuesta->num_rows) ? $respuesta : false;
    }
    function mostrar_usuario($id_usuario)
    {
        $sql = "SELECT U.*,A.imagen FROM usuarios AS U
                    INNER JOIN avatar AS A ON A.id_avatar = U.id_avatar WHERE U.id_usuario = $id_usuario";

        $respuesta = $this->CONEXION->query($sql);
        $respuesta =  ($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false;
        if ($respuesta) $respuesta['direccion'] = json_decode($respuesta['direccion'], true);
        return $respuesta;
    }
    function buscar_usuario($id_usuario)
    {
        $sql = "SELECT U.id_usuario, U.nombre_usuario, U.nombre,U.apellidos,U.telefono,U.direccion,U.cargo,U.fecha_nacimiento,U.estado,U.id_avatar,A.imagen FROM usuarios AS U
                    INNER JOIN avatar AS A ON A.id_avatar = U.id_avatar WHERE U.id_usuario = $id_usuario";

        $respuesta = $this->CONEXION->query($sql);
        $respuesta =  ($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc() : false;
        if ($respuesta) $respuesta['direccion'] = json_decode($respuesta['direccion'], true);
        return $respuesta;
    }
    function mostrar_usuarios()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';

        if ($buscar) {
            $filtro = " WHERE (U.nombre_usuario LIKE '%$buscar%' OR U.nombre LIKE '%$buscar%' OR U.apellidos LIKE '%$buscar%' OR U.direccion LIKE '%$buscar%')  ";
        }
        $this->total_usuarios = $this->contar_usuarios($filtro);

        $sql = "SELECT U.id_usuario, U.nombre_usuario, U.nombre,U.apellidos,U.telefono,U.direccion,U.cargo,U.fecha_nacimiento,U.estado,U.id_avatar,A.imagen FROM usuarios AS U
                    INNER JOIN avatar AS A ON A.id_avatar = U.id_avatar
                    $filtro LIMIT $pagina,$limite";

        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $respuesta->num_rows) ? $respuesta : false;
    }
    function contar_usuarios($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios AS U
                    INNER JOIN avatar AS A ON A.id_avatar = U.id_avatar $filtro";

        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $respuesta->num_rows) ? $respuesta->fetch_assoc()['total'] : false;
    }
    function total_usuarios()
    {
        return $this->total_usuarios;
    }
    function crear_usuario($nombre, $apellidos, $telefono, $direccion, $cargo, $nombre_usuario, $password, $fecha_nacimiento, $estado, $id_avatar)
    {
        $sql = "INSERT INTO usuarios(nombre, apellidos, telefono, direccion, cargo, nombre_usuario, password, fecha_nacimiento, estado, id_avatar) VALUES 
                    ('$nombre', '$apellidos', '$telefono', '$direccion', '$cargo', '$nombre_usuario','$password', '$fecha_nacimiento', '$estado', '$id_avatar');";
        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $this->CONEXION->insert_id) ? $this->CONEXION->insert_id : false;
    }

    function actualizar_usuario($id_usuario)
    {
        $update = "";
        $update .= ($this->nombre           ? ($update != "" ? "," : "") . "nombre='$this->nombre'" : "");
        $update .= ($this->apellidos        ? ($update != "" ? "," : "") . "apellidos='$this->apellidos'" : "");
        $update .= ($this->telefono         ? ($update != "" ? "," : "") . "telefono='$this->telefono'" : "");
        $update .= ($this->direccion        ? ($update != "" ? "," : "") . "direccion='$this->direccion'" : "");
        $update .= ($this->cargo            ? ($update != "" ? "," : "") . "cargo='$this->cargo'" : "");
        $update .= ($this->nombre_usuario   ? ($update != "" ? "," : "") . "nombre_usuario='$this->nombre_usuario'" : "");
        $update .= ($this->password         ? ($update != "" ? "," : "") . "password='$this->password'" : "");
        $update .= ($this->fecha_nacimiento ? ($update != "" ? "," : "") . "fecha_nacimiento='$this->fecha_nacimiento'" : "");
        $update .= ($this->fecha_salida     ? ($update != "" ? "," : "") . "fecha_salida='$this->fecha_salida'" : "");
        $update .= ($this->estado           ? ($update != "" ? "," : "") . "estado='$this->estado'" : "");
        $update .= ($this->id_avatar        ? ($update != "" ? "," : "") . "id_avatar='$this->id_avatar'" : "");
        $update .= ($this->ultimo_login     ? ($update != "" ? "," : "") . "ultimo_login='$this->ultimo_login'" : "");
        $update .= ($this->intento_login === false    ? "" : ($update != "" ? "," : "") . "intento_login='$this->intento_login'");

        $sql = "UPDATE usuarios SET $update WHERE id_usuario = '$id_usuario'";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $this->CONEXION->affected_rows) ? true : false);
    }
    function recuperar_password($id_usuario)
    {
        $sql = "SELECT RC.*, U.nombre, U.apellidos, U.correo, U.cargo FROM recuperar_cuenta AS RC
                    INNER JOIN usuarios AS U 
                    ON RC.id_usuario = U.id WHERE U.id = $id_usuario ";
        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $respuesta->num_rows ? $respuesta->fetch_assoc() : false);
    }
    function restablecer_password($id_usuario, $codigo, $intentos)
    {
        $sql = "INSERT INTO recuperar_cuenta(id_usuario, codigo, intentos) VALUES ($id_usuario,'$codigo',$intentos)";
        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function restablecer_password_update($id_usuario, $codigo, $intentos, $restaurar = 0)
    {
        $sql = "UPDATE recuperar_cuenta SET codigo='$codigo',intentos=$intentos,intento_restaurar=$restaurar WHERE id_usuario = $id_usuario";
        $respuesta = $this->CONEXION->query($sql);
        return ($respuesta && $this->CONEXION->affected_rows ? $respuesta : false);
    }
}
