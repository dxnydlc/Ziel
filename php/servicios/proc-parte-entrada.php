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
$idPE = 0;

$Cliente = '';
$fecha = '';
$Total = 0;

		

$tag = strip_tags($_POST["tag"]);

if( $_POST["idPedido"] == "0" ){
	$filtro = 'insertOC';
}

switch ($filtro){
	/* ------------------------------- */
	case 'updatePromos':
		$idp 		= $_POST["idp"];
		$OBJ->update_detalle_pe_for_promos( $idp );
	break;
	/* ------------------------------- */
	case 'goParteEntrada':
		$idp 		= $_POST["idp"];
		$response['idKardex'] = $OBJ->aumentar_kardex_from_pe( $idp );
		$OBJ1 = new Usuario();
		$OBJ1->set_Valor( 'CER' , 'chr_Estado' );
		$OBJ1->set_Union( $idp , 'int_IdParteEntrada' );
		$OBJ1->update_pe();
	break;
	/* ------------------------------- */
	case 'copy':
		$idp 	= $_POST["idp"];
		$response['id'] = $OBJ->copiar_parte_entrada( $idp );
	break;
	/* ------------------------------- */
	case 'delPE':
		$idpe 	= $_POST["idpe"];
		$estadoDoc = $OBJ->get_estado_doc( $idpe , 'PE' );
		#
		$OBJ->set_Union( $idpe , 'int_IdParteEntrada' );
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->update_pe();
		#
		$response['id'] = $estadoDoc;
		if( $estadoDoc == 'CER' ){
			#Muevo el kardex.
			$OBJ->anular_kardex_from_pe( $idpe );
		}
	break;
	/* ------------------------------- */
	case 'getItem':
		$idp 	= $_POST["idp"];
		$response = $OBJ->get_detalle_pe01( " AND p.int_IdDetallePE = ".$idp );
	break;
	/* ------------------------------- */
	case 'delItem':
		$idItem	= $_POST["idItem"];
		$idp 	= $_POST["idp"];
		$OBJ->set_Dato( $idItem , 'int_IdDetallePE' );
		$OBJ->delete_detalle_pe();
		$response = $OBJ->get_detalle_pe01( " AND p.int_IdParteEntrada = ".$idp );
	break;
	/* ------------------------------- */
	case 'addItem':
		#Insertar unidad de medida
		$idp 	= $_POST["idProd"];
		$idum 	= $_POST["idUM"];
		$cant 	= $_POST["txtCantidad"];
		$tag 	= $_POST["tag"];
		$total  = $_POST["txtTotal"];
		$idItem	= $_POST["idItem"];
		$idPE   = $_POST["idpedido"];
		$lote   = $_POST["txtLote"];
		$vence  = $_POST["txtVence"];
		$lab 	= $_POST["txtLab"];
		$vencimiento 	= '';
		$arr_fecha = array();
		if( $_POST["txtVence"] != '' ){
			$arr_fecha = split('/', $_POST["txtVence"] );
			$vencimiento 	= $arr_fecha[2].'-'.$arr_fecha[1].'-'.$arr_fecha[0];
		}
		#
		$compra 	= $_POST["txtPrecio"];
		$venta 		= $_POST["txtVenta"];
		$utilidad 	= $_POST["txtUtilidad"];
		# ==============================
		if( $idPE > 0 ){
			$OBJ->set_Dato( $idPE , 'int_IdParteEntrada' );
		}else{
			$OBJ->set_Dato( 0 , 'int_IdParteEntrada' );
		}
		$OBJ->set_Dato( $idp , 'int_IdProducto' );
		$OBJ->set_Dato( $idum , 'int_IdUnidadMedida' );
		$OBJ->set_Dato( $cant , 'int_Cantidad' );
		$OBJ->set_Dato( $compra , 'flt_Precio_Compra' );
		$OBJ->set_Dato( $venta , 'ftl_Precio_Venta' );
		$OBJ->set_Dato( $utilidad , 'flt_Utilidad' );
		$OBJ->set_Dato( $compra , 'flt_Precio' );
		$OBJ->set_Dato( $total , 'flt_Total' );
		$OBJ->set_Dato( $tag , 'txt_Tag' );
		$OBJ->set_Dato( $lote , 'var_Lote' );
		$OBJ->set_Dato( $vencimiento , 'dt_Vencimiento' );
		$OBJ->set_Dato( $lab , 'var_Laboratorio' );
		/* Actualizar, Insertar*/
		if( $idItem > 0 ){
			$OBJ->set_UnionQ( $idItem , 'int_IdDetallePE' );
			$response['id'] = $OBJ->update_detalle_pe();

		}else{
			$response['id'] = $OBJ->insert_detalle_pe();
		}
		
		/**/
		if( $idPE > 0 ){
			$response = $OBJ->get_detalle_pe01( " AND p.int_IdParteEntrada = '".$idPE."' " );
			#$response['id'] = $idPE;
		}else{
			$response = $OBJ->get_detalle_pe01( " AND p.txt_Tag = '".$tag."' " );
			#$response['id'] = $tag;
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

		$idPE = $_POST["idPE"];

		$OBJ->set_Valor( $Cliente , 'int_IdProveedor' );
		$OBJ->set_Valor( $fecha , 'dt_Fecha' );
		$OBJ->set_Valor( $Total , 'flt_Total' );

		if( $idPE == 0 ){
			$idPE = $OBJ->insert_pe();
		}else{
			$OBJ->set_Union( $idPE , 'int_IdParteEntrada' );
			$OBJ->update_pe();
		}
		
		$response['idPE'] = $idPE;

		$OBJ1 = new Usuario();
		$OBJ1->set_Dato( $idPE , 'int_IdParteEntrada' );
		$OBJ1->set_UnionT( $tag , 'txt_Tag' );
		$response['sql'] = $OBJ1->join_pe_detalle();
	break;
	/* ------------------------------- */
}

echo json_encode($response);

?>