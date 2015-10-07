<?php
session_start();
if( $_SESSION["ziel_idu"] == '' ){
    header('location: login.php');
}
#en caso sea cajero y llegue hasta aqui lo mando al login
if( $_SESSION["ziel_tipo"] != 'A' ){ header('location: login.php'); }
#
$idBenutzer = $_SESSION["ziel_idu"];
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$rand = '?v='.rand(0,9999999);

$tag = date('d-m-y H-i-s');
$tag = sha1($tag);

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();

include_once '../js/zebra/Zebra_Pagination.php';

$zebra = new Zebra_Pagination();

$id =  $_GET["id"];
$estado = '';

$total = 0;

$total = $OBJ->get_count_detalle_inventario( $id);
$result = 10;


$zebra->records( $total );
$zebra->records_per_page( $result );

#limit 
$limite = ' LIMIT '.( $zebra->get_page() -1 ) * $result.','.$result;


if( $id != '' ){
    $data_Inventarios = array();
    $data_detalle = array();
    $data_Inventarios = $OBJ->get_Inventarios( ' WHERE int_IdAuto = '.$id );

    if( is_array($data_Inventarios["data"]) ){
        #
        foreach ($data_Inventarios["data"] as $key => $rs) {
            $nombre     = $rs->var_Nombre;
            $fecha      = $rs->fecha;
            $estado     = $rs->chr_Estado;
            $Usuario    = $rs->int_IdUsuario;
            $Tipo       = $rs->var_Tipo;
            $Valor      = $rs->int_ValorTipo;
        }
        #
    }
    $data_detalle = $OBJ->get_detalle_inventario( " AND i.int_IdInventario = '".$id."' " , $limite );
}else{ 
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

    <title>Ziel - Nuevo Inventario</title>

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

    <!-- Selectize -->
    <link href="../js/selectize/selectize.css" rel="stylesheet">

    <!-- Alertify -->
    <link rel="stylesheet" href="../js/alertify/alertify.core.css" />
    <link rel="stylesheet" href="../js/alertify/alertify.default.css" id="toggleCSS" />

    <!-- Typeahead -->
    <link rel="stylesheet" type="text/css" href="../js/typeahead/typeaheadjs.css">

    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="../js/datepicker/bootstrap-datepicker.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
    var _pagina     = '<?php echo $zebra->get_page(); ?>';
    var _idu        = '<?php echo $idBenutzer; ?>';
    var _valorCOmbo = '<?php echo $Valor; ?>';
    var _tipoInv    = '<?php echo $Tipo; ?>';
    </script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('menu_nav.php'); ?>

        <div id="page-wrapper">
            
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Inventarios</h1>
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
                        <li>
                            <a href="inventarios.php">Inventarios</a>
                        </li>
                        <li class="active" >Detalle Inventario</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Inventario
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form id="Formulario" name="Formulario" method="post" autocomplete="off" >
                            
                                <input type="hidden" name="idInventario" id="idInventario" value="<?php echo $id; ?>" />
                                <input type="hidden" name="tag" id="tag" value="<?php echo $tag; ?>" />
                                <input type="hidden" name="idBenutzer" id="idBenutzer" value="<?php echo $idBenutzer; ?>" />

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="txtNombre">Nombre</label>
                                            <input type="text" name="txtNombre" id="txtNombre" value="<?php echo $nombre; ?>" class="form-control" />
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-3 -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="txtFecha">Fecha</label>
                                            <input type="text" name="txtFecha" id="txtFecha" value="<?php echo $fecha; ?>" class="form-control" />
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-3 -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="tipoInv">Tipo Inventario</label>
                                            <select name="tipoInv" id="tipoInv" class="comboLindo" >
                                                <option value="Todos" <?php if( $Tipo == 'Todos' ){echo 'selected="selected"';} ?> >Todos los Productos</option>
                                                <option value="Almacen" <?php if( $Tipo == 'Almacen' ){echo 'selected="selected"';} ?> >Almacen Producto</option>
                                                <option value="Clases" <?php if( $Tipo == 'Clases' ){echo 'selected="selected"';} ?> >Clases Producto</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-3 -->
                                    <div id="wrapper_Clases" class="col-lg-3" style="display:none;" >
                                        <div class="form-group">
                                            <label for="valorClases">Seleccione Clase</label>
                                            <select name="valorClases" id="valorClases" >
                                                <option value="-1" >Seleccione Tipo Inventario</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-3 -->
                                    <div id="wrapper_Almacen" class="col-lg-3" style="display:none;" >
                                        <div class="form-group">
                                            <label for="valorAlmacen">Seleccione Almacen</label>
                                            <select name="valorAlmacen" id="valorAlmacen" >
                                                <option value="-1" >Seleccione Tipo Inventario</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col-lg-3 -->
                                </div>
                                <!-- /.row -->   
                            </form>
                            
                            <hr/>

                            <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        
                                        <a id="addNuevoItem" class="btn btn-primary btn-outline navbar-btn"  href="#editorProducto" >
                                          <span class="glyphicon glyphicon-plus" ></span> Producto
                                        </a>
                                    
                                    </div>
                                    <!-- /.navbar-header -->

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <form id="frmBuscar" class="navbar-form navbar-right" role="search" autocomplete="off" >
                                            <div class="form-group">
                                                <input id="txtBuscar" type="text" class="form-control" placeholder="Producto" />
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



                            <!-- Editor de Productos -->
                                <form id="frmItems" name="frmItems" method="post" autocomplete="off" >
                                    <input type="hidden" name="idInv" id="idInv" value="<?php echo $id; ?>" />
                                    <input type="hidden" name="idItem" id="idItem" value="0" />
                                    <input type="hidden" name="f" id="f" value="item" />
                                    <input type="hidden" name="UnidadMedida" id="UnidadMedida" value="" />
                                    <input type="hidden" name="idProd" id="idProd" value="0" />
                                    <input type="hidden" name="tagItem" id="tagItem" value="<?php echo $tag; ?>" />
                                    
                                    <div id="editorProducto" class=" panel panel-primary " style="display:none;" >
                                        <div class="panel-heading">Agregar un Producto</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div id="containerProducto" class="form-group">
                                                        <label for="txtProducto" >Producto</label>
                                                        <input type="text" name="txtProducto" id="txtProducto" value="" class="form-control" />
                                                    </div>
                                                    <!-- /.form-group -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="txtCantidad" >Cantidad</label>
                                                        <input type="number" name="txtCantidad" id="txtCantidad" value="" class="form-control" onkeypress="return validar(event);" />
                                                    </div>
                                                    <!-- /.form-group -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <div class="panel-footer">
                                            <button type="button" id="addProducto" data-loading-text="Loading..." class="btn btn-link" autocomplete="off">Agregar</button>
                                            <button type="button" id="cerrarProd" class="btn btn-link" >Cerrar</button>
                                        </div>
                                    </div>

                                </form>
                                

                                    
                            <!-- /Editor de Productos -->
                            
                            <!-- tabpanel -->
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul id="myTab" class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a id="tab1" href="#home" aria-controls="home" role="tab" data-toggle="tab">Todos</a>
                                    </li>
                                    <li role="presentation">
                                        <a id="tab2" href="#Busqueda" aria-controls="Busqueda" role="tab" data-toggle="tab">Busqueda</a>
                                    </li>
                                </ul>

                                <div class="panel panel-default">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <!-- ********** Resultado inicial -->
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <div class="panel-heading">Productos agregados</div>
                                            <div class="panel-body">
                                                <!-- .table -->
                                                <table id="tblDetalle" class="table" >
                                                    <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Unidad Medida</th>
                                                        <th>Cantidad</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if( is_array($data_detalle['data']) ){
                                                            foreach( $data_detalle['data'] as $key => $r ){
                                                                echo '<tr>';
                                                                    echo '<td><a href="#" class="itemProd" rel="'.$r["int_IdDetalleInv"].'" title="'.$r["var_Nombre"].'" ><span class="fa fa-barcode" ></span> '.$r["var_Nombre"].'</a></td>';
                                                                    echo '<td>'.$r["unidadMedida"].'</td>';
                                                                    echo '<td id="Cant_'.$r["int_IdDetalleInv"].'" class="text-right" >'.$r["int_Cant"].'</td>';
                                                                    echo '<td><a href="#" class="pull-right quitarProd" rel="'.$r["int_IdDetalleInv"].'" ><span class="glyphicon glyphicon-remove" ></span></a></td>';
                                                                echo '</tr>';
                                                            }
                                                        }else{
                                                            echo '<tr><td colspan="4" ><p class="text-center" >Los productos se cargarán al guardar.</p></td></tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!-- .table -->
                                                <?php
                                                $zebra->render();
                                                ?>
                                            </div>
                                            <!-- panel-body -->
                                        </div>
                                        <!-- tab-pane -->
                                        <!-- ********** Resultados de busqueda -->
                                        <div role="tabpanel" class="tab-pane" id="Busqueda">
                                            <div class="panel-heading">Resultados de la busqueda</div>
                                            <div class="panel-body">
                                            <!-- .table -->
                                                <table id="tblResultados" class="table" >
                                                    <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Unidad Medida</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                <!-- .table -->
                                            </div>
                                            <!-- panel-body -->
                                        </div>
                                    </div>
                                    <!-- tab-content -->
                                </div>
                                <!-- panel -->
                            </div>
                            <!-- tabpanel -->

                            
                        </div>
                        <!-- /panel-body -->
                        <div class="panel-footer">
                            <a class="btn btn-default" href="inventarios.php">Regresar</a>
                            <button style="<?php if( $estado == 'CER' ){ echo 'display:none;'; } ?>" id="SaveInventario" type="button" class="btn btn-primary" data-loading-text="Guardando..." >Guardar</button>
                            <button style="<?php if( $estado != 'ACT' ){ echo 'display:none;'; } ?>" id="GenerateInventario" type="button" class="btn btn-success" data-loading-text="Generando..." >Generar Inventario</button>
                        </div>
                        <!-- /panel-footer -->
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
    
    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>
    
    <!-- type head -->
    <script type="text/javascript" src="../js/typeahead/bootstrap-typeahead.js" ></script>
    <script type="text/javascript" src="../js/typeahead/bloodhound.js" ></script>
    <script type="text/javascript" src="../js/typeahead/handlebars-v3.0.3.js" ></script>

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
    <script src="../dist/js/nuevo-inventario.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>

