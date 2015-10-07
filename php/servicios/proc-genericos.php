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
		# Devuelve todas los productos genericos
		$response = $OBJ->get_all_genericos('');
		break;
	// -------------------------------------------------
	case 'get-data-generico':
		# Devuelve todos los datos de un generico
		$id 	= $_POST["idc"];
		$response = $OBJ->get_data_generico( $id );
		break;
	// -------------------------------------------------
	case 'update':
		$id 	= $_POST["idGenerico"];
		$nombre	= $_POST["txtNombre"];
		$OBJ->set_Valor( $nombre , 'var_Nombre' );
		$OBJ->set_Union( $id , 'int_IdGenerico' );
		$OBJ->update_Generico_Producto();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	case 'del':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdGenerico' );
		$OBJ->update_Generico_Producto();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	case 'act':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'ACT' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdGenerico' );
		$OBJ->update_Generico_Producto();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	default:
		if( isset($_POST["txtNombre"]) ){
			$nombre = $_POST["txtNombre"];
			#Existe????????????
			$existe = $OBJ->existe_clase( $nombre );
			if( $existe == 0 ){
				$response['existe'] = 'no';
				$OBJ->set_Dato( $nombre , 'var_Nombre' );
				$response['id'] = $OBJ->insert_Generico_Producto();
			}else{
				$response['existe'] = 'ja';
			}
		}
		break;
	// -------------------------------------------------
}

		

echo json_encode($response);

?>