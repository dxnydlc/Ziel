var _servicio = '../php/servicios/proc-nueva-factura.php';
var _servicioK = '../php/servicios/proc-kardex.php';

(function($){

var _cboProd = [];

var template = Handlebars.compile($("#result-template").html());
var empty = Handlebars.compile($("#empty-template").html());

	$(document).ready(function(){
		/* -------------------------------------- */
		$('#txtProducto').autoComplete({
			source: function(term, response){
		        $.post('../php/servicios/get_prods_lotes.php', { q: term }, function(data){ response(data); },'json');
		    },
			renderItem: function (item, search){
				var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
				var _html = '';
				_html += '<div class="autocomplete-suggestion" data-prodi="'+item[0]+'" data-lote="'+item[1]+'" data-val="'+search+'" data-idprod="'+item[5]+'" data-idum="'+item[6]+'" data-precio="'+item[4]+'" data-idlote="'+item[7]+'" >';
					_html += item[0].replace(re, "<b>$1</b>")+' Precio <strong>S/. '+item[4]+'</strong>, Stock: '+item[2]+', Lote: '+item[1]+', Vence: '+item[3];
				_html += '</div>';
				return _html;
			},
			onSelect: function(e, term, item){
				$('#idProd').val( item.data('idprod') );
				$('#idUM').val( item.data('idum') );
				$('#txtPrecio').val( item.data('precio') );
				$('#txtProducto').val( item.data('prodi') );
				$('#idLote').val( item.data('idlote') );
				$('#txtCantidad').focus();
				//alert('Item "'+item.data('prodi')+' Lote: '+item.data('lote')+' " selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
				e.preventDefault();
			}
		});
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
		$('#CerrarVenta').click(function(event) {
			alertify.confirm("Confirme cerrar esta Factura y mover el stock de productos",function(e){
				if(e){
					var _idv = $('#idVenta').val();
					$.post( _servicioK , { f :'menosKardex',idv:_idv, idu: _idu} , function(data, textStatus, xhr) {
						alertify.success("Factura Cerrada");
						$('#wrapper_addProd').hide('slow');
            			$('#wrapper_guardar').hide('slow');
            			$('#wrapper_cerrar').hide('slow');
					},'json');
				}
			});
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
			/* Guardar venta */
			var _data = $('#frmData').serializeArray();
			_data.push({name: 'Medio', value: $('#Medio').val() });
			_data.push({name: 'CantPago', value: $('#CantPago').val() });
			_data.push({name: 'Vuelto', value: $('#Vuelto').val() });
			_data.push({name: 'Obs', value: $('#Obs').val() });
			_data.push({name: 'serie', value: $('#Ser').val() });
			_data.push({name: 'corr', value: $('#Corr').val() });
			//
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				if( data.error == '' ){
					$('#labelid').html( 'Factura <span class="label label-success">'+data.serie+' - '+data.corr+'</span>');
					$('#labelPopup').html( '#'+data.idVenta );
					$('#idVenta').val(data.idVenta);
					$('#wrapper_cerrar').show();
					$('#wrapper_anular').show();
				}
				alertify.success("Factura Guardada");
				document.location.href = 'nueva-factura.php?id='+data.idVenta;
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
		$('.jChosen').selectize();
		/* -------------------------------------- */
		$('#addProducto').click(function(event) {
			$(this).attr({'disabled':'disabled'});
			//
			var _data = $('#frmEditor').serialize();
			//
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				
				$('#addProducto').removeAttr('disabled');
				loadTablita(data);
				resetAddItems();
				$('#txtProducto').val('');
				$('#txtProducto').focus();
				alertify.success("Producto Agregado");
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
			/*
			Quitar un item de la lista y volver a dibujar la tabla.
			*/
			var _Nombre = $(this).attr('rel'), _idd = $(this).attr('href'), _idVenta = $('#idVenta').val();
			alertify.confirm('Confirme quitar Item: '+_Nombre, function (e) {
			if (e) {
				$('#Fila_'+_idd).hide();
				$.post( _servicio , {f:'delItem',idItem:_idd,'idp':_idVenta} , function(data, textStatus, xhr) {
					loadTablita(data);
					alertify.error("Producto quitado correctamente.");
				},'json');
			}
			});
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
		$(document).delegate('.goPedido', 'click', function(event) {
			var _idp = $(this).attr('href');
			$('#myModal').modal('show');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#AnularVenta').click(function(event) {
			/* Anular venta */
			var _idv = $('#idVenta').val();
			alertify.prompt("Motivo por el que anula esta Boleta", function (e, str) {
				if (e) {
					$.post( _servicio , {f:'delBoleta',id:_idv, texto: str} , function(data, textStatus, xhr) {
						alertify.error('Factura Anulada');
            			document.location.reload();
					},'json');
				} else {
					// user clicked "cancel"
				}
			}, "");
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#CantPago').keyup(function(event) {
			var _total = parseFloat( $('#TotalVenta').val() ).toFixed(2);
			if( _total > 0 ){
				_total = parseFloat(_total).toFixed(2);
			}
			var _pago = parseFloat( $(this).val() ).toFixed(2);
			if( _total > 0 ){
				_total = parseFloat(_total).toFixed(2);
			}
			var _vuelto = 0;
			$('#msgPago').html('');
			console.log(_pago +' , '+_total);
			if( Number(_pago) < Number(_total) ){
				$('#msgPago').html('<div class="alert alert-danger" role="alert"><strong>Error</strong> El monto es menor al total.</div>');
				$('#Vuelto').val('0');
			}else{
				_vuelto = _pago - _total;
				_vuelto = parseFloat(_vuelto).toFixed(2);
				$('#Vuelto').val(_vuelto);
			}
		});
		/* -------------------------------------- */
		$('#Medio').change(function(event) {
			$('#Vuelto').val('0');
			$('#CantPago').val('0');
			$('#Obs').val('');
		});
		/* -------------------------------------- */
		$(document).keydown(function(tecla) {
			switch(tecla.keyCode){
				case 120://addItem
					$('#addNuevoItem').click();
				break;
				case 121://grabar
					$('#SaveVenta').click();
				break;
				case 119://grabar F8
					$('#Medio').focus();
				break;
			}
			//F10 = 121, F11 = 122
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
			$('#idItem').val( _item.int_IdDetalleVenta );
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

			_html += '<tr id="Fila_'+_fila.int_IdDetalleVenta+'" >';
				_html += '<td>';
					_html += '<span class="fa fa-barcode" ></span> '+_fila.var_Nombre+' x '+_fila.unidadMedida+'';
					if( _fila.int_IdPromo != null ){
						_html += '<br/><small>'+_fila.var_Promo+' antes ('+_fila.flt_Precio+')</small>';
					}
				_html += '</td>';
				_html += '<td>'+_fila.lote+'</td>';
				
				if( _fila.int_IdPromo != null ){
					_html += '<td class="text-right" >S/. '+_fila.flt_Promo+'</td>';
				}else{
					_html += '<td class="text-right" >S/. '+_fila.flt_Precio+'</td>';
				}
				_html += '<td class="text-right" >'+_fila.int_Cantidad+'</td>';
				_total = _total + parseFloat(_fila.flt_Total);
				_html += '<td class="text-right" >'+_fila.flt_Total+'</td>';
				_html += '<td>';
					_html += '<a href="'+_fila.int_IdDetalleVenta+'" class="pull-right quitarProd" rel="" ><span class="glyphicon glyphicon-remove" ></span></a>';
				_html += '</td>';
		};
		$('#TotalVenta').val( _total );
		$('#LabelTotal').html('Total de Venta: '+_total);
		$('#Tablita tbody').html( _html );
	}
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

