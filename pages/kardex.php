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
$rand = '?v='.rand(0,9999999);

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();


$data_kardex = array();

$query = '';

if( isset($_POST["txtBuscar"]) ){
    $query = " WHERE var_NombreProducto LIKE '%".$_POST["txtBuscar"]."%' ";
}

$data_kardex = $OBJ->get_Kardex( $query );


?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Kardex</title>

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
    td:nth-of-type(1):before { content: "Fecha:"; }
    td:nth-of-type(2):before { content: "Producto:"; }
    td:nth-of-type(3):before { content: "Documento:"; }
    td:nth-of-type(4):before { content: "Tipo:"; }
    td:nth-of-type(5):before { content: "Entrada:"; }
    td:nth-of-type(6):before { content: "Salida:"; }
    td:nth-of-type(6):before { content: "Saldo:"; }
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
                    <h1 class="page-header">Kardex</h1>
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
                        <li class="active" >Kardex</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row  -->

            <div class="row">
                <div class="col-lg-12">

                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                
                            </div>
                            <!-- /.navbar-header -->

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <form id="frmBuscar" class="navbar-form navbar-right" role="search" autocomplete="off" method="post" >
                                    <div class="form-group">
                                        <input id="txtBuscar" name="txtBuscar" type="text" class="form-control" placeholder="Producto" required value="<?php if( isset($_POST["txtBuscar"]) ){$_POST["txtBuscar"];}?>" />
                                    </div>
                                    <!-- /.form-group -->
                                    <button type="submit" class="btn btn-primary btn-outline">
                                        <span class="glyphicon glyphicon-search" ></span> Buscar
                                    </button>
                                </form>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                    <!-- /.navbar -->
                </div>
            </div>
            <!-- /.row -->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Inventarios actuales.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- .table -->
                            <table class="table" >
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th>Documento</th>
                                    <th>Tipo</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Saldo</th>
                                </tr>
                                </thead>
                                <tbody>
<?php
    if( is_array($data_kardex['data']) ){
        foreach ($data_kardex['data'] as $key => $rs ) {
?>
                                <tr>
                                    <td><?php echo $rs->fecha; ?></td>
                                    <td><?php echo $rs->var_NombreProducto.' '.$rs->var_UnidadMedida; ?><br/><small><?php echo $rs->var_Descri; ?></small></td>
                                    <td><?php echo $rs->var_Mascara; ?></td>
                                    <td><?php echo $rs->chr_TipoDoc; ?></td>
                                    <td><?php echo $rs->int_Entrada; ?></td>
                                    <td><?php echo $rs->int_Salida; ?></td>
                                    <td><?php echo $rs->int_Saldo; ?></td>
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
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

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
    <script src="../dist/js/kardex.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>

