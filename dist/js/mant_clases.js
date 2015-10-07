
var _servicio = '../php/servicios/proc-clases.php';
var _idItemActivo = '';
var _filtroGeneral = '';

(function($){

	$(document).ready(function(){
		/* -------------------------------------- */
		$('#NuevoItem').click(function(event) {
			/* Act on the event */
			$('#myModal').modal('show');
			$('#myModalLabel').html('Nueva Clase de Producto');
			$('#idClase').val( '' );
			$('#txtNombre').val( '' );
			$('#f').val( '' );
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#myButton').on('click', function (e) {
		    var $btn = $(this).button('loading');
		    // business logic...
		    var _data = $('#frmData').serialize();
		    $.post( _servicio , _data , function(data, textStatus, xhr) {
		    	/* optional stuff to do after success */
		    	if( data.existe != undefined || data.existe != null ){
		    		if( data.existe == 'si' ){
		    			sendAlert(  'warning' , 'Response' , 'La clase de producto ya existe' );
		    			$btn.button('reset');
		    			return true;
		    		}
	    			if( data.id != 'false' ){
	    				sendAlert(  'success' , 'Response' , 'La clase se guardo correctamente' );
	    			}else{
	    				sendAlert(  'error' , 'Response' , 'Error al intentar guardar' );
	    			}
		    	}else{
		    		sendAlert(  'error' , 'Response' , 'Error al intentar guardar' );
		    	}
		    	$btn.button('reset');
		    	LoadClases();
		    },'json');
		    e.preventDefault();
		});
		/* -------------------------------------- */
		LoadClases();
		/* -------------------------------------- */
		$(document).delegate('.editClase', 'click', function(event){
			var _idclases = $(this).attr('rel');
			$('#myModalLabel').html('Editar Clase de Producto');
			$.post( _servicio , {f:'get-data-clase',idc:_idclases} , function(data,textStatus,xhr){
				/*optional stuff to do after success */
				if( data.data != null || data.data != undefined ){
					var _fila = [], _html = '';
					for (var i = 0; i < data.data.length; i++){
						_fila = data.data[i];
						$('#idClase').val( _fila.int_IdAuto );
						$('#txtNombre').val( _fila.var_Nombre );
						$('#f').val( 'update' );
					};
				}
				$('#myModal').modal('show');
				LoadClases();
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.anularClase', 'click', function(event){
			_idItemActivo = $(this).attr('rel');
			_filtroGeneral = 'del';
			mostrarPopup( 'Anular Clase de Producto','Confirme Anular la Clase: <b>'+$(this).attr('alt')+'</b>' );
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#GoPopup').click(function(event) {
			/* Act on the event */
			var $btn = $(this).button('loading');
			$.post( _servicio , { f :_filtroGeneral, idc : _idItemActivo } , function(data, textStatus, xhr) {
				console.log( data );
				$btn.button('reset');
				$('#ElPopup').modal('hide');
				LoadClases();
			},'json');
		});
		/* -------------------------------------- */
		$(document).delegate('.activarClase', 'click', function(event) {
			_idItemActivo = $(this).attr('rel');
			_filtroGeneral = 'act';
			mostrarPopup( 'Activar Clase de Producto','Confirme Activar la Clase: <b>'+$(this).attr('alt')+'</b>' );
			event.preventDefault();
		});
		/* -------------------------------------- */
	});

})(jQuery);



function LoadClases(){
	$.post( _servicio , {f:'get'} , function(data, textStatus, xhr) {
		/*optional stuff to do after success */
		if( data != undefined || data != null ){
			var _fila = [], _html = '';
			for (var i = 0; i < data.data.length; i++) {
				_fila = data.data[i];

				_html += '<tr>';
					_html += '<td>'+_fila.int_IdAuto+'</td>';
					_html += '<td><a href="#" class="editClase" rel="'+_fila.int_IdAuto+'" >'+_fila.var_Nombre+'</a></td>';
					_html += '<td>'+_fila.chr_Estado+'</td>';
				_html += '</tr>';

			};
			//console.log( data.data[i] );
			$('#tblClases tbody').html( _html );
		}
	},'json');
}

