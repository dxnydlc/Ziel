

/* ----------------------------------------------------- */
/* Pinta un mensaje de alerta en un objeto. */
function sendAlert( _clase , _objeto , _texto ){

	var _html = '';

	_html = '<div class="alert alert-'+_clase+'" role="alert">'+_texto+'</div>';
		

	$('#'+_objeto).html( _html );

}
/* ----------------------------------------------------- */
function clearAlert( _objeto ){
	var _html = 'l';
	$('#'+_objeto).empty();
	//$('#'+_objeto).html( _html );
	console.log('>>>>>>>>>>>>>>Response');
}
/* ----------------------------------------------------- */
function mostrarPopup( _titulo,_texto){
	$('#popupTitulo').html(_titulo);
	$('#popupTexto').html(_texto);
	$('#ElPopup').modal('show');
}
/* ----------------------------------------------------- */