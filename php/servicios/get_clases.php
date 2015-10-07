<?php
include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ 		= new Usuario();
$response 	= array();

$q = '';

$q = " AND var_Nombre LIKE '%".$_GET["q"]."%' ";

$response = $OBJ->get_clases_json( $q );


echo json_encode($response);

?>