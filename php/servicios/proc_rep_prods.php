<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';



$OBJ 		= new Usuario();
$response 	= array();
$filtro 	= '';
$query 		= '';

$filtro = $_POST["f"];
$existe = '';
$id 	= '';


switch ($filtro){
	// -------------------------------------------------
	case 'buscar':
		$query = " AND p.var_Nombre like  '%".$_POST["q"]."%'";
		$response = $OBJ->get_productos_lotes_lista( $query );
		break;
	// -------------------------------------------------
}
		

echo json_encode($response);


?>