
var _servicio = '../php/servicios/proc-ventas.php';
var _servicioK = '../php/servicios/proc-kardex.php';

(function($){
	
	function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }

    $( "#txtFecha" ).datepicker();

	$( "#txtProducto" ).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../php/servicios/get_prods.php",
				dataType: "json",
				data: {
				q: request.term
				},
				success: function( data ) {
					response( data );
				}
			});
		},
		autoFocus: true,
		minLength: 2,
		search: function( event, ui ) {
			$('#containerProducto').removeClass().addClass('form-group');
			$('#idProd').val('0');
			$('#idUM').val('0');
			$('#txtPrecio').val( '0' );
		},
		select: function( event, ui ) {
			log( ui.item ?
		  "Selected: " + ui.item.label :
		  "Nothing selected, input was " + this.value);
			//
			$('#idProd').val( ui.item.id );
			$('#idUM').val( ui.item.um );
			$('#txtPrecio').val( ui.item.prec );
			$('#containerProducto').removeClass().addClass('form-group').addClass('has-success');
			$('#txtCantidad').focus();
		},
		open: function() {
			$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
    });

	$(document).ready(function(){
		/* -------------------------------------- */
		$('[data-toggle="tooltip"]').tooltip();
		/* -------------------------------------- */
		$('#addNuevoItem').click(function(event) {
			resetAddItems();
			$('#editorProducto').fadeIn('fast');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#cerrarProd').click(function(event) {
			resetAddItems();
			$('#editorProducto').fadeOut('fast');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#CerrarVenta').click(function(event) {
			if( confirm('Confirme cerrar esta venta y mover el stock de productos') ){
				var _idv = $('#idVenta').val();
				$.post( _servicioK , { f :'menosKardex',idv:_idv} , function(data, textStatus, xhr) {
					/*optional stuff to do after success */
					//document.location.reload();
					$.notify("Venta Cerrada","success");
				},'json');
			}
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
		$('#SaveVenta').click(function(event) {
			/* Act on the event */
			var _data = $('#frmData').serialize();
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				console.log(data);
				if( data.error == '' ){
					$('#labelid').html( 'Venta #'+data.idPedido );
					$('#labelPopup').html( '#'+data.idPedido );
					//$('#ModalPedido').modal('show');
					//$('#closeModal').focus();
				}
				$.notify("Venta guardada","success");
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
		$('.jChosen').chosen({width: "100%"});
		/* -------------------------------------- */
		$('#addProducto').click(function(event) {
			$(this).attr({'disabled':'disabled'});
			//
			var _idp = $('#idProd').val(), _idum = $('#idUM').val(), _cant = $('#txtCantidad').val(), _idpedido = $('#idPedido').val();
			var _precio = $('#txtPrecio').val(), _tag = $('#tag').val(), _total = $('#txtTotal').val(), _iddetalle = $('#idItem').val();
			var _data = {f:'addItem',idp:_idp,idum:_idum,cant:_cant,precio:_precio,tag:_tag,total:_total, idItem:_iddetalle,idpedido:_idpedido};
			//
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				
				$('#addProducto').removeAttr('disabled');
				loadTablita(data);
				resetAddItems();
				$('#txtProducto').focus();
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#txtPrecio').keyup(function(event) {
			var _cant = $('#txtCantidad').val(), _precio = $(this).val();
			var _total = _cant * _precio;
			$('#txtTotal').val(_total);
		});
		/* -------------------------------------- */
		$('#txtCantidad').keyup(function(event) {
			var _cant = $(this).val(), _precio = $('#txtPrecio').val();
			var _total = _cant * _precio;
			$('#txtTotal').val(_total);
		});
		/* -------------------------------------- */
		$(document).delegate('.quitarProd', 'click', function(event) {
			var _Nombre = $(this).attr('rel');
			if( confirm('Confirme quitar Item: '+_Nombre) ){
				//
			}
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.ItemLista', 'click', function(event) {
			var _idp = $(this).attr('href');
			$.post( _servicio , { f:'getItem', idp:_idp } , function(data, textStatus, xhr) {
				LoadItem( data );
			},'json');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.quitarProd', 'click', function(event) {
			event.preventDefault();
		});
		/* -------------------------------------- */
		$(document).delegate('.goPedido', 'click', function(event) {
			var _idp = $(this).attr('href');
			$('#myModal').modal('show');
			event.preventDefault();
		});
		/* -------------------------------------- */
	});

})(jQuery);

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

function resetAddItems(){
	$('#containerProducto').removeClass().addClass('form-group');
	$('#idProd').val('0');
	$('#idUM').val('0');
	$('#txtPrecio').val( '0' );
	$('#txtCantidad').val( '' );
	$('#txtTotal').val( '0' );
	$("#txtProducto").val('');
	$("#idItem").val('0');
}


function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++) {
			_fila = json.data[i];

			_html += '<tr>';
				_html += '<td>';
					_html += '<a href="'+_fila.int_IdDetallePedido+'" class="ItemLista" >'+_fila.var_Nombre+' x '+_fila.unidadMedida+'</a>';
				_html += '</td>';
				_html += '<td class="text-right" >'+_fila.int_Cantidad+'</td>';
				_html += '<td class="text-right" >S/. '+_fila.flt_Precio+'</td>';
				_total = _total + parseFloat(_fila.flt_Total);
				_html += '<td class="text-right" >'+_fila.flt_Total+'</td>';
				_html += '<td>';
					_html += '<a href="#" class="pull-right quitarProd" rel="" ><span class="glyphicon glyphicon-remove" ></span></a>';
				_html += '</td>';
		};
		$('#TotalPedido').val( _total );
		$('#LabelTotal').html('Total de Pedido: '+_total);
		$('#Tablita tbody').html( _html );
	}
}



