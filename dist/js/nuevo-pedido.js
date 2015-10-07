var _servicio = '../php/servicios/proc-pedidos.php';
var _idPedidoX = 0, _docGenerate = '', _serieUsar = '';

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
		_cboCLiente = $('#cboCliente').selectize({
			options: _json_clientes,
			labelField: 'texto',
    		valueField: 'id',
		});
		if( _idCliente > 0 ){
			_cboCLiente[0].selectize.setValue(_idCliente);
		}else{
			_cboCLiente[0].selectize.setValue("1");
		}
		/* -------------------------------------- */
		$('#txtVence').datepicker({
			format: 'dd/mm/yyyy',
			startDate: '-3d',
			language : 'es',
			startView : 'year'
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
			var _data = $('#frmData').serialize();
			var $btn = $(this).button('loading')
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				if( data.error == '' ){
					$('#idPedido').val( data.idPedido );
					_idPedidoX = data.idPedido;
					$('#labelidPedido').html( 'Pre venta #'+data.idPedido );
					$('#labelPedido').html( '#'+data.idPedido );
					alertify.alert('Pre venta generado #'+data.idPedido,function(){
						document.location.href = 'nuevo-pedido.php?idpedido='+data.idPedido;
					});
					$('#panelFacturar').show();
				}
				$btn.button('reset');
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
		//$('.jChosen').chosen({width: "100%"});
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
				alertify.success('Producto agregado');
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
			var _Nombre = $(this).attr('rel'), _idd = $(this).attr('href');
			alertify.confirm('Confirme quitar Item: '+_Nombre,function(e){
				if(e){
					$.post( _servicio , {f:'delItem',idItem:_idd,'idp':_idPedido} , function(data, textStatus, xhr) {
						$('#Fila_'+_idd).hide('slow');
						loadTablita(data);
						alertify.error('Producto quitado.');
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
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#btnGoFacturar').click(function(event) {
			var _filtro = '';
			_docGenerate 	= $('#Documento').val();
			_serieUsar 		= $('#Correlativo').val();
			var _idPedido 	= $('#idPedido').val();
			_filtro = 'goBoleta';
			/**/
			$.post( _servicio , { f:_filtro, idp:_idPedido, 'TipoDoc':_docGenerate, serie:_serieUsar} , function(data, textStatus, xhr) {
				if( data.idVenta > 0 ){
					switch(_docGenerate){
						case 'B':
							document.location.href = 'nueva-boleta.php?id='+data.idVenta;
						break;
						case 'F':
							document.location.href = 'nueva-factura.php?id='+data.idVenta;
						break;
						case 'R':
							document.location.href = 'nuevo-recibo.php?id='+data.idVenta;
						break;
					}
				}
			},'json');
			/**/
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
			//$('#txtProducto').val( _item.var_Nombre+' x '+_item.unidadMedida );
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
	//$("#txtProducto").val('');
	$("#idItem").val('0');
}


function loadTablita( json ){
	if( json.data != undefined || json.data != null ){

		var  _fila = [], _html = '', _total = 0;

		for (var i = 0; i < json.data.length; i++) {
			_fila = json.data[i];

			_html += '<tr id="Fila_'+_fila.int_IdDetallePedido+'" >';
				_html += '<td>';
					_html += '<span class="fa fa-barcode" ></span> '+_fila.prod+' x '+_fila.um+'';
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

				_html += '<td class="text-right" >'+_fila.cant+'</td>';
				
				_total = _total + parseFloat(_fila.flt_Total);
				_html += '<td class="text-right" >'+_fila.flt_Total+'</td>';
				_html += '<td>';
					_html += '<a href="'+_fila.int_IdDetallePedido+'" class="pull-right quitarProd" rel="'+_fila.prod+'" ><span class="glyphicon glyphicon-remove" ></span></a>';
				_html += '</td>';
		};
		$('#TotalPedido').val( _total );
		$('#LabelTotal').html('Total Pre venta: '+_total);
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
