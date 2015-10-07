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
	case 'goBoleta':
		$idp 	= $_POST["idp"];
		$TipoDoc = $_POST["TipoDoc"];
		$response['idVenta'] = $OBJ->facturar_pedido( $TipoDoc , $idp );
	break;
	/* ------------------------------- */
	case 'copy':
		$idp 	= $_POST["idp"];
		$response['id'] = $OBJ->copiar_pedido( $idp );
	break;
	/* ------------------------------- */
	case 'getItem':
		$idp 	= $_POST["idp"];
		$response = $OBJ->get_detalle_venta( " AND p.int_IdDetalleVenta = ".$idp );
	break;
	/* ------------------------------- */
	case 'delItem':
		$idItem	= $_POST["idItem"];
		$OBJ->set_Dato( $idItem , 'int_IdDetalleVenta' );
	break;
	/* ------------------------------- */
	case 'addItem':
		#Insertar unidad de medida
		$idp 	= $_POST["idp"];
		$idum 	= $_POST["idum"];
		$cant 	= $_POST["cant"];
		$precio = $_POST["precio"];
		$tag 	= $_POST["tag"];
		$total  = $_POST["total"];
		$idItem	= $_POST["idItem"];
		$idpedido = $_POST["idpedido"];
		# ==============================
		if( $idpedido > 0 ){
			$OBJ->set_Dato( $idpedido , 'int_IdPedido' );
		}else{
			$OBJ->set_Dato( 0 , 'int_IdPedido' );
		}
		$OBJ->set_Dato( $idp , 'int_IdProducto' );
		$OBJ->set_Dato( $idum , 'int_IdUnidadMedida' );
		$OBJ->set_Dato( $cant , 'int_Cantidad' );
		$OBJ->set_Dato( $precio , 'flt_Precio' );
		$OBJ->set_Dato( $total , 'flt_Total' );
		$OBJ->set_Dato( $tag , 'txt_Tag' );
		/* Actualizar, Insertar*/
		if( $idItem > 0 ){
			$OBJ->set_UnionQ( $idItem , 'int_IdDetallePedido' );
			$response['id'] = $OBJ->update_detalle_pedido();

		}else{
			$response['id'] = $OBJ->insert_detalle_pedido();
		}
		
		if( $idpedido > 0 ){
			$response = $OBJ->get_detalle_pedido( " AND p.int_IdPedido = '".$idpedido."' " );
		}else{
			$response = $OBJ->get_detalle_pedido( " AND p.txt_Tag = '".$tag."' " );
		}
		
	break;
	/* ------------------------------- */
	default:
		
		#Cliente
		$Cliente = strip_tags( $_POST["cboCliente"] );
		if( trim($Cliente) == '' ){
			$error['cliente'] = 'Seleccione Cliente';
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

		$OBJ->set_Valor( $Cliente , 'int_IdCliente' );
		$OBJ->set_Valor( $fecha , 'dt_Fecha' );
		$OBJ->set_Valor( $Total , 'flt_Total' );
		#$idPedido = $OBJ->insert_pedido();
		$response['idPedido'] = $idPedido;

		$OBJ1 = new Usuario();
		$OBJ1->set_Dato( $idPedido , 'int_IdPedido' );
		$OBJ1->set_UnionT( $tag , 'txt_Tag' );
		$response['sql'] = $OBJ1->join_pedido_detalle();
	break;
	/* ------------------------------- */
}

echo json_encode($response);

?>