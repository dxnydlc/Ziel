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
$rand = '?v='.rand(0,9999999);
$idproducto = '';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';
$OBJ = new Usuario();

include_once '../js/zebra/Zebra_Pagination.php';
$zebra = new Zebra_Pagination();

$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);

$data_ventas = array();

$total  = 0;
$result = 10;
$limite = '';

$total = $OBJ->count_listado_ventas();

$zebra->records( $total );
$zebra->records_per_page( $result );

#limit 
$limite = ' LIMIT '.( $zebra->get_page() -1 ) * $result.','.$result;

$data_ventas = $OBJ->get_listado_ventas( '' , $limite );

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Boletas</title>

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
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {    
    /*
    Label the data
    */
    td:nth-of-type(1):before { content: "#:"; }
    td:nth-of-type(2):before { content: "Cliente:"; }
    td:nth-of-type(3):before { content: "Pre-Vta:"; }
    td:nth-of-type(4):before { content: "Fecha:"; }
    td:nth-of-type(5):before { content: "Total:"; }
    td:nth-of-type(6):before { content: "Estado:"; }
    td:nth-of-type(7):before { content: "Usuario:"; }
    td:nth-of-type(8):before { content: ""; }
}   
</style>

<script type="text/javascript">
    var _pagina     = '<?php echo $zebra->get_page(); ?>';
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
            <!--
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >Todas las ventas</h1>
                </div>
            </div>
             /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li class="active" >Todas las ventas</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-primary" >Todas las ventas</h4>
                        </div>
                        <!-- /panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-primary btn-outline" >
                                        Nuevo Documento <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                        <li>
                                            <a href="nueva-boleta.php">Nueva Boleta</a>
                                        </li>
                                        <li>
                                            <a href="nueva-factura.php">Nueva Factura</a>
                                        </li>
                                        <li>
                                            <a href="nuevo-recibo.php">Nuevo Recibo</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- col-lg-6 -->
                                <div class="col-lg-6">
                                    <form class="navbar-form navbar-right" role="search">
                                        <div class="form-group">
                                            <div class="input-daterange input-group">
                                                <input id="txtDesde" name="txtDesde" type="text" class="input-sm form-control" value="" />
                                                <div class="input-group-addon">al</div>
                                                <input id="txtHasta" name="txtHasta" type="text" class="input-sm form-control" value="" />
                                                <a id="btnBuscar" href="#" class="btn btn-default input-group-addon "><i class="fa fa-search"></i> Buscar</a>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                                <!-- col-lg-6 -->
                            </div>
                            <!-- /.row -->
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-primary" >Resultados:</h4>
                        </div>
                        <!-- /panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                                <div class="col-lg-12">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Todos</a></li>
                                            <li role="presentation"><a href="#Activos" aria-controls="Activos" role="tab" data-toggle="tab">Activos</a></li>
                                            <li role="presentation"><a href="#Anulados" aria-controls="Anulados" role="tab" data-toggle="tab">Anulados</a></li>
                                            <li role="presentation"><a href="#Busqueda" aria-controls="Busqueda" role="tab" data-toggle="tab">Busqueda</a></li>
                                        </ul>

                                <div class="panel panel-default">
                                      <!-- Tab panes -->
                                      <div class="tab-content">
                                        <!-- ********** Resultado inicial -->
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <div class="panel-heading">Mostrando las boletas generadas</div>
                                            <div class="panel-body">
                                                <!-- .table -->
                                                <table class=" table table-hover " >
                                                    <thead>
                                                        <tr>
                                                            <th>#</th><th>Cliente</th><th>Pre-Venta</th><th>Fecha</th><th>Total</th><th>Estado</th><th>Usuario</th><th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if( is_array( $data_ventas['data'] ) ){
                                                            foreach ( $data_ventas['data'] as $key => $rs ) {
                                                                $cla = ''; $tdoc = '';
                                                                switch ($rs->estado) {
                                                                    case 'CER':
                                                                        $cla = 'success';
                                                                        break;
                                                                    case 'DEL':
                                                                        $cla = 'danger';
                                                                        break;
                                                                }
                                                                switch ($rs->cht_TipoDoc) {
                                                                    case 'B':
                                                                        $tdoc = 'Boleta '; $link = 'nueva-boleta.php?id=';
                                                                        break;
                                                                    case 'F':
                                                                        $tdoc = 'Factura '; $link = 'nueva-factura.php?id=';
                                                                        break;
                                                                    case 'R':
                                                                        $tdoc = 'Recibo '; $link = 'nuevo-recibo.php?id=';
                                                                        break;
                                                                }
                                                        ?>
                                                            <tr id="Fila_<?php echo $rs->id; ?>" class="<?php echo $cla; ?>" >
                                                                <td><span class=" fa fa-file-o " ></span> <?php echo$rs->var_Mascara; ?></td>
                                                                <td>
                                                                    <a href="<?php echo $link.$rs->id; ?>" ><strong><?php echo $rs->var_Nombre; ?></strong></a>
                                                                </td>
                                                                <td><?php echo sprintf("%05s", $rs->int_IdPedido ); ?></td>
                                                                <td><?php echo $rs->fecha; ?></td>
                                                                <td><?php echo number_format( $rs->flt_Total , 2 ) ?></td>
                                                                <td id="estado_<?php echo $rs->id; ?>" ><?php echo $rs->estado; ?></td>
                                                                <td><?php echo $rs->user; ?></td>
                                                                <td>
                                                                    <ul class="list-inline" >
                                                                        <li>
                                                                            <a class="copiarVenta pull-left btn btn-primary btn-outline" href="<?php echo $rs->id; ?>" alt="" data-toggle="tooltip" data-placement="top" title="Copiar Pedido" >
                                                                                <i class="fa fa-copy"></i>
                                                                            </a>
                                                                        </li>
                                                                        <?php
                                                                        if( $rs->estado != 'DEL' ){
                                                                        ?>
                                                                            <li>
                                                                                <a class="anularDocvta pull-left btn btn-primary btn-outline" href="<?php echo $rs->id; ?>" rel="<?php echo $tdoc; ?>" data-toggle="tooltip" data-placement="top" title="Anular Boleta" ><i class="fa fa-times"></i> </a>
                                                                            </li>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!-- /.table -->
                                                <?php
                                                $zebra->render();
                                                ?>
                                            </div>
                                        </div>
                                        <!-- ********** Resultado Activos -->
                                        <div role="tabpanel" class="tab-pane" id="Activos">
                                            <div class="panel-heading">Mostrando las boletas activas</div>
                                            <div class="panel-body">
                                                <!-- .table -->
                                                <table id="tblActivos" class=" table table-hover " >
                                                    <thead>
                                                        <tr>
                                                            <th>Correlativo</th><th>Cliente</th><th>Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ********** Resultado Anulados -->
                                        <div role="tabpanel" class="tab-pane" id="Anulados">
                                            <div class="panel-heading">Mostrando las boletas anuladas</div>
                                            <div class="panel-body">
                                                <!-- .table -->
                                                <table id="tblAnulados" class=" table table-hover " >
                                                    <thead>
                                                        <tr>
                                                            <th>Correlativo</th><th>Cliente</th><th>Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ********** Resultado Busqueda -->
                                        <div role="tabpanel" class="tab-pane" id="Busqueda">
                                            <div class="panel-heading">Resultados de la busqueda.</div>
                                            <div class="panel-body">
                                                <!-- .table -->
                                                <table id="tblBusqueda" class=" table table-hover " >
                                                    <thead>
                                                        <tr>
                                                            <th>Correlativo</th><th>Cliente</th><th>Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                      </div>
                                </div>
                                    </div><!-- tab panes -->
                                </div><!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /panel-body -->
                    </div>
                    <!-- /panel -->
                </div>
                <!-- /col-lg-12 -->
            </div>
            <!-- /row -->
                            



                            

        </div>
        <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- copiando -->
<div class="modal fade" id="CopiarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Copiar Pedido</h4>
      </div>
      <div class="modal-body">
        <p class="" ><img src="../images/loading.gif" />Copiando Pedido, por favor espere</p>
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

    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Datepicker -->
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.es.min.js" ></script>

    <!-- Selectize -->
    <script type="text/javascript" src="../js/selectize/selectize.js" ></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Notificacion -->
    <script type="text/javascript" src="../js/notify.min.js" ></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/ventas.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>
