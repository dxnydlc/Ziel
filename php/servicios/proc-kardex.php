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
	case 'menosKardex':
	#Se cierra la venta y se mueve el kardex
		$idv 	= $_POST["idv"];
		$idu 	= $_POST["idu"];
		$response['v'] = $OBJ->disminuir_kardex( $idv );
		$OBJ1 = new Usuario();
		$OBJ1->set_Valor( 'CER' , 'chr_Estado' );
		$OBJ1->set_Union( $idv , 'int_idVenta' );
		$OBJ1->update_ventas();
		#Agregar movimiento de caja.
		$OBJ = new Usuario();
		$OBJ->set_Valor( $idv , 'int_IdVenta' );
		$OBJ->set_Valor( $idu , 'int_IdUsuario' );
		$OBJ->insert_caja();
	break;
	/* ------------------------------- */
}

echo json_encode( $response );

?>