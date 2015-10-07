<?php
session_start();
if( $_SESSION["ziel_idu"] == '' ){
    header('location: login.php');
}
$idBenutzer = $_SESSION["ziel_idu"];
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$fecha_actual = date('d/m/Y');
$rand = '?v='.rand(0,9999999);
$idproducto = '';
#$chr_Estado = 'ACT';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);
$idPedido = 0;

$data_clientes  = array();
$data_pedidos   = array();
$data_detalle   = array();
$idCliente      = 0;
$chr_Estado     = '';
$totalPedido    = 0;


$data_clientes = $OBJ->get_all_clientes('');

if( $_GET["idpedido"] != '' ){
    $idPedido = $_GET["idpedido"];
}

$data_pedidos = $OBJ->get_data_pedido( $idPedido );

if( is_array( $data_pedidos["data"] ) ){

    foreach ( $data_pedidos["data"] as $key => $rsp ) {
        $idCliente      = $rsp->int_IdCliente;
        $nombreCliente  = $rsp->var_Nombre;
        $fecha_actual   = $rsp->fecha;
        $chr_Estado     = $rsp->estado;
        $chr_TipoDoc    = $rsp->chr_TipoDoc;
        $var_NumDoc     = $rsp->var_NumDoc;
        $ts_FechaDoc    = $rsp->ts_FechaDoc;
        $totalPedido    = $rsp->flt_Total;
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

$data_detalle = $OBJ->get_detalle_pedido01( " AND p.int_IdPedido = ".$idPedido );

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

    <title>Ziel - Pre Venta</title>

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

    <!-- Autocomplete -->
    <link rel="stylesheet" type="text/css" href="../js/auco/jquery.auto-complete.css">

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
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*
        Label the data
        */
        #Tablita td:nth-of-type(1):before { content: "Producto:"; }
        #Tablita td:nth-of-type(2):before { content: "Cantidad:"; }
        #Tablita td:nth-of-type(3):before { content: "Precio:"; }
        #Tablita td:nth-of-type(4):before { content: "Total:"; }
        #Tablita td:nth-of-type(5):before { content: "Opciones:"; }
    }
</style>

<script type="text/javascript">
    var _idPedido       = '<?php echo $idPedido; ?>';
    var _estado         = '<?php echo $chr_Estado; ?>';
    var _idBenutzer     = '<?php echo $idBenutzer; ?>';
    var _json_clientes  = [];
    <?php
    if( is_array($data_clientes['data']) ){
        $r = array();
        echo '_json_clientes = [';
        foreach ($data_clientes['data'] as $key => $rsc ) {
            array_push($r, " {id: ".$rsc->int_IdCliente.", texto: '".$rsc->var_Nombre."'}") ;
        }
        echo implode(',', $r);
        echo '];';
    }
    ?>
    var _cboCLiente     = [];
    var _idCliente      = <?php echo $idCliente ?>;
</script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('menu_nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >Agregar/Editar Pre-Venta</h1>
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
                            <a href="pedidos.php">Pre venta</a>
                        </li>
                        <li class="active" >Nueva Pre-venta</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

<?php
$arPromos = array();
$arPromos = $OBJ->get_promos_hoy();

    if( is_array($arPromos ) ){
        echo '<strong>Promociones vigentes:</strong><br/>'."\n";
        echo '<ul class="list-group">';
        foreach ($arPromos as $key => $pro) {
?> 
            <li class="list-group-item">
                <u><?php echo $pro["Nombre"]; ?></u><br/>
                <?php echo $pro["Mascara"]; ?>
            </li>
                
<?php
        }
        echo '</ul>';
    }
?>

            <?php
            switch ($chr_Estado) {
                case 'ADJ':
                    echo '<div class="alert alert-success" role="alert"><strong>Atención</strong> Este pedido esta adjunto <u>'. $tipoDoc.' '.$var_NumDoc.'</u></div>';
                    break;
                case 'ADJ':
                    echo '<div class="alert alert-danger" role="alert"><strong>Atención</strong> Este pedido esta anulado</div>';
                    break;
            }
            ?>

            <div class="panel panel-default">
                
                <div class="panel-body">
                    <form name="frmData" id="frmData" method="post" autocomplete="off" class="" >
                        <input type="hidden" name="idPedido" id="idPedido" value="<?php echo $idPedido; ?>" />
                        <input type="hidden" name="TotalPedido" id="TotalPedido" value="<?php echo $totalPedido; ?>" />
                        <input type="hidden" name="f" id="f" value="" />
                        <input type="hidden" name="tag" id="tag" value="<?php echo $tag ?>" />
                        <input type="hidden" name="idBenutzer" id="idBenutzer" value="<?php echo $idBenutzer; ?>" />
                        
                        <div class="panel panel-primary">
                            <div id="labelidPedido" class="panel-heading">Pre venta <?php echo '#'.$idPedido; ?></div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="txtNombre" >Cliente</label>
                                            <select name="cboCliente" id="cboCliente" placeholder="Buscar cliente..." ></select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="txtFecha">Fecha</label>
                                            <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo $fecha_actual; ?>" data-provide="datepicker" />
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                </div>
                                <!-- /.row -->

                                        
                                        
                                <hr/>

                                <!-- Boton AddProducto -->
                                <div class="form-group">
                                    <a id="addNuevoItem" class="btn btn-default btn-outline"  href="#" >
                                      <span class="glyphicon glyphicon-plus" ></span> Producto
                                    </a>
                                </div>
                                <!-- /.Boton AddProducto -->
                    
                    </form>
                                <!-- Editor de Productos -->
                            <form id="frmEditor" name="frmEditor" >
                                
                                <input type="hidden" name="f" id="f" value="addItem" />
                                <input type="hidden" name="idItem" id="idItem" value="0" />
                                <input type="hidden" name="idProd" id="idProd" value="0" />
                                <input type="hidden" name="idUM" id="idUM" value="0" />
                                <input type="hidden" name="idDoc" id="idDoc" value="<?php echo $idPedido; ?>" />
                                <input type="hidden" name="TotalDoc" id="TotalDoc" value="<?php echo $totalPedido; ?>" />
                                <input type="hidden" name="idBet" id="idBet" value="<?php echo $idu; ?>" />
                                <input type="hidden" name="tagItem" id="tagItem" value="<?php echo $tag ?>" />
                                <input type="hidden" name="idLote" id="idLote" value="0" />

                                <div id="editorProducto" class=" panel panel-primary " style="display:none;" >
                                    <div class="panel-heading">Agregar un Producto</div>
                                    <div class="panel-body">
                                        <div id="containerProducto" class="form-group">
                                            <label for="txtProducto" >Producto</label>
                                            <input id="txtProducto" name="txtProducto" type="text" class="col-md-12 form-control"  autocomplete="off" />
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-xs-12">
                                                <label for="txtCantidad" >Cantidad</label>
                                                <input type="text" name="txtCantidad" id="txtCantidad" value="" placeholder="Cantidad" class="form-control" onkeypress="return validar(event);" />
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
                                                                <tr  id="Fila_'<?php echo $rsd->int_IdDetallePedido ?>"  >
                                                                    <td>
                                                                        <span class="fa fa-barcode" ></span> <?php echo $rsd->prod .' x '. $rsd->um; ?>
                                                                        <?php
                                                                        if( $rsd->int_IdPromo != '' ){
                                                                            echo '<br/><small>'.$rsd->var_Promo.' antes ('.$rsd->flt_Precio.')</small>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $rsd->lote ?></td>
                                                                    <?php
                                                                    if( $rsd->int_IdPromo != '' ){
                                                                        echo '<td class="text-right" >S/. '.$rsd->flt_Promo.'</td>';
                                                                    }else{
                                                                        echo '<td class="text-right" >S/. '.$rsd->flt_Precio.'</td>';
                                                                    }
                                                                    ?>
                                                                    <td class="text-right" ><?php echo $rsd->cant ?></td>
                                                                    <td class="text-right" ><?php echo $rsd->flt_Total;$total = $total + $rsd->flt_Total; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        if ( $chr_Estado == 'ACT' ){
                                                                            echo '<a href="'.$rsd->int_IdDetallePedido.'" class="pull-right quitarProd" rel="'.$rsd->var_Nombre.'" ><span class="glyphicon glyphicon-remove" ></span></a>';
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
                                                Total Pre venta: <?php echo $total; ?>
                                            </div>
                                        </div>
                                        <!-- /Lista de Items -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-lg-1 col-md-1 col-xs-12"></div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row tabla detalle de pedido -->
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /panel-body -->
                <div class="panel-footer">
                    <a class="btn btn-default" href="pedidos.php">Regresar</a>
                    <button id="SavePedido" type="button" class="btn btn-success" data-loading-text="Guardando..." >Guardar Pedido</button>
                </div>
            </div>
            <!-- /panel -->

            <!-- Facturar -->
            <div id="panelFacturar" class="panel panel-primary " style="display:none;" >
                <div class="panel-heading">Facturar Pedido de Venta</div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="Documento" >Documento a usar</label>
                            <select name="Documento" id="Documento" class="form-control" >
                                <option value="B" >Boleta</option>
                                <option value="F" >Factura</option>
                                <option value="R" >Recibo</option>
                            </select>
                        </div>
                        <!-- ./form-group -->
                    </form>
                    <!-- /.form -->
                    <form class="form-inline" >
                        <div class="form-group">
                            <label for="Serie">Serie</label>
                            <input type="text" name="Serie" id="Serie" class="form-control" value="001" />
                        </div>
                        <!-- ./form-group -->
                        <div class="form-group">
                            <label for="Correlativo">Correlativo</label>
                            <input type="number" name="Correlativo" id="Correlativo" class="form-control" value="" onkeypress="return validar(event);" />
                        </div>
                        <!-- ./form-group -->
                        <p><small>Si no coloca un correlativo el sistema asignará uno automaticamente</small></p>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a id="btnGoFacturar" class="btn btn-link">Generar</a>
                  </div>
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
        <h3 class="text-center" >Pedido generado <span class="label label-success" id="labelPedido" >#</span></h3>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Datepicker -->
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.es.min.js" ></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Autocomplete -->
    <script type="text/javascript" src="../js/auco/jquery.auto-complete.min.js" ></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/nuevo-pedido.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

    <script type="text/javascript">
    switch(_estado){
        case 'ADJ':
            $('#addNuevoItem').hide();
            $('#panelFacturar').hide();
            $('#SavePedido').hide();
        break;
        case 'DEL':
            $('#addNuevoItem').hide();
            $('#panelFacturar').hide();
            $('#SavePedido').hide();
        break;
        case '':
            $('#panelFacturar').hide();
        break;
        case 'ACT':
            $('#panelFacturar').show();
        break;
    }
    </script>
</body>

</html>
