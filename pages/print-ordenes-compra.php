<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$fecha_actual = date('d/m/Y');
$rand = '?v='.rand(0,9999999);
$idproducto = '';
$chr_Estado = 'ACT';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);
$idOC = 0;


$data_clientes  = array();
$data_oc        = array();
$data_detalle   = array();



if( $_GET["id"] != '' ){
    $idOC = $_GET["id"];
}

$data_oc = $OBJ->get_data_oc( $idOC );

if( is_array( $data_oc["data"] ) ){

    foreach ( $data_oc["data"] as $key => $rsp ) {
        
        $idCliente      = $rsp->int_IdCliente;
        $nombreCliente  = $rsp->var_Nombre;
        $fecha_actual   = $rsp->fecha;
        $chr_Estado     = $rsp->estado;
        $chr_TipoDoc    = $rsp->chr_TipoDoc;
        $var_NumDoc     = $rsp->var_NumDoc;
        $ts_FechaDoc    = $rsp->ts_FechaDoc;
        $total          = number_format($rs->flt_Total,2);

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

$data_detalle = $OBJ->get_detalle_oc( " AND p.int_IdOrdenCompra = ".$idOC );

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

    <title>Ziel - Nuevo Orden Compra</title>

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

    <script type="text/javascript">
        var _idPedido = '<?php echo $idOC ?>';
    </script>

<style type="text/css">
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*
        Label the data
        */
        td:nth-of-type(1):before { content: "Producto:"; }
        td:nth-of-type(2):before { content: "Cantidad:"; }
        td:nth-of-type(3):before { content: "P. compra:"; }
        td:nth-of-type(4):before { content: "P. venta:"; }
        td:nth-of-type(5):before { content: "Utilidad:"; }
        td:nth-of-type(6):before { content: "Total:"; }
        td:nth-of-type(7):before { content: "Opciones:"; }
    }
</style>

</head>

<body>

    <div class="container" >
        
        <div class="row">
            <div class="col-lg-12">
                <table class="table" >
                    <tr>
                        <td colspan="2" >
                            <h2>ORDEN DE COMPRA #<?php echo $idOC; ?></h2>
                        </td>
                    </tr>
                    <tr>
                        <td>Proveedor: </td>
                        <td><?php echo$nombreCliente;  ?></td>
                    </tr>
                    <tr>
                        <td>Fecha: </td>
                        <td><?php echo$fecha_actual;  ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-12">
                <table class="table" >
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <!--<th>Prec. compra</th>
                            <th>Prec. venta</th>
                            <th>Utilidad</th>
                            <th>Total</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        if( is_array($data_detalle["data"]) ){
                            foreach ($data_detalle["data"] as $key => $rsd ) {
                            ?>
                                <tr id="Fila_<?php echo $rsd["int_IdDetalleOC"] ?>" >
                                    <td>
                                        <span class="fa fa-barcode" ></span> <?php echo $rsd["var_Nombre"] .' x '. $rsd["unidadMedida"]; ?>
                                    </td>
                                    <td class="text-right" ><?php echo $rsd["int_Cantidad"] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

		</div>
    	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->




    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>
