<?php

use App\Models\{ClienteNota, Clientes, Materiaprima, Modelos, Notificacion, StockMaP, StockModelos};

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */

// @request post: back/cliente/nota_venta

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada', $_POST
];

header('Content-type:application/json;charset=utf-8');

$permisos = ['mostrar', 'crear_nota', 'modificar_nota', 'enviar_nota_email', 'agregar_pago_nota', 'estadisticas', 'mostrar_nota', 'eliminar_pago', 'eliminar_nota'];

switch ($opcion) {
    case 'mostrar':
        $buscar         = (isset($_POST['buscar'])          && !empty($_POST['buscar'])         ? htmlspecialchars($_POST['buscar']) : false);
        $pagina         = (isset($_POST['pagina'])          && !empty($_POST['pagina'])         ? (int)$_POST['pagina'] : 1);
        $id_cliente     = (isset($_POST['id_cliente'])      && !empty($_POST['id_cliente'])     ? (int)$_POST['id_cliente'] : false);
        $limite         = (isset($_POST['limite'])          && !empty($_POST['limite'])         ? (int)$_POST['limite'] : 8);
        $estado         = (isset($_POST['estado'])          && !empty($_POST['estado'])         ? $_POST['estado'] : false);
        $fecha_inicio   = (isset($_POST['fecha_inicio'])    && !empty($_POST['fecha_inicio'])   ? $_POST['fecha_inicio'] : false);
        $fecha_limite   = (isset($_POST['fecha_limite'])    && !empty($_POST['fecha_limite'])   ? $_POST['fecha_limite'] : false);

        $CL = new Clientes();
        $NOTE_V = new ClienteNota();

        $NOTE_V->buscar = $buscar;
        $NOTE_V->pagina = $pagina;
        $NOTE_V->limite = $limite;


        /**OTROS FILTROS */
        $NOTE_V->id_cliente     = $id_cliente;
        $NOTE_V->estado         = $estado;
        $NOTE_V->fecha_inicio   = $fecha_inicio;
        $NOTE_V->fecha_limite   = $fecha_limite;
        /**OTROS FILTROS */
        $total = 0;
        if ($notas = $NOTE_V->mostrar_notas()) {
            $notas_data = [];
            while ($nota = $notas->fetch_assoc()) {
                $nota['productos'] = json_decode($nota['productos'], true);
                $nota['stock_historico'] = json_decode($nota['stock_historico'], true);
                $nota['datos_cliente_general'] = json_decode($nota['datos_cliente_general'], true);

                $nota['cliente'] = $CL->mostrar_cliente($nota['id_cliente']);
                $nota['pagos'] = $NOTE_V->mostrar_pagos($nota['id_nota_cliente']);
                $notas_data[] = $nota;
            }
            $respuesta = [
                'response' => 'success',
                'text' => 'El modelo se encontro',
                'data' => $notas_data,
            ];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
        }

        $respuesta['pagination'] = [
            "page" => $pagina,
            "limit" => $limite,
            "total" => (int)$NOTE_V->total_notas,
        ];

        echo json_encode($respuesta);
        break;
    case 'crear_nota':
        $nota        = (isset($_POST['nota'])    && !empty($_POST['nota'])    ? json_decode($_POST['nota'], true) : false);
        $iva         = false;

        $id_usuario = $USERSYSTEM['idUsuario'];
        if ($nota) {
            $descuento = $nota['descuentos'];
            $cliente = $nota['usuario'];
            $productos = $nota['productos'];

            $fecha = $nota['fecha'];
            $iva = ($nota['iva'] ? 1.16 : false);
            $PRIMA = new StockMaP();
            $MODEL = new StockModelos();
            $CL = new Clientes();
            $cliente = $CL->mostrar_cliente($cliente['id']);

            if ($productos) {
                $cantidad_productos = sizeof($productos);

                $continuar = ['status' => true, 'text' => '']; //Analisa el proceso de la nota
                /**
                 * validacion de existencia de todos los productos de la nota
                 */
                $new_productos = [];

                $total_prod = 0; //Total de la suma de los productos por unidad de la nota
                $total_costo = 0; //Total de nota con iva y descuento
                $sub_total = 0; //Total de nota sin descuentos ni iva
                $iva = $nota['iva'];
                foreach ($productos as $i_prod => $producto) {
                    $prod = false; //El producto aun no se ha encontrado
                    $PRIMA->id_materia = $producto['id'];
                    if ($producto['tipo'] == 'materia_prima') $prod = $PRIMA->mostrar_stock_materia();
                    else if ($producto['tipo'] == 'modelo') $prod = $MODEL->mostrar_stock_modelos($producto['id']);
                    $productos_final = [];

                    $total_prod += $producto['cantidad'];
                    $costo = ($producto['precio_venta'] * $producto['cantidad']);
                    $sub_total += $costo;

                    if ($prod) {
                        $prod = $prod->fetch_assoc();
                        $total = $prod['cantidad'] - $prod['vendido']; //Total Disponible
                        if ($total >= $producto['cantidad']) {
                            //Si la tantidad en stock es mayor o igual a la requerida continuar_nota
                            // var_dump($producto);
                            $new_prod = $producto; //Re asigna
                            unset($new_prod['data']); //Limpia la data
                            $new_productos[] = $new_prod; //Almacena en un array
                        } else {
                            $continuar = [
                                'status' => false, 'response' => 'error',
                                'text' => $prod['nombre'] . ', no cuenta con suficiente stock para continuar; ' . $total . ' disponibles ',
                            ];
                            break;
                        }
                    } else {
                        $continuar = [
                            'status' => false, 'response' => 'error',
                            'text' => $producto['data']['nombre'] . ', no cuenta con suficiente stock para continuar; 0 disponibles',
                        ];
                        break;
                    }
                }
                $tipo_descuento = ($descuento ? $descuento['tipo'] : "moneda"); //Tiene que venir en el arreglo del descuento {tipo:"",cantidad:0}
                $descuento      = ($descuento ? $descuento['cantidad'] : 0); //Tiene que venir en el arreglo del descuento {tipo:"",cantidad:0}
                $descuento  = ($tipo_descuento == 'moneda' ? $descuento : (($descuento / 100) * $sub_total)); //Descuento aplicado por el tipo de producto, esto solo afecta al precio final

                $total = (($sub_total - $descuento)); //La suma total menos el descuento

                $total = (($iva) ? $total * 1.16 : $total);
                $iva = ($iva ? 'si' : 'no');

                /**Fin de la validación, no continuar si esto arroja false */

                if ($continuar['status'] === false) {
                    die(json_encode($continuar));
                }
                /**Si todo esta bien, finalizar la nota :D */
                $NOTE_V = new ClienteNota();

                $new_productos = json_encode($new_productos, JSON_UNESCAPED_UNICODE);
                // productos, $cantidad_productos, $total_costo, $id_cliente, $id_usuario, $iva, $descuento, $tipo_descuento, $datos_cliente_general, $comentario
                if ($id_nota_venta = $NOTE_V->crear_nota($new_productos, $total_prod, $total, $cliente['id_cliente'], $USERSYSTEM['idUsuario'], $iva, $descuento, $tipo_descuento, json_encode($cliente, JSON_UNESCAPED_UNICODE), "")) {


                    $historico = [];
                    foreach ($productos as $i_prod => $producto) {

                        $prod = false; //El producto aun no se ha encontrado

                        if ($producto['tipo'] == 'materia_prima') $prod = $PRIMA->mostrar_stock($producto['id']);
                        else if ($producto['tipo'] == 'modelo') $prod = $MODEL->mostrar_stock_m($producto['id']);

                        $total = $producto['cantidad']; //Cantidad de productos

                        foreach ($prod as $un_prod) {

                            $prod_total = $un_prod['cantidad'] - $un_prod['vendido']; //Cantidad de productos en este registro

                            $id = ($producto['tipo'] == 'modelo' ? $un_prod['id_stock_maquila'] : $un_prod['id_stock_materia_prima']); //ID EN STOCK
                            $id_general = ($producto['tipo'] == 'modelo' ? $un_prod['id_modelo'] : $un_prod['id_materia_prima']); //ID MODELO O MATERIA Y ASI CANCELAR DE FORMA EFICIENTE

                            $cantidad_final = 0;

                            $retiro = [
                                "id" => $id,
                                "id_general" => $id_general,
                                "tipo" => $producto['tipo'], "venta" => $total,
                                "cancelado" => false
                            ]; //Controlador de actualizació

                            if ($prod_total >= $total) {
                                $retiro["venta"] = $total; //Total retirado de este elemento

                                $cantidad_final = ($un_prod['vendido'] + $total); //Cantidad a actualizar en stock
                                $total = 0; //Cantidad restante de mi producto de nota
                            } else {
                                $puedo_tomar = ($total - $prod_total); //Se calcula cuantos puede tomar de ese stock para que no haya conflictos para dar de baja productos

                                $retiro["venta"] = $puedo_tomar; //Total retirado de este elemento

                                $total = ($total - $prod_total); //Faltante
                                $cantidad_final = ($un_prod['vendido'] + $prod_total); //Cantidad final en ese stock
                            }



                            /** Historico venta stock */
                            $ventas = json_decode($un_prod['historico_venta'], true);

                            $historico_venta_stock = $ventas ? $ventas : [];
                            $historico_venta_stock[] = ["id" => $id_nota_venta, "tipo" => "venta", "cantidad" => $retiro['venta'], "cancelado" => false]; //Se debe de actualizar en la materia o modelo del stock

                            if ($producto['tipo'] == 'modelo') {
                                $MODEL = new StockModelos();
                                $MODEL->historico_venta = json_encode($historico_venta_stock, JSON_UNESCAPED_UNICODE); //ACTUALIZAR ESTO
                                $MODEL->cantidad_vendida = $cantidad_final;
                                $MODEL->modificar_stock_modelo($id);
                            } else {
                                $PRIMA = new StockMaP();
                                $PRIMA->id_stock_materia_prima = $id;
                                $PRIMA->historico_venta = json_encode($historico_venta_stock, JSON_UNESCAPED_UNICODE); //ACTUALIZAR ESTO
                                $PRIMA->cantidad_vendida = $cantidad_final;
                                $PRIMA->modificar_materia_stock(false, false);
                            }
                            /** END HISTORICO VENTA STOCK */

                            $historico[] = $retiro; //Se debe de guardar en la nota

                            if ($total == 0) break;
                        }

                        /** */
                    }

                    $NOTE_V->stock_historico = json_encode($historico, JSON_UNESCAPED_UNICODE);
                    $NOTE_V->modificar_nota($id_nota_venta);

                    $respuesta = [
                        'status' => true,
                        'response' => 'success',
                        'text' => 'La nota fue registrada de forma correcta',
                        'data' => ['id_nota' => $id_nota_venta]
                    ];

                    /**CREACIÓN DE NOTIFICACIONES */
                    /** NOTIFICACION */

                    $NTF = new Notificacion();
                    $opciones_ntf = $NTF->config;


                    $config = [
                        'bg_color' => $opciones_ntf['bg_color']['success'],
                        'color' => $opciones_ntf['color']['success'],
                        'icon' => $opciones_ntf['icons']['venta'],
                        'link' => 'sistema/ventas/notas/' . $id_nota_venta
                    ];
                    $config = json_encode($config, JSON_UNESCAPED_UNICODE);
                    $NTF->crear_notificacion($USERSYSTEM['idUsuario'], "NOTA", "Se genero una nueva nota de venta ", "success", $config);
                    /** NOTIFICACION */
                    /**FIN CREACIÓN DE NOTIFICACIONES */
                } else {
                    $respuesta = [
                        'response' => 'warning',
                        'text' => 'No fue posible terminar con el registro del nuevo modelo'
                    ];
                }
            }

            /** */
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'Completa los campos obligatorios'
            ];
        }

        echo json_encode($respuesta);
        break;

    case 'modificar_nota':
        $id_nota        = (isset($_POST['id_nota'])       && !empty($_POST['id_nota'])       ? $_POST['id_nota'] : false);
        $nombre           = (isset($_POST['nombre'])          && !empty($_POST['nombre'])          ? $_POST['nombre'] : false);
        $codigo           = (isset($_POST['codigo'])          && !empty($_POST['codigo'])          ? $_POST['codigo'] : false);
        $color            = (isset($_POST['color'])           && !empty($_POST['color'])           ? $_POST['color'] : false);
        $talla            = (isset($_POST['talla'])           && !empty($_POST['talla'])           ? $_POST['talla'] : false);
        $tipo             = (isset($_POST['tipo'])            && !empty($_POST['tipo'])            ? $_POST['tipo'] : false);
        $sexo             = (isset($_POST['sexo'])            && !empty($_POST['sexo'])            ? $_POST['sexo'] : false);
        $codigo_completo  = (isset($_POST['codigo_completo']) && !empty($_POST['codigo_completo']) ? $_POST['codigo_completo'] : false);
        $materia_prima    = (isset($_POST['materia_prima'])   && !empty($_POST['materia_prima'])   ? $_POST['materia_prima'] : false);

        $NOTE_V = new  ClienteNota();
        $modelo = $NOTE_V->mostrar_nota($id_nota);

        if ($modelo) {
            $NOTE_V->nombre          = $nombre;
            $NOTE_V->codigo          = $codigo;
            $NOTE_V->color           = $color;
            $NOTE_V->talla           = $talla;
            $NOTE_V->tipo            = $tipo;
            $NOTE_V->sexo            = $sexo;
            $NOTE_V->codigo_completo = $codigo_completo;
            $NOTE_V->materia_prima   = $materia_prima;

            if ($id = $NOTE_V->modificar_nota($id_nota)) $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al modelo'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el modelo, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;

    case 'agregar_pago_nota':
        $id_nota        = (isset($_POST['id_nota'])     && !empty($_POST['id_nota'])    ? $_POST['id_nota'] : false);
        $pago           = (isset($_POST['pago'])        && !empty($_POST['pago'])       ? floatval($_POST['pago']) : false);
        $tipo_pago      = (isset($_POST['tipo_pago'])   && !empty($_POST['tipo_pago'])  ? $_POST['tipo_pago'] : false);
        $comentario     = (isset($_POST['comentario'])  && !empty($_POST['comentario']) ? htmlspecialchars($_POST['comentario']) : false);
        $iva            = (isset($_POST['iva'])         && !empty($_POST['iva']) && $_POST['iva'] == 'si' ? 'si' : 'no');

        $finalizar      = (isset($_POST['finalizar'])   && !empty($_POST['finalizar'])  ? true : false);

        $id_usuario = $USERSYSTEM['idUsuario'];

        $NOTE_V = new ClienteNota();


        if ($nota = $NOTE_V->mostrar_nota($id_nota)) {
            $nota['productos'] = json_decode($nota['productos'], true);

            $total_costo   = floatval($nota['total_costo']);

            $total_pagado  = floatval($nota['total_pagado']);


            $deuda_total = round(($total_costo - $total_pagado), 2);


            $debera = round($total_costo - ($total_pagado + $pago));

            if ($nota['estado'] == 'pagado') {
                /** La nota ya se pago, no tienes nada que hacer pagando de más */
                $respuesta = [
                    'response' => 'error',
                    'text' => 'Tu nota ya se encuentra pagada',
                ];
                /** */
            } else if ($finalizar) {
                /**Si llega la orden de finalizar deberá de cumplir con las reglas, (OJO: Solamente llegará cuando se hagan pagos de una nota recien generada) */
                if ($total_costo == $pago) {
                    $NOTE_V->agregar_pago($id_nota, $pago, $id_usuario, $tipo_pago, $comentario, $iva);

                    $NOTE_V->total_pagado = $nota['total_costo'];
                    $NOTE_V->fecha_pago_total = date("Y-m-d H:m:s");
                    $NOTE_V->estado = "pagado";
                    $NOTE_V->modificar_nota($id_nota);
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'La nota se pago correctamente, puedes revisar el historial de notas en: Clientes  / Todas las notas',
                    ];
                } else {
                    $respuesta = [
                        'response' => 'error',
                        'text' => 'Solamente puedes hacer el pago total de la nota, si deceas agregar parcialidades ve a el apartado de 2 clientees  / Todas las notas',
                    ];
                }
            } else {
                if ($pago < $deuda_total) {
                    $NOTE_V->agregar_pago($id_nota, $pago, $id_usuario, $tipo_pago, $comentario, $iva);

                    $NOTE_V->total_pagado = ($total_pagado + $pago);
                    $NOTE_V->modificar_nota($id_nota);
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'La nota se pago correctamente, puedes revisar el historial de notas en: Clientes  / Todas las notas',
                    ];
                } else if ($pago == $deuda_total) {
                    $NOTE_V->agregar_pago($id_nota, $pago, $id_usuario, $tipo_pago, $comentario, $iva);
                    $NOTE_V->total_pagado = $nota['total_costo'];
                    $NOTE_V->fecha_pago_total = date("Y-m-d H:m:s");
                    $NOTE_V->estado = "pagado";
                    $NOTE_V->modificar_nota($id_nota);
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'La nota se pago correctamente, puedes revisar el historial de notas en: Clientes  / Todas las notas',
                    ];
                } else {
                    $respuesta = [
                        'response' => 'error',
                        'text' => 'Solamente puedes agregar pago menor al total o el total completo, falta pagar: $ ' . number_format($deuda_total, 2),
                    ];
                }
            }
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'Ocurrio un error al consultar la nota'];
        }

        echo json_encode($respuesta);
        break;
    case 'estadisticas':
        $id_cliente   = (isset($_POST['id_cliente'])    && !empty($_POST['id_cliente'])   ? (int)$_POST['id_cliente'] : false);
        $NOTE_V = new  ClienteNota();
        $NOTE_V->id_cliente = $id_cliente;
        $respuesta = [
            "response" => 'success',
            "text" => 'Envio de resultados',
            "data" => [
                "notas" => $NOTE_V->estadisticas_notas(),
                "pagos_nota" => $NOTE_V->estadisticas_pagos()
            ]
        ];

        echo json_encode($respuesta);

        break;
    case 'mostrar_nota':
        $id_nota        = isset($_POST['id_nota'])      && !empty($_POST['id_nota'])        ? (int)$_POST['id_nota'] : false;
        $traer_store    = isset($_POST['traer_store'])  && !empty($_POST['traer_store'])    ? true : false;

        $MATERIA = new Materiaprima();
        $MODEL = new Modelos();
        $STOCK_M_P = new StockMaP(); // STOCK DE MATERIA PRIMA
        $NOTE_V = new  ClienteNota();

        if ($nota_cliente = $NOTE_V->mostrar_nota($id_nota)) {

            $nota_cliente['productos'] = json_decode($nota_cliente['productos'], true); //DECODIFICA LOS PRODUCTOS 
            $nota_cliente['datos_cliente_general'] = json_decode($nota_cliente['datos_cliente_general'], true); //DECODIFICA LOS PRODUCTOS 
            $nota_cliente['stock_historico'] = json_decode($nota_cliente['stock_historico'], true); //DECODIFICA LOS PRODUCTOS 

            $productos = $nota_cliente['productos']; // SE ASIGNA PARA VALIDAR

            /**Para obtener el código fiscal */
            if ($traer_store && $productos) {
                foreach ($productos as $i_prod => $producto) {
                    $cod_fiscal = false;
                    if ($producto['tipo'] == 'modelo') {
                        $model_stock = $MODEL->mostrar_modelo($producto['id']);
                        $cod_fiscal = ($model_stock ? $model_stock['codigo_fiscal'] : false);
                    } else {
                        $mp_stock = $MATERIA->mostrar_materia($producto['id']);
                        $cod_fiscal = ($mp_stock ? $mp_stock['codigo_fiscal'] : false);
                    };

                    $productos[$i_prod]['codigo_fiscal'] = $cod_fiscal;
                }
            }
            /**Para obtener el código fiscal */

            $nota_cliente['productos'] = $productos;
            $cliente = $NOTE_V->mostrar_cliente($nota_cliente['id_cliente']);
            $pagos = $NOTE_V->mostrar_pagos($id_nota); //Guarda todos los pagos de la nota ya llega formateados en array

            $data = [
                'nota' => $nota_cliente,
                'cliente' => $cliente,
                'pagos' => $pagos,
            ];

            $respuesta = [
                'response' => 'success',
                'text' => 'Datos encontrados',
                'data' => $data
            ];
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'No fue posible encontrar la nota que necesitas', $_POST
            ];
        }
        echo json_encode($respuesta);

        break;

    case 'eliminar_pago':
        $id_nota = isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? (int)$_POST['id_nota'] : false;
        $id_pago = isset($_POST['id_pago']) && !empty($_POST['id_pago']) ? (int)$_POST['id_pago'] : false;

        $NOTE_V = new  ClienteNota();
        if (($nota_cliente = $NOTE_V->mostrar_nota($id_nota)) && ($pago = $NOTE_V->mostrar_pagos($id_nota, $id_pago))) {

            $PAGO_C = new ClienteNota();
            $PAGO_C->estado = 'eliminado';

            $total_pagado = ($nota_cliente['total_pagado'] - $pago[0]['cantidad']); //Resta el pago eliminado


            if ($pagos = $PAGO_C->actualizar_pago($id_pago, $id_nota)) {
                /**Si eliminas pago, reseteas la nota */
                $pago = $pago[0];

                $total_pagado = ($nota_cliente['total_pagado'] - $pago['cantidad']); //Resta el pago eliminado

                // en caso de haber tenido error de pago, puede eliminar y no afectar el estado de la nota
                if ($nota_cliente['total_costo'] > $total_pagado) $NOTE_V->estado = 'pendiente';

                if ($total_pagado <= 0) $total_pagado = 0;


                $NOTE_V->total_pagado = $total_pagado; //actualiza el total
                $NOTE_V->modificar_nota($id_nota); //Ejecuta la actualización

                $respuesta = [
                    'response' => 'success',
                    'text' => 'El pago a sido eliminado'
                ];
            } else {
                $respuesta = [
                    'response' => 'error',
                    'text' => 'No fue posible realizar la eliminación del pago',
                ];
            }
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'No fue posible encontrar la nota que necesitas', $_POST
            ];
        }
        echo json_encode($respuesta);
        break;


    case 'eliminar_nota':
        $id_nota = isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? (int)$_POST['id_nota'] : false;
        $MATERIA = new StockMaP();
        $NOTE_V = new  ClienteNota();

        $NOTE_V->estado = 'eliminado';

        if ($NOTE_V->mostrar_nota($id_nota)) {

            $total = $MATERIA->total_materia_nota($id_nota);

            if (!$total || ($total && $total['vendidas_t'] == 0)) {
                if ($NOTE_V->actualizar($id_nota)) {
                    $MATERIA->estado = 'eliminado';
                    $MATERIA->modificar_materia_stock(false, $id_nota);
                    $respuesta = [
                        'status' => true,
                        'response' => 'error',
                        'text' => 'Todos los datos fueron eliminados de forma correcta',
                    ];
                } else {
                    $respuesta = ['response' => 'error', 'text' => 'No fue posible realizar la eliminación de la nota'];
                }
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No será posible eliminar esta nota, la materia ya fue vendida o retirada del stock',];
            }
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrio un error al encontrar la nota'];
        }
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
