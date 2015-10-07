<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$rand = '?v='.rand(0,9999999);

$tag = sha1($tag);


if( isset($_POST["btnGo"]) ){

    include_once '../php/mysql.class/mysql.class.php';
    include_once '../php/clases/clsUsuario.php';
    $OBJ = new Usuario();

    $correo     = $_POST["correo"];
    $clave      = $_POST["clave"];

    $arr_login = array();

    $arr_login = $OBJ->login_usuario( $correo , $clave );

    if( is_array($arr_login) ){
        foreach ($arr_login['data'] as $key => $rs) {
            session_start();
            $_SESSION["ziel_idu"]       = $rs->int_IdUsuario;
            $_SESSION["ziel_user"]      = $rs->var_Usuario;
            $_SESSION["ziel_nombre"]    = $rs->Var_Nombre;
            $_SESSION["ziel_tipo"]      = $rs->cht_Tipo;
        }
        header('location:index.php');
    }

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

    <title>Login Ziel</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Animated -->
    <link rel="stylesheet" href="../js/animated/animate.css">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
    
        <div class="row">
            <h1 class="text-center wow fadeInDown" >Ziel <small>versión 1.0</small></h1>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default wow fadeInUp">
                    
                    <div class="panel-body">
                        <form role="form" method="post" autocomplete="off" class="wow bounceIn" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="correo" id="correo" type="text" autofocus required />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="clave" id="clave" type="password" value="" />
                                </div>
                                <!--<div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>-->
                                <!-- Change this to a button or input when using this as a form -->
                                <input name="btnGo" id="btnGo" type="submit" class="btn btn-success btn-outline" value="Iniciar session" />
                            </fieldset>
                        </form>

                    </div>
                    <div class="panel-footer">
                        <a href="ayuda.php">Ayuda</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- WOW -->
    <script type="text/javascript" src="../js/animated/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/login.js"></script>

</body>

</html>
