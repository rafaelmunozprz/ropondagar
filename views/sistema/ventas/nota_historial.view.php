<?php

use App\Models\Funciones;
use App\Models\TemplateAdmin;

$TEMPLATE =  new TemplateAdmin($USERSYSTEM);
$FUNC = new Funciones();
$TEMPLATE->jsBarCode = true;
$TEMPLATE->header();
$TEMPLATE->library_admin(); ?>

<body>
    <div class="wrapper">
        <?php $TEMPLATE->nav_bar_admin('clientes', 'nota_cliente'); ?>

        <div class="main-panel">
            <div class="content">
                <input type="hidden" id="id_nota" value="<?php echo $id_nota; ?>" hiden style="display: none" disabled class="d-none disabled" autocomplete="off">
                <div class="page-inner pt-2 " style="background-color: #69696950;">
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice p-3 mb-3 ">
                                <div class="row">
                                    <div class="col-12 px-sm-1 px-0">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <h5><i class="fas fa-info"></i> Nota:</h5>
                                                Solamente es una vista de la nota si quieres hacer algun pago a las notas es necesario hacerlo en el listado de notas o en el perfil del cliente.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Cuerpo de la nota -->
                                <div id="cuerpo_invoice">
                                    <div class="row invoice-info">
                                        <div class="col-12 px-sm-1 px-0">
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4>
                                                                <i class="fas fa-globe"></i> Rop??n Dagar.
                                                                <small class="float-right">Fecha: <?php echo date('d/m/Y'); ?></small>
                                                            </h4>
                                                        </div>
                                                        <div class="col-sm-4 invoice-col">
                                                            <address>
                                                                <strong>Rop??n Dagar.</strong><br>
                                                                Prolongaci??n Macias #212, C.P. 47140<br>
                                                                <b>Col. </b>Sagrada Familia<br>
                                                                <b>RFC: </b>AOGA730511IC3<br>
                                                                <b>TEL: </b>347 106 4585, <br>
                                                                <b>CEL: </b>347 108 0422
                                                            </address>
                                                        </div>
                                                        <div class="col-sm-4 invoice-col">
                                                        </div>
                                                        <div class="col-sm-4 invoice-col">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Cuerpo de la nota -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php $TEMPLATE->scripts();
    $TEMPLATE->scripts_admin(); ?>
    <script src="<?php echo $RUTA; ?>js/sistema/ventas_clientes/nota_propiedades/invoice.js"></script>
    <script src="<?php echo $RUTA; ?>js/sistema/ventas_clientes/nota_propiedades/vista_nota.js"></script>

</body>

</html>