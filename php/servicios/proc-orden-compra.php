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
$idOC = 0;

$Cliente = '';
$fecha = '';
$Total = 0;

		

$tag = strip_tags($_POST["tag"]);

if( $_POST["idPedido"] == "0" ){
	$filtro = 'insertOC';
}

switch ($filtro){
	/* ------------------------------- */
	case 'goParteEntrada':
		$idp 		= $_POST["idp"];
		$response['idPE'] = $OBJ->oc_to_pe( $idp );
	break;
	/* ------------------------------- */
	case 'copy':
		$idp 	= $_POST["idp"];
		$response['id'] = $OBJ->copiar_orden_compra( $idp );
	break;
	/* ------------------------------- */
	case 'delPedido':
		$idp 	= $_POST["idp"];
		$OBJ->set_Union( $idp , 'int_IdPedido' );
		$OBJ->set_Dato( 'DEL' , 'chr_Estado' );
		$response['id'] = $OBJ->update_oc();
	break;
	/* ------------------------------- */
	case 'getItem':
		$idp 	= $_POST["idp"];
		$response = $OBJ->get_detalle_oc( " AND p.int_IdOrdenCompra = ".$idp );
	break;
	/* ------------------------------- */
	case 'delItem':
		$idItem	= $_POST["idItem"];
		$idp 	= $_POST["idp"];
		$OBJ->set_Dato( $idItem , 'int_IdDetalleOC' );
		$OBJ->delete_detalle_oc();
		$response = $OBJ->get_detalle_oc( " AND p.int_IdOrdenCompra = ".$idp );
	break;
	/* ------------------------------- */
	case 'addItem':
		#Insertar unidad de medida
		$idp 	= $_POST["idProd"];
		$idum 	= $_POST["idUM"];
		$cant 	= $_POST["txtCantidad"];
		$precio = $_POST["txtPrecio"];
		$tag 	= $_POST["tag"];
		$total  = $_POST["txtTotal"];
		$idItem	= $_POST["idItem"];
		$idOC 	= $_POST["idpedido"];
		$utilidad = $_POST["txtUtilidad"];
		$txtVenta = $_POST["txtVenta"];
		# ==============================
		if( $idOC > 0 ){
			$OBJ->set_Dato( $idOC , 'int_IdOrdenCompra' );
		}else{
			$OBJ->set_Dato( 0 , 'int_IdOrdenCompra' );
		}
		$OBJ->set_Dato( $idp , 'int_IdProducto' );
		$OBJ->set_Dato( $idum , 'int_IdUnidadMedida' );
		$OBJ->set_Dato( $cant , 'int_Cantidad' );
		$OBJ->set_Dato( $precio , 'flt_Precio' );
		$OBJ->set_Dato( $total , 'flt_Total' );
		$OBJ->set_Dato( $tag , 'txt_Tag' );
		$OBJ->set_Dato( $precio , 'flt_Precio_Compra' );
		$OBJ->set_Dato( $txtVenta , 'ftl_Precio_Venta' );
		$OBJ->set_Dato( $utilidad , 'flt_Utilidad' );
		/* Actualizar, Insertar*/
		if( $idItem > 0 ){
			$OBJ->set_UnionQ( $idItem , 'int_IdDetalleOC' );
			$response['id'] = $OBJ->update_detalle_oc();
		}else{
			$response['id'] = $OBJ->insert_detalle_oc();
		}
		/**/
		if( $idOC > 0 ){
			$response = $OBJ->get_detalle_oc( " AND p.int_IdOrdenCompra = '".$idOC."' " );
		}else{
			$response = $OBJ->get_detalle_oc( " AND p.txt_Tag = '".$tag."' " );
		}
		/**/
	break;
	/* ------------------------------- */
	default:
		
		#Cliente
		$Cliente = strip_tags($_POST["cboCliente"]);
		if( trim($Cliente) == '' ){
			$error['cliente'] = 'Seleccione Proveedor';
		}

		$ar_fecha = array();
		$Dia 	= "";
		$Mes 	= "";
		$Anio 	= "";

		#Fecha
		$fecha = strip_tags($_POST["txtFecha"]);
		$ar_fecha = split("/", $fecha);
		list( $Dia , $Mes , $Anio ) = $ar_fecha;
		$fecha 	= $Anio.'-'.$Mes.'-'.$Dia;

		if(! checkdate ( $Mes , $Dia , $Anio ) ){
			$error['Fecha'] = 'Fecha Incorrecta';
		}

		#Total
		$Total = strip_tags($_POST["TotalPedido"]);

		if( count($error) > 0 ){
			$errores = implode(', ', $error);
			$response['error'] = $errores;
			echo json_encode($response);
			die(0);
		}

		$response['error'] = '';

		$idOC = $_POST["idOC"];

		$OBJ->set_Valor( $Cliente , 'int_IdProveedor' );
		$OBJ->set_Valor( $fecha , 'dt_Fecha' );
		$OBJ->set_Valor( $Total , 'flt_Total' );

		if( $idOC == 0 ){
			$idOC = $OBJ->insert_oc();
		}else{
			$OBJ->set_Union( $idOC , 'int_IdOrdenCompra' );
			$OBJ->update_oc();
		}
		
		$response['idOC'] = $idOC;

		$OBJ1 = new Usuario();
		$OBJ1->set_Dato( $idOC , 'int_IdOrdenCompra' );
		$OBJ1->set_UnionT( $tag , 'txt_Tag' );
		$response['sql'] = $OBJ1->join_pedido_oc();
	break;
	/* ------------------------------- */
}

echo json_encode($response);

?>