var _servicio = '../php/servicios/proc-inventario.php';

(function($){
	
	/* -------------------------------------- */
	var _cboProd = [];

	var template = Handlebars.compile($("#result-template").html());
	var empty = Handlebars.compile($("#empty-template").html());
	/* -------------------------------------- */

	$(document).ready(function() {
		/* -------------------------------------- */
		$(document).delegate('.itemProd', 'click', function(event) {
			var _nombre = $(this).attr('title');
			var _id = $(this).attr('rel')
			alertify.prompt("Cantidad para: "+_nombre, function (e, str) {
			    // str is the input text
			    if (e) {
			    	if( isNaN(str) ){
			    		alertify.error('El valor no es número');
			    	}else{
			    		$.post( _servicio , {f:'update_cant', id: _id, cant: str} , function(data, textStatus, xhr) {
			    			$('#Cant_'+_id).html( str );
			    			alertify.success('Cantidad modificada');
			    		});
			    	}
			        //
			    } else {
			        // user clicked "cancel"
			    }
			}, "0");
			event.preventDefault();
		});
		/* -------------------------------------- */
		/* Mostrando los contenedores. */
		switch(_tipoInv){
            case 'Almacen':
                $('#wrapper_Almacen').show();
                $('#wrapper_Clases').hide();
            break;
            case 'Clases':
                $('#wrapper_Clases').show();
                $('#wrapper_Almacen').hide();
            break;
        }
		/* -------------------------------------- */
		var bestPictures = new Bloodhound({
			identify: function(o) { return o.id_str; },
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('label'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			dupDetector: function(a, b) { return a.id_str === b.id_str; },
			prefetch: '../php/servicios/prefetch_prods.php',
			remote: {
				url: '../php/servicios/get_prods.php?q=%QUERY',
				wildcard: '%QUERY'
			}
		});

		// ensure default users are read on initialization
		bestPictures.get(1,2)

		function engineWithDefaults(q, sync, async) {
			if (q === '') {
				sync(bestPictures.get(1,2));
				async([]);
			}else{
			  	bestPictures.search(q, sync, async);
			}
		}
		//Buscador
		$('#txtProducto').typeahead({
			hint: $('.Typeahead-hint'),
    		menu: $('.Typeahead-menu'),
			minLength: 2,
			classNames: {
				open: 'menu-lista-th',
				//empty: 'is-empty',
				//cursor: 'is-active',
				//suggestion: 'Typeahead-suggestion',
				//selectable: 'Typeahead-selectable'
			}
		},{
			displayKey: 'label',
  			display: 'label',
			source: engineWithDefaults,
			templates: {
			    empty: empty,
			    suggestion: template
			},
		});
		$('#txtProducto').bind('typeahead:select', function(ev, suggestion) {
		  //console.log(suggestion);
		  $('#idProd').val(suggestion.id);
		  $('#UnidadMedida').val(suggestion.idum);
		  $('#txtCantidad').focus();
		});
		/* -------------------------------------- */
		$('#txtFecha').datepicker({
			format: 'dd/mm/yyyy',
			startDate: '-3d',
			language : 'es',
			startView : 'day'
		});
		/* -------------------------------------- */
		$.post( _servicio , {f:'get_almacenes'} , function(data, textStatus, xhr) {
			cargarAlmacenes(data);
		},'json');
		/* -------------------------------------- */
		$.post( _servicio , {f:'get_clases'} , function(data, textStatus, xhr) {
			cargarClases(data);
		},'json');
		/* -------------------------------------- */
		$('.comboLindo').selectize();
		/* -------------------------------------- */
		$('#tipoInv').change(function(event) {
			var _Valor = $(this).val();
			switch(_Valor){
				case 'Total':
					$('#wrapper_Almacen').hide();
					$('#wrapper_Clases').hide();
				break;
				case 'Almacen':
					$('#wrapper_Almacen').show();
					$('#wrapper_Clases').hide();
				break;
				case 'Clases':
					$('#wrapper_Clases').show();
					$('#wrapper_Almacen').hide();
				break;
			}
		});
		/* -------------------------------------- */
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
		$(document).delegate('.quitarProd', 'click', function(event) {
			var _item = $(this).attr('rel');
			var _idinv = $('#idInventario').val();
			//
			if(confirm('Confirme anular Item')){
				$.post( _servicio , {f:'delItem',item:_item,idInv:_idinv} , function(data, textStatus, xhr) {
					loadTablita(data);
				},'json');
			}
			//
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#addNuevoItem').click(function(event) {
			resetAddItems();
			$('#editorProducto').fadeIn('fast');
			$('#txtProducto').focus();
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#cerrarProd').click(function(event) {
			resetAddItems();
			$('#editorProducto').fadeOut('fast');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#txtCantidad').keypress(function(event) {
			if( event.keyCode == 13 ){
				$('#addProducto').focus();
			}
		});
		/* -------------------------------------- */
		$('#addProducto').click(function(event) {
			var _data = $('#frmItems').serialize();
			$.post(_servicio , _data , function(data, textStatus, xhr) {
				resetAddItems();
				loadTablita(data);
				$('#txtProducto').focus();
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#SaveInventario').click(function(event) {
			var _data = $('#Formulario').serialize();
			var _nombre = $('#txtNombre').val(), _fecha = $('#txtFecha').val();
			if( _fecha == '' ){
				alertify.error('Ingrese Fecha.');
			}else{
				$.post( _servicio , _data , function(data, textStatus, xhr) {
					if( data.idi > 0 ){
						alertify.success('Inventario Guardado Correctamente.');
						$('#idInventario').val( data.idi );
						$('#idInv').val( data.idi );
						$('#GenerateInventario').show();
						//loadTablita(data);
						document.location.href = 'nuevo-inventario.php?id='+data.idi;
					}
				},'json');
			}
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#GenerateInventario').click(function(event) {
			var _idInventario = $('#idInventario').val();
			$.post(_servicio , {f:'goInventario', idInv:_idInventario} , function(data, textStatus, xhr) {
				if(data.idk != undefined){
					if(data.idk > 0){
						alertify.success('Inventario Generado correctamente.');
						document.location.reload();
					}
				}
					
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#frmBuscar').submit(function(event) {
			/* Buscar producto dentro de la lista */
			var _query = $('#txtBuscar').val();
			var _idInventario = $('#idInventario').val();
			$.post( _servicio , {f:'buscar',q: _query, id:_idInventario} , function(data, textStatus, xhr) {
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
	});

})(jQuery);

function cargarClases( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '<option value="-1" >Seleccione</option>', _total = 0;
		var _sel = '';

		for (var i = 0; i < json.data.length; i++){
			_fila = json.data[i];
			if( _tipoInv == 'Clases' ){
				if( _valorCOmbo == _fila.int_IdAuto ){
					_sel = 'selected="selected"';
				}else{
					_sel = '';
				}
			}
			_html += '<option value="'+_fila.int_IdAuto+'" '+_sel+' >'+_fila.var_Nombre+'</option>';
		};
		$('#valorClases').html( _html );
		$('#valorClases').selectize();
	}
}

function cargarAlmacenes( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '<option value="-1" >Seleccione</option>', _total = 0;
		var _sel = '';

		for (var i = 0; i < json.data.length; i++){
			_fila = json.data[i];
			if( _tipoInv == 'Almacen' ){
				if( _valorCOmbo == _fila.int_IdAlmacen ){
					_sel = 'selected="selected"';
				}else{
					_sel = '';
				}
				console.log(_sel);
			}
			_html += '<option value="'+_fila.int_IdAlmacen+'" '+_sel+' >'+_fila.var_Nombre+'</option>';
		};
		
		$('#valorAlmacen').html( _html );
		$('#valorAlmacen').selectize();
	}
}

function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++){
			_fila = json.data[i];

			_html += '<tr>';
				_html += '<td>';
					_html += '<span class="fa fa-barcode" ></span> '+_fila.var_Nombre+'';
				_html += '</td>';
				_html += '<td>'+_fila.unidadMedida+'</td>';
				_html += '<td class="text-right" >'+_fila.int_Cant+'</td>';
				
				_html += '<td>';
					_html += '<a href="#" class="pull-right quitarProd" rel="'+_fila.int_IdDetalleInv+'" ><span class="glyphicon glyphicon-remove" ></span></a>';
				_html += '</td>';
		};
		$('#tblDetalle tbody').html( _html );
	}
}

function load_resultados_busqueda( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++){
			_fila = json.data[i];

			_html += '<tr>';
				_html += '<td>';
					_html += '<span class="fa fa-barcode" ></span> '+_fila.var_Nombre+'';
				_html += '</td>';
				_html += '<td class="text-right" >'+_fila.unidadMedida+'</td>';
				_html += '<td class="text-right" >'+_fila.int_Cant+'</td>';
		};
		$('#tblResultados tbody').html( _html );
	}
}


function resetAddItems(){
	$('#containerProducto').removeClass().addClass('form-group');
	$("#idItem").val('0');
	$('#UnidadMedida').val('0');
	$('#idProd').val('0');
	$('#txtCantidad').val( '' );
	$("#txtProducto").val('');
	
}
/* ---------------------------------------------------------- */
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