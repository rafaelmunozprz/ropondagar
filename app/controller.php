<?php

require_once 'Models/Template.php';
require_once 'Models/Template_admin.php';
require_once 'Config/Config.php';
require_once 'Models/Funciones.php';
require_once 'Models/Notificaciones.php';



/**USUARIOS */
require_once 'Models/Usuarios.php';
require_once 'Models/Permisos.php';

/**Clientes */
require_once 'Models/Cliente.php';
require_once 'Models/ClienteNota.php';

/**PROVEEDORES */
require_once 'Models/Proveedor.php';
require_once 'Models/Proveedor_nota.php';

/** LIBRERIAS */
require_once 'Library/Libreria.php';

/**MODELOS DEL SISTEMA */

require_once 'Models/Modelos.php';
require_once 'Models/Modelos_viejos.php';
require_once 'Models/ModelosStock.php';
require_once 'Models/Modelosviejos.php';
require_once 'Models/Notas_modelos_viejos.php';
require_once 'Models/Grupos.php';

/**Materia prima */
require_once 'Models/MateriaPrima.php';
require_once 'Models/MateriaPrimaStock.php';
/**Categorias */
require_once 'Models/Categorias.php';
/**Anaqueles */
require_once 'Models/Anaqueles.php';
/**Burros */
require_once 'Models/Burros.php';

require_once 'Models/Ordenes.php';

/**CLIENTE DEL SISTEMA */


/**MODELOS DEL SISTEMA */



/**
 * PLANTILLAS DE CORREO ELECTRONICO
 */

require_once 'Email/Email_templates.php';
require_once 'Email/Email.php';


/**Facturación */

require_once 'Models/Facturacion/Facturacion.php';
