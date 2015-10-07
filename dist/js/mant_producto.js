var _servicio = '../php/servicios/proc-productos.php';
var _idItemActivo = '';
var _filtroGeneral = '';

var _pc = 0, _pv = 0, _ut = 0;

(function($){

	$(document).ready(function(){
		/* -------------------------------------- */
		$('.Zebra_Pagination ul').addClass('pagination');
		//Seleccionar la pagina actual
		$('.Zebra_Pagination ul li').each(function(index, el) {
			var _obj = $(this).find('a');
			if( Number(_obj.html()) == Number(_pagina) ){
				$(this).addClass('active');
			}
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
		    	loadProductosLista();
		    },'json');
		    e.preventDefault();
		});
		/* -------------------------------------- */
		//loadProductosLista();
		/* -------------------------------------- */
		$(document).delegate('.editClase', 'click', function(event){
			var _idProducto = $(this).attr('rel');
			document.location.href = 'editar-producto.php?idp='+_idProducto;
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.anularProd', 'click', function(event){
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
				loadProductosLista();
			},'json');
		});
		/* -------------------------------------- */
		$(document).delegate('.activarProd', 'click', function(event) {
			_idItemActivo = $(this).attr('rel');
			_filtroGeneral = 'act';
			mostrarPopup( 'Activar Clase de Producto','Confirme Activar el Producto: <b>'+$(this).attr('alt')+'</b>' );
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#frmBuscar').submit(function(event) {
			/* Buscar producto dentro de la lista */
			var _query = $('#txtBuscar').val();
			if( _query == '' ){
				alertify.error('Ingrese un nombre de producto');
				event.preventDefault();
				return true;
			}
			$.post( _servicio , {f:'buscar',q: _query} , function(data, textStatus, xhr) {
				load_resultados_busqueda( data );
				//Activo el tab de busqueda.
				$('#tab2').tab('show');
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#txtBuscar').keypress(function(event) {
			if( event.keyCode == 13 ){
				$('#frmBuscar').submit();
				event.preventDefault();
			}
		});
		/* -------------------------------------- */
	});

})(jQuery);


function load_resultados_busqueda( data ){
	/*optional stuff to do after success */
	if( data.data != undefined || data.data != null ){
		var _fila = [], _html = '';
		for (var i = 0; i < data.data.length; i++) {
			_fila = data.data[i];

			var _clases = [], _txtClases = '', _cls = [], _ico = '<span class="fa fa-bookmark-o " ></span>';
			if( _fila.clases != null || _fila.clases != undefined ){
				for (var c = 0; c < _fila.clases.length; c++) {
					_clases = _fila.clases[c];
					_cls.push( _clases.name );
				};
				_txtClases = _cls.join(', ');
			}

			if( _fila.chr_Destacado == 1 ){
				_ico = '<span class="fa fa-bookmark " ></span>';
			}
			_html += '<tr>';
				_html += '<td>'+_fila.int_IdProducto+'</td>';
				_html += '<td>'+_ico+'</td>';
				_html += '<td><a href="editar-producto.php?idp='+_fila.int_IdProducto+'" ><span class="fa fa-barcode" ></span> '+_fila.producto+'</a></td>';
				var _arPrecio = _fila.arPrecio, _textoAr = [];
				_textoAr = _arPrecio.split(',');
				_html += '<td class="text-right" >'+_textoAr[0]+'</td>';
				_html += '<td>'+_txtClases+'</td>';
				_html += '<td>'+_fila.generico+'</td>';
				_html += '<td>'+_fila.estado+'</td>';
			_html += '</tr>';
		};
		//console.log( data.data[i] );
		$('#tblBusquseda tbody').html( _html );
	}
}

function loadProductosLista(){
	$.post( _servicio , {f:'get'} , function(data, textStatus, xhr) {
		/*optional stuff to do after success */
		if( data.data != undefined || data.data != null ){
			var _fila = [], _html = '';
			for (var i = 0; i < data.data.length; i++) {
				_fila = data.data[i];

				var _clases = [], _txtClases = '', _cls = [], _ico = '<span class="fa fa-bookmark-o " ></span>';
				if( _fila.clases != null || _fila.clases != undefined ){
					for (var c = 0; c < _fila.clases.length; c++) {
						_clases = _fila.clases[c];
						_cls.push( _clases.name );
					};
					_txtClases = _cls.join(', ');
				}

				if( _fila.chr_Destacado == 1 ){
					_ico = '<span class="fa fa-bookmark " ></span>';
				}
				_html += '<tr>';
					_html += '<td>'+_fila.int_IdProducto+'</td>';
					_html += '<td>'+_ico+'</td>';
					_html += '<td><a href="editar-producto.php?idp='+_fila.int_IdProducto+'" ><span class="fa fa-barcode" ></span> '+_fila.producto+'</a></td>';
					var _arPrecio = _fila.arPrecio, _textoAr = [];
					_textoAr = _arPrecio.split(',');
					_html += '<td class="text-right" >'+_textoAr[0]+'</td>';
					_html += '<td>'+_txtClases+'</td>';
					_html += '<td>'+_fila.generico+'</td>';
					_html += '<td>'+_fila.estado+'</td>';
				_html += '</tr>';
			};
			//console.log( data.data[i] );
			$('#ItemsResponse tbody').html( _html );
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

