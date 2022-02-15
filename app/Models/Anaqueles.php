<?php

namespace App\Models;

use App\Config\Config;
use DateTime;

class Anaqueles
{
    var $id_anaquel = false;
    var $codigo_anaquel = false;
    var $anaquel = false;
    var $historico = false;
    var $fecha = false;
    var $id_usuario = false;

    /**Paginacion */
    var $buscar = "";
    var $limite = 8;
    var $pagina = 1;
    /**Paginacion */
    private $total_anaqueles = 0;

    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }
    function comprobar_ocupado($codigo_anaquel)
    {
        $sql = "SELECT anaquel FROM anaqueles WHERE codigo_anaquel='$codigo_anaquel'";
        $resultado = $this->CONEXION->query($sql);
        $resultado = $resultado->fetch_assoc();
        $resultadoDECODE = json_decode($resultado['anaquel'], true);
        $resultado = false;
        foreach ($resultadoDECODE as $key => $value) {
            //if($value['productos'])
            //print_r(count($value['productos'])>0);
            if (count($value['productos']) > 0) {
                $resultado = true;
            }
            break;
        }
        return $resultado;
    }
    function cargar_dimensiones($codigo_anaquel)
    {
        $cod = $codigo_anaquel;
        $sql = "SELECT tamano FROM anaqueles WHERE codigo_anaquel='$cod'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado ? $resultado : false);
    }
    function modificar_anaquel($codigo_anaquel, $tamano)
    {
        return true;
    }
    function mostrar_anaqueles()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);;
        $filtro = '';
        if ($buscar = $this->buscar) $filtro = " AND codigo_anaquel LIKE '%$buscar%'  ";
        $this->total_anaqueles = $this->contar_anaqueles($filtro);
        $sql = "SELECT * FROM anaqueles WHERE eliminacion_definitiva='false' $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function mostrar_grid($codigo)
    {
        $cod = $codigo;
        $sql = "SELECT * FROM anaqueles WHERE codigo_anaquel='$cod'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado ? $resultado : false);
    }
    function contar_anaqueles($filtro = "")
    {

        $sql = "SELECT COUNT(*) AS total FROM anaqueles $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function eliminar_anaquel($codigo_anaquel)
    {
        $sql = "UPDATE anaqueles SET eliminacion_definitiva='true' WHERE codigo_anaquel='$codigo_anaquel'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado ? $resultado : false);
    }
    function total_anaqueles()
    {
        return $this->total_anaqueles;
    }
    function crear_anaquel($tamano, $id_usuario)
    {
        $dimensiones = explode(',', $tamano);
        $filas = $dimensiones[0];
        $columnas = $dimensiones[1];
        $arregloAnaquel = [];
        $objetoAnaquel = array("id_anaquel" => "", "fila" => "", "columna" => "", "productos" => []);
        $codigo_anaquel = "ANA" . uniqid();
        for ($fila = 0; $fila < $filas; $fila++) {
            for ($columna = 0; $columna < $columnas; $columna++) {
                $objetoAnaquel['id_anaquel'] = 'F' . ($fila + 1) . 'C' . ($columna + 1) . '-' . $codigo_anaquel;
                $objetoAnaquel['fila'] = $fila + 1;
                $objetoAnaquel['columna'] = $columna + 1;
                array_push($arregloAnaquel, $objetoAnaquel);
            }
        }
        $objeto = json_encode($arregloAnaquel);
        $sql = "INSERT INTO anaqueles (codigo_anaquel,tamano,anaquel,id_usuario) VALUES ('" . $codigo_anaquel . "','" . $tamano . "','" . $objeto . "', $id_usuario)";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function redimensionar_anaquel($codigo_anaquel, $nuevas_filas, $nuevas_columnas)
    {
        /**
         * TRAEMOS LA MEDIDA ANTERIOR
         */
        $sql = "SELECT tamano, anaquel FROM anaqueles WHERE codigo_anaquel='$codigo_anaquel'";
        $resultado = $this->CONEXION->query($sql);
        $resultado = $resultado->fetch_assoc();
        $viejo_tamano = $resultado['tamano'];
        $anaquel_viejo = json_decode($resultado['anaquel'], true);
        $nuevo_tamano = $nuevas_filas . ',' . $nuevas_columnas;
        $arregloAnaquelNuevo = [];
        $objetoAnaquel = array("id_anaquel" => "", "fila" => "", "columna" => "", "productos" => []);
        for ($i = 0; $i < $nuevas_filas; $i++) {
            for ($j = 0; $j < $nuevas_columnas; $j++) {
                $objetoAnaquel['id_anaquel'] = 'F' . ($i + 1) . 'C' . ($j + 1) . '-' . $codigo_anaquel;
                $objetoAnaquel['fila'] = $i + 1;
                $objetoAnaquel['columna'] = $j + 1;
                array_push($arregloAnaquelNuevo, $objetoAnaquel);
            }
        }
        for ($posicionNuevo = 0; $posicionNuevo < count($arregloAnaquelNuevo); $posicionNuevo++) {
            for ($posicionViejo = 0; $posicionViejo < count($anaquel_viejo); $posicionViejo++) {
                if ($anaquel_viejo[$posicionViejo]['id_anaquel'] == $arregloAnaquelNuevo[$posicionNuevo]['id_anaquel']) {
                    $arregloAnaquelNuevo[$posicionNuevo] = $anaquel_viejo[$posicionViejo];
                }
            }
        }
        $arregloAnaquelNuevoENCODE = json_encode($arregloAnaquelNuevo);

        $sql = "UPDATE anaqueles SET tamano='$nuevo_tamano', anaquel='$arregloAnaquelNuevoENCODE' WHERE codigo_anaquel='$codigo_anaquel'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado ? $resultado : false);
    }
    function mostrar_materia($posicion, $codigo_anaquel)
    {
        $cod = $codigo_anaquel;
        $sql = "SELECT anaquel FROM anaqueles WHERE codigo_anaquel='$cod'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado ? $resultado : false);
    }
    function guardar_articulo($cantidad, $codigo_materia, $espacio)
    {
        $nombre = explode('-', $espacio);
        $sql = "SELECT anaquel FROM anaqueles WHERE codigo_anaquel='$nombre[1]'";
        $resultado = $this->CONEXION->query($sql);
        $resultado = $resultado->fetch_assoc();
        $resultadoJSON = json_decode($resultado['anaquel'], true);
        $nuevo_producto = array("id_transaccion" => "", "id_nota" => "", "id_producto" => "", "codigo" => "", "cantidad_disponible" => "", "cantidad_inicial" => "", "fecha_entrada" => "", "fecha_terminado" => "");
        for ($i = 0; $i < count($resultadoJSON); $i++) {
            if ($resultadoJSON[$i]['id_anaquel'] == $espacio) {
                $nuevo_producto['id_transaccion'] = uniqid();
                $nuevo_producto['id_nota'] = '1';
                $nuevo_producto['id_producto'] = 1;
                $nuevo_producto['codigo'] = $codigo_materia;
                $nuevo_producto['cantidad_disponible'] = $cantidad;
                $nuevo_producto['cantidad_inicial'] = $cantidad;
                $nuevo_producto['fecha_entrada'] = date("Y-m-d");
                $nuevo_producto['fecha_terminado'] = "";
                array_push($resultadoJSON[$i]['productos'], $nuevo_producto);
            }
        }
        $resultadoDECODE = json_encode($resultadoJSON);
        $sql = "UPDATE anaqueles SET anaquel='" . $resultadoDECODE . "' WHERE codigo_anaquel='$nombre[1]'";
        $resultado = $this->CONEXION->query($sql);
        //print_r($resultado);
        return ($resultado ? $resultado : false);
    }
}
