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
	case 'get':
		$idu 	= $_POST["idu"];
		$response = $OBJ->get_data_usuario( $idu );
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
	default:
	$idu 		= $_POST["idu"];
	$Nombre 	= $_POST["Nombre"];
	$Correo 	= $_POST["Correo"];
	$Usuario 	= $_POST["Usuario"];
	$clave 		= $_POST["clave"];
	$Tipo 		= $_POST["Tipo"];
	#
	$OBJ->set_Dato( $Usuario , 'var_Usuario' );
	$OBJ->set_Dato( $Correo , 'var_Mail' );
	$OBJ->set_Dato( $Nombre , 'Var_Nombre' );
	$OBJ->set_Dato( $Tipo , 'cht_Tipo' );
	#
	$clave = sha1( $clave );
	$OBJ->set_Dato( $clave , 'txt_Clave' );
	#
	if( $idu != '' ){
		$OBJ->set_UnionQ( $idu , 'int_IdUsuario' );
		$OBJ->update_usuario();
		$response["idu"] = $idu;
	}else{
		$response["idu"] = $OBJ->insert_usuario();
	}
	$response['data'] = $OBJ->get_usuarios_lista();
	break;
	/* ------------------------------- */
}

echo json_encode( $response );

?>