<?php
session_start();
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

if( $_SESSION["ziel_idu"] == '' ){
    header('location: login.php');
}
#en caso sea cajero y llegue hasta aqui lo mando al login
if( $_SESSION["ziel_tipo"] != 'A' ){ header('location: login.php'); }
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
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);

$data_promos = array();

$data_promos = $OBJ->get_promo_listado('');

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Promociones</title>

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
    td:nth-of-type(1):before { content: "Id:"; }
    td:nth-of-type(2):before { content: "Nombre:"; }
    td:nth-of-type(3):before { content: "tipo:"; }
    td:nth-of-type(4):before { content: "Creado:"; }
    td:nth-of-type(5):before { content: "Estado:"; }
    td:nth-of-type(6):before { content: ""; }
}   
</style>

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
                    <h1 class="page-header" >Todas las promociones</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li class="active" >Promociones</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline" >
                        <li>
                            <a href="nueva-promocion.php" class="btn btn-primary btn-outline" ><i class="fa fa-plus"></i> Nueva Promoción</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->

                    

            <div class="panel panel-default">
                <div class="panel-heading">Mostrando todas las promociones</div>
                <div class="panel-body">

                <!-- .table -->
                <table class="table table-hover" >
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>tipo</th>
                        <th>Creado</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
<?php

if( is_array( $data_promos['data'] ) ){

    foreach ( $data_promos['data'] as $key => $rs ) {
        $cla = ''; $para = '';
        switch ($rs->chr_Estado) {
            case 'ADJ':
                $cla = 'success';
                break;
            case 'DEL':
                $cla = 'danger';
                break;
        }
?>
                        <tr id="Fila_<?php echo $rs->int_IdPromocion; ?>" class="<?php echo $cla; ?>" >
                            <td>
                                <?php echo $rs->int_IdPromocion; ?>
                            </td>
                            <td>
                                <a href="nueva-promocion.php?idpromo=<?php echo $rs->int_IdPromocion; ?>" ><span class="fa  fa-file-text-o" ></span> <strong><?php echo $rs->var_Nombre; ?></strong></a><br/>
                                <small><?php echo $rs->var_Mascara; ?></small>
                            </td>
                            <td><?php echo $rs->var_Para; ?></td>
                            <td><?php echo $rs->fecha; ?></td>
                            <td id="Estado_<?php echo $rs->int_IdPromocion; ?>" ><?php echo $rs->chr_Estado; ?></td>
                            <td>
                            <?php if( $rs->chr_Estado == 'ACT' ){ ?>
                                <a class="anularPromo pull-left btn btn-primary btn-outline" href="<?php echo $rs->int_IdPromocion; ?>" alt="" data-toggle="tooltip" data-placement="top" title="Anular Promoción" >
                                    <i class="fa fa-times"></i>
                                </a>
                            <?php } ?>
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
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
		</div>
    	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Popup -->
<?php include_once('popup1.php'); ?>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/promociones.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>
