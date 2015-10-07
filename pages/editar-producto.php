<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$rand = '';
$tag = date('d-m-y H-i-s');
$rand = '?v='.rand(0,9999999);
$idproducto = '';

include_once '../php/mysql.class/mysql.class.php';
include_once '../php/clases/clsUsuario.php';


$OBJ = new Usuario();

$tag = sha1($tag);
$data_clases 		= array();
$data_generico 		= array();
$data_um 			= array();
$data_producto 		= array();
$data_clases2 		= array();

$data_almacenes1	= array();
$data_almacenes2	= array();

$json_data_clases 	= '0';
$id_clases_prod 	= '';
$id_almacen_prod 	= '';
$idProveedor 		= 0;

$cantidad = 1;
$unidad_medida = 1;
$tab_activo = 2;
$idproducto = $_GET["idp"];
if( $idproducto != '' ){

	$idclase = '';
	$idgenerico = '';

	$data_producto = $OBJ->get_productos_lista( " and p.int_IdProducto = ".$idproducto );

	if( is_array($data_producto['data']) ){
		foreach ($data_producto['data'] as $key => $rsp ) {
			$idclase 	= $rsp["int_IdClase"];
			$idgenerico = $rsp["int_IdGenerico"];
			$producto 	= $rsp["producto"];
			$descri 	= $rsp["txt_Descri"];
			$tag 		= $rsp["txt_Tag"];
			$lote 		= $rsp["var_Lote"];
			$vence 		= $rsp["vencimiento"];
			$cantidad 	= $rsp["int_Cantidad"];
			$unidad_medida = $rsp["int_IdUM"];
			$destacado 	 = $rsp["chr_Destacado"];
			if( $rsp["int_IdProveedor"] != '' ){
				$idProveedor = $rsp["int_IdProveedor"];
			}
			$laboratorio = $rsp["var_Laboratorio"];
		}
	}

#Arreglo de clases de producto.
	$data_clases2 = $OBJ->get_clases_in_producto( $idproducto );
	if( is_array( $data_clases2["data"] ) ){
		$k = array();
		foreach ($data_clases2['data'] as $key => $rsp) {
			array_push($k, $rsp->id );
		}
		$id_clases_prod = '['.implode(',',$k).']';
		$json_data_clases = $data_clases2["json"];
	}
}

$json_clases = array();
$json_clases = $OBJ->get_all_clases( " WHERE chr_Estado = 'ACT' " );


#Arreglo de alacenes seleccionados
	$data_almacenes2 = $OBJ->get_producto_almacenes( $idproducto );
	if( is_array( $data_almacenes2["data"] ) ){
		$k = array();
		foreach ($data_almacenes2['data'] as $key => $rsa) {
			array_push( $k , $rsa->id );
		}
		$id_almacen_prod = '['.implode(',',$k).']';
		$json_data_clases = $data_almacenes2["json"];
	}
	unset($rsa);


$json_almacenes = array();
$json_almacenes = $OBJ->get_all_almacenes( " WHERE chr_Estado = 'ACT' " );


/**/
$data_generico = $OBJ->get_all_genericos( " WHERE chr_Estado = 'ACT' " );
$data_um = $OBJ->get_unidades_medida();

$data_clientes = $OBJ->get_all_clientes('');

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

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Alertify -->
    <link rel="stylesheet" href="../js/alertify/alertify.core.css" />
    <link rel="stylesheet" href="../js/alertify/alertify.default.css" id="toggleCSS" />

    <!-- Datepicker -->
    <link href="../js/datepicker/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- Selectize -->
    <link href="../js/selectize/selectize.default.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
	.deaTabs{
		display: none;
	}
</style>
<script type="text/javascript">
	
	var _lasClases 			= <?php echo $json_data_clases; ?>;
	var _clases_producto 	= [];
	var _almacen_producto 	= [];

	<?php
	#Clases de producto.
	if( $id_clases_prod != '' ){
		echo '_clases_producto 	= '.$id_clases_prod.';'."\n";
	}
	echo 'var _json_all_clases = [';
	if( is_array($json_clases) ){
		$t = array();
		foreach ($json_clases['data'] as $key => $rsc) {
			$linea = "{id:".$rsc->int_IdAuto.",title:'".$rsc->var_Nombre."'}";
			array_push($t, $linea );
		}
		echo implode(',', $t);
	}
	echo ']'."\n";

	#Almacenes
	if( $id_almacen_prod != '' ){
		echo '_almacen_producto 	= '.$id_almacen_prod.';'."\n";
	}
	echo 'var _json_all_almacenes = [';
	if( is_array($json_almacenes) ){
		$t = array();
		foreach ($json_almacenes['data'] as $key => $rsa) {
			$linea = "{id:".$rsa->int_IdAlmacen.",title:'".$rsa->var_Nombre."'}";
			array_push($t, $linea );
		}
		echo implode(',', $t);
	}
	echo ']'."\n";

	?>
	var _json_clientes  = [];
    <?php
    if( is_array($data_clientes['data']) ){
        $r = array();
        echo '_json_clientes = [';
        foreach ($data_clientes['data'] as $key => $rsc ) {
            array_push($r, " {id: ".$rsc->int_IdCliente.", texto: '".$rsc->var_Nombre."'}") ;
        }
        echo implode(',', $r);
        echo '];'."\n";
    }
    ?>
	var _Proveedor 		= [];
	var _idProveedor 	= <?php echo $idProveedor ?>;
</script>
</head>

<body>

<div id="wrapper">

        <!-- Navigation -->
        <?php include_once('menu_nav.php'); ?>

        <div id="page-wrapper">
            
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Editar un producto</h1>
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
                            <a href="mant-producto.php">Productos</a>
                        </li>
                        <li class="active" >Editar Producto</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <form name="frmData" id="frmData" method="post" autocomplete="off" class=" " >
		        <input type="hidden" name="idProducto" id="idProducto" value="<?php echo $idproducto; ?>" />
		        <input type="hidden" name="f" id="f" value="" />
		        <input type="hidden" name="tag" id="tag" value="<?php echo $tag; ?>" />
		        <input type="hidden" name="tabActive" id="tabActive" value="2" />

		      <div class="modal-body">
				<div id="theClases" ></div>
		      	<div class="panel panel-primary">
		      		<div class="panel-heading">Clases</div>
					<div class="panel-body">
					
						<div class="form-group hidden"><!-- Descontinuado -->
			            	<label for="cboClase" >kkkkkkkkkkkkkkk</label>
			            	<select name="cboClase" id="cboClase" class="jChosen form-control" >
			                <option value="" >Seleccione clase</option>
			            	</select>
			          	</div><!-- Descontinuado -->
			          <!-- /.form-group -->

			          <div class="row">
			          	<div class="col-lg-6">
			          		<div class="form-group">
					          	<label for="deaClases" >Clases</label>
					          	<div name="deaClases" id="deaClases" placeholder="Buscar clases..." ></div>
					          </div>
					          <!-- /.form-group -->
			          	</div>
			          	<!-- /.col-lg-6 -->
			          	<div class="col-lg-6">
			          		<div class="form-group">
					          	<label for="deaAlamcen" >Almacen</label>
					          	<div name="deaAlamcen" id="deaAlamcen" placeholder="Buscar Almacen..." ></div>
					          </div>
					          <!-- /.form-group -->
			          	</div>
			          	<!-- /.col-lg-6 -->
			          </div>
			          <!-- /.row -->

					          
						<div class="row">
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label for="cboGenerico" >Generico</label>
									<select name="cboGenerico" id="cboGenerico" class="cboSelectize" >
										<option value="" >Seleccione Generico</option>
										<?php
										/**/
										if( is_array($data_generico['data']) ){
											foreach ( $data_generico['data'] as $key => $c ) {
												$cls = '';
												if( $idgenerico == $c->int_IdGenerico ){ $cls = 'selected="selected"'; }else{ $cls = ''; }
												echo '<option value="'.$c->int_IdGenerico.'" '.$cls.' >'.$c->var_Nombre.'</option>';
											}
										}
										/**/
										?>
									</select>
								</div>
						  		<!-- /.form-group -->
							</div><!-- /.col -->
							<div class="col-lg-6 col-md-6">
								<div class="form-group">
									<label for="cboDestacado" >Producto destacado</label>
									<select name="cboDestacado" id="cboDestacado" class="cboSelectize" >
										<option value="0" <?php if($destacado=='0'){echo 'selected="selected"';} ?> >No</option>
										<option value="1" <?php if($destacado=='1'){echo 'selected="selected"';} ?> >Si</option>
									</select>
								</div>
								<!-- /.form-group -->
							</div><!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
		      	</div>

				<div class="panel panel-primary">
		         	<div class="panel-heading">Datos del producto</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="cboUMP">Unidad de medida principal</label>
									<select id="cboUMP" name="cboUMP" class="cboSelectize" >
					            		<option value="" >Seleccione Unidad Medida Principal</option>
						                <?php
						                /**/
						                if( is_array($data_um['data']) ){
						                	$clase = '';
						                    foreach ( $data_um['data'] as $key => $c ) {
						                    	if( $unidad_medida == $c->int_IdUM ){ $clase = 'selected="selected"'; }else{ $clase = ''; }
						                        echo '<option value="'.$c->int_IdUM.'" '.$clase.' >'.$c->var_Nombre.'</option>';
						                    }
						                }
						                /**/
						                ?>
					            	</select>
					            	<small>Unidad de medida con la que se vende por lo general.</small>
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col -->
							<div class="col-lg-6">
								<div class="form-group">
									<label for="txtCant">Equivalencia</label>
									<input type="number" id="txtCant" name="txtCant" value="1" class="form-control" >
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
						            <label for="txtNombre" >Nombre Producto</label>
						            <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $producto; ?>" />
								</div>
						        <!-- /.form-group -->
							</div>
							<!-- /.col-lg-6 -->
							<div class="col-lg-6">
								<div class="form-group">
									<label for="txtLote" >Laboratorio</label>
									<input type="text" class="form-control" id="txtLaboratorio" name="txtLaboratorio" value="<?php echo $laboratorio; ?>" />
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col-lg-6 -->
						</div>
						<!-- /.row -->

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="txtNombre" >Proveedor</label>
									<select name="cboProveedor" id="cboProveedor" placeholder="Buscar Proveedor..." ></select>
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col-lg-6 -->
							<div class="col-lg-6">
								<div class="form-group">
						            <label for="txtDescri" >Descripción del Producto</label>
						            <textarea class="form-control" name="txtDescri" id="txtDescri" ><?php echo $descri; ?></textarea>
						        </div>
						        <!-- /.form-group -->
							</div>
							<!-- /.col-lg-6 -->
						</div>
						<!-- /.row -->

					</div>
		        </div>

<?php
	
	$data_precio = array();
	$data_precio = $OBJ->get_precios_producto( $idproducto );
	if( is_array( $data_precio['data'] ) ){
		foreach ($data_precio['data'] as $key => $rsp ) {
			$tab_activo = $rsp->int_TipoCalculo;
			if( $tab_activo == 1 ){
				$pv1 = $rsp->ftl_Precio_Venta;
				$pc1 = $rsp->flt_Precio_Compra;
				$uti1 =$rsp->flt_Utilidad;
			}else{
				$pv2 = $rsp->ftl_Precio_Venta;
				$pc2 = $rsp->flt_Precio_Compra;
				$uti2 =$rsp->flt_Utilidad;
			}
		}
	}
?>
		        <div class="panel panel-primary">
		        	<div class="panel-heading">Precio de Producto</div>
		        	<div class="panel-body">

		        		<div class="form-group" >
		                    <ul class="nav nav-tabs">
		                        <li id="tab2" role="presentation" class="deaTabs" >
		                            <a href="#" class="losTabs" rel="2" >por Precio Venta</a>
		                        </li>
		                        <li id="tab1" role="presentation" class="deaTabs ">
		                            <a href="#" class="losTabs" rel="1" >por Utilidad</a>
		                        </li>
		                    </ul>
			            </div>
					            
			            <!-- Precio 1 -->
			            <div id="Pre1" class=" tabPre " style="<?php if( $tab_activo == 2 ){ echo 'display: none'; } ?>" >
			            	<div class="row">
								<div class="col-lg-4">
									<div class="form-group" >
					                    <label for="txtPreCompra1" >Precio Compra</label>
					                    <input value="<?php echo $pc1; ?>" type="text" class="form-control" id="txtPreCompra1" name="txtPreCompra1" placeholder="00.00" onkeypress="return validar(event);" />
					                </div>
								</div>
								<!-- /.col-lg-4 -->
								<div class="col-lg-4">
									<div class="form-group" >
					                    <label for="txtUtilidad1" >% Utilidad</label>
					                    <input value="<?php echo $uti1; ?>" type="text" class="form-control" id="txtUtilidad1" name="txtUtilidad1" placeholder="00" onkeypress="return validar(event);" />
					                </div>
								</div>
								<!-- /.col-lg-4 -->
								<div class="col-lg-4">
									<div class="form-group" >
					                    <label for="txtPv1" >Precio Venta</label>
					                    <input value="<?php echo $pv1; ?>" type="text" class="form-control" id="txtPv1" name="txtPv1" readonly />
					                </div>
								</div>
								<!-- /.col-lg-4 -->
							</div>
							<!-- /.row -->
			            </div>
			            <!-- /Precio 1 -->

			            <!-- Precio 2 -->
			            <div id="Pre2" class=" tabPre " style="<?php if( $tab_activo == 1 ){ echo 'display: none'; } ?>" >
			            	<div class="row">
								<div class="col-lg-4">
									<div class="form-group" >
					                    <label for="txtPreCompra2" >Precio Compra</label>
					                    <input value="<?php echo $pc2; ?>" type="text" class="form-control" id="txtPreCompra2" name="txtPreCompra2" placeholder="00.00" onkeypress="return validar(event);" />
					                </div>
								</div>
								<!-- /.col-lg-4 -->
								<div class="col-lg-4">
									<div class="form-group" >
					                    <label for="txtPv2" >Precio Venta</label>
					                    <input value="<?php echo $pv2; ?>"type="text" class="form-control" id="txtPv2" name="txtPv2" onkeypress="return validar(event);" />
					                </div>
								</div>
								<!-- /.col-lg-4 -->
								<div class="col-lg-4">
									<div class="form-group" >
					                    <label for="txtUtilidad2" >Utilidad %</label>
					                    <input value="<?php echo $uti2; ?>" type="text" class="form-control" id="txtUtilidad2" name="txtUtilidad2" readonly  />
					                </div>
								</div>
								<!-- /.col-lg-4 -->
							</div>
							<!-- /.row -->  
			            </div>
			            <!-- Precio 2 -->
		          </div>
		        </div>
		        <!-- /precio -->

		        <div class="panel panel-primary">
		        	<div class="panel-heading">Lotes Producto</div>
		        	<div class="panel-body">
		        		<div class="row" style="display:none;" ><!-- OCULTO -->
							<div class="col-lg-6">
								<div class="form-group">
						            <label for="txtLote" >Lote</label>
						            <input type="text" class="form-control" id="txtLote" name="txtLote" value="<?php echo $lote; ?>" />
						        </div>
						        <!-- /.form-group -->
							</div>
							<!-- /.col-lg-6 -->
							<div class="col-lg-6">
								<div class="form-group">
						            <label for="txtVence" >Vencimiento</label>
						            <input type="text" class="form-control" id="txtVence" name="txtVence" value="<?php echo $vence; ?>" placeholder="05/03/2015" data-provide="datepicker" />
						        </div>
						        <!-- /.form-group -->
							</div>
							<!-- /.col-lg-6 -->
						</div>
						<!-- /.row -->
						<div class="row">
							<div class="col-lg-12">
								<table class="table" >
									<thead>
										<tr>
											<th>Lote</th>
											<th>Vencimiento</th>
											<th>Stock</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$arr_lotes = array();
										$arr_lotes = $OBJ->get_lotes_producto( $idproducto );
										if( is_array($arr_lotes['data']) ){
											foreach ($arr_lotes['data'] as $key => $rsl) {
										?>
										<tr>
											<td><?php echo $rsl->lote; ?></td>
											<td><?php echo $rsl->vence; ?></td>
											<td><?php echo $rsl->stock; ?></td>
										</tr>
										<?php
											}
											unset($rsl);
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
		        	</div>
		        </div>
		        <!-- /.Lotes Producto -->
				

				<div class="panel panel-primary" style="display: none" >
					<div class="panel-heading">Unidades de Medida</div>
					<div class="panel-body">
			            <div class="form-group" >
			            	<label>Unidad de Medida</label>
			            	<select class="cboSelectize" id="cboum" name="cboum" >
			            		<option value="" >Seleccione Unidad Medida</option>
				                <?php
				                /**/
				                if( is_array($data_um['data']) ){
				                    foreach ( $data_um['data'] as $key => $c ) {
				                        echo '<option value="'.$c->int_IdUM.'" >'.$c->var_Nombre.'</option>';
				                    }
				                }
				                /**/
				                ?>
			            	</select>
			            </div>
		            	<!-- /.form-group -->
			            <div class="form-group">
			            	<label>Unidades de equivalencia</label>
			            	<input type="number" name="cantNeg" id="cantNeg" class="form-control" placeholder="Ejemplo 10" onkeypress="return validar(event);" />
			            </div>
			            <!-- /.form-group -->
			            <div class="form-group">
			            	<a id="btnSetEquiv" href="#" class="btn btn-default" data-loading-text="Guardando..." >Agregar</a>
			            </div>
			            <!-- /.form-group -->
						<?php
							$data_equiv = array();
							$data_equiv = $OBJ->get_equivalencias_prod(" AND e.int_IdProducto = ".$idproducto );
						?>
			            <div class="form-group">
			            	<table id="tablita" class="table table-striped" >
			            		<thead>
			            			<tr>
			            				<th>Unidad Medida</th>
			            				<th>Equivalencia</th>
			            				<th></th>
			            			</tr>
			            		</thead>
			            		<tbody>
		            			<?php
		            			if( is_array($data_equiv['data']) ){
		            				foreach ($data_equiv['data'] as $key => $rse ) {
		            					echo '<tr>';
		            						echo '<td>'.$rse->var_Nombre.'</td>';
		            						echo '<td>'.$rse->int_Cantidad.'</td>';
		            						echo '<td><a href="#" title="Quitar Item" class="quitarEqui" rel="'.$rse->int_IdAuto.'" >';
												echo '<span class="glyphicon glyphicon-remove" ></span>';
											echo '</a></td>';
		            					echo '</tr>';
		            				}
		            			}
		            			?>
			            		</tbody>
			            	</table>
			            </div>
			            <!-- /.form-group -->
		          	</div>
				</div>
		          
				<div class="modal-footer">
					<div class="row">
						<div id="msgBox" class="col-lg-12"></div>
					</div>
			        <a href="mant-producto.php" class="btn btn-default" >Cerrar</a>
			        <button id="myButton" type="button" class="btn btn-success" data-loading-text="Guardando..." >Guardar Cambios</button>
			    </div>

		            
		<!-- ******************************************************* -->
		      
		    </form>
            
        </div>
        <!-- /#page-wrapper -->

    </div>


    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
    <!-- Alertify -->
    <script type="text/javascript" src="../js/alertify/alertify.min.js" ></script>

    <!-- DatePicker -->
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.min.js" ></script>
    <script type="text/javascript" src="../js/datepicker/bootstrap-datepicker.es.min.js" ></script>

    <!-- Selectize -->
    <script type="text/javascript" src="../js/selectize/selectize.js" ></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Funciones de la pagina -->
    <script src="../dist/js/editar_producto.js<?php echo $rand; ?>"></script>

    <!-- Funciones de mensajes -->
    <script src="../dist/js/mensajes.js<?php echo $rand; ?>"></script>

    <script type="text/javascript">
    	$('#tab<?php echo $tab_activo ?>').addClass('active');
    </script>

</body>

</html>
