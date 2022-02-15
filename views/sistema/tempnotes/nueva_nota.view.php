<?php

use App\Models\Funciones;
use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$FUNC = new Funciones();

$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('ordenes', 'notatest'); ?>

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-1">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white fw-bold pb-0">NOTA</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col px-0">
                            <div class="card mb-0" id="formulario_productos">
                                <div class="card-body py-0 text-center contenedor_titulos">
                                    <h2 class="mb-0" style="display: none;">Agregar producto</h2>
                                    <a class="btn btn-primary btn-border btn-round evento_producto" data-estado="open">Agregar producto <i class="fas fa-cash-register ml-4 "></i></a>
                                </div>
                                <div class="card-body py-0 contenedor_form" style="display: none;">
                                    <div class="form">
                                        <form id="form_new_producto" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xl-3 col-md-4 col-sm-3 col-6 px-0 my-1 text-center">
                                                    <div class="form-group py-0 cont_modelo">
                                                        <label class="mb-0"># Modelo</label>
                                                        <div class="input-group ">
                                                            <input type="text" class="form-control" name="modelo" placeholder="FFFF00" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-2 col-sm-3 col-6 px-0 my-1 text-center">
                                                    <div class="form-group py-0 cont_cantidad">
                                                        <label class="mb-0">Cantidad</label>
                                                        <div class="input-group ">
                                                            <input type="number" class="form-control" name="cantidad" placeholder="00" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-6 col-12 px-0 my-1 text-center">
                                                    <div class="form-group py-0">
                                                        <label class="mb-0">Color</label>
                                                        <div class="selectgroup w-100">
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="color" value="N/A" class="selectgroup-input" checked="" autocomplete="off">
                                                                <span class="selectgroup-button">N/A</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="color" value="kaki" class="selectgroup-input" checked="" autocomplete="off">
                                                                <span class="selectgroup-button">KAKI</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="color" value="rosa" class="selectgroup-input" checked="" autocomplete="off">
                                                                <span class="selectgroup-button">ROSA</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="color" value="BCO" class="selectgroup-input" checked="" autocomplete="off">
                                                                <span class="selectgroup-button">BCO</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="color" value="PER" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">PER</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" name="color" value="CHA" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">CHA</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-4 col-sm-4 col-12 px-0 my-1 text-center">
                                                    <div class="form-group py-0">
                                                        <label class="mb-0">Talla</label>
                                                        <div class="selectgroup w-100">
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="talla" value="N/A" class="selectgroup-input" checked="" autocomplete="off">
                                                                <span class="selectgroup-button">N/A</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="talla" value="3M" class="selectgroup-input" checked="" autocomplete="off">
                                                                <span class="selectgroup-button">3M</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="talla" value="6M" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">6M</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="talla" value="1" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">1</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="talla" value="2" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">2</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-6 col-12 px-0 my-1 text-center">
                                                    <div class="form-group py-0 my-0">
                                                        <label class="mb-0">Tipo</label>
                                                        <div class="selectgroup w-100">
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="N/A" class="selectgroup-input" checked=""  autocomplete="off">
                                                                <span class="selectgroup-button">N/A</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="PAN" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">PAN </span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="BOM" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">BOM</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="DES" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">DES</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="TIR" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">TIR</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="SHO" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">SHO</span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="tipo" value="VES" class="selectgroup-input" autocomplete="off">
                                                                <span class="selectgroup-button">VES</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-4 col-sm-4 col-6 px-0 my-1 text-center">
                                                    <div class="form-group py-0 ">
                                                        <label class="mb-0">P. UNITARIO</label>
                                                        <div class="input-group cont_precio">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="precio" placeholder="0000.00" step="any" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right mt-2 mb-3">
                                                    <button class="btn btn-success btn-border btn-round p-1 pl-2" type="submit">Añadir producto <i class="fas fa-plus-circle mx-3"></i></button>
                                                </div>
                                                <div class="col-12 text-right mb-2">
                                                    <a class="btn btn-warning btn-border btn-round p-1 pl-2 evento_producto" data-estado="hide">Cerrar ventana <i class="fas fa-chevron-up mx-3"></i></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form id="form_search_almacen" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                        </div>
                                        <input type="text" class="form-control" name="buscador" placeholder="Buscar entre los modelos registrados" autocomplete="off">
                                    </div><input type="button" value="" hidden class="d-none">
                                </div>
                            </form>
                        </div>
                        <div class="col-12 clientes-h">
                            <div class="row " id="contenedor_modelos"></div>
                            <div class="row justify-content-center bg-white my-2" id="paginacion">
                                <div class="col-md-6 col-8  " style="display: none;">
                                    <a class="btn btn-secondary btn-border btn-round btn-block">Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right py-0" style="display: none;"><a class="btn btn-danger btn-border btn-round btn-sm" id="borrar_busqueda"> <i class="far fa-times-circle"></i> CERRAR</a></div>
                    </div>
                    <div class="row">
                        <div class="col px-0">
                            <div class="card">
                                <div class="card-body pb-0 text-center">
                                    <div class="row">
                                        <div class="col">
                                            <h2>Nota <?php echo $TEMPLATE->SISTEMNAME; ?></h2>
                                            <input type="hidden" value="<?php echo date("Y-m-d"); ?>" hidden id="fecha_actual" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0" id="config_nota_cliente" style="cursor: pointer;">
                                    <div class="text-right">
                                        <div class="">
                                            <small class="text-muted"><?php echo date('d') . " de " . $FUNC->meses(((int)date('m'))) . " de " . date('Y') ?></small>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="avatar avatar-online">
                                            <span class="avatar-title rounded-circle border border-white bg-info">J</span>
                                        </div>
                                        <div class="flex-1 ml-3 pt-1">
                                            <h6 class="text-uppercase fw-bold mb-1">Nombre: <span class="text-muted pl-3">Sin nombre de cliente</span></h6>
                                            <p class="my-0 py-0">Dirección:<span class="text-muted"> Sin dirección</span></p>
                                            <p class="my-0 py-0">Ciudad:<span class="text-muted"> Sin ciudad</span></p>
                                            <p class="my-0 py-0">Email:<span class="text-muted"> no-email@email.com</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col table-responsive" id="tabla_nota">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-6 my-2"><a class="btn btn-warning btn-border btn-round  btn-block" id="clear_nota_venta"> <span class="btn-label"> <i class="fas fa-broom"></i></span>Limpiar nota</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner py-0">
                    <div class="continuar_venta active">
                        <div class="row vender" id="print_PDF">
                            <div class="col pt-2 mt-1 text-center">
                                <!-- <h3 class="ml-5" id="total_nota"> <a href="<?php //echo $RUTA; ?>sistema/pagonota"><span class="cantidad">0</span> prod <span class="total">$0.00 mxn</span></a></h3> -->
                                <h3 class="ml-5" id="total_nota"> <a><span class="cantidad">0</span> prod <span class="total">$0.00 mxn</span></a></h3>
                            </div>
                            <div class="col-2 pt-2 mt-1">
                                <i class="fas fa-hand-point-right fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_config_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10001;">
                    <div class="modal-dialog modal-" role="document">
                        <div class="modal-content">
                            <div class="modal-header py-2 px-2 ">
                                <h4 class="mx-auto">Seleccionar cliente</h4>
                                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card card-post card-round">
                                    <div class="card-body p-1">
                                        <div class="card mb-0" id="formulario_clientes">
                                            <div class="card-body py-0">
                                                <div class="form-group px-0">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="number_icon"><i class="fas fa-sort-numeric-up-alt"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control" id="numero" placeholder="Número de nota  " aria-label="Número de nota    " aria-describedby="number_icon" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body py-0 text-center contenedor_titulos">
                                                <a class="btn btn-primary btn-border btn-round show_form_cliente" data-estado="open">Venta al público <i class="fas fa-user-tie ml-4 "></i></a>
                                            </div>
                                            <div class="card-body py-0 contenedor_form" style="display: none;">
                                                <form action="" id="form_config_cliente">
                                                    <div class="form-group px-0 d-none">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="date_icon"><i class="fas fa-calendar-week"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control" name="fecha" placeholder="Fecha " aria-label="Fecha" aria-describedby="date_icon" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group px-0">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="nombre_icon"><i class="fas fa-signature"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" aria-label="Nombre" aria-describedby="nombre_icon" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group px-0">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="direccion_icon"><i class="fas fa-house-user"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="direccion" placeholder="Dirección " aria-label="Dirección" aria-describedby="direccion_icon" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group px-0">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="ciudad_icon"><i class="fas fa-building"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="ciudad" placeholder="Ciudad" aria-label="Ciudad" aria-describedby="ciudad_icon" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group px-0">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="email_icon"><i class="fas fa-at"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="correo" placeholder="Correo" aria-label="Correo" aria-describedby="email_icon" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row">
                                                    <div class="col-12 text-right">
                                                        <a class="btn btn-warning btn-border btn-round p-1 pl-2 show_form_cliente" data-estado="hide">Cerrar ventana <i class="fas fa-chevron-up mx-3"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body cliente_cuerpo">
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="form_search_clientes" method="POST">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-default btn-border" type="button"><i class="fas fa-qrcode"></i></button>
                                                            </div>
                                                            <input type="text" class="form-control" name="buscador" placeholder="Buscar entre los clientes" autocomplete="off">
                                                        </div>
                                                        <input type="button" value="" hidden class="d-none">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12 clientes-h">
                                                <div class="row " id="contenedor_clientes"></div>
                                                <div class="row justify-content-center bg-white my-2" id="paginacion">
                                                    <div class="col-md-6 col-8  " style="display: none;">
                                                        <a class="btn btn-secondary btn-border btn-round btn-block cliente">Mostrar más <i class="fas fa-arrow-circle-down mx-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right py-0" style="display: none;"><a class="btn btn-danger btn-border btn-round btn-sm" id="borrar_busqueda"> <i class="far fa-times-circle"></i> CERRAR</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning p-1 mr-5" id="limpiar_cliente">Limpiar cliente</button>
                                <button type="button" class="btn btn-secondary p-1 ml-1 mr-3" data-dismiss="modal">Salir</button>
                                <button type="button" class="btn btn-primary p-1 ml-3" id="guardar_cliente">Guardar datos</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_descuento" tabindex="-1" role="dialog" aria-labelledby="modal_descuento_label" aria-hidden="true" style="z-index: 10001;">
                    <div class="modal-dialog modal_descuentos" role="document">
                        <div class="modal-content cuerpo">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modal_descuento_label">Aplicar descuento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body form_carrito">
                                <form action="#" id="calculo_descuento" method="post">
                                    <table class="table table-light text-center">
                                        <tbody>
                                            <tr>
                                                <div class="form-group py-0">
                                                    <label class="mb-0">Tipo de descuento</label>
                                                    <div class="selectgroup w-100">

                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="tipodescuento" value="moneda" class="selectgroup-input" checked="" autocomplete="off">
                                                            <span class="selectgroup-button">Moneda</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="tipodescuento" value="porcentaje" class="selectgroup-input" autocomplete="off">
                                                            <span class="selectgroup-button">Porcentaje</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </tr>
                                            <tr>
                                                <td><input type="number" step="any" placeholder="0.0" name="cantidad" class="modificar_precio xxl bb2" attr-tipo="porcentaje" value="" autocomplete="off"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0 "></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0 "></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <a class="btn success-color-dark py-1 px-2 btn-block" id="guardar_descuento">Aplicar descuento</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger py-1 px-2" data-dismiss="modal">Volver</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_notificacion" tabindex="-1" role="dialog" aria-labelledby="modal_descuento_label" aria-hidden="true" style="z-index: 10001;">
                    <div class="modal-dialog modal_descuentos" role="document">
                        <div class="modal-content cuerpo">
                            <div class="modal-header titulo_modal">
                                <h5 class="modal-title mx-auto" id="modal_descuento_label"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body cuerpo_modal">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger py-1 px-2" data-dismiss="modal">Volver</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $TEMPLATE->footer_admin(); ?>
        </div>
    </div>
    <div class="container my-5 py-3"></div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/notatest/notatest.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/notatest/clientes.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/notatest/modelos.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/notatest/send_mail.js"></script>
</body>

</html>