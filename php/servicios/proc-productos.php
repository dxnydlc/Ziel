<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';



$OBJ 		= new Usuario();
$response 	= array();
$filtro 	= '';
$query 		= '';

$filtro = $_POST["f"];
$existe = '';
$id 	= '';


switch ($filtro){
	// -------------------------------------------------
	case 'buscar':
		$query = " AND p.var_Nombre like  '%".$_POST["q"]."%'";
		$response = $OBJ->get_productos_lista( $query );
		break;
	// -------------------------------------------------
	case 'inserteq':
		//insertar equivalencia
		$um 		= $_POST["cboum"];
		$tag 		= $_POST["tag"];
		$cantNeg 	= $_POST["cantNeg"];
		$idp 		= $_POST["idp"];
		$precio 	= $_POST["precio"];
		#
		$OBJ->set_Dato( $tag , 'txt_Tag' );
		$OBJ->set_Dato( $um , 'int_IdUM' );
		$OBJ->set_Dato( $cantNeg , 'int_Cantidad' );
		$OBJ->set_Dato( $idp , 'int_IdProducto' );
		$OBJ->insert_equivalencia_Producto();
		$response = $OBJ->get_equivalencias_prod(" WHERE e.txt_Tag = '".$tag."' ");
	break;
	// -------------------------------------------------
	case 'deleq':
		#Anular equivalencia
		$id = $_POST["ideq"];
		$tag = $_POST["tag"];
		#
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdAuto' );
		$OBJ->update_equivalencia_producto();

		$response = $OBJ->get_equivalencias_prod(" WHERE e.txt_Tag = '".$tag."' ");
	break;
	// -------------------------------------------------
	case 'get':
		# Devuelve todos los productos para la lista
		$response = $OBJ->get_productos_lista('');
		break;
	// -------------------------------------------------
	case 'act':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'ACT' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdProducto' );
		$OBJ->update_Producto();
		$response = $OBJ->get_productos_lista('');
		break;
	// -------------------------------------------------
	case 'del':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdProducto' );
		$OBJ->update_Producto();
		$response = $OBJ->get_productos_lista('');
		break;
	// -------------------------------------------------
	case 'prodven':
		$response = $OBJ->get_productos_lista('');
	break;
	// -------------------------------------------------
	default:
		#Un nuevo producto
		$error = array();
		$response['error'] = 'si';
		$response['existe'] = 'si';
		#
		$id_producto 	= 0;
		$cantNeg 		= $_POST["cantNeg"];
		$cboClase 		= 0;#$_POST["deaClases"];
		$cboGenerico 	= $_POST["cboGenerico"];
		if( $cboGenerico == '' ){
			array_push($error, 'Selecciones Generico');
		}
		$cboum 			= $_POST["cboum"];
		
		$idProducto 	= $_POST["idProducto"];
		$deatag 		= $_POST["tag"];
		$txtDescri 		= $_POST["txtDescri"];
		$txtNombre 		= trim($_POST["txtNombre"]);
		if( $txtNombre == '' ){
			array_push($error, 'Ingrese un nombre');
		}
		$txtPreCompra1 	= $_POST["txtPreCompra1"];
		$txtPreCompra2 	= $_POST["txtPreCompra2"];
		$tabActive 		= $_POST["tabActive"];
		$txtPv1 		= $_POST["txtPv1"];
		$txtPv2 		= $_POST["txtPv2"];
		$txtUtilidad1 	= $_POST["txtUtilidad1"];
		$txtUtilidad2 	= $_POST["txtUtilidad2"];
		#
		$cboUMP 		= $_POST["cboUMP"];
		if( $cboUMP == '' ){
			array_push($error, 'Seleccione una Unidad de medida');
		}
		$txtCant 		= $_POST["txtCant"];
		if( $txtCant == '' ){
			array_push($error, 'Ingrese cantidad equivalente');
		}
		#
		$lote 			= $_POST["txtLote"];
		$vencimiento 	= '';
		$arr_fecha = array();
		if( $_POST["txtVence"] != '' ){
			$arr_fecha = split('/', $_POST["txtVence"] );
			$vencimiento 	= $arr_fecha[2].'-'.$arr_fecha[1].'-'.$arr_fecha[0];
		}
		#
		$lasClases 		= $_POST["lasClases"];
		if( $lasClases == '' ){
			array_push($error, 'Seleccione las clases del producto');
		}
		$losAlmacen		= $_POST["losAlmacen"];
		if( $losAlmacen == '' ){
			array_push($error, 'Seleccione almacenes de producto');
		}
		#
		$destacado 		= $_POST["cboDestacado"];
		$cboProveedor 	= $_POST["cboProveedor"];
		$txtLaboratorio = $_POST["txtLaboratorio"];
		$nombreProveedor = $_POST["nombreProveedor"];
		#
		if( count($error) > 0 ){
			//Hay errores
			$texto_error = '';
			$texto_error = implode( ' * ' , $error );
			$response['texto_error'] = $texto_error;
			echo json_encode( $response );
			die(0);
		}
		#
		$response['error'] = 'no';
		#
		if( isset($_POST["txtNombre"]) ){
			
			#
			if( $_POST["idProducto"] != '' ){
				/**/
				#Update
				$id_producto = $_POST["idProducto"];
				$OBJ->set_Valor( $cboClase , 'int_IdClase' );
				$OBJ->set_Valor( $cboGenerico , 'int_IdGenerico' );
				$OBJ->set_Valor( $txtNombre , 'var_Nombre' );
				$OBJ->set_Valor( $txtDescri , 'txt_Descri' );
				
				#$OBJ->set_Valor( $lote , 'var_Lote' );
				#$OBJ->set_Valor( $vencimiento , 'dt_Vencimiento' );

				$OBJ->set_Valor( $txtCant , 'int_Cantidad' );
				$OBJ->set_Valor( $cboUMP , 'int_IdUM' );
				
				$OBJ->set_Valor( $destacado , 'chr_Destacado' );
				$OBJ->set_Valor( $txtLaboratorio , 'var_Laboratorio' );
				$OBJ->set_Valor( $cboProveedor , 'int_IdProveedor' );
				$OBJ->set_Valor( $nombreProveedor , 'var_Proveedor' );
				#
				$OBJ->set_Union( $id_producto , 'int_IdProducto' );
				$OBJ->update_Producto();
				$response['idprod'] = $id_producto;
				$OBJ = array();

				$response['existe'] = 'no';

				/* Clases de Producto */
				$OBJc = array();
				$OBJc = new Usuario();
				if ( $lasClases != '') {
					
					$OBJc->set_UnionQ( $id_producto , "int_IdProducto" );
					$OBJc->delete_clases_in_producto();
					$arClases = array();
					$arClases = explode(",", $lasClases );

					for ( $i = 0 ; $i < count($arClases) ; $i++ ){ 
						$OBJc->set_Dato( $id_producto , 'int_IdProducto' );
						$OBJc->set_Dato( $arClases[$i] , 'int_IdClase' );
						$OBJc->insert_clases_in_producto();
					}
				}
				/* Producto en Almacenes */
				$OBJa = array();
				$OBJa = new Usuario();
				if ( $losAlmacen != '') {
					
					$OBJa->set_UnionQ( $id_producto , "int_IdProducto" );
					$OBJa->delete_almacenes_in_producto();
					$arAlmacen = array();
					$arAlmacen = explode(",", $losAlmacen );

					for ( $i = 0 ; $i < count($arAlmacen) ; $i++ ){ 
						$OBJa->set_Dato( $id_producto , 'int_IdProducto' );
						$OBJa->set_Dato( $arAlmacen[$i] , 'int_IdAlmacen' );
						$OBJa->insert_almacen_in_producto();
					}
				}
			}else{
				#Existe el producto?
				$id_producto = $OBJ->existe_producto( $txtNombre );
				if( $id_producto != 0 ){
					echo json_encode( $response );
					die(0);
				}
				$response['existe'] = 'no';
				#Insert
				/* ===================================================== */
				#Se guardan 3 enlaces.
				$OBJ->set_Valor( $cboClase , 'int_IdClase' );
				$OBJ->set_Valor( $cboGenerico , 'int_IdGenerico' );
				$OBJ->set_Valor( $txtNombre , 'var_Nombre' );
				$OBJ->set_Valor( $txtDescri , 'txt_Descri' );
				$OBJ->set_Valor( $deatag , 'txt_Tag' );
				#$OBJ->set_Valor( $lote , 'var_Lote' );
				#$OBJ->set_Valor( $vencimiento , 'dt_Vencimiento' );
				$OBJ->set_Valor( $txtCant , 'int_Cantidad' );
				$OBJ->set_Valor( $cboUMP , 'int_IdUM' );
				
				$OBJ->set_Valor( $destacado , 'chr_Destacado' );
				$OBJ->set_Valor( $txtLaboratorio , 'var_Laboratorio' );
				$OBJ->set_Valor( $cboProveedor , 'int_IdProveedor' );
				$OBJ->set_Valor( $nombreProveedor , 'var_Proveedor' );
				#Guardando Producto
				$id_producto = $OBJ->insert_Producto();
				$response['idprod'] = $id_producto;
				/* ===================================================== */
				$OBJ = array();
				$OBJ = new Usuario();
				
				/* ===================================================== */
				$deatag 		= $_POST["tag"];
				$OBJ1 = array();
				$OBJ1 = new Usuario();
				$OBJ1->set_Valor( $id_producto , 'int_IdProducto' );
				$OBJ1->set_Union_tag( $deatag , 'txt_Tag' );
				#Actualizando id producto en equivalencia
				$OBJ1->update_Equivalencia_Producto();

				$OBJ = array();
				$OBJ = new Usuario();

				#Equivalencia de Producto ++++++++++++++++++++++++++++
				$OBJ->set_Dato( 'PRI' , 'chr_Estado' );
				$OBJ->set_Dato( $cboUMP , 'int_IdUM' );
				$OBJ->set_Dato( $txtCant , 'int_Cantidad' );
				$OBJ->set_Dato( $id_producto , 'int_IdProducto' );
				$OBJ->insert_equivalencia_Producto();

				/* Clases de Producto */
				$OBJc = array();
				$OBJc = new Usuario();
				#
				if ( $lasClases != '') {
					$arClases = array();
					$arClases = explode(",", $lasClases );
					for ( $i = 0 ; $i < count($arClases) ; $i++ ){ 
						$OBJc->set_Dato( $id_producto , 'int_IdProducto' );
						$OBJc->set_Dato( $arClases[$i] , 'int_IdClase' );
						$OBJc->insert_clases_in_producto();
					}
				}
				/* Los almacenes */
				$OBJa = array();
				$OBJa = new Usuario();
				#
				if ( $losAlmacen != '') {
					$arAlmacen = array();
					$arAlmacen = explode(",", $losAlmacen );
					for ( $i = 0 ; $i < count($arAlmacen) ; $i++ ){ 
						$OBJa->set_Dato( $id_producto , 'int_IdProducto' );
						$OBJa->set_Dato( $arAlmacen[$i] , 'int_IdAlmacen' );
						$OBJa->insert_clases_in_producto();
					}
				}
				
			}
			
			

			/* Precio de producto y sus equivalencias */
			$OBJ = array();
			$OBJ = new Usuario();

			#Anulando productos anteriores.
			$OBJ->anular_precios_producto( $id_producto );

			$data_eqv = array();
			$um = '';
			$idp = '';
			$newprecio = 0;
			$newcompra = 0;
			$cant = 0;
			$data_eqv = $OBJ->get_equivalencias_producto_for_precio( $id_producto );

			/*if( is_array($data_eqv) ){
				foreach ($data_eqv as $key => $rse) {*/
					$um 	= 1;#$rse["um"];
					$idp 	= $id_producto;
					$cant 	= 1;#$rse["cant"];
					#-------------------------------------------
					$OBJ->set_Valor( $idp , 'int_IdProducto' );
					$OBJ->set_Valor( $um , 'int_IdUM' );
					$OBJ->set_Valor( $tabActive , 'int_TipoCalculo' );
					if( $tabActive == '1' ){

						$newcompra = ($txtPreCompra1 * $cant);
						$OBJ->set_Valor( $newcompra , 'flt_Precio_Compra' );
						
						$newprecio = ($txtPv1 * $cant);
						$OBJ->set_Valor( $newprecio , 'ftl_Precio_Venta' );

						$OBJ->set_Valor( $txtUtilidad1 , 'flt_Utilidad' );
					}else{
						#Calculo por precio de venta
						$newcompra = ($txtPreCompra2 * $cant);
						$OBJ->set_Valor( $newcompra , 'flt_Precio_Compra' );
						
						$newprecio = ($txtPv2 * $cant);
						$OBJ->set_Valor( $newprecio , 'ftl_Precio_Venta' );

						$OBJ->set_Valor( $txtUtilidad2 , 'flt_Utilidad' );
					}
					#Guardando Precio Producto
					$OBJ->insert_Precio_Producto();
					$response['cant'] = $cant;
				/*}
			}else{
				$response['equi'] ="no";
			}*/
			#Actualizo el precio del productos en las promocioes.
			#$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
			$response['promo'] = $OBJc->update_precio_promo_prod( $id_producto );
		}
		break;
	
}
		

echo json_encode($response);


?>