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
$idUsuarioZiel = $_SESSION["ziel_idu"];
		

$tag = strip_tags($_POST["tag"]);

switch ($filtro){
	/* ------------------------------- */
	case 'copy':
		$idp 	= $_POST["idp"];
		$response['id'] = $OBJ->copiar_venta( $idp , $idUsuarioZiel );
	break;
	/* ------------------------------- */
	case 'delBoleta':
		$id 	= $_POST["id"];
		$estadoDoc = $OBJ->get_estado_doc( $id , 'V' );
		#
		$OBJ->set_Union( $id , 'int_idVenta' );
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
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
	case 'get':
		$estado 	= $_POST["estado"];
		switch ($estado) {
			case '#Activos':
				$response = $OBJ->get_listado_ventas( " AND v.chr_Estado = 'ACT' " );
				break;
			case '#Anulados':
				$response = $OBJ->get_listado_ventas( " AND v.chr_Estado = 'DEL' " );
				break;
		}
	break;
	/* ------------------------------- */
	case 'buscar':
		$desde 	= $_POST["desde"];
		$hasta 	= $_POST["hasta"];
		#
		$fecha_desde = '';
		$fecha_hasta = '';
		if( $desde =='' ){
			return '';
		}
		if( $hasta =='' ){
			return '';
		}
		#
		$arr_desde = array();
		$arr_desde = explode('/', $desde );
		$fecha_desde = $arr_desde[2].'-'.$arr_desde[1].'-'.$arr_desde[0];
		$arr_hasta = array();
		//
		$arr_hasta = explode('/', $hasta );
		$fecha_hasta = $arr_hasta[2].'-'.$arr_hasta[1].'-'.$arr_hasta[0];
		#
		$response = $OBJ->get_listado_ventas( " AND v.dt_Fecha >= '".$fecha_desde."' AND v.dt_Fecha <= '".$fecha_hasta."' " );
	break;
	/* ------------------------------- */
	case 'menosKardex':
		$idv 	= $_POST["idv"];
		$response['v'] = $OBJ->disminuir_kardex( $idv );
		$OBJ1 = new Usuario();
		$OBJ1->set_Valor( 'CER' , 'chr_Estado' );
		$OBJ1->set_Union( $idv , 'int_idVenta' );
		$OBJ1->update_ventas();
	break;
	/* ------------------------------- */
}

echo json_encode( $response );

?>