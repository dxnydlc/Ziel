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
		# Devuelve todos los almacenes
		$response = $OBJ->get_all_almacenes('');
		break;
	// -------------------------------------------------
	case 'update':
		$id 	= $_POST["ida"];
		$nombre	= $_POST["txtNombre"];
		#
		#Existe????????????
		$existe = $OBJ->existe_Almacen( $nombre );
		if( $existe == 0 ){
			$OBJ->set_Valor( $nombre , 'var_Nombre' );
			$OBJ->set_Union( $id , 'int_IdAlmacen' );
			$OBJ->update_Almacen();
			$response['id'] = $id;
			$response['existe'] = 'no';
		}else{
			$response['existe'] = 'ja';
		}		
		break;
	// -------------------------------------------------
	case 'del':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdAlmacen' );
		$OBJ->update_Almacen();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	default:
		if( isset($_POST["txtNombre"]) ){
			$nombre = $_POST["txtNombre"];
			#Existe????????????
			$existe = $OBJ->existe_Almacen( $nombre );
			if( $existe == 0 ){
				$response['existe'] = 'no';
				$OBJ->set_Dato( $nombre , 'var_Nombre' );
				$response['id'] = $OBJ->insert_Almacen();
			}else{
				$response['existe'] = 'ja';
			}
			$response['data'] = $OBJ->get_all_almacenes('');
		}
		break;
	// -------------------------------------------------
}

		

echo json_encode($response);

?>