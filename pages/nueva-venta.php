<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

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


$data_clientes = $OBJ->get_all_clientes('');

if( $_GET["id"] != '' ){
    $idVenta = $_GET["id"];
}

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

if( $_GET["t"] != '' ){
    switch ($_GET["t"]) {
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
}

}

$data_detalle = $OBJ->get_detalle_venta( " AND v.`int_idVenta` = ".$idVenta );

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Nueva Venta</title>

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

    <!-- jChosen -->
    <link href="../js/jchosen/chosen.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- UI -->
    <link rel="stylesheet" type="text/css" href="../js/ui/jquery-ui.min.css">

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

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('menu_nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" ><?php echo $NombreDoc; ?></h1>
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
                            <a href="boletas.php">Ventas</a>
                        </li>
                        <li class="active" >Nuevo Venta</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="panel panel-default">
                <div id="labelid" class="panel-heading">
                    <?php echo $NombreDoc; ?> <span class="label label-success" ><?php echo '#'.$Corr; ?></span>
                </div>
                
                <div class="panel-body">
                    <form name="frmData" id="frmData" method="post" autocomplete="off" >
                    <input type="hidden" name="idVenta" id="idVenta" value="<?php echo $idVenta; ?>" />
                    <input type="hidden" name="idPedido" id="idPedido" value="<?php echo $idPedido; ?>" />
                    <input type="hidden" name="TotalVenta" id="TotalVenta" value="<?php echo $totalVenta; ?>" />
                    <input type="hidden" name="idProd" id="idProd" value="0" />
                    <input type="hidden" name="idUM" id="idUM" value="0" />
                    <input type="hidden" name="f" id="f" value="" />
                    <input type="hidden" name="tag" id="tag" value="<?php echo $tag ?>" />
                    
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
                     <div class="form-group">
                        <label for="txtDir">Dirección</label>
                        <input type="text" name="txtDir" id="txtDir" class="form-control" value="<?php echo $dir; ?>" />
                    </div>
                    <!-- /.form-group -->
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="txtFecha">Fecha</label>
                                <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo $fecha_actual; ?>" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php if( $idPedido != '' ){ ?>
                                    <label >Documentos Adjuntos</label>
                                    <a href="nuevo-pedido.php?idpedido=<?php echo $idPedido; ?>" class="form-control" target="_blank" ><span class="fa fa- fa-paperclip " ></span> Pedido #<?php echo $idPedido; ?></a>
                                <?php } ?>
                            </div>
                            <!-- /.form-group -->
                        </div>
                            <!-- /.col -->
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
                    <!-- /.form-group -->
                    <?php } ?>
                    <!-- /.Boton AddProducto -->

                    <!-- Editor de Productos -->
                        <input type="hidden" name="idItem" id="idItem" value="0" />

                                <div id="editorProducto" class=" panel panel-primary " style="display:none;" >
                                    <div class="panel-heading">Agregar un Producto</div>
                                    <div class="panel-body">
                                        <div id="containerProducto" class="form-group">
                                            <label for="txtProducto" >Producto</label>
                                            <input type="text" name="txtProducto" id="txtProducto" value="" class="form-control" />
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <ul class="list-inline addItem" >
                                                <li>
                                                    <input type="number" name="txtCantidad" id="txtCantidad" value="" placeholder="Cantidad" />
                                                </li>
                                                <li>
                                                    <input type="decimal" name="txtPrecio" id="txtPrecio" value="" placeholder="Precio" readonly />
                                                </li>
                                                <li>
                                                    <input type="decimal" name="txtTotal" id="txtTotal" value="" placeholder="Total" readonly />
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="panel-footer">
                                        <button type="button" id="addProducto" data-loading-text="Loading..." class="btn btn-link" autocomplete="off">Agregar</button>
                                        <button type="button" id="cerrarProd" class="btn btn-link" >Cerrar</button>
                                    </div>
                                </div>
                    </form>
                    <!-- /Editor de Productos -->


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
                                        <th>Precio</th>
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
                                            <tr>
                                                <td>
                                                    <a href="<?php echo $rsd["int_IdDetalleVenta"] ?>" class="ItemLista" ><?php echo $rsd["var_Nombre"] .' x '. $rsd["unidadMedida"]; ?></a>
                                                </td>
                                                <td class="text-right" ><?php echo $rsd["int_Cantidad"] ?></td>
                                                <td class="text-right" ><?php echo 'S/. '.$rsd["flt_Precio"] ?></td>
                                                <td class="text-right" ><?php echo $rsd["flt_Total"];$total = $total + $rsd["flt_Total"]; ?></td>
                                                <td>
                                                    <a href="#" class="pull-right quitarProd" rel="" ><span class="glyphicon glyphicon-remove" ></span></a>
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
                            Total de Venta: <?php echo $totalVenta ?>
                        </div>
                    </div>
                    <!-- /Lista de Items -->
                    
                    <!-- /.row -->
                </div>
                <!-- /panel-body -->
                <div class="panel-footer btns">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-6">
                            <a class="btn btn-default" href="boletas.php">Regresar</a>
                        </div>
                        <?php
                        if ( $chr_Estado == 'ACT' ){
                        ?>
                        <div class="col-lg-3 col-md-3 col-xs-6">
                            <button id="SaveVenta" type="button" class="btn btn-primary" data-loading-text="Guardando..." >Guardar Pedido</button>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-6">
                            <button id="CerrarVenta" type="button" class="btn btn-success" data-loading-text="Cerrando..." >Cerrar Venta</button>
                        </div>
                        <?php
                        }
                        if( $chr_Estado != 'DEL' ){
                        ?>
                        <div class="col-lg-3 col-md-3 col-xs-6">
                            <button id="AnularVenta" type="button" class="btn btn-danger" data-loading-text="Anulando..." >Anular Venta</button>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
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

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jChosen -->
    <script type="text/javascript" src="../js/jchosen/chosen.jquery.min.js" ></script>
    <script type="text/javascript" src="../js/jchosen/chosen.proto.min.js" ></script>

    <!-- UI -->
    <script type="text/javascript" src="../js/ui/jquery-ui.min.js" ></script>
    <script type="text/javascript" src="../js/ui/jquery.ui.datepicker-es.js" ></script>

    <!-- Notificacion -->
    <script type="text/javascript" src="../js/notify.min.js" ></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/nueva-venta.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>
