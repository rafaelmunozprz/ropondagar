<?php

namespace App\Models;

use App\Config\Config;

class Modelos
{
    protected $CONEXION  = false;

    var $id_modelo = false;
    var $nombre = false;
    var $codigo = false;
    var $color = false;
    var $talla = false;
    var $tipo = false;
    var $sexo = false;
    var $codigo_completo = false;
    var $materia_prima = false;
    var $codigo_fiscal = false;
    /**Paginacion */
    var $buscar = "";
    var $limite = 9;
    var $pagina = 1;

    var $total_modelos = 0; //resultado para paginacion
    var $total_movimientos = 0;
    /**Paginacion */
    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }

    /**
     *  @param number $id_modelo
     */
    function modelo_activado($id_modelo)
    {
        $sql = "UPDATE modelos SET eliminacion_definitiva='false' WHERE id_modelo = $id_modelo";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }

    /**
     * 
     */
    function traer_historial_treinta_dias($buscar)
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND m.codigo LIKE '%$buscar%' AND lm.fecha BETWEEN CURDATE()-30 AND CURDATE() ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    function traer_historial_treinta_dias_todo()
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND lm.fecha BETWEEN CURDATE()-30 AND CURDATE() ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @return object
     */
    function mostrar_historial_siete_dias_todo()
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND lm.fecha BETWEEN CURDATE()-7 AND CURDATE() ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param string $buscar
     * @return object
     */
    function traer_historial_siete_dias($buscar)
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND m.codigo LIKE '%$buscar%' AND lm.fecha BETWEEN CURDATE()-7 AND CURDATE() ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @return object
     */
    function mostrar_historial_ayer_todo()
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND fecha=(CURDATE()-1) ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param string $buscar
     * @return object
     */
    function traer_historial_ayer($buscar)
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND m.codigo LIKE '%$buscar%' AND fecha=(CURDATE()-1) ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param string $buscar codigo del por item con coincidencias para el dia en turno
     */
    function traer_historial_hoy($buscar)
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND m.codigo LIKE '%$buscar%' AND fecha=CURDATE() ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param object respueta con todas las coincidencias de los moviemientos del dia en turno
     */
    function mostrar_historial_hoy_todo()
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND fecha=CURDATE() ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param object objeto con la respuesta que muestra todas las coincidencias de movimientos para dia en turno
     */
    function mostrar_historial_todo()
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    /**
     * @param string $buscar un producto por código
     * @return object
     */
    function traer_historial_siempre($buscar)
    {
        $SQL = "SELECT lm.*, m.codigo, u.nombre, u.apellidos FROM logs_movimientos AS lm INNER JOIN modelos AS m ON lm.id_modelo=m.id_modelo INNER JOIN usuarios AS u ON u.id_usuario=lm.id_usuario AND m.codigo LIKE '%$buscar%' ORDER BY lm.id_movimiento DESC";
        $resultado = $this->CONEXION->query($SQL);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }

    function disminuir($id_modelo, $disminuir_stock)
    {
        $viejo_stock = $this->revisar_stock($id_modelo);
        $stock = $viejo_stock['cantidad'];

        $stock = $stock - $disminuir_stock;
        if ($stock < 0)
            return false;
        else {
            $sql = "UPDATE stock_maquilas SET cantidad=$stock WHERE id_modelo = '$id_modelo'";
            $resultado = $this->CONEXION->query($sql);
            $SQL = "INSERT INTO logs_movimientos (id_usuario, id_modelo, fecha, cantidad, tipo_movimiento) VALUES (4, $id_modelo, CURDATE(), $disminuir_stock,'reduccion_maquila')";
            $res = $this->CONEXION->query($SQL);
            return ($resultado && $this->CONEXION->affected_rows ? true : false);
        }
    }
    function ajuste($id_modelo, $inversion, $precio_mayoreo, $precio_menudeo)
    {
        $sql = "SELECT id_modelo FROM stock_maquilas WHERE id_modelo = '$id_modelo'";
        $resultado = $this->CONEXION->query($sql);
        if ($resultado->num_rows == 0) {
            $sql = "INSERT INTO stock_maquilas(id_modelo, id_orden_cuerpo, id_usuario, cantidad, cantidad_vendida, costo, precio_mayoreo, precio_menudeo, codigo_maquila, historico_venta, codigo_final) VALUES ($id_modelo, 1, 4, 0, 0, $inversion, $precio_mayoreo, $precio_menudeo, 1, '', '')";
            $resultado = $this->CONEXION->query($sql);
            $respuesta = ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
        } else {
            $sql = "UPDATE stock_maquilas SET costo=$inversion, precio_mayoreo=$precio_mayoreo, precio_menudeo=$precio_menudeo WHERE id_modelo = '$id_modelo'";
            $resultado = $this->CONEXION->query($sql);
            $respuesta = ($resultado && $this->CONEXION->affected_rows ? true : false);
        }
        return $respuesta;
    }
    function cargar_precios_viejos($id_modelo)
    {
        $sql = "SELECT costo, precio_mayoreo, precio_menudeo FROM stock_maquilas WHERE id_modelo = '$id_modelo'";
        $resultado = $this->CONEXION->query($sql);
        if ($resultado->num_rows == 0) {
            $sql = "INSERT INTO stock_maquilas(id_modelo, id_orden_cuerpo, id_usuario, cantidad, cantidad_vendida, costo, precio_mayoreo, precio_menudeo, codigo_maquila, historico_venta, codigo_final) VALUES ($id_modelo, 1, 4, 0, 0, 0, 0, 0, 1, '', '')";
            $resultado = $this->CONEXION->query($sql);
            $sql = "SELECT costo, precio_mayoreo, precio_menudeo FROM stock_maquilas WHERE id_modelo = '$id_modelo'";
            $resultado = $this->CONEXION->query($sql);
            $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        } else {
            $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        }
        return $respuesta;
    }
    function revisar_stock($id_modelo)
    {
        $sql = "SELECT cantidad FROM stock_maquilas WHERE id_modelo = '$id_modelo'";
        $resultado = $this->CONEXION->query($sql);
        if ($resultado->num_rows == 0) {
            $sql = "INSERT INTO stock_maquilas(id_modelo, id_orden_cuerpo, id_usuario, cantidad, cantidad_vendida, costo, precio_mayoreo, precio_menudeo, codigo_maquila, historico_venta, codigo_final) VALUES ($id_modelo, 1, 4, 0, 0, 0, 0, 0, 1, '', '')";
            $resultado = $this->CONEXION->query($sql);
            $sql = "SELECT cantidad FROM stock_maquilas WHERE id_modelo = '$id_modelo'";
            $resultado = $this->CONEXION->query($sql);
            $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        } else {
            $respuesta =  ($resultado && $resultado->num_rows) ? $resultado->fetch_assoc() : false;
        }
        return $respuesta;
    }
    function agregar_stock($id_modelo, $nuevo_stock)
    {
        $stock = $nuevo_stock;
        $viejo_stock = $this->revisar_stock($id_modelo);
        $nuevo_stock = $nuevo_stock + $viejo_stock['cantidad'];
        $sql = "UPDATE stock_maquilas SET cantidad=$nuevo_stock WHERE id_modelo = '$id_modelo'";
        $resultado = $this->CONEXION->query($sql);
        $SQL = "INSERT INTO logs_movimientos (id_usuario, id_modelo, fecha, cantidad, tipo_movimiento) VALUES (4, $id_modelo, CURDATE(), $stock,'aumento_maquila')";
        $res = $this->CONEXION->query($SQL);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function crear_modelo($nombre, $codigo, $color, $talla, $tipo, $sexo, $materia_prima, $codigo_completo, $codigo_fiscal = "", $categoria)
    {
        $sql = "INSERT INTO modelos(nombre, codigo, color, talla, tipo, sexo, codigo_completo, materia_prima, codigo_antiguo, eliminacion_definitiva,codigo_fiscal, id_categoria) VALUES ('$nombre', '$codigo', '$color', '$talla', '$tipo', '$sexo', '$codigo_completo','$materia_prima', '$codigo', 'false','$codigo_fiscal', $categoria)";
        $resultado = $this->CONEXION->query($sql);
        $id_modelo = $this->CONEXION->insert_id;
        //print_r($id_modelo);
        if ($this->CONEXION->insert_id) {
            $hoy = date("Y-m-d H:i:s");
            $SQL = "INSERT INTO stock_maquilas(id_modelo, id_orden_cuerpo, id_usuario, cantidad, cantidad_vendida, costo, precio_mayoreo, precio_menudeo, codigo_maquila, historico_venta, codigo_final, fecha) VALUES ($id_modelo, 1, 4, 0, 0, 0, 0, 0, 1, NULL, '$codigo', '$hoy')";
            $res = $this->CONEXION->query($SQL);
        }
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function modificar_modelo($id_modelo)
    {
        $update = "";
        $update .= $this->nombre ? "nombre = '$this->nombre'" : "";
        $update .= $this->codigo           ? ($update == "" ? "" : ",") . "codigo = '$this->codigo'" : "";
        $update .= $this->color            ? ($update == "" ? "" : ",") . "color = '$this->color'" : "";
        $update .= $this->talla            ? ($update == "" ? "" : ",") . "talla = '$this->talla'" : "";
        $update .= $this->tipo             ? ($update == "" ? "" : ",") . "tipo = '$this->tipo'" : "";
        $update .= $this->sexo             ? ($update == "" ? "" : ",") . "sexo = '$this->sexo'" : "";
        $update .= $this->codigo_completo  ? ($update == "" ? "" : ",") . "codigo_completo = '$this->codigo_completo'" : "";
        $update .= $this->materia_prima    ? ($update == "" ? "" : ",") . "materia_prima = '$this->materia_prima'" : "";
        $update .= $this->codigo_fiscal    ? ($update == "" ? "" : ",") . "codigo_fiscal = '$this->codigo_fiscal'" : "";

        $sql = "UPDATE modelos SET $update WHERE id_modelo = $id_modelo";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function eliminar_modelo($id_modelo)
    {
        $sql = "UPDATE modelos SET eliminacion_definitiva='true' WHERE id_modelo=$id_modelo";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? true : false);
    }
    function mostrar_modelo_por_codigo($codigo)
    {
        $sql = "SELECT * FROM modelos INNER JOIN stock_maquilas ON stock_maquilas.id_modelo = modelos.id_modelo AND modelos.codigo = '$codigo'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }

    /**
     * @param number $id_modelo
     */
    function mostrar_modelo_desactivado($id_modelo)
    {
        $sql = "SELECT * FROM modelos WHERE id_modelo LIKE '$id_modelo%' AND estado_eliminacion='true'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }

    /**
     * @param number $id_modelo 
     * @return object $resultado
     */
    function mostrar_modelo($id_modelo)
    {
        $sql = "SELECT * FROM modelos WHERE id_modelo LIKE '$id_modelo%'";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }

    /**
     * 
     */
    function mostrar_modelos_desactivados()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';

        if ($buscar) $filtro = " AND (M.nombre LIKE '%$buscar%' OR M.codigo LIKE '%$buscar%' OR M.color LIKE '%$buscar%' OR M.tipo LIKE '%$buscar%' OR M.sexo LIKE '%$buscar%')  ";

        $this->total_modelos = $this->contar_modelos($filtro);
        $sql = "SELECT M.*, S.* FROM modelos AS M, stock_maquilas AS S  WHERE eliminacion_definitiva='true' AND M.id_modelo=S.id_modelo $filtro LIMIT $pagina,$limite";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function mostrar_modelos()
    {
        $limite = $this->limite;
        $pagina = ($this->pagina > 1 ? ($this->pagina - 1) * $limite : 0);
        $buscar = $this->buscar;
        $filtro = '';

        if ($buscar) $filtro = " AND (M.nombre LIKE '%$buscar%' OR M.codigo LIKE '%$buscar%' OR M.color LIKE '%$buscar%' OR M.tipo LIKE '%$buscar%' OR M.sexo LIKE '%$buscar%')  ";

        $this->total_modelos = $this->contar_modelos($filtro);
        $sql = "SELECT M.*, S.* FROM modelos AS M, stock_maquilas AS S  WHERE eliminacion_definitiva='false' AND M.id_modelo=S.id_modelo $filtro LIMIT $pagina,$limite";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    private function contar_modelos($filtro = "")
    {
        $sql = "SELECT COUNT(*) AS total FROM modelos AS M  $filtro";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc()['total'] : false);
    }
    function total_modelos()
    {
        return $this->total_modelos;
    }

    function total_movimientos()
    {
        return $this->total_movimientos;
    }
    function galeria_modelo($id_modelo, $estado = false)
    {
        $sql = "SELECT * FROM galeria_modelo WHERE id_modelo = $id_modelo ORDER BY fecha DESC";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado : false);
    }
    function actualizar_foto($id_imagen, $estado = 'activo', $imagen = false)
    {
        $imagen = $imagen ? ",imagen='$imagen'" : "";
        $sql = "UPDATE galeria_modelo SET  estado='$estado' $imagen WHERE id_galeria_modelo= $id_imagen";

        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->affected_rows ? $this->CONEXION->affected_rows : false);
    }
    function agregar_foto($id_modelo, $imagen)
    {
        $sql = "INSERT INTO galeria_modelo(id_modelo, imagen, estado) VALUES ($id_modelo,'$imagen','activo')";

        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $this->CONEXION->insert_id ? $this->CONEXION->insert_id : false);
    }
    function mostrar_imagen_modelo($id_modelo, $id_imagen)
    {
        $sql = "SELECT * FROM galeria_modelo WHERE id_modelo = $id_modelo AND id_galeria_modelo = $id_imagen";
        $resultado = $this->CONEXION->query($sql);
        return ($resultado && $resultado->num_rows ? $resultado->fetch_assoc() : false);
    }
}
