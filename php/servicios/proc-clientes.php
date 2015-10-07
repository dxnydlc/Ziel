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
		# Devuelve todas los clientes
		$response = $OBJ->get_all_clientes('');
		break;
	// -------------------------------------------------
	case 'get-data-cliente':
		# Devuelve todos los datos de una clase
		$id 	= $_POST["idc"];
		$response = $OBJ->get_data_cliente( $id );
		break;
	// -------------------------------------------------
	case 'update':
		$id 	= $_POST["idCliente"];
		$nombre	= $_POST["txtNombre"];
		$ruc	= $_POST["txtRuc"];
		$dir	= $_POST["txtDir"];
		$OBJ->set_Valor( $nombre , 'var_Nombre' );
		$OBJ->set_Valor( $ruc , 'var_Ruc' );
		$OBJ->set_Valor( $dir , 'var_Dir' );
		$OBJ->set_Union( $id , 'int_IdCliente' );
		$OBJ->update_Cliente();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	case 'del':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'DEL' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdCliente' );
		$OBJ->update_Cliente();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	case 'act':
		$id 	= $_POST["idc"];
		$OBJ->set_Valor( 'ACT' , 'chr_Estado' );
		$OBJ->set_Union( $id , 'int_IdCliente' );
		$OBJ->update_Cliente();
		$response['id'] = $id;
		$response['existe'] = 'no';
		break;
	// -------------------------------------------------
	default:
		if( isset($_POST["txtNombre"]) ){
			$nombre = $_POST["txtNombre"];
			$ruc 	= $_POST["txtRuc"];
			$dir 	= $_POST["txtDir"];
			#Existe????????????
			$existe = $OBJ->existe_cliente( $ruc );
			if( $existe == 0 ){
				$response['existe'] = 'no';
				$OBJ->set_Dato( $nombre , 'var_Nombre' );
				$OBJ->set_Dato( $ruc , 'var_Ruc' );
				$OBJ->set_Dato( $dir , 'var_Dir' );
				$response['id'] = $OBJ->insert_Cliente();
			}else{
				$response['existe'] = 'ja';
			}
		}
		break;
	// -------------------------------------------------
}

		

echo json_encode($response);

?>