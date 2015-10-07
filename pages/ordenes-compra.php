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

$data_pedidos = array();

$data_pedidos = $OBJ->get_oc_listado('');

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Ordenes Compra</title>

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

    <!-- Alertify -->
    <link rel="stylesheet" href="../js/alertify/alertify.core.css" />
    <link rel="stylesheet" href="../js/alertify/alertify.default.css" id="toggleCSS" />

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
    td:nth-of-type(1):before { content: "OC:"; }
    td:nth-of-type(2):before { content: "Proveedor:"; }
    td:nth-of-type(3):before { content: "Fecha:"; }
    td:nth-of-type(4):before { content: "Total:"; }
    td:nth-of-type(5):before { content: "Estado:"; }
    td:nth-of-type(6):before { content: "Opciones:"; }
    td:nth-of-type(7):before { content: "PE:"; }
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
                    <h1 class="page-header" >Todas las Ordenes de Compra</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li class="active" >Ordenes de Compra</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline" >
                        <li>
                            <a href="nueva-orden-compra.php" class="btn btn-primary btn-outline" ><i class="fa fa-plus"></i> Nueva Orden de Compra</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->

                    

            <div class="panel panel-default">
                <div class="panel-heading">Mostrando todos los pedidos generados</div>
                <div class="panel-body">

                <!-- .table -->
                <table class="table" >
                    <thead>
                    <tr>
                        <th>Orden de Compra:</th>
                        <th>Proveedor</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>PE</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
<?php

if( is_array( $data_pedidos['data'] ) ){

    foreach ( $data_pedidos['data'] as $key => $rs ) {
        $tipoDoc = '';
        switch ($rs->chr_TipoDoc) {
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
        $cla = ''; $tdoc = '';
        switch ($rs->estado) {
            case 'ADJ':
                $cla = 'success';
                break;
            case 'DEL':
                $cla = 'danger';
                break;
        }
?>
                        <tr id="Fila_<?php echo $rs->int_IdOrdenCompra; ?>" class="<?php echo $cla; ?>" >
                            <td>
                                <?php echo $rs->int_IdOrdenCompra; ?> 
                            </td>
                            <td>
                                <a href="nueva-orden-compra.php?idoc=<?php echo $rs->int_IdOrdenCompra; ?>" ><span class="fa  fa-file-text-o" ></span> <strong><?php echo $rs->var_Nombre; ?></strong></a>
                            </td>
                            <td><?php echo $rs->fecha; ?></td>
                            <td><?php echo number_format( $rs->flt_Total , 2 ) ?></td>
                            <td><?php echo $rs->estado; ?></td>
                            <td><a href="nuevo-parte-entrada.php?idpe=<?php echo $rs->int_ParteEntrada; ?>">000<?php echo $rs->int_ParteEntrada; ?></a></td>
                            <td></td>
                            <td>
                                <ul class="list-inline" >
                                    <?php
                                    switch ($rs->estado){
                                        case 'ACT':
                                            #Copiar
                                            echo '<li>';
                                                echo '<a class="copiarPedido pull-left btn btn-primary btn-outline" href="'.$rs->int_IdOrdenCompra.'" alt="" data-toggle="tooltip" data-placement="top" title="Copiar Orden Compra" ><i class="fa fa-copy"></i></a>';
                                            echo '</li>';
                                            #Anular
                                            echo '<li>';
                                                echo '<a class="anularPedido pull-left btn btn-primary btn-outline" href="'.$rs->int_IdOrdenCompra.'" alt="" data-toggle="tooltip" data-placement="top" title="Anular Orden Compra" ><i class="fa fa-times"></i></a>';
                                            echo '</li>';
                                            #Unir con PE
                                            echo '<li>';
                                                echo '<a class="goPedido pull-left btn btn-primary btn-outline" href="'.$rs->int_IdOrdenCompra.'" alt="" data-toggle="tooltip" data-placement="top" title="Ingresar Orden Compra" ><i class="fa fa-tag"></i></a>';
                                            echo '</li>';
                                        break;
                                        default:
                                            #Copiar
                                            echo '<li>';
                                                echo '<a class="copiarPedido pull-left btn btn-primary btn-outline" href="'.$rs->int_IdOrdenCompra.'" alt="" data-toggle="tooltip" data-placement="top" title="Copiar Orden Compra" ><i class="fa fa-copy"></i></a>';
                                            echo '</li>';
                                        break;
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

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
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
        <h4 class="modal-title" id="myModalLabel">Copiar Orden Compra</h4>
      </div>
      <div class="modal-body">
        <p class="" ><img src="../images/loading.gif" />Copiando Orden Compra, por favor espere</p>
      </div>
    </div>
  </div>
</div>


<!-- Facturar -->
<div class="modal fade" id="facturarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Facturar Pedido</h4>
      </div>
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
        <a class="btn btn-link" data-dismiss="modal">Cancelar</a>
        <a id="btnGoFacturar" class="btn btn-link">Generar</a>
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

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/orden-compra.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

</body>

</html>
