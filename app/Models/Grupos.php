<?php

namespace App\Models;

use App\Config\Config;

class Grupos
{
    private $CONEXION  = false;

    var $id_modelo_viejo = false;
    var $nombre = false;
    var $estado = false;
    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;

    private $total_grupos = 0;
    /**Paginacion */
    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }

    /**
     * @param number $id_grupo_trabajo identificador único del grupo que identificará a los usuarios en la base de datos
     * @return object $resultado si la busqueda tiene coincidencias retornara un objeto con todos los usuarios en la base de datos que pertenescan al grupo
     */
    function determinar_encargado($id_grupo_trabajo)
    {
        $SQL = "SELECT gu.id_grupo_trabajo, u.nombre, u.apellidos, gu.id_grupo_usuario FROM grupos_usuarios AS gu INNER JOIN usuarios AS u ON gu.id_usuario = u.id_usuario AND gu.id_grupo_trabajo = $id_grupo_trabajo";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param number $id_grupo_trabajo identificador del grupo de trabajo que se repetirá en cada usuario asignado a dicho grupo
     * @param array $users arreglo de usuarios que se guardará en la base de datos
     * @return object $resultado si la inserción de los datos fue correcta regresa el ID de la insersión en la base de datos
     */
    function agregar_personal($users, $id_grupo_trabajo)
    {
        $hoy = date("Y-m-d H:i:s");
        foreach ($users as $user) {
            $id_usuario = $user['user_id'];
            $SQL = "INSERT INTO grupos_usuarios (id_usuario, cargo, fecha, id_grupo_trabajo) VALUES ($id_usuario, 'trabajador', '$hoy', $id_grupo_trabajo)";
            $resultado = $this->CONEXION->query($SQL);
        }
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }

    /**
     * @return object $resultado retorna la lista de usuarios disponibles en la tabla 'usuarios'
     */
    function cargar_personal_agregar()
    {
        $sql = "SELECT id_usuario, nombre, apellidos FROM usuarios";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param number $id_grupo_trabajo identificador del grupo de usuarios, se borrarán tanto los usuarios del grupo como el grupo
     * @return object $resultado retorna la confirmación de la eliminación del grupo y los usuarios
     */
    function eliminar_grupo($id_grupo_trabajo)
    {
        $sql = "UPDATE grupos_trabajos SET estado='eliminado' WHERE id_grupo_trabajo = '$id_grupo_trabajo'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }

    /**
     * @param string $nombre nombre del grupo que será creado
     * @param string $tipo_grupo tipo de grupo de la linea de produccion que será creada
     * @return resultado resultado de la insersion en la base de datos
     */
    function nuevo_grupo($nombre, $tipo_grupo)
    {
        $sql = "INSERT INTO grupos_trabajos (nombre_grupo, estado, grupo) VALUES ('$nombre', 'activo','$tipo_grupo')";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }

    /**
     * @return object devuelve un objeto con todos los grupos disponibles sin estado de eliminado
     */
    function mostrar_grupos()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        if ($buscar) {
            $filtro = " AND (nombre_grupo LIKE '%$buscar%')  ";
        }
        $this->total_proveedores = $this->total_grupos($filtro);
        $sql = "SELECT * FROM grupos_trabajos WHERE estado!='eliminado' $filtro ORDER BY id_grupo_trabajo ASC LIMIT $pagina,$limite ";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param string $buscar nombre de un grupo en específico que será buscado en la base de datos
     * @return object $respuesta con la respuesta de la base de datos
     */
    function mostrar_grupo($buscar)
    {
        $sql = "SELECT * FROM grupos_trabajos WHERE nombre_grupo LIKE '$buscar%' AND estado!='eliminado' ";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $respuesta;
    }
    /**
     * @param string $filtro parte de la cadena SQL que devuelve la cantidad de grupos encontrados en la base de datos_cliente_general
     * @return number  $resultado la candtidad de elementos encontrada con la busqueda en la base de datos
     */
    function total_grupos($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM grupos_trabajos $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }

    /**
     * @param number $id_grupo_trabajo identificador del grupo que será actualizado
     * @param string $nombre_grupo nombre que será actualizado
     * @param string $estado estado que será actualizado
     * @return object $resultado confirmación de la modificación en la base de datos
     */
    function editar_grupo_trabajo($id_grupo_trabajo, $nombre_grupo, $estado)
    {
        $sql = "UPDATE grupos_trabajos SET nombre_grupo='$nombre_grupo', estado='$estado' WHERE id_grupo_trabajo = '$id_grupo_trabajo'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }

    /**
     * @param number $id_grupo_trabajo identificador del grupo que será mostrado
     * @return object $resultado respuesta de la base de datos
     */
    function cargar_grupo($id_grupo_trabajo)
    {
        $sql = "SELECT * FROM grupos_trabajos WHERE id_grupo_trabajo='$id_grupo_trabajo' ";
        $resultado = $this->CONEXION->query($sql);
        $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        return $respuesta;
    }
}
