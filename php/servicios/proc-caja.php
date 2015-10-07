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
	/* ------------------------------- */
	case 'abrir':
		$idUsuario = $_POST["idu"];
		$monto = $_POST["monto"];
		$response['caja'] = $OBJ->insert_apertura_caja( $idUsuario , $monto );
	break;
	/* ------------------------------- */
	case 'cerrar':
		$idUsuario = $_POST["idu"];
		$monto = $_POST["monto"];
		$response['caja'] = $OBJ->insert_cierre_caja( $idUsuario , $monto );
	break;
	/* ------------------------------- */
	case 'get':
		$estado 	= $_POST["estado"];
		switch ($estado) {
			case '#Activos':
				$response = $OBJ->get_listado_caja( " AND v.chr_Estado = 'ACT' " );
				break;
			case '#Anulados':
				$response = $OBJ->get_listado_caja( " AND v.chr_Estado = 'DEL' " );
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
}

echo json_encode( $response );

?>