<?php
session_start();
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

if( $_SESSION["ziel_idu"] == '' ){
    header('location: login.php');
}
$idu = $_SESSION["ziel_idu"];
$tipoUsuarioZiel = $_SESSION["ziel_tipo"];


$rand = '';
$tag = date('d-m-y H-i-s');
$rand = '?v='.rand(0,9999999);
$idproducto = '';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);


$num_pedidos = 0;
$num_pedidos = $OBJ->count_pedidos(' WHERE DATE(`ts_Registro`) = CURRENT_DATE() ');

$num_facturas = 0;
$num_facturas = $OBJ->count_facturas(' AND DATE(`ts_Registro`) = CURRENT_DATE() ');

$num_boletas = 0;
$num_boletas = $OBJ->count_boletas(' AND DATE(`ts_Registro`) = CURRENT_DATE() ');

$data_grafico = array();
$data_dona = array();

if( $_SESSION["ziel_tipo"] != 'A' ){
    $data_grafico   = $OBJ->grafico_ventas_dias();
    $data_dona      = $OBJ->grafico_prod_mas_vendido_user( $idu );
}else{
    $data_grafico   = $OBJ->grafico_ventas_usuario_dia( $idu );
    $data_dona      = $OBJ->grafico_prod_mas_vendido_user( $idu );
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

    <title>Ziel - Inicio</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Alertify -->
    <link rel="stylesheet" href="../js/alertify/alertify.core.css" />
    <link rel="stylesheet" href="../js/alertify/alertify.default.css" id="toggleCSS" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var _idUsuario = <?php echo $idu; ?>;
        var _data_grafico = [];
        var _data_dona = [];

        <?php 
        if( is_array($data_grafico) ){
            echo '_data_grafico = '. json_encode($data_grafico).';';
        }
        if( is_array( $data_dona ) ){
            echo '_data_dona = '.json_encode($data_dona).';';
        }
        ?>
        console.log(_data_dona);
    </script>

</head>

<body>

    <div id="wrapper">

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
                    <h1 class="page-header">Hola <?php echo $_SESSION["ziel_nombre"]; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_pedidos ?></div>
                                    <div>Nuevos Pedidos</div>
                                </div>
                            </div>
                        </div>
                        <a href="pedidos.php">
                            <div class="panel-footer">
                                <span class="pull-left">Ver todos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div><!-- /.panel Pedidos -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_facturas; ?></div>
                                    <div>Nuevas Facturas</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver todas</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div><!-- /.panel Facturas -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_boletas; ?></div>
                                    <div>Nuevas Boletas</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver todas</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Pedidos Anulados</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalle</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
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
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Ventas el día de hoy
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Movimientos de caja
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Opciones
                                        <span class=" fa fa-th-list "></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="caja.php">Ver todos</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#" id="abrirCaja" >Abrir Caja</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#" id="cerrarCaja" >Cerrar Caja</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
<?php
$arr_caja = array();
$arr_caja = $OBJ->get_listado_caja( " AND c.`int_IdUsuario` = ".$idu." AND DATE(c.`ts_Registro`) =  CURRENT_DATE() " );
?>
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Total</th>
                                                    <th>Estado</th>
                                                    <th>Registro</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tdoc = '';
                                                $link = '';
                                                $total_caja = 0;
                                                if( is_array($arr_caja) ){
                                                foreach ( $arr_caja['data'] as $key => $c ) {
                                                    switch ($c->cht_TipoDoc) {
                                                        case 'B':
                                                            $link = 'nueva-boleta.php?id='.$c->int_IdVenta;
                                                            break;
                                                        case 'F':
                                                            $link = 'nueva-factura.php?id='.$c->int_IdVenta;
                                                            break;
                                                        case 'R':
                                                            $link = 'nuevo-recibo.php?id='.$c->int_IdVenta;
                                                            break;
                                                    }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo $link; ?>"><span class=" fa fa-file-o " ></span> <?php echo $c->var_Mascara; ?></a>
                                                    </td>
                                                    <td class="text-right" ><?php echo number_format($c->flt_Total,2); ?></td>
                                                    <td><?php echo $c->estado_caja; ?></td>
                                                    <td><?php echo $c->fecha_caja; ?></td>
                                                </tr>
                                                <?php
                                                    if( $c->estado_caja == 'ACT' ){
                                                        $total_caja = $total_caja + $c->flt_Total;
                                                    }
                                                }
                                            }
                                                ?>
                                                <tr>
                                                    <td colspan="4" class="text-right" >
                                                        <strong>Total</strong> <?php echo number_format($total_caja,2); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" >Estados caja</th>
                                                </tr>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Monto</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $hoy = date("Y-m-d H:i:s");  
                                                $arr_EstadoCaja = array();
                                                $arr_EstadoCaja = $OBJ->get_estados_caja();
                                                if(is_array( $arr_EstadoCaja['data'] )){
                                                    foreach ( $arr_EstadoCaja['data'] as $key => $rscaja) {
                                                        $a = $rscaja->chr_Accion;
                                                        if( $a == 'A' ){
                                                            $accion = 'Apertura';
                                                            $total = $rscaja->flt_Caja;
                                                        }else{
                                                            $accion = 'Cierre';
                                                            $total = $rscaja->flt_Cierre;
                                                        }
                                                        echo '<tr>';
                                                            echo '<td>'.$accion.'</td>';
                                                            echo '<td>'.number_format($total,2).'</td>';
                                                            echo '<td>'.$rscaja->ts_Registro.'</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-12 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Productos vendidos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                            <?php
                            $arProds = array();
                            $arProds = $OBJ->get_ventas_usuario( $idu );
                            if( is_array($arProds['data']) ){
                                $link = '';
                                foreach ( $arProds['data'] as $key => $rsp ) {
                                    switch ($rsp->tipo) {
                                        case 'B':
                                            $link = 'nueva-boleta.php?id='.$rsp->idv;
                                            break;
                                        case 'F':
                                            $link = 'nueva-factura.php?id='.$rsp->idv;
                                            break;
                                        case 'R':
                                            $link = 'nuevo-recibo.php?id='.$rsp->idv;
                                            break;
                                    }
                                    echo '<a href="'.$link.'" class="list-group-item">';
                                        echo '<i class="fa fa-money fa-fw"></i> '.$rsp->producto;
                                        echo '<span class="pull-right text-muted small"><em>'.$rsp->cant.'</em>';
                                        echo '</span>';
                                    echo '</a>';
                                }
                            }
                            ?>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Producto más vendido
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <a href="rep_producto_mas_vendido.php" class="btn btn-default btn-block">Ver detalles</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <div id="morris-bar-chart"></div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js<?php echo $rand; ?>"></script>

</body>

</html>
