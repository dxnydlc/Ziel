<?php
session_start();
if( $_SESSION["ziel_idu"] == '' ){
    header('location: login.php');
}
$idBenutzer = $_SESSION["ziel_idu"];
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$fecha_actual = date('d/m/Y');
$rand = '?v='.rand(0,9999999);
$idproducto = '';
#$chr_Estado = 'ACT';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';

$OBJ = new Usuario();
$tag = sha1($tag);
$rand = '';
$rand = '?v='.rand(0,9999999);
$idPromo = 0;

$data_clientes  = array();
$data_promo   = array();
$data_prods   = array();
$idCliente      = 0;
$chr_Estado     = '';
$arDias         = array();

if( $_GET["idpromo"] != '' ){
    $idPromo = $_GET["idpromo"];
}

$data_promo = $OBJ->get_data_promo(  $idPromo );

if( is_array( $data_promo["data"] ) ){

    foreach ( $data_promo["data"] as $key => $rsp ) {
        $Nombre     = $rsp->var_Nombre;
        $para       = $rsp->var_Para;
        $Objeto     = $rsp->int_Objeto;
        $Aplicar    = $rsp->var_Aplicar;
        $Valor      = $rsp->flt_ValorAplicar;
        $Tiempo     = $rsp->var_Tiempo;
        #
        $desde      = $rsp->desde;
        $hasta      = $rsp->hasta;
        #
        $dias       = $rsp->var_Dias;
        if( $dias != '' ){
            $arDias = explode(',', $dias );
        }
        $hInicio    = $rsp->var_HoraInicio;
        $hFin       = $rsp->var_HoraFin;

        $Estado     = $rsp->chr_Estado;
        $Restric    = $rsp->txt_Restric;
    }

$data_prods = $OBJ->get_productos_in_promo( $idPromo );

}

$json_clases = array();
$json_clases = $OBJ->get_all_clases( " WHERE chr_Estado = 'ACT' " );

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Nueva Promocion</title>

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
    
    <!-- Typeahead -->
    <link rel="stylesheet" type="text/css" href="../js/typeahead/typeaheadjs.css">

    <!-- Selectize -->
    <link href="../js/selectize/selectize.css" rel="stylesheet">

    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="../js/datepicker/bootstrap-datetimepicker.css">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<style type="text/css">
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*
        Label the data
        */
        #Tablita td:nth-of-type(1):before { content: "Producto:"; }
        #Tablita td:nth-of-type(2):before { content: "Precio:"; }
        #Tablita td:nth-of-type(3):before { content: "Promo:"; }
    }
</style>

<script type="text/javascript">
    _Estado = '<?php echo $Estado; ?>';
</script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('menu_nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >Agregar/Editar Promoción</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb" >
                        <li>
                            <a href="index.php">Inicio</a>
                        </li>
                        <li>
                            <a href="promociones.php">Promociones</a>
                        </li>
                        <li class="active" >Nueva promoción</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="panel panel-default">
                <div id="labelidPedido" class="panel-heading">Promoción #<span id="labelPromo"><?php echo $idPromo; ?></span></div>
                <div class="panel-body">
                    <form name="frmPromo" id="frmPromo" method="post" autocomplete="off" class="" >
                        <input type="hidden" id="idPromo" name="idPromo" value="<?php echo $idPromo; ?>" />
                        <input type="hidden" id="idObjeto" name="idObjeto" value="" />
                        <input type="hidden" id="f" name="f" value="" />
                        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $idBenutzer; ?>" />
                        <input type="hidden" id="Mascara" name="Mascara" value="" />
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="Nombre" >Nombre Promoción</label>
                                        <input type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre; ?>" class="form-control" >
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-xs-6">
                                    <div class="form-group">
                                        <label for="cboPara" >Para</label>
                                        <select id="cboPara" name="cboPara" class="form-control" >
                                            <option value="Producto" <?php if($para == 'Producto'){ echo 'selected="selected"'; } ?> >Producto fijo</option>
                                            <option value="Clase" <?php if($para == 'Clase'){ echo 'selected="selected"'; } ?> >Clases</option>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-4 col-md-4 col-xs-6" id="wrapperProd" >
                                    <div class="form-group" style="position:relative" >
                                        <label for="Objeto" >Producto</label>
                                        <input type="text" name="Objeto" id="Objeto" value="" class="form-control" >
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-4 col-md-4 col-xs-6" id="wrapperClase" style="display:none;" >
                                    <div class="form-group">
                                        <label for="cboClase" >Clases</label>
                                        <select name="cboClase" id="cboClase" class="form-control" >
                                        <?php
                                            if( is_array($json_clases['data']) ){
                                                $sel='';
                                                foreach ($json_clases['data'] as $key => $rc) {
                                                    if( $rc->int_IdAuto == $Objeto ){ $sel = 'selected="selected"'; }else{ $sel=''; }
                                                    echo '<option value="'.$rc->int_IdAuto.'" '.$sel.' >'.$rc->var_Nombre.'</option>';
                                                }
                                            }
                                        ?>
                                            <option value="" ></option>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-2 col-md-2 col-xs-6">
                                    <div class="form-group">
                                        <label for="cboAplicar" >Aplicar</label>
                                        <select id="cboAplicar" name="cboAplicar" class="form-control" >
                                            <option value="PrecioFijo" <?php if($Aplicar == 'PrecioFijo'){ echo 'selected="selected"'; } ?> >Precio Fijo</option>
                                            <option value="Porcentaje" <?php if($Aplicar == 'Porcentaje'){ echo 'selected="selected"'; } ?> >Porcentaje</option>
                                        </select>
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-4 col-md-4 col-xs-6">
                                    <div class="form-group">
                                        <label for="Valor" >Valor Aplicar</label>
                                        <div class="input-group">
                                            <input type="text" name="Valor" id="Valor" class="form-control" value="<?php echo $Valor; ?>" />
                                            <div class="input-group-addon" id="addON" >S/.</div>
                                        </div>
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                            </div><!-- row -->

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-xs-12">
                                    <h3>Tiempo a aplicar</h3>
                                    <select id="tiempo" name="tiempo" class="form-control" >
                                        <option value="RangoFechas" <?php if($Tiempo == 'RangoFechas'){ echo 'selected="selected"'; } ?> >Rango de Fechas</option>
                                        <option value="Permanente" <?php if($Tiempo == 'Permanente'){ echo 'selected="selected"'; } ?> >Permanente</option>
                                    </select>
                                </div>
                            </div>
                            <hr/>

                            <div class="row" id="wrapperRango" >
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="Desde" >Desde</label>
                                        <input type="text" name="Desde" id="Desde" value="<?php echo $desde; ?>" class="form-control" />
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="Hasta" >Hasta</label>
                                        <input type="text" name="Hasta" id="Hasta" value="<?php echo $hasta; ?>" class="form-control" />
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                            </div><!-- row -->
                            <div class="row" id="wrapperPermanente" style="display:none;" >
                                <div class="col-lg-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="1" <?php if(in_array("1", $arDias )){ echo 'checked'; } ?> rel="Lunes" > Lunes
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="2" <?php if(in_array("2", $arDias )){ echo 'checked'; } ?> rel="Martes" > Martes
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="3" <?php if(in_array("3", $arDias )){ echo 'checked'; } ?> rel="Miercoles" > Miercoles
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="4" <?php if(in_array("4", $arDias )){ echo 'checked'; } ?> rel="Jueves" > Jueves
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="5" <?php if(in_array("5", $arDias )){ echo 'checked'; } ?> rel="Viernes" > Viernes
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="6" <?php if(in_array("6", $arDias )){ echo 'checked'; } ?> rel="Sabado" > Sabado
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="Dias[]" value="7" <?php if(in_array("7", $arDias )){ echo 'checked'; } ?> rel="Domingo" > Domingo
                                        </label>
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-3 col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="HoraI" >Hora Inicio</label>
                                        <input type="text" name="HoraI" id="HoraI" value="<?php echo $hInicio ?>" class="form-control" onkeypress="return validar(event);" placeholder="09:00" />
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                                <div class="col-lg-3 col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="HoraF" >Hora Fin</label>
                                        <input type="text" name="HoraF" id="HoraF" value="<?php echo $hFin ?>" class="form-control" onkeypress="return validar(event);" placeholder="20:30" />
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                            </div><!-- row -->

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="Restric" >Restricciones</label>
                                        <input type="text" name="Restric" id="Restric" class="form-control" value="<?php echo $Restric; ?>" />
                                    </div><!-- form-group -->
                                </div><!-- /col -->
                            </div><!-- row -->
                            
                            <hr/>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Productos Afectados</h3>
                                </div>
                                <div class="panel-body">
                                    <!-- .table -->
                                    <table id="Tablita" class="table" >
                                        <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Promo</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if( is_array($data_prods["data"]) ){
                                            foreach ($data_prods['data'] as $key => $rs) {
                                                echo '<tr>';
                                                    echo '<td>'.$rs->prod." ".$rs->um."</td>";
                                                    echo '<td>'.$rs->prec."</td>";
                                                    echo '<td>'.$rs->prom."</td>";
                                                    echo "<td></td>";
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div><!-- /panel-body -->
                <div class="panel-footer">
                    <a class="btn btn-default" href="promociones.php">Regresar</a>
                    <button id="SavePromo" type="button" class="btn btn-success" data-loading-text="Guardando..." style="display:none;" >Guardar Promoción</button>
                    <button id="delPromo" rel="<?php echo $idPromo; ?>" type="button" class="btn btn-danger" data-loading-text="Anulando..." style="display:none;" >Anular Promoción</button>
                </div>
            </div>
            <!-- /panel -->

		</div>
    	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Popup -->
<?php include_once('popup1.php'); ?>

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

    <!-- type head -->
    <script type="text/javascript" src="../js/typeahead/bootstrap-typeahead.js" ></script>
    <script type="text/javascript" src="../js/typeahead/bloodhound.js" ></script>
    <script type="text/javascript" src="../js/typeahead/handlebars-v3.0.3.js" ></script>

    <!-- Selectize -->
    <script type="text/javascript" src="../js/selectize/selectize.js" ></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- Datetimepicker -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datetimepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/es.js" ></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/nueva-promocion.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

    <script type="text/javascript">
        cambioPara( '<?php echo $para; ?>' );
        cambioAplicar( '<?php echo $Aplicar; ?>' );
        cambioTiempo( '<?php echo $Tiempo; ?>' );
    </script>
</body>

</html>

<?php

?>