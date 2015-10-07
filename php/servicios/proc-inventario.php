<?php
include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ = new Usuario();
$response = array();
$error = array();
$filtro = '';

$filtro = $_POST["f"];
$existe = '';
$id 	= '';
$idPedido = 0;

$Cliente = '';
$fecha = '';
$Total = 0;

		

$tag = strip_tags($_POST["tag"]);

if( $_POST["idPedido"] == "0" ){
	$filtro = 'insertPedido';
}

switch ($filtro){
	/* ------------------------------- */
	case 'update_cant':
		$id 	= $_POST["id"];
		$cant 	= $_POST["cant"];
		$OBJ->set_Valor( $cant , 'int_Cant' );
		$OBJ->set_Union( $id , 'int_IdDetalleInv' );
		$OBJ->update_cant_detinv();
		#
	break;
	/* ------------------------------- */
	case 'get_clases':
		$response = $OBJ->get_all_clases('');
	break;
	/* ------------------------------- */
	case 'get_almacenes':
		$response = $OBJ->get_all_almacenes('');
	break;
	/* ------------------------------- */
	case 'buscar':
		//vamos a buscar un producto dentro de los ingresados.
		$query = $_POST["q"];
		$idInv = $_POST["id"];
		$response = $OBJ->buscar_in_detalle_inventario( $query , $idInv );
	break;
	/* ------------------------------- */
	case 'delItem':
		$item 	= $_POST["item"];
		$idInv  = $_POST["idInv"];
		$sql = " AND i.int_IdInventario = ".$idInv;
		$OBJ->set_Dato( $item , 'int_IdDetalleInv' );
		$OBJ->delete_detalle_inventario();
		$response = $OBJ->get_detalle_inventario( $sql );
	break;
	/* ------------------------------- */
	case 'item':
		#Add Item
		$idItem 		= $_POST["idItem"];
		$UnidadMedida 	= $_POST["UnidadMedida"];
		$idProd 		= $_POST["idProd"];
		$tagItem 		= $_POST["tagItem"];
		$txtCantidad 	= $_POST["txtCantidad"];
		$idInv 			= $_POST["idInv"];
		#
		$sql = " AND i.int_IdInventario = ".$idInv;
		if( $idInv == 0 ){
			$OBJ->set_Dato( $tagItem , 'txt_Tag' );
			$sql = " AND i.txt_Tag = '".$tagItem."' ";
		}
		$OBJ->set_Dato( $idInv , 'int_IdInventario' );
		$OBJ->set_Dato( $idProd , 'int_IdProducto' );
		$OBJ->set_Dato( $UnidadMedida , 'int_IdUm' );
		$OBJ->set_Dato( $txtCantidad , 'int_Cant' );
		if( $idItem > 0 ){
			#$OBJ->set_Dato( $txtNombre , 'var_Nombre' );
		}else{
			$response['idi'] = $OBJ->add_item_inventario();
			$response = $OBJ->get_detalle_inventario( $sql );
		}


		
	break;
	/* ------------------------------- */
	case 'goInventario':
		$idInv = $_POST["idInv"];
		$response['idk'] = $OBJ->inventario_kardex( $idInv );
		$OBJ->set_Dato( 'CER' , 'chr_Estado' );
		$OBJ->set_UnionQ( $idInv , 'int_IdAuto' );
		$OBJ->update_new_inventario();
	break;
	/* ------------------------------- */
	default:
		$idInventario 	= $_POST["idInventario"];
		$txtNombre 		= strip_tags( $_POST["txtNombre"] );
		$txtFecha 		= $_POST["txtFecha"];
		$tag 			= $_POST["tag"];
		$idUsuario 		= $_POST["idBenutzer"];
		$TipoInv 		= $_POST["tipoInv"];
		$ValorInv 		= '';
		switch ($TipoInv) {
			case 'Almacen':
				$ValorInv 		= $_POST["valorAlmacen"];
				#Llenamos el detalle con todos los productos en ese almacen.
				break;
			case 'Clases':
				$ValorInv 		= $_POST["valorClases"];
				#Llenamos el detalle con todos los productos con esa clase.
				break;
		}
		#
		$fecha 		= '';
		$dia 		= '';
		$mes 		= '';
		$anio 		= '';
		$arr_fecha = array();
		list($dia,$mes,$anio) = split("/", $txtFecha);
		$fecha = $anio.'-'.$mes.'-'.$dia;
		#
		$OBJ->set_Dato( $txtNombre , 'var_Nombre' );
		$OBJ->set_Dato( $fecha , 'dt_Fecha' );
		$OBJ->set_Dato( $idUsuario , 'int_IdUsuario' );
		$OBJ->set_Dato( $TipoInv , 'var_Tipo' );
		$OBJ->set_Dato( $ValorInv , 'int_ValorTipo' );
		
		if( $idInventario > 0 ){

			$OBJ->set_UnionQ( $idInventario , 'int_IdAuto' );
			$OBJ->update_new_inventario();

		}else{

			$idInventario = $OBJ->create_new_inventario();
			$sql = " AND i.int_IdInventario = ".$idInventario;
			switch ($TipoInv) {
				case 'Almacen':
					#Llenamos el detalle con todos los productos en ese almacen.
					$data_almacen = array();
					$data_almacen = $OBJ->get_productos_almacen( $ValorInv );
					if( is_array($data_almacen) ){
						$OBJ0 = new Usuario();
						foreach ( $data_almacen as $key => $rs) {
							$OBJ0->set_Dato( $idInventario , 'int_IdInventario' );
							$OBJ0->set_Dato( $rs->int_IdProducto , 'int_IdProducto' );
							$OBJ0->set_Dato( $rs->int_IdUM , 'int_IdUm' );
							$OBJ0->set_Dato( 0 , 'int_Cant' );
							$response['querys'] = $OBJ0->add_item_inventario();
						}
						unset($rs);
					}
				break;
				case 'Clases':
					#Llenamos el detalle con todos los productos con esa clase.
					$data_clases = array();
					$data_clases = $OBJ->get_productos_clase( $ValorInv );
					if( is_array($data_clases) ){
						$OBJ0 = new Usuario();
						foreach ( $data_clases as $key => $rs) {
							$OBJ0->set_Dato( $idInventario , 'int_IdInventario' );
							$OBJ0->set_Dato( $rs->int_IdProducto , 'int_IdProducto' );
							$OBJ0->set_Dato( $rs->int_IdUM , 'int_IdUm' );
							$OBJ0->set_Dato( 0 , 'int_Cant' );
							$response['querys'] = $OBJ0->add_item_inventario();
						}
						unset($rs);
					}
				break;
				case 'Todos':
					#Llenamos el detalle con todos los productos.
					$data_prods = array();
					$data_prods = $OBJ->get_productos_01();
					if( is_array($data_prods) ){
						$OBJ0 = new Usuario();
						foreach ( $data_prods as $key => $rs) {
							$OBJ0->set_Dato( $idInventario , 'int_IdInventario' );
							$OBJ0->set_Dato( $rs->int_IdProducto , 'int_IdProducto' );
							$OBJ0->set_Dato( $rs->int_IdUM , 'int_IdUm' );
							$OBJ0->set_Dato( 0 , 'int_Cant' );
							$response['querys'] = $OBJ0->add_item_inventario();
						}
						unset($rs);
					}
				break;
			}

			$response = $OBJ->get_detalle_inventario( $sql );

		}

		$response['idi'] = $idInventario;
		
		$OBJ1 = array();
		$OBJ1 = new Usuario();
		#Unir detalle con Encabezado de Inventario
		$OBJ1->set_UnionT( $tag , 'txt_Tag' );
		$OBJ1->set_Dato( $idInventario , 'int_IdInventario' );
		$OBJ1->join_inventario_detalle();

	break;
}

echo json_encode($response);

?>
