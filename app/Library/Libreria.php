<?php

namespace App\Libreria;

class  Libreria
{
    function PHPExcel()
    {
        require_once 'PHPExcel/PHPExcel.php';
    }
    function TCPDF()
    {
        require_once 'TCPDF/tcpdf.php';
    }
    function PHPMailer()
    {
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/SMTP.php';
    }
}
