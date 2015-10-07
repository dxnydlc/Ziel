<?php

include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ = new Usuario();
$response = array();
$filtro = '';

$filtro = $_POST["f"];
$existe = '';
$id 	= '';

switch ($filtro) {
	// -------------------------------------------------
	case 'get':
		# Devuelve todas las promociones
		$response = $OBJ->get_promo_listado('');
		break;
	// -------------------------------------------------
	case 'get-prods':
		# Devuelve todos los productos que contienen una promocion determinada
		$idPromo 	= $_POST["idPromo"];
		$response = $OBJ->get_productos_in_promo( $idPromo );
		break;
	// -------------------------------------------------
	case 'del':
		$idPromo 	= $_POST["idPromo"];
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $idPromo , 'int_IdPromocion' );
		$OBJ->update_promocion();
		$OBJ1 = new Usuario();
		$OBJ1->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ1->set_Union( $idPromo , 'int_IdPromo' );
		$OBJ1->update_detalle_promocion();
		break;
	// -------------------------------------------------
	default:

		$arDias = array();
		$losdias = '';
		$arDesde = array();
		$arHasta = array();
		$artime1 = array();
		$artime2 = array();
		$texto_desde = '';
		$texto_hasta = '';
		#
		$Nombre			= $_POST['Nombre'];
		$idUsuario 		= $_POST['idUsuario'];
		$cboPara		= $_POST['cboPara'];
		$idObjeto		= $_POST['idObjeto'];
		#$cboClase 		= $_POST['cboClase'];
		#$Objeto 		= $_POST['Objeto'];
		$cboAplicar		= $_POST['cboAplicar'];
		$Valor			= $_POST['Valor'];
		$tiempo			= $_POST['tiempo'];
		$Desde			= $_POST['Desde'];
		$Hasta			= $_POST['Hasta'];
		$restriccion 	= $_POST["Restric"];
		$Mascara 		= $_POST["Mascara"];

		if( $Desde != '' ){
			$artime1 = explode( ' ' , $Desde );
			$arDesde = explode( '/' , $artime1[0] );
			$texto_desde = $arDesde[2].'-'.$arDesde[1].'-'.$arDesde[0].' '.$artime1[1];
		}
		if( $Hasta != '' ){
			$artime2 = explode( ' ' , $Hasta );
			$arHasta = explode( '/' , $artime2[0] );
			$texto_hasta = $arHasta[2].'-'.$arHasta[1].'-'.$arHasta[0].' '.$artime2[1];
		}

		$Dias			= $_POST['Dias'];

		foreach( $_POST["Dias"] as $valorCheckbox ){
            array_push( $arDias , $valorCheckbox );
        }
        if(is_array($arDias)){
        	$losdias = implode(',', $arDias );
        }

		$HoraI			= $_POST['HoraI'];
		$HoraF			= $_POST['HoraF'];
		$idPromo		= $_POST['idPromo'];
		
		# =====================================================

		$OBJ->set_Valor( $idUsuario , 'int_IdUsuario' );
		$OBJ->set_Valor( $Nombre , 'var_Nombre' );
		$OBJ->set_Valor( $cboPara , 'var_Para' );
		$OBJ->set_Valor( $idObjeto , 'int_Objeto' );
		$OBJ->set_Valor( $cboAplicar , 'var_Aplicar' );
		$OBJ->set_Valor( $Valor , 'flt_ValorAplicar' );
		$OBJ->set_Valor( $tiempo , 'var_Tiempo' );
		$OBJ->set_Valor( $texto_desde , 'dt_Desde' );
		$OBJ->set_Valor( $texto_hasta , 'dt_Hasta' );
		$OBJ->set_Valor( $losdias , 'var_Dias' );
		$OBJ->set_Valor( $HoraI , 'var_HoraInicio' );
		$OBJ->set_Valor( $HoraF , 'var_HoraFin' );
		#
		$OBJ->set_Valor( $Mascara , 'var_Mascara' );
		$OBJ->set_Valor( $restriccion , 'txt_Restric' );
		$idPromo = $OBJ->insert_promocion();
		$response['idPromo'] = $idPromo;

		if( $idPromo > 0 ){
			#Ahora vamos a generar los precios por cada producto en base a esta promo.
			switch ($cboPara) {
				case 'Producto':
					$OBJ1 = new Usuario();
					$arr_prec 	= array();
					$arr_prec 	= explode(',', $OBJ1->get_precio_producto1( $idObjeto ) );
					$precio 	= 0;
					$promo 		= 0;
					$proct 		= 0;
					$precio 	= $arr_prec[0];
					if( $cboAplicar == 'PrecioFijo' ){
						$promo = $Valor;
					}else{
						$proct 		= ( $precio * $Valor ) / 100;
						$promo 		= $precio - $proct;
					}
					#
					$OBJ1->set_Valor( $idPromo , 'int_IdPromo' );
					$OBJ1->set_Valor( $idObjeto , 'int_IdProducto' );
					$OBJ1->set_Valor( $precio , 'flt_Precio' );
					$OBJ1->set_Valor( $promo , 'flt_Promo' );
					$OBJ1->set_Valor( $Nombre , 'var_Descri' );
					$OBJ1->set_Valor( $cboAplicar , 'var_Aplicar' );
					$OBJ1->set_Valor( $Valor , 'flt_Valor' );
					$OBJ1->insert_producto_promocion();
					break;
				case 'Clase':
					$OBJ1 = new Usuario();
					$arr_prec 	= array();
					$data_clase = array();
					$data_clase = $OBJ1->get_clases_for_prods( $idObjeto );
					foreach ($data_clase as $key => $rs) {
						$idProd = 0;
						$idProd = $rs->idp;
						$arr_prec 	= explode(',', $OBJ1->get_precio_producto1( $idProd ) );
						$precio 	= 0;
						$promo 		= 0;
						$proct 		= 0;
						$precio 	= $arr_prec[0];
						if( $cboAplicar == 'PrecioFijo' ){
							$promo = $Valor;
						}else{
							$proct 		= ( $precio * $Valor ) / 100;
							$promo 		= $precio - $proct;
						}
						#
						$OBJ1->set_Valor( $idPromo , 'int_IdPromo' );
						$OBJ1->set_Valor( $idProd , 'int_IdProducto' );
						$OBJ1->set_Valor( $precio , 'flt_Precio' );
						$OBJ1->set_Valor( $promo , 'flt_Promo' );
						$OBJ1->set_Valor( $Nombre , 'var_Descri' );
						$OBJ1->set_Valor( $cboAplicar , 'var_Aplicar' );
						$OBJ1->set_Valor( $Valor , 'flt_Valor' );
						$OBJ1->insert_producto_promocion();
					}
					break;
			}
			#devolver los productos afectados
			$response['data'] = $OBJ->get_productos_in_promo( $idPromo );
		}
			

		break;
	// -------------------------------------------------
}

		

echo json_encode($response);

?>