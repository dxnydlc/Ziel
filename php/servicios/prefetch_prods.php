<?php
include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ 		= new Usuario();
$response 	= array();

$q = '';

$response = $OBJ->get_prefetch_prod( $q );


echo json_encode($response);


?>