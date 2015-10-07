<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$fecha_actual = date('d/m/Y');
$rand = '?v='.rand(0,9999999);
$idproducto = '';
$chr_Estado = 'ACT';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);
$idOC = 0;


$data_clientes  = array();
$data_oc        = array();
$data_detalle   = array();


$data_clientes = $OBJ->get_all_clientes('');

if( $_GET["idoc"] != '' ){
    $idOC = $_GET["idoc"];
}

$data_oc = $OBJ->get_data_oc( $idOC );

if( is_array( $data_oc["data"] ) ){

    foreach ( $data_oc["data"] as $key => $rsp ) {
        
        $idCliente      = $rsp->int_IdCliente;
        $nombreCliente  = $rsp->var_Nombre;
        $fecha_actual   = $rsp->fecha;
        $chr_Estado     = $rsp->estado;
        #
        $chr_TipoDoc    = $rsp->chr_TipoDoc;
        $var_NumDoc     = $rsp->var_NumDoc;
        $ts_FechaDoc    = $rsp->ts_FechaDoc;
        $total          = number_format($rsp->flt_Total,2);

    }

    $tipoDoc = '';
    switch ($chr_TipoDoc) {
        case 'B':
            $tipoDoc = 'Boleta';
            break;
        case 'F':
            $tipoDoc = 'Factura';
            break;
        case 'R':
            $tipoDoc = 'Recibo';
            break;
    }

$data_detalle = $OBJ->get_detalle_oc( " AND p.int_IdOrdenCompra = ".$idOC );

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

    <title>Ziel - Nuevo Orden Compra</title>

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

    <script type="text/javascript">
        var _idPedido = '<?php echo $idOC ?>';
    </script>

<style type="text/css">
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*
        Label the data
        */
        td:nth-of-type(1):before { content: "Producto:"; }
        td:nth-of-type(2):before { content: "Cantidad:"; }
        td:nth-of-type(3):before { content: "P. compra:"; }
        td:nth-of-type(4):before { content: "P. venta:"; }
        td:nth-of-type(5):before { content: "Utilidad:"; }
        td:nth-of-type(6):before { content: "Total:"; }
        td:nth-of-type(7):before { content: "Opciones:"; }
    }
</style>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('menu_nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >Agregar/Editar Orden de Compra</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li>
                            <a href="ordenes-compra.php">Ordenes de Compra</a>
                        </li>
                        <li class="active" >Nueva Orden de Compra</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <?php
            switch ($chr_Estado) {
                case 'ADJ':
                    echo '<div class="alert alert-success" role="alert"><strong>Atención</strong> Esta Orden de Compra está adjunto <u>'. $tipoDoc.' '.$var_NumDoc.'</u></div>';
                    break;
                case 'ADJ':
                    echo '<div class="alert alert-danger" role="alert"><strong>Atención</strong> Esta Orden de Compra está anulada</div>';
                    break;
            }
            ?>

            <div class="panel panel-default">
                
                <div class="panel-body">
                    
                    <form name="frmData" id="frmData" method="post" autocomplete="off" class="" >
                        <input type="hidden" name="idOC" id="idOC" value="<?php echo $idOC; ?>" />
                        <input type="hidden" name="TotalPedido" id="TotalPedido" value="<?php echo $total; ?>" />
                        <input type="hidden" name="f" id="f" value="" />
                        <input type="hidden" name="tag" id="tag" value="<?php echo $tag ?>" />
                        
                        <div class="panel panel-primary">
                            <div id="labelidPedido" class="panel-heading">Orden de Compra <?php echo '#'.$idOC; ?></div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="txtNombre" >Proveedor</label>
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
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="txtFecha">Fecha</label>
                                            <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo $fecha_actual; ?>" />
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                </div>
                                <!-- /.row -->

                                <hr/>

                                <!-- Boton AddProducto -->
                                <?php if( $chr_Estado == 'ACT' ){ ?>
                                <div class="form-group">
                                    <a id="addNuevoItem" class="btn btn-default btn-outline"  href="#editorProducto" >
                                      <span class="glyphicon glyphicon-plus" ></span> Producto
                                    </a>
                                </div>
                                <?php } ?>
                                <!-- /.Boton AddProducto -->
                    </form>
                    <!-- Editor de Productos -->
                    <form name="frmItem" id="frmItem" >
                        <input type="hidden" name="idProd" id="idProd" value="0" />
                        <input type="hidden" name="idUM" id="idUM" value="0" />
                        <input type="hidden" name="idItem" id="idItem" value="0" />
                        <input type="hidden" name="txtUtilidad" id="txtUtilidad" value="0" />

                                <div id="editorProducto" class=" panel panel-primary " style="display:none;" >
                                    <div class="panel-heading">Agregar un Producto</div>
                                    <div class="panel-body">
                                        <div id="containerProducto" class="form-group">
                                            <label for="txtProducto" >Producto</label>
                                            <input id="txtProducto" name="txtProducto" type="text" class="col-md-12 form-control"  autocomplete="off" />
                                        </div><!-- /.form-group -->
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1"></div>
                                            <div id="lblEtiqueta" class="co-lg-10 col-md-10"></div>
                                        </div><!-- /row -->
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <label for="txtCantidad" >Cantidad</label>
                                                <input type="number" name="txtCantidad" id="txtCantidad" value="" class="form-control" />
                                            </div><!-- /.col -->
                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <label for="txtPrecio" >Precio Compra</label>
                                                <input type="text" name="txtPrecio" id="txtPrecio" value="" class="form-control" />
                                            </div><!-- /.col -->
                                            <div class="col-lg-3 col-md-3 col-xs-6">
                                                <label for="txtVenta" id="lblVenta" >Precio Venta</label>
                                                <input type="text" name="txtVenta" id="txtVenta" value="" class="form-control" />
                                            </div><!-- /.col -->
                                            <div class="col-lg-3 col-md-3 col-xs-6">
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
                            </div>
                        </div>
                    </form>

                    <!-- /Editor de Productos -->

                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-xs-12"></div>
                        <!-- /.col -->
                        <div class="col-lg-10 col-md-10 col-xs-12">
                            <!-- Lista de Items -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">Productos</div>
                                <div class="panel-body">
                                    <div class="form-group">

                                        <!-- .table -->
                                        <table id="Tablita" class="table" >
                                            <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Prec. compra</th>
                                                <th>Prec. venta</th>
                                                <th>Utilidad</th>
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
                                                    <tr id="Fila_<?php echo $rsd["int_IdDetalleOC"] ?>" >
                                                        <td>
                                                            <span class="fa fa-barcode" ></span> <?php echo $rsd["var_Nombre"] .' x '. $rsd["unidadMedida"]; ?>
                                                        </td>
                                                        <td class="text-right" ><?php echo $rsd["int_Cantidad"] ?></td>
                                                        <td class="text-right" ><?php echo 'S/. '.$rsd["flt_Precio_Compra"] ?></td>
                                                        <td class="text-right" ><?php echo 'S/. '.$rsd["ftl_Precio_Venta"] ?></td>
                                                        <td class="text-right" ><?php echo ''.$rsd["flt_Utilidad"] ?>%</td>
                                                        <td class="text-right" ><?php echo $rsd["flt_Total"];$total = $total + $rsd["flt_Total"]; ?></td>
                                                        <td>
                                                            <?php
                                                            if ( $chr_Estado == 'ACT' ){
                                                                echo '<a href="'.$rsd["int_IdDetalleOC"].'" class="pull-right quitarProd" rel="'.$rsd["var_Nombre"].'" ><span class="glyphicon glyphicon-remove" ></span></a>';
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

                                      </div>
                                      <!-- /.form-group -->
                                </div>
                                <div id="LabelTotal" class="panel-footer text-right ">
                                    Total de Orden Compra: <?php echo $total; ?>
                                </div>
                            </div>
                            <!-- /Lista de Items -->
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-1 col-md-1 col-xs-12"></div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                            <!-- /panel-body -->
                            <div class="panel-footer">
                                <a class="btn btn-default" href="ordenes-compra.php">Regresar</a>
                                <?php
                                if ( $chr_Estado == 'ACT' ){
                                    echo '<button id="SavePedido" type="button" class="btn btn-success" data-loading-text="Guardando..." >Guardar Orden de Compra</button>';
                                }
                                ?>
                                <a class="btn btn-primary" href="print-ordenes-compra.php?id=<?php echo $idOC; ?>" target="_blank" >Imprimir</a>
                            </div>
                        </div>
                        
                    
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
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
        <h4 class="modal-title" id="myModalLabel">Orden de Compra</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-center" >OC generado <span class="label label-success" id="labelPedido" >#</span></h3>
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

    <!-- Selectize -->
    <script type="text/javascript" src="../js/selectize/selectize.js" ></script>

    <!-- type head -->
    <script type="text/javascript" src="../js/typeahead/bootstrap-typeahead.js" ></script>
    <script type="text/javascript" src="../js/typeahead/bloodhound.js" ></script>
    <script type="text/javascript" src="../js/typeahead/handlebars-v3.0.3.js" ></script>


    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Datepicker -->
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.es.min.js" ></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/nueva-orden-compra.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>
