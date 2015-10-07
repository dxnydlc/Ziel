var _pc = 0, _pv = 0, _ut = 0;
var _servicio = '../php/servicios/proc-orden-compra.php';

(function($){

	var _cboProd = [];

var template = Handlebars.compile($("#result-template").html());
var empty = Handlebars.compile($("#empty-template").html());

	$(document).ready(function(){
		/* -------------------------------------- */
		var bestPictures = new Bloodhound({
			identify: function(o) { return o.id_str; },
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('label'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			dupDetector: function(a, b) { return a.id_str === b.id_str; },
			//prefetch: '../php/servicios/prefetch_prods.php',
			remote: {
				url: '../php/servicios/get_prods.php?q=%QUERY',
				wildcard: '%QUERY'
			}
		});

		// ensure default users are read on initialization
		bestPictures.get('crest')

		function engineWithDefaults(q, sync, async) {
			if (q === '') {
				sync(bestPictures.get('crest'));
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
		  $('#idUM').val(suggestion.idum);
		  $('#txtPrecio').val(suggestion.comp);
		  $('#txtVenta').val(suggestion.prec);
		  calcularUT( 1 , suggestion.comp , suggestion.prec );
		  $('#txtCantidad').focus();
		});
		/* -------------------------------------- */
		$('#txtPrecio').keyup(function(event) {
			var _cant = $('#txtCantidad').val(), _precio = $(this).val();
			var _total = _cant * _precio;
			$('#txtTotal').val(_total);
			//
			_pc = $('#txtPrecio').val();
			_pv = $('#txtVenta').val();
			calcularUT( 1 , _pc , _pv );
		});
		/* -------------------------------------- */
		$('#txtVenta').keyup(function(event) {
			_pc = $('#txtPrecio').val();
			_pv = $('#txtVenta').val();
			calcularUT( 1 , _pc , _pv );
		});
		/* -------------------------------------- */
		$('#cboCliente').selectize();
		/* -------------------------------------- */
		$('#txtFecha').datepicker({
			format: 'dd/mm/yyyy',
			startDate: '-3d',
			language : 'es',
			startView : 'day'
		});
		/* -------------------------------------- */
		$('[data-toggle="tooltip"]').tooltip();
		/* -------------------------------------- */
		$(document).delegate('.copiarPedido', 'click', function(event) {
			/**/
			var _idPedido = $(this).attr('href');
			$('#CopiarModal').modal('show');
			$.post( _servicio , {f:'copy',idp:_idPedido} , function(data, textStatus, xhr) {
				$('#CopiarModal').modal('hide');
				document.location.reload();
			},'json');
			event.preventDefault();
			/**/
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
			/* Act on the event */
			if( event.keyCode == 13 ){
				$('#addProducto').focus();
			}
		});
		/* -------------------------------------- */
		$('#SavePedido').click(function(event) {
			/* Act on the event */
			var $btn = $(this).button('loading');
			var _data = $('#frmData').serialize();
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				console.log( data.idOC);
				if( data.error == '' ){
					$('#labelidPedido').html( 'Pedido #'+data.idOC );
					$('#labelPedido').html( '#'+data.idOC );
					$('#idOC').val( data.idOC );
					alertify.alert('Orden compra generado #'+data.idOC,function(){
						document.location.href = 'nueva-orden-compra.php?idoc='+data.idOC;
					});
					$btn.button('reset');
				}
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#NuevoItem').click(function(event) {
			/* Act on the event */
			$('#myModal').modal('show');
			$('#myModalLabel').html('Nuevo Pedido');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#addProducto').click(function(event) {
			$(this).attr({'disabled':'disabled'});
			//
			var _form = $('#frmItem').serializeArray();
			var  _tag = $('#tag').val(), _idpedido = $('#idOC').val();
			_form.push({name:'tag',value: _tag });
			_form.push({name:'idpedido', value: _idpedido});
			_form.push({name:'f', value: 'addItem'});
			//
			var _idp = $('#idProd').val(), _idum = $('#idUM').val(), _cant = $('#txtCantidad').val();
			var _precio = $('#txtPrecio').val(), _total = $('#txtTotal').val(), _iddetalle = $('#idItem').val();
			var _data = {f:'addItem',idp:_idp,idum:_idum,cant:_cant,precio:_precio,tag:_tag,total:_total, idItem:_iddetalle,idpedido:_idpedido};
			//
			$.post( _servicio , _form , function(data, textStatus, xhr) {
				$('#addProducto').removeAttr('disabled');
				loadTablita(data);
				resetAddItems();
				$('#txtProducto').focus();
				alertify.success('Producto agregado');
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#txtCantidad').keyup(function(event) {
			var _cant = $(this).val(), _precio = $('#txtPrecio').val();
			var _total = _cant * _precio;
			$('#txtTotal').val(_total);
		});
		/* -------------------------------------- */
		$(document).delegate('.quitarProd', 'click', function(event) {
			/*
			Quitar un item de la lista y volver a dibujar la tabla.
			*/
			var _Nombre = $(this).attr('rel'), _idd = $(this).attr('href');
			alertify.confirm('Confirme quitar Item: '+_Nombre,function(e){
				if( e ){
					$('#Fila_'+_idd).hide();
					$.post( _servicio , {f:'delItem',idItem:_idd,'idp':_idPedido} , function(data, textStatus, xhr) {
						loadTablita(data);
					},'json');
				}
			});
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.ItemLista', 'click', function(event) {
			/*
			Agregar un item de la lista y volver a dibujar la tabla.
			*/
			var _idp = $(this).attr('href');
			$.post( _servicio , { f:'getItem', idp:_idp } , function(data, textStatus, xhr) {
				LoadItem( data );
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.goPedido', 'click', function(event) {
			var _idp = $(this).attr('href');
			$('#myModal').modal('show');
			/*
			$.post( _servicio , { f:'goBoleta', idp:_idp } , function(data, textStatus, xhr) {
				console.log( data );
			},'json');
			/**/
			event.preventDefault();
		});
		/* -------------------------------------- */
	});

})(jQuery);
/* ---------------------------------------------------------- */
function LoadItem( json ){
	if( json.data != undefined || json.data != null ){

		var _html = '', _item = [];
		for (var i = 0; i < json.data.length; i++) {
			_item = json.data[0];
			$('#txtCantidad').val( _item.int_Cantidad );
			$('#txtProducto').val( _item.var_Nombre+' x '+_item.unidadMedida );
			$('#txtPrecio').val( _item.flt_Precio );
			$('#txtTotal').val( _item.flt_Total );
			//
			$('#idProd').val( _item.int_IdProducto );
			$('#idUM').val( _item.int_IdUnidadMedida );
			$('#idItem').val( _item.int_IdDetallePedido );
			$('#editorProducto').fadeIn('fast');
		};

	}
}
/* ---------------------------------------------------------- */
function resetAddItems(){
	$('#containerProducto').removeClass().addClass('form-group');
	$('#idProd').val('0');
	$('#idUM').val('0');
	$('#txtPrecio').val( '0' );
	$('#txtVenta').val( '0' );
	$('#txtCantidad').val( '' );
	$('#txtTotal').val( '0' );
	$("#txtProducto").val('');
	$("#idItem").val('0');
}
/* ---------------------------------------------------------- */
function calcularUT( _tag , _elpc , _elpv ){
	if( !isNaN( _elpv ) && !isNaN( _elpc ) ){
		var _lauti = (( _elpc / _elpv ) - 1 ) * 100;
		_lauti = _lauti * -1;
		if( !isNaN(_lauti) ){
			_lauti = parseInt(_lauti), _out = 0;
		}
		$('#txtUtilidad').val( _lauti );
		$('#lblVenta').html('Precio Venta ,Utilidad '+_lauti+'%');
	}
}
/* ---------------------------------------------------------- */
function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++) {
			_fila = json.data[i];

			_html += '<tr id="Fila_'+_fila.int_IdDetalleOC+'" >';
				_html += '<td>';
					_html += _fila.var_Nombre+' x '+_fila.unidadMedida;
				_html += '</td>';
				_html += '<td class="text-right" >'+_fila.int_Cantidad+'</td>';
				_html += '<td class="text-right" >S/. '+_fila.flt_Precio_Compra+'</td>';
				_html += '<td class="text-right" >S/. '+_fila.ftl_Precio_Venta+'</td>';
				_html += '<td class="text-right" >'+_fila.flt_Utilidad+'%</td>';
				_total = _total + parseFloat(_fila.flt_Total);
				_html += '<td class="text-right" >'+_fila.flt_Total+'</td>';
				_html += '<td>';
					_html += '<a href="'+_fila.int_IdDetalleOC+'" class="pull-right quitarProd" rel="'+_fila.var_Nombre+'" ><span class="glyphicon glyphicon-remove" ></span></a>';
				_html += '</td>';
			_html += '</tr>';
		};
		$('#TotalPedido').val( _total );
		$('#LabelTotal').html('Total de Pedido: '+_total);
		$('#Tablita tbody').html( _html );
	}
}
/* ---------------------------------------------------------- */


