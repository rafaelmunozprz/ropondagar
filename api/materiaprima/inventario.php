<?php

use App\Models\{Nota_p, StockMaP};

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */
$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'registrar_stock':
        $id_nota    = isset($_POST['id_nota'])    && !empty($_POST['id_nota'])     ? (int)$_POST['id_nota'] : false;
        $id_materia = isset($_POST['id_materia']) && !empty($_POST['id_materia'])  ? (int)$_POST['id_materia'] : false;
        $tipo       = isset($_POST['tipo'])       && !empty($_POST['tipo'])        ? htmlspecialchars($_POST['tipo']) : false;
        $solo_uno   = isset($_POST['solo_uno'])   && !empty($_POST['solo_uno'])    ? true : false;

        $NOTE = new Nota_p();
        $MATERIA = new StockMaP();

        if ($nota = $NOTE->mostrar_nota($id_nota)) {

            $productos = $nota['productos'] = json_decode($nota['productos'], true); //DECODIFICA LOS PRODUCTOS 

            /**Agregar productos */
            $actualizacion = false;
            $p_in_stock = 0; // productos en stock
            if ($productos) {
                /**BUSCA EL NOMBRE Y DATOS DE EL MATERIAL DE LA NOTA */
                foreach ($productos as $i_prod => $producto) {
                    $id_stock = !empty($producto['id_stock']) ? (int)$producto['id_stock'] : false;
                    $stock = $MATERIA->mostrar_materia_stock($id_stock);

                    if (((($producto['id'] == $id_materia) && ($producto['tipo'] == $tipo)) || ($solo_uno === false)) && (empty($producto['id_stock']) || !$stock)) {
                        /**
                         * primero compara si el id de la materia prima y el tipo estan correctos
                         * En caso de que no sean correctos el sistema verificará el tipo de carga, si la nota se cargara al mismo tiempo todo
                         * verifica que exista en stock sino, reara el registro
                         */
                        $materia_prima = $MATERIA->mostrar_materia($producto['id']); //AGREGA LA DATA){

                        $id_materia_prima = $producto['id'];
                        $id_proveedor = $nota['id_proveedor'];
                        $id_usuario = $USERSYSTEM['idUsuario'];
                        $cantidad = $producto['cantidad'];
                        $precio_compra = $producto['precio_compra'];
                        $precio_menudeo = $producto['precio_menudeo'];
                        $precio_mayoreo = $producto['precio_mayoreo'];
                        $codigo_materia = strtoupper(uniqid($materia_prima['codigo'] . "-", false)); //Genera un código unico en base al c+odigo primario establecido para la materia prima
                        $id_nota_proveedor = $id_nota;

                        $id_stock = $MATERIA->registrar_materia($id_materia_prima, $id_proveedor, $id_usuario, $cantidad, $precio_compra, $precio_menudeo, $precio_mayoreo, $codigo_materia, $id_nota_proveedor);
                        if ($id_stock) {
                            $productos[$i_prod]['id_stock'] = $id_stock;
                            $actualizacion = true;
                        }
                        // if ($solo_uno) break;
                    }

                    if (!empty($productos[$i_prod]['id_stock'])) $p_in_stock++;
                }
            }

            if ($actualizacion) {
                $NOTE->stock = ($p_in_stock == $nota['cantidad_productos'] ? 'si' : 'no');
                $NOTE->productos = json_encode($productos, JSON_UNESCAPED_UNICODE);
                $actualizacion  = $NOTE->actualizar($id_nota);
            }
            /**Agregar productos */


            if ($actualizacion) {
                $respuesta = [
                    'status' => true,
                    'response' => 'success',
                    'text' => 'La nota fue actualizada de forma correcta',
                ];
            } else {
                $respuesta = [
                    'status' => false,
                    'response' => 'error',
                    'text' => 'No se realizó actualización, revisa que los productos aún se encuentren en el sistema o no se hayan registrado antes.'
                ];
            }
        } else {
            $respuesta = [
                'status' => false,
                'response' => 'error',
                'text' => 'Ocurrio un error al consultar la nota'
            ];
        }
        echo json_encode($respuesta);
        break;

    default:
        echo json_encode($respuesta);
        break;
}
