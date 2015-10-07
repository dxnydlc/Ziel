<?php
session_start();
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ = new Usuario();
$response = array();
$error = array();
$filtro = '';

$filtro = $_POST["f"];
$existe = '';
$id 	= '';
$idventa= 0;
$hoy 	= '';

$Cliente 	= '';
$fecha 		= '';
$Total 		= 0;
$iduser 	= 0;
$hoy 		= date("Y-m-d H:i:s"); 
		
$iduser = $_SESSION["ziel_idu"];

$tag = strip_tags($_POST["tag"]);

if( $_POST["idPedido"] == "0" ){
	$filtro = 'insertPedido';
}

switch ($filtro){
	/* ------------------------------- */
	case 'delBoleta':
		$id 	= $_POST["id"];
		$texto 	= $_POST["texto"];
		$estadoDoc = $OBJ->get_estado_doc( $id , 'V' );
		#
		$OBJ->set_Union( $id , 'int_idVenta' );
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Valor( $iduser , 'int_idUserAnula' );
		$OBJ->set_Valor( $hoy , 'dt_Anulado' );
		$OBJ->set_Valor( $texto , 'txt_MotivoAnulado' );
		#
		$response['q'] = $OBJ->update_ventas();
		if( $estadoDoc == 'CER' ){
			#Muevo el kardex.
			$OBJ->anular_kardex( $id );
		}
		#Movimiento de Caja.
		$OBJ = new Usuario();
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdVenta' );
		$OBJ->update_caja();
	break;
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
		$response = $OBJ->get_detalle_venta01( " AND p.int_IdDetalleVenta = ".$idp );
	break;
	/* ------------------------------- */
	case 'delItem':
		$idItem	= $_POST["idItem"];
		$idp 	= $_POST["idp"];
		$OBJ->set_Dato( $idItem , 'int_IdDetalleVenta' );
		$OBJ->delete_detalle_venta();
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
		$idventa 	= $_POST["idDoc"];
		$idUsuario 	= $_POST["idBet"];
		$idLote 	= $_POST["idLote"];
		# =============================
		if( $idventa > 0 ){
			$OBJ->set_Dato( $idventa , 'int_IdVenta' );
		}else{
			$OBJ->set_Dato( 0 , 'int_IdVenta' );
		}
		# =============================
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
				$OBJ->set_Dato( $rsp->int_IdPromo , 'int_IdPromo' );
				$OBJ->set_Dato( $rsp->var_Promo , 'var_Promo' );
				$OBJ->set_Dato( $rsp->flt_Promo , 'flt_Promo' );
				$newPrecio = $rsp->flt_Promo;
			}
			$ntotal = $cant * $newPrecio;

			$OBJ->set_Dato( $ntotal , 'flt_Total' );
			unset($rsp);
		}else{
			$OBJ->set_Dato( $total , 'flt_Total' );
		}

		/* Actualizar, Insertar*/
		if( $idItem > 0 ){
			$OBJ->set_UnionQ( $idItem , 'int_IdDetalleVenta' );
			$response['id'] = $OBJ->update_detalle_venta();

		}else{
			$response['id'] = $OBJ->insert_detalle_venta();
		}
		
		if( $idventa > 0 ){
			$response = $OBJ->get_detalle_venta01( " AND v.int_IdVenta = '".$idventa."' " );
		}else{
			$response = $OBJ->get_detalle_venta01( " AND v.txt_Tag = '".$tag."' " );
		}
		
	break;
	/* ------------------------------- */
	default:
		
		#Cliente
		$Cliente = strip_tags( $_POST["cboCliente"] );
		if( trim($Cliente) == '' ){
			$error['cliente'] = 'Seleccione Cliente';
		}

		$ar_fecha 	= array();
		$Dia 		= "";
		$Mes 		= "";
		$Anio 		= "";
		$idUsuario  = $_POST["idBenutzer"];

		$Medio  	= $_POST["Medio"];
		$CantPago   = $_POST["CantPago"];
		$Vuelto  	= $_POST["Vuelto"];
		$Obs  		= $_POST["Obs"];
		#
		$corr 		= '';
		$corr_man 	= $_POST["Corr"];
		#Fecha
		$fecha = strip_tags($_POST["txtFecha"]);
		$ar_fecha = split("/", $fecha);
		list( $Dia , $Mes , $Anio ) = $ar_fecha;
		$fecha 	= $Anio.'-'.$Mes.'-'.$Dia;

		if(! checkdate ( $Mes , $Dia , $Anio ) ){
			$error['Fecha'] = 'Fecha Incorrecta';
		}

		#Total
		$Total = strip_tags($_POST["TotalVenta"]);
		$txtDir = strip_tags($_POST["txtDir"]);

		if( count($error) > 0 ){
			$errores = implode(', ', $error);
			$response['error'] = $errores;
			echo json_encode($response);
			die(0);
		}

		$response['error'] = '';
		$idVenta = $_POST["idVenta"];

		$OBJ->set_Valor( $Cliente , 'int_IdCliente' );
		$OBJ->set_Valor( $txtDir , 'var_Dir' );
		$OBJ->set_Valor( $fecha , 'dt_Fecha' );
		$OBJ->set_Valor( $Total , 'flt_Total' );
		$OBJ->set_Valor( $idUsuario , 'int_IdUsuario' );
		#
		$OBJ->set_Valor( $Medio , 'var_FormaPago' );
		$OBJ->set_Valor( $CantPago , 'flt_Pago' );
		$OBJ->set_Valor( $Vuelto , 'flt_Vuelto' );
		$OBJ->set_Valor( $Obs , 'var_Nota' );
		#
		if( $idVenta == 0 ){
			$OBJ->set_Valor( 'B' , 'cht_TipoDoc' );
			
			$existeCorr = 0;
			$existeCorr = $OBJ->existe_correlativo( $corr_man , 'B' );
			if( $existeCorr == 0 ){
				#No existe
				$corr = $corr_man;
			}else{
				#si existe, entonces saco el correlativo siguiente.
				$corr 		= $OBJ->get_max_correlativo( 'B' ) + 1;
			}
			$OBJ->set_Valor( '1' , 'int_Serie' );
			$OBJ->set_Valor( $corr , 'int_Correlativo' );
			$OBJ->set_Valor( 'Boleta '.sprintf("%05s", $corr ) , 'var_Mascara' );
			$idVenta = $OBJ->insert_ventas();
			/* Unir Detalle con encabezado */
			$OBJ1 = new Usuario();
			$OBJ1->set_Dato( $idVenta , 'int_IdVenta' );
			$OBJ1->set_UnionT( $tag , 'txt_Tag' );
			$OBJ1->join_venta_detalle();
			/**/
		}else{
			$OBJ->set_Union( $idVenta , 'int_idVenta' );
			$OBJ->update_ventas();
		}
		
		$response['idVenta'] = $idVenta;
		$response['serie'] = '1';
		$response['corr'] = $corr;
			
	break;
	/* ------------------------------- */
}

echo json_encode($response);

?>