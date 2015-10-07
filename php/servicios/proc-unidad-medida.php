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
		# Devuelve todas las unidades de medida
		$response = $OBJ->get_unidades_medida('');
		break;
	// -------------------------------------------------
	case 'get-data-clase':
		# Devuelve todos los datos de una clase
		$id 	= $_POST["idc"];
		$response = $OBJ->get_data_um( $id );
		break;
	// -------------------------------------------------
	case 'update':
		$id 	= $_POST["idClase"];
		$nombre	= $_POST["txtNombre"];
		$OBJ->set_Valor( $nombre , 'var_Nombre' );
		$OBJ->set_Union( $id , 'int_IdAuto' );
		$OBJ->update_Clase_Producto();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	case 'del':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdAuto' );
		$OBJ->update_Clase_Producto();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	case 'act':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'ACT' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdAuto' );
		$OBJ->update_Clase_Producto();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	default:
		if( isset($_POST["txtNombre"]) ){
			$nombre = $_POST["txtNombre"];
			$abrev = $_POST["txtAbrev"];
			#Existe????????????
			$existe = $OBJ->existe_um( $nombre );
			if( $existe == 0 ){
				$response['existe'] = 'no';
				$OBJ->set_Dato( $nombre , 'var_Nombre' );
				$OBJ->set_Dato( $abrev , 'chr_Abr' );
				$response['id'] = $OBJ->insert_unidad_medida();
			}else{
				$response['existe'] = 'ja';
			}
		}
		break;
	// -------------------------------------------------
}

		

echo json_encode($response);

?>