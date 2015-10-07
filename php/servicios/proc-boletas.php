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

switch ($filtro){
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
		#
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
		$fecha 	= $_POST["fecha"];
		$fecha_formato = '';
		if( $fecha =='' ){
			return '';
		}
		$arr_fecha = array();
		$arr_fecha = explode('/', $fecha );
		$fecha_formato = $arr_fecha[2].'-'.$arr_fecha[1].'-'.$arr_fecha[0];
		$response = $OBJ->get_listado_ventas( " AND v.dt_Fecha = '".$fecha_formato."' " );
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