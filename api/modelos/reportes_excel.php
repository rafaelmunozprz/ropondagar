<?php
class RepoteExcel{
    function crearReporte($modelos){
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
        exit();
    }
}
