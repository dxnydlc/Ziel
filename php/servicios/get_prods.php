<?php
include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ 		= new Usuario();
$response 	= array();

$q = '';

$q = " AND p.var_Nombre LIKE '%".$_GET["q"]."%' ";

$response = $OBJ->get_productos_venta( $q );


echo json_encode($response);


?>