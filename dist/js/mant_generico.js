
var _servicio = '../php/servicios/proc-genericos.php';
var _idItemActivo = '';
var _filtroGeneral = '';

(function($){

	$(document).ready(function(){
		/* -------------------------------------- */
		$('#NuevoItem').click(function(event) {
			/* Act on the event */
			$('#myModal').modal('show');
			$('#myModalLabel').html('Nueva Producto Generico');
			$('#idGenerico').val( '' );
			$('#txtNombre').val( '' );
			$('#f').val( '' );
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#myButton').on('click', function (e) {
		    var $btn = $(this).button('loading');
		    // Nuevo registro
		    var _data = $('#frmData').serialize();
		    $.post( _servicio , _data , function(data, textStatus, xhr) {
		    	/* optional stuff to do after success */
		    	if( data.existe != undefined || data.existe != null ){
		    		if( data.existe == 'si' ){
		    			sendAlert(  'warning' , 'Response' , 'El generico de producto ya existe' );
		    			$btn.button('reset');
		    			return true;
		    		}
	    			if( data.id != 'false' ){
	    				sendAlert(  'success' , 'Response' , 'El generico se guardo correctamente' );
	    			}else{
	    				sendAlert(  'error' , 'Response' , 'Error al intentar guardar' );
	    			}
		    	}else{
		    		sendAlert(  'error' , 'Response' , 'Error al intentar guardar' );
		    	}
		    	$btn.button('reset');
		    	loadGenericos();
		    },'json');
		    e.preventDefault();
		});
		/* -------------------------------------- */
		loadGenericos();
		/* -------------------------------------- */
		$(document).delegate('.editClase', 'click', function(event){
			var _idGenericos = $(this).attr('rel');
			$('#myModalLabel').html('Editar Producto Generico');
			$.post( _servicio , {f:'get-data-generico',idc:_idGenericos} , function(data,textStatus,xhr){
				/*optional stuff to do after success */
				if( data.data != null || data.data != undefined ){
					var _fila = [], _html = '';
					for (var i = 0; i < data.data.length; i++){
						_fila = data.data[i];
						$('#idGenerico').val( _fila.int_IdGenerico );
						$('#txtNombre').val( _fila.var_Nombre );
						$('#f').val( 'update' );
					};
				}
				$('#myModal').modal('show');
				loadGenericos();
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.anularClase', 'click', function(event){
			_idItemActivo = $(this).attr('rel');
			_filtroGeneral = 'del';
			mostrarPopup( 'Anular Producto Generico','Confirme Generico: <b>'+$(this).attr('alt')+'</b>' );
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
				loadGenericos();
			},'json');
		});
		/* -------------------------------------- */
		$(document).delegate('.activarClase', 'click', function(event) {
			_idItemActivo = $(this).attr('rel');
			_filtroGeneral = 'act';
			mostrarPopup( 'Activar Producto Generico','Confirme Activar Generico: <b>'+$(this).attr('alt')+'</b>' );
			event.preventDefault();
		});
		/* -------------------------------------- */
	});

})(jQuery);



function loadGenericos(){
	$.post( _servicio , {f:'get'} , function(data, textStatus, xhr) {
		/*optional stuff to do after success */
		if( data.data != undefined || data.data != null ){
			var _fila = [], _html = '';
			for (var i = 0; i < data.data.length; i++) {
				_fila = data.data[i];

				_html += '<tr>';
					_html += '<td>'+_fila.int_IdGenerico+'</td>';
					_html += '<td><a href="#" class="editClase" rel="'+_fila.int_IdGenerico+'" >'+_fila.var_Nombre+'</a></td>';
					_html += '<td>'+_fila.chr_Estado+'</td>';
				_html += '</tr>';

			};
			//console.log( data.data[i] );
			$('#tblGenerico tbody').html( _html );
		}
	},'json');
}

