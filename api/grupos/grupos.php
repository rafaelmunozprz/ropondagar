<?php

use App\Models\Grupos;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$GRUPO = new Grupos();

$respuesta = [
    'response' => 'error',
    'text' => 'La solicitud esta equivocada'
];

header('Content-type:application/json;charset=utf-8');

switch ($opcion) {
    case 'determinar_encargado':
        $id_grupo_trabajo     = (isset($_POST['id_grupo_trabajo'])    && !empty($_POST['id_grupo_trabajo'])    ? $_POST['id_grupo_trabajo'] : false);
        if ($usuarios = $GRUPO->determinar_encargado($id_grupo_trabajo)) {
            $usuarios_data = [];
            while ($grupo = $usuarios->fetch_assoc()) {
                $usuarios_data[] = $grupo;
            }
            $respuesta = ['response' => 'success', 'text' => 'Los usuarios se encontraron', 'data' => $usuarios_data];
        } else $respuesta = ['response' => 'warning', 'text' => 'Los usuarios del grupo ' . $id_grupo_trabajo . ' no se han cargado'];
        echo json_encode($respuesta);
        break;
    case 'agregar_personal':
        $users     = (isset($_POST['users'])    && !empty($_POST['users'])    ? $_POST['users'] : false);
        $id_grupo_trabajo     = (isset($_POST['id_grupo_trabajo'])    && !empty($_POST['id_grupo_trabajo'])    ? $_POST['id_grupo_trabajo'] : false);
        $users = json_decode($users, true);
        if ($agregado = $GRUPO->agregar_personal($users, $id_grupo_trabajo)) {
            $respuesta = ['response' => 'success', 'text' => 'Los usuarios se agregaron exitosamente', 'data' => $agregado];
        } else $respuesta = ['response' => 'warning', 'text' => 'El personal no pudo ser agregado'];
        echo json_encode($respuesta);
        break;
    case 'mostrar_personal_agregar':
        $id_grupo_trabajo     = (isset($_POST['id_grupo_trabajo'])    && !empty($_POST['id_grupo_trabajo'])    ? $_POST['id_grupo_trabajo'] : 1);
        if ($cargado = $GRUPO->cargar_personal_agregar()) {
            $usuarios_data = [];
            while ($grupo = $cargado->fetch_assoc()) {
                $usuarios_data[] = $grupo;
            }
            $respuesta = ['response' => 'success', 'text' => 'El grupo se encontró', 'data' => $usuarios_data];
        } else $respuesta = ['response' => 'warning', 'text' => 'El grupo ' . $id_grupo_trabajo . ' no se ha cargado'];
        echo json_encode($respuesta);
        break;
    case 'eliminar_grupo':
        $id_grupo_trabajo     = (isset($_POST['id_grupo_trabajo'])    && !empty($_POST['id_grupo_trabajo'])    ? $_POST['id_grupo_trabajo'] : 1);
        if ($eliminado = $GRUPO->eliminar_grupo($id_grupo_trabajo)) {
            $respuesta = ['response' => 'success', 'text' => 'El grupo ha sido eliminado exitosamente'];
        } else $respuesta = ['response' => 'warning', 'text' => 'El grupo no ha sido eliminado'];
        echo json_encode($respuesta);
        break;
    case 'cargar_grupo':
        $id_grupo_trabajo     = (isset($_POST['id_grupo_trabajo'])    && !empty($_POST['id_grupo_trabajo'])    ? $_POST['id_grupo_trabajo'] : 1);
        if ($cargado = $GRUPO->cargar_grupo($id_grupo_trabajo)) {
            $respuesta = [
                'response' => 'success', 'text' => 'El grupo se encontró', 'data' => [$cargado]
            ];
        } else $respuesta = ['response' => 'warning', 'text' => 'El grupo ' . $id_grupo_trabajo . ' no se ha cargado'];
        echo json_encode($respuesta);
        break;
    case 'nuevo_grupo':
        $nombre     = (isset($_POST['nombre'])    && !empty($_POST['nombre'])    ? $_POST['nombre'] : false);
        $tipo_grupo     = (isset($_POST['tipo_grupo'])    && !empty($_POST['tipo_grupo'])    ? $_POST['tipo_grupo'] : false);
        if ($nuevo = $GRUPO->nuevo_grupo($nombre, $tipo_grupo)) {
            $respuesta = ['response' => 'success', 'text' => 'El grupo ' . $nombre . ' ha sido creado exitosamente'];
        } else $respuesta = ['response' => 'warning', 'text' => 'El grupo ' . $nombre . ' no ha sido creado'];
        echo json_encode($respuesta);
        break;
    case 'editar':
        $id_grupo_trabajo     = (isset($_POST['id_grupo_trabajo'])    && !empty($_POST['id_grupo_trabajo'])    ? $_POST['id_grupo_trabajo'] : 1);
        $nombre     = (isset($_POST['nombre_grupo'])    && !empty($_POST['nombre_grupo'])    ? $_POST['nombre_grupo'] : 1);
        $tipo_grupo     = (isset($_POST['tipo_grupo'])    && !empty($_POST['tipo_grupo'])    ? $_POST['tipo_grupo'] : 'activo');
        if ($editado = $GRUPO->editar_grupo_trabajo($id_grupo_trabajo, $nombre, $estado)) {
            $respuesta = ['response' => 'success', 'text' => 'El grupo ' . $nombre . ' ha sido modificado exitosamente'];
        } else $respuesta = ['response' => 'warning', 'text' => 'El grupo ' . $nombre . ' no ha sido modificado'];
        echo json_encode($respuesta);
        break;
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 9);
        if ($buscar) {
            if ($grupo_buscado = $GRUPO->mostrar_grupo($buscar)) {
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El grupo no se encontró',
                    'data' => [$grupo_buscado],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El grupo que fue buscado no fue encontrado'];
            }
        } else {
            $GRUPO->buscar = $buscar;
            $GRUPO->pagina = $pagina;
            $GRUPO->limite = $limite;
            if ($grupos = $GRUPO->mostrar_grupos()) {
                $grupos_data = [];
                while ($grupo = $grupos->fetch_assoc()) {
                    $grupos_data[] = $grupo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El grupo se encontro',
                    'data' => $grupos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $GRUPO->total_grupos(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
