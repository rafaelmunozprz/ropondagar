<?php

namespace App\Models;

use App\Config\Config;

class Notificacion
{
    private $CONEXION = false;

    public $id_usuario = false;
    public $limite = 8;
    public $pagina = 1;
    public $buscar = '';

    public $total = 0;

    public $config = [
        'icons' => [
            'factura'       => "fas fa-clipboard",
            'factura_lite'  => "far fa-clipboard",
            'venta'         => "fas fa-cash-register",
            'pago'          => "fas fa-money-bill-alt",
        ],
        'color' => [
            'success' => 'text-success',
            'warning' => 'text-warning',
            'danger' => 'bg-danger',
            'default' => 'bg-info',
        ],
        'bg_color' => [
            'success' => 'bg-success',
            'warning' => 'bg-warning',
            'danger' => 'bg-danger',
            'default' => 'bg-info',
        ],
    ];

    function __construct()
    {
        $conf =  new Config();
        $this->CONEXION = $conf->getConexion();
    }

    function mostrar_notificacion($id = false)
    {
        $busqueda = $this->buscar;

        $pagina = $this->pagina >= 1 ? $this->pagina - 1 : 0;
        $limite = $this->limite;
        $pagina = $pagina * $limite;

        $filtro = "";
        $filtro .= ($id) ? " AND N.id_notificacion = $id " : "";
        $usuario = ($id_usuario = $this->id_usuario) ? " AND N.vistas LIKE '%id_usuario_:_$id_usuario%'" : "";


        $sql = "SELECT * FROM notificaciones AS N WHERE N.estado != 'eliminado' $filtro 
                    ORDER BY N.fecha DESC 
                    LIMIT $pagina,$limite";
        $sql_total = "SELECT COUNT(*) as total FROM notificaciones AS N WHERE N.estado != 'eliminado'
                        $filtro $usuario";
        $respuesta_total = $this->CONEXION->query($sql_total);
        $this->total = (($respuesta_total && $respuesta_total->num_rows) ? (int)$respuesta_total->fetch_assoc()['total'] : 0);

        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $respuesta->num_rows) ? $respuesta : false);
    }

    function actualizar_notificacion($id, $vistas)
    {
        $sql = "UPDATE notificaciones SET visto='$vistas' WHERE id_notificacion=$id";
        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $this->CONEXION->affected_rows) ? $respuesta : false);
    }

    function crear_notificacion($id_usuario, $titulo, $cuerpo, $color, $config)
    {

        $sql = "INSERT INTO notificaciones(id_usuario, titulo, cuerpo, color, config) VALUES ('$id_usuario' ,'$titulo' ,'$cuerpo' ,'$color' ,'$config')";

        $respuesta = $this->CONEXION->query($sql);
        return (($respuesta && $this->CONEXION->insert_id) ? $this->CONEXION->insert_id : false);
    }
}
