<?php
include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();

$data_venta   = array();
$data_detalle   = array();


if( $_GET["id"] != '' ){
    $idVenta = $_GET["id"];
    $data_detalle = $OBJ->get_detalle_venta01( " AND v.`int_idVenta` = ".$idVenta );
}

$data_venta = $OBJ->get_data_venta( $idVenta );

if( is_array( $data_venta["data"] ) ){

    foreach ( $data_venta["data"] as $key => $rsp ) {
        #
        $idPedido       = $rsp->int_IdPedido;
        $idCliente      = $rsp->int_IdCliente;
        $nombreCliente  = $rsp->var_Nombre;
        $dir            = $rsp->dir;
        $fecha_actual   = $rsp->fecha;
        $tipoDoc        = $rsp->cht_TipoDoc;
        $Serie          = $rsp->int_Serie;
        $Corr           = $rsp->int_Correlativo;
        $totalVenta     = $rsp->flt_Total;
        $chr_Estado     = $rsp->estado;
        $Mascara        = $rsp->var_Mascara;
        #
        $FormaPago      = $rsp->var_FormaPago;
        $Pago           = $rsp->flt_Pago;
        $Vuelto         = $rsp->flt_Vuelto;
        $Nota           = $rsp->var_Nota;
        $Log            = 'Boleta creada por: '.$rsp->user.' a las '.$rsp->registro;
        #
    }
    switch ($tipoDoc) {
        case 'B':
            $NombreDoc = 'Boleta';
            break;
        case 'F':
            $NombreDoc = 'Factura';
            break;
        case 'R':
            $NombreDoc = 'Recibo';
            break;
    }
    switch ( $chr_Estado ) {
        case 'CER':
            $estado = 'Cerrado';
            break;
        case 'DEL':
            $estado = 'Anulado';
            break;
        default:
            $estado = 'Activo';
        break;
    }
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ziel - Venta</title>

    <!-- Bootstrap -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/css/estilos.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 ">
          <h1 class="text-center" >Boticas Angel</h1>
          <h4 class="text-center" >Ruc: 201102020202</h4>
          <h4 class="text-center" >Dirección: Pasaje el sol 331 - Los olivos</h4>
          <br/>
          <h4><?php echo $Mascara.' fecha: '.$fecha_actual; ?></h4>
        </div>
        <hr/>
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 ">
          <table class="table" >
            <thead>
              <tr>
                <th>Producto</th>
                <th>Lote</th>
                <th class="text-right" >Precio</th>
                <th class="text-right" >Cantidad</th>
                <th class="text-right" >Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              if( is_array($data_detalle["data"]) ){
                  foreach ($data_detalle["data"] as $key => $rsd ) {
                  ?>
                      <tr id="Fila_<?php echo $rsd["int_IdDetalleVenta"] ?>" >
                          <td>
                              <span class="fa fa-barcode" ></span> <?php echo $rsd["var_Nombre"] .' x '. $rsd["unidadMedida"]; ?>
                              <?php
                              if( $rsd["int_IdPromo"] != '' ){
                                  echo '<br/><small>'.$rsd["var_Promo"].' antes ('.$rsd["flt_Precio"].')</small>';
                              }
                              ?>
                          </td>
                          <td><?php echo $rsd["lote"] ?></td>
                          <?php
                          if( $rsd["int_IdPromo"] != '' ){
                              echo '<td class="text-right" >S/. '.$rsd["flt_Promo"].'</td>';
                          }else{
                              echo '<td class="text-right" >S/. '.$rsd["flt_Precio"].'</td>';
                          }
                          ?>
                          <td class="text-right" ><?php echo $rsd["int_Cantidad"] ?></td>
                          <td class="text-right" ><?php echo $rsd["flt_Total"]; $total = $total + $rsd["flt_Total"]; ?></td>
                      </tr>
                      <?php
                  }
              }
              ?>
            </tbody>
          </table>
          <div id="LabelTotal" class=" text-right ">
              Total de Venta: <?php echo $totalVenta ?>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  </body>
</html>