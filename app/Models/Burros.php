<?php

namespace App\Models;

use App\Config\Config;
use DateTime;

class Burros
{
    function __construct()
    {
        $CONFIG  = new Config();
        $this->CONEXION = $CONFIG->getConexion();
    }
}
