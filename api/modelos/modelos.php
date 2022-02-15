<?php
require_once 'reportes_excel.php';

use App\Models\Materiaprima;
use App\Models\Modelos;
use App\Models\StockModelos;
use App\Libreria\Libreria;

$opcion = (isset($_POST['opcion']) && !empty($_POST['opcion']) ? $_POST['opcion'] : false);

$MODEL = new StockModelos();
$EXCEL = new Libreria();
$EXCEL->PHPExcel();

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
$raiz = '../public/';

$salidaExcel = false;

switch ($opcion) {
    case 'reactivar_modelo':
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        if ($activado = $MODEL->modelo_activado($id_modelo)) {
            $respuesta = ['response' => 'success', 'text' => 'El modelo ha sido activado'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible activar el nuevo stock'];
        echo json_encode($respuesta);
        break;
    case 'excel_siempre':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $hoy = date('Y-m-d');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator('RoponDagar')
            ->setTitle('Reporte Excel Hoy')
            ->setDescription('Documento creado el dia ' . $hoy)
            ->setKeywords('excel phpexcel ropondagarexcel')
            ->setCategory('Reportes');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
            ->setTitle("$hoy");
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_siempre($buscar)) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_todo()) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscados->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'excel_treinta_dias':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $hoy = date('Y-m-d');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator('RoponDagar')
            ->setTitle('Reporte Excel Hoy')
            ->setDescription('Documento creado el dia ' . $hoy)
            ->setKeywords('excel phpexcel ropondagarexcel')
            ->setCategory('Reportes');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
            ->setTitle("$hoy");
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_treinta_dias($buscar)) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->traer_historial_treinta_dias_todo()) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscados->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'excel_siete_dias':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $hoy = date('Y-m-d');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator('RoponDagar')
            ->setTitle('Reporte Excel Hoy')
            ->setDescription('Documento creado el dia ' . $hoy)
            ->setKeywords('excel phpexcel ropondagarexcel')
            ->setCategory('Reportes');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
            ->setTitle("$hoy");
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_siete_dias($buscar)) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_siete_dias_todo()) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscados->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'excel_ayer':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $hoy = date('Y-m-d');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator('RoponDagar')
            ->setTitle('Reporte Excel Hoy')
            ->setDescription('Documento creado el dia ' . $hoy)
            ->setKeywords('excel phpexcel ropondagarexcel')
            ->setCategory('Reportes');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
            ->setTitle("$hoy");
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_ayer($buscar)) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_ayer_todo()) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscados->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'excel_hoy':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $hoy = date('Y-m-d');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator('RoponDagar')
            ->setTitle('Reporte Excel Hoy')
            ->setDescription('Documento creado el dia ' . $hoy)
            ->setKeywords('excel phpexcel ropondagarexcel')
            ->setCategory('Reportes');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
            ->setTitle("$hoy");
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_hoy($buscar)) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_hoy_todo()) {
                $modelos_data = [];
                $counter = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, 'CODIGO');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, 'FECHA');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, 'CANTIDAD');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, 'TIPO MOVIMIENTO');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, 'USUARIO');
                while ($modelo = $buscados->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                    $counter++;
                    $nombre = strtoupper($modelo['nombre']) . ' ' . strtoupper($modelo['apellidos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $nombre);
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Excel.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'traer_historial_treinta_dias':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_treinta_dias($buscar)) {
                $modelos_data = [];
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->traer_historial_treinta_dias_todo()) {
                $modelos_data = [];
                while ($categoria = $buscados->fetch_assoc()) {
                    $modelos_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'traer_historial_siete_dias':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_siete_dias($buscar)) {
                $modelos_data = [];
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_siete_dias_todo()) {
                $modelos_data = [];
                while ($categoria = $buscados->fetch_assoc()) {
                    $modelos_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'traer_historial_ayer':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_ayer($buscar)) {
                $modelos_data = [];
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_ayer_todo()) {
                $modelos_data = [];
                while ($categoria = $buscados->fetch_assoc()) {
                    $modelos_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'traer_historial_hoy':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_hoy($buscar)) {
                $modelos_data = [];
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_hoy_todo()) {
                $modelos_data = [];
                while ($categoria = $buscados->fetch_assoc()) {
                    $modelos_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'traer_historial_siempre':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 30);
        if ($buscar) {
            if ($buscado = $MODEL->traer_historial_siempre($buscar)) {
                $modelos_data = [];
                while ($modelo = $buscado->fetch_assoc()) {
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'Coincidencias con el modelo',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El categoria que estas buscando no fue encontrado'];
            }
        } else {
            if ($buscados = $MODEL->mostrar_historial_todo()) {
                $modelos_data = [];
                while ($categoria = $buscados->fetch_assoc()) {
                    $modelos_data[] = $categoria;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'La categoría se encontro',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $MODEL->total_movimientos(),
                    ]
                ];
            } else {
                $respuesta = ['response' => 'error', 'text' => 'No se encontraron resultados'];
            }
        }
        echo json_encode($respuesta);
        break;
    case 'disminiur_stock':
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        $stock  = (isset($_POST['stock']) && !empty($_POST['stock']) ? $_POST['stock'] : false);
        if ($disminuido = $MODEL->disminuir($id_modelo, $stock)) {
            $respuesta = ['response' => 'success', 'text' => 'Stock actualizado de manera correcta'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible agregar el nuevo stock'];
        echo json_encode($respuesta);
        break;
    case 'ajuste':
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        $inversion  = (isset($_POST['inversion']) && !empty($_POST['inversion']) ? $_POST['inversion'] : 0.00);
        $precio_mayoreo  = (isset($_POST['precio_mayoreo']) && !empty($_POST['precio_mayoreo']) ? $_POST['precio_mayoreo'] : 0.00);
        $precio_menudeo  = (isset($_POST['precio_menudeo']) && !empty($_POST['precio_menudeo']) ? $_POST['precio_menudeo'] : 0.00);
        if ($ajustado = $MODEL->ajuste($id_modelo, $inversion, $precio_mayoreo, $precio_menudeo)) {
            $respuesta = ['response' => 'success', 'text' => 'Ajuste de precio realizado con éxito'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible el ajuste de precio'];
        echo json_encode($respuesta);
        break;
    case 'cargar_precios_viejos':
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        if ($cargado = $MODEL->cargar_precios_viejos($id_modelo)) {
            $respuesta = ['response' => 'success', 'text' => 'El modelo se encontro', 'data' => $cargado];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible cargar los precios'];
        echo json_encode($respuesta);
        break;
    case 'agregar_stock':
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        $nuevo_stock  = (isset($_POST['nuevo_stock']) && !empty($_POST['nuevo_stock']) ? $_POST['nuevo_stock'] : false);
        if ($agregado = $MODEL->agregar_stock($id_modelo, $nuevo_stock)) {
            $respuesta = ['response' => 'success', 'text' => 'Stock actualizado de manera correcta'];
        } else $respuesta = ['response' => 'warning', 'text' => 'No fue posible agregar el nuevo stock'];
        echo json_encode($respuesta);
        break;
    case 'mostrar_desactivados':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 30);
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        $codigo     = (isset($_POST['codigo'])    ? $_POST['codigo'] : false);
        $stock      = (isset($_POST['stock'])       && !empty($_POST['stock'])      ? true : false);


        if ($id_modelo) {
            if ($modelo = $MODEL->mostrar_modelo_desactivado($id_modelo)) {
                // $modelo['materia_prima'] = json_decode($modelo['materia_prima'], true);
                $materia_prima = json_decode($modelo['materia_prima'], true);
                $materias = false;
                if ($materia_prima) {
                    $materias = [];
                    $MAT = new Materiaprima();
                    foreach ($materia_prima as $mat_i => $mat) { //recorre el arreglo de materiales asignados para ver que existan en el sistema
                        $materia = $MAT->mostrar_materia($mat['id_materia_prima']); //Busca la materia
                        if ($materia) { //Si existe 
                            $materia_prima[$mat_i]['materia_prima'] = $materia; // Le agrega al arreglo $materia_prima[1] un nuevo campo materia prima con el resultado de la busqueda
                            $materias[] = $materia_prima[$mat_i]; //Lo guarda en materias para que solamente se añadan las que existan
                        }
                    }
                }
                $modelo['materia_prima'] = $materias; // Se cambia el valor de materia prima y se devuelve el analizado
                $galery_cont = false;
                if ($galeria = $MODEL->galeria_modelo($modelo['id_modelo'])) {
                    $galery_cont = [];
                    $existen_imagenes = false;
                    while ($imagen_n = $galeria->fetch_assoc()) {
                        $imagen_n['is_file'] = is_file($raiz . $imagen_n['imagen']);
                        $galery_cont[] = $imagen_n;
                        $existen_imagenes = true;
                    }
                    if (!$existen_imagenes) $galery_cont = false;
                }

                $modelo['galeria'] = $galery_cont;
                // $modelo['img_existe'] = is_file($modelo['imagen']);

                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => [$modelo],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            $MODEL->buscar = $buscar;
            $MODEL->pagina = $pagina;
            $MODEL->limite = $limite;
            $MODEL->codigo = $codigo;
            $MODEL->codigo_completo = $codigo;
            $modelos = false;
            if (!$stock) $modelos = $MODEL->mostrar_modelos_desactivados();
            else $modelos = $MODEL->mostrar_stock_modelos();

            if ($modelos) {
                $modelos_data = [];
                while ($modelo = $modelos->fetch_assoc()) {
                    $modelo['materia_prima'] = json_decode($modelo['materia_prima'], true);
                    /** */
                    $galery_cont = false;
                    if ($galeria = $MODEL->galeria_modelo($modelo['id_modelo'])) {
                        $galery_cont = [];
                        $existen_imagenes = false;
                        while ($imagen_n = $galeria->fetch_assoc()) {
                            $imagen_n['is_file'] = is_file($raiz . $imagen_n['imagen']);
                            $galery_cont[] = $imagen_n;
                            $existen_imagenes = true;
                        }
                        if (!$existen_imagenes) $galery_cont = false;
                    }

                    $modelo['galeria'] = $galery_cont;
                    /** */
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $MODEL->total_modelos(),
                    ]
                ];
            } else {
                if (!$stock) $respuesta = ['response' => 'error', 'text' => 'No encontramos más modelos para mostrarte'];
                else $respuesta = ['response' => 'error', 'text' => 'No tienes más stock disponible'];
            }
        }

        echo json_encode($respuesta);
        break;
    case 'mostrar':
        $buscar     = (isset($_POST['buscar'])    && !empty($_POST['buscar'])    ? $_POST['buscar'] : false);
        $pagina     = (isset($_POST['pagina'])    && !empty($_POST['pagina'])    ? $_POST['pagina'] : 1);
        $limite     = (isset($_POST['limite'])    && !empty($_POST['limite'])    ? $_POST['limite'] : 30);
        $id_modelo  = (isset($_POST['id_modelo']) && !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : false);
        $codigo     = (isset($_POST['codigo'])    ? $_POST['codigo'] : false);
        $stock      = (isset($_POST['stock'])       && !empty($_POST['stock'])      ? true : false);


        if ($id_modelo) {
            if ($modelo = $MODEL->mostrar_modelo($id_modelo)) {
                // $modelo['materia_prima'] = json_decode($modelo['materia_prima'], true);
                $materia_prima = json_decode($modelo['materia_prima'], true);
                $materias = false;
                if ($materia_prima) {
                    $materias = [];
                    $MAT = new Materiaprima();
                    foreach ($materia_prima as $mat_i => $mat) { //recorre el arreglo de materiales asignados para ver que existan en el sistema
                        $materia = $MAT->mostrar_materia($mat['id_materia_prima']); //Busca la materia
                        if ($materia) { //Si existe 
                            $materia_prima[$mat_i]['materia_prima'] = $materia; // Le agrega al arreglo $materia_prima[1] un nuevo campo materia prima con el resultado de la busqueda
                            $materias[] = $materia_prima[$mat_i]; //Lo guarda en materias para que solamente se añadan las que existan
                        }
                    }
                }
                $modelo['materia_prima'] = $materias; // Se cambia el valor de materia prima y se devuelve el analizado
                $galery_cont = false;
                if ($galeria = $MODEL->galeria_modelo($modelo['id_modelo'])) {
                    $galery_cont = [];
                    $existen_imagenes = false;
                    while ($imagen_n = $galeria->fetch_assoc()) {
                        $imagen_n['is_file'] = is_file($raiz . $imagen_n['imagen']);
                        $galery_cont[] = $imagen_n;
                        $existen_imagenes = true;
                    }
                    if (!$existen_imagenes) $galery_cont = false;
                }

                $modelo['galeria'] = $galery_cont;
                // $modelo['img_existe'] = is_file($modelo['imagen']);

                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => [$modelo],
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => 1
                    ]
                ];
            } else {
                $respuesta = ['response' => 'warning', 'text' => 'El modelo que estas buscando no fue encontrado'];
            }
        } else {
            $MODEL->buscar = $buscar;
            $MODEL->pagina = $pagina;
            $MODEL->limite = $limite;
            $MODEL->codigo = $codigo;
            $MODEL->codigo_completo = $codigo;
            $modelos = false;
            if (!$stock) $modelos = $MODEL->mostrar_modelos();
            else $modelos = $MODEL->mostrar_stock_modelos();

            if ($modelos) {
                $modelos_data = [];
                while ($modelo = $modelos->fetch_assoc()) {
                    $modelo['materia_prima'] = json_decode($modelo['materia_prima'], true);
                    /** */
                    $galery_cont = false;
                    if ($galeria = $MODEL->galeria_modelo($modelo['id_modelo'])) {
                        $galery_cont = [];
                        $existen_imagenes = false;
                        while ($imagen_n = $galeria->fetch_assoc()) {
                            $imagen_n['is_file'] = is_file($raiz . $imagen_n['imagen']);
                            $galery_cont[] = $imagen_n;
                            $existen_imagenes = true;
                        }
                        if (!$existen_imagenes) $galery_cont = false;
                    }

                    $modelo['galeria'] = $galery_cont;
                    /** */
                    $modelos_data[] = $modelo;
                }
                $respuesta = [
                    'response' => 'success',
                    'text' => 'El modelo se encontro',
                    'data' => $modelos_data,
                    'pagination' => [
                        'page' => (int)$pagina,
                        'limit' => (int) $limite,
                        'total' => $MODEL->total_modelos(),
                    ]
                ];
            } else {
                if (!$stock) $respuesta = ['response' => 'error', 'text' => 'No encontramos más modelos para mostrarte'];
                else $respuesta = ['response' => 'error', 'text' => 'No tienes más stock disponible'];
            }
        }

        echo json_encode($respuesta);
        break;
    case 'eliminar_modelo':
        $id_modelo           = (isset($_POST['id_modelo'])          && !empty($_POST['id_modelo'])          ? $_POST['id_modelo']          : false);
        if ($eliminar = $MODEL->eliminar_modelo($id_modelo)) {
            $respuesta = ['response' => 'success', 'text' => 'La eliminación se realizo de forma exitosa'];
        } else {
            $respuesta = ['response' => 'warning', 'text' => 'El modelo no ha sido eliminado'];
        }
        echo json_encode($respuesta);
        break;
    case 'crear_modelo':
        $nombre           = (isset($_POST['nombre'])          && !empty($_POST['nombre'])          ? $_POST['nombre']          : false);
        $codigo           = (isset($_POST['codigo'])          && !empty($_POST['codigo'])          ? $_POST['codigo']          : false);
        $color            = (isset($_POST['color'])           && !empty($_POST['color'])           ? $_POST['color']           : false);
        $nuevo_color      = (isset($_POST['color_nuevo'])     && !empty($_POST['color_nuevo'])     ? $_POST['color_nuevo']     : false);
        $talla            = (isset($_POST['talla'])           && !empty($_POST['talla'])           ? $_POST['talla']           : false);
        $tipo             = (isset($_POST['tipo'])            && !empty($_POST['tipo'])            ? $_POST['tipo']            : false);
        $sexo             = (isset($_POST['sexo'])            && !empty($_POST['sexo'])            ? $_POST['sexo']            : false);
        $codigo_completo  = (isset($_POST['codigo_completo']) && !empty($_POST['codigo_completo']) ? $_POST['codigo_completo'] : false);
        $materia_prima    = (isset($_POST['materia_prima'])   && !empty($_POST['materia_prima'])   ? $_POST['materia_prima']   : false);
        $fecha_completa   = (isset($_POST['fecha_completa'])  && !empty($_POST['fecha_completa'])  ? $_POST['fecha_completa']  : false);
        $codigo_fiscal    = (isset($_POST['codigo_fiscal'])   && !empty($_POST['codigo_fiscal'])   ? $_POST['codigo_fiscal']   : false);
        $categoria        = (isset($_POST['categoria'])       && !empty($_POST['categoria'])       ? $_POST['categoria']       : false);

        $newCode = $nombre[0] . $codigo . $nuevo_color[0] . $fecha_completa;

        $imagen    = (isset($_FILES['imagen'])   && !empty($_FILES['imagen'])   ? $_FILES['imagen'] : false);


        if ($nombre && $codigo && $color && $talla && $tipo && $sexo) {
            if ($encontrado = $MODEL->mostrar_modelo_por_codigo($codigo)) {
                $materia_prima = json_decode($encontrado['materia_prima'], true);
                $materias = false;
                if ($materia_prima) {
                    $materias = [];
                    $MAT = new Materiaprima();
                    foreach ($materia_prima as $mat_i => $mat) { //recorre el arreglo de materiales asignados para ver que existan en el sistema
                        $materia = $MAT->mostrar_materia($mat['id_materia_prima']); //Busca la materia
                        if ($materia) { //Si existe 
                            $materia_prima[$mat_i]['materia_prima'] = $materia; // Le agrega al arreglo $materia_prima[1] un nuevo campo materia prima con el resultado de la busqueda
                            $materias[] = $materia_prima[$mat_i]; //Lo guarda en materias para que solamente se añadan las que existan
                        }
                    }
                }
                $encontrado['materia_prima'] = $materias; // Se cambia el valor de materia prima y se devuelve el analizado
                $galery_cont = false;
                if ($galeria = $MODEL->galeria_modelo($encontrado['id_modelo'])) {
                    $galery_cont = [];
                    $existen_imagenes = false;
                    while ($imagen_n = $galeria->fetch_assoc()) {
                        $imagen_n['is_file'] = is_file($raiz . $imagen_n['imagen']);
                        $galery_cont[] = $imagen_n;
                        $existen_imagenes = true;
                    }
                    if (!$existen_imagenes) $galery_cont = false;
                }

                $encontrado['galeria'] = $galery_cont;
                // $encontrado['img_existe'] = is_file($encontrado['imagen']);

                $respuesta = [
                    'response' => 'encontrado',
                    'text' => 'El modelo se encontro',
                    'data' => $encontrado,
                ];
            } else {
                if ($id = $MODEL->crear_modelo($nombre, $codigo, $color, $talla, $tipo, $sexo, $materia_prima, $newCode, $codigo_fiscal, $categoria)) {
                    $respuesta = [
                        'response' => 'success',
                        'text' => 'El registro del modelo fue creado de manera correcta',
                    ];
                } else {
                    $respuesta = [
                        'response' => 'warning',
                        'text' => 'No fue posible terminar con el registro del nuevo modelo'
                    ];
                }
            }
        } else {
            $respuesta = [
                'response' => 'error',
                'text' => 'Completa los campos obligatorios'
            ];
        }
        echo json_encode($respuesta);
        break;
    case 'modificar_modelo':
        $id_modelo        = (isset($_POST['id_modelo'])       && !empty($_POST['id_modelo'])       ? $_POST['id_modelo'] : false);
        $nombre           = (isset($_POST['nombre'])          && !empty($_POST['nombre'])          ? $_POST['nombre'] : false);
        $codigo           = (isset($_POST['codigo'])          && !empty($_POST['codigo'])          ? $_POST['codigo'] : false);
        $color            = (isset($_POST['color'])           && !empty($_POST['color'])           ? $_POST['color'] : false);
        $talla            = (isset($_POST['talla'])           && !empty($_POST['talla'])           ? $_POST['talla'] : false);
        $tipo             = (isset($_POST['tipo'])            && !empty($_POST['tipo'])            ? $_POST['tipo'] : false);
        $sexo             = (isset($_POST['sexo'])            && !empty($_POST['sexo'])            ? $_POST['sexo'] : false);
        $codigo_completo  = (isset($_POST['codigo_completo']) && !empty($_POST['codigo_completo']) ? $_POST['codigo_completo'] : false);
        $materia_prima    = (isset($_POST['materia_prima'])   && !empty($_POST['materia_prima'])   ? $_POST['materia_prima'] : false);
        $codigo_fiscal    = (isset($_POST['codigo_fiscal'])   && !empty($_POST['codigo_fiscal'])   ? $_POST['codigo_fiscal']  : false);

        $modelo = $MODEL->mostrar_modelo($id_modelo);
        if ($modelo) {
            $MODEL->nombre          = $nombre;
            $MODEL->codigo          = $codigo;
            $MODEL->color           = $color;
            $MODEL->talla           = $talla;
            $MODEL->tipo            = $tipo;
            $MODEL->sexo            = $sexo;
            $MODEL->codigo_completo = $codigo_completo;
            $MODEL->materia_prima   = $materia_prima;
            $MODEL->codigo_fiscal   = $codigo_fiscal;
            if ($id = $MODEL->modificar_modelo($id_modelo)) $respuesta = ['response' => 'success', 'text' => 'La actualización se realizo de forma exitosa'];
            else $respuesta = ['response' => 'warning', 'text' => 'No fue posible realizar la actualización al modelo'];
        } else {
            $respuesta = ['response' => 'error', 'text' => 'Ocurrió un error al consultar el modelo, es muy probable que este haya sido eliminado recientemente'];
        }
        echo json_encode($respuesta);
        break;
    default:
        echo json_encode($respuesta);
        break;
}
//excel($modelos_data);
function excel($modelos)
{
    //print_r($modelos);
    $hoy = date('Y-m-d');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()
        ->setCreator('RoponDagar')
        ->setTitle('Reporte Excel Hoy')
        ->setDescription('Documento creado el dia ' . $hoy)
        ->setKeywords('excel phpexcel ropondagarexcel')
        ->setCategory('Reportes');
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()
        ->setTitle("$hoy");
    $counter = 1;
    foreach ($modelos as $modelo) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $modelo['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $modelo['fecha']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $modelo['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $modelo['tipo_movimiento']);
        $counter++;
    }
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Excel.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}
