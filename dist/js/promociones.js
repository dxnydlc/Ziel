
var _servicio = '../php/servicios/proc-promociones.php';
var _idPedidoX = 0, _docGenerate = '', _serieUsar = '';

(function($){

	//

	$(document).ready(function(){
		/* -------------------------------------- */
		$(document).delegate('.anularPromo', 'click', function(event) {
			var _idP = $(this).attr('href');
			alertify.confirm('Confirme anular Promoción',function(e){
				if(e){
					$.post( _servicio , {f:'del',idPromo:_idP} , function(data, textStatus, xhr) {
						alertify.error('Promoción anulada');
						$('#Fila_'+_idP).removeClass().addClass('danger');
						$('#Estado_'+_idP).html('DEL');
					});
				}
			});
			event.preventDefault();
		});
		/* -------------------------------------- */
	});
})(jQuery);
