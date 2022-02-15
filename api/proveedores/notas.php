<?php

use App\Models\{Materiaprima, Nota_p, StockMaP};

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$NOTE_P = new Nota_p();
/**
 * response = success,warning,error
 * text = @String
 * data = @array[]
 */
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
        $id_proveedor   = (isset($_POST['id_proveedor'])    && !empty($_POST['id_proveedor'])   ? (int)$_POST['id_proveedor'] : false);
        $limite         = (isset($_POST['limite'])          && !empty($_POST['limite'])         ? (int)$_POST['limite'] : 8);
        $estado         = (isset($_POST['estado'])          && !empty($_POST['estado'])         ? $_POST['estado'] : false);
        $fecha_inicio   = (isset($_POST['fecha_inicio'])    && !empty($_POST['fecha_inicio'])   ? $_POST['fecha_inicio'] : false);
        $fecha_limite   = (isset($_POST['fecha_limite'])    && !empty($_POST['fecha_limite'])   ? $_POST['fecha_limite'] : false);


        $NOTE_P->buscar = $buscar;
        $NOTE_P->pagina = $pagina;
        $NOTE_P->limite = $limite;

        // $NOTE_P->id_nota = $id_nota;

        /**OTROS FILTROS */
        $NOTE_P->id_proveedor   = $id_proveedor;
        $NOTE_P->estado         = $estado;
        $NOTE_P->fecha_inicio   = $fecha_inicio;
        $NOTE_P->fecha_limite   = $fecha_limite;
        /**OTROS FILTROS */
        $total = 0;
        if ($notas = $NOTE_P->mostrar_notas()) {
            $notas_data = [];
            while ($nota = $notas->fetch_assoc()) {
                $nota['productos'] = json_decode($nota['productos'], true);
                $nota['proveedor'] = $NOTE_P->mostrar_proveedor($nota['id_proveedor']);
                $nota['pagos'] = $NOTE_P->mostrar_pagos($nota['id_nota_proveedor']);
                $notas_data[] = $nota;
            }
            $respuesta = [
                'response' => 'success',
                'text' => 'El modelo se encontro',
                'data' => $notas_data
            ];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
        }

        $respuesta['pagination'] = [
            "page" => $pagina,
            "limit" => $limite,
            "total" => (int)$NOTE_P->total_notas,
            "post" => $_POST,
        ];

        echo json_encode($respuesta);
        break;
    case 'crear_nota':
        $nota        = (isset($_POST['nota'])    && !empty($_POST['nota'])    ? json_decode($_POST['nota'], true) : false);
        $iva         = false;

        $id_usuario = $USERSYSTEM['idUsuario'];

        if ($nota) {

            $descuento = $nota['descuentos'];
            $proveedor = $nota['usuario'];
            $productos = $nota['productos'];
            $fecha = $nota['fecha'];
            $iva = ($nota['iva'] ? 1.16 : false);
            $PRIMA = new Materiaprima();
            $NOTA = new Nota_p();

            if ($productos) {
                $cantidad_productos = sizeof($productos);
                $total_costo = 0;

                foreach ($productos as $i_prod => $producto) {
                    $total_costo += (floatval($producto['precio_compra']) * ((int)$producto['cantidad']));
                    $productos[$i_prod]['data'];
                    unset($productos[$i_prod]['data']); //Elimino la data, ya que no es necesario almacenarlo
                }
                $descuento_val = 0;

                $tipo_descuento = ($descuento ? $descuento['tipo'] : "moneda"); //Tiene que venir en el arreglo del descuento {tipo:"",cantidad:0}
                $descuento      = ($descuento ? $descuento['cantidad'] : 0); //Tiene que venir en el arreglo del descuento {tipo:"",cantidad:0}
                $descuento  = ($tipo_descuento == 'moneda' ? $descuento : (($descuento / 100) * $total_costo)); //Descuento aplicado por el tipo de producto, esto solo afecta al precio final

                $total_costo = (($total_costo - $descuento) * ($iva ? $iva : 1)); //La suma total menos el descuento

                $productos = json_encode($productos, JSON_UNESCAPED_UNICODE); //Se vuelven String para almacenar
                $id_proveedor = $proveedor['id'];


                $iva = ($iva ? "si" : "no");

                if ($id = $NOTA->crear_nota_proveedor($productos, $cantidad_productos, $total_costo, $fecha, $id_proveedor, $id_usuario, $iva, $descuento, $tipo_descuento, 0)) {
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'El registro del modelo fue creado de manera correcta',
                        'data' => ['id_nota' => $id]
                    ];
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
        $modelo = $NOTE_P->mostrar_nota($id_nota);
        if ($modelo) {
            $NOTE_P->nombre          = $nombre;
            $NOTE_P->codigo          = $codigo;
            $NOTE_P->color           = $color;
            $NOTE_P->talla           = $talla;
            $NOTE_P->tipo            = $tipo;
            $NOTE_P->sexo            = $sexo;
            $NOTE_P->codigo_completo = $codigo_completo;
            $NOTE_P->materia_prima   = $materia_prima;

            if ($id = $NOTE_P->actualizar($id_nota)) $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al modelo'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el modelo, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);

        break;


    case 'enviar_nota_email':
        $id_nota        = (isset($_POST['id_nota'])     && !empty($_POST['id_nota'])    ? $_POST['id_nota'] : false);

        $respuesta = [
            'response' => 'success',
            'text' => 'Llego la solicitud'
        ];
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



        if ($nota = $NOTE_P->mostrar_nota($id_nota)) {
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
                    $NOTE_P->agregar_pago($id_nota, $pago, $id_usuario, $tipo_pago, $comentario, $iva);

                    $NOTE_P->total_pagado = $nota['total_costo'];
                    $NOTE_P->fecha_pago_total = date("Y-m-d H:m:s");
                    $NOTE_P->estado = "pagado";
                    $NOTE_P->actualizar($id_nota);
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'La nota se pago correctamente, puedes revisar el historial de notas en: Proveedores  / Todas las notas',
                    ];
                } else {
                    $respuesta = [
                        'response' => 'error',
                        'text' => 'Solamente puedes hacer el pago total de la nota, si deceas agregar parcialidades ve a el apartado de 2 proveedores  / Todas las notas',
                    ];
                }
            } else {
                if ($pago < $deuda_total) {
                    $NOTE_P->agregar_pago($id_nota, $pago, $id_usuario, $tipo_pago, $comentario, $iva);

                    $NOTE_P->total_pagado = ($total_pagado + $pago);
                    $NOTE_P->actualizar($id_nota);
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'La nota se pago correctamente, puedes revisar el historial de notas en: Proveedores  / Todas las notas',
                    ];
                } else if ($pago == $deuda_total) {
                    $NOTE_P->agregar_pago($id_nota, $pago, $id_usuario, $tipo_pago, $comentario, $iva);
                    $NOTE_P->total_pagado = $nota['total_costo'];
                    $NOTE_P->fecha_pago_total = date("Y-m-d H:m:s");
                    $NOTE_P->estado = "pagado";
                    $NOTE_P->actualizar($id_nota);
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'La nota se pago correctamente, puedes revisar el historial de notas en: Proveedores  / Todas las notas',
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
        $id_proveedor   = (isset($_POST['id_proveedor'])    && !empty($_POST['id_proveedor'])   ? (int)$_POST['id_proveedor'] : false);
        $NOTE_P->id_proveedor = $id_proveedor;
        $respuesta = [
            "response" => 'success',
            "text" => 'Envio de resultados',
            "data" => [
                "notas" => $NOTE_P->estadisticas_notas(),
                "pagos_nota" => $NOTE_P->estadisticas_pagos()
            ]
        ];

        echo json_encode($respuesta);

        break;
    case 'mostrar_nota':
        $id_nota = isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? (int)$_POST['id_nota'] : false;

        $MATERIA = new Materiaprima();
        $STOCK_M_P = new StockMaP(); // STOCK DE MATERIA PRIMA

        if ($nota_proveedor = $NOTE_P->mostrar_nota($id_nota)) {

            $nota_proveedor['productos'] = json_decode($nota_proveedor['productos'], true); //DECODIFICA LOS PRODUCTOS 

            $productos = $nota_proveedor['productos']; // SE ASIGNA PARA VALIDAR
            if ($productos) {
                /**BUSCA EL NOMBRE Y DATOS DE EL MATERIAL DE LA NOTA */
                foreach ($productos as $i_prod => $producto) {
                    $productos[$i_prod]['data'] = $MATERIA->mostrar_materia($producto['id']); //AGREGA LA DATA

                    if (!empty($productos[$i_prod]['id_stock'])) {
                        $productos[$i_prod]['data_stock'] = $STOCK_M_P->mostrar_materia_stock($productos[$i_prod]['id_stock']); // En caso de haber en stock mandar los datos
                    } else unset($productos[$i_prod]['id_stock']);
                }
            }
            $nota_proveedor['productos'] = $productos;
            $proveedor = $NOTE_P->mostrar_proveedor($nota_proveedor['id_proveedor']);
            $pagos = $NOTE_P->mostrar_pagos($id_nota); //Guarda todos los pagos de la nota ya llega formateados en array

            $data = [
                'nota' => $nota_proveedor,
                'proveedor' => $proveedor,
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
                'text' => 'No fue posible encontrar la nota que necesitas'
            ];
        }
        echo json_encode($respuesta);

        break;

    case 'eliminar_pago':
        $id_nota = isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? (int)$_POST['id_nota'] : false;
        $id_pago = isset($_POST['id_pago']) && !empty($_POST['id_pago']) ? (int)$_POST['id_pago'] : false;

        if (($nota_proveedor = $NOTE_P->mostrar_nota($id_nota)) && ($pago = $NOTE_P->mostrar_pagos($id_nota, $id_pago))) {

            $PAGO_C = new Nota_p();
            $PAGO_C->estado = 'eliminado';

            $total_pagado = ($nota_proveedor['total_pagado'] - $pago[0]['cantidad']); //Resta el pago eliminado


            if ($pagos = $PAGO_C->actualizar_pago($id_pago, $id_nota)) {
                /**Si eliminas pago, reseteas la nota */
                $pago = $pago[0];

                $total_pagado = ($nota_proveedor['total_pagado'] - $pago['cantidad']); //Resta el pago eliminado

                // en caso de haber tenido error de pago, puede eliminar y no afectar el estado de la nota
                if ($nota_proveedor['total_costo'] > $total_pagado) $NOTE_P->estado = 'pendiente';

                if ($total_pagado <= 0) $total_pagado = 0;


                $NOTE_P->total_pagado = $total_pagado; //actualiza el total
                $NOTE_P->actualizar($id_nota); //Ejecuta la actualización

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
                'text' => 'No fue posible encontrar la nota que necesitas'
            ];
        }
        echo json_encode($respuesta);
        break;


    case 'eliminar_nota':
        $id_nota = isset($_POST['id_nota']) && !empty($_POST['id_nota']) ? (int)$_POST['id_nota'] : false;
        $MATERIA = new StockMaP();
        $NOTE_P->estado = 'eliminado';


        if ($NOTE_P->mostrar_nota($id_nota)) {

            $total = $MATERIA->total_materia_nota($id_nota);

            if (!$total || ($total && $total['vendidas_t'] == 0)) {
                if ($NOTE_P->actualizar($id_nota)) {
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
