
var _servicio = '../php/servicios/proc-pedidos.php';
var _idPedidoX = 0, _docGenerate = '', _serieUsar = '';

(function($){
	
	function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }

	$(document).ready(function(){
		/* -------------------------------------- */
		$('[data-toggle="tooltip"]').tooltip();
		/* -------------------------------------- */
		$(document).delegate('.anularPedido', 'click', function(event) {
			/**/
			var _idPedido = $(this).attr('href');
			alertify.confirm('Confirme anular Pedido',function(e){
				if(e){
					$.post( _servicio , {f:'delPedido',idp:_idPedido} , function(data, textStatus, xhr) {
						$('#Estado_'+_idPedido).html('DEL');
						$('#Fila_'+_idPedido).removeClass().addClass('danger');
						alertify.error('Pedido Anulado');
					},'json');
				}
			});
			event.preventDefault();
			/**/
		});
		/* -------------------------------------- */
		$(document).delegate('.copiarPedido', 'click', function(event) {
			/**/
			var _idPedido = $(this).attr('href');
			var _from = $('#idUsuarioZiel').val();
			//
			alertify.confirm('Confirme copiar Pedido de venta #'+_idPedido,function(e){
				if(e){
					$('#CopiarModal').modal('show');
					$.post( _servicio , {f:'copy',idp:_idPedido, from: _from} , function(data, textStatus, xhr) {
						$('#CopiarModal').modal('hide');
						document.location.reload();
					},'json');
				}
			});
			event.preventDefault();
			/**/
		});
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
			$.post( _servicio , _data , function(data, textStatus, xhr) {
				console.log(data);
				if( data.error == '' ){
					$('#idPedido').val( data.idPedido );
					$('#labelidPedido').html( 'Pedido #'+data.idPedido );
					$('#labelPedido').html( '#'+data.idPedido );
					$('#ModalPedido').modal('show');
					$('#closeModal').focus();
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
			_idPedidoX 		= $(this).attr('href');
			//
			$('#facturarModal').modal('show');
			event.preventDefault();
		});
		/* -------------------------------------- */
		$('#btnGoFacturar').click(function(event) {
			var _filtro = '';
			_docGenerate 	= $('#Documento').val();
			_serieUsar 		= $('#Correlativo').val();
			_filtro = 'goBoleta';
			/**/
			$.post( _servicio , { f:_filtro, idp:_idPedidoX, 'TipoDoc':_docGenerate, serie:_serieUsar} , function(data, textStatus, xhr) {
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

