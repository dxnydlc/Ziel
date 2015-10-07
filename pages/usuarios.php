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

$data_ventas = array();

$data_ventas = $OBJ->get_usuarios_lista('');

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Usuarios</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Typeahead -->
    <link rel="stylesheet" type="text/css" href="../js/typeahead/typeaheadjs.css">

    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="../js/datepicker/bootstrap-datepicker.min.css">

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
    td:nth-of-type(1):before { content: "#:"; }
    td:nth-of-type(2):before { content: "Usuario:"; }
    td:nth-of-type(3):before { content: "Nombre:"; }
    td:nth-of-type(4):before { content: "Correo:"; }
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
                    <h1 class="page-header" >Todos los Usuario</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li class="active" >Usuarios</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <a href="#myModal" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus"></i> Nuevo Usuario</a>
                </div>
                <div class="col-lg-12">
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input id="fecha" type="text" class="form-control" placeholder="Fecha">
                        </div>
                        <a id="btnBuscar" href="#" class="btn btn-default"><i class="fa fa-search"></i> Buscar</a>
                    </form>
                </div>
                <!-- col-lg-6 -->
            </div>
            <!-- /.row -->



            <div class="row">
                <div class="col-lg-12">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Todos</a></li>
                            <!--<li role="presentation"><a href="#Activos" aria-controls="Activos" role="tab" data-toggle="tab">Activos</a></li>
                            <li role="presentation"><a href="#Anulados" aria-controls="Anulados" role="tab" data-toggle="tab">Anulados</a></li>
                            <li role="presentation"><a href="#Busqueda" aria-controls="Busqueda" role="tab" data-toggle="tab">Busqueda</a></li>-->
                        </ul>

                <div class="panel panel-default">
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <!-- ********** Resultado inicial -->
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="panel-heading">Mostrando todos lo usuarios</div>
                            <div class="panel-body">
                                <!-- .table -->
                                <table id="tblUser" class=" table table-hover " >
                                    <thead>
                                        <tr>
                                            <th>#</th><th>Usuario</th><th>Nombre</th><th>Correo</th><th>Tipo</th><th>Estado</th><th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if( is_array( $data_ventas['data'] ) ){
                                            foreach ( $data_ventas['data'] as $key => $rs ) {
                                                $cla = ''; $tdoc = '';
                                                switch ($rs->chr_estado) {
                                                    case 'DEL':
                                                        $cla = 'danger';
                                                        break;
                                                }
                                        ?>
                                            <tr class="<?php echo $cla; ?>" >
                                                <td><?php echo $rs->int_IdUsuario; ?></td>
                                                <td>
                                                    <a class="getUser" href="#" rel="<?php echo $rs->int_IdUsuario; ?>" data-toggle="modal" data-target="#myModal" >
                                                        <span class=" fa  fa-user " ></span> <?php echo$rs->var_Usuario; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $rs->Var_Nombre; ?></td>
                                                <td><?php echo $rs->var_Mail; ?></td>
                                                <td><?php echo $rs->cht_Tipo; ?></td>
                                                <td><?php echo $rs->chr_estado; ?></td>
                                                <td></td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- /.table -->
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
                                            <th>#</th><th>Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th>Usuario</th>
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
                                            <th>#</th><th>Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th>Usuario</th>
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
                                            <th>#</th><th>Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th>Usuario</th>
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
        <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar/editar usuario</h4>
      </div>
      <div class="modal-body">
        <!-- **************************************** -->
        <form name="frmUser" id="frmUser" method="post" >
            <input type="hidden" name="idu" id="idu" value="" />
            <div class="form-group">
                <label for="Nombre">Nombre</label>
                <input name="Nombre" id="Nombre" type="text" class="form-control" >
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label for="Correo">Correo</label>
                <input name="Correo" id="Correo" type="email" class="form-control" >
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label for="Usuario">Usuario</label>
                <input name="Usuario" id="Usuario" type="text" class="form-control" >
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label for="Tipo">Tipo</label>
                <select name="Tipo" id="Tipo" class="form-control" >
                    <option value="C" >Cajero</option>
                    <option value="A" >Administrador</option>
                </select>
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label for="clave">Contraseña</label>
                <input type="password" class="form-control" id="clave" name="clave" >
            </div>
            <!-- form-group -->
            <div class="form-group">
                <label for="clave2">Volver a escribir contraseña</label>
                <input type="password" class="form-control" id="clave2" name="clave2" >
            </div>
            <!-- form-group -->
        </form>
        <!-- **************************************** -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="SaveUser" type="button" class="btn btn-primary">Save changes</button>
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

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script> 

    <!-- Datepicker -->
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.es.min.js" ></script>

    <!-- type head -->
    <script type="text/javascript" src="../js/typeahead/bootstrap-typeahead.js" ></script>
    <script type="text/javascript" src="../js/typeahead/bloodhound.js" ></script>
    <script type="text/javascript" src="../js/typeahead/handlebars-v3.0.3.js" ></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Notificacion -->
    <script type="text/javascript" src="../js/notify.min.js" ></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/usuarios.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>
