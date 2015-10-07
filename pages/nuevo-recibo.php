<?php
session_start();
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

if( $_SESSION["ziel_idu"] == '' ){
    header('location: login.php');
}
#
$idu = $_SESSION["ziel_idu"];
$tipoUsuarioZiel = $_SESSION["ziel_tipo"];

$rand = '';
$tag = date('d-m-y H-i-s');
$fecha_actual = date('d/m/Y');
$rand = '?v='.rand(0,9999999);
$idproducto = '';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);
$idVenta = 0;
$totalVenta = 0;
$NombreDoc = '';
$data_clientes  = array();
$data_venta   = array();
$data_detalle   = array();
$Corr           = 0;
$estado     = '';
$motivoDel  = '';
$userDel    = '';
$fecDel     = '';

$data_clientes = $OBJ->get_all_clientes('');

if( $_GET["id"] != '' ){
    $idVenta = $_GET["id"];
    $data_detalle = $OBJ->get_detalle_venta01( " AND v.`int_idVenta` = ".$idVenta );
}

$chr_Estado = '';

$data_venta = $OBJ->get_data_venta( $idVenta );

if( is_array( $data_venta["data"] ) ){

    foreach ( $data_venta["data"] as $key => $rsp ) {
        
        $idPedido       = $rsp->int_IdPedido;
        $idCliente      = $rsp->int_IdCliente;
        $nombreCliente  = $rsp->var_Nombre;
        $dir            = $rsp->dir;
        $fecha_actual   = $rsp->fecha;
        $tipoDoc        = $rsp->cht_TipoDoc;
        $Serie          = $rsp->int_Serie;
        $Corr           = $rsp->int_Correlativo;
        $totalVenta     = $rsp->flt_Total;
        $chr_Estado     = $rsp->estado;
        $FormaPago      = $rsp->var_FormaPago;
        $Pago           = $rsp->flt_Pago;
        $Vuelto         = $rsp->flt_Vuelto;
        $Nota           = $rsp->var_Nota;
        $Log            = 'Recibo creado por: '.$rsp->user.' a las '.$rsp->registro;
        #
    }
    unset($rsp);
    if( is_array($data_venta["data_del"]) ){
        foreach ( $data_venta["data_del"] as $key => $rsp ) {
            $motivoDel  = '<p class="text-danger" >Motivo: '.$rsp->txt_MotivoAnulado.' Usuario: <strong>'.$rsp->var_Usuario.'</strong>, Fecha: '.$rsp->fec_anulado.'</p>';
            /*$userDel    = $rsp->var_Usuario;
            $fecDel     = $rsp->fec_anulado;*/
        }
        unset($rsp);
    }

    switch ( $chr_Estado ) {
        case 'CER':
            $estado = 'Cerrado';
            break;
        case 'DEL':
            $estado = 'Anulado';
            break;
        default:
            $estado = 'Activo';
        break;
    }

    switch ($tipoDoc) {
        case 'B':
            $NombreDoc = 'Boleta';
            break;
        case 'F':
            $NombreDoc = 'Factura';
            break;
        case 'R':
            $NombreDoc = 'Recibo';
            break;
    }


}else{
    $Corr = $OBJ->get_max_correlativo( 'R' ) + 1;
}



?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Nuevo Recibo</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../dist/css/estilos.css" rel="stylesheet">

    <!-- Alertify -->
    <link rel="stylesheet" href="../js/alertify/alertify.core.css" />
    <link rel="stylesheet" href="../js/alertify/alertify.default.css" id="toggleCSS" />
    
    <!-- Autocomplete -->
    <link rel="stylesheet" type="text/css" href="../js/auco/jquery.auto-complete.css">

    <!-- Selectize -->
    <link href="../js/selectize/selectize.css" rel="stylesheet">
    
    <!-- Typeahead -->
    <link rel="stylesheet" type="text/css" href="../js/typeahead/typeaheadjs.css">

    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="../js/datepicker/bootstrap-datepicker.min.css">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<style type="text/css">
    .btns .btn{
        margin-right: 30px;
    }
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*
        Label the data
        */
        td:nth-of-type(1):before { content: "Producto:"; }
        td:nth-of-type(2):before { content: "Cantidad:"; }
        td:nth-of-type(3):before { content: "Precio:"; }
        td:nth-of-type(4):before { content: "Total:"; }
        td:nth-of-type(5):before { content: "Opciones:"; }
    }
</style>

<script type="text/javascript">
    var _idu = '<?php echo $idu; ?>';
</script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php 
        if( $tipoUsuarioZiel == 'C' ){
            include_once('menu_cajero.php');
        }else{
            include_once('menu_nav.php');
        }
        ?>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li>
                            <a href="ventas.php">Ventas</a>
                        </li>
                        <li class="active" >Nuevo Recibo</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-primary" >Recibo <small class="text-muted" >Usuario actual: <?php echo $_SESSION["ziel_nombre"]; ?></small></h4>
                        </div>
                        <!-- /panel-heading -->
                        <div class="panel-body">

                            <div id="wrapper_estado">
                                <p>Estado del documento: <strong><?php echo $estado; ?></strong></p>
                            </div>
                            <?php
                                echo '<p>'.$Log.'</p>';
                                echo $motivoDel;
                            ?>
                        </div>
                        <!-- /panel-body -->
                    </div>
                </div>
            </div>
            <!-- /row -->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Encabezado del documento
                </div>
                <!-- /panel-heading -->
                <div class="panel-body">
                    <form name="frmData" id="frmData" method="post" autocomplete="off" >
                        <input type="hidden" name="idVenta" id="idVenta" value="<?php echo $idVenta; ?>" />
                        <input type="hidden" name="idPedido" id="idPedido" value="<?php echo $idPedido; ?>" />
                        <input type="hidden" name="TotalVenta" id="TotalVenta" value="<?php echo $totalVenta; ?>" />
                        <input type="hidden" name="idBenutzer" id="idBenutzer" value="<?php echo $idu; ?>" />
                        <input type="hidden" name="tag" id="tag" value="<?php echo $tag ?>" />
                    
                    <div class="row">
                        <div class="col-lg-2">
                            <!-- Serie del doc -->
                            <div class="form-group">
                                <label for="Corr" >Correlativo</label>
                                <input <?php if( $idVenta != 0 ){ echo 'readonly="readonly"'; } ?> type="number" id="Corr" name="Corr" class="form-control" value="<?php echo $Corr; ?>" >
                            </div>
                        </div>
                        <!-- /col-lg-2 -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="txtNombre" >Cliente</label>
                                <select name="cboCliente" id="cboCliente" class="jChosen" >
                                    <?php
                                    if( is_array($data_clientes['data']) ){
                                        $sel = '';
                                        foreach ($data_clientes['data'] as $key => $rsc ) {
                                            if( $idCliente == $rsc->int_IdCliente ){ $sel = 'selected="selected"'; }else{ $sel = ''; }
                                            echo '<option value="'.$rsc->int_IdCliente.'" '.$sel.' >'.$rsc->var_Nombre.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /col-lg-3 -->
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="txtFecha">Fecha</label>
                                <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo $fecha_actual; ?>" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-lg-2 -->
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="txtDir">Dirección</label>
                                <input type="text" name="txtDir" id="txtDir" class="form-control" value="<?php echo $dir; ?>" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /col-lg-3 -->
                        
                    </div>
                    <!-- /row -->
                    </form>
                </div>
                <!-- /panel-body -->
            </div>
            <!-- /panel -->
        </div>
        <!-- /col-lg-12 -->
    </div>
    <!-- /row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Productos</div>
                <div class="panel-body">

                    <!-- Boton AddProducto -->
                    <div id="wrapper_addProd" class="form-group" >
                        <a id="addNuevoItem" class="btn btn-default btn-outline"  href="#editorProducto" >
                          <span class="glyphicon glyphicon-plus" ></span> Producto
                        </a>
                    </div>
                    <!-- /.form-group -->
                    <!-- /.Boton AddProducto -->

                    <!-- Editor de Productos -->
                    <form id="frmEditor" name="frmEditor" >
                        
                        <input type="hidden" name="idProd" id="idProd" value="0" />
                        <input type="hidden" name="idUM" id="idUM" value="0" />
                        <input type="hidden" name="idDoc" id="idDoc" value="<?php echo $idVenta; ?>" />
                        <input type="hidden" name="tagItem" id="tagItem" value="<?php echo $tag ?>" />
                        <input type="hidden" name="TotalDoc" id="TotalDoc" value="<?php echo $totalVenta; ?>" />
                        <input type="hidden" name="idItem" id="idItem" value="0" />
                        <input type="hidden" name="idLote" id="idLote" value="0" />
                        <input type="hidden" name="f" id="f" value="addItem" />
                        <input type="hidden" name="idBet" id="idBet" value="<?php echo $idu; ?>" />
                        

                            <div id="editorProducto" class=" panel panel-primary " style="display:none;" >
                                <div class="panel-heading">Agregar un Producto</div>
                                <div class="panel-body">
                                    <div id="containerProducto" class="form-group">
                                        <label for="txtProducto" >Producto</label>
                                        <input id="txtProducto" type="text" class="col-md-12 form-control"  autocomplete="off" />
                                    </div><!-- /.form-group -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xs-12">
                                            <label for="txtCantidad" >Cantidad</label>
                                            <input type="text" name="txtCantidad" id="txtCantidad" value="" placeholder="Cantidad" class="form-control" />
                                        </div><!-- /.col -->
                                        <div class="col-lg-3 col-md-3 col-xs-12">
                                            <label for="txtPrecio" >Precio</label>
                                            <input type="text" name="txtPrecio" id="txtPrecio" value="" placeholder="Precio" readonly class="form-control" />
                                        </div><!-- /.col -->
                                        <div class="col-lg-3 col-md-3 col-xs-12">
                                            <label for="txtTotal" >Total</label>
                                            <input type="text" name="txtTotal" id="txtTotal" value="" placeholder="Total" readonly class="form-control" />
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <div class="panel-footer">
                                    <button type="button" id="addProducto" data-loading-text="Loading..." class="btn btn-link" autocomplete="off">Agregar</button>
                                    <button type="button" id="cerrarProd" class="btn btn-link" >Cerrar</button>
                                </div>
                            </div>

                    </form>
                    <!-- /Editor de Productos -->

                    <!-- .table -->
                    <table id="Tablita" class="table" >
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Lote</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        if( is_array($data_detalle["data"]) ){
                            foreach ($data_detalle["data"] as $key => $rsd ) {
                            ?>
                                <tr id="Fila_<?php echo $rsd["int_IdDetalleVenta"] ?>" >
                                    <td>
                                        <span class="fa fa-barcode" ></span> <?php echo $rsd["var_Nombre"] .' x '. $rsd["unidadMedida"]; ?>
                                    </td>
                                    <td><?php echo $rsd["lote"] ?></td>
                                    <td class="text-right" ><?php echo 'S/. '.$rsd["flt_Precio"] ?></td>
                                    <td class="text-right" ><?php echo $rsd["int_Cantidad"] ?></td>
                                    <td class="text-right" ><?php echo $rsd["flt_Total"];$total = $total + $rsd["flt_Total"]; ?></td>
                                    <td>
                                        <?php
                                        if ( $chr_Estado == 'ACT' ){
                                            echo '<a href="'.$rsd["int_IdDetalleVenta"].'" class="pull-right quitarProd" rel="" ><span class="glyphicon glyphicon-remove" ></span></a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                        </table>
                        <!-- /.table -->

                        <div id="LabelTotal" class="panel-footer text-right ">
                            Total Recibo: <?php echo $totalVenta ?>
                        </div>


                </div>
                <!-- /panel-body -->
            </div>
            <!-- /panel -->
        </div>
        <!-- /col-lg-12 -->
    </div>
    <!-- /row -->



    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Forma de Pago</div>
                <!-- /panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="Medio">Medio de Pago</label>
                                <select id="Medio" name="Medio" class="form-control" >
                                    <option value="Efectivo" <?php if( $FormaPago == 'Efectivo' ){ echo 'selected="selected"'; } ?> >Efectivo</option>
                                    <option value="Dolares" <?php if( $FormaPago == 'Dolares' ){ echo 'selected="selected"'; } ?> >Dolares</option>
                                    <option value="Tarjeta" <?php if( $FormaPago == 'Tarjeta' ){ echo 'selected="selected"'; } ?> >Tarjeta</option>
                                </select>
                            </div>
                        </div><!-- /col -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                            <div class="form-group">
                                <label for="CantPago">Pago con</label>
                                <input type="text" name="CantPago" id="CantPago" class="form-control" value="<?php echo $Pago; ?>" onkeypress="return validar(event);" />
                            </div>
                        </div><!-- /col -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                            <div class="form-group">
                                <label for="Vuelto">Vuelto</label>
                                <input readonly type="text" name="Vuelto" id="Vuelto" class="form-control" value="<?php echo $Vuelto; ?>" />
                            </div>
                        </div><!-- /col -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="Obs">Observaciones</label>
                                <input type="text" name="Obs" id="Obs" class="form-control" value="<?php echo $Nota; ?>" />
                            </div>
                        </div><!-- /col -->
                    </div><!-- /row -->
                    <div class="row">
                        <div id="msgPago" class="col-lg-11 col-lg-offset-1"></div>
                    </div>
                </div>
                <!-- /panel-body -->
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group" >
                            <div class="btn-group" role="group">
                                <a class="btn btn-default" href="ventas.php">Regresar</a>
                            </div>
                            <div id="wrap_Imprimir" class="btn-group" role="group">
                                <a id="Imprimir" href="print-venta.php?id=<?php echo $idVenta; ?>" target="_blank" class="btn btn-default" >Imprimir</a>
                            </div>
                            <div id="wrapper_guardar" class="btn-group" role="group">
                                <button id="SaveVenta" type="button" class="btn btn-primary" data-loading-text="Guardando..." >Guardar Recibo</button>
                            </div>
                            <div id="wrapper_cerrar" class="btn-group" role="group">
                                <button id="CerrarVenta" type="button" class="btn btn-success" data-loading-text="Cerrando..." >Cerrar Recibo</button>
                            </div>
                            <div id="wrapper_anular" class="btn-group" role="group">
                                <button id="AnularVenta" type="button" class="btn btn-danger" data-loading-text="Anulando..." >Anular Recibo</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


		</div>
    	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Modal -->
<div class="modal fade" id="ModalPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pedidos</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-center" >Documento generado <span class="label label-success" id="labelPopup" >#</span></h3>
      </div>
      <div class="modal-footer">
        <button id="closeModal" type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- Popup -->
<?php include_once('popup1.php'); ?>

<script id="result-template" type="text/x-handlebars-template">
  <div class="ProfileCard">
    <div class="ProfileCard-details">
        <div class="ProfileCard-avatar"><img class="" src="../images/{{ico}}.png"></div>
        <div class="ProfileCard-realName">{{label}} por {{textum}}</div>
        <div class="ProfileCard-realName">Precio: S/.<strong>{{prec}}</strong>, stock: {{stock}}</div>
    </div>
  </div>
</script>
<script id="empty-template" type="text/x-handlebars-template">
  <div class="EmptyMessage">No hay productos con ese nombre.</div>
</script>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Selectize -->
    <script type="text/javascript" src="../js/selectize/selectize.js" ></script>

    <!-- type head -->
    <script type="text/javascript" src="../js/typeahead/bootstrap-typeahead.js" ></script>
    <script type="text/javascript" src="../js/typeahead/bloodhound.js" ></script>
    <script type="text/javascript" src="../js/typeahead/handlebars-v3.0.3.js" ></script>

    <!-- Datepicker -->
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.es.min.js" ></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/nuevo-recibo.js<?php echo $rand; ?>"></script>

    <!-- Autocomplete -->
    <script type="text/javascript" src="../js/auco/jquery.auto-complete.min.js" ></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

    <script type="text/javascript">
    <?php
    switch ($chr_Estado){
        case 'ACT':
            echo "$('#wrapper_guardar').show();";
            echo "$('#wrapper_cerrar').show();";
            echo "$('#wrapper_anular').show();";
            echo "$('#wrapper_addProd').show();";
            break;
        case 'DEL':
            echo "$('#wrapper_addProd').hide();";
            echo "$('#wrapper_guardar').hide();";
            echo "$('#wrapper_anular').hide();";
            echo "$('#wrapper_cerrar').hide();";
            echo "$('#Imprimir').hide();";
            echo "$('#wrapper_estado').addClass('alert alert-danger');";
        break;
        case 'CER':
            echo "$('#wrapper_cerrar').hide();";
            echo "$('#wrapper_addProd').hide();";
            echo "$('#wrapper_guardar').hide();";
            echo "$('#wrapper_anular').show();";
            echo "$('#wrapper_estado').addClass('alert alert-success');";
        break;
        default:
            echo "$('#wrapper_estado').hide();";
            echo "$('#Imprimir').hide();";
        break;
    }
    ?>
    </script>

</body>

</html>
