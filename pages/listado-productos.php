<?php
session_start();
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$rand = '?v='.rand(0,9999999);

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

/**/
$OBJ = new Usuario();

$tag = sha1( $tag );

$arr_productos = array();
$arr_productos = $OBJ->get_productos_lista('');

/**/
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Productos</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
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



</head>

<body style="background-color: #FFF;" >

<div class="container">
    <div class="row">
        <?php
        if( is_array($arr_productos['data']) ){
            foreach ( $arr_productos['data'] as $key => $rs) {
        ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
            <table class="table" >
                <tbody>
                    <tr>
                        <td colspan="2" ><?php echo $rs['producto']; ?></td>
                    </tr>
                    <tr>
                        <td>Cantidad</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <!-- table Producto -->
        </div><!-- /col -->
        <?php
            }
        }
        ?>
    </div><!-- row -->
</div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>