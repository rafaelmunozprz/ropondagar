<?php

namespace App\Facturacion;

use App\Config\Config;

class Facturacion
{
    private $config_sandbox = [
        'correo' => 'ing.leonardovaz@gmail.com',
        'usuario' => 'pruebag17',
        'password' => '123456',
        'codigo_empresa' => 'E0001',
        'options' => array('trace' => 1, 'exceptions' => true, "connection_timeout" => 580),
        'link_timbrado' => 'http://g17.opravymx.com/ws/cfdi/opravycfdi.asmx?WSDL',

    ];
    private $config = [
        'correo' => 'ing.leonardovaz@gmail.com',
        'usuario' => 'pruebag17',
        'password' => '123456',
        'codigo_empresa' => 'E0001',
        'options' => array('trace' => 1, 'exceptions' => true, "connection_timeout" => 580),
        'link_timbrado' => 'http://g17.opravymx.com/ws/cfdi/opravycfdi.asmx?WSDL',

    ];
    private $sandbox = true;

    function getConfig()
    {
        return ($this->sandbox ? $this->config_sandbox : $this->config);
    }

    function extract_zip_cfdi($folio, $public_dir)
    {
        require_once "Extraer_zip.php";
        /**
         * devuelve 
         * [
         *  'status'=>true | false
         *  'response' => success | error
         *  'text'=> string
         *   ///(Solo si status ===true)
         *      data => [tipo_file,route_file]  xml y pdf
         * ]
         *              ]
         */
        return Zip_extract::extract_cfdi($folio, $public_dir);
    }

    static function save_factura($id_nota, $uuid, $archivos, $config, $estado = "activa")
    {
        $CON = new Config();
        $conexion = $CON->getConexion();
        $sql = "INSERT INTO facturacion_venta (id_nota,uuid_nota,archivos,nota_datos,estado) VALUES ('$id_nota', '$uuid', '$archivos','$config','$estado');";
        $resultado = $conexion->query($sql);
        return (($resultado && $conexion->insert_id) ? $conexion->insert_id : false);
    }
    static function update_factura($id, $id_nota = false, $uuid = false, $archivos = false, $config = false, $estado = false)
    {
        $CON = new Config();
        $conexion = $CON->getConexion();


        $sql = "INSERT INTO facturacion_venta (id_nota,uuid_nota,archivos,nota_datos,estado) VALUES ('$id_nota', '$uuid', '$archivos','$config','$estado');";
        $resultado = $conexion->query($sql);
        return (($resultado && $conexion->insert_id) ? $conexion->insert_id : false);
    }
    static function mostrar_factura($folio)
    {
        $CON = new Config();
        $conexion = $CON->getConexion();

        $sql = "SELECT * FROM facturacion_venta WHERE uuid_nota = $folio;";
        $resultado = $conexion->query($sql);
        return (($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false);
    }
}
