

var _servicio = '../php/servicios/proc-clientes.php';
var _idItemActivo = '';
var _filtroGeneral = '';

(function($){

	$(document).ready(function(){
		/* -------------------------------------- */
		$('#NuevoItem').click(function(event) {
			/* Act on the event */
			$('#myModal').modal('show');
			$('#myModalLabel').html('Nueva Clase de Producto');
			$('#idCliente').val( '' );
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
		    			sendAlert(  'warning' , 'Response' , 'El Cliente ya existe' );
		    			$btn.button('reset');
		    			return true;
		    		}
	    			if( data.id != 'false' ){
	    				sendAlert(  'success' , 'Response' , 'El Cliente se guardó correctamente' );
	    			}else{
	    				sendAlert(  'error' , 'Response' , 'Error al intentar guardar' );
	    			}
		    	}else{
		    		sendAlert(  'error' , 'Response' , 'Error al intentar guardar' );
		    	}
		    	$btn.button('reset');
		    	LoadClientes();
		    	document.location.reload();
		    },'json');
		    e.preventDefault();
		});
		/* -------------------------------------- */
		LoadClientes();
		/* -------------------------------------- */
		$(document).delegate('.editClase', 'click', function(event){
			var _idClientes = $(this).attr('rel');
			$('#myModalLabel').html('Editar Cliente');
			$.post( _servicio , {f:'get-data-cliente',idc:_idClientes} , function(data,textStatus,xhr){
				/*optional stuff to do after success */
				if( data.data != null || data.data != undefined ){
					var _fila = [], _html = '';
					for (var i = 0; i < data.data.length; i++){
						_fila = data.data[i];
						$('#idCliente').val( _fila.int_IdCliente );
						$('#txtRuc').val( _fila.var_Ruc );
						$('#txtDir').val( _fila.var_Dir );
						$('#txtNombre').val( _fila.var_Nombre );	
						$('#f').val( 'update' );
					};
				}
				$('#myModal').modal('show');
				LoadClientes();
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
				LoadClientes();
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



function LoadClientes(){
	$.post( _servicio , {f:'get'} , function(data, textStatus, xhr) {
		/*optional stuff to do after success */
		if( data != undefined || data != null ){
			var _fila = [], _html = '';
			for (var i = 0; i < data.data.length; i++) {
				_fila = data.data[i];

				_html += '<tr>';
					_html += '<td>'+_fila.int_IdCliente+'</td>';
					_html += '<td><a href="#" class="editClase" rel="'+_fila.int_IdCliente+'" ><span class="fa fa-male " ></span> '+_fila.var_Nombre+'</a></td>';
					_html += '<td>'+_fila.var_Ruc+'</td>';
					_html += '<td>'+_fila.chr_Estado+'</td>';
					_html += '';
				_html += '</tr>';
			};
			$('#tblClientes tbody').html( _html );
		}
	},'json');
}


/*Solo Numeros*/
/*
onkeypress="return validar(event);"
*/
function validar(e) {
    tecla = (document.all)?e.keyCode:e.which;//ascii
    //alert(tecla);
    switch(tecla){
        case 8:
            return true;
            break;
        case 46://punto
            return  true;
            break;
        case 43://Mas
            return true;
            break;
        case 45://Menos
            return true;
            break;
        case 44://Coma
            return true;
            break;
        case 0://Suprimir
            return true;
            break;
            

        default:
            
            break;
    }
    patron = /\d/;
    te = String.fromCharCode(tecla);
    
    return patron.test(te);
    
}
