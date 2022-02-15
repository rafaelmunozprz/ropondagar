<?php

namespace App\Models;

class TemplateAdmin extends Templates
{
    private $USERSYSTEM = false;

    public $notify = true;
    public $toastr = true;
    public $jsBarCode = false;
    public $admin_config = true;
    function __construct($USERSYSTEM)
    {
        $this->USERSYSTEM = $USERSYSTEM;
        parent::__construct();
        $this->bootstrap = false;
    }
    function library_admin()
    {
        $library_admin = '<script src="' . $this->RUTA . 'library/atlantis/assets/js/plugin/webfont/webfont.min.js"></script>';
        $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/fontawesome/css/all.css">';
        $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/mdbootstrap/css/bootstrap.min.css">';
        $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/atlantis/assets/css/atlantis.css">';
        $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/atlantis/assets/css/demo.css">';
        $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'css/estilos.css">';
        $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'css/sistema.css">';

        if ($this->toastr) {
            $library_admin .= '<link rel="stylesheet" href="' . $this->RUTA . 'library/toastr/toastr.min.css">';
        }


        echo $library_admin;
    }
    function scripts_admin()
    {
        $body_admin = ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/core/jquery.3.2.1.min.js"></script>';
        $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/core/popper.min.js"></script>';
        $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/core/bootstrap.min.js"></script>';
        $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>';
        $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>';
        $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>';
        $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/atlantis.min.js"></script>';

        if ($this->notify) {
            $body_admin .= ' <script src="' . $this->RUTA . 'library/atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>';
        }
        if ($this->admin_config) {
            $body_admin .= ' <script src="' . $this->RUTA . 'js/models/funciones.js"></script>';
            $body_admin .= ' <script src="' . $this->RUTA . 'js/notificaciones/notificacion.js"></script>';
        }
        if ($this->jsBarCode) {
            $body_admin .= ' <script src="' . $this->RUTA . 'library/jsBarCode/JsBarcode.all.min.js"></script>';
        }
        if ($this->toastr) {
            $body_admin .= ' <script src="' . $this->RUTA . 'library/toastr/toastr.min.js"></script>';
        }
        $body_admin .= ' <script src="' . $this->RUTA . 'js/login/cerrarSesion.js"></script>';


        echo $body_admin;
    }
    
    function nav_bar_admin($active = '', $sub_menu = '')
    {
        // $vistas = $permisos['vistas']; //Actualizacion de permisos a futuro
        
        $vistas = [
            'ordenes' => ['notatest', 'nueva_venta', 'notas_venta'],
            'stock' => ['inventario', 'materiaprima', 'modelos', 'anaqueles', 'burros'],
            'proveedores' => ['proveedores', 'nota_proveedor', 'notas'],
            'usuarios' => ['usuarios', 'clientes'],
            'produccion' => ['categorias', 'nueva_orden', 'ordenes_produccion',],
            'procesos' => [],
            'orden' => []
        ];
        $header_admin = '       
                <div class="main-header" id="id_usuario" id_usuario="'.$this->USERSYSTEM['idUsuario'].'">
                    <div class="logo-header" data-background-color="white">

                        <a href="' . $this->RUTA . 'sistema" class="logo">' . $this->SISTEMNAME . '</a>
                        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <i class="fas fa-bars"></i>
                            </span>
                        </button>
                        <button class="topbar-toggler more"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                    </div>
                    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="white">
                        <div class="container-fluid">
                            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                                <li class="nav-item dropdown hidden-caret" id="notificaciones_body"></li>
                                
                                <li class="nav-item dropdown hidden-caret">
                                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <i class="fas fa-layer-group"></i>
                                    </a>
                                    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                        <div class="quick-actions-header">
                                            <span class="title mb-1">Herramientas de administración</span>
                                            <span class="subtitle op-8">Acceso Rápido</span>
                                        </div>
                                        <div class="quick-actions-scroll scrollbar-outer">
                                            <div class="quick-actions-items">
                                                <div class="row m-0">
                                                    <a class="col-6 col-md-4 p-0" href="#">
                                                        <div class="quick-actions-item">
                                                            <i class="fas fa-traffic-light"></i>
                                                            <span class="text">Iniciar nueva orden</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="#">
                                                        <div class="quick-actions-item">
                                                            <i class="fas fa-microchip"></i>
                                                            <span class="text">Ver ordenes en proceso</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="#">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-pen"></i>
                                                            <span class="text">Ver trabajadores</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="#">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-interface-1"></i>
                                                            <span class="text">Ver grupos de trabajo</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="#">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-list"></i>
                                                            <span class="text">Procesos finalizados</span>
                                                        </div>
                                                    </a>
                                                    <a class="col-6 col-md-4 p-0" href="#">
                                                        <div class="quick-actions-item">
                                                            <i class="flaticon-file"></i>
                                                            <span class="text">Crear notificación</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item dropdown hidden-caret">
                                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <div class="avatar-sm">
                                            <img src="' . $this->RUTA . 'galeria/sistema/avatars/1.jpg" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                    <div class="avatar-lg"><img src="' . $this->RUTA . 'galeria/sistema/avatars/1.jpg" alt="image profile" class="avatar-img rounded"></div>
                                                    <div class="u-text">
                                                        <h4>Leonardo</h4>
                                                        <p class="text-muted">hello@example.com</p><a href="' . $this->RUTA . 'sistema/perfil" class="btn btn-xs btn-secondary btn-sm">Ver Perfil</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="' . $this->RUTA . 'sistema/perfil">MI perfil</a>
                                                <a class="dropdown-item" href="' . $this->RUTA . 'banalce">Mi Balance</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="' . $this->RUTA . 'sistema/perfil/configurar">Editar mi perfil</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" id="cerrarSesion">Cerrar Sesión</a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            
                <div class="sidebar ">
                    <div class="sidebar-wrapper scrollbar scrollbar-inner">
                        <div class="sidebar-content">
                            <div class="user">
                                <div class="avatar-sm float-left mr-2">
                                    <img src="' . $this->RUTA . 'galeria/sistema/avatars/1.jpg" alt="..." class="avatar-img rounded-circle">
                                </div>
                                <div class="info">
                                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                        <span>
                                            Leonardo
                                            <span class="user-level">Administrator</span>
                                            <span class="caret"></span>
                                        </span>
                                    </a>
                                    <div class="clearfix"></div>

                                    <div class="collapse in" id="collapseExample">
                                        <ul class="nav">
                                            <li>
                                                <a href="' . $this->RUTA . 'sistema/perfil"><span class="link-collapse">MI perfil</span></a>
                                            </li>
                                            <li>
                                                <a href="#edit"><span class="link-collapse">Editar Perfil</span></a>
                                            </li>
                                            <li>
                                                <a href="#settings"><span class="link-collapse">Configuración</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-primary">' . (isset($vistas['ordenes']) ? '
                                <li class="nav-item active submenu">
                                    <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                        <i class="fas fa-home"></i><p>VENDER</p><span class="caret"></span>
                                    </a>
                                    <div class="collapse ' . ($active == 'ordenes' ? 'show' : "") . '" id="dashboard">
                                        <ul class="nav nav-collapse">
                                            <!--<li ' . ($sub_menu == 'notatest' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/notatest">
                                                    <span class="sub-item">Nueva nota</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'nota_modelo_viejo' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/nota_modelo_viejo">
                                                    <span class="sub-item">Nueva nota modelo viejo</span>
                                                </a>
                                            </li>-->
                                            <li ' . ($sub_menu == 'nueva_venta' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/ventas">
                                                    <span class="sub-item">Vender</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'notas_venta' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/ventas/notas">
                                                    <span class="sub-item">Notas de ventas</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>' : "") . (isset($vistas['stock']) ? '
                                <li class="nav-item active submenu">
                                    <a data-toggle="collapse" href="#stock" class="collapsed" aria-expanded="false">
                                        <i class="fas fa-store"></i><p>STOCK</p><span class="caret"></span>
                                    </a>
                                    <div class="collapse ' . ($active == 'stock' ? 'show' : "") . '" id="stock">
                                        <ul class="nav nav-collapse">
                                            <li ' . ($sub_menu == 'inventario' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/inventario">
                                                    <span class="sub-item">Inventario</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'materiaprima' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/materiaprima">
                                                    <span class="sub-item">Materia prima</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'modelos' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/produccion/modelos">
                                                    <span class="sub-item">Modelos</span>
                                                </a>
                                            </li>
                                            <!--<li ' . ($sub_menu == 'modelos_viejos' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/produccion/modelos_viejos">
                                                    <span class="sub-item">Modelos Viejos</span>
                                                </a>
                                            </li>-->
                                            <li ' . ($sub_menu == 'anaqueles' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/anaqueles">
                                                    <span class="sub-item">Anaqueles</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'burros' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/burros">
                                                    <span class="sub-item">Burros</span>
                                                </a>
                                            </li>                                            
                                        </ul>
                                    </div>
                                </li>' : "") . (isset($vistas['proveedores']) ? '
                                <li class="nav-item active submenu">
                                    <a data-toggle="collapse" href="#proveedores_menu" class="collapsed" aria-expanded="false">
                                        <i class="fas fa-user-friends"></i><p>PROVEEDORES</p><span class="caret"></span>
                                    </a>
                                    <div class="collapse ' . ($active == 'proveedores' ? 'show' : "") . '" id="proveedores_menu">
                                        <ul class="nav nav-collapse">
                                            <li ' . ($sub_menu == 'proveedores' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/proveedores">
                                                    <span class="sub-item">Proveedores</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'nota_proveedor' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/proveedor/nueva_nota">
                                                    <span class="sub-item">Nota proveedor</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'notas' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/proveedor/notas">
                                                    <span class="sub-item">Todas las notas</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>' : "") . (isset($vistas['usuarios']) ? '
                                <li class="nav-item active submenu">
                                    <a data-toggle="collapse" href="#usuarios" class="collapsed" aria-expanded="false">
                                        <i class="fas fa-user-friends"></i><p>USUARIOS</p><span class="caret"></span>
                                    </a>
                                    <div class="collapse ' . ($active == 'usuarios' ? 'show' : "") . '" id="usuarios">
                                        <ul class="nav nav-collapse">
                                            <li ' . ($sub_menu == 'usuarios' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/usuarios">
                                                    <span class="sub-item">Usuarios</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'grupos' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/grupos">
                                                    <span class="sub-item">Grupos</span>
                                                </a>
                                            </li>
                                            <li ' . ($sub_menu == 'clientes' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/clientes">
                                                    <span class="sub-item">Clientes</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>' : "") . (isset($vistas['produccion']) ? '
                                <li class="nav-item active submenu">
                                    <a data-toggle="collapse" href="#produccion_menu" class="collapsed" aria-expanded="false">
                                        <i class="fas fa-project-diagram"></i><p>PRODUCCIÓN</p><span class="caret"></span>
                                    </a>
                                    <div class="collapse ' . ($active == 'produccion' ? 'show' : "") . '" id="produccion_menu">
                                        <ul class="nav nav-collapse">
                                            <li ' . ($sub_menu == 'categorias' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/categorias">
                                                    <span class="sub-item">Categorías</span>
                                                </a>
                                            </li>
                                            
                                            <li ' . ($sub_menu == 'nueva_orden' ? 'class="active"' : "") . '>
                                                <a href="' . $this->RUTA . 'sistema/produccion">
                                                    <span class="sub-item">Nueva orden</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>' : "") . (isset($vistas['procesos']) ? '
                                <li class="nav-section">
                                    <span class="sidebar-mini-icon">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </span>
                                    <h4 class="text-section">Procesos</h4>
                                </li>' : "") . ((isset($vistas['produccion']) && isset($vistas['produccion']['ordenes_produccion']))  ? '
                                <li class="nav-item">
                                    <a href="' . $this->RUTA . 'sistema/orden">
                                        <i class="fas fa-layer-group"></i>
                                        <p>Orden de producción</p>
                                    </a>
                                </li>' : "") . (isset($vistas['orden']) ? '
                                <li class="nav-item">
                                    <a  href="' . $this->RUTA . 'sistema/orden">
                                        <i class="fas fa-layer-group"></i>
                                        <p>Orden de producción</p>
                                    </a>
                                </li>' : "") . (isset($vistas['stock']) ? '
                                <li class="mx-4 mt-2">
                                    <a href="' . $this->RUTA . 'sistema/tareas" class="btn btn-primary btn-block"><span class="btn-label mr-2"> <i class="fa fa-heart"></i> </span>Mis tareas</a>
                                </li>' : "") . '
                            </ul>
                        </div>
                    </div>
                </div>
           
        ';
        echo $header_admin;
    }
    function footer_admin()
    {
        $admin_footer = ' <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="' . $this->RUTA . '/documentos/manual.pdf">
                                Manual de usuario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Ayuda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Soporte
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto">' . date('Y') . ', Desarrollado por:  <a href="' . $this->RUTA . '/documentos/manual.pdf"> CODE RALEEM SOFTWARE</a>
                </div>
            </div>
        </footer>';
        echo $admin_footer;
    }
}
