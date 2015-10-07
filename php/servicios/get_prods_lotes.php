<?php
#obtendrá los productos desde los lotes
include_once '../mysql.class/mysql.class.php';
include_once '../clases/clsUsuario.php';

$OBJ 		= new Usuario();
$response 	= array();

$q = '';

$q = " AND p.var_Nombre LIKE '%".$_POST["q"]."%' ";

$response = $OBJ->get_productos_venta_by_lotes( $q );


echo json_encode($response);


?>