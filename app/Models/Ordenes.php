<?php

namespace App\Models;

use App\Config\Config;

class Ordenes
{
    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;

    var $total_ordenes = false;
    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }

    /**
     * 
     */
    function mostrar_orden_finalizada($buscar)
    {
        $SQL = "SELECT * FROM ordenes WHERE estado!='0_espera' AND estado!='17_finalizado' AND uuid='$buscar'";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
    }

    /**
     * @return object resultado de todas las órdenes finalizadas
     */
    function mostrar_ordenes_finalizadas()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        if ($buscar) {
            $filtro = " AND (uuid LIKE '%$buscar%' )";
        }
        $this->total_ordenes = $this->total_ordenes();
        $sql = "SELECT * FROM ordenes WHERE estado='19_finalizado' ORDER BY fecha LIMIT $pagina,$limite ";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function avanzar_estado($uuid, $siguiente_estado)
    {
        $UPDATE = "UPDATE ordenes SET estado='$siguiente_estado' WHERE uuid='$uuid'";
        $resultado = $this->CONEXION->query($UPDATE);
        return (($resultado && $this->CONEXION->affected_rows) ? $resultado : false);
    }
    function total_ordenes()
    {
        $sql = "SELECT COUNT(*) AS total FROM ordenes WHERE estado!='0_espera' AND estado!='19_finalizado'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function mostrar_ordenes_produccion()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';
        if ($buscar) {
            $filtro = " AND (uuid LIKE '%$buscar%' )";
        }
        $this->total_ordenes = $this->total_ordenes();
        $sql = "SELECT * FROM ordenes WHERE estado!='0_espera' AND estado!='19_finalizado' ORDER BY fecha LIMIT $pagina,$limite ";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function mostrar_orden_produccion($buscar)
    {
        $SQL = "SELECT * FROM ordenes WHERE estado!='0_espera' AND estado!='19_finalizado' AND uuid='$buscar'";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
    }
    function iniciar_proceso_maquila($uuid)
    {
        $SQL_UPDATE = "UPDATE ordenes SET estado='1_inicio_preparacion' WHERE uuid='$uuid'";
        $resultado = $this->CONEXION->query($SQL_UPDATE);
        return (($resultado && $this->CONEXION->affected_rows) ? $resultado : false);
    }
    function cargar_detalle_orden($uuid)
    {
        $SQL = "SELECT OC.id_orden_cuerpo, OC.id_modelo, OC.cantidad, OC.uuid_orden, M.codigo FROM ordenes_cuerpo AS OC, modelos AS M WHERE uuid_orden='$uuid' AND M.id_modelo=OC.id_modelo";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function eliminar_ordenes_espera($uuid)
    {
        $SQL = "DELETE FROM ordenes_cuerpo WHERE uuid_orden='$uuid'";
        $resultado = $this->CONEXION->query($SQL);
        $SQL = "DELETE FROM ordenes WHERE uuid='$uuid'";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado ? $resultado : false);
    }
    function mostrar_ordenes_espera()
    {
        $SQL = "SELECT * FROM ordenes WHERE estado='0_espera'";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function crear_orden_nueva($orden)
    {   
        
        $hoy = date('Y-m-d H:i:s');
        $historial_cambios = [
            '0_espera' => $hoy,
            '1_inicio_preparacion' => '',
            '2_fin_preparacion' => '',
            '3_inicio_corte' => '',
            '4_fin_corte' => '',
            '5_inicio_prebordado' => '',
            '6_fin_prebordado' => '',
            '7_inicio_bordado' => '',
            '8_fin_bordado' => '',
            '9_inicio_maquila' => '',
            '10_fin_maquila' => '',
            '11_inicio_ojal_y_boton' => '',
            '12_fin_ojal_y_boton' => '',
            '13_inicio_deshebre' => '',
            '14_fin_deshebre' => '',
            '15_inicio_planchado' => '',
            '16_fin_planchado' => '',
            '17_inicio_terminado' => '',
            '18_fin_terminado' => '',
            '19_finalizado' => ''
        ];
        $historial_cambios = json_encode($historial_cambios);
        $orden = json_decode($orden, true);
        $uuid = uniqid('', true);
        $uuid = explode('.', $uuid);
        $uuid = $uuid[1];
        $SQL_INSERT = "INSERT INTO ordenes (id_usuario, fecha, estado, uuid, historial_cambios) VALUES (4, '$hoy', '0_espera', '$uuid', '$historial_cambios')";
        $resultado = $this->CONEXION->query($SQL_INSERT);
        $id_orden = $this->CONEXION->insert_id;
        foreach ($orden as $articulo) {
            $id_modelo = $articulo['id_modelo'];
            $cantidad = $articulo['cantidad'];
            $SQL_INSERT = "INSERT INTO ordenes_cuerpo (id_modelo, id_orden, cantidad, fecha, estado, materia_prima_usada, uuid_orden) VALUES ($id_modelo, $id_orden, $cantidad, '$hoy', 'activo', '', '$uuid')";
            $resultado = $this->CONEXION->query($SQL_INSERT);
        }
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function mostrar_modelo($codigo)
    {
        $SQL = "SELECT M.codigo, M.color, M.id_modelo, M.nombre, M.sexo, M.talla, M.tipo FROM modelos as M WHERE codigo='$codigo'";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
}
