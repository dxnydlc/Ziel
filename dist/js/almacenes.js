var _servicio = '../php/servicios/proc-almacen.php';

(function($){
	$(document).ready(function(){
		/* -------------------------------------------- */
		$('#NuevoAlmacen').click(function(event) {
			// Nuevo Almacen
			alertify.prompt("Nuevo Almacen", function (e, str) {
				// str is the input text
				if (e) {
					$.post( _servicio , {f:'',txtNombre:str} , function(data, textStatus, xhr) {
						if( data.existe == 'no' ){
							loadTablita( data.data );
						}else{
							alertify.error('El nombre de almacén ya existe en la base de datos.');
						}
					},'json');
				} else {
					// user clicked "cancel"
				}
			}, '' );
			event.preventDefault();
		});
		/* -------------------------------------------- */
		$(document).delegate('.editarAlmacen', 'click', function(event) {
			_Almacen =  $(this).html();
			var _idA = $(this).attr('rel');
			//Editar almacen
			alertify.prompt("Editar Almacen", function (e, str) {
				// str is the input text
				if (e) {
					$.post( _servicio , {f:'update',txtNombre:str, ida:_idA} , function(data, textStatus, xhr) {
						if( data.existe == 'no' ){
							loadTablita( data.data );
						}else{
							alertify.error('El nombre de almacén ya existe en la base de datos.');
						}
					},'json');
				} else {
					// user clicked "cancel"
				}
			}, _Almacen );
			event.preventDefault();
		});
		/* -------------------------------------------- */

	});
})(jQuery);

function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++) {
			_fila = json.data[i];

			_html += '<tr>';
				_html += '<td>'+_fila.int_IdAlmacen+'</td>';
				_html += '<td>';
					_html += '<a href="#" rel="'+_fila.int_IdDetallePedido+'" class=editarAlmacen" >'+_fila.var_Nombre+'</a>';
				_html += '</td>';
				_html += '<td>'+_fila.chr_Estado+'</td>';
				_html += '<td>'+_fila.ts_Registro+'</td>';
		};
		$('#tblAlmacen tbody').html( _html );
	}
}
