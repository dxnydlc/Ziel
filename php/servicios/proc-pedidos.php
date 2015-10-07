<?php
session_start();
include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ = new Usuario();
$response 	= array();
$error 		= array();
$filtro 	= '';

$filtro 	= $_POST["f"];
$idu 		= $_POST["from"];
$existe 	= '';
$id 		= '';
$idPedido 	= 0;

$Cliente 	= '';
$fecha 		= '';
$Total 		= 0;
$idUsuarioZiel = $_SESSION["ziel_idu"];
		

$tag = strip_tags($_POST["tag"]);

if( $_POST["idPedido"] == "0" ){
	$filtro = 'insertPedido';
}

switch ($filtro){
	/* ------------------------------- */
	case 'goBoleta':
		$idp 		= $_POST["idp"];
		$TipoDoc 	= $_POST["TipoDoc"];
		$serie 		= $_POST["serie"];
		$response['idVenta'] = $OBJ->facturar_pedido( $TipoDoc , $idp , $serie , $idUsuarioZiel );
	break;
	/* ------------------------------- */
	case 'copy':
		$idp 	= $_POST["idp"];
		$response['id'] = $OBJ->copiar_pedido( $idp , $idu );
	break;
	/* ------------------------------- */
	case 'delPedido':
		$idp 	= $_POST["idp"];
		$OBJ->set_Union( $idp , 'int_IdPedido' );
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$response['id'] = $OBJ->update_pedido();
	break;
	/* ------------------------------- */
	case 'getItem':
		$idp 	= $_POST["idp"];
		$response = $OBJ->get_detalle_pedido01( " AND p.int_IdDetallePedido = ".$idp );
	break;
	/* ------------------------------- */
	case 'delItem':
		$idItem	= $_POST["idItem"];
		$idp 	= $_POST["idp"];
		$OBJ->set_Dato( $idItem , 'int_IdDetallePedido' );
		$OBJ->delete_detalle_pedido();
		$response = $OBJ->get_detalle_pedido01( " AND p.int_IdDetallePedido = ".$idp );
	break;
	/* ------------------------------- */
	case 'addItem':
		#Insertar unidad de medida
		$idp 		= $_POST["idProd"];
		$idum 		= $_POST["idUM"];
		$cant 		= $_POST["txtCantidad"];
		$precio 	= $_POST["txtPrecio"];
		$tag 		= $_POST["tagItem"];
		$total  	= $_POST["txtTotal"];
		$idItem		= $_POST["idItem"];
		$idpedido 	= $_POST["idDoc"];
		$idUsuario 	= $_POST["idBet"];
		$idLote 	= $_POST["idLote"];
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
		$OBJ->set_Dato( $idLote , 'int_IdLote' );
		#Total se calcula
		$OBJ->set_Dato( $tag , 'txt_Tag' );
		$OBJ->set_Dato( $idUsuario , 'int_IdUsuario' );

		#Busco si el producto esta dentro de una promoción.
		$newPrecio = 0;
		$arPromo = array();
		$response['promo'] = $arPromo = $OBJ->prod_in_promo( $idp );
		if(is_array($arPromo)){
			foreach ($arPromo as $key => $rsp) {
				$OBJ->set_Dato( $rsp["int_IdPromo"] , 'int_IdPromo' );
				$OBJ->set_Dato( $rsp["var_Promo"] , 'var_Promo' );
				$OBJ->set_Dato( $rsp["flt_Promo"] , 'flt_Promo' );
				$newPrecio = $rsp["flt_Promo"];
			}
			$ntotal = $cant * $newPrecio;

			$OBJ->set_Dato( $ntotal , 'flt_Total' );
			unset($rsp);
		}else{
			$OBJ->set_Dato( $total , 'flt_Total' );
		}

		/* Actualizar, Insertar*/
		if( $idItem > 0 ){
			$OBJ->set_UnionQ( $idItem , 'int_IdDetallePedido' );
			$response['id'] = $OBJ->update_detalle_pedido();

		}else{
			$response['id'] = $OBJ->insert_detalle_pedido();
		}
		
		/**/
		if( $idpedido > 0 ){
			$response = $OBJ->get_detalle_pedido01( " AND p.int_IdPedido = '".$idpedido."' " );
		}else{
			$response = $OBJ->get_detalle_pedido01( " AND p.txt_Tag = '".$tag."' " );
		}
		/**/
		
		
	break;
	/* ------------------------------- */
	default:
		
		#Cliente
		$Cliente = strip_tags($_POST["cboCliente"]);
		if( trim($Cliente) == '' ){
			$error['cliente'] = 'Seleccione Cliente';
		}

		$ar_fecha = array();
		$Dia 	= "";
		$Mes 	= "";
		$Anio 	= "";
		$idUsuario  = $_POST["idBenutzer"];

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

		$idPedido = $_POST["idPedido"];

		$OBJ->set_Valor( $Cliente , 'int_IdCliente' );
		$OBJ->set_Valor( $fecha , 'dt_Fecha' );
		$OBJ->set_Valor( $Total , 'flt_Total' );
		$OBJ->set_Valor( $idUsuario , 'int_IdUsuario' );

		if( $idPedido > 0 ){
			$OBJ->set_Union( $idPedido , 'int_IdPedido' );
			$OBJ->update_pedido();
		}else{
			$idPedido = $OBJ->insert_pedido();
		}
		
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